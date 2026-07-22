@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Coupons
        </h2>

        <a href="{{ route('restaurant.coupons.create') }}"
           class="inline-flex items-center px-4 py-2 bg-[#C25A2A] hover:bg-[#A54A1F] text-white rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>
            Add Coupon
        </a>
    </div>

    

    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-100">

                <tr>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">#</th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Code
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Title
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Type
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Value
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Minimum Order
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Usage
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Expiry
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Status
                    </th>

                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-gray-600">
                        Action
                    </th>

                </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">

                @forelse($coupons as $coupon)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 font-semibold text-indigo-600">
                            {{ $coupon->code }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $coupon->title }}
                        </td>

                        <td class="px-4 py-3">

                            @if($coupon->type=='percentage')
                                Percentage
                            @else
                                Fixed
                            @endif

                        </td>

                        <td class="px-4 py-3">

                            @if($coupon->type=='percentage')
                                {{ $coupon->value }}%
                            @else
                                £{{ number_format($coupon->value,2) }}
                            @endif

                        </td>

                        <td class="px-4 py-3">
                            £{{ number_format($coupon->min_order_amount,2) }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $coupon->used_count }}

                            @if($coupon->usage_limit)
                                / {{ $coupon->usage_limit }}
                            @else
                                / Unlimited
                            @endif
                        </td>

                        <td class="px-4 py-3">

                            @if($coupon->expires_at)
                                {{ $coupon->expires_at->format('d M Y') }}
                            @else
                                -
                            @endif

                        </td>

                        <td class="px-4 py-3">

                            @if($coupon->status)

                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                    Inactive
                                </span>

                            @endif

                        </td>

                        <td class="px-4 py-3">

                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('restaurant.coupons.edit',$coupon->id) }}"
                                   class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#C25A2A] text-white hover:bg-[#A54A1F]">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form action="{{ route('restaurant.coupons.destroy',$coupon->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Delete this coupon?')"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#C25A2A] text-white hover:bg-[#A54A1F]">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="10" class="px-4 py-10 text-center text-gray-500">

                            No coupons found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="border-t border-gray-200 px-6 py-4">
            {{ $coupons->links() }}
        </div>

    </div>

</div>

@endsection