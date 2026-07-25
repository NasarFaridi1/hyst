@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-10">

        <div>

            <h1 class="text-4xl font-bold">

                Order Details

            </h1>

            <p class="text-gray-500 mt-2">

                Order #{{ $order->id }}

            </p>

        </div>

        <a href="/admin/complaint"
        class="bg-black text-white px-6 py-3 rounded-xl">

            Back

        </a>

    </div>





    <div class="grid grid-cols-3 gap-8">

        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-5">

                Customer Info

            </h2>

            <p class="mb-3">

                <strong>Name:</strong>
                {{ $order->user->name ?? 'N/A' }}

            </p>

            <p class="mb-3">

                <strong>Email:</strong>
                {{ $order->user->email ?? 'N/A' }}

            </p>

        </div>





        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-5">

                Restaurant

            </h2>

            <p class="mb-3">

                <strong>Name:</strong>
                {{ $order->restaurant->name ?? 'N/A' }}

            </p>

        </div>



		
		<div class="bg-white rounded-2xl shadow p-8 mt-6">

    <h2 class="text-xl font-bold mb-5">
        Complaint Status
    </h2>

    @foreach($complaints as $complaint)

    <div class=" rounded-xl p-5 mb-4">

        <div class="flex justify-between items-center">

            <div>

                <h4 class="font-bold">
                    {{ $complaint->subject }}
                </h4>

                <p class="text-sm text-gray-500">
                    Complaint #{{ $complaint->id }}
                </p>

            </div>

            <div>

                @switch($complaint->status)

                    @case('open')
                        <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700">
                            Open
                        </span>
                    @break

                    @case('restaurant_replied')
                        <span class="px-4 py-2 rounded-full bg-orange-100 text-orange-700">
                            Restaurant Replied
                        </span>
                    @break

                    @case('admin_replied')
                        <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700">
                            Admin Replied
                        </span>
                    @break

                    @case('waiting_customer')
                        <span class="px-4 py-2 rounded-full bg-purple-100 text-purple-700">
                            Waiting Customer
                        </span>
                    @break

                    @case('waiting_restaurant')
                        <span class="px-4 py-2 rounded-full bg-indigo-100 text-indigo-700">
                            Waiting Restaurant
                        </span>
                    @break

                    @case('resolved')
                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-700">
                            Resolved
                        </span>
                    @break

                    @case('closed')
                        <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-700">
                            Closed
                        </span>
                    @break

                    @case('rejected')
                        <span class="px-4 py-2 rounded-full bg-red-100 text-red-700">
                            Rejected
                        </span>
                    @break

                @endswitch

            </div>

        </div>

        <form
            action="{{ route('admin.complaints.status',$complaint->id) }}"
            method="POST"
            class="mt-5">

            @csrf

            <div class="flex gap-3">

                <select
                    name="status"
                    class="border rounded-lg px-4 py-2 w-72">

                    <option value="open" {{ $complaint->status=='open'?'selected':'' }}>
                        Open
                    </option>

                    <option value="restaurant_replied" {{ $complaint->status=='restaurant_replied'?'selected':'' }}>
                        Restaurant Replied
                    </option>

                    <option value="admin_replied" {{ $complaint->status=='admin_replied'?'selected':'' }}>
                        Admin Replied
                    </option>

                    <option value="waiting_customer" {{ $complaint->status=='waiting_customer'?'selected':'' }}>
                        Waiting Customer
                    </option>

                    <option value="waiting_restaurant" {{ $complaint->status=='waiting_restaurant'?'selected':'' }}>
                        Waiting Restaurant
                    </option>

                    <option value="resolved" {{ $complaint->status=='resolved'?'selected':'' }}>
                        Resolved
                    </option>

                    <option value="closed" {{ $complaint->status=='closed'?'selected':'' }}>
                        Closed
                    </option>

                    <option value="rejected" {{ $complaint->status=='rejected'?'selected':'' }}>
                        Rejected
                    </option>

                </select>

                <button
                    class="bg-blue-600 text-white px-6 rounded-lg">

                    Update 

                </button>

            </div>

        </form>

    </div>

    @endforeach

</div>


        

    </div>

	
	<div class="grid grid-cols-12 gap-6 mt-8">



    {{-- Complaint Chat --}}

            <div class="col-span-12">

                



                @foreach($complaints as $complaint)



                <div class="bg-white rounded-2xl shadow p-6">

                        <h3 class="text-xl font-bold mb-4">

                            Complaint Chat

                            </h3>

                    <div class="flex justify-between items-center mb-4">



                        <div>

                            <h3 class="text-xl font-bold">

                                {{ $complaint->subject }}

                            </h3>



                            <p class="text-sm text-gray-500">

                                {{ $complaint->category }}

                            </p>

                        </div>



                        <span class="text-xs text-gray-500">

                            {{ $complaint->created_at->format('d M Y h:i A') }}

                        </span>



                    </div>



                    {{-- Chat Box --}}

                    <div class="bg-gray-50 rounded-xl p-5 h-[400px] overflow-y-auto border">



                        @foreach($complaint->messages as $message)



                            {{-- Customer --}}

                            @if($message->sender_type=='customer')



                                <div class="flex justify-start mb-4">



                                    <div class="bg-blue-100 rounded-2xl px-4 py-3 max-w-md shadow">



                                        <div class="font-semibold text-blue-700 mb-1">

                                            {{ $order->user->name ?? 'N/A' }}

                                        </div>



                                        {{ $message->message }}



                                        <div class="text-xs text-gray-500 mt-2">

                                            {{ $message->created_at->format('d M h:i A') }}

                                        </div>



                                    </div>



                                </div>



                            {{-- Restaurant --}}

                            @elseif($message->sender_type=='restaurant')



                                <div class="flex justify-end mb-4">



                                    <div class="bg-green-100 rounded-2xl px-4 py-3 max-w-md shadow">



                                        <div class="font-semibold text-green-700 mb-1">

                                            {{ $order->restaurant->name ?? 'N/A' }}

                                        </div>



                                        {{ $message->message }}



                                        <div class="text-xs text-gray-500 mt-2 text-right">

                                            {{ $message->created_at->format('d M h:i A') }}

                                        </div>



                                    </div>



                                </div>



                            {{-- Admin --}}

                            @elseif($message->sender_type=='admin')



                                <div class="flex justify-end mb-4">



                                    <div class="bg-orange-100 rounded-2xl px-4 py-3 max-w-md shadow">



                                        <div class="font-semibold text-orange-700 mb-1">

                                            you

                                        </div>



                                        {{ $message->message }}



                                        <div class="text-xs text-gray-500 mt-2 text-right">

                                            {{ $message->created_at->format('d M h:i A') }}

                                        </div>



                                    </div>



                                </div>



                            @endif



                        @endforeach



                    </div>



                    {{-- Reply Box --}}

                    <form action="{{ route('admin.complaints.reply',$complaint->id) }}"

                        method="POST"

                        class="mt-5">



                        @csrf



                        <textarea

                            name="message"

                            rows="3"

                            class="w-full border rounded-xl p-4 focus:ring-2 focus:ring-orange-400"

                            placeholder="Type your reply..."></textarea>



                        <button

                            class="mt-4 bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl">



                            Send Reply



                        </button>



                    </form>



                </div>



                @endforeach



            </div>



    

   



</div>
	
	
<div class="grid grid-cols-12 gap-6 mt-8">

    {{-- Customer Evidence --}}
    @if($customerEvidence)
    <div class="col-span-6">

        <div class="bg-white rounded-2xl shadow-lg border h-full overflow-hidden">

            <div class="bg-blue-50 border-b px-5 py-4">
                <h3 class="text-lg font-bold text-blue-700">
                    Customer Order Received Proof
                </h3>
            </div>

            <div class="p-5">

                <div class="overflow-hidden rounded-xl border bg-gray-100">
                    <img
                        src="{{ asset($customerEvidence->photo) }}"
                        class="w-full h-80 object-cover cursor-pointer"
                        onclick="window.open(this.src,'_blank')">
                </div>

                <div class="mt-5">
                    <h4 class="font-semibold text-gray-800 mb-2">
                        Description
                    </h4>

                    <div class="bg-gray-50 border rounded-xl p-4 text-gray-700 leading-7">
                        {{ $customerEvidence->description }}
                    </div>
                </div>

                <div class="mt-4 flex justify-between text-xs text-gray-500">
                    <span>{{ $order->user->name }}</span>

                    <span>
                        {{ $customerEvidence->created_at->format('d M Y h:i A') }}
                    </span>
                </div>

            </div>

        </div>

    </div>
    @endif


    {{-- Restaurant Evidence --}}
    @if($restaurantEvidence)
    <div class="col-span-6">

        <div class="bg-white rounded-2xl shadow-lg border h-full overflow-hidden">

            <div class="bg-green-50 border-b px-5 py-4">
                <h3 class="text-lg font-bold text-green-700">
                    Restaurant Completion Proof
                </h3>
            </div>

            <div class="p-5">

                <div class="overflow-hidden rounded-xl border bg-gray-100">
                    <img
                        src="{{ asset($restaurantEvidence->photo) }}"
                        class="w-full h-80 object-cover cursor-pointer"
                        onclick="window.open(this.src,'_blank')">
                </div>

                <div class="mt-5">
                    <h4 class="font-semibold text-gray-800 mb-2">
                        Description
                    </h4>

                    <div class="bg-gray-50 border rounded-xl p-4 text-gray-700 leading-7">
                        {{ $restaurantEvidence->description }}
                    </div>
                </div>

                <div class="mt-4 flex justify-between text-xs text-gray-500">
                    <span>{{ $order->restaurant->name }}</span>

                    <span>
                        {{ $restaurantEvidence->created_at->format('d M Y h:i A') }}
                    </span>
                </div>

            </div>

        </div>

    </div>
    @endif

</div>


    <div class="bg-white rounded-2xl shadow mt-10 overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-5 text-left">
                        Product
                    </th>

                    <th class="p-5 text-left">
                        Price
                    </th>

                    <th class="p-5 text-left">
                        Qty
                    </th>

                    <th class="p-5 text-left">
                        Total
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($order->items as $item)

                <tr class="border-t">

                    <td class="p-5">

                        {{ $item->product->name ?? '' }}

                    </td>

                    <td class="p-5">

                        £{{ $item->price }}

                    </td>

                    <td class="p-5">

                        {{ $item->quantity }}

                    </td>

                    <td class="p-5 font-bold">

                        £{{ $item->total }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>
        

    </div>

</div>

@endsection