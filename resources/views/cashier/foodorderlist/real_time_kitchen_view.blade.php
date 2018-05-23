@if(isset($groupedOrders) && count($groupedOrders) > 0)
    @foreach($groupedOrders as $group)  
        @if($group['status'] == 1)
        <div class="col-md-3 mg-20">   
            <div class="order-status">
            @if($group['order_id'])
                <p class="order-num"><span>Order No. </span><span>{{ $group['order_id']}}</span></p>
            @endif
                <div class="ordernum-list"> 
                    <button class="btn fd-taken ajax_request" id="{{$group['order_id']}}/4" type="button" {{ $group['count_taken'] > 0 ? "" : "disabled" }}>{{$group['count_taken']}}</button>
                    <button class="btn fd-cooked ajax_request" id="{{$group['order_id']}}/3" type="button" {{ $group['count_cooked'] > 0 ? "" : "disabled" }}>{{$group['count_cooked']}}</button>
                    <button class="btn fd-cooking ajax_request" id="{{$group['order_id']}}/2" type="button" {{ $group['count_cooking'] > 0 ? "" : "disabled" }}>{{$group['count_cooking']}}</button>
                    <button class="btn fd-notyet ajax_request" id="{{$group['order_id']}}/1" type="button" {{ $group['count_start'] > 0 ? "" : "disabled" }}>{{$group['count_start']}}</button>
                </div> 
                @if($group['order_id'])
                <p class="table-num">
                    @if($group['take_id'] == 1)
                        Take Away
                    @endif

                    @if(isset($tables))
                        @foreach($tables as $table)
                            @if($table->order_id == $group['order_id'])
                               {{ $table->table_no }}
                            @endif
                        @endforeach
                    @endif

                    @if(isset($rooms))
                        @foreach($rooms as $room)
                            @if($room->order_id == $group['order_id'])
                                {{ $room->room_name }}
                            @endif
                        @endforeach
                    @endif
                </p> 
                @endif
            </div>
        </div>
        @endif  
    @endforeach
@endif