@extends('Backend/layouts.master')
@section('title','Permission Listing')
@section('content')
<style>
tfoot {
     display: table-header-group;
}
</style>
<div class="content-wrapper">
        <div class="box">
            <div class="box-header">
              <h3 class="h3 list-heading-align"><strong> &nbspPermission Listing</strong></h3>
                
                @if(count(Session::get('message')) != 0)
                        <div ></div>
                @endif
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body col-md-*">
              <table  id="invoice_list" class="table table-striped list-table" ">
                
                    <thead>
                    <tr class="active">
                        <th><input type='checkbox' name='check_all' id='check_all'  onclick="check(value);" />  </th>
                        <th>No</th>
                        <th>Module Name</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="module_name">Module Name</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @if(isset($modules) && count($modules) > 0)
                        @foreach($modules as $module)
                            <tr class="active">
                                <input type="hidden" value="{{$module->id}}">

                                <td> <input class="source" type="checkbox" name="module_check" value="{{ $module->id }}" id="check" />

                                </td>
                                <td></td>
                                <td>{{ $module->module }}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
   </div>
<script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            $('#invoice_list tfoot th.search-col').each( function () {
                var title = $('#invoice_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            
            var table = $('#invoice_list').DataTable({
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



   
