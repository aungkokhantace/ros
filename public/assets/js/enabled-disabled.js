function enable(){

        var data = [];
        $("input[name='check_item']:checked").each(function () {
            data.push($(this).val());
        });
        var d = typeof(data);

        //console.log(data[]);
        if (data[0] == null) {
            sweetAlert("Oops...", "Please select at least one item to enable!", "error");
        }
        else{
            window.location = "/Cashier/Item/item_enabled/" + data;
    }
}

function disable(){

        var data = [];
        $("input[name='check_item']:checked").each(function () {
            data.push($(this).val());
        });
        var d = typeof(data);

        //console.log(data[]);
        if (data[0] == null) {
            sweetAlert("Oops...", "Please select at least one item to disable!", "error");
        }
        else{
            window.location = "/Cashier/Item/item_disabled/" + data;
    }
}

function catenable(){

    var data = [];
    $("input[name='category-check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    //console.log(data[]);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one category to enable!", "error");
    }
    else{
        window.location = "/Cashier/cat_enabled/" + data;
    }
}

function catdisable(){

    var data = [];
    $("input[name='category-check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    //console.log(data[]);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one category to disable!", "error");
    }
    else{
        window.location = "/Cashier/cat_disabled/" + data;
    }
}

function roomenable(){

    var data = [];
    $("input[name='room_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    //console.log(data[]);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one category to enable!", "error");
    }
    else{
        window.location = "/Cashier/Room/room_enabled/" + data;
    }
}

function table_enable(){

    var data = [];
    $("input[name='table_check']:checked").each(function () {
        data.push($(this).val());
    });
    var d = typeof(data);

    //console.log(data[]);
    if (data[0] == null) {
        sweetAlert("Oops...", "Please select at least one category to enable!", "error");
    }
    else{
        window.location = "/Cashier/Table/table_enabled/" + data;
    }
}