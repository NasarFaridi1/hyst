@extends('layouts.app')

@section('content')

<div class="p-10">

    <h1 class="text-4xl font-bold mb-6">

        Vendor Dashboard

    </h1>

    <div class="grid grid-cols-3 gap-6">

        <div class="bg-white shadow rounded-2xl p-8">

            <h2 class="text-2xl font-bold">

                Total Products

            </h2>

            <p class="text-4xl mt-4">

                {{ \App\Models\Product::where('vendor_id', auth()->id())->count() }}

            </p>

        </div>

    </div>

</div>

@endsection