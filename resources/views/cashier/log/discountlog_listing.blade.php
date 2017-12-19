@extends('cashier/layouts.master')
@section('title','Config Log Histories')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Config Log Histories</strong></h3>
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
                <div class="table-responsive">
                    <table class="table table-striped list-table" id="example2" style="min-width:1600px;">
                        <thead>
                            <tr class="active">
                                {{--listing--}}
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th >Item</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Deleted By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Deleted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->name }}</td>
                                    <td>{{ $discount->amount }}</td>
                                    <td>{{ $discount->type }}</td>
                                    <td>{{ $discount->start_date }}</td>
                                    <td>{{ $discount->end_date }}</td>
                                    <td>{{ $discount->item->name }}</td>
                                    <td>
                                    @if ($discount->created_by > 0)
                                        {{ $discount->created_user->user_name }}
                                    @else
                                    -
                                    @endif
                                    </td>
                                    <td>
                                    @if ($discount->updated_by > 0)
                                        {{ $discount->updated_user->user_name }}
                                    @else
                                    -
                                    @endif
                                    </td>
                                    <td>
                                    @if ($discount->deleted_by > 0)
                                        {{ $discount->deleted_user->user_name }}
                                    @else
                                    -
                                    @endif
                                    </td>
                                    <td>
                                    @if ($discount->deleted_by > 0)
                                        {{ $discount->created_at }}
                                    @else
                                    -
                                    @endif
                                    </td>
                                    <td>
                                    @if ($discount->deleted_by > 0)
                                        {{ $discount->updated_at }}
                                    @else
                                    -
                                    @endif
                                    </td>
                                    <td>
                                    @if ($discount->deleted_by > 0)
                                        {{ $discount->deleted_at }}
                                    @else
                                    -
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