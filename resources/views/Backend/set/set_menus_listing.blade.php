@extends('Backend.layouts.master')
@section('title','Set menu Listing')
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
                    <h3 class="h3 list-heading-align"><strong>Set Menu Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
       
                <div class="col-md-9 pull-right">
                    <div class=" buttons">
                        <button type="button"  onclick='set_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='sub_menus_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="sub_menus_delete();" class="btn btn-default btn-md third_btn">
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
                    <table id="sub_menu_list" class="table table-striped list-table">

                        <thead>
                        <tr class="active">
                            <th><input type='checkbox' name='check_all' id='check_all'  onclick="check(value);" /> </th>
                            <th>No</th>
                            <th>Set menu Name</th>
                            <th>Items</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Branch</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="set_menu_name">Set Menu Name</th>
                            <th class="search-col" con-id="item">Items</th>
                            <th class="search-col" con-id="price">Price</th>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="branch">Branch</th>
                        </tr>
                    </tfoot>
                        <tbody>

                        @foreach($set_menu as $set)
                            <tr class="active">
                                <input type="hidden" value="{{$set->id}}">
                                <td> <input class="source" type="checkbox" name="sub_check" value="{{ $set->id }}" id="check" />

                                </td>
                                <td></td>
                                <td><a href="/Backend/SetMenu/edit/{{$set->id}}">{{ $set->set_menus_name }}</a> </td>
                                <td>
                                    @foreach($set->set_item as $sitem)
                                        @foreach($items as $item)
                                            @if($sitem->item_id == $item->id)
                                                {{ $item->name }},
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>{{ $set->set_menus_price}}</td>
                                <td>{{ $set->image }}</td>
                                <td>
                                    @if( $set->status==0)
                                        {{"Not Available"}}
                                    @else
                                        {{"Available"}}
                                    @endif
                                </td>
                                <td>{{$set->branch->name}}</td>
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

            $('#sub_menu_list tfoot th.search-col').each( function () {
                var title = $('#sub_menu_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            
            var table = $('#sub_menu_list').DataTable({
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
