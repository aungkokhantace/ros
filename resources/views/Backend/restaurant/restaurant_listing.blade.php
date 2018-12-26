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
                    <h3 class="h3 list-heading-align"><strong>Restaurant Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
       </div>
   
                <div class="col-md-9 pull-right">
                    <div class=" buttons">
                        {{--create button--}}
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="restaurant_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>

                        {{--edit button--}}
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="restaurantEdit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>

                        {{--delete button--}}
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="restaurantDelete();">
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
                                <th></th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Website</th>
                                <th>Address</th>
                               
                            </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="category_name">Name</th>                            
                            <th class="search-col" con-id="phone">Phone</th>
                            <th class="search-col" con-id="website">Website</th>
                            <th class="search-col" con-id="address">Address</th>                           
                        </tr>
                    </tfoot>
                        <tbody>
                        @foreach($restaurants as $restaurant)
                                <tr class="active">
                                    <td><input type="checkbox" name="restaurant-check" class="source" value="{{ $restaurant->id }}" id="all"></td>
                                    <td></td>
                                    <td><a href="/Backend/Restaurant/edit/{{$restaurant->id}}">{{ $restaurant->name }}</a></td>                                    
                                    <td>{{ $restaurant->phone }}</td>
                                    <td>{{ $restaurant->website }}</td>
                                    <td>{{$restaurant->address}}</td>                                    
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
