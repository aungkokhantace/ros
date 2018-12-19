@foreach($order['detail'] as $detail)
<tr class="item-tr" id="item-tr-{{$detail['uniqid'] }}">
    <td>
        @if($detail['item_name'] !== Null)
            @if($detail['has_continent'] == 1)
            <p data-toggle="modal" data-target="#continent-{{$detail['item_id'] . '-' . $detail['uniqid']}}" id="continent-{{$detail['uniqid']}}">{{ $detail['item_name'] . '(' . $detail['continent_name'] . ')' }}</p>
            <!-- Modal for Continent -->
            <div class="modal fade" id="continent-{{$detail['item_id'] . '-' . $detail['uniqid']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content extra-box">
                        <h3>Continent</h3>    
                        <form>
                            <label>Choose Continent</label>
                            <select style="width: 80%;height: 30px;" id="continent-select-{{$detail['uniqid']}}">
                                @foreach($detail['continents'] as $continent)
                                    <option value="{{ $continent['id'] }}" {{ $continent['id'] == $detail['continent_id'] ? "selected" : "" }}>{{ $continent['name'] }}</option>
                                @endforeach
                            </select>                                     
                            <div class="modal-footer cashier-footer">
                                <button type="button" data-dismiss="modal" class="ok-btn" onclick="continentOK({{$detail['item_id'] . ',"' . $detail['uniqid'] . '"' }})">OK</button>
                                <button type="reset" class="cancel-btn" data-dismiss="modal">Cancel1</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
            <!-- end of Modal for Choose Continent -->
            @else 
                <p>{{ $detail['item_name'] }}</p>
            @endif
        @else
            <p>{{ $detail['set_name'] }}</p>
        @endif
    </td>
    <td class="cart_quantity">
        <div class="qty-box">
            <input type='button' value='-' class='qtyminus' field='quantity' onclick="quantityMinus({{($detail['set_id'] == Null) ? $detail['item_id'] . ',"' . $detail['uniqid'] . '"' :  $detail['set_id'] . ',"' . $detail['uniqid'] . '"'}})" />
            <input type='text' name='quantity[]' value="{{ $detail['quantity'] }}" class='qty' id="qty-{{$detail['uniqid']}}"/>
            <input type='button' value='+' class='qtyplus' field='quantity' onclick="quantityPlus({{ ($detail['set_id'] == Null) ? $detail['item_id'] . ',"' . $detail['uniqid'] . '"' :  $detail['set_id'] . ',"' . $detail['uniqid'] . '"'}})" />
        </div>
    </td>

    
    <td id="price-{{$detail['uniqid']}}"> {{ $detail['amount'] }}</td>
    @if ($detail['discount_amount'] == '')
        <td id="discount-{{$detail['uniqid']}}">&nbsp;</td>
    @else
        <td id="discount-{{$detail['uniqid']}}">{{ $detail['discount_amount'] }}</td>
    @endif
    <td>
        <button class="extra-btn" data-toggle="modal" data-target="#extra-choose-{{$detail['item_id'] . '-' . $detail['uniqid']}}" type="button">Add On</button>
        @if(count($detail['category_addon']) > 0)
            <!-- Modal for Extra Choose -->
            <div class="modal fade" id="extra-choose-{{$detail['item_id'] . '-' . $detail['uniqid']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content extra-box" id="addon-{{$detail['item_id'] . '-' . $detail['uniqid'] }}">
                        <h3>Choose Extra</h3>    
                        <form>
                            @foreach($detail['category_addon'] as $addon)
                            <label class="control">{{ $addon['food_name'] }}
                                <input type="checkbox" value="{{ $addon['id'] . ',' . $addon['price'] }}" {{ (in_array($addon['id'],$detail['addon'])) ? "checked" : ""}} />
                                <div class="check-mark"></div>
                            </label>
                            @endforeach                         
                            <div class="modal-footer cashier-footer">
                                <button type="button" data-dismiss="modal" class="ok-btn" onclick="addOnOK({{$detail['item_id'] . ',"' . $detail['uniqid'] . '"' }})">OK</button>
                                <button type="reset" data-dismiss="modal" class="cancel-btn">Cancel2</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
            <!-- end of Modal for Extra Choose -->
        @endif
    </td>
    <td><input type="text" id="extra-{{ $detail['item_id'] . '-' . $detail['uniqid'] }}" name="extra[]" value="{{ $detail['total_addon_price'] }}" style="border:none;background:none;" readonly /></td>
    <td>
    <input type="text" value="{{$detail['amount_with_discount'] }}" style="border:none;background:none;" readonly id="amount-{{$detail['uniqid']}}" />
    </td>

    <td>
        <label class="control">
          <input type="hidden" value="0" name="take_{{$detail['uniqid']}}" />
          <input type="checkbox" value="1" name="take_{{$detail['uniqid']}}" {{ ($detail['take_item'] == '1')? 'checked':'' }} />
          <div class="check-mark"></div>
        </label>
    </td>
    <td>
        @if($detail['detail_status'] ==1 )
        <button class="cancel-btn" type="button" onclick="cancelBtn({{$detail['order_detail_id']}},'{{$detail['uniqid']}}')">Cancel3</button>
        @endif
    </td>

    <input type="hidden" name="item[]" value="{{($detail['set_id'] == Null) ? $detail['item_id']: $detail['set_id'] }}" id="item-{{$detail['uniqid'] }}" />
    <input type="hidden" name="addon[]" value="{{ implode(',',$detail['addon'])}}" id="addon-{{$detail['item_id'] . '-' . $detail['uniqid'] }}" />
    <input type="hidden" name="originamount[]" value="{{$detail['amount'] }}" id="amount-without-discount-{{$detail['uniqid'] }}" />

    @if($detail['set_id'] == Null)
        <input type="hidden" name="price[]" value="{{$detail['amount_with_discount'] }}" id="price-{{ $detail['item_id'] . '-' . $detail['uniqid']}}" />
    @else
        <input type="hidden" name="price[]" value="{{$detail['amount_with_discount'] }}" id="price-{{ $detail['set_id'] . '-' . $detail['uniqid']}}" />
    @endif
    <input type="hidden" name="discount[]" value="{{$detail['discount_amount'] }}" id="discount-{{$detail['item_id'] }}" />
    <input type="hidden" value="{{ $detail['uniqid'] }}" name="uniqid[]" />
    <input type="hidden" value="{{ $detail['order_detail_id'] }}" name="order_detail_id[]" />
    <input type="hidden" value="{{ ($detail['item_id'] == Null) ? 1 : 0}}" name="type[]" />
</tr>
@endforeach