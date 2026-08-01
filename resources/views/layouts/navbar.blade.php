<div style="background:rgba(245, 240, 232, 0.95); border-bottom:1px solid #F0F0EC; padding:0 28px; height:68px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:30;">

    <!-- LEFT: Mobile toggle + Page title -->
    <div style="display:flex; align-items:center; gap:14px;">

        <!-- Mobile menu toggle -->
        {{-- <button class="mobile-menu-btn" onclick="openSidebar()"
                style="display:none; align-items:center; justify-content:center; width:40px; height:40px; background:#F5F5F0; border:none; border-radius:10px; cursor:pointer;">
            <i data-lucide="menu" style="width:20px; height:20px;"></i>
        </button> --}}

        <button
            onclick="toggleSidebar()"
            style="
                width:52px;
                height:52px;
                border:none;
                border-radius:50%;
                background:#C25A2A;
                color:white;
                cursor:pointer;
                display:flex;
                align-items:center;
                justify-content:center;
            ">
            <i data-lucide="menu"></i>
        </button>

        <!-- Dynamic page title -->
        <div>
            <h1 style="font-family:'Poppins',sans-serif; font-size:20px; font-weight:700; color:#0D0D0D; margin:0; letter-spacing:-.3px;">
                @php
                    $path = request()->path();
                    $titles = [
                        'dashboard'  => 'Dashboard',
                        'products'   => 'Products',
                        'orders'     => 'Orders',
                        'categories' => 'Categories',
                        'users'      => 'Users',
                        'vendor'     => 'Vendors',
                        'restaurants'=> 'Restaurants',
                        'profile'    => 'Restaurant Profile',
                        'items'      => 'Menu Items',
                    ];
                    $pageTitle = 'Dashboard';
                    foreach($titles as $key => $label) {
                        if(str_contains($path, $key)) { $pageTitle = $label; break; }
                    }
                @endphp
                {{ $pageTitle }}
            </h1>
            <p style="font-size:12px; color:#9CA3AF; margin:1px 0 0; font-weight:400;">
                {{ now()->format('l, d M Y') }}
            </p>
        </div>
    </div>

    <!-- RIGHT: Notifications + User -->
    @auth
        <div style="display:flex; align-items:center; gap:10px;">

            <!-- Enable Notifications Button -->
            <button id="btnEnableNavbarPush" onclick="enablePushNotifications(this)"
                    style="
                        background: linear-gradient(135deg, #C25A2A 0%, #E8570E 100%);
                        color: #fff;
                        border: none;
                        border-radius: 10px;
                        padding: 8px 14px;
                        font-family: 'Poppins', sans-serif;
                        font-size: 12px;
                        font-weight: 600;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        gap: 6px;
                        box-shadow: 0 2px 6px rgba(194, 90, 42, 0.25);
                        transition: all 0.2s;
                    ">
                <i data-lucide="bell-ring" style="width:14px; height:14px;"></i>
                <span>Enable Alerts</span>
            </button>

            @php
                $notifications = \App\Models\Notification::where(
                    'user_id',
                    auth()->id()
                )
                ->latest()
                ->take(10)
                ->get();

                $unreadCount = \App\Models\Notification::where(
                    'user_id',
                    auth()->id()
                )
                ->where('is_read', 0)
                ->count();
            @endphp
            <!-- Notification Bell -->
            <div style="position:relative;">

                <button
                    onclick="toggleNotificationDropdown()"
                    style="
                        width:40px;
                        height:40px;
                        background:#F5F5F0;
                        border:none;
                        border-radius:10px;
                        cursor:pointer;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        position:relative;
                    ">

                    <i data-lucide="bell"
                    style="width:18px;height:18px;color:#374151;">
                    </i>

                    @if($unreadCount > 0)
                        <span 
                        id="notificationCount"
                        style="
                            position:absolute;
                            top:4px;
                            right:4px;
                            min-width:18px;
                            height:18px;
                            background:#DC2626;
                            color:white;
                            font-size:10px;
                            font-weight:700;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                        ">
                            {{ $unreadCount }}
                        </span>
                    @endif

                </button>

                <div id="notificationDropdown"
                    style="
                        display:none;
                        position:absolute;
                        top:50px;
                        right:0;
                        width:380px;
                        max-height:500px;
                        overflow:hidden;
                        background:white;
                        border-radius:16px;
                        box-shadow:0 20px 60px rgba(0,0,0,.15);
                        z-index:9999;
                    ">

                    <div style="
                        padding:18px;
                        border-bottom:1px solid #eee;
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                    ">
                        <strong>Notifications</strong>

                        <form
                            method="POST"
                            action="{{ route('notifications.clearAll') }}">
                            @csrf

                            <button
                                type="submit"
                                style="
                                    border:none;
                                    background:none;
                                    color:#DC2626;
                                    font-size:12px;
                                    font-weight:600;
                                    cursor:pointer;
                                ">
                                Clear All
                            </button>
                        </form>
                    </div>

                    <div
                    id="notificationList"
                    style="
                        max-height:420px;
                        overflow-y:auto;
                    ">

                        

                    </div>

                </div>

            </div>

            <!-- Divider -->
            <div style="width:1px; height:28px; background:#F0F0EC;"></div>

            <!-- User Info -->
           <!-- User Dropdown -->
<div style="position:relative;">

    <div onclick="toggleUserDropdown()"
        style="display:flex; align-items:center; gap:10px; background:#F5F5F0; padding:7px 14px 7px 7px; border-radius:12px; cursor:pointer;">

        <div style="width:34px;height:34px;background:#C25A2A;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;color:#fff;">
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </div>

        <div class="user-info-text" style="display:none;">
            <p style="font-size:13px;font-weight:700;margin:0;">
                {{ auth()->user()->name }}
            </p>
            <p style="font-size:11px;color:#6B7280;margin:0;text-transform:capitalize;">
                {{ str_replace('_',' ',auth()->user()->role) }}
            </p>
        </div>

        <i data-lucide="chevron-down" style="width:16px;height:16px;"></i>
    </div>

    <div id="userDropdown"
        style="display:none;position:absolute;top:55px;right:0;background:#fff;width:180px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.15);overflow:hidden;z-index:9999;">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                style="width:100%;border:none;background:none;padding:14px 16px;text-align:left;cursor:pointer;display:flex;align-items:center;gap:10px;font-size:14px;">
                <i data-lucide="log-out"></i>
                Logout
            </button>
        </form>

    </div>

</div>
        </div>
    @endauth

</div>

<script>

function toggleNotificationDropdown() {

    let dropdown =
        document.getElementById(
            'notificationDropdown'
        );

    dropdown.style.display =
        dropdown.style.display === 'block'
        ? 'none'
        : 'block';
}

document.addEventListener('click', function(e){

    const dropdown =
        document.getElementById(
            'notificationDropdown'
        );

    if (
        !e.target.closest('#notificationDropdown')
        &&
        !e.target.closest('[onclick="toggleNotificationDropdown()"]')
    ) {
        dropdown.style.display = 'none';
    }
});

let lastUnreadCount = null;

function fetchNotifications()
{
    fetch('/notifications/latest')
    .then(res => res.json())
    .then(data => {

        if (lastUnreadCount !== null && data.unreadCount > lastUnreadCount) {
            if (typeof window.playNotificationSound === 'function') {
                window.playNotificationSound();
            }
        }
        lastUnreadCount = data.unreadCount;

        /*
        |--------------------------------------------------------------------------
        | UPDATE COUNT
        |--------------------------------------------------------------------------
        */

        let badge =
            document.getElementById(
                'notificationCount'
            );

        if(!badge){

            const bellButton =
                document.querySelector(
                    '[onclick="toggleNotificationDropdown()"]'
                );

            badge =
                document.createElement('span');

            badge.id =
                'notificationCount';

            badge.style.cssText = `
                position:absolute;
                top:4px;
                right:4px;
                min-width:18px;
                height:18px;
                background:#DC2626;
                color:white;
                font-size:10px;
                font-weight:700;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
            `;

            bellButton.appendChild(
                badge
            );
        }

        if(data.unreadCount > 0){

            badge.style.display =
                'flex';

            badge.innerHTML =
                data.unreadCount;

        }else{

            badge.style.display =
                'none';
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE LIST
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | UPDATE LIST
        |--------------------------------------------------------------------------
        */

        let html = '';

        if (data.notifications.length) {

            data.notifications.forEach(item => {

                html += `
                    <div style="
                        padding:15px 18px;
                        border-bottom:1px solid #F0F0EC;
                        transition:background .15s;
                    "
                    onmouseover="this.style.background='#FAFAFA'"
                    onmouseout="this.style.background='white'">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:flex-start;
                            gap:10px;
                        ">

                            <div style="flex:1;">

                                <div style="
                                    font-family:'Poppins',sans-serif;
                                    font-weight:700;
                                    font-size:13.5px;
                                    color:#0D0D0D;
                                    margin-bottom:5px;
                                ">
                                    ${item.title}
                                </div>

                                <div style="
                                    font-size:12.5px;
                                    color:#6B7280;
                                    line-height:1.45;
                                ">
                                    ${item.message}

                                    ${
                                        item.order_id
                                        ? `
                                            <a href="/restaurant/orders/${item.order_id}"
                                                style="
                                                    color:#16A34A;
                                                    text-decoration:underline;
                                                    font-weight:600;
                                                    margin-left:4px;
                                                ">
                                                View
                                            </a>
                                        `
                                        : ''
                                    }
                                </div>

                            </div>

                            ${
                                item.can_clear
                                ? `
                                    <form method="POST"
                                        action="/notifications/${item.id}/clear"
                                        style="margin:0;">
                                        <input type="hidden"
                                            name="_token"
                                            value="${document.querySelector('meta[name=csrf-token]').content}">

                                        <button type="submit"
                                                style="
                                                    border:none;
                                                    background:none;
                                                    color:#9CA3AF;
                                                    cursor:pointer;
                                                    font-size:18px;
                                                    line-height:1;
                                                    padding:0;
                                                    transition:.2s;
                                                "
                                                onmouseover="this.style.color='#DC2626'"
                                                onmouseout="this.style.color='#9CA3AF'"
                                                title="Remove Notification">
                                            &times;
                                        </button>
                                    </form>
                                `
                                : ''
                            }

                        </div>

                    </div>
                `;
            });

        } else {

            html = `
                <div style="
                    padding:30px 20px;
                    text-align:center;
                    color:#9CA3AF;
                    font-size:13px;
                ">
                    No notifications yet
                </div>
            `;
        }

        document.getElementById('notificationList').innerHTML = html;

    });
}

/*
|--------------------------------------------------------------------------
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

fetchNotifications();

/*
|--------------------------------------------------------------------------
| AUTO REFRESH EVERY 10 SECONDS
|--------------------------------------------------------------------------
*/

setInterval(fetchNotifications, 10000);

</script>
<script>
function toggleUserDropdown() {
    let dropdown = document.getElementById('userDropdown');

    dropdown.style.display =
        dropdown.style.display === 'block'
        ? 'none'
        : 'block';
}

document.addEventListener('click', function(e){

    if(
        !e.target.closest('#userDropdown') &&
        !e.target.closest('[onclick="toggleUserDropdown()"]')
    ){
        document.getElementById('userDropdown').style.display='none';
    }

});
</script>

<style>
@media(min-width:600px){
    .user-info-text { display:block !important; }
}
</style>