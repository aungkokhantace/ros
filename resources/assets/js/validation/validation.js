$(document).ready(function() {
    $.validator.addMethod("needsSelection", function(value, element) {
        return $(element).multipleSelect("getChecked").length > 0;
    });
    //For Staff Entry Form
    $('#staffEntryForm').validate({
        rules: {

            name                : "required",
            staff_id            : "required",
            login_password      : {
                required    : true,
                minlength   : 8,

            },

            conpassword         : {
                required    : true,
                minlength   : 8,
                equalTo     : "#login_password"
            },
            userType    : "required"
        },
        messages: {
            name                : "Staff Name is required.",
            staff_id            : "Staff ID is required.",
            login_password      : {
                required    : "Password is required.",
            },
            conpassword         : {
                required    : "Confirm Password is required.",
                equalTo     : "Password and Confirm Password must match."
            },
            userType    : "Staff Type is required."
        }
    });
    //For Staff Edit Form
    $('#staffEditForm').validate({
        rules: {
            name        : "required",
            staff_id    : "required",
            userType    : "required"
        },
        messages: {
            name        : "Staff Name is required.",
            staff_id    : "Staff ID is required.",
            userType    : "Staff Type is required."
        }
    });
    //For Staff Type Entry and edit Form
    $('#staffTypeEntry').validate({
        rules: {
            name        : "required",
            description : "required",
            "permission[]"  : "required",
        },
        messages: {
            name        : "Staff Type Name is required.",
            description : "Staff Type Description is required.",
            "permission[]"    : "Permission is required"
        },
        errorPlacement: function (error, element) { //Positioning Jquery Validation Errors after checkbox value
            if (element.attr("type") == "checkbox") {
                error.insertAfter($(element).parent('#checkbox'));
            }else {
                error.insertAfter( element ); // standard behaviour
            }
        },
    });
    //For Category
    $('#categoryForm').validate({
        rules: {
            name        : "required",
            kitchen     : "required",
            image       : "required",
            description : "required"
        },
        messages: {
            name        : "Category Name is required.",
            kitchen     : "Kitchen is required.",
            image       : "Category Image is required.",
            description : "Description is required."
        }
    });
    $('#category_browse').on('change',function(){
        $('#categoryForm').valid();
    });

    //For Item
    $('#item-validate').validate({
        rules: {
            name        : "required",
            parent_category: "required",
            //price       : "required",
            price        : {
                required : true,
                number : true
            },
            filename    : "required",
            description : "required"
        },
        messages: {
            name        : "Item Name is required.",
            parent_category: "Parent category is required.",
            //price       : "Item Price is required.",
            price        : {
              required : "Item Price is required.",
              number : "Item Price must be numeric."
            },
            filename       : "Item Image is required.",
            description : "Item Description is required."
        }
    });
    $('#item_browse').on('change',function(){
        $('#item-validate').valid();
    });

    //For Extra Food or Add On
    $('#extraForm').validate({
        rules: {
            food_name   : "required",
            category_id : "required",
            description : "required",
            filename       : "required",
            //price       : "required"
            price       : {
              required : true,
              number : true
            }
        },
        messages: {
            food_name   : "Add-on Name is required.",
            category_id : "Category is required.",
            description : "Description is required.",
            filename       : "Add-on Image is required.",
            //price       : "Price is required."
            price       : {
                required : "Add-on Price is requried.",
                number : "Add-on Price must be numeric."
            }
        }
    });
    $('#extra_browse').on('change',function(){
        $('#extraForm').valid();
    });
    //For Discount
    $("#discount").validate({
        rules: {
            name        : "required",
            from_date   : {
                required: true,
            },
            to_date     : {
                required: true,
            },
            product     : "required",
            //amount      : "required"
            amount      : {
                required : true,
                number   :true
            }
        },
        messages: {
            name        : "Discount Name is required.",
            from_date   : {
                required: "Start Date is required.",
            },
            to_date     : {
                required: "End Date is required.",
            },
            product     : "Item is required.",
            //amount      : "Discount Amount is required."
            amount      : {
                required : "Discount Amount is required.",
                number   :"Discount Amount must be numeric."
            }
        }
    });
    //For Set Menu
    $('#setForm').validate({
        rules: {
            sub_menus_name  : "required",
            "item[]"        : "required",
            //sub_menus_price : "required",
            sub_menus_price :{
                required : true,
                number   :true
            },
            image            : "required",
        },
        messages: {
            sub_menus_name  : "Set Menu Name is required.",
            "item[]"        : "Item is required.",
            sub_menus_price :{
                required : "Set Menu Price is required.",
                number   : "Set Menu Price must be numeric."
            },
            image           : "Set Menu Image is required.",
        },
        ignore: ':hidden:not("#Category")', // Tells the validator to check the hidden select
        errorPlacement: function (error, element) { //Positioning Jquery Validation Errors after checkbox value
            if (element.attr("id") == "Category") {
                error.insertAfter($(element).parent('div'));
            }else {
                error.insertAfter( element ); // standard behaviour
            }
        },

    });

    $('#set_browse').on('change',function(){
        $('#setForm').valid();
    });

    $('#Category').change(function() {
        console.log($(this).val());
    }).multipleSelect({
        width: '100%'
    }).on('change',function(){
        $('#setForm').valid();
    });

    
    //For Member
    $("#customer-entry").validate({
        rules: {
            name            : "required",
            phone           : {
                required: true,
                number: true
            },
            birthday        : "required",
            member_card_no  : "required",
        },
        messages: {
            name            : "Member Name is required",
            phone           : {
                required: "Phone is required",
                number: "Phone Number should be number only"
            },
            birthday        : "Birthday is required",
            member_card_no  : 'Member Card No. is required'
        },

    });

    //For Table
    $('#table-form-entry').validate({
        rules: {
            table_no: "required",
            capacity: "required",
            location: "required",
        },
        messages: {
            table_no: "Table No is required.",
            capacity: "Capacity is required.",
            location: "Location is required.",
        },
        errorPlacement: function (error, element) { //Positioning Jquery Validation Errors after checkbox value
            if (element.attr("type") == "checkbox") {
                error.insertAfter($(element).parent('div'));
            }else {
                error.insertAfter( element ); // standard behaviour
            }
        },
    });
    //For Room
    $('#roomForm').validate({
        rules: {
            room_name   : "required",
            capacity    : "required",
        },
        messages: {
            room_name   : "Room Name is required.",
            capacity    : "Capacity is required."
        }
    });
    //For General Setting
    $('#general').validate({
        rules: {
            tax         : "number",
            service     : "number",
            room_charge : "number"
        },
        messages: {
            tax         : "Tax must be numeric",
            service     : "Service must be numeric",
            room_charge : "Room charge must be numeric"
        }
    });
    //For Profile
    $('#profile').validate({
        rules: {
            website     : "url",
            email       : "email"
        },
        //messages: {}
    });
    //For Promotion
    $('#promotion').validate({
        rules: {
            "sell_item[]"       : "required",
            sell_item_qty       : {
                required    : true,
                number      : true,
            },
            present_item        : "required",
            present_item_qty    : {
                required    : true,
                number      : true,
            }
        },
        messages: {
            "sell_item[]"       : "Selling Item is required.",
            sell_item_qty       : {
                required    : "Selling Item Qty is required.",
                number      : "Selling Item Qty must be numeric.",
            },
            present_item        : "Present Item is required.",
            present_item_qty    : {
                required    : "Present Item Qty is required.",
                number      : "Present Item Qty must be numeric.",
            }
        },
        ignore: ':hidden:not("#sell_item")', // Tells the validator to check the hidden select
        errorPlacement: function (error, element) { //Positioning Jquery Validation Errors after checkbox value
            if (element.attr("id") == "sell_item") {
                error.insertAfter($(element).parent('div'));
            }else {
                error.insertAfter( element ); // standard behaviour
            }
        },

    });
    $('#sell_item').change(function() {
        var dd = $('#sell_item').val();
    }).multipleSelect({
        width: '100%'
    }).on('change',function(){
        $('#promotion').valid();
    });
    
    //For Kitchen
    $('#kitchenForm').validate({
        rules: {
            name    : "required"
        },
        messages: {
            name    : "Kitchen Name is required."
        }
    });
    //For Booking Entry

    $("#bookingForm").validate({
        rules: {
            name    : "required",
            date :{
                required: true,
                //dpDate: true
            },
            from_time: "required",
            quantity: {
                required: true,
                number: true
            },
            phone: {
                required: true,
                number: true
            },
        },
        messages: {
            name: "Name is required.",
            date: "Date is required.",
            from_time: "From_time is required.",
            quantity: {
                required: 'Capacity is required.',
                number: 'Capacity must be numeric.'
            },
            phone: {
                required: "Phone is required.",
                number: "Phone Number must be numeric."
            },
        },
    });

    $('#date1').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        startDate: new Date()
    }).on('changeDate', function(e) {
        // Revalidate the date field
        $('#bookingForm').valid();
    });

    $('#from_time').timepicki({
        increase_direction:'up'
    }).on('blur',function(){
        $('#from_time-error').hide();
        $('#from_time').css('color','black');
    });
    //For Booking Edit
    $("#bookingEditForm").validate({
        rules: {
            bname    : "required",
            bdate :{
                required: true,
            },
            bfrom_time: "required",
            bquantity: {
                required: true,
                number: true
            },
            bphone: {
                required: true,
                number: true
            },

        },
        messages: {
            bname: "Name is required",
            bdate: "Date is required",
            bfrom_time: "From_time is required",
            bquantity: {
                required: 'Capacity is required.',
                number: 'Capacity must be numeric.'
            },
            bphone: {
                required: "Phone is required",
                number: "Phone Number should be number only"
            },
        },
    });
});


