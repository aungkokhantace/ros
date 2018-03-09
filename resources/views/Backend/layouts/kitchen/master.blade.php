@include('Backend.layouts.kitchen.header')
@include('Backend.layouts.kitchen.nav')
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
@include('Backend.layouts.kitchen.footer')
{{--@include('sweet::alert')--}}
@include('sweet::alert')

