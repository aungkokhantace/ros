
<!-- Navigation -->
<nav class=" nav-color" role="navigation">
    <div class="container">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav ">

                {{-- Kitchen --}}
                <li @if(Request::path() == 'Kitchen/kitchen')class="active" @endif>
                    <a href="/Kitchen/kitchen">Table View</a></li>

                <li @if(Request::path() == 'Kitchen/productView') class="active" @endif>
                    <a href="/Kitchen/productView">Product View</a></li>

   
                {{-- End Kitchen for nav--}}

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>