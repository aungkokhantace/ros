// /**
//  * Created by Dell on 3/29/2016.
//  */
 var today=new Date();

   $('.datepicker').datepicker({
    format: 'dd-mm-yyyy (D)',
    autoclose: true,
    keyboardNavigation : true ,
    daysOfWeekDisabled : [0],
    startDate:new Date(),
    
});

