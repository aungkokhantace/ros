function New_Member_Form(){
    window.location='/Cashier/Member/create';
}

function New_Promotion_Form(){
    window.location='/Cashier/Promotion/create';
}

function member_type_form_create(){
    window.location='/Cashier/MemberType/create';
}

function table_create(){
    window.location='/Cashier/Table/create';
}

function item_create(){
    window.location='/Cashier/Item/create';
}

function user_create() {
    window.location='/Cashier/Staff/create';
}

function role_create(){
    window.location='/Cashier/StaffType/create';
}

function category_create(){
    window.location ='/Cashier/Category/create';
}

function extra_create(){
    window.location='/Cashier/AddOn/create';
}

function discount_entry_form_create(){
    window.location="/Cashier/Discount/create";
}
function room_create(){
    window.location = '/Cashier/Room/create';
}

function set_create(){
    window.location = '/Cashier/SetMenu/create';
}

function kitchen_create(){
    window.location = '/Cashier/Kitchen/create';
}

function location_create(){
    window.location = '/Cashier/Location/create';
}
function permission_create(){
    window.location = '/Cashier/Permission/create';
}
//BestSelling
function select_best_selling_item(value)
{
    //alert(value);
    window.location.href="/Cashier/select_best_selling_item/"+value;
}

function select_best_selling_item_with_date(value)
{
    //alert(value);
    window.location.href="/Cashier/select_best_selling_item_with_date/"+value;
}

//For Edit 

/**
 * Created by Dell on 3/25/2016.
*/

function MemberEdit() {

    var data = [];
    $("input[name='member-check']:checked").each(function () {
        data.push($(this).val());
    });

    if (data[0] == null ) {
        sweetAlert("Oops...", "Please select at least one item to edit!", "error");
    }
    else if (data[1] != null) {
        sweetAlert("Oops...", "You can select one item to edit in one time!", "error");
    }
    else
        window.location='/Cashier/Member/edit/'+data[0];
}

function Booking_Edit() {
    var data = [];
    $("input[name='booking-check']:checked").each(function(){
        data.push($(this).val());
    });
    if(data[0] == null){
        sweetAlert("Oops...","Please select at least one item to edit!","error");
    }
    else if(data[1] != null){
        sweetAlert("Oops...","You can select one item to edit in one time!","error");
    }
    else
        window.location='/Cashier/Booking/edit/'+data[0];
}

function PromotionEdit(){
    var data = [];
    $("input[name='promotion-check']:checked").each(function(){
        data.push($(this).val());
    });
    if(data[0] == null){
        sweetAlert("Oops...","Please select at least one item to edit!", "error");
    }
    else if (data[1] != null) {
        sweetAlert("Oops...","You can select one item to edit in one time!", "error");
    }
    else
        window.location='/Cashier/Promotion/edit/'+data[0];
}

function categoryEdit() {

    var data = [];
    $("input[name='category-check']:checked").each(function () {
        data.push($(this).val());
    });

    if (data[0] == null) {
        sweetAlert("Oops...", "You must select at least one item to edit !", "error");
    }
    else if (data[1] != null) {
        sweetAlert("Oops...", "You can select only one item to edit in one time!", "error");
    }
    else
        window.location = "/Cashier/Category/edit/" + data;
}


function member_type_edit() {

    var data = [];
    $("input[name='member_type_check']:checked").each(function () {
        data.push($(this).val());
    })

    if (data[0] == null) {
        sweetAlert("Oops...", "You can select at least one item to edit !", "error");
    }
    else if (data[1] != null) {
        sweetAlert("Oops...", "You can select one item to edit in one time!", "error");

    } else
        window.location = "/Cashier/MemberType/edit/" + data;
}


function discount_edit() {
    var data = [];

    $("input[name='check']:checked").each(function () {
        data.push($(this).val());
    })

    if (data[0] == null || data[1] >1) {
        sweetAlert("Oops...", "Please select at least one item to edit!", "error");
    }
    else {
        window.location='/Cashier/Discount/edit/'+data[0];
    }
}


function extra_edit() {
    var data = [];

    $("input[name='extra_check']:checked").each(function () {
        data.push($(this).val());
    })

    if (data[0] == null || data[1] >1) {
        sweetAlert("Oops...", "Please select at least one item to edit!", "error");
    }
    else {
        window.location='/Cashier/AddOn/edit/'+data[0];
    }
}

//Khin Zar Ni Wint
function user_edit() {
    var data = [];
    $("input[name='usercheck']:checked").each(function () {
        data.push($(this).val());
    })

    if (data[0] == null || data[1] > 1) {
        sweetAlert("Oops...", "Please select at least one item to edit!", "error");
    }
    else {
        window.location = '/Cashier/Staff/edit/' + data[0];
    }
}
//Khin Zar Ni Wint
function table_edit() {
    var data = [];
    $("input[name='table_check']:checked").each(function () {
        data.push($(this).val());
    });

    if (data[0] == null) {
        sweetAlert("Oops...", "You can select at least one item to edit !", "error");
    }
    else if (data[1] != null) {
        sweetAlert("Oops...", "You can select one item to edit in one time!", "error");
    }
    else
        window.location = "/Cashier/Table/edit/" + data;
}

function item_edit() {

    var data = [];
    $("input[name='check_item']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    if (data[0] == null) {

        sweetAlert("Oops...", "Please select at least one item to edit !", "error");

    }
    else if (data[1] != null) {

        sweetAlert("Oops...", "Please select only one item to edit !", "error");

    }
    else {
        window.location = "/Cashier/Item/edit/" + data;
    }
}
function room_edit() {
    var data = [];
    $("input[name='room_check']:checked").each(function () {
        data.push($(this).val());
    });

    if (data[0] == null) {
        sweetAlert("Oops...", "You can select at least one item to edit !", "error");
    }
    else if (data[1] != null) {
        sweetAlert("Oops...", "You can select one item to edit in one time!", "error");
    }
    else
        window.location = "/Cashier/Room/edit/" + data;
}



function sub_menus_edit() {

    var data = [];
    $("input[name='sub_check']:checked").each(function () {
        data.push($(this).val());
    });

    if (data[0] == null ) {

        sweetAlert("Oops...", "Please select at least one item to edit!", "error");

    }
    else if (data[1] != null) {
        sweetAlert("Oops...", "You can select one item to edit in one time!", "error");
    }

    else
        window.location='/Cashier/SetMenu/edit/'+data[0];


}


function role_edit() {
    var data = [];
    $("input[name='row_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    if (data[0] == null) {

        sweetAlert("Oops...", "Please select at least one item to edit !", "error");

    }
    else if (data[1] != null) {

        sweetAlert("Oops...", "Please select only one item to edit !", "error");

    }
    else {
        window.location = "/Cashier/StaffType/edit/" + data;
    }
}

function check_date(){
    var from = $('#datepicker').val();
    var to = $('#datepicker1').val();
    if( from == null ){
        sweetAlert("Oops...","Please Choose a Date")
    }
}

// Start Kitchen Setting
function kitchen_edit(){
    var data = [];
    $("input[name='kitchen_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    if (data[0] == null) {

        sweetAlert("Oops...", "Please select at least one to edit !", "error");

    }
    else if (data[1] != null) {

        sweetAlert("Oops...", "Please select only one to edit !", "error");

    }
    else {
        window.location = "/Cashier/Kitchen/edit/" + data;
    }
}
//End Kitchen Setting

// Start Kitchen Setting
function location_edit(){
    var data = [];
    $("input[name='location_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    if (data[0] == null) {

        sweetAlert("Oops...", "Please select at least one to edit !", "error");

    }
    else if (data[1] != null) {

        sweetAlert("Oops...", "Please select only one to edit !", "error");

    }
    else {
        window.location = "/Cashier/Location/edit/" + data;
    }
}
//End Kitchen Setting

//Start Permission
function permission_edit(){
    var data = [];
    $("input[name='module_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    console.log(data);
    if (data[0] == null) {

        sweetAlert("Oops...", "Please select at least one to edit !", "error");

    }
    else if (data[1] != null) {

        sweetAlert("Oops...", "Please select only one to edit !", "error");

    }
    else {
        window.location = "/Cashier/Permission/edit/" + data;
    }
}
//End Permission

//Delete
//user delete
function user_delete() {
    var data = [];
    $("input[name='usercheck']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/Staff/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/Staff/index";
                    //index page which show list
                }
            });
    }
}

//user delete

//booking delete

function Booking_Delete() {
    var data = [];
    $("input[name='booking-check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/Booking/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/Booking/index";
                    //index page which show list
                }
            });
    }
}

//End booking delete


    //=========================MemberDelete Function================//
    function MemberDelete(){

        var data = [];
        $("input[name='member-check']:checked").each(function() {
            data.push($(this).val());
        });
        var d= typeof(data);

        //console.log(data[]);

        if(data[0] == null){

            sweetAlert("Oops...", "Please select at least one item to delete !", "error");

        }
        else{
            swal({   title: "Are you sure?",
                    text: "You will not be able to recover this record!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55 ",
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location ="/Cashier/Member/delete/"+data; ///Route name of delete function
                        //route path to do deletion in controller
                    } else {

                        window.location ="/Cashier/Member/index";/// url name in route.php
                        //index page which show list
                    }
                });

        }

    }

function categoryDelete(){

    var data = [];
    $("input[name='category-check']:checked").each(function() {
        data.push($(this).val());
    });
    var d= typeof(data);

    if(data[0] == null){
        sweetAlert("Oops...", "Please select at least one category to delete !", "error");
    }
    else{
        swal({   title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {

                    window.location ="/Cashier/Category/delete/"+data;

                } else {

                    window.location ="/Cashier/Category/index/";
                }
            });

    }
}


//multi-delete item
function item_delete(){

    var data = [];
    $("input[name='check_item']:checked").each(function() {
        data.push($(this).val());
    });
    var d= typeof(data);

    //console.log(data[]);

    if(data[0] == null){
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else{
        swal({   title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    window.location ="/Cashier/Item/delete/"+data;
                    //route path to do deletion in controller
                } else {

                    window.location ="/Cashier/Item/index";
                    //index page which show list
                }
            });

    }

}

function member_type_delete() {

    var data = [];
    $("input[name='member_type_check']:checked").each(function () {
        data.push($(this).val());
    });
    //var d = typeof(data);


    if (data[0] == null) {

        sweetAlert("Oops...", "Please select at least one item to delete !", "error");

    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/MemberType/delete/" + data;
                    //route path to do deletion in controller
                } else {

                    window.location = "/Cashier/MemberType/index";
                    //index page which show list
                }
            });
    }
}


function discount_delete(){

    var data = [];
    $("input[name='check']:checked").each(function() {
        data.push($(this).val());
    });
    var d= typeof(data);
    if(data[0] == null){
        sweetAlert("Oops...", "Please select atleast one item to delete !", "error");
    }
    else{
        swal({   title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    window.location ="/Cashier/Discount/delete/"+data;

                } else {

                    window.location ="/Cashier/Discount/index";
                    //index page which show list
                }
            });
    }
}
function extra_delete() {

    var data = [];
    $("input[name='extra_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/AddOn/delete/" + data;
                    //route path to do deletion in controller
                } else {

                    window.location = "/Cashier/AddOn/index";
                    //index page which show list
                }
            });
    }
}
//table delete
function table_delete() {
    var data = [];
    $("input[name='table_check']:checked").each(function () {
        data.push($(this).val());
    });
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/Table/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/Table/index";
                    //index page which show list
                }
            });
    }
}
//table delete


//Payment Confirmation

//room delete
function room_delete() {
    var data = [];
    $("input[name='room_check']:checked").each(function () {
        data.push($(this).val());
    });
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = "/Cashier/Room/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location.href = "/Cashier/Room/index";
                    //index page which show list
                }
            });
    }
}


//role delete
function role_delete() {
    var data = [];
    $("input[name='row_check']:checked").each(function () {
        data.push($(this).val());
    });
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55   ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/StaffType/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/StaffType/index";
                    //index page which show list
                }
            });
    }
}
//role delete



function sub_menus_delete() {
    var data = [];
    $("input[name='sub_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one item to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/SetMenu/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/SetMenu/index";
                    //index page which show list
                }
            });
    }
}

// Start Kitchen delete
function kitchen_delete(){
    var data = [];
    $("input[name='kitchen_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/Kitchen/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/Kitchen/index";
                    //show listing
                }
            });
    }
}
//End kitchen delete

// Start Kitchen delete
function location_delete(){
    var data = [];
    $("input[name='location_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/Location/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/Location/index";
                    //show listing
                }
            });
    }
}
//End kitchen delete


//PromotionDelete
function PromotionDelete(){
    var data = [];
    $("input[name='promotion-check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one to delete !", "error");
    }
    else {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = "/Cashier/Promotion/delete/" + data;
                    //route path to do deletion in controller
                } else {
                    window.location = "/Cashier/Promotion/index";
                    //show listing
                }
            });
    }
}
//End kitchen delete


//Cancel

function member_type_cancel(){
    window.location.href='/Cashier/MemberType/index';
}
function table_cancel() {
    window.location.href = '/Cashier/Table/index';
}
function user_cancel() {
    window.location.href = '/Cashier/Staff/index';
}

function discount_listing_form_back()
{
    window.location='/Cashier/Discount/index';
}
function booking_listing_form_back(){
    window.location='/Cashier/Booking/index';
}
function categoryList() {
    window.location = '/Cashier/Category/index';
}

function show_item_list() {
    window.location = '/Cashier/Item/index';
}

function Member_Cancel_Form(){
    window.location='/Cashier/Member/index';
}

function Item_Cancel_Form() {
    window.location.href = '/Cashier/Item/index';
}

function room_cancel(){
    window.location.href = '/Cashier/Room/index';
}

function role_cancel(){
    window.location.href='/Cashier/StaffType/index';
}

function extra_listing_form_back()
{
    window.location.href='/Cashier/AddOn/index';
}
function sub_listing_form_back()
{
    window.location.href='/Cashier/SetMenu/index';
}
function config_cancel(){
    window.location.href='/Cashier/Config/general_config';
}

function profile_cancel(){
    window.location.href='/Cashier/Profile/company_profile';
}

function kitchen_cancel(){
    window.location.href='/Cashier/Kitchen/index';
}
function location_cancel(){
    window.location.href='/Cashier/Location/index';
}

function permission_cancel(){
    window.location.href='/Cashier/Permission/index';
}
 function booking_cancel(id){

     swal({   title: "Are you sure?",
     text: "You will not be able to recover this record!",
     type: "warning",
     showCancelButton: true,
     confirmButtonColor: "#68A219 ",
     cancelButtonColor: "#ff0005",
     confirmButtonText: "Confirm",
     cancelButtonText: "Cancel",
     closeOnConfirm: false,
     closeOnCancel: false
     },
     function(isConfirm){
     if (isConfirm) {
     window.location ="/Cashier/Booking/bookingCancel/"+id; ///Route name of delete function
     //route path to do deletion in controller
     } else{
     window.location ="/Cashier/Booking/index";/// url name in route.php
     //index page which show list
     }
     });
 }

function Promotion_Cancel_Form(){
    window.location.href = '/Cashier/Promotion/index';
}


//Sweet Alert By theodore
$('#btn-payment').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this payment!",
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#86CCEB",
        confirmButtonText: "Confirm",
        closeOnConfirm: false
    }, function(isConfirm){
        if (isConfirm) form.submit();
    });
});

// function confirmCancle() {
//     var id  = $(this).attr('id');
//     alert(id);
    // $(document).ready(function(){
    //     $.ajax({
    //         url: 'invoice/cancel/' + id,
    //         type: 'get',
    //         contentType: 'application/x-www-form-urlencoded',
    //         success: function (response) {
    //             //service.php response
    //             console.log(response);
    //         }
    //     });
    // });    
// }

// $('.order-cancel').on('click',function(e){
//     e.preventDefault();
//     var id      = this.id;
//     var role    = '<?php echo $roleCheck; ?>';
//     alert(role);
//     swal({
//         title: "Are you sure?",
//         text: "You will not be able to recover this payment!",
//         type: "success",
//         showCancelButton: true,
//         confirmButtonColor: "#86CCEB",
//         confirmButtonText: "Confirm",
//         closeOnConfirm: false
//     }, function(isConfirm){
//         if (isConfirm) {
//              $(document).ready(function(){
//                 $.ajax({
//                     url: 'invoice/cancel/' + id,
//                     type: 'get',
//                     contentType: 'application/x-www-form-urlencoded',
//                     success: function (data) {
//                         var message = data.message;
//                         if (message == 'success') {
//                             swal.close();
//                             $(".tr-" + id).fadeOut('5000');
//                         }
//                     }
//                 });
//             });    
//         };
//     });

// });


function checkRole() {
    $(document).ready(function(){
        var managerLogin    = $('#adm-user').val();
        var managerPass     = $('#adm-pass').val();
        var orderId         = $('#orderId').val();
        if (managerLogin == '' || managerPass == '') {
            $("#error-blank").fadeTo(1000,1).fadeOut(5000);
        } else {
                $.ajax({
                    url: 'invoice/manager/confirm/' + managerLogin + '/' + managerPass,
                    type: 'get',
                    contentType: 'application/x-www-form-urlencoded',
                    success: function (data) {
                        var message = data.message;
                        if(message == 'success') {
                            swal({
                                title: "Are you sure?",
                                text: "You will not be able to recover this payment!",
                                type: "success",
                                showCancelButton: true,
                                confirmButtonColor: "#86CCEB",
                                confirmButtonText: "Confirm",
                                closeOnConfirm: false
                            }, function(isConfirm){
                                if (isConfirm) {
                                    cancelOrder(orderId);
                                    $("#manager-modal .close").click();   
                                };
                            });
                        } else {
                            $("#error-wrong").fadeTo(1000,1).fadeOut(5000);    
                        }
                    }
                });
        }
    });
}







