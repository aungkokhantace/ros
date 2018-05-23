@extends('Backend.layouts.master')
@section('title','Table Listing')
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
                    <h3 class="h3 list-heading-align"><strong>Table Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
        
                <div class="col-md-9 pull-right">
                    <div class=" buttons">
                        <input type="image" class="img_btn" src="../../../assets/images/enable.png" onclick="table_active();">
                        <input class="img_btn" src="../../../assets/images/disable.png" onclick="table_disable();" type="image">
                        <button type="button"  onclick='table_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='table_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="table_delete();" class="btn btn-default btn-md third_btn">
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
                <div class="col-md-12 tbl-container">
                    
                    <table id="table_list" class="table table-striped list-table">

                        <thead>
                            <tr class="active">
                                <th><input type="checkbox" id="table_check_all"></th>
                                <th>No</th>
                                <th>Table Name</th>
                                <th>Table Capacity</th>
                                <th>Area</th>
                                <th>Table Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="tablel_name">Table Name</th>
                            <th class="search-col" con-id="table_capacity">Table Capacity</th>
                            <th class="search-col" con-id="area">Area</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                        <tbody>

                        @foreach($tables as $table)

                            <tr class="active">
                                <td> <input class="table_source" type="checkbox" name="table_check" value="{{ $table->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Backend/Table/edit/{{$table->id}}">{{ $table->table_no }}</a></td>
                                <td>{{ $table->capacity }}</td>
                                <td>{{$table->area}}</td>
                                <td>
                                    @if($table->status == 0) 
                                        {{"Available"}}
                                    @else
                                        {{"Serve"}}
                                    @endif
                                </td>
                                <td>
                                @if($table->active == 1)
                                {{ "Enable" }}
                                @else 
                                {{ "Disable"}}
                                @endif
                                </td>
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

            $('#table_list tfoot th.search-col').each( function () {
                var title = $('#table_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            
            var table = $('#table_list').DataTable({
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
@endsection
