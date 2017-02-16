<div class="col-md-12 tbl-container">
@foreach($orders as $orderKey=>$orderValue)
@if(isset($orderValue->items) && count($orderValue->items) > 0)
<table class="table table-bordered" >
    <thead class="header">
        <tr>
            <td class="tdname">
                @if($orderKey)
                    @if($orderValue->take_id != 0)
                        <h4>Take Away </h4>
                    @endif

                    @if(isset($tables))
                        @foreach($tables as $table)
                            @if($table->order_id == $orderKey)
                                <h4> {{ $table->table_no }} </h4>
                            @endif
                        @endforeach
                    @endif

                    @if(isset($rooms))
                        @foreach($rooms as $room)
                            @if($room->order_id == $orderKey)
                                <h4> {{ $room->room_name }} </h4>
                            @endif
                        @endforeach
                    @endif
                @endif
            </td>
        </tr>
        <tr class="tr_header">
            <td>Product Name</td>
            <td>Order Type</td>
            <td>Quantity</td>
            <td>Exception</td>
            <td>Remark</td>
            <td>Add On</td>
            <td>StartTime</td>
            <td>OrderTime</td>
            <td>CookingTime</td>
            <td>Order Status</td>
            <td>Cancel</td>
        </tr>
    </thead>
    <tbody class="body">
        @foreach($orderValue->items as $key => $item)
            <tr class="tr-row"  data-ordertime = "{{ $item->order_time }}">
                <td>
                    {{ $item->name }} 
                    @if($item->setmenu_id != '0')
                        {{ "(SetMenu)" }}
                    @endif</td>
                <td>
                    @if($item->order_type_id == '1')
                       
                        {{ "Eat" }}
                    @else
                        
                        {{ "Parcel"}}
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->exception }}</td>
                <td>{{ $item->remark}}</td>
                <td>
                    @foreach($extra as $ex)
                        @if($ex->order_detail_id == $item->id)
                            {{ $ex->food_name }},
                        @endif
                    @endforeach
                </td>
                <td class="td-row" data-ordertime = "{{ $item->order_time }}">
                    {{ date('h:m:s A', strtotime($item->order_time)) }}
                </td>
                <td>
                    @if($item->status_id == '1')
                        <span class="duration"></span>
                        <input type="hidden" name="duration" class="txt_duration" />
                    @endif
                    @if($item->status_id =='2')
                        {{ date('h:m:s A', strtotime($item->order_duration)) }}
                    @endif
                </td>
                <td>
                    @if($item->status_id =='2')
                        <input type="hidden" name="order_duration" value="{{ $item->order_duration }}" />
                        <span class="cooking_duration"></span>
                                    
                        <input type="hidden" name="duration" class="txt_cooking_duration" />
                    @endif
                </td>
                       
                <td>
                    @if($item->status_id == '1')
                        <input type="submit" class="start btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" name="start" value="Cooking">
                    @endif
                    @if($item->status_id =='2')
                        <input type="submit" class="complete btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" name="complete" value="Cooked">
                    @endif
                </td>
                @if($item->status_id == '1')
                <td>
                    <input type="button" class="cancel btn_k" id="{{$item->id}}-{{$item->setmenu_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$item->id}}-{{$item->setmenu_id}}modal">
                        <div class="modal fade" id="{{$item->id}}-{{$item->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content pop-up-content">
                                    <div class="modal-header pop-up-header">
                                        <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                    </div>
                                    <div class="modal-body">
                                    {!! Form::open(array('url' => 'Kitchen/getCancelID/TableView', 'class'=> 'form-horizontal')) !!}

                                        @if(isset($item->setmenu_id) && $item->setmenu_id != 0)
                                            <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
                                        @else
                                            <input type="hidden" name="order_details_id" value="{{$item->id}}">
                                        @endif
                                        <input type="hidden" name="setmenu_id" value="{{$item->setmenu_id}}">

                                        <div class="row">
                                            <label class="col-sm-3 control-label"><b>Enter Message</b></label>
                                            <div class="col-sm-7">
                                                <input type="text" name="message" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                                                <input type="submit" name="submit" value="Save" class="btn btn-primary pop-up-button">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer pop-up-footer">
                                        <span>AcePlus Solutions.,Co Ltd</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table> 
@endif   
@endforeach    
</div>