@extends('Backend.layouts.master')
@section('title','Item Listing')
@section('content')
<style>
.item_scroll{
    overflow: auto;
    white-space: nowrap;

 }
tfoot {
     display: table-header-group;
}
#item_list {
    width: 100% !important;
}
#item_list_paginate ul:first-child li {
    margin-left: -16px !important;
}

</style>
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--Start heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Item Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>


                {{--End heading title--}}
                <div class="col-md-9 pull-right">
                    <div class="buttons">
                        <input type="image" class="img_btn" src="../../../assets/images/enable.png" onclick="enable();">
                        <input type="image" class="img_btn" src="../../../assets/images/disable.png" onclick="disable();">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="item_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md second_btn" onclick="item_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md third_btn" onclick="item_delete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--End Buttons--}}
    </div>
        {{--Start table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-12 tbl-container item_scroll">
                    <div class="col-md-12"></div>
                    <table id="item_list" class="table table-striped list-table ">
                        <thead>

                        <tr class="active">

                            <th> <input type='checkbox' name='check' id='check_all'/></th>
                            <th>No</th>
                            <th>Item Name</th>
                            <th>Item Category</th>
                            <!-- <th>Item Image</th> -->
                            <th>Item Description</th>
                            <th>Item Price</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="item_name">Name</th>
                            <th class="search-col" con-id="item_category">Category</th>
                            <!-- <th></th> -->
                            <th class="search-col" con-id="item_description">Description</th>
                            <th class="search-col" con-id="item_price">Price</th>
                            <th></th>
                        </tr>
                      </tfoot>
                        <tbody>
                        @foreach($items as $item)
                            @if ($item->group_id == '' || $item->isdefault == 1)
                            <tr class="active">
                                <td>
                                    <input type="checkbox" class="source" name="check_item" value="{{$item->id}}">
                                </td>
                                <td></td>
                                <td><a href="/Backend/Item/edit/{{$item->id}}">{{ $item->name}}</a></td>
                                <td>{{ $item->category->name}}</td>
                                {{--<td>{{ $item->image}}</td>--}}
                                <td>{{ $item->description}}</td>
                                <td>{{ $item->price}}</td>
                                <td>
                                    @if($item->status == 1)
                                        {{'Available'}}
                                    @else
                                        {{'Not Available'}}
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            $('#item_list tfoot th.search-col').each( function () {
                var title = $('#item_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );

            var table = $('#item_list').DataTable({
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
