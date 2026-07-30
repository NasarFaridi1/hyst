<style>
    /* Floating Menu */

    #sidebar{
        position:fixed;

        top:85px;
        left:30px;

        width:120px;

        max-height:75vh;

        background:#C25A2A;

        border-radius:50px;

        padding:15px 10px;

        display:none;
        flex-direction:column;
        align-items:center;
        gap:12px;

        overflow-y:auto;
        overflow-x:hidden;

        z-index:9999;

        box-shadow:
            0 10px 25px rgba(0,0,0,.12),
            0 4px 10px rgba(0,0,0,.08);
    }

    /* Open State */

    #sidebar.open{
        display:flex;
    }

    /* Hide Scrollbar */

    #sidebar::-webkit-scrollbar{
        width:0;
        height:0;
        display:none;
    }

    #sidebar{
        scrollbar-width:none;
        -ms-overflow-style:none;
    }

    /* Menu Items */

    .sidebar-item{
        width:100%;

        display:flex;
        flex-direction:column;
        align-items:center;

        text-decoration:none;

        color:#fff;

        padding:4px 0;

        transition:.25s ease;
    }

    /* Circular Icon */

    .sidebar-icon{
        width:58px;
        height:58px;

        border:2px solid rgba(255,255,255,.95);

        border-radius:50%;

        display:flex;
        align-items:center;
        justify-content:center;

        transition:.25s ease;
    }

    .sidebar-icon i{
        width:26px;
        height:26px;
    }

    /* Text */

    .sidebar-item span{
        margin-top:6px;

        font-size:11px;

        font-weight:600;

        text-align:center;

        line-height:1.2;
    }

    /* Hover */

    .sidebar-item:hover .sidebar-icon{
        background:#fff;
        color:#C25A2A;

        transform:translateY(-2px);
    }

    /* Active */

    .sidebar-item.active .sidebar-icon{
        background:#fff;
        color:#C25A2A;
    }

    .sidebar-item.active span{
        font-weight:700;
    }

    /* Logout Button */

    .sidebar-item button{
        all:unset;
    }

    /* Mobile */

    @media(max-width:768px){

        #sidebar{
            left:15px;
            top:75px;

            width:110px;

            max-height:65vh;
        }

        .sidebar-icon{
            width:52px;
            height:52px;
        }

        .sidebar-icon i{
            width:22px;
            height:22px;
        }

        .sidebar-item span{
            font-size:10px;
        }
    }
</style>

<div id="sidebar">
    @php $current = request()->path(); @endphp

    @if(auth()->check())
        {{-- SUPER ADMIN --}}
        @if(auth()->user()->role == 'super_admin')

            <a href="/admin/dashboard"
            class="sidebar-item {{ str_contains($current,'admin/dashboard') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="layout-dashboard"></i>
                </div>
                <span>Dashboard</span>
            </a>

            <a href="/admin/orders"
            class="sidebar-item {{ str_contains($current,'admin/orders') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="clipboard-list"></i>
                </div>
                <span>Orders</span>
            </a>

            <a href="/admin/restaurant-categories"
            class="sidebar-item {{ str_contains($current,'admin/restaurant-categories') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="store"></i>
                </div>
                <span>Restaurants Categories</span>
            </a>

            <a href="/admin/restaurants"
            class="sidebar-item {{ str_contains($current,'admin/restaurants') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="store"></i>
                </div>
                <span>Restaurants</span>
            </a>

            <a href="/admin/products"
            class="sidebar-item {{ str_contains($current,'admin/products') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="package"></i>
                </div>
                <span>Products</span>
            </a>


            <a href="/admin/users"
            class="sidebar-item {{ str_contains($current,'admin/users') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="users"></i>
                </div>
                <span>Users</span>
            </a>

            <a href="/admin/gift-cards"
                class="sidebar-item {{ str_contains($current,'admin/gift-cards') ? 'active' : '' }}">

                    <div class="sidebar-icon">
                        <i data-lucide="layers-3"></i>
                    </div>

                    <span>Gift Cards</span>

            </a>

            <a href="/admin/marketing-banner-categories"
                class="sidebar-item {{ str_contains($current,'admin/marketing-banner-categories') ? 'active' : '' }}">

                    <div class="sidebar-icon">
                        <i data-lucide="layers-3"></i>
                    </div>

                    <span>Banner Categories</span>

            </a>

            <a href="/admin/marketing-banners"
            class="sidebar-item {{ str_contains($current,'admin/marketing-banners') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="megaphone"></i>
                </div>
                <span>Marketing Banners</span>
            </a>

            <a href="/admin/terms-and-conditions"
            class="sidebar-item {{ str_contains($current,'admin/terms-and-conditions') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="file-text"></i>
                </div>
                <span>Terms & Conditions</span>
            </a>

            <a href="/admin/privacy-policy"
            class="sidebar-item {{ str_contains($current,'admin/privacy-policy') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="shield-check"></i>
                </div>
                <span>Privacy Policy</span>
            </a>
	
	        <a href="{{ route('admin.page-visits.index') }}"

                class="sidebar-item {{ str_contains($current,'admin/page-visits') ? 'active' : '' }}">



                <div class="sidebar-icon">

                    <i data-lucide="activity"></i>

                </div>
                <span>Analytics Integration</span>


            </a>

            <a href="/admin/complaint"
            class="sidebar-item {{ str_contains($current,'admin/complaint') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="clipboard-list"></i>
                </div>
                <span>Complaints</span>
            </a>

            

        @endif

        {{-- RESTAURANT ADMIN --}}
        @if(auth()->user()->role == 'restaurant_admin')

            {{-- 1. Dashboard --}}
            <a href="/restaurant/dashboard"
            class="sidebar-item {{ str_contains($current,'restaurant/dashboard') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="layout-dashboard"></i>
                </div>
                <span>Dashboard</span>
            </a>

            {{-- 2. Orders --}}
            <a href="/restaurant/orders"
            class="sidebar-item {{ str_contains($current,'restaurant/orders') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="clipboard-list"></i>
                </div>
                <span>Orders</span>
            </a>

            {{-- 3. Payment --}}
            <a href="/restaurant/payments"
            class="sidebar-item {{ str_contains($current,'restaurant/payments') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="credit-card"></i>
                </div>
                <span>Payment</span>
            </a>

            {{-- 4. Payment Complain --}}
            <a href="/restaurant/complaint"
            class="sidebar-item {{ str_contains($current,'restaurant/complaint') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="message-square"></i>
                </div>
                <span>Payment Complain</span>
            </a>

            {{-- 5. Review --}}
            <a href="/restaurant/reviews"
            class="sidebar-item {{ str_contains($current,'restaurant/reviews') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="star"></i>
                </div>
                <span>Review</span>
            </a>

            {{-- 6. Banner --}}
            <a href="/restaurant/banners"
            class="sidebar-item {{ str_contains($current,'restaurant/banners') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="megaphone"></i>
                </div>
                <span>Banner</span>
            </a>

            {{-- 7. Coupon --}}
            <a href="/restaurant/coupons"
            class="sidebar-item {{ str_contains($current,'restaurant/coupons') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="ticket"></i>
                </div>
                <span>Coupon</span>
            </a>

            {{-- 8. Offer --}}
            <a href="/restaurant/order-offers"
            class="sidebar-item {{ str_contains($current,'restaurant/order-offers') || str_contains($current,'restaurant/offers') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="badge-percent"></i>
                </div>
                <span>Offer</span>
            </a>

            {{-- 9. Category --}}
            <a href="/restaurant/categories"
            class="sidebar-item {{ str_contains($current,'restaurant/categories') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="grid-2x2"></i>
                </div>
                <span>Category</span>
            </a>

            {{-- 10. Products --}}
            <a href="/restaurant/products"
            class="sidebar-item {{ str_contains($current,'restaurant/products') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="package"></i>
                </div>
                <span>Products</span>
            </a>

            {{-- 11. Items --}}
            <!-- <a href="/restaurant/items"
            class="sidebar-item {{ str_contains($current,'restaurant/items') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="utensils-crossed"></i>
                </div>
                <span>Items</span>
            </a> -->

            {{-- 12. Analytic --}}
            <a href="{{ route('restaurant.page-visits.index') }}"
            class="sidebar-item {{ str_contains($current,'restaurant/page-visits') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="activity"></i>
                </div>
                <span>Analytic</span>
            </a>

            {{-- 13. Profile --}}
            <a href="/restaurant/profile"
            class="sidebar-item {{ str_contains($current,'restaurant/profile') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="store"></i>
                </div>
                <span>Profile</span>
            </a>

            {{-- 14. Loyalty & Rewards --}}
            <a href="{{ route('restaurant.loyalty.index') }}"
            class="sidebar-item {{ str_contains($current,'restaurant/loyalty-rewards') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="gift"></i>
                </div>
                <span>Loyalty & Rewards</span>
            </a>

            {{-- 15. Delivery Charges --}}
            <a href="{{ route('restaurant.delivery-charges.index') }}"
            class="sidebar-item {{ str_contains($current,'restaurant/delivery-charges') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="truck"></i>
                </div>
                <span>Delivery Charges</span>
            </a>

        @endif

        {{-- VENDOR --}}
        @if(auth()->user()->role == 'vendor')

            <a href="/vendor/dashboard"
            class="sidebar-item {{ str_contains($current,'vendor/dashboard') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="layout-dashboard"></i>
                </div>
                <span>Dashboard</span>
            </a>

            <a href="/vendor/products"
            class="sidebar-item {{ str_contains($current,'vendor/products') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <i data-lucide="package"></i>
                </div>
                <span>Products</span>
            </a>

        @endif

        @if(auth()->user()->role=='ambassador')

                <a href="/ambassador/dashboard"
                class="sidebar-item {{ str_contains($current,'ambassador/dashboard') ? 'active' : '' }}">

                <div class="sidebar-icon">

                <i data-lucide="layout-dashboard"></i>

                </div>

                <span>Dashboard</span>

                </a>

                <a href="/ambassador/restaurants"
                class="sidebar-item">

                <div class="sidebar-icon">

                <i data-lucide="store"></i>

                </div>

                <span>Restaurants</span>

                </a>


                <a href="/ambassador/profile"
                class="sidebar-item">

                <div class="sidebar-icon">

                <i data-lucide="user"></i>

                </div>

                <span>My Profile</span>

                </a>
                {{-- <a href="{{ route('ambassador.profile.index') }}"  class="sidebar-item">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a> --}}

                

        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="sidebar-item" style="background:none;border:none;cursor:pointer;">
                <div class="sidebar-icon">
                    <i data-lucide="log-out"></i>
                </div>
                <span>Logout</span>
            </button>
        </form>
    @endif

</div>

