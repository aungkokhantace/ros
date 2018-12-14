<table class="table table-striped bookingListing thead_report " id="booking_list">
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
            <th><label>Branch</label></th>
            
        </tr>
    </thead>
    <tfoot>
        <tr>
           <th></th>
           <th></th>
           <th class="search-col" con-id="name">Name</th> 
           <th class="search-col" con-id="Date">Date</th>
           <th class="search-col" con-id="From_time">From Time</th>
           <th class="search-col" con-id="to_time">To Time </th>
           <th class="search-col" con-id="Table_room">Table/Room</th>
           <th class="search-col" con-id="capacity">Capacity</th>
           <th class="search-col" con-id="phone">Capacity</th>  
           <th class="search-col" con-id="branch">Branch</th>                
        </tr>
    </tfoot>
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
                    <td ><a href="/Backend/Booking/edit/{{$booking->id}}">{{$booking->customer_name}}</a></td>
                    <td >{{$booking->booking_date }}</td>
                    <td >{{Carbon\Carbon::parse($booking->from_time)->format('h:i A')}}</td>
                    <td >{{Carbon\Carbon::parse($booking->to_time)->format('h:i A')}}</td>
                    <td >
                    @if(isset($booking->booking_table))
                        @php
                            $table_name  = '';
                        @endphp

                       @foreach($booking->booking_table as $t)
                            @foreach($table as $result)
                            
                                @if($t->table_id == $result->id)
                                    @php
                                        $table_name  .= $result->table_no . ",";
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach 

                        {{ substr($table_name,0, -1) }} 
                    @endif
                    @if(isset($booking->booking_room))
                        @php
                            $room_name  = '';
                        @endphp
                        @foreach($booking->booking_room as $r)
                            @foreach($room as $result)
                                @if($r->room_id == $result->id)
                                    @php
                                        $room_name  .= $result->room_name . ",";
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach

                        {{ substr($room_name,0, -1) }}
                    @endif    
                    </td>
                    <td class="black-text">{{$booking->capacity}}</td>
                    <td class="black-text">{{$booking->phone}}</td>
                    <td class="black-text">{{$booking->branch->name}}</td>
                    
                </tr>
        @endforeach
        @endif 
    </tbody>
</table>