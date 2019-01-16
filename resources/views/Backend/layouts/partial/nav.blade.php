
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>

          <a href="/Backend/Dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">

            </span>
          </a>

        </li>
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
            <li><a href="/Backend/StaffType/index"><i class="fa fa-circle-o text-aqua"></i>  Staff Type</a></li>
            <li><a href="/Backend/Staff/index"><i class="fa fa-circle-o text-aqua"></i>  Staff</a></li>
          </ul>
        </li>
        <li>
        <a href="/Backend/Kitchen/index">
            <i class="fa fa-cutlery"></i>
            <span>Kitchen</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
           <i class="fa fa-plus-square-o"></i><span>Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/Backend/Category/index"><i class="fa fa-circle-o text-aqua"></i>  Category </a></li>
            <li><a href="/Backend/Remark/index"><i class="fa fa-circle-o text-aqua"></i> </i> Remark</a></li>
            <li><a href="/Backend/Item/index"><i class="fa fa-circle-o text-aqua"></i>  Items</a></li>
            <li><a href="/Backend/Continent/index"><i class="fa fa-circle-o text-aqua"></i> </i> Continent</a></li>
            <li><a href="/Backend/AddOn/index"><i class="fa fa-circle-o text-aqua"></i>  Add On</a></li>
            <li><a href="/Backend/SetMenu/index"><i class="fa fa-circle-o text-aqua"></i> </i> Set Menu</a></li>

          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-bag"></i> <span>Service</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/Backend/Table/index"><i class="fa fa-circle-o text-aqua"></i>  Table </a></li>
            <li><a href="/Backend/Room/index"><i class="fa fa-circle-o text-aqua"></i>  Room</a></li>
            <li><a href="/Backend/Location/index"><i class="fa fa-circle-o text-aqua"></i>  Location</a></li>
          </ul>
        </li>
       <li class="treeview">
          <a href="#">
            <i class="fa fa-share-alt-square"></i> <span>General</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/Backend/Config/general_config"><i class="fa fa-circle-o text-aqua"></i>  Configuration </a></li>
            <li><a href="/Backend/Discount/index"><i class="fa fa-circle-o text-aqua"></i>  Discount</a></li>
            <li><a href="/Backend/Booking/index"><i class="fa fa-circle-o text-aqua"></i>  Reservation</a></li>
            <li><a href="/Backend/invoice"><i class="fa fa-circle-o text-aqua"></i>  Invoice List</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
           <i class="fa fa-file-excel-o"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/Backend/saleSummaryReport"><i class="fa fa-circle-o text-aqua"></i>  Sale Summary Report</a></li>
            <li><a href="/Backend/saleReport"><i class="fa fa-circle-o text-aqua"></i>  Sale Report</a></li>
            <li><a href="/Backend/itemReport"><i class="fa fa-circle-o text-aqua"></i>  Best Selling Item Report</a></li>
            <li><a href="/Backend/favourite_set_menus"><i class="fa fa-circle-o text-aqua"></i>  Best Selling Set Report</a></li>
            <li><a href="/Backend/categorySaleReport"><i class="fa fa-circle-o text-aqua"></i>  Category Sale Report </a></li>
            <li><a href="/Backend/table-sale-report"><i class="fa fa-circle-o text-aqua"></i>  Sale Report By Table  </a></li>
          </ul>
        </li>


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
        @if (Auth::guard('Cashier')->user()->role_id == 1)
          <li>
              <a href="{{ url('Backend/activity-log/index') }}">
                <i class="fa fa-cog"></i>
                <span>Activity Log</span>
              </a>
          </li>
        @endif
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
