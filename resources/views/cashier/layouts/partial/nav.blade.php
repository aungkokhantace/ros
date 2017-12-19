<!-- Navigation -->
<nav class=" nav-color" role="navigation">
    <div class="container">
        <!--  Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if (in_array('1',session()->get('module')))
                <li>
                    <a href="/Cashier/Dashboard">Dashboard</a>
                </li>
                @endif

                @if (in_array('2',session()->get('module')) || in_array('3',session()->get('module')))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Staff <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/Cashier/Permission/index">Permission</a></li>
                        @if (in_array('3',session()->get('module')))
                        <li><a href="/Cashier/StaffType/index">Staff Type</a></li>
                        @endif

                        @if (in_array('2',session()->get('module')))
                        <li><a href="/Cashier/Staff/index">Staff</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                
                @if (in_array('9',session()->get('module')) || in_array('10',session()->get('module')))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Member <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if (in_array('9',session()->get('module')))
                        <li><a href="/Cashier/MemberType/index">Member Type</a></li>
                        @endif

                        @if (in_array('10',session()->get('module')))
                        <li><a href="/Cashier/Member/index">Member</a></li>
                        @endif

                    </ul>
                </li>
                @endif

                @if (in_array('18',session()->get('module')))
                <li><a href="/Cashier/Kitchen/index">Kitchen</a></li>
                @endif

                @if (in_array('4',session()->get('module')) || in_array('5',session()->get('module')) || in_array('6',session()->get('module')) || in_array('8',session()->get('module')))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Product <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if (in_array('4',session()->get('module')))
                        <li><a href="/Cashier/Category/index">Category</a></li>
                        @endif

                        @if (in_array('5',session()->get('module')))
                        <li><a href="/Cashier/Item/index">Item</a></li>
                        @endif

                        @if (in_array('6',session()->get('module')))
                        <li><a href="/Cashier/AddOn/index">Add-on</a></li>
                        @endif 

                        @if (in_array('8',session()->get('module')))
                        <li><a href="/Cashier/SetMenu/index">Set Menu</a></li>
                        @endif
                        <!-- <li><a href="/Cashier/MakeOrder">MakeOrder</a></li> -->
                    </ul>
                </li>
                @endif

                @if (in_array('11',session()->get('module')) || in_array('12',session()->get('module')))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Service <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if (in_array('11',session()->get('module')))
                        <li><a href="/Cashier/Table/index">Table</a></li>
                        @endif

                        @if (in_array('12',session()->get('module')))
                        <li><a href="/Cashier/Room/index">Room</a></li>
                        @endif 

                        <li><a href="/Cashier/Location/index">Location</a></li>
                        
                    </ul>
                </li>
                @endif 
                
                @if (in_array('14',session()->get('module')) || in_array('7',session()->get('module')))
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">General<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    @if (in_array('14',session()->get('module')))
                        <li><a href="/Cashier/Config/general_config">Configurations</a></li>
                    @endif
                        <!-- <li><a href="/Cashier/Promotion/index">Promotions</a></li> -->
                    @if (in_array('7',session()->get('module')))
                        <li><a href="/Cashier/Discount/index">Discount</a></li>
                    @endif
                    </ul>
                </li>
                @endif 

                @if (in_array('17',session()->get('module')) || in_array('15',session()->get('module')) || in_array('13',session()->get('module')))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Report<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    @if (in_array('17',session()->get('module')))
                        <li><a href="/Cashier/OrderView/index">Food Order List</a></li>
                    @endif

                    @if (in_array('13',session()->get('module')))
                        <li><a href="/Cashier/Booking/index">Reservation</a> </li>
                    @endif
                        <li><a href="/Cashier/invoice">Invoice List</a></li>
                    @if (in_array('15',session()->get('module')))
                        <li><a href="/Cashier/saleSummaryReport">Sale Summary Report</a></li>
                        <li><a href="/Cashier/saleReport">Sale Report</a></li>
                        <!-- <li><a href="/Cashier/saleSummaryDetailReport">Category Sale Summary Detail Report</a></li> -->
                        <li><a href="/Cashier/itemReport">Best-selling Item Report</a></li>
                        <li><a href="/Cashier/favourite_set_menus">Best-selling Set Report</a></li>
                        <li><a href="/Cashier/memberFavaourite/0">Member Favourite Food Report</a></li>
                    @endif
                    </ul>
                </li>
                @endif

                @if (in_array('23',session()->get('module')))
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Log<span class="caret"></span></a>
                       <ul class="dropdown-menu">
                            <li><a href="/Cashier/Pricehistory/all">Price Histories</a></li>
                            <li><a href="/Cashier/Confighistory">Config Histories</a></li>
                            <li><a href="/Cashier/Discounthistory">Discount Histories</a></li>
                            <li><a href="/Cashier/SyncApi">Api List</a></li>
                       </ul>
                </li>
                @endif
            </ul>
        </div>
    
    </div>
  
</nav>

