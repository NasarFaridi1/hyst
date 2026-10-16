<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AiCampaignDispatcherService;
use Throwable;

class DispatchAiCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hyst:dispatch-ai-campaigns {--restaurant_id= : Optional restaurant ID to process specifically}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically dispatch targeted, margin-protected AI campaign notifications via HYST notification system (In-App & FCM Push) with 7-Day Fatigue Guard.';

    /**
     * Execute the console command.
     */
    public function handle(AiCampaignDispatcherService $dispatcher)
    {
        $this->info('Starting Automated AI Campaign Dispatcher...');

        $restaurantId = $this->option('restaurant_id');

        try {
            if ($restaurantId) {
                $this->info("Processing specific restaurant ID: {$restaurantId}");
                $result = $dispatcher->dispatchForRestaurant((int) $restaurantId);
                
                $this->line("Dispatched: <info>{$result['dispatched_count']}</info>");
                $this->line("Skipped (7-Day Fatigue Guard): <comment>{$result['skipped_fatigue_count']}</comment>");
                $this->info($result['message']);
            } else {
                $this->info("Processing all active restaurants across platform...");
                $result = $dispatcher->dispatchAll();

                $this->line("Restaurants Evaluated: <info>{$result['total_restaurants']}</info>");
                $this->line("Total Dispatched: <info>{$result['total_dispatched']}</info>");
                $this->line("Total Suppressed by Fatigue Guard: <comment>{$result['total_skipped_fatigue']}</comment>");
                $this->info('Completed automated AI campaign dispatch cycle.');
            }

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Failed to dispatch AI campaigns: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
