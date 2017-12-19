<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingDown">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDown" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/download_voucher</p>
                </a>
            </h4>
        </div>
        <div id="collapseDown" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDown">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/download_voucher</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က မရွင္းရေသးတဲ့ order ေတြကုိ ဆြဲထုတ္တဲ့ api ေတြကုိ ျပန္ခ်ေပးတာျဖစ္တယ္။ 
                </p>
                <ol>
                    <li>Tablet ကေန ဆာဗာဘက္ကုိ site_activation_key ပုိ႔ေပးလုိက္တယ္။</li>
                    <li>မွားရင္ Fail message response ျပန္တယ္</li>
                    <li>မွန္ရင္ order table ထဲက status 1 (မရွင္းရေသးတဲ့ order) ေတြကုိ ျပန္ခ်ေပးတယ္။</li>
                </ol>
                <p>&nbsp;</p>
                <h4>Sample Input String</h4>
                <div class="sample-input">
                    <table style="height: 44px; width: 451px;">
                    <tbody>
                    <tr>
                    <td style="width: 215.383px;"><strong>Key</strong></td>
                    <td style="width: 219.617px;">Value</td>
                    </tr>
                    <tr>
                    <td style="width: 215.383px;">site_activation_key</td>
                    <td style="width: 219.617px;">api</td>
                    </tr>
                    </tbody>
                    </table>
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "Data": [
                            {
                                "id": "1-0000000155",
                                "take_id": 1,
                                "order_time": "2017-12-14 16:55:38",
                                "total_extra_price": 0,
                                "total_discount_amount": 0,
                                "total_price": 0,
                                "all_total_amount": 0,
                                "status": 1
                            },
                            {
                                "id": "1-0000000156",
                                "take_id": 1,
                                "order_time": "2017-12-14 16:56:27",
                                "total_extra_price": 0,
                                "total_discount_amount": 0,
                                "total_price": 5000,
                                "all_total_amount": 6000,
                                "status": 1
                            },
                            {
                                "id": "1-0000000157",
                                "take_id": 1,
                                "order_time": "2017-12-14 17:03:07",
                                "total_extra_price": 0,
                                "total_discount_amount": 0,
                                "total_price": 0,
                                "all_total_amount": 0,
                                "status": 1
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingDownd">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDownd" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/download_voucher_detail</p>
                </a>
            </h4>
        </div>
        <div id="collapseDownd" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDownd">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/download_voucher_detail</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က order တစ္ခုခ်င္းစီမွာရွိတဲ့ order_detail ကုိ array ထဲမွာ ထည္႕ၿပီးျပတာျဖစ္တယ္။
                </p>
                <ol>
                    <li>Tablet ကေန ဆာဗာဘက္ကုိ site_activation_key ႏွင့္ order id ပုိ႔ေပးလုိက္တယ္။</li>
                    <li>site_activation_key မွားရင္ Fail message response ျပန္တယ္</li>
                    <li>မွန္ရင္ order id နဲ႔ သက္ဆုိင္တဲ့ order_detail,set_menu,extra,order_table,order_room ထဲက data ေတြဆြဲထုတ္ၿပီး
array ထဲ ထည္႕ေပါင္းလုိက္တယ္။</li>
                </ol>
                <p>&nbsp;</p>
                <h4>Sample Input String</h4>
                <div class="sample-input">
                    <table style="height: 44px; width: 451px;">
                    <tbody>
                    <tr>
                    <td style="width: 215.383px;"><strong>Key</strong></td>
                    <td style="width: 219.617px;">Value</td>
                    </tr>
                    <tr>
                    <td style="width: 215.383px;">site_activation_key</td>
                    <td style="width: 219.617px;">api</td>
                    </tr>

                    <tr>
                    <td style="width: 215.383px;">order_id</td>
                    <td style="width: 219.617px;">1-0000000155</td>
                    </tr>
                    </tbody>
                    </table>
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "Data": [
                            {
                                "id": "1-0000000155",
                                "user_id": 5,
                                "take_id": 1,
                                "order_time": "2017-12-14 16:55:38",
                                "member_id": 0,
                                "total_extra_price": 0,
                                "total_discount_amount": 0,
                                "total_price": 0,
                                "member_discount": 0,
                                "member_discount_amount": 0,
                                "service_amount": 0,
                                "tax_amount": 0,
                                "foc_amount": null,
                                "foc_description": null,
                                "total_price_foc": 0,
                                "all_total_amount": 0,
                                "payment_amount": 0,
                                "refund": 0,
                                "status": 1,
                                "created_by": 0,
                                "updated_by": 0,
                                "deleted_by": null,
                                "created_at": "2017-12-14 16:55:38",
                                "updated_at": "2017-12-14 16:59:26",
                                "deleted_at": null,
                                "room_charge": 0,
                                "tablet_id": "a32dc315e590c384",
                                "user_name": "waiter",
                                "order_detail": [
                                    {
                                        "id": 1,
                                        "order_detail_id": "1-00000001551",
                                        "order_id": "1-0000000155",
                                        "item_id": 12,
                                        "order_type_id": 2,
                                        "setmenu_id": 0,
                                        "take_item": 1,
                                        "quantity": 1,
                                        "exception": "",
                                        "discount_amount": "0.0",
                                        "promotion_id": 0,
                                        "amount": 3000,
                                        "amount_with_discount": 3000,
                                        "order_time": "2017-12-14 16:55:38",
                                        "order_duration": null,
                                        "cooking_time": null,
                                        "waiter_duration": null,
                                        "waiter_id": 0,
                                        "waiter_status": null,
                                        "status_id": 6,
                                        "cancel_status": null,
                                        "message": "vvv",
                                        "remark": "",
                                        "created_by": 0,
                                        "updated_by": 0,
                                        "deleted_by": null,
                                        "created_at": "2017-12-14 16:55:38",
                                        "updated_at": "2017-12-14 16:59:09",
                                        "deleted_at": null,
                                        "order_setmenu": [],
                                        "order_extra": [],
                                        "order_table": [],
                                        "order_room": [],
                                        "state": "old"
                                    },
                                    {
                                        "id": 2,
                                        "order_detail_id": "1-00000001552",
                                        "order_id": "1-0000000155",
                                        "item_id": 18,
                                        "order_type_id": 2,
                                        "setmenu_id": 0,
                                        "take_item": 1,
                                        "quantity": 1,
                                        "exception": "",
                                        "discount_amount": "0.0",
                                        "promotion_id": 0,
                                        "amount": 2000,
                                        "amount_with_discount": 2000,
                                        "order_time": "2017-12-14 16:55:38",
                                        "order_duration": null,
                                        "cooking_time": null,
                                        "waiter_duration": null,
                                        "waiter_id": 0,
                                        "waiter_status": null,
                                        "status_id": 6,
                                        "cancel_status": null,
                                        "message": "i",
                                        "remark": "",
                                        "created_by": 0,
                                        "updated_by": 0,
                                        "deleted_by": null,
                                        "created_at": "2017-12-14 16:55:38",
                                        "updated_at": "2017-12-14 16:59:26",
                                        "deleted_at": null,
                                        "order_setmenu": [],
                                        "order_extra": [],
                                        "order_table": [],
                                        "order_room": [],
                                        "state": "old"
                                    }
                                ]
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->
</div><!-- End Panel Group -->