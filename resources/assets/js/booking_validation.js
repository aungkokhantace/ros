/*
$.validator.addMethod("graterThan", function(value, element,date) {
    //If false, the validation fails and the message below is displayed

    var st= $(date).val();
    console.log(st);
    var etime=parseInt(value.replace(/:/g,""),10);
    var stime=parseInt(st.replace(/:/g,""),10);
    return etime>stime;
}, "End time must be larger than start time");
$().ready(function() {
    $("#booking-insert").validate({
        rules : {
            to_time:{graterThan:"#from_time"}
        }
    });
});*/
/*
$('#booking-insert').submit(function(e){
    var to = $('#to_time').val().replace(/ /g,'');
    var from = $('#from_time').val().replace(/ /g,'');
    var to_sub = to.substring(6);
    var from_sub = from.substring(6);
    if(to_sub=="AM") var to_replace = to.replace(':AM',' AM');
    else var to_replace = to.replace(':PM',' PM');
    if(from_sub == "AM") var from_replace = from.replace(':AM',' AM');
    else var from_replace = from.replace(':PM',' PM');
    console.log(to_sub);
});*/