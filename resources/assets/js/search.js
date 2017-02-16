//member_type
$('#member_type_search').keyup(function(e){
    console.log($(this).val());
    var url = 'getmembertype?term='+$(this).val();
    var jqxhr = $.get( url, function(json) {
            $('#member_type_listing tbody').html("");
            var i = 1;
            json.forEach(function(value, index, ar){
                var member_type = value.id;
                var temp_html=
                    '<tr class="active">' +
                    '<td><input class="source" type="checkbox" name="member_type_check" value='+ member_type+ ' />'+ i++ +'</td>'+
                    '<td><a href="/Cashier/member_type_edit/'+member_type+'">'+value.type+'</a></td>' +
                    '<td>'+value.description+'</td>' +
                    '<td>'+value.discount_amount+'% </td>' +
                    '<td>'+value.life_time+' years</td>' +
                    '</tr>';
                $('#member_type_listing tbody').append(temp_html);
            });
        })
        .fail(function() {
            alert( "error" );
        })
});

//ExtraFoodSearch
$('#extra_search').keyup(function(e){
    extraSearch();
});
$('#extra_status').change(function(e){
    extraSearch();
});
function extraSearch(){
    var txt = $('#extra_search').val();
    var url = '/Cashier/getextra?term='+txt;
    var status = document.getElementById('extra_status');
    if(status.selectedIndex != 0){
        var st = $('#extra_status').val();
        url += '&term1=' + st;
    }
    console.log('url :'+url);
    var jqxhr = $.get( url, function(json) {
        $('#extra_listing tbody').html("");
        var i = 1;
        json.forEach(function(value, index, ar){
            var extra_id = value.id;
            var extra_status = "";
            if(value.status == 0){
                extra_status = "Not Available";
            }
            else{
                extra_status = "Available";
            }
            var temp_html=
                '<tr class="active">' +
                '<td><input class="source" type="checkbox" name="extra_check" value='+ extra_id+ ' />'+ i++ +'</td>'+
                '<td><a href="/Cashier/extra_edit/'+extra_id+'">'+value.food_name+'</a></td>' +

                '<td>'+value.name+'</td>' +
                '<td>'+value.description+'</td>' +

                '<td>'+value.image+'</td>' +

                '<td>'+value.price+'</td>' +
                '<td>'+extra_status+'</td>' +
                '</tr>';
            $('#extra_listing tbody').append(temp_html);

        });
    }).fail(function(){
        alert("error");
    })
}


//OrderSearch
$('#orderauto').keyup(function(e){
    console.log($(this).val());
    var url = '/Cashier/getorder?term='+$(this).val();
    console.log(url);
    var jqxhr = $.get( url, function(json) {
            $('#tbl_listing tbody').html("");
        console.log("hello");
            json.forEach(function(value, index, ar){
                var order = value.order_id;
                console.log(order);
                var temp_html=
                    '<tr class="active">' +
                    '<td>'+order+'</td>'+
                    '<td>'+value.order_time+'</td>' +
                    '<td>'+value.user_id+'</td>' +
                    '<td>'+value.table_id+'</td>' +
                    '<td>'+value.name+'</td>' +
                    '<td>'+value.price+'</td>' +
                    '<td>'+value.quantity+'</td>' +
                    '<td>'+value.exception+'</td>' +
                    '<td>'+value.extra+'</td>' +
                    '<td>'+value.order_type_id+'</td>' +
                    '<td>'+value.status_id+'</td>' +
                    '<td>'+value.total_amount+'</td>' +
                    '</tr>';
                $('#tbl_listing tbody').append(temp_html);
            });
        })
        .fail(function() {
            alert( "error" );
        })
});


//set menus searrch

//ExtraFoodSearch
$('#sub_search').keyup(function(e){
    subSearch();
});
$('#sub_status').change(function(e){
    subSearch();
});
function subSearch(){
    var txt = $('#sub_search').val();
    var url = '/Cashier/getsub?term='+txt;
    var status = document.getElementById('sub_status');
    if(status.selectedIndex != 0){
        var st = $('#sub_status').val();
        url += '&term1=' + st;
    }
    console.log('url :'+url);
    var jqxhr = $.get( url, function(json) {
        $('#sub_menus_listing tbody').html("");
        var i = 1;
        json.forEach(function(value, index, ar){
            var sub_id = value.id;
            var sub_status = "";
            if(value.status == 0){
                sub_status = "Not Available";
            }
            else{
                sub_status = "Available";
            }
            var food = "";
            value.item.forEach(function(v, i, a){
                food = (food.length!=0)?( food += ','+v):food += food += v;
            });
            var temp_html=
                '<tr class="active">' +
                '<td><input class="source" type="checkbox" name="sub_check" value='+ sub_id+ ' />'+ i++ +'</td>'+
                '<td><a href="/Cashier/sub_menus_edit/'+sub_id+'">'+value.sub_menus_name+'</a></td>' +
                '<td>'+food+'</td>'+
                '<td>'+value.image+'</td>' +
                '<td>'+value.sub_menus_price+'</td>' +



                '<td>'+sub_status+'</td>' +
                '</tr>';
            $('#sub_menus_listing tbody').append(temp_html);

        });
    }).fail(function(){
        alert("error");
    })
}
//start user
$('#auto').keyup(function(e){
    userSearch();
});
$('#auto1').change(function(e){
    userSearch();
});
$('#auto2').change(function(e){
    userSearch();
});
function userSearch(){
    var txtvalue = $('#auto').val();
    var url = '/Cashier/getuser?term='+txtvalue;
    var type = document.getElementById('auto1');
    var status = document.getElementById('auto2');
    if(type.selectedIndex != 0){
        var tvalue = $('#auto1').val();
        url += '&term1=' + tvalue;
    }
    if(status.selectedIndex != 0){
        var svalue = $('#auto2').val();
        url += '&term2=' + svalue;
    }
    var jqxhr = $.get( url, function(json) {
        $('#tbl_listing tbody').html("");
        var i =1;
        json.forEach(function(value, index, ar){
            var userid = value.id;
            var status = value.status;
            var d = new Date(value.last_activity);
            var last_activity = d.getTime();
            var current = Date.now();
            var diff = ((current - last_activity)/1000)/60;
            var image = "";
            if(status == 1){
                if(diff<=60){
                    image = '<img src="/assets/images/Circle_Green.png" class="circle-image">';
                }
                else{
                    image = '<img src="/assets/images/Circle_Red.png" class="circle-image">';
                }
            }
            else{
                image = '<img src="/assets/images/Circle_Red.png" class="circle-image">';
            }
            var temp_html=
                '<tr class="active">' +
                '<td><input type="checkbox" class="user_source" name="usercheck" value="'+value.id+'" id="all">'+ i++ +'</td>'+
                '<td><a href="/Cashier/userEdit/'+userid+'">'+value.user_name+'</a></td>' +

                '<td>'+value.staff_id+'</td>' +
                '<td>'+image+'</td>'+
                '<td>'+value.name+'</td>' +
                '</tr>';
            $('#tbl_listing tbody').append(temp_html);
        });
    }).fail(function(){
        alert("error");
    })
}
//end user

//Start Category Search
$('#categoryauto').keyup(function(e){
    categorysearch();
});
$('#categoryauto1').change(function(e){
    categorysearch();
});

function categorysearch(){
    var txtvalue = $('#categoryauto').val();
    console.log('text :'+txtvalue);
    var url = '/Cashier/getdatacategory?term='+txtvalue;
    var status = document.getElementById('categoryauto1');


    if(status.selectedIndex != 0){
        var svalue = $('#categoryauto1').val();
        url += '&term1=' + svalue;
        console.log('d1 :'+svalue);
    }
    console.log('url :'+url);
    var jqxhr = $.get( url, function(json) {
        $('#tablecategory tbody').html("");
        var i =1;
        json.forEach(function(value, index, ar){
            var name = value.name;
            var status = value.status;
            //alert(status);
            var av = "";
            if(status == 1){
                av = "Available";
            }
            else{
                av = "Not Available";
            }
            var category = value.id;

            var temp_html=
                '<tr class="active">' +
                '<td><input type="checkbox" name="category-check" class="source" value="'+category+'" id="all">'+ i++ +'</td>'+
                '<td><a href="/Cashier/categoryEdit/'+category+'">'+value.name+'</a></td>' +
                '<td>'+ value.kname +'</td>'+
                '<td>'+value.image+'</td>' +
                '<td>'+value.description+'</td>' +
                '<td>'+av+'</td>' +
                '</tr>';
            $('#tablecategory tbody').append(temp_html);
        });
    }).fail(function(){
        alert("error");
    })
}
//End Category Search

//Start Item Search
$('#itemauto').keyup(function(e){
    itemsearch();
});
$('#itemauto1').change(function(e){
    itemsearch();
});
$('#itemauto2').change(function(e){
    itemsearch();
});
function itemsearch(){
    var txtvalue = $('#itemauto').val();
    console.log('text :'+txtvalue);
    var url = '/Cashier/getdataitem?term='+txtvalue;

    var type = document.getElementById('itemauto1');
    var status = document.getElementById('itemauto2');

    if(type.selectedIndex != 0){
        var tvalue = $('#itemauto1').val();
        url += '&term1=' + tvalue;
        console.log('d1 :'+tvalue);
    }
    if(status.selectedIndex != 0){
        var svalue = $('#itemauto2').val();
        url += '&term2=' + svalue;
        console.log('d2 :'+svalue);
    }
    console.log('url :'+url);
    var jqxhr = $.get( url, function(json) {
        $('#tableitem tbody').html("");
        var i = 1;
        json.forEach(function(value, index, ar){
            var name = value.name;
            var status = value.status;
            var av = "";
            if(status == 1){
                av = "Available";
            }
            else{
                av = "Not Available";
            }
            var temp_html=
                '<tr class="active">' +
                //'<td><input type="checkbox" class="source" name="item_check" value="'+value.id+'">'+ i++ +'</td>' +
                '<td><input type="checkbox" class="source" name="check_item" value="'+value.id+'">'+ i++ +'</td>' +
                '<td><a href="/Cashier/item_edit/'+value.id+'">'+name+'</a></td>' +
                '<td>'+value.category_name+'</td>' +
                '<td>'+value.image+'</td>' +
                '<td>'+value.description+'</td>' +
                '<td>'+value.price+'</td>' +
                '<td>'+av+'</td>' +
                '</tr>';
            $('#tableitem tbody').append(temp_html);
        });
    }).fail(function(){
        alert("error");
    })
}
//End Item Search

//Start Discount Search
$('#discount_auto').keyup(function(e){
    console.log($(this).val());
    var url = 'getdatadiscount?term='+$(this).val();
    var jqxhr = $.get( url, function(json) {
            $('#discount_listing tbody').html("");
            var i = 1;
            json.forEach(function(value, index, ar){
                var discount = value.id;
                var temp_html=
                    '<tr class="active">' +
                    '<td><input type="checkbox" name="check" class="source" value="'+discount+'" id="all">'+ i++ +'</td>'+
                    '<td><a href="/Cashier/discount_edit/'+discount+'">'+value.name+'</a></td>' +
                    '<td>'+value.start_date+'</td>' +
                    '<td>'+value.end_date+'</td>' +
                    '<td>'+value.item_name+'</td>'+
                    '<td>'+value.amount+value.type+'</td>' +
                    '</tr>';
                $('#discount_listing tbody').append(temp_html);
            });
        })
        .fail(function() {
            alert( "error" );
        })
});

//End Discount Search


//Start Member Search
/**
 * Created by Dell on 3/28/2016.
 */

$('#member_search').keyup(function(e){
    var url = '/Cashier/getdatamember?term='+$(this).val();
    var jqxhr = $.get( url, function(json) {
            $('#member_listing tbody').html("");
            var i = 1;
            json.forEach(function(value, index, ar){
                console.log(value.name,value.item);
                var temp_html="";
                var food = "";
                value.item.forEach(function(v, i, a){
                    food = (food.length!=0)?( food += ','+v):food += food += v;
                });
                temp_html=
                    '<tr  class="active">' +
                    '<td><input type="checkbox" name="member-check" value="'+value.id+'" id="all" >'+ i++ +'</td>'+
                    '<td><a href="/Cashier/memberEdit/'+value.id+'">'+value.name+'</a></td>' +
                    '<td>'+value.phone+'</td>' +
                    '<td>'+value.email+'</td>' +
                    '<td>'+value.birthdate+'</td>'+
                    '<td>'+food+'</td>'+
                    '<td>'+value.type+'</td>' +
                    '</tr>';
                $('#member_listing tbody').append(temp_html);
            });
        })
        .fail(function() {
            alert( "error" );
        })
});
//End Member Search

$('#staff_type').keyup(function(e){
    var url = '/Cashier/getStaffType?term='+$(this).val();
    var jqxhr = $.get(url, function(json){
            $('#tbl_listing tbody').html("");
            var i = 1;
            json.forEach(function(value, index, ar){
                var staffType = value.id;
                var permission = "";
                console.log(permission);
                value.permission.forEach(function(v,i,a){
                    permission = (permission.length !=0)?(permission += ','+v):permission += permission +=v;
                });
                var temp_html =
                    '<tr>'+
                    '<td><input class="role_source" type="checkbox" name="sub_check" value='+ staffType+ ' />'+ i++ +'</td>'+
                    '<td><a href="/Cashier/roleEdit/'+staffType+'">'+value.name+'</a></td>' +
                    '<td>'+value.id+'</td>'+
                    '<td>'+value.description+'</td>'+
                    '<td>'+permission+'</td>'+
                    '</tr>';
                $('#tbl_listing tbody').append(temp_html);
            })
        })
        .fail(function(){
            alert("error");
        })
});

//Start Table Search
$('#table_search').keyup(function(e){
    tableSearch();
});
$('#table_status').change(function(e){
    tableSearch();
});
function tableSearch(){
    var txt = $('#table_search').val();
    var url = '/Cashier/gettable?term='+txt;
    var status = document.getElementById('table_status');
    if(status.selectedIndex != 0){
        var st = $('#table_status').val();
        url += '&term1=' + st;
    }
    var jqxhr = $.get( url, function(json) {
        $('#tablelisting tbody').html("");
        var i = 1;
        json.forEach(function(value, index, ar){
            var table_id = value.id;
            var table_status = "";
            if(value.status == 0){
                table_status = "Available";
            }
            if(value.status == 1){
                table_status = "Serve";
            }

            var temp_html=
                '<tr  class="active">' +
                '<td><input class="table_source" type="checkbox" name="table_check" value='+ table_id+ ' />'+ i++ +'</td>'+
                '<td><a href="/Cashier/tableedit/'+table_id+'">'+value.table_no+'</a></td>' +
                '<td>'+value.capacity+'</td>' +
                '<td>'+value.location+'</td>' +
                '<td>'+value.area+'</td>' +
                '<td>'+table_status+'</td>' +
                '</tr>';
            $('#tablelisting tbody').append(temp_html);
        });
    }).fail(function(){
        alert("error");
    })
}
//End Table Search

//Start Room Search
$('#room_search').keyup(function(e){
    roomSearch();
});
$('#room_status').change(function(e){
    roomSearch();
});
function roomSearch(){
    var txtvalue = $('#room_search').val();
    var url = '/Cashier/getroom?term='+txtvalue;
    var status = document.getElementById('room_status');
    if(status.selectedIndex != 0){
        var svalue = $('#room_status').val();
        url += '&term1=' + svalue;
    }
    var jqxhr = $.get( url, function(json) {
        $('#roomlisting tbody').html("");
        var i = 1;
        json.forEach(function(value, index, ar){
            var roomid = value.id;
            var status = "";
            if(value.status == 0){
                status = "Available";
            }
            else{
                status = "Serve";
            }
            var temp_html=
                '<tr class="active">' +
                '<td><input type="checkbox" class="room_source" name="room_check" value="'+roomid+'" id="all">'+ i++ +'</td>'+
                '<td><a href="/Cashier/roomEdit/'+roomid+'"> '+value.room_name+'</td>' +
                '<td>'+value.capacity+'</td>'+
                '<td>'+status+'</td>' +
                '</tr>';
            $('#roomlisting tbody').append(temp_html);
        });
    }).fail(function(){
        alert("error");
    })
}
//End Room Search

//Start Kitchen Search
$('#kitchen_search').keyup(function(e){
    var txt = $('#kitchen_search').val();
    var url = '/Cashier/getKitchen?term='+txt;
    var jqxhr = $.get(url, function(json){
            $('#kitchenlisting tbody').html("");
            var i = 1;
            json.forEach(function(value, index, ar){
                var kitchen_id = value.id;
                var temp_html =
                    '<tr class="active">'+
                    '<td><input class="source" type="checkbox" name="kitchen_check" value='+ kitchen_id+ ' />'+ i++ +'</td>'+
                    '<td><a href="/Cashier/kitchen_edit/'+kitchen_id+'">'+value.name+'</a></td>'+
                    '</tr>';
                $('#kitchenlisting tbody').append(temp_html);
            })
        })
        .fail(function(){
            alert("error");
        })
});
//End Kitchen Search

