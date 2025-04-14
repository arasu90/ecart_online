<!DOCTYPE html>
<html lang="en">

@include('admin.include.header')
<style>
    .width-10 {
        width: 10rem !important;
        height: 10rem !important;
    }

    .width-25 {
        width: 25rem !important;
    }

    .float-right {
        float: right !important;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        text-align: center;
        vertical-align: middle;
        font-size: larger;
    }

    .zoom-img {
        width: 100%;
        height: 100px;
        overflow: clip;
    }

    .zoom-img img {
        width: 100%;
        transition: all .3s ease;
    }

    .zoom-img img:hover {
        transform: scale(2);
        border: 1px solid #000;
        position: absolute;
    }

    .mt-1 {
        margin-top: 1rem;
    }
</style>

<body>
    @include('admin.include.topbar')
    <!--header-->
    <div class="container-fluid">
        <!--documents-->
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
                @include('admin.include.sidemenu')
            </div>
            <div class="col-xs-12 col-sm-9 content">
                {{ $slot }}
            </div><!-- content -->
        </div>
    </div>
    @include('admin.include.footer')
    @stack('scripts')
</body>

</html>
