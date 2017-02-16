<div class="col-md-12 tbl-container">

    @foreach($groupedOrders as $group)
      
        <table class="table table-bordered" id="{{ $group->first()->order_id}}">
            <thead class="header">
                <tr>
                    <td class="tdname">
                       @if($group->first()->order_id)
                            
                            @if($group->first()->take_id != 0)
                            <h4>Take Away </h4>
                            @endif

                            @if(isset($tables))
                                @foreach($tables as $table)
                                    @if($table->order_id == $group->first()->order_id)
                                        <h4> {{ $table->table_no }} </h4>
                                    @endif
                                @endforeach
                            @endif

                            @if(isset($rooms))
                                @foreach($rooms as $room)
                                    @if($room->order_id == $group->first()->order_id)
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
                    <td>Exception</td>
                    <td>Add On</td>
                    <td>StartTime</td>
                    <td>Order Duration</td>
                    <td>Cooking Duration</td>
                    <td>Order Status</td>
                    <td>Cancel</td>
                </tr>
            </thead>
            <tbody class="body">
                @foreach($group as $order)
                    @if($order->item_id != "null")
                        <tr class="tr-row"  data-ordertime = "{{ $order->order_time }}">
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->order_type }}</td>
                        <td>{{ $order->exception }}</td>
                        <td>
                            @foreach($extra as $ex)
                                @if($ex->order_detail_id == $order->id)
                                    {{ $ex->extra->food_name }},
                                @endif
                            @endforeach
                        </td>
                        <td data-ordertime = "{{ $order->order_time }}">
                            {{ date('Y-m-d h:m:s A', strtotime($order->order_time)) }}
                        </td>
                        <td>
                            @if($order->order_status == '1')
                                <span class="duration"></span>
                             
                                <input type="hidden" name="duration" class="txt_duration" />
                            @endif
                            @if($order->order_status =='2')
                                {{ date('Y-m-d h:m:s A', strtotime($order->order_duration)) }}
                            @endif
                        </td>
                        <td>
                            @if($order->order_status =='2')
                                <input type="hidden" name="order_duration" value="{{ $order->order_duration }}" />
                                <span class="cooking_duration"></span>
                                
                                <input type="hidden" name="duration" class="txt_cooking_duration" />
                            @endif
                        </td>
                       
                        <td>
                            @if($order->order_status == '1')
                                <input type="submit" class="start btn_k" id="{{$order->order_details_id}}" name="start" value="Start">
                            @endif
                            @if($order->order_status =='2')
                                <input type="submit" class="complete btn_k" id="{{$order->order_details_id}}" name="complete" value="Complete">
                            @endif
                        </td>
                    @if($order->order_status == '1')
                        <td>
                            <input type="button" class="cancel btn_k" id="{{$order->order_details_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$order->order_details_id}}modal">
                                        
                            <!-- Modal -->
                            <div class="modal fade" id="{{$order->order_details_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content pop-up-content">
                                        <div class="modal-header pop-up-header">
                                            <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(array('url' => 'Kitchen/getCancelID', 'class'=> 'form-horizontal')) !!}
                                            <input type="hidden" name="order_details_id" value="{{$order->order_details_id}}" class="form-control">
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
                            
                    @endif
                    @if($order->set_id != "null")
                       <tr class="tr-row"  data-ordertime = "{{ $order->order_time }}">
                            <td>{{ $order->set_menus_name }}</td>
                            <td>{{ $order->order_type }}</td>
                            <td>{{ $order->exception }}</td>
                            <td>
                                @foreach($extra as $ex)
                                    @if($ex->order_detail_id == $order->id)
                                        {{ $ex->extra->food_name }},
                                    @endif
                                @endforeach
                            </td>
                            <td data-ordertime = "{{ $order->order_time }}">
                                {{ $order->order_time }}
                            </td>
                            <td>
                                @if($order->order_status == '1')
                                    <span class="duration"></span>
                                    <input type="hidden" name="duration" class="txt_duration" />
                                @endif
                                @if($order->order_status =='2')
                                    {{ $order->order_duration }}
                                @endif
                            </td>
                            <td>
                                @if($order->order_status =='2')
                                    <input type="hidden" name="order_duration" value="{{ $order->order_duration }}" />
                                    <span class="cooking_duration"></span>
                                    <input type="hidden" name="duration" class="txt_cooking_duration" />
                                @endif
                            </td>
                            
                            <td>
                                @if($order->order_status == '1')
                                    <input type="button" class="start btn_k" id="{{$order->order_details_id}}" name="start" value="Start">
                                @endif
                                @if($order->order_status =='2')
                                    <input type="submit" class="complete btn_k" id="{{$order->order_details_id}}" name="complete" value="Complete">
                                @endif
                            </td>
                        @if($order->order_status == '1')
                            <td>
                                <input type="button" class="cancel btn_k" id="{{$order->order_details_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$order->order_details_id}}modal">
                                            
                                <!-- Modal -->
                                <div class="modal fade" id="{{$order->order_details_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content pop-up-content">
                                            <div class="modal-header pop-up-header">
                                                <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open(array('url' => 'Kitchen/getCancelID', 'class'=> 'form-horizontal')) !!}
                                                    <input type="hidden" name="order_details_id" value="{{$order->order_details_id}}" class="form-control">
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
                        
                    @endif
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>

