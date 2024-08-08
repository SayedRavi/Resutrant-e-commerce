<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>

    </form>

    <ul class="navbar-nav navbar-right">
        @php
            $notifications = \App\Models\OrderPlacedNotifaction::where('seen', 0)->latest()->take(5)->get();
            $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();
        @endphp

        <li class="dropdown dropdown-list-toggle">
            <a href="{{route('admin.chat.index')}}" class="nav-link nav-link-lg message_envelope {{$unseenMessages > 0 ? 'beep' : ''}}">
                <i class="far fa-envelope"></i>
            </a>
        </li>

        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
           class="nav-link notification-toggle nav-link-lg notification-beep{{count($notifications) > 0 ? 'beep' : ''}}"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="{{route('admin.clear-notification')}}">Mark All As Read</a>
                    </div>
                </div>

                <div class="dropdown-list-content dropdown-list-icons rt-notification">
                   @foreach($notifications as $notification)

                    <a href="{{route('admin.order.show', $notification->order_id)}}" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>{{$notification->message}}</b> Order have been placed.
                            <div class="time">{{date('h:i A | d-F-Y',strtotime($notification->dates))}}</div>
                        </div>
                    </a>
                    @endforeach


                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{route('admin.order.index')}}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{asset(auth()->user()->avatar)}}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{auth()->user()->name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{route('admin.profile')}}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="javascript: void(0);" onclick="$('#logout').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout

                </a>
            </div>
        </li>
    </ul>
    <form action="{{route('logout')}}" id="logout" method="post">
        @csrf
    </form>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

                 <li class=active><a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fas fa-fire"></i>General Dashboard</a></li>

            <li class="menu-header">Starter</li>
            <li><a class="nav-link" href="{{route('admin.slider.index')}}"><i class="far fa-square"></i> <span>Slider</span></a></li>
            <li><a class="nav-link" href="{{route('admin.daily-offer.index')}}"><i class="far fa-square"></i> <span>Daily Offers</span></a></li>


            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin.order.index')}}">All Orders</a></li>
                    <li><a class="nav-link" href="{{route('admin.pending-order.index')}}">Pending Orders</a></li>
                    <li><a class="nav-link" href="{{route('admin.in-process-order.index')}}">In Process Orders</a></li>
                    <li><a class="nav-link" href="{{route('admin.delivered-order.index')}}">Delivered Orders</a></li>
                    <li><a class="nav-link" href="{{route('admin.declined-order.index')}}">Declined Orders</a></li>

                </ul>
            </li>

            <li class="dropdown">
                  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Products</span></a>
                  <ul class="dropdown-menu">
                     <li><a class="nav-link" href="{{route('admin.category.index')}}">Category</a></li>
                     <li><a class="nav-link" href="{{route('admin.product.index')}}">Products</a></li>

                 </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Ecommerce</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin.coupon.index')}}">Coupons</a></li>
                    <li><a class="nav-link" href="{{route('admin.delivery-areas.index')}}">Delivery Areas</a></li>
                    <li><a class="nav-link" href="{{route('admin.payment-gateway-setting')}}">Payment Gateways</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="{{route('admin.chat.index')}}"><i class="far fa-square"></i> <span>Chat</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Blog</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin.blog-category.index')}}">Categories</a></li>
                    <li><a class="nav-link" href="{{route('admin.blog.index')}}">Blog</a></li>
                    <li><a class="nav-link" href="{{route('admin.blog.comments.index')}}">Blog Comments</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Sections</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin.why-choose-us.index')}}">Why Choose Us</a></li>
                    <li><a class="nav-link" href="{{route('admin.banner-slider.index')}}">Banner Slider</a></li>
                    <li><a class="nav-link" href="{{route('admin.chef.index')}}">Chefs</a></li>
                    <li><a class="nav-link" href="{{route('admin.app-download.index')}}">App Download</a></li>
                    <li><a class="nav-link" href="{{route('admin.testimonial.index')}}">Testimonials</a></li>
                    <li><a class="nav-link" href="{{route('admin.counter.index')}}">Counter</a></li>

                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Pages</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin.about.index')}}">About</a></li>
                    <li><a class="nav-link" href="{{route('admin.privacy-policy.index')}}">Privacy Policy</a></li>
                    <li><a class="nav-link" href="{{route('admin.terms-and-conditions.index')}}">Terms and Conditions</a></li>
                    <li><a class="nav-link" href="{{route('admin.contact.index')}}">Contact</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="{{route('admin.setting.index')}}"><i class="far fa-square"></i> <span>Settings</span></a></li>

            {{--            <li class="dropdown">--}}
{{--                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>--}}
{{--                <ul class="dropdown-menu">--}}
{{--                    <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>--}}
{{--                    <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>--}}
{{--                    <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>--}}
        </ul>

        </aside>
</div>
