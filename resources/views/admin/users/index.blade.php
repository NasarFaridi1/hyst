@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-10">

    <div>

        <h1 class="text-4xl font-bold">

            All Users

        </h1>

        <p class="text-gray-500 mt-2">

            Manage all users

        </p>

    </div>

</div>

<div class="bg-white rounded-2xl shadow p-5 mb-6">

    <form method="GET" action="{{ route('admin.users.index') }}">

        <div class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name, email, phone..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

                Search

            </button>

            @if(request('search'))
                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Reset

                </a>
            @endif

        </div>

    </form>

</div>





<div class="bg-white rounded-2xl shadow overflow-x-auto">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-5 text-left">
                    ID
                </th>

                <th class="p-5 text-left">
                    Name
                </th>

                <th class="p-5 text-left">
                    Email
                </th>

                <th class="p-5 text-left">
                    Phone
                </th>

                <th class="p-5 text-left">
                    Role
                </th>

                <th class="p-5 text-left">
                    Restaurant
                </th>

                <th class="p-5 text-left">
                    Created
                </th>
                 <th class="p-5 text-left">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-5">

                    {{ $user->id }}

                </td>

                <td class="p-5 font-bold">

                    {{ $user->name }}

                </td>

                <td class="p-5">

                    {{ $user->email }}

                </td>

                <td class="p-5">

                    {{ $user->phone ?? '-' }}

                </td>

                <td class="p-5">

                    @if($user->role == 'super_admin')

                    <span
                    class="bg-purple-100 text-purple-700 px-4 py-1 rounded-full">

                        Super Admin

                    </span>

                    @elseif($user->role == 'restaurant_admin')

                    <span
                    class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full">

                        Restaurant Admin

                    </span>

                    @else

                    <span
                    class="bg-green-100 text-green-700 px-4 py-1 rounded-full">

                        User

                    </span>

                    @endif

                </td>

                <td class="p-5">

                    {{ $user->restaurant->name ?? '-' }}

                </td>

                <td class="p-5">

                    {{ $user->created_at->format('d M Y') }}

                </td>
                <td class="p-5">

    <form method="POST"
    action="{{ route('admin.users.destroy',$user->id) }}"
    onsubmit="return confirm('Delete User?')">

        @csrf
        @method('DELETE')

        <button
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

            Delete

        </button>

    </form>

</td>

            </tr>

            @empty

            <tr>

                <td colspan="8"
                class="text-center py-20 text-gray-500">

                    No Users Found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-6">
    {{ $users->links() }}
</div>

@endsection