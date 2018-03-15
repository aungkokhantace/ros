





<!-- Start Footer -->
<footer class="main-footer">
<div class="pull-right hidden-xs">
  <b>Version</b> 2.4.0
</div>
<div class="col-md-6">
<strong> <p class="footer-status ">&copy;Copyright 2017.All rights reserved by <a href="http://www.aceplussolutions.com/">AcePlus Solutions.,Co Ltd</a></p></strong>
</div>
</footer>
<a href="#" class="scrollToTop btn btn-icon btn-circle "><i class="fa fa-angle-double-up"></i></a>
<!-- End Footer -->

<script>
    $(document).ready(function() {
        

      //for scroll to top
            $(window).scroll(function(){
              if($(this).scrollTop() > 100){
                 $('.scrollToTop').fadeIn();
              } else {
            $('.scrollToTop').fadeOut();
             }
           });

          //Click event to scroll to top
         $('.scrollToTop').click(function(){
         $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    });
</script> 


<script>


    function addNotification(title, text){
        $.gritter.add({
            title: title,
            text: text,
            time: 2000
        });
        return false;
    };
    


 
       
    $(document).ready(function(){

        var t = $('#example1').DataTable( {
            "ordering":false,
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]]
        } );

        t.on( 'order.dt search.dt', function () {
            t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw(); 

        $('#invoice').DataTable( {
            "ordering":false,
            "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
            } ],
           "paging":   false,
           "info":     false,
            "order": [[ 1, 'asc' ]]
        } );






        if($('input[name="view"]:checked', '#view_by_radio').val()=="daily"){
            $('.daily').show();
            $('.monthly').hide();
            $('.yearly').hide();
        }
        else if($('input[name="view"]:checked', '#view_by_radio').val()=="monthly"){
            $('.daily').hide();
            $('.monthly').show();
            $('.yearly').hide();
        }
        else{
            $('.daily').hide();
            $('.monthly').hide();
            $('.yearly').show();
        }

        $('#view_by_radio input[type=radio][name="view"]').on('change', function() {
        if($('input[name="view"]:checked', '#view_by_radio').val()=="daily"){
            var data = $('input[name="view"]:checked', '#view_by_radio').val();
            $('.daily').show();
            $('.monthly').hide();
            $('.yearly').hide();
            window.location.href = '/Backend/saleSummaryDetailReport/'+ data;
        }
        else if($('input[name="view"]:checked', '#view_by_radio').val()=="monthly"){
            var data = $('input[name="view"]:checked', '#view_by_radio').val();
            $('.daily').hide();
            $('.monthly').show();
            $('.yearly').hide();
            
            window.location.href = '/Backend/saleSummaryDetailReport/' + data;
        }
        else{
            var data = $('input[name="view"]:checked', '#view_by_radio').val();
            $('.daily').hide();
            $('.monthly').hide();
            $('.yearly').show();
            console.log(data);
            window.location.href = '/Backend/saleSummaryDetailReport/' + data;
        }
    });

        $('#sale_summary input[type=radio][name="sale"]').on('change', function() {
        if($('input[name="sale"]:checked', '#sale_summary').val()=="daily"){
            var data = $('input[name="sale"]:checked', '#sale_summary').val();

            window.location.href = '/Backend/saleSummaryReport/'+ data;
        }else if($('input[name="sale"]:checked', '#sale_summary').val()=="monthly"){
            var data = $('input[name="sale"]:checked', '#sale_summary').val();

            window.location.href = '/Backend/saleSummaryReport/'+ data;
        }else{
            var data = $('input[name="sale"]:checked', '#sale_summary').val();

            window.location.href = '/Backend/saleSummaryReport/'+ data;
        }
    });
    });
</script>
<script src="/assets/backend_js/multi-row.js"></script>

</body>
