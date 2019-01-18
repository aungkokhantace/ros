@foreach($orders as $orderKey => $orderValue)
    @if (isset($orderValue->items) && count($orderValue->items) > 0)
        @foreach($orderValue->items as $item)
        <div class="modal fade " id="{{$item->id}}-print-chef" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-width" role="document">
            <div class="modal-content" id="order-id">
              <div class="modal-body" id="{{$item->id}}-print-table">
                  <hr>{{ $kitchen->name }} Kitchen<hr>
                  <table class="table">
                    <tr>
                      <td class="left">
                        {{ $item->name }}
                        @if(!empty($item->continent_name))
                            ({{ $item->continent_name }})
                        @endif
                      </td>
                      <td class="right">{{ $item->quantity }}</td>
                    </tr>
                    <tr>
                      <td class="left">Type:</td>
                      <td class="right">
                        @if($orderValue->take_id !== 1)
                            {{ "Dine in" }}
                        @else
                            {{ "Parcel"}}
                        @endif
                      </td>
                    </tr>
                    @if(strlen($item->remark) != 0)
                      <tr>
                        <td class="left">Remark:</td>
                        <td class="right remark"><span>{{ $item->remark }}</span></td>
                      </tr>
                    @endif
                    @foreach($extra as $ex)
                      @if($ex->order_detail_id == $item->id && $item->setmenu_id == 0)
                      <tr>
                        <td class="left">Add On:</td>
                        <td class="right"><span>{{ $ex->food_name }}</span></td>
                      </tr>
                      @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                      <tr>
                        <td class="left">Add On:</td>
                        <td class="right"><span>{{ $ex->food_name }}</span></td>
                      @endif
                    @endforeach
                  </table>
                  <hr>
              </div>
              <div class="modal-footer">
                <button class="btn btn-success" id ="{{ $item->id}}" onClick="print_click(this.id)">Print</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Close</button>
              </div>
            </div>
          </div>
        </div>

        @endforeach
    @endif
@endforeach

@foreach($orders as $orderKey => $orderValue)
    @if (isset($orderValue->items) && count($orderValue->items) > 0)
        <?php
            $index_key    = [];
            $index_keys[] = $orderKey;
        ?>
        @foreach($orderValue->items as $item)
        <div class="modal fade " id="{{$item->order_detail_id}}-print-waiter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-width" role="document">
            <div class="modal-content" id="order-id">
              <div class="modal-body" id="{{$item->order_detail_id}}-print-table">
                  <hr>
                    <table class="table">
                          @if($orderKey)
                              @if($orderValue->take_id != 0)
                                  Take Away
                              @endif

                              @php $room_check = []; @endphp

                              @if(isset($rooms))
                                  @foreach($rooms as $room)
                                      @if($room->order_id == $orderKey)
                                          @php $room_check[] = $room->room_name; @endphp
                                          {{ $room->room_name }} Room
                                      @endif
                                  @endforeach
                              @endif


                              @if (isset($tables) && empty($room_check) && $orderValue->take_id == 0)
                                <tr>
                                  <td class="left">
                                  @foreach($tables as $table)
                                      @if($table->order_id == $orderKey)
                                          {{ $table->location_type }}
                                      @endif
                                  @endforeach
                                  </td>
                                  <td class="center">:</td>
                                  <td class="right">
                                    @foreach($tables as $table)
                                        @if($table->order_id == $orderKey)
                                            {{ $table->table_no }}
                                        @endif
                                    @endforeach
                                  </td>
                              </tr>
                                @if($orderValue->take_id == 0)
                                  <tr>
                                    <td class="left">Stand</td>
                                    <td class="center">:</td>
                                    <td class="right">{{ $orderValue->stand_number }}</td>
                                  </tr>
                                @endif
                              @elseif (!empty($room_check))
                                @php unset($room_check[0]); @endphp
                              @endif
                          @endif
                    </table>
                  <hr>
                  <table class="table">
                    <tr>
                      <td class="left">
                        {{ $item->name }}
                        @if(!empty($item->continent_name))
                            ({{ $item->continent_name }})
                        @endif
                      </td>
                      <td class="right">{{ $item->quantity }}</td>
                    </tr>
                    <tr>
                      <td class="left">Type:</td>
                      <td class="right">
                        @if($orderValue->take_id !== 1)
                            {{ "Dine in" }}
                        @else
                            {{ "Parcel"}}
                        @endif
                      </td>
                    </tr>
                    @if(strlen($item->remark) != 0)
                      <tr>
                        <td class="left">Remark:</td>
                        <td class="right remark">{{ $item->remark }}</td>
                      </tr>
                    @endif
                    @foreach($extra as $ex)
                      @if($ex->order_detail_id == $item->id && $item->setmenu_id == 0)
                      <tr>
                        <td class="left">Add On:</td>
                        <td class="right"><span>{{ $ex->food_name }}</span></td>
                      </tr>
                      @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                      <tr>
                        <td class="left">Add On:</td>
                        <td class="right"><span>{{ $ex->food_name }}</span></td>
                      @endif
                    @endforeach
                  </table>
              </div>
              <div class="modal-footer">
                <button class="btn btn-success" id ="{{ $item->order_detail_id}}" onClick="print_click(this.id)">Print</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Close</button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
    @endif
@endforeach
