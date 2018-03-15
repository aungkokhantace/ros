@extends('Backend.layouts.master')
@section('title','Booking Listing')
@section('content')
<style>
tfoot {
     display: table-header-group;
     background: #ecf0f5;    
      }
.add_on_scroll{
    overflow: auto;
    white-space: nowrap;
    
               }
</style>
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#">Booking Listing</a></li>
                    <li role="presentation"><a href="/Backend/Booking/tableListView">Table View</a></li>
                    <li role="presentation"><a href="/Backend/Booking/roomListView">Room View</a></li>
                </ul>
            </div>
            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
    <div class="container">
        <div class="row">
            {{--heading title--}}

            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Booking Listing</strong></h3>
                </div>
                <div class="col-md-9">
                    <div class=" buttons">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="Booking_Form();" >
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="Booking_Edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="Booking_Delete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container add_on_scroll" id="booking-frame">
                @include('Backend.booking.bookingListing')
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
        // $('.timepicki').timepicki({
        //     increase_direction:'up'
        // });
        $('.booking_edit_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            startDate: new Date()
        });
        $(document).ready(function() {
            setInterval(ajaxCall, 300000); //300000 MS == 5 minutes
            function ajaxCall() {
                $.ajax({
                    type: 'GET',
                    url: '/Cashier/Booking/ajaxBookingRequest',
                    success: function (Response) {
                        console.log(Response);
                        $('#booking-frame').html('');
                        $('#booking-frame').append(Response);
                    }
                })
            }

           
        });
        function Booking_Form(){
            window.location='/Backend/Booking/create';
        }

        $(document).ready(function() {

            $('#booking_list tfoot th.search-col').each( function () {
                var title = $('#booking_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            
            var table = $('#booking_list').DataTable({
                aLengthMenu: [
                    [5,25, 50, 100, 200, -1],
                    [5,25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 10,
                "ordering":false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                
                "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
                } ],
                "order": [[ 2, "desc" ]],
                stateSave: false,
                "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',

            });

            table.on( 'order.dt search.dt', function () {
            table.column(1,).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw(); 
//            new $.fn.dataTable.FixedHeader( table, {
//            });


            // Apply the search
            table.columns().eq( 0 ).each( function ( colIdx ) {
                $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                    table
                            .column( colIdx )
                            .search( this.value )
                            .draw();
                } );

            });
        });
    </script>
</div>

@endsection
