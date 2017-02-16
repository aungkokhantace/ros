//extra list
$("#check_all").click(function(event){
    if(this.checked) {
        $('.source').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }else{
        $('.source').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
});

//For User List
$("#user_check_all").click(function(event){
    if(this.checked) {
        $('.user_source').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }else{
        $('.user_source').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
});

//For Table List
$("#table_check_all").click(function(event){
    if(this.checked)
    {
        $('.table_source').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }
    else
    {
        $('.table_source').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
});

//For Room List
$("#room_check_all").click(function(event){
    if(this.checked)
    {
        $('.room_source').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }
    else
    {
        $('.room_source').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
});

//For Role or Staff_Type
$("#role_check_all").click(function(event){
    if(this.checked) {
        $('.role_source').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
        });
    }else{
        $('.role_source').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"
        });
    }
});


function discount_check(value)
{
    //$(document).ready(function() {

        $('#product').on('click', function() {
        $id=value;
            // Add loading state
            $('.place_for_text').html('Loading please wait ...');

            // Set request
            var request = $.get('/Cashier/prices/'+$id);

            // When it's done
            request.done(function(response) {
                $('.place_for_text').html('The old amount for this item is ...'+response);
                $data=response;
            });
        });

    //});

}


$('#amount').focusout(function (e)
{
    var value =  $("input[name='choose']:checked").val();
    if(value=="%")
    {
        if ($(this).val() > 100 || $(this).val() < 0)
        {
            sweetAlert("Percentage amount must be between 0 and 100");
        }
    }
    else
    {
        var id = $('#product').val();
        var request = $.get('/Cashier/prices/'+id);
        request.done(function(response) {
            $data=response;
        });
            var current_value=Number(($(this).val()));
            var old_value=Number($data);
           if(current_value > old_value)
           {
                sweetAlert("Discount Price must be less than your original price!!!");
           }
           else
           {
           }
    }

});

$('#capacity').focus(function(){
    var from = $('#from_time').val();
    var to   = $('#to_time').val();

    var from_time = moment(from,"h:mm:ss tt");
    var to_time   = moment(to,"h:mm:ss tt");
    
    if(from_time.isSame(to_time,'hh:mm:ss')){
       sweetAlert("To time must be greater than From Time");
    }else{
       
    }
});
$('#bquantity').focus(function(){
    var from = $('#bfrom_time').val();
    var to   = $('#bto_time').val();

    var from_time = moment(from,"h:mm:ss tt");
    var to_time   = moment(to,"h:mm:ss tt");
    
    if(from_time.isSame(to_time,'hh:mm:ss')){
       sweetAlert("To time must be greater than From Time");
    }else{
       
    }
});

$('#phone').focus(function(){

    var table = $('#booking_table').val();
    var room  = $('#booking_room').val();

    var request = $.get('/Cashier/Booking/capacity'+table+room);
        request.done(function(response) {
            $data=response;
        });
            var current_value=$('#capacity').val();
            var old_value=Number($data);
           if(current_value > old_value)
           {
                sweetAlert("More Than Seat!!!");
           }
           else
           {
           }
});