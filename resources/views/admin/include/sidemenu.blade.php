<ul class="list-group panel">
    <li class="list-group-item"><i class="glyphicon glyphicon-align-justify"></i> <b>Admin Access</b></li>
    <li class="list-group-item">
        <input type="text" class="form-control search-query" placeholder="Search Something">
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.dashboard') }}">
            <i class="glyphicon glyphicon-home"></i>{{ __('Dashboard') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.productlist') }}">
            <i class="glyphicon glyphicon-list-alt"></i>{{ __('Product') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.userlist') }}">
            <i class="glyphicon glyphicon-th-list"></i>{{ __('Users') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.orderlist') }}">
            <i class="glyphicon glyphicon-calendar"></i>{{ __('Orders List') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.websitedata') }}">
            <i class="glyphicon glyphicon-certificate"></i>{{ __('Website Details') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.prodDataList') }}">
            <i class="glyphicon glyphicon-indent-left"></i>{{ __('Product Data Field') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.categorylist') }}">
            <i class="glyphicon glyphicon-indent-left"></i>{{ __('Category') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.brandlist') }}">
            <i class="glyphicon glyphicon-th"></i>{{ __('Brand') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.changepassword') }}">
            <i class="glyphicon glyphicon-cog"></i>{{ __('Change Password') }}
        </a>
    </li>
    <li class="list-group-item">
        &nbsp;
    </li>
    <li class="list-group-item">
        <a href="{{ env('APP_URL') }}" target="_blank">
            <i class="glyphicon glyphicon-globe"></i>{{ __('Goto Website') }}
        </a>
    </li>
    <li class="list-group-item">
        &nbsp;
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.logout') }}" >
            <i class="glyphicon glyphicon-log-out"></i>{{ __('Logout') }}
        </a>
    </li>
</ul>
