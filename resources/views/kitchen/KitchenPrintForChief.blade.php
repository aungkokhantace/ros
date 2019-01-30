@foreach($orders as $orderKey => $orderValue)
    @if (isset($orderValue->items) && count($orderValue->items) > 0)
        @foreach($orderValue->items as $item)
        <div class="modal fade " id="{{$item->id}}-print-chef" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-width" role="document">
            <div class="modal-content" id="order-id">
              <div class="modal-body" id="{{$item->id}}-chef">
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
              <div class="footer-modal">
                <button class="btn btn-success" id ="{{ $item->id }}" onClick="print_chef(this.id)">Print</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary">ပိတ္မယ္</button>
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
              <div class="modal-body" id="{{$item->order_detail_id}}-waiter">
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
                                          @php
                                            $loc_array[] = $table->location_type;
                                          @endphp
                                      @endif
                                  @endforeach
                                  @if (!empty($loc_array) && count($loc_array) > 1)
                                      {{ implode(',', array_unique($loc_array)) }}
                                  @elseif (!empty($loc_array) && count($loc_array) == 1)
                                      {{ $loc_array[0] }}
                                  @endif
                                  @php unset($loc_array); @endphp
                                  </td>
                                  <td class="center">:</td>
                                  <td class="right">
                                    @php $no_array   = []; @endphp
                                    @foreach($tables as $table)
                                        @if($table->order_id == $orderKey)
                                          @php
                                            $no_array[] = $table->table_no;
                                          @endphp
                                        @endif
                                    @endforeach
                                    @if (!empty($no_array) && count($no_array) > 1)
                                      {{ implode(',', $no_array) }}
                                    @elseif (!empty($no_array) && count($no_array) == 1)
                                      {{ $no_array[0] }}
                                    @endif
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
                  <hr>
              </div>
              <div class="footer-modal">
                <button class="btn btn-success" id ="{{ $item->order_detail_id }}" onClick="print_for_waiter(this.id)">Print</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary">ပိတ္မယ္</button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
    @endif
@endforeach
