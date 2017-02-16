@include('cashier.layouts.kitchen.header')
@include('cashier.layouts.kitchen.nav')
        <!-- Page Content -->
<div class="container">

    <div class="row">
        <div id="body">
            <!-- Blog Entries Column -->
            @yield('content')
        </div>
    </div>
    <!-- /.row -->
</div>
@include('cashier.layouts.kitchen.footer')
{{--@include('sweet::alert')--}}
@include('sweet::alert')

