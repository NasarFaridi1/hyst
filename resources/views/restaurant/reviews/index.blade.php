@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-4xl font-bold">

            Customer Reviews

        </h1>

    </div>

    <div class="grid gap-6">

        @foreach($reviews as $review)

            <div class="bg-white rounded-3xl shadow p-8">

                <div class="flex justify-between gap-6 flex-wrap">

                    <div>

                        <h2 class="text-2xl font-bold mb-3">

                            {{ $review->user->name ?? 'User' }}

                        </h2>

                        <div class="text-yellow-500 text-2xl mb-4">

                            @for($i=1; $i <= $review->rating; $i++)

                                ⭐

                            @endfor

                        </div>

                        <p class="text-gray-600 leading-8">

                            {{ $review->review }}

                        </p>

                    </div>

                    <div class="flex flex-col gap-3">

                        <div class="text-sm font-bold">

                            Status:
                            <span class="
                                @if($review->status == 'approved')
                                    text-green-600
                                @elseif($review->status == 'rejected')
                                    text-red-600
                                @else
                                    text-yellow-600
                                @endif
                            ">

                                {{ ucfirst($review->status) }}

                            </span>

                        </div>

                        @if($review->status == 'pending')

                            <form
                                method="POST"
                                action="/restaurant/reviews/{{ $review->id }}/approve">

                                @csrf

                                <button class="
                                    bg-green-500
                                    text-white
                                    px-5
                                    py-3
                                    rounded-xl
                                    w-full
                                ">

                                    Approve

                                </button>

                            </form>

                            <form
                                method="POST"
                                action="/restaurant/reviews/{{ $review->id }}/reject">

                                @csrf

                                <button class="
                                    bg-red-500
                                    text-white
                                    px-5
                                    py-3
                                    rounded-xl
                                    w-full
                                ">

                                    Reject

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection