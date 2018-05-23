
<div class="container">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingUser">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseUser" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/user</p>
                </a>
            </h4>
        </div>
        <div id="collapseUser" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUser">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/user</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all users datas to  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract staff_id, user_name FROM users FROM Server Database and Response Json in its value.</li>
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
                        "user": [
                            {
                                "staff_id": "1",
                                "user_name": "admin"
                            },
                            {
                                "staff_id": "2",
                                "user_name": "manager"
                            },
                            {
                                "staff_id": "3",
                                "user_name": "cashier"
                            },
                            {
                                "staff_id": "4",
                                "user_name": "kitchen"
                            },
                            {
                                "staff_id": "6",
                                "user_name": "waiter"
                            },
                            {
                                "staff_id": "7",
                                "user_name": "Kitchen2"
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingCategory">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                <p>URL - http://localhost:8080/api/v1/category</p>
                </a>
            </h4>
        </div>
        <div id="collapseCategory" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingCategory">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/category</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server from Categories,Set Menu,Set Items datas to  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,name,status,parent_id,kitchen_id,image FROM <span class="text-danger">category</span>,
                        id,set_menus_name,set_menus_price,status FROM <span class="text-danger">set_menu</span>
                        id,set_menu_id,item_id FROM <span class="text-danger">set_item</span>
                            Server Database and Response Json in its value.</li>
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
                            "category": [
                                {
                                    "id": 1,
                                    "name": "Myanmar Food",
                                    "status": 1,
                                    "parent_id": 0,
                                    "kitchen_id": 2,
                                    "image": "5a12668c7107a.jpg"
                                },
                                {
                                    "id": 2,
                                    "name": "Chinese Food",
                                    "status": 1,
                                    "parent_id": 0,
                                    "kitchen_id": 1,
                                    "image": "5a127a2b5e7f0.jpeg"
                                },
                                {
                                    "id": 3,
                                    "name": "Thai Food",
                                    "status": 1,
                                    "parent_id": 0,
                                    "kitchen_id": 1,
                                    "image": "5a127a875e288.png"
                                },
                                {
                                    "id": 4,
                                    "name": "Japanese Food",
                                    "status": 1,
                                    "parent_id": 0,
                                    "kitchen_id": 1,
                                    "image": "5a127b385fe7c.png"
                                },
                                {
                                    "id": 5,
                                    "name": "Japanese Noodles",
                                    "status": 1,
                                    "parent_id": 4,
                                    "kitchen_id": 1,
                                    "image": "5a127c77b0647.jpg"
                                }
                            ],
                            "set_menu": [
                                {
                                    "id": 1,
                                    "set_menus_name": "Thai Desserts Set",
                                    "set_menus_price": "5000",
                                    "status": 1
                                },
                                {
                                    "id": 2,
                                    "set_menus_name": "Sushi set",
                                    "set_menus_price": "8000",
                                    "status": 1
                                }
                            ],
                            "set_item": [
                                {
                                    "id": 1,
                                    "set_menu_id": 1,
                                    "item_id": 9
                                },
                                {
                                    "id": 2,
                                    "set_menu_id": 1,
                                    "item_id": 10
                                },
                                {
                                    "id": 3,
                                    "set_menu_id": 2,
                                    "item_id": 4
                                }
                            ]
                        }
                    </pre>
                </div>
            </div>
        </div>
    </div><!-- End Panel Primary -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingAddon">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAddon" aria-expanded="false" aria-controls="collapseAddon">
                <p>URL - http://localhost:8080/api/v1/addon</p>
                </a>
            </h4>
        </div>

        <div id="collapseAddon" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAddon">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/addon</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server Add on datas to  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,food_name,category_id,image,price,status,mobile_image FROM <span class="text-danger">add_on</span> Server Database and Response Json in its value.</li>
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
                            "addon": [
                            {
                            "id": 1,
                            "food_name": "Egg",
                            "category_id": 2,
                            "image": "5a12f5b339a02.jpg",
                            "price": 600,
                            "status": 1,
                            "mobile_image": "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"
                            },
                            {
                            "id": 2,
                            "food_name": "Egg",
                            "category_id": 2,
                            "image": "5a12f5c664de4.jpg",
                            "price": 400,
                            "status": 1,
                            "mobile_image": "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"
                            }
                            ]
                            }
                    </pre>
                </div>
            </div>
        </div>
    </div><!-- End Panel Primary -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingItem">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseItem" aria-expanded="false" aria-controls="collapseItem">
                <p>URL - http://localhost:8080/api/v1/item</p>
                </a>
            </h4>
        </div>
        <div id="collapseItem" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingItem">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/item</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server from Items datas to  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,food_name,category_id,image,price,status,mobile_image FROM <span class="text-danger">item</span> Server Database and Response Json in its value.</li>
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
                    "items": [
                    {
                    "id": 1,
                    "name": "RamenNoodle",
                    "image": "5a127d40c5a65.jpg",
                    "price": "2500",
                    "status": 1,
                    "category_id": 5,
                    "mobile_image": "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",
                    "continent_id": 0,
                    "group_id": "",
                    "isdefault": 0,
                    "has_continent": 0
                    },
                    {
                    "id": 2,
                    "name": "UdonNoodle",
                    "image": "5a127d9390b82.jpg",
                    "price": "3000",
                    "status": 1,
                    "category_id": 5,
                    "mobile_image": "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",
                    "continent_id": 0,
                    "group_id": "",
                    "isdefault": 0,
                    "has_continent": 0
                    }
                    ]
                    }
                    </pre>
                </div>
            </div>
        </div>
    </div><!-- End Panel Primary -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingContinent">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseContinent" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/continent</p>
                </a>
            </h4>
        </div>
        <div id="collapseContinent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingContinent">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/continent</b><br />
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

    <!-- Set Menu -->
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingSetMenu">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSetMenu" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/set_menu</p>
                </a>
            </h4>
        </div>
        <div id="collapseSetMenu" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSetMenu">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/set_menu</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Set Menu data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,set_menus_name,set_menus_price,image,status,mobile_image FROM <span class="text-danger">set_menu</span> Server Database and Response Json in its value.</li>
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
                        "set_menu": [
                            {
                                "id": 1,
                                "set_menus_name": "Thai Desserts Set",
                                "set_menus_price": "5000",
                                "image": "5a128c793a40c.jpg",
                                "status": 1,
                                "mobile_image": "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"
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingSetitem">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSetitem" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/set_item</p>
                </a>
            </h4>
        </div>
        <div id="collapseSetitem" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSetitem">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/set_item</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Set Items data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,set_menu_id,item_id FROM <span class="text-danger">set_item</span> Server Database and Response Json in its value.</li>
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
                        "set_item": [
                            {
                                "id": 1,
                                "set_menu_id": 1,
                                "item_id": 9
                            },
                            {
                                "id": 2,
                                "set_menu_id": 1,
                                "item_id": 10
                            },
                            {
                                "id": 3,
                                "set_menu_id": 2,
                                "item_id": 4
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingConfig">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseConfig" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/config</p>
                </a>
            </h4>
        </div>
        <div id="collapseConfig" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingConfig">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/config</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Config data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract tax,service,booking_warning_time,booking_waiting_time,booking_service_time,room_charge,restaurant_name,logo,mobile_logo,email,website,phone,address,message,remark,mobile_image FROM <span class="text-danger">config</span> Server Database and Response Json in its value.</li>
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
                        "config": [
                            {
                                "tax": 10,
                                "service": 10,
                                "booking_warning_time": "00:15:00",
                                "booking_waiting_time": "00:15:00",
                                "booking_service_time": "00:15:00",
                                "room_charge": 2000,
                                "restaurant_name": "AceplusSolution",
                                "logo": "images.png",
                                "mobile_logo": "images.png",
                                "email": "aceplus@gmail.com",
                                "website": "https://www.aceplussolutions.com",
                                "phone": "092653623",
                                "address": "MICT Park, Building(5) Third Floor",
                                "message": "Enter Message",
                                "remark": "Remark",
                                "mobile_image": " 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"
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->
    
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingContinent">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTable" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/table</p>
                </a>
            </h4>
        </div>
        <div id="collapseTable" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTable">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/table</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Table data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct Select Booking Default,Warning,Waiting Status and table_id for today FROM <span class="text-danger">booking table</span> with lefjoin <span class="text-danger">booking_table</span> table.Extract id,table_no,status and active table FROM tables.If table id is equal with First query from booking table.Change status to Default,Warning,Waiting from booking table and Response Json in its value.</li>
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
                        "table": [
                            {
                                "id": 2,
                                "table_no": "Table2",
                                "status": 0
                            },
                            {
                                "id": 3,
                                "table_no": "Table3",
                                "status": 0
                            },
                            {
                                "id": 4,
                                "table_no": "Table4",
                                "status": 1
                            },
                            {
                                "id": 5,
                                "table_no": "Table5",
                                "status": 0
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingRoom">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseRoom" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/room</p>
                </a>
            </h4>
        </div>
        <div id="collapseRoom" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRoom">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/room</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Room data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct Select Booking Default,Warning,Waiting Status and room_id for today FROM <span class="text-danger">booking table</span> with lefjoin <span class="text-danger">booking_room</span> table.Extract id,room_name,status and active room FROM rooms.If room id is equal with First query from booking room.Change status to Default,Warning,Waiting from booking room and Response Json in its value.</li>
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
                        "room": [
                            {
                                "id": 2,
                                "room_name": "Room2",
                                "status": 1
                            },
                            {
                                "id": 3,
                                "room_name": "Room3",
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
        <div class="panel-heading" role="tab" id="headingDiscount">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDiscount" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/discount</p>
                </a>
            </h4>
        </div>
        <div id="collapseDiscount" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDiscount">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/discount</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server all Discount data  From Database.
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract amount,type,item_id FROM <span class="text-danger">discount</span> and Today Date must between discount start date and end date.If today date have discount, Extract data and Response Json in its value.</li>
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
                        "discount": [
                            {
                                "amount": "2",
                                "type": "%",
                                "item_id": 1
                            },
                            {
                                "amount": "3",
                                "type": "%",
                                "item_id": 1
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingBooking">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseBooking" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/booking</p>
                </a>
            </h4>
        </div>
        <div id="collapseBooking" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingBooking">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/booking</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is synchronizing backend server booking table and table id.According to result booking id select table id from
                booking_table.Push Booking id,customer_name,from_time,to_time and booking_table
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,customer_name,from_time,to_tim from <span class="text-danger">booking table</span>.Extract booking_id,table_id FROM <span class="text-danger">booking_table</span>. Extract booking_id,room_id FROM <span class="text-danger">booking_room</span>.If id from booking table is equal to booking_id from booking_table, push booking_id,table_id,capicity as an array to booking list..If id from booking room is equal to booking_id from booking_room, push booking_id,room_id,capicity as an array to booking list.Response array as json.</li>
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
                        "booking": [
                            {
                                "id": 3,
                                "customer_name": "shwekayin",
                                "from_time": "12:00:00",
                                "to_time": "12:15:00",
                                "booking_table": [
                                    {
                                        "booking_id": 3,
                                        "table_id": 2,
                                        "capicity": 5
                                    }
                                ],
                                "booking_room": []
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingSync">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSync" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/syncs_table</p>
                </a>
            </h4>
        </div>
        <div id="collapseSync" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSync">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/syncs_table</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is used for android to download latest data.It control by version column and if Server version column is greater than Android version column in database, download latest data from server to android. 
                </p>
                <ol>
                    <li>Tablet Send site_activation_key string to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Extract id,table_name,version<span class="text-danger">syncs_tables</span> Server Database and Response Json in its value.</li>
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
                        "syncs_table": [
                            {
                                "id": 1,
                                "table_name": "category",
                                "version": 310
                            },
                            {
                                "id": 2,
                                "table_name": "items",
                                "version": 24
                            },
                            {
                                "id": 3,
                                "table_name": "add_on",
                                "version": 6
                            },
                            {
                                "id": 5,
                                "table_name": "members",
                                "version": 1
                            },
                            {
                                "id": 7,
                                "table_name": "set_menu",
                                "version": 4
                            },
                            {
                                "id": 8,
                                "table_name": "set_item",
                                "version": 8
                            },
                            {
                                "id": 9,
                                "table_name": "rooms",
                                "version": 6
                            }
                        ]
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->

    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingSyncs">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSyncs" aria-expanded="true" aria-controls="collapseOne">
                <p>URL - http://localhost:8080/api/v1/syncs</p>
                </a>
            </h4>
        </div>
        <div id="collapseSyncs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSyncs">
            <div class="panel-body">
                <h4>URL</h4>
                <b>http://localhost:8080/api/v1/syncs</b><br />
                <p>Method -> POST</p><p>&nbsp;</p>
                <h4>Description</h4>
                <p>
                This Api is use for synchronizing updated backend server for android.Android Send string column name to check server.If server has updated value,response json data to android.If server has not updated value, return empty json.
                </p>
                <ol>
                    <li>When update data or insert data in backend, increase version in syncs_tables where update or insert data table name in backend database.</li>
                    <li>Tablet Send site_activation_key string and tables names and table version to Server.</li>
                    <li>Server Check site_activation_key is valid or not from <span class="text-danger">config<span> table.</li>
                    <li>If site_activation_key is wrong, Server Response Unauthorized Message Json Response.</li>
                    <li>If site_activation_key is correct, Check table name and version in Backend database. If Backend version is greater than android version. Synchronizing its table name data.</li>
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
                        <td style="width: 215.383px;">category</td>
                        <td style="width: 219.617px;">310</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">items</td>
                        <td style="width: 219.617px;">24</td>
                    </tr>

                    <tr>
                        <td style="width: 215.383px;">add_on</td>
                        <td style="width: 219.617px;">6</td>
                    </tr>

                    <tr>
                        <td style="width: 215.383px;">members</td>
                        <td style="width: 219.617px;">1</td>
                    </tr>

                    <tr>
                        <td style="width: 215.383px;">set_menu</td>
                        <td style="width: 219.617px;">4</td>
                    </tr>

                    <tr>
                        <td style="width: 215.383px;">set_item</td>
                        <td style="width: 219.617px;">8</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">rooms</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">rooms</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">tables</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">booking</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">config</td>
                        <td style="width: 219.617px;">46</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">promotions</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">promotion_items</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>
                    <tr>
                        <td style="width: 215.383px;">discount</td>
                        <td style="width: 219.617px;">2</td>
                    </tr>

                    </tbody>
                    </table>
                </div>
                <p>&nbsp;</p>
                <h4>Sample Output Json</h4>
                <div class="sample-input">
                    <pre>
                    {
                        "room": [
                            {
                                "id": 1,
                                "room_name": "Room1",
                                "status": 0
                            },
                            {
                                "id": 2,
                                "room_name": "Room2",
                                "status": 1
                            },
                            {
                                "id": 3,
                                "room_name": "Room3",
                                "status": 1
                            },
                            {
                                "id": 4,
                                "room_name": "Room4",
                                "status": 1
                            },
                            {
                                "id": 5,
                                "room_name": "Room5",
                                "status": 0
                            }
                        ],
                        "table": [
                            {
                                "id": 1,
                                "table_no": "Table1",
                                "status": 0
                            },
                            {
                                "id": 2,
                                "table_no": "Table2",
                                "status": 0
                            },
                            {
                                "id": 3,
                                "table_no": "Table3",
                                "status": 0
                            },
                            {
                                "id": 4,
                                "table_no": "Table4",
                                "status": 1
                            },
                            {
                                "id": 5,
                                "table_no": "Table5",
                                "status": 0
                            }
                        ],
                        "booking": [
                            {
                                "id": 3,
                                "customer_name": "shwekayin",
                                "from_time": "12:00:00",
                                "booking_table": [
                                    {
                                        "booking_id": 3,
                                        "table_id": 2
                                    }
                                ],
                                "booking_room": []
                            }
                        ],
                        "discount": [
                            {
                                "id": 1,
                                "name": "Christmax Discoun",
                                "amount": "2",
                                "type": "%",
                                "start_date": "2017-12-12",
                                "end_date": "2017-12-31",
                                "item_id": 1
                            },
                            {
                                "id": 2,
                                "name": "two Year Anniversary",
                                "amount": "3",
                                "type": "%",
                                "start_date": "2017-12-12",
                                "end_date": "2017-12-31",
                                "item_id": 1
                            }
                        ],
                        "category": [],
                        "items": [],
                        "addon": [],
                        "set_menu": [],
                        "set_item": [],
                        "promotion": [],
                        "promotion_item": [],
                        "member": [],
                        "config": []
                    }
                    </pre> 
                </div><!-- End sample-input -->
            </div>
        </div>
    </div><!-- End Collapse Section -->
</div><!-- End Panel Group -->
</div>