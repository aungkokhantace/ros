<table class="table table-striped " id="invoice">
    <thead>
        <tr>
            <th><label>Order No</label></th>
            <th><label>Total Amount</label></th>
            <th><label>Date</label></th>
            <th><label>View Detail</label></th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
                
                <tr >
                    <td> {{$order->id}} </td>
                    <td> {{$order->all_total_amount}} </td>
                    <td > {{$order->created_at }} </td>
                    <td ><a href="/Cashier/invoice/detail/{{$order->id}}">View Detail </a></td>
                                        
                </tr>
        @endforeach

    </tbody>
</table>