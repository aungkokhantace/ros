<table class="table table-striped bookingListing" id="example1">
    <thead>
        <tr>
            <th><input type='checkbox' name='booking-check' id='check_all'/></th>
            <th><label>No</label></th>
            <th><label>Name</label></th>
            <th><label>Date</label></th>
            <th><label>From Time</label></th>
            <th><label>To Time</label></th>
            <th><label>Table/Room</label></th>
            <th><label>Capacity</label></th>
            <th><label>Phone</label></th>
            
        </tr>
    </thead>
    <tbody>
       @if(isset($bookings))
        @foreach($bookings as $booking)
            @if(in_array($booking->id,$waiting))
                <tr >
            @else
                <tr class="active">
            @endif
                    <td><input class="source" type="checkbox" name="booking-check" value="{{$booking->id}}" id="all"></td>
                    <td></td>
                    <td ><a href="/Cashier/Booking/edit/{{$booking->id}}">{{$booking->customer_name}}</a></td>
                    <td >{{$booking->booking_date }}</td>
                    <td >{{Carbon\Carbon::parse($booking->from_time)->format('h:i A')}}</td>
                    <td >{{Carbon\Carbon::parse($booking->to_time)->format('h:i A')}}</td>
                    <td >
                    @if(isset($booking->booking_table))
                       @foreach($booking->booking_table as $t)
                            @foreach($table as $result)
                            
                                @if($t->table_id == $result->id)
                                    {{ $result->table_no }},
                                @endif
                            @endforeach
                        @endforeach  
                    @endif
                    @if(isset($booking->booking_room))
                        @foreach($booking->booking_room as $r)
                            @foreach($room as $result)
                                @if($r->room_id == $result->id)
                                    {{ $result->room_name }}
                                @endif
                            @endforeach
                        @endforeach
                    @endif    
                    </td>
                    <td class="black-text">{{$booking->capacity}}</td>
                    <td class="black-text">{{$booking->phone}}</td>
                    
                </tr>
        @endforeach
        @endif 
    </tbody>
</table>