<!-- Topbar Start -->
<div class="container-fluid bg-secondary">
    <div class="row align-items-center py-1 px-xl-5">
        <div class="col-lg-3 col-2 d-lg-block">
            <a href="{{ route('page.home') }}" class="text-decoration-none">
                <img class="logoheader" src="{{ asset('assets/img/logo.png') }}" alt="logo">
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <!-- <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form> -->
            <form action="{{route('product.list')}}" method="get">
                <div class="input-group">
                    <input type="text" class="form-control search-font-size" name="search" placeholder="Search for products">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary" onclick="event.preventDefault();this.closest('form').submit();">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-4 text-right {{ (Auth::user()) ? 'col-lg-padding-right col-lg-padding-left' : '' }}">
            @if(Auth::user())
            <span class="dropdown menu-dropdown">
                <button type="button" class="btn border dropdown-toggle  mr-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user text-primary"></i></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <label class="text-primary label p-2">Welcome {{ ucfirst(Auth::user()->name) }}</label>
                    <a href="{{route('profile.edit')}}" class="dropdown-item">
                        <i class="fas fa-user-secret text-primary"></i> {{ __('My Profile') }}
                    </a>
                    <a href="{{route('page.cart')}}" class="dropdown-item">
                        <i class="fas fa-shopping-cart text-primary"></i> {{ __('Shopping Cart') }}
                    </a>
                    <a href="{{route('page.orderlist')}}" class="dropdown-item">
                        <i class="fas fa-shopping-cart text-primary"></i> {{ __('Order List') }}
                    </a>
                    <a href="{{route('address.list')}}" class="dropdown-item">
                        <i class="fas fa-shopping-cart text-primary"></i> {{ __('My Address Book') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{route('logout')}}" class="dropdown-item" onclick="event.preventDefault();this.closest('form').submit();">
                            <i class="fas fa-bed text-primary"></i> {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </span>
            @else
            <a href="{{route('login')}}" class="btn border abtn">
                <i class="fas fa-user text-primary"></i>
            </a>
            @endif
            <a href="{{ route('page.cart') }}" class="btn border {{ (Auth::user()) ? 'margin-left-40' : 'abtn' }} ">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge">{{ $cart_count ?? 0 }}</span>
            </a>
        </div>
    </div>
</div>
<!-- Topbar End -->