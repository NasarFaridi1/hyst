@extends('layouts.app')
@section('content')
<div class="p-8">
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-2xl font-medium">Dashboard</h1>
      <p class="text-gray-500 text-sm mt-1">Super admin overview</p>
    </div>
  </div>

  <div class="grid grid-cols-4 gap-4 mb-8">
    @foreach([
      ['label'=>'Restaurants','value'=>$restaurants,'icon'=>'🍽️','bg'=>'bg-blue-50','text'=>'text-blue-600'],
      ['label'=>'Products','value'=>$products,'icon'=>'📦','bg'=>'bg-green-50','text'=>'text-green-600'],
      ['label'=>'Orders','value'=>$orders,'icon'=>'🛒','bg'=>'bg-yellow-50','text'=>'text-yellow-600'],
      ['label'=>'Users','value'=>$users,'icon'=>'👥','bg'=>'bg-purple-50','text'=>'text-purple-600'],
    ] as $stat)
    <div class="bg-white border border-gray-100 rounded-xl p-5">
      <div class="w-9 h-9 {{ $stat['bg'] }} rounded-lg flex items-center justify-center text-lg mb-3">{{ $stat['icon'] }}</div>
      <p class="text-xs uppercase tracking-wide text-gray-400 font-medium">{{ $stat['label'] }}</p>
      <p class="text-3xl font-medium mt-1">{{ $stat['value'] }}</p>
    </div>
    @endforeach
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div class="bg-white border border-gray-100 rounded-xl p-5">
      <p class="text-sm font-medium text-gray-500 mb-3">Quick actions</p>
      <div class="flex flex-col gap-2">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium w-fit">+ Add product</a>
      </div>
    </div>
    <div class="bg-white border border-gray-100 rounded-xl p-5">
      <p class="text-sm font-medium text-gray-500 mb-3">Recent activity</p>
      <div class="flex flex-col gap-2 text-sm text-gray-600">
        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-400"></span>New order received</div>
        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span>Product updated</div>
        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-yellow-400"></span>New restaurant added</div>
      </div>
    </div>
  </div>
</div>
@endsection

