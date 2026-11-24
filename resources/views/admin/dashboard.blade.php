@extends('layouts.app')
@section('content')
<div class="p-8">
  <div class="flex flex-col md:flex-row justify-between items-center mb-8">
    <div>
      <h1 class="text-2xl font-medium">Dashboard</h1>
      <p class="text-gray-500 text-sm mt-1">Super admin overview</p>
    </div>
    {{-- //direct button --}}
    {{-- <a href="{{ route('admin.google-drive.index') }}"
      class="bg-[#C25A2A] text-white px-5 py-2 rounded hover:bg-blue-700">
        Google Drive Token
    </a> --}}

    {{-- //dynamic --}}
    @php
        use Illuminate\Support\Facades\Storage;
        use Carbon\Carbon;

        $status = 'not_connected';
        $daysLeft = null;
        $statusText = 'Not Connected';

        if (Storage::exists('google-drive-token.json')) {

            $token = json_decode(Storage::get('google-drive-token.json'), true);

            if (!empty($token['expires_at'])) {

                $expiresAt = Carbon::parse($token['expires_at']);

                $daysLeft = now()->diffInDays($expiresAt, false);

                if ($daysLeft < 0) {

                    $status = 'expired';
                    $statusText = 'Expired';

                } elseif ($daysLeft <= 3) {

                    $status = 'warning';
                    $statusText = $daysLeft . ' day(s) left';

                } else {

                    $status = 'connected';
                    $statusText = 'Connected';

                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | Production Refresh Token
                |--------------------------------------------------------------------------
                | No expiry stored means token is treated as active.
                */

                $status = 'connected';
                $statusText = 'Connected';
            }
        }
    @endphp

    <div class="flex flex-col md:flex-row items-center gap-3">

        <a href="{{ route('admin.google-drive.index') }}"
          class="inline-flex items-center gap-2 px-5 py-2 rounded-lg font-medium text-white transition

          @if($status=='connected')
                bg-green-600 hover:bg-green-700
          @elseif($status=='warning')
                bg-yellow-500 hover:bg-yellow-600
          @elseif($status=='expired')
                bg-red-600 hover:bg-red-700
          @else
                bg-blue-600 hover:bg-blue-700
          @endif">

            @if($status=='connected')
                🟢
            @elseif($status=='warning')
                🟡
            @elseif($status=='expired')
                🔴
            @else
                ⚪
            @endif

            Google Drive

        </a>

        @if($status=='connected')

            <span class="text-green-600 font-semibold">
            <span class="font-semibold">({{ $daysLeft }} days left)</span> Connected
            </span>

        @elseif($status=='warning')

            <span class="text-yellow-600 font-semibold">
                {{ $statusText }}
            </span>

        @elseif($status=='expired')

            <span class="text-red-600 font-semibold">
                Token Expired
            </span>

        @else

            <span class="text-gray-500 font-semibold">
                Not Connected
            </span>

        @endif

    </div>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    @foreach([
      ['label'=>'Restaurants','value'=>$restaurants,'icon'=>'🍽️','bg'=>'bg-blue-50','text'=>'text-blue-600'],
      ['label'=>'Products','value'=>$products,'icon'=>'📦','bg'=>'bg-green-50','text'=>'text-green-600'],
      ['label'=>'Orders','value'=>$orders,'icon'=>'🛒','bg'=>'bg-yellow-50','text'=>'text-yellow-600'],
      ['label'=>'Users','value'=>$users,'icon'=>'👥','bg'=>'bg-purple-50','text'=>'text-purple-600'],
      ['label'=>'Fantasy Squad','value'=>$playersCount,'icon'=>'🏴󠁧󠁢󠁥󠁮󠁧󠁿','bg'=>'bg-amber-50','text'=>'text-amber-600'],
    ] as $stat)
    <div class="bg-white border border-gray-100 rounded-xl p-5">
      <div class="w-9 h-9 {{ $stat['bg'] }} rounded-lg flex items-center justify-center text-lg mb-3">{{ $stat['icon'] }}</div>
      <p class="text-xs uppercase tracking-wide text-gray-400 font-medium">{{ $stat['label'] }}</p>
      <p class="text-3xl font-medium mt-1">{{ $stat['value'] }}</p>
    </div>
    @endforeach
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white border border-gray-100 rounded-xl p-5">
      <p class="text-sm font-medium text-gray-500 mb-3">Quick actions</p>
      <div class="flex flex-wrap gap-2.5">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add product</a>
        <a href="{{ route('admin.matchday.players.index') }}" class="inline-flex items-center gap-2 bg-[#C25A2A] hover:bg-[#a94c20] text-white px-4 py-2 rounded-lg text-sm font-medium">🏴󠁧󠁢󠁥󠁮󠁧󠁿 Manage Fantasy Squad</a>
        <a href="{{ route('admin.matchday.campaigns.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">⚙️ Campaign Rules</a>
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

  {{-- System Error & Journey Monitor Widget --}}
  <div class="bg-white border border-gray-100 rounded-xl p-6 mt-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4 pb-4 border-b border-gray-100">
      <div>
        <div class="flex items-center gap-2.5">
          <span class="text-xl">🛡️</span>
          <h2 class="text-lg font-semibold text-gray-900">System Errors &amp; Request Health</h2>
          @if($todayErrors > 0)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
              <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
              {{ $todayErrors }} Error(s) Today
            </span>
          @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
              <span class="w-2 h-2 rounded-full bg-green-600"></span>
              Healthy
            </span>
          @endif
        </div>
        <p class="text-xs text-gray-500 mt-1">Real-time errors and browsing journeys recorded in <code>admin_hystLogs</code></p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.activity-logs.index', ['status' => 'failed']) }}" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold px-3.5 py-2 rounded-lg transition border border-red-200">
          🚨 View {{ $totalErrors }} Error Logs
        </a>
        <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
          🗺️ Open Error Journeys
        </a>
      </div>
    </div>

    @if($recentErrors->isNotEmpty())
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="text-gray-400 uppercase tracking-wider border-b border-gray-100">
              <th class="pb-2.5 font-semibold">Time</th>
              <th class="pb-2.5 font-semibold">IP Address</th>
              <th class="pb-2.5 font-semibold">Action</th>
              <th class="pb-2.5 font-semibold">HTTP Code</th>
              <th class="pb-2.5 font-semibold">Endpoint / Error Message</th>
              <th class="pb-2.5 font-semibold text-right">Journey</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 text-gray-700">
            @foreach($recentErrors as $err)
              @php
                $resp = is_array($err->response) ? $err->response : (json_decode($err->response, true) ?? []);
                $code = $resp['status_code'] ?? 500;
                $errMsg = $resp['error']['message'] ?? ($err->description ?? 'Error');
              @endphp
              <tr class="hover:bg-red-50/40 transition">
                <td class="py-2.5 text-gray-500 whitespace-nowrap">{{ $err->created_at ? $err->created_at->format('M d, H:i:s') : '—' }}</td>
                <td class="py-2.5 font-mono font-medium text-gray-900">{{ $err->ip_address }}</td>
                <td class="py-2.5">
                  <span class="px-2 py-0.5 rounded font-mono text-[10px] font-bold uppercase {{ $err->action === 'POST' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $err->action }}
                  </span>
                </td>
                <td class="py-2.5">
                  <span class="px-2 py-0.5 rounded text-[11px] font-bold {{ $code >= 500 ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-amber-100 text-amber-700' }}">
                    {{ $code }}
                  </span>
                </td>
                <td class="py-2.5 max-w-md truncate" title="{{ $errMsg }}">
                  <span class="font-medium text-red-700">{{ $errMsg }}</span>
                </td>
                <td class="py-2.5 text-right whitespace-nowrap">
                  <a href="{{ route('admin.activity-logs.index', ['ip' => $err->ip_address]) }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                    View IP Journey &rarr;
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="py-8 text-center text-gray-400">
        <div class="text-2xl mb-1">🟢</div>
        <p class="text-sm font-medium text-gray-600">No system errors recorded</p>
        <p class="text-xs text-gray-400 mt-0.5">All incoming HTTP requests are operating cleanly without exceptions.</p>
      </div>
    @endif
  </div>
</div>
@endsection

