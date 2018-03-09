



<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
       
        <li  @if(Request::path() == 'Kitchen/kitchen')class="active" @endif>
          
          <a href="/Kitchen/kitchen">
            <i class="fa fa-sliders"></i> <span>Table View</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          
        </li>
        <li  @if(Request::path() == 'Kitchen/productView') class="active" @endif>
          
          <a href="/Kitchen/productView">
           <i class="fa fa-suitcase"></i> <span>Product View</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          
        </li>


        <li>
          
          <a href="/Backend/updateDataBeforeLogout">
           <i class="fa fa-circle-o text-danger"></i> <span>Logout</span>
            <span class="pull-right-container">
              
            </span>
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


