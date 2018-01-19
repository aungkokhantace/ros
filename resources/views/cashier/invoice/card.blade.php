<div class="row">
    <input type="hidden" value="0" class="count" style="width:100%;" />
</div><div class="spacer-10px"></div>

@if(count($payments) > 0)
    @foreach($payments as $payment)
    <div class="input_fields_wrap" id="fields_wrap">
        <div class="payment_wrapper" style="border:1px solid black;width:80%;padding:10px;margin-bottom:20px;" >
            <div class="row">
                <div class="col-md-3">
                    <select class"form-control select" name="cardtype[]" onchange="checkCash(this)" id="cardSelect" disabled>
                        @foreach($cards as $card)
                        <option value="{{ $card->id }}" @if($card->id == $payment['payment_type']) {{ 'selected'}} @endif >{{ $card->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-9">
                @if ($payment['payment_type'] !== 2)
                    <input type="text" name="card_id[]" value="{{ $payment['payment_card_id'] }}" placeholder="Enter Card Number" />
                @endif
                </div>
            </div><div class="spacer-10px"></div>
            <div class="row">
                <div class="col-md-11">
                    <input type="text" name="amount[]" value="{{ $payment['paid_amount'] }}" placeholder="Enter Payment Amount" class="amount" style="width:100%;" id="amount-id"/>
                </div>
            </div><div class="spacer-10px"></div>
        </div> 
    </div>
    @endforeach

@else
<div class="input_fields_wrap" id="fields_wrap">
    <div class="payment_wrapper" style="border:1px solid black;width:80%;padding:10px;margin-bottom:20px;" >
        <div class="row">
            <div class="col-md-3">
                <select class"form-control select" name="cardtype[]" onchange="checkCash(this)" id="cardSelect">
                    @foreach($cards as $card)
                    <option value="{{ $card->id }}" class="changeSelect" >{{ $card->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-9">
                <input type="text" name="card_id[]" value="" placeholder="Enter Card Number" class="changeSelect" />
            </div>
        </div><div class="spacer-10px"></div>
        <div class="row">
            <div class="col-md-11">
                <input type="text" name="amount[]" value="" placeholder="Enter Payment Amount" class="amount" style="width:100%;" id="amount-id"/>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
             <div class="col-md-4">
                <button type="button" class="btn btn-success add-amount" onclick="addAmount(element)" disable='disable'>Add Amount</button>
            </div>

            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove" style="display:none;">Remove</button>
            </div> 
        </div>
    </div> 
</div>
@endif