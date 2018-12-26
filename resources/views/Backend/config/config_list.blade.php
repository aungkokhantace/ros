@extends('Backend.layouts.master')
@section('title','Category')
@section('content')
<style>
tfoot {
     display: table-header-group;
}
</style>
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Config Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
       </div>
   
                <div class="col-md-9 pull-right">
                    <div class=" buttons">
                        {{--create button--}}
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="config_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>

                        {{--edit button--}}
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="configEdit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>

                        {{--delete button--}}
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="configDelete();">
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
                <div class="col-md-12 tbl-container table-responsive">
                    <div class="col-md-12"></div>
                    <table class="table table-striped list-table" id="category_list">
                        <thead class="thead_product">

                            <tr class="active">
                                <th> <input type='checkbox' name='check' id='check_all'/></th>
                                <th>No</th>
                                <th>Restaurant Name</th>
                                <th>Tax</th>
                                <th>Service</th>
                                <th>Room Charge</th>
                                <th>Booking Warning Time</th>
                                <th>Booking Waiting Time</th>
                                <th>Booking Service Time</th>
                            </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="category_name">Name</th>
                            <th class="search-col" con-id="tax">Tax</th>
                            <th class="search-col" con-id="service">Service</th>
                            <th class="search-col" con-id="charge">Charge</th>
                            <th class="search-col" con-id="warning_time">Warning Time</th>
                            <th class="search-col" con-id="wait_time">Waiting Time</th>
                            <th class="search-col" con-id="service_time">Service Time</th>
                        </tr>
                    </tfoot>
                        <tbody>
                            @foreach($configs as $config)
                            <tr>
                                <th><input type="checkbox" name="config-check" class="source" value="{{ $config->id }}" id="all"></th>
                                <th></th>
                                <th><a href="/Backend/Config/edit/{{$config->id}}"> {{$config->restaurant->name}}</a></th>
                                <td>{{$config->tax}}</td>
                                <td>{{$config->service}}</td>
                                <td>{{$config->room_charge}}</td>
                                <td>{{$config->booking_warning_time}}</td>
                                <td>{{$config->booking_waiting_time}}</td>
                                <td>{{$config->booking_service_time}}</td>

                                </tr>
                            @endforeach
                       
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
<script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            $('#category_list tfoot th.search-col').each( function () {
                var title = $('#category_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            
            var table = $('#category_list').DataTable({
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
            table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
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
@endsection
