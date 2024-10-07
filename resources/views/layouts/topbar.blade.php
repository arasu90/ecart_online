<div>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 col-6">
                <a href="{{route('home')}}" class="">
                <img src="{{ getLogo() }}" class="logo" alt="Logo">

                </a>
            </div>
            <div class="col-lg-6 col-6 text-left d-none d-lg-block">
                <form action="{{route('product')}}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary" onclick="event.preventDefault();this.closest('form').submit();">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                @if(Auth::user())
                <span class="dropdown">
                    <button type="button" class="btn border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user text-primary"></i></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <label for="form-label" class="text-primary label">Welcome {{ ucfirst(Auth::user()->name) }}</label>
                        <a href="{{route('profile.edit')}}" class="dropdown-item">
                            <i class="fas fa-user-secret text-primary"></i> 
                            My Profile
                        </a>
                        <a href="{{route('cart')}}" class="dropdown-item">
                            <i class="fas fa-shopping-cart text-primary"></i> 
                            Shopping Cart
                        </a>
                        <a href="{{route('myorderlist')}}" class="dropdown-item">
                            <i class="fas fa-shopping-cart text-primary"></i> 
                            Order History
                        </a>
                        <a href="{{route('profile.myaddress')}}" class="dropdown-item">
                            <i class="fas fa-shopping-cart text-primary"></i> 
                            {{ __('My Address') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{route('logout')}}" class="dropdown-item" onclick="event.preventDefault();this.closest('form').submit();"> 
                            <i class="fas fa-bed text-primary"></i>  {{ __('Log Out') }}
                            </a>

                        </form>
                        
                    </div>
                </span>
                @else
                <a href="{{route('login')}}" class="btn border">
                    <i class="fas fa-user text-primary"></i>
                </a>
                @endif
                <a href="{{route('cart')}}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge"><span id="shoppingcart_count">
                            @if(Session::has('cart_count'))
                            {{ Session::get('cart_count') }}
                            @else
                            0
                            @endif
                        </span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
</div>