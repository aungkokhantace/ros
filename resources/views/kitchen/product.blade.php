<div class="col-md-12 tbl-container">
    @foreach($product as $orderKey=>$p)
        <table class="table table-bordered" ">
            <thead class="header">
            <tr>
                <td class="tdname">
                    <h4>{{$p['item_name']}}</h4>
                </td>
            </tr>
            <tr class="tr_header">
                <td>Table/Room Name/Take Away</td>
                <td>Quantity</td>
                <td>Exception</td>
                <td>Remark</td>
                <td>Add On</td>
                <td>StartTime</td>
                <td>Order Duration</td>
                <td>Cooking Duration</td>
                <td>Order Status</td>
                <td>Cancel</td>
            </tr>
            </thead>
            <tbody class="body">
                @if($p['product_order'] != null)
                    @foreach($p['product_order'] as $item)
                        @if($p['item_id'] == $item->id)
                            <tr class="tr-row"  data-ordertime = "{{$item->order_time}}">
                                <td>
                                    @if($item->take_id == 1)
                                        <h4>Take Away</h4>
                                    @endif
                                    @if(isset($tables) && count($tables) >0 )
                                        @foreach($tables as $table)
                                            @if($table->order_id == $item->order_id)
                                                <h4>{{$table->table_no}}</h4>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(isset($rooms) && count($rooms) > 0)
                                        @foreach($rooms as $room)
                                            @if($room->order_id == $item->order_id)
                                                <h4>{{ $room->room_name }}</h4>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->exception }}</td>
                                <td>{{ $item->remark }}</td>
                                <td>
                                    @foreach($extra as $ex)
                                        @if($ex->order_detail_id == $item->order_detail_id)
                                            {{ $ex->food_name }},
                                        @endif
                                    @endforeach
                                </td>
                                <td class="td-row" data-ordertime = "{{ $item->order_time}}">
                                    {{ date('h:m:s A', strtotime($item->order_time)) }}
                                </td>
                                <td >
                                    @if($item->status_id == '1')
                                        <span class="duration"></span>
                                        <input type="hidden" name="duration" class="txt_duration"/>
                                    @endif
                                    @if($item->status_id =='2')
                                        {{ date('h:m:s A', strtotime($item->order_duration)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($item->status_id =='2')
                                        <input type="hidden" name="order_duration" value="{{ $item->order_duration }}"/>
                                        <span class="cooking_duration"></span>
                                        <input type="hidden" name="duration" class="txt_cooking_duration"/>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status_id == '1')
                                        <input type="submit" class="start start_duration_item btn_k" id="{{$item->order_detail_id}}" name="start" value="Cooking">
                                    @endif
                                    @if($item->status_id =='2')
                                        <input type="submit" class="complete complete_duration_item btn_k" id="{{$item->order_detail_id}}" name="complete" value="Cooked">
                                    @endif
                                </td>  
                                @if($item->status_id == '1')
                                <td>
                                    <input type="button" class="cancel btn_k" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$item->order_detail_id}}-{{$item->setmenu_id}}modal">
                                    <div class="modal fade" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content pop-up-content">
                                                <div class="modal-header pop-up-header">
                                                    <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(array('url' => 'Kitchen/getCancelID/ProductView', 'class'=> 'form-horizontal')) !!}

                                                    @if(isset($item->setmenu_id) && $item->setmenu_id != 0)
                                                        <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
                                                    @else
                                                        <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
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
                                    <!-- Modal -->
                                </td>
                                @endif                          
                            </tr>    
                        @endif
                    @endforeach    
                @endif   

                 @if($p['setmenu'] != null)
                    @foreach($p['setmenu'] as $setmenu)
                        @if($p['item_id'] == $setmenu->item_id)
                            <tr class="tr-row"  data-ordertime = "{{$setmenu->order_time}}">
                                <td>
                                    @if($setmenu->take_id == 1)
                                        <h4>Take Away</h4>
                                    @endif
                                    @if(isset($tables) && count($tables) >0 )
                                        @foreach($tables as $table)
                                            @if($table->order_id == $setmenu->order_id)
                                                <h4>{{$table->table_no}}</h4>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(isset($rooms) && count($rooms) > 0)
                                        @foreach($rooms as $room)
                                            @if($room->order_id == $setmenu->order_id)
                                                <h4>{{ $room->room_name }}</h4>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $setmenu->quantity }}</td>
                                <td>{{ $setmenu->exception }}</td>
                                <td>{{ $setmenu->remark }}</td>
                                <td>
                                    @foreach($extra as $ex)
                                        @if($ex->order_detail_id == $setmenu->order_detail_id)
                                            {{ $ex->food_name }},
                                        @endif
                                    @endforeach
                                </td>
                                <td class="td-row" data-ordertime = "{{ $setmenu->order_time}}">
                                    {{ date('h:m:s A', strtotime($setmenu->order_time)) }}
                                </td>
                                <td >
                                    @if($setmenu->status_id == '1')
                                        <span class="duration"></span>
                                        <input type="hidden" name="duration" class="txt_duration"/>
                                    @endif
                                    @if($setmenu->status_id =='2')
                                        {{ date('h:m:s A', strtotime($setmenu->order_duration)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($setmenu->status_id =='2')
                                        <input type="hidden" name="order_duration" value="{{ $setmenu->order_duration }}"/>
                                        <span class="cooking_duration"></span>
                                        <input type="hidden" name="duration" class="txt_cooking_duration"/>
                                    @endif
                                </td>
                                <td>
                                    @if($setmenu->status_id == '1')
                                        <input type="submit" class="start start_duration_setmenu btn_k" id="{{$setmenu->id}}" name="start" value="Cooking">
                                    @endif
                                    @if($setmenu->status_id =='2')
                                        <input type="submit" class="complete complete_duration_setmenu btn_k" id="{{$setmenu->id}}" name="complete" value="Cooked">
                                    @endif
                                </td>  
                                @if($setmenu->status_id == '1')
                                <td>
                                    <input type="button" class="cancel btn_k" id="{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}modal">
                                    <div class="modal fade" id="{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content pop-up-content">
                                                <div class="modal-header pop-up-header">
                                                    <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(array('url' => 'Kitchen/getCancelID/ProductView', 'class'=> 'form-horizontal')) !!}

                                                    @if(isset($setmenu->setmenu_id) && $setmenu->setmenu_id != 0)
                                                        <input type="hidden" name="order_details_id" value="{{$setmenu->order_detail_id}}">
                                                    @else
                                                        <input type="hidden" name="order_details_id" value="{{$setmenu->order_detail_id}}">
                                                    @endif
                                                    <input type="hidden" name="setmenu_id" value="{{$setmenu->setmenu_id}}">

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
                                    <!-- Modal -->
                                </td>
                                @endif                          
                            </tr>    
                        @endif
                    @endforeach    
                @endif           
            </tbody>
        </table>
    @endforeach
</div>
