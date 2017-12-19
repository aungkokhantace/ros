<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingOStatus">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOStatus" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/order_status</p>
                </a>
            </h4>
        </div>
        <div id="collapseOStatus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOStatus">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/order_status</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က Kitchen က ခ်က္ေနတုန္း (cooked status) ႏွင့္ ခ်က္ၿပီး (cooking done status) order ေတြကုိ ျပန္ခ်ေပးတာျဖစ္တယ္။ 
                </p>
                <ol>
                    <li>Tablet ကေန ဆာဗာဘက္ကုိ http://localhost:8080/api/v1/order_status မွ တစ္ဆင့္ Post Request ပုိ႔ေပးလုိက္တယ္။ </li>
                    <li>Server ဘက္က Post Request ေရာက္လာၿပီဆုိတာနဲ႔ order_detail table နဲ႔ order table( order_detail.id = order.id) ထဲက status 2 and 3 (cooked and cooking status) ေတြကုိ သြားယူတယ္။ </li>
                    <li>oder ရဲ႕ id ကုိ array ထဲမွာ သိမ္းတယ္။</li>
                    <li>ရလာတဲ့ array ထဲက ရွိတဲ့ id အတုိင္း order_table,order_room ထဲက ေဒတာကုိ လွမ္းယူၿပီး array အျဖစ္ေျပာင္းတယ္။</li>
                    <li>status 2 and 3 (cooked and cooking status) အေနနဲ႔ရလာတဲ့ order_detail table အထဲက ေဒတာရဲ႕ item name, set_item name and set_menu name ေတြကုိ သက္ဆုိင္ရာ table ကေန order_detail id နဲ႔ သြားယူၿပီး array အျဖစ္ေျပာင္းတယ္။</li>
                    <li>ရလာတဲ့ array ေတြကုိ ေပါင္းၿပီး တစ္ခုထဲအေနအျဖစ္ေျပာင္းခဲ့တယ္။ Json format ေျပာင္းၿပီး response ျပန္ေပးခဲ့တယ္။</li>
                    <li>Id from order table as voucher_no,Response Json in its value.</li>
                </ol>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "order_status": [
                            {
                                "voucher_no": "1-00000128",
                                "table_name": null,
                                "room_name": null,
                                "product_list": [
                                    {
                                        "item_name": "O-eo",
                                        "set_menus_name": null,
                                        "id": 194,
                                        "order_id": "1-00000128",
                                        "order_detail_id": "1-000001281",
                                        "order_type": "Parcel",
                                        "status": 3,
                                        "cooking_time": "2017-12-14 14:52:24",
                                        "message": "",
                                        "set_item_id": null,
                                        "cancel_status": null
                                    }
                                ]
                            },
                            {
                                "voucher_no": "1-00000134",
                                "table_name": null,
                                "room_name": null,
                                "product_list": [
                                    {
                                        "item_name": "UdonNoodle",
                                        "set_menus_name": null,
                                        "id": 203,
                                        "order_id": "1-00000134",
                                        "order_detail_id": "1-000001341",
                                        "order_type": "Parcel",
                                        "status": 3,
                                        "cooking_time": "2017-12-14 14:52:04",
                                        "message": "",
                                        "set_item_id": null,
                                        "cancel_status": null
                                    },
                                    {
                                        "item_name": "SobaNoodle",
                                        "set_menus_name": null,
                                        "id": 204,
                                        "order_id": "1-00000134",
                                        "order_detail_id": "1-000001342",
                                        "order_type": "Parcel",
                                        "status": 3,
                                        "cooking_time": "2017-12-14 14:52:20",
                                        "message": "",
                                        "set_item_id": null,
                                        "cancel_status": null
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

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingKcancel">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseKcancel" aria-expanded="true" aria-controls="collapseOne">
                URL - http://localhost:8080/api/v1/kitchen_cancel
                </a>
            </h4>
        </div>
        <div id="collapseKcancel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingKcancel">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/kitchen_cancel</b><br />
                <p>Method -> GET</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က Kitchen ကေန Cancel လုပ္လုိက္တဲ့ order ေတြကုိ ျပန္ခ်ေပးတာျဖစ္တယ္။
                </p>
                <ol>
                    <li>Table ကေန http://localhost:8080/api/v1/kitchen_cancel route ကုိ GET request နဲ႔ လွမ္းေခၚလုိက္တာနဲ႔ order_details table ထဲက status 6 (Kitchen  ကေန cancel လုပ္လုိက္တဲ့ order) ကုိ database ထဲက ဆြဲထုတ္ၿပီး json response ျပန္ေပးတယ္။</li>
                </ol>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                    "kitchen_cancel": [
                        {
                            "id": 119,
                            "order_id": "1-000000082",
                            "status_id": 6,
                            "message": "Cancel"
                        },
                        {
                            "id": 134,
                            "order_id": "1-000000093",
                            "status_id": 6,
                            "message": "Cancel"
                        },
                        {
                            "id": 137,
                            "order_id": "1-000000095",
                            "status_id": 6,
                            "message": "Cancel"
                        },
                        {
                            "id": 140,
                            "order_id": "1-000000096",
                            "status_id": 6,
                            "message": "Cancel"
                        }
                    ]
                }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingFlogin">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFlogin" aria-expanded="true" aria-controls="collapseOne">
                URL - http://localhost:8080/api/v1/first_time_login
                </a>
            </h4>
        </div>
        <div id="collapseFlogin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFlogin">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/first_time_login</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                Tablet မွ ပုိ႔ေပးလုိက္ေသာ tablet_id ကုိ ၾကည္႕ၿပီး ထုိ tablet အတြက္ id တစ္ခု generate လုပ္ေပးရမွာျဖစ္ပါတယ္။ထုတ္ေပးလုိက္တဲ့ id အေပၚမူတည္ၿပီး order မွာရင္ ထုိ id ကုိ ေရွ႕ဆံုးမွာ ထည္႕ေပးရမယ္။
                </p>
                <ol>
                    <li>Tablet မွ tablet_id ႏွင့္ site_activation_key ကုိ ပုိ႔ေပးလုိက္မယ္။</li>
                    <li>ရလာတဲ့ tablet_id ကုိ tablet_activation table ထဲကေနသြားၾကည္႕မယ္။ တကယ္လုိ႔မရွိေသးရင္ tablet_activation table အထဲကုိ insert လုပ္မယ္။</li>
                    <li>ရလာတဲ့ tablet_id ကုိ tablet_activation table ထဲက tablet_id column မွတဆင့္သြားၾကည္႕မယ္။ တကယ္လုိ႔မရွိေသးရင္ tablet_activation table အထဲကုိ insert လုပ္မယ္။ tablet_generated_id ရဲ႕ value ကုိ 0 အေနနဲ႔ json response ျပန္ေပးမယ္။</li>
                    <li>tablet_id က ရွိေနခဲ့မယ္ဆုိရင္ tablet_activation က သူ႔ရဲ႕ id ကုိထုတ္မယ္။ ရလာတဲ့ id ကုိ order table ထဲမွာ tablet_id ဆုိတဲ့ column နဲ႔ တုိက္္စစ္ၿပီး count ဘယ္ႏွစ္ခုလဲထုတ္မယ္။
ရလာတဲ့ value ကုိ tablet_generated_id အေနနဲ႔ json response ျပန္ေပးမယ္။</li>
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
                        <td style="width: 215.383px;">tabletId</td>
                        <td style="width: 219.617px;">ap1</td>
                    </tr>
                    </tbody>
                    </table>
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "tablet_generated_id": 1,
                        "order_id": 155
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headinglogin">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapselogin" aria-expanded="true" aria-controls="collapseOne">
                URL - http://localhost:8080/api/v1/login
                </a>
            </h4>
        </div>
        <div id="collapselogin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headinglogin">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/login</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က Tablet က ပုိ႔ေပးလုိက္တဲ့ Username and password မွန္ မမွန္ တုိက္စစ္ေပးမယ္။
                </p>
                <ol>
                    <li>Tablet က ပုိ႔ေပးလုိက္တဲ့ Username and Password မွန္ မမွန္ကုိ user table ကေန တုိက္စစ္တယ္။ မမွန္ရင္ Fail message json response ျပန္တယ္။။</li>
                    <li>Username and password က မွန္ခဲ့ရင္ User role က Waiter ဟုတ္မဟုတ္ စစ္တယ္။ မွန္ခဲ့ရင္ Success json response ျပန္ၿပီး မမွန္ခဲ့ရင္ Fail json response ျပန္တယ္။</li>
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
                        <td style="width: 215.383px;">username</td>
                        <td style="width: 219.617px;">waiter</td>
                    </tr>

                    <tr>
                        <td style="width: 215.383px;">password</td>
                        <td style="width: 219.617px;">admin123</td>
                    </tr>
                    </tbody>
                    </table>
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "message": "Success",
                        "waiter_id": 5,
                        "username": "waiter",
                        "role": "Waiter"
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingVoucher">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseVoucher" aria-expanded="true" aria-controls="collapseOne">
                URL - http://localhost:8080/api/v1/create_voucher
                </a>
            </h4>
        </div>
        <div id="collapseVoucher" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingVoucher">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/create_voucher</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က Tablet က ပုိ႔ေပးလုိက္တဲ့ Order ကုိ database ထဲမွာ သိမ္းဖုိ႔ သံုးတယ္။
                </p>
                <ol>
                    <li>Table ကေန user_id,take_id,order_id,extra_price,discount_amount,total_price,service_amount,room_charge,tax_amount,net_price,order_table,order_room,order_detail,order_status,
tablet_id အစရွိတာေတြကုိ json format နဲ႔ ပုိ႔ေပးလုိက္တယ္။
</li>
                    <li>order_table အထဲမွာမွ table_id ေတြကုိ array အေနနဲ႔ ေသာ္လည္းေကာင္း၊</li>
                    <li>order_room အထဲမွာ room_id ေတြကုိ array အေနနဲ႔ေသာ္လည္းေကာင္း</li>
                    <li>order_detail အထဲမွာ order တစ္ေစာင္ခ်င္းစီရဲ႕ item_id,order_detail_id,set_id,quantity,order_type_id,discount_amount,exception,promotion_id,price,amount,status,take_item
အစရွိတာေတြကုိ array အေနနဲ႔ ပုိ႔ေပးလုိက္တယ္။</li>
                    <li>သက္ဆုိင္ရာ table ေတြကုိ database အထဲ သက္ဆုိင္ရာ table အလုိက္ သြားသိမ္းတယ္။</li>
                </ol>
                <p>&nbsp;</p>
                <h4>Sample Input Json</h4>
                <div class="sample-input">
                    <pre>
                    [
                        {
                            "order_id":"517112400003",
                            "order_status":1,
                            "user_id":"5",
                            "order_table":[

                            ],
                            "order_room":[

                            ],
                            "take_id":"1",
                            "total_price":18000,
                            "extra_price":0,
                            "discount_amount":0,
                            "service_amount":1800,
                            "tax_amount":1800,
                            "order_detail":[
                                {
                                    "set_id":"1",
                                    "item_id":"null",
                                    "set_item":[
                                    {
                                        "id":"1",
                                        "item_id":"9",
                                        "set_menu_id":"1"
                                    },
                                    {
                                        "id":"2",
                                        "item_id":"10",
                                        "set_menu_id":"1"
                                    }
                                    ],
                                    "state":"new",
                                    "order_detail_id":"5171124000031",
                                    "take_item":1,
                                    "discount_amount":"0.0",
                                    "promotion_id":"null",
                                    "price":4500,
                                    "quantity":4,
                                    "amount":18000,
                                    "order_type_id":"2",
                                    "status":"1",
                                    "exception":"",
                                    "extra":[

                                    ]
                                }
                            ],
                            "net_price":21600
                        }
                        ]
                    </pre> 
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "message": "Success"
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingAVoucher">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAVoucher" aria-expanded="true" aria-controls="collapseOne">
                URL - http://localhost:8080/api/v1/add_new_to_voucher
                </a>
            </h4>
        </div>
        <div id="collapseAVoucher" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAVoucher">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/add_new_to_voucher</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                ယခု Api က Tablet က Order Edit ၿပီး ပုိ႔ေပးလုိက္တဲ့ Order ကုိ database ထဲမွာ update လုပ္ဖုိ႔ သံုးတယ္။
                </p>
                <ol>
                    <li>Table ကေန Edit လုပ္ၿပီး ျပန္ပုိ႔ေပးလာတဲ့  user_id,take_id,order_id,extra_price,discount_amount,total_price,service_amount,room_charge,tax_amount,net_price,order_table,order_room,order_detail,order_status,
tablet_id အစရွိတာေတြကုိ json format နဲ႔ ပုိ႔ေပးလုိက္တယ္။
</li>
                    <li>order_table အထဲမွာမွ table_id ေတြကုိ array အေနနဲ႔ ေသာ္လည္းေကာင္း၊</li>
                    <li>order_room အထဲမွာ room_id ေတြကုိ array အေနနဲ႔ေသာ္လည္းေကာင္း</li>
                    <li>order_detail အထဲမွာ order တစ္ေစာင္ခ်င္းစီရဲ႕ item_id,order_detail_id,set_id,quantity,order_type_id,discount_amount,exception,promotion_id,price,amount,status,take_item
အစရွိတာေတြကုိ array အေနနဲ႔ ပုိ႔ေပးလုိက္တယ္။</li>
                    <li>data အေဟာင္းဆုိရင္ 
သက္ဆုိင္ရာ table ေတြကုိ database အထဲ သက္ဆုိင္ရာ table အလုိက္ update သြားသိမ္းတယ္။ data အသစ္ဆုိရင္ သက္ဆုိင္ရာ table ေတြကုိ database အထဲ သက္ဆုိင္ရာ table အလုိက္ သြားသိမ္းတယ္။</li>
                </ol>
                <p>&nbsp;</p>
                <h4>Sample Input Json</h4>
                <div class="sample-input">
                    <pre>
                    [
                        {
                            "take_id":"1",
                            "order_detail":[
                                {
                                    "set_id":"null",
                                    "status":"1",
                                    "extra":[

                                    ],
                                    "exception":"",
                                    "order_detail_id":"2170727000251",
                                    "discount_amount":"0.0",
                                    "promotion_id":"null",
                                    "amount":2000,
                                    "set_item":[

                                    ],
                                    "take_item":1,
                                    "price":2000,
                                    "item_id":"32",
                                    "quantity":1,
                                    "order_type_id":"2"
                                },
                                {
                                    "set_id":"null",
                                    "status":"1",
                                    "extra":[

                                    ],
                                    "exception":"",
                                    "order_detail_id":"2170727000252",
                                    "discount_amount":"100.0",
                                    "promotion_id":"null",
                                    "amount":1900,
                                    "set_item":[

                                    ],
                                    "take_item":1,
                                    "price":2000,
                                    "item_id":"34",
                                    "quantity":1,
                                    "order_type_id":"2"
                                },
                                {
                                    "set_id":"null",
                                    "status":"1",
                                    "extra":[

                                    ],
                                    "exception":"",
                                    "order_detail_id":"2170727000253",
                                    "discount_amount":"200.0",
                                    "promotion_id":"null",
                                    "amount":1800,
                                    "set_item":[

                                    ],
                                    "take_item":1,
                                    "price":2000,
                                    "item_id":"38",
                                    "quantity":1,
                                    "order_type_id":"2"
                                },
                                {
                                    "set_id":"null",
                                    "status":"1",
                                    "extra":[

                                    ],
                                    "exception":"",
                                    "order_detail_id":"2170727000254",
                                    "discount_amount":"200.0",
                                    "promotion_id":"null",
                                    "amount":1800,
                                    "set_item":[

                                    ],
                                    "take_item":1,
                                    "price":2000,
                                    "item_id":"38",
                                    "quantity":1,
                                    "order_type_id":"2"
                                }
                            ],
                            "tax_amount":375,
                            "net_price":8250,
                            "extra_price":0,
                            "order_id":"217072700025",
                            "service_amount":375,
                            "total_price":7500,
                            "discount_amount":500
                        }
                    ]
                    </pre> 
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "message": "Success"
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingContinent">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseContinent" aria-expanded="true" aria-controls="collapseOne">
                URL - http://localhost:8080/api/v1/table_status
                </a>
            </h4>
        </div>
        <div id="collapseContinent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingContinent">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/table_status</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Continent data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,name FROM <span class="text-danger">continent</span> Server Database and Response Json in its value.</li>
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
                        "continents": [
                            {
                                "id": 1,
                                "name": "Pork"
                            },
                            {
                                "id": 2,
                                "name": "Chicken"
                            },
                            {
                                "id": 3,
                                "name": "Fish"
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->
</div><!-- End Panel Group -->