<!-- Start Footer -->
<div id="footer">
    <p class="footer-status">&copy;Copyright 2017.All rights reserved by <a href="http://www.aceplussolutions.com/">
            AcePlus Solutions.,Co Ltd</a></p>
    <p class="text-danger text-right">Git Version {!! gitVersion() !!}</p>
</div>
<!-- End Footer -->
{{--<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/js/datatables/dataTables.bootstrap.js"></script>
<script src="/assets/js/multiple-select.js"></script>
<script src="/assets/js/crud.js"></script>
<script src="/assets/js/validation/jquery.validate.js"></script>
<script src="/assets/js/validation/validation.js"></script>
<script src="/assets/js/checkbox.js"></script>
<script src="/assets/js/checkall.js"></script>
<script src="/assets/js/enabled-disabled.js"></script>
<script src="/assets/js/custom-datepicker.js"></script>
<script src="/assets/js/sweetalert-dev.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/custom.min.js"></script>
<script src="/assets/js/fileupload.js"></script>
<script src="/assets/js/downloadexcel_redirect.js"></script>
<script src="/assets/js/jktCuteDropdown.min.js"></script>
<script src="/assets/js/combodate.js"></script>
<script src="/assets/js/amcharts.min.js"></script>
<script src="/assets/js/serial.min.js"></script>
<script src="/assets/js/light.min.js"></script>
<script src="/assets/js/booking_validation.js"></script>

<script>
    function addNotification(title, text){
        $.gritter.add({
            title: title,
            text: text,
            time: 3000
        });
        return false;
    };
    $(document).ready(function(){
        var t = $('#example1').DataTable( {
            "ordering":true,
            "columnDefs": [ {
                "searchable": true,
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
        // $('#example1').DataTable();
        $('#invoice').DataTable({
            "ordering":false,
            "columnDefs": [ {
                "searchable": true,
                "orderable": false,
                "targets": 0
            } ],
        } );

        $('#unpaid-invoice').DataTable({
            "bFilter": false,
            "bInfo": false,
            "lengthChange": false,
            "ordering":false,
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
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
            window.location.href = '/Cashier/saleSummaryDetailReport/'+ data;
        }
        else if($('input[name="view"]:checked', '#view_by_radio').val()=="monthly"){
            var data = $('input[name="view"]:checked', '#view_by_radio').val();
            $('.daily').hide();
            $('.monthly').show();
            $('.yearly').hide();
            
            window.location.href = '/Cashier/saleSummaryDetailReport/' + data;
        }
        else{
            var data = $('input[name="view"]:checked', '#view_by_radio').val();
            $('.daily').hide();
            $('.monthly').hide();
            $('.yearly').show();
            console.log(data);
            window.location.href = '/Cashier/saleSummaryDetailReport/' + data;
        }
    });

        $('#sale_summary input[type=radio][name="sale"]').on('change', function() {
        if($('input[name="sale"]:checked', '#sale_summary').val()=="daily"){
            var data = $('input[name="sale"]:checked', '#sale_summary').val();

            window.location.href = '/Cashier/saleSummaryReport/'+ data;
        }else if($('input[name="sale"]:checked', '#sale_summary').val()=="monthly"){
            var data = $('input[name="sale"]:checked', '#sale_summary').val();

            window.location.href = '/Cashier/saleSummaryReport/'+ data;
        }else{
            var data = $('input[name="sale"]:checked', '#sale_summary').val();

            window.location.href = '/Cashier/saleSummaryReport/'+ data;
        }
    });
    });
</script>
<script src="/assets/js/multi-row.js"></script>

</body>
