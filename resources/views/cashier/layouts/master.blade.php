@include('cashier.layouts.partial.header')

@include('cashier.layouts.partial.nav')

        <!-- Page Content -->
    <div class="container container-part">
        <div class="col-md-12" id="body">

            @yield('content')

        </div>
     </div>
    <!-- Page Content -->
@include('cashier.layouts.partial.footer')

{{--@include('sweet::alert')--}}
@include('sweet::alert')

