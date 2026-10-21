<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'video',
        'status',
        // SEO Meta
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        // Open Graph
        'og_title',
        'og_description',
        'og_image',
        // JSON-LD Schema
        'schema_headline',
        'schema_description',
        'schema_image',
        'schema_author',
        'schema_publisher',
        'schema_date_published',
        'schema_date_modified',
        'schema_custom_json',
    ];

    protected $casts = [
        'schema_date_published' => 'datetime',
        'schema_date_modified' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Get effective SEO Meta Title with fallback to blog title.
     */
    public function getEffectiveMetaTitleAttribute(): string
    {
        if (!empty($this->meta_title)) {
            return $this->meta_title;
        }

        $title = e($this->title ?? 'Food Guide');
        return mb_strlen($title) > 65 ? Str::limit($title, 62) . ' | HYST Blog' : $title . ' | HYST Blog';
    }

    /**
     * Get effective SEO Meta Description with fallback to stripped content excerpt.
     */
    public function getEffectiveMetaDescriptionAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }

        return Str::limit(strip_tags($this->description ?? 'Read our local Hounslow food guide on HYST.'), 155);
    }

    /**
     * Get effective Canonical URL.
     */
    public function getEffectiveCanonicalUrlAttribute(): string
    {
        if (!empty($this->canonical_url)) {
            return $this->canonical_url;
        }

        $baseUrl = rtrim(config('app.url', 'https://hyst.uk'), '/');
        return $baseUrl . '/blog/' . ($this->slug ?? $this->id);
    }

    /**
     * Get effective Open Graph Title.
     */
    public function getEffectiveOgTitleAttribute(): string
    {
        return !empty($this->og_title) ? $this->og_title : $this->effective_meta_title;
    }

    /**
     * Get effective Open Graph Description.
     */
    public function getEffectiveOgDescriptionAttribute(): string
    {
        return !empty($this->og_description) ? $this->og_description : $this->effective_meta_description;
    }

    /**
     * Get effective Open Graph Image URL.
     */
    public function getEffectiveOgImageAttribute(): string
    {
        if (!empty($this->og_image)) {
            return Str::startsWith($this->og_image, ['http://', 'https://']) ? $this->og_image : asset($this->og_image);
        }

        if (!empty($this->image)) {
            return Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : asset($this->image);
        }

        return rtrim(config('app.url', 'https://hyst.uk'), '/') . '/twitter.jpeg';
    }

    /**
     * Get effective Schema Image URL.
     */
    public function getEffectiveSchemaImageAttribute(): string
    {
        if (!empty($this->schema_image)) {
            return Str::startsWith($this->schema_image, ['http://', 'https://']) ? $this->schema_image : asset($this->schema_image);
        }

        return $this->effective_og_image;
    }

    /**
     * Build the structured JSON-LD BlogPosting schema.
     */
    public function toBlogPostingSchema(string $baseUrl, string $defaultImage): array
    {
        if (!empty($this->schema_custom_json)) {
            $custom = json_decode($this->schema_custom_json, true);
            if (is_array($custom)) {
                return $custom;
            }
        }

        $canonicalUrl = $this->effective_canonical_url;
        $headline = !empty($this->schema_headline) ? $this->schema_headline : ($this->title ?? 'HYST Blog');
        $desc = !empty($this->schema_description) ? $this->schema_description : $this->effective_meta_description;
        $image = $this->effective_schema_image;

        $datePublished = !empty($this->schema_date_published)
            ? $this->schema_date_published->toIso8601String()
            : (optional($this->created_at)->toIso8601String() ?? now()->toIso8601String());

        $dateModified = !empty($this->schema_date_modified)
            ? $this->schema_date_modified->toIso8601String()
            : (optional($this->updated_at)->toIso8601String() ?? $datePublished);

        $authorName = !empty($this->schema_author) ? $this->schema_author : 'HYST';
        $publisherName = !empty($this->schema_publisher) ? $this->schema_publisher : 'HYST';

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $canonicalUrl,
            ],
            'headline' => $headline,
            'description' => $desc,
            'image' => $image,
            'url' => $canonicalUrl,
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'author' => [
                '@type' => 'Organization',
                'name' => $authorName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $publisherName,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $defaultImage,
                ],
            ],
        ];
    }
}
