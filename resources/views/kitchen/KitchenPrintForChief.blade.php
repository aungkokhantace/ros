@foreach($orders as $orderKey => $orderValue)
    @if (isset($orderValue->items) && count($orderValue->items) > 0)
        @foreach($orderValue->items as $item)
            <div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="{{$item->id}}-print">
                <div class="modal-dialog" role="document" style="width:430px;">
                    <div class="modal-content" style="background:none;box-shadow:none;">
                        <div class="modal-header" style="width: 500px;background:#11463d">
                            <div class="bootstrap-dialog-header">
                                <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">Print Order</div>
                            </div>
                        </div>
                        <div class="modal-body" id="order-id" style="width: 500px;height: 250px; background: whitesmoke;">
                            {{--id="{{$item->id}}-print-table"--}}
                            <div id="{{$item->id}}-print-table">
                                <table style="border-collapse: collapse;margin:0 auto;table-layout: fixed;word-wrap: break-word;background:none;">
                                    <tbody style="font-size:13px;line-height:25px;">
                                    <tr>
                                        <td style="border: 0 !important;">Item Name&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">
                                            {{ $item->name }}
                                            @if(!empty($item->continent_name))
                                                ({{ $item->continent_name }})
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 0 !important;">Order type&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">
                                            @if($orderValue->take_id !== 1)
                                                {{ "Dine in" }}
                                            @else
                                                {{ "Parcel"}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 0 !important;">Quantity&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">{{ $item->quantity }}</td>
                                    </tr>
                                    @if(strlen($item->remark) != 0)
                                        <tr>
                                            <td style="border: 0 !important;">Remark&nbsp;</td>
                                            <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                            <td style="border: 0 !important;text-align: left">{{ $item->remark }}</td>
                                        </tr>
                                    @endif
                                    @foreach($extra as $ex)
                                        @if($ex->order_detail_id == $item->id)
                                            @php
                                                $check = 1;
                                            @endphp
                                        @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                                            @php
                                                $check = 1;
                                            @endphp
                                        @else
                                            @php
                                                $check = null;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!empty($check))
                                        <tr>
                                            <td style="border: 0 !important;">Add On&nbsp;</td>
                                            <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                            <td style="border: 0 !important;text-align: left">
                                                @foreach($extra as $ex)
                                                    @if($ex->order_detail_id == $item->id)
                                                        <span>
                                                            {{ $ex->food_name }}
                                                        </span>
                                                    @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                                                        <span>
                                                            {{ $ex->food_name }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div style="width: 300px;"></div>
                            <div>
                                <br>
                                <button class="btn btn-success btn-lg" id ="{{ $item->id}}" onClick="print_click(this.id)">Print</button>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-lg">Close</button>
                            </div>
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
            <div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="{{$item->order_detail_id}}-print">
                <div class="modal-dialog" role="document" style="width:430px;">
                    <div class="modal-content" style="background:none;box-shadow:none;">
                        <div class="modal-header" style="width: 500px;background:#11463d">
                            <div class="bootstrap-dialog-header">
                                <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb67_title">Print Order</div>
                            </div>
                        </div>
                        <div class="modal-body" id="order-id" style="width: 500px;height: 260px; background: whitesmoke;">
                            <div id="{{$item->order_detail_id}}-print-table">
                                <table style="border-collapse: collapse;margin:0 auto;table-layout: fixed;word-wrap: break-word;background:none;">
                                    <tbody style="font-size:13px;line-height:25px;">
                                    <tr>
                                        <td style="border: 0 !important;">Table Name&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">
                                            @if($orderKey)
                                                @if($orderValue->take_id != 0)
                                                    Take Away
                                                @endif

                                                @if(isset($tables))
                                                    @foreach($tables as $table)
                                                        @if($table->order_id == $orderKey)
                                                            {{ $table->table_no }}
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @if(isset($rooms))
                                                    @foreach($rooms as $room)
                                                        @if($room->order_id == $orderKey)
                                                            {{ $room->room_name }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 0 !important;">Item Name&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">
                                            {{ $item->name }}
                                            @if(!empty($item->continent_name))
                                                ({{ $item->continent_name }})
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 0 !important;">Order type&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">
                                            @if($orderValue->take_id !== 1)
                                                {{ "Dine in" }}
                                            @else
                                                {{ "Parcel"}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: 0 !important;">Quantity&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">{{ $item->quantity }}</td>
                                    </tr>
                                    @if(strlen($item->remark) != 0)
                                        <tr>
                                            <td style="border: 0 !important;">Remark&nbsp;</td>
                                            <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                            <td style="border: 0 !important;text-align: left">{{ $item->remark }}</td>
                                        </tr>
                                    @endif

                                    @foreach($extra as $ex)
                                        @if($ex->order_detail_id == $item->id)
                                            @php
                                                $check = 1;
                                            @endphp
                                        @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                                            @php
                                                $check = 1;
                                            @endphp
                                        @else
                                            @php
                                                $check = null;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!empty($check))
                                        <tr>
                                            <td style="border: 0 !important;">Add On&nbsp;</td>
                                            <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                            <td style="border: 0 !important;text-align: left">
                                                @foreach($extra as $ex)
                                                    @if($ex->order_detail_id == $item->id)
                                                        <span>
                                                            {{ $ex->food_name }}
                                                        </span>
                                                    @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                                                        <span>
                                                            {{ $ex->food_name }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                    @if($orderValue->take_id == 0)
                                        <tr>
                                            <td style="border: 0 !important;">Stand Number&nbsp;</td>
                                            <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                            <td style="border: 0 !important;text-align: left">{{ $orderValue->stand_number }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="border: 0 !important;">Total Amount&nbsp;</td>
                                        <td style="border: 0 !important;">&nbsp;:&nbsp;&nbsp;</td>
                                        <td style="border: 0 !important;text-align: left">{{ $item->amount_with_discount }} MMK</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="width: 500px;"></div>
                            <div>
                                <br>
                                <button class="btn btn-success btn-lg" id ="{{ $item->order_detail_id}}" onClick="print_click(this.id)">Print</button>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-lg">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endforeach