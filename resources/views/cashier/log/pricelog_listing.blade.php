@extends('cashier/layouts.master')
@section('title','Price Log Histories')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Price Log Histories</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>

        </div>

    </div>
    {{--three btns--}}
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <div class="col-md-12"></div>
                <table class="table table-striped list-table" id="example2">
                    <thead>
                        <tr class="active">
                            {{--listing--}}
                            <th>Type</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Old Price</th>
                            <th>New Price</th>
                            <th>Action</th>
                            <th>Created By</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pricehistories as $pricehistory)
                            <tr>
                                <td>{{ $pricehistory->table_name }}</td>
                                <td>{{ $pricehistory->table_id }}</td>
                                <td>{{ $pricehistory->setup_name }}</td>
                                <td>{{ $pricehistory->old_price }}</td>
                                <td>{{ $pricehistory->new_price }}</td>
                                <td>{{ $pricehistory->action }}</td>
                                <td>{{ $pricehistory->created_by }}</td>
                                <td>{{ $pricehistory->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


<script>
    $(document).ready(function(){
        var t = $('#example2').DataTable( {
            "ordering":false,
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]]
        } );
    })
</script>

@endsection
