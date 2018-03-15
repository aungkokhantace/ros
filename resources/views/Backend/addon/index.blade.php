@extends('Backend/layouts.master')
@section('title','Add-on Listing')
@section('content')
<style>
 .add_on_scroll{
    overflow: auto;
    white-space: nowrap;
    
 }
tfoot {
     display: table-header-group;
}
</style>
      <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Add-on Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>

            </div>
        
                <div class="col-md-9 pull-right">
                    <div class="buttons">
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="extra_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="extra_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="extra_delete();">
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
            <div class="col-md-12 add_on_scroll">
                <div class="col-md-12"></div>
                <table class="table table-striped list-table" id="add_on_list" cellspacing="0">
                    <thead>
                        <tr class="active">
                            <th><input type='checkbox' name='check_all' id='check_all'  onclick="check(value);" />  </th>
                            <th>No</th>
                            <th>Add-on Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>image</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="module_name">Module Name</th>
                            <th class="search-col" con-id="add-on_name">Add On Name</th>
                            <th class="search-col" con-id="category">Category</th>
                            <th></th>
                            <th class="search-col" con-id="price">Price</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @foreach($ex as $extras)
                        <tr class="active">
                            <input type="hidden" value="{{$extras->id}}">

                            <td> <input class="source" type="checkbox" name="extra_check" value="{{ $extras->id }}" id="check" />

                            </td>
                            <td></td>
                            <td><a href="/Backend/AddOn/edit/{{$extras->id}}">{{ $extras->food_name }}</a></td>
                            <td>  @foreach($category as $cat)
                                    <?php
                                    if($cat->id == $extras->category_id)
                                    {
                                        echo $cat->name;
                                    }
                                    ?>
                                @endforeach
                            </td>
                            <td>{{ $extras->description }}</td>
                            <td>{{ $extras->image }}</td>
                            <td>{{ $extras->price }}</td>
                            <td>
                            @if( $extras->status==0)
                                {{"Not Available"}}
                                @else
                               {{"Available"}}
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
</div>
</div>


<script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            $('#add_on_list tfoot th.search-col').each( function () {
                var title = $('#add_on_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            
            var table = $('#add_on_list').DataTable({
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
