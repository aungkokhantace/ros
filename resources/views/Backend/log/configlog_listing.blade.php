@extends('Backend/layouts.master')
@section('title','Config Log Histories')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
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
                                <th width="2%">Tax</th>
                                <th width="3%">Service</th>
                                <th width="10%">Room Charge</th>
                                <th width="10%">Warning Time</th>
                                <th width="10%">Waiting Time</th>
                                <th >Restaurant Name</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Update By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($configs as $config)
                                <tr>
                                    <td>{{ $config->tax }}</td>
                                    <td>{{ $config->service }}</td>
                                    <td>{{ $config->room_charge }}</td>
                                    <td>{{ $config->booking_warning_time }}</td>
                                    <td>{{ $config->booking_waiting_time }}</td>
                                    <td>{{ $config->restaurant_name }}</td>
                                    <td>{{ $config->email }}</td>
                                    <td>{{ $config->website }}</td>
                                    <td>{{ $config->phone }}</td>
                                    <td>{{ $config->address }}</td>
                                    <td>{{ $config->users->user_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
