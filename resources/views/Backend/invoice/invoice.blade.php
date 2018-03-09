<table class="table table-striped " id="invoice">
    <thead class="thead_report">
        <tr>
            <th><label>Order No</label></th>
            <th><label>Total Amount</label></th>
            <th><label>Date</label></th>
            <th><label>View Detail</label></th>
            <th><label>Status</label></th>
            <th><label>Action</label></th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
                <tr class="tr-{{$order->id}}">
                    <td id="ordere-id"> {{$order->id}} </td>
                    <td> {{$order->all_total_amount}} </td>
                    <td > {{$order->created_at }} </td>
                    <td ><a href="/Backend/invoice/detail/{{$order->id}}">View Detail </a></td>
                    <td ><a href="/Backend/invoice/paid/{{$order->id}}">
                            @if($order->status == 2)
                                {{ 'Paid' }}
                            @else
                                {{ 'To Pay' }}
                            @endif
                        </a>
                    </td>
                    <td>
                    @if($order->status == 2)
                        <button type="button"  class="btn btn-success btn-print" id = '{{$order->id}}' data-toggle="modal" data-target="#printModal" data-id="{{$order->id}}" onclick="printInvoice('{{$order->id}}')">Print</button> 
                    @else
                        <button type="submit" class="btn btn-danger order-cancel" id = '{{$order->id}}' data-toggle="modal" data-target="#myModal" data-id="{{$order->id}}">Cancel</button>
                    @endif
                    </td>
                </tr>
        @endforeach
       
    
    </tbody>

</table>
<div class="text-center">{{ $orderRepo->links() }}</div>

