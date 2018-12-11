@extends('Backend.layouts.master')
@section('title','remark Listing')
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
                    <h3 class="h3 list-heading-align"><strong>Remark Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
                <div class="col-md-9 pull-right">
                    <div class="buttons">
                 <!--    <input type="image" class="img_btn" src="../../../assets/images/enable.png" onclick="remark_enable();">
                        <input type="image" class="img_btn" src="../../../assets/images/disable.png" onclick="remark_disable();"> -->

                        <button type="button"  onclick='remark_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='remark_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="remark_delete();" class="btn btn-default btn-md third_btn">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 tbl-container">
                    <div class="col-md-12"></div>
                    <table id="remark_list" class="table table-striped list-table">
                        <thead>
                        <tr class="active">
                            <th><input type="checkbox" id="remark_check_all"></th>
                            <th>No</th>
                            <th>Name</th>
                            <!-- <th>Status</th> -->
                            <th>Description</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="search-col" con-id="name">Name</th>
                            <!-- <th class="search-col" con-id="status">Status</th> -->
                            <th class="search-col" con-id="description">Description</th>

                        </tr>
                    </tfoot>
                        <tbody>

                        @foreach($remarks as $remark)
                            <tr class="active">
                                <td> <input class="remark_source" type="checkbox" name="remark_check" value="{{ $remark->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Backend/Remark/edit/{{$remark->id}}">{{ $remark->name}}</a></td>
                                {{-- <td>@if($remark->status ==1) Available @else Not Available @endif</td> --}}
                                <td>{{ $remark->description }}</td>

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

            $('#remark_list tfoot th.search-col').each( function () {
                var title = $('#remark_list thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );

            var table = $('#remark_list').DataTable({
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
