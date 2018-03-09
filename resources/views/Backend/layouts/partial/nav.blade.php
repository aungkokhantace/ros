
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @if (in_array('1',session()->get('module')))
        <li>
          
          <a href="/Backend/Dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          
        </li>
         @endif
         @if (in_array('2',session()->get('module')) || in_array('3',session()->get('module')))
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Staff</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           
            <li><a href="/Backend/Permission/index"><i class="fa fa-circle-o text-aqua"></i>  Permission</a></li>
            @if (in_array('3',session()->get('module')))
            <li><a href="/Backend/StaffType/index"><i class="fa fa-circle-o text-aqua"></i>  Staff Type</a></li>
            @endif

            @if (in_array('2',session()->get('module')))
            <li><a href="/Backend/Staff/index"><i class="fa fa-circle-o text-aqua"></i>  Staff</a></li>
            @endif
            
          </ul>
        </li>
        @endif
       
         @if (in_array('18',session()->get('module')))
        <li>
        <a href="/Backend/Kitchen/index">
            <i class="fa fa-cutlery"></i>
            <span>Kitchen</span>
            
          </a>
        </li>
        @endif

        @if (in_array('4',session()->get('module')) || in_array('5',session()->get('module')) || in_array('6',session()->get('module')) || in_array('8',session()->get('module')))
        <li class="treeview">
          <a href="#">
           <i class="fa fa-plus-square-o"></i><span>Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             @if (in_array('4',session()->get('module')))
            <li><a href="/Backend/Category/index"><i class="fa fa-circle-o text-aqua"></i>  Category </a></li>
            @endif
            @if (in_array('5',session()->get('module')))
            <li><a href="/Backend/Item/index"><i class="fa fa-circle-o text-aqua"></i>  Items</a></li>
            @endif
            @if (in_array('6',session()->get('module')))
            <li><a href="/Backend/AddOn/index"><i class="fa fa-circle-o text-aqua"></i>  Add On</a></li>
            @endif

            @if (in_array('8',session()->get('module')))
            <li><a href="/Backend/SetMenu/index"><i class="fa fa-circle-o text-aqua"></i> </i> Set Menu</a></li>
            @endif
          </ul>
        </li>
        @endif
        @if (in_array('11',session()->get('module')) || in_array('12',session()->get('module')))
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-bag"></i> <span>Service</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             @if (in_array('11',session()->get('module')))
            <li><a href="/Backend/Table/index"><i class="fa fa-circle-o text-aqua"></i>  Table </a></li>
            @endif
            @if (in_array('12',session()->get('module')))
            <li><a href="/Backend/Room/index"><i class="fa fa-circle-o text-aqua"></i>  Room</a></li>
            @endif
            <li><a href="/Backend/Location/index"><i class="fa fa-circle-o text-aqua"></i>  Location</a></li>
          </ul>
        </li>
        @endif
     @if (in_array('14',session()->get('module')) || in_array('7',session()->get('module')))
       <li class="treeview">
          <a href="#">
            <i class="fa fa-share-alt-square"></i> <span>General</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if (in_array('14',session()->get('module')))
            <li><a href="/Backend/Config/general_config"><i class="fa fa-circle-o text-aqua"></i>  Configuration </a></li>
            @endif
            @if (in_array('7',session()->get('module')))
            <li><a href="/Backend/Discount/index"><i class="fa fa-circle-o text-aqua"></i>  Discount</a></li>
            @endif
          </ul>
        </li>
        @endif
       @if (in_array('17',session()->get('module')) || in_array('15',session()->get('module')) || in_array('13',session()->get('module')))
        <li class="treeview">
          <a href="#">
           <i class="fa fa-file-excel-o"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            

            @if (in_array('13',session()->get('module')))
            <li><a href="/Backend/Booking/index"><i class="fa fa-circle-o text-aqua"></i>  Reservation</a></li>
            @endif
            @if (in_array('15',session()->get('module')))
            <li><a href="/Backend/invoice"><i class="fa fa-circle-o text-aqua"></i>  Invoice List</a></li>
            @endif
            <li><a href="/Backend/saleSummaryReport"><i class="fa fa-circle-o text-aqua"></i>  Sale Summary Report</a></li>
            <li><a href="/Backend/saleReport"><i class="fa fa-circle-o text-aqua"></i>  Sale Report</a></li>
            <li><a href="/Backend/itemReport"><i class="fa fa-circle-o text-aqua"></i>  Best Selling Item report</a></li>
            <li><a href="/Backend/favourite_set_menus"><i class="fa fa-circle-o text-aqua"></i>  Best Selling Set Report</a></li>
            
          </ul>
        </li>
        @endif


        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Session</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="/Backend/Shift/index"><i class="fa fa-circle-o text-aqua"></i>  Shift</a></li>
          
          </ul>
        </li>

      @if (in_array('23',session()->get('module')))
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Log</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="/Backend/Pricehistory/all"><i class="fa fa-circle-o text-aqua"></i>  Price Histories</a></li>
            <li><a href="/Backend/Confighistory"><i class="fa fa-circle-o text-aqua"></i>  Config Histories</a></li>
            <li><a href="/Backend/Discounthistory"><i class="fa fa-circle-o text-aqua"></i>  Discount Histories</a></li>
            <li><a href="/Backend/SyncApi"><i class="fa fa-circle-o text-aqua"></i>  Api List</a></li>
          
          </ul>
        </li>
        @endif
       
        
       
        <li class="header">LABELS</li>
        <li>
        <a href="/Backend/logout">
            <i class="fa fa-circle-o text-danger"></i>
            <span>Logout</span>
            
          </a>
        </li>
      </ul>
    </section>

    <script type="text/javascript">
    $(document).ready(function() {
        //make sidebar active current tab when a page is selected
        var path = window.location.pathname;
        var submenu = '.treeview-menu li';
        var hassub = '.treeview';

        $(hassub).removeClass('active');
        $(submenu).removeClass('active');
          
        $(".treeview-menu li a").each(function () {
            var href = $(this).attr('href');
            // var child_href = href+'/';
            var child_href = href.replace('index','');
            
            //check for child hrefs also (eg. room and room/create)
            if (path == href || path.includes(child_href)) {

            // if (path.includes(href)) {
                $(this).closest('li').addClass('active');
                $(this).closest('.treeview').addClass('active');
                $(this).parents(".treeview:eq(1)").toggleClass("active");
            }
        });
    });
</script>
  </aside>