@include('Backend.layouts.partial.header')

@include('Backend.layouts.partial.nav')

        <!--  Content -->

            @yield('content')

    <!-- Page Content -->
@include('Backend.layouts.partial.footer')

{{--@include('sweet::alert')--}}
@include('sweet::alert')
