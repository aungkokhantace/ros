$().ready(function() {
    // validation for customer-entry
//discount
    $("#discount").validate({
        rules: {
            name: "required",
            from_date: {
                required: true,
            },
            to_date: {
                required: true,
            },
            amount: "required"

        },
        messages: {
            name: "Member Name is required",
            from_date: {
                required: "Start Date is required",

            },
            to_date: {
                required: "End Date is required",
            }
        }
    });



});

