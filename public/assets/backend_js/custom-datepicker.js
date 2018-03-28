 $('.dateTimePicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        allowInputToggle: true
    });

$(".dateTimePicker").keypress(function(event) {event.preventDefault();});

$(document).ready(function(){
  $("#from_date").datepicker({
		format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date(),
       
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate() + 1);
        $('#to_date').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('#to_date').datepicker('setStartDate',null);
  });

  $("#to_date").datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          startDate: new Date()
      }).on('changeDate', function (selected) {
          var endDate = new Date(selected.date.valueOf());
          $('#from_date').datepicker('setEndDate', endDate);
      }).on('clearDate', function (selected) {
          $('#from_date').datepicker('setEndDate',null);
  });

  $("#from").datepicker({
    format: 'dd-mm-yyyy',
        autoclose: true
       
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate() + 1);
        $('#to').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('#to').datepicker('setStartDate',null);
  });
  
  $("#to").datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true
         
      }).on('changeDate', function (selected) {
          var endDate = new Date(selected.date.valueOf());
          $('#from').datepicker('setEndDate', endDate);
      }).on('clearDate', function (selected) {
          $('#from').datepicker('setEndDate',null);
  });

  $("#monthpicker1").datepicker({
          format: 'mm-yyyy',
          viewMode: "months",
          minViewMode: "months",
          allowInputToggle:true,
          autoclose: true
          
      }).on('changeDate', function (selected) {
          var endDate = new Date(selected.date.valueOf());
          endDate.setDate(endDate.getDate() + 1);
          $('#monthpicker2').datepicker('setStartDate', endDate);
      }).on('clearDate', function (selected) {
          $('#monthpicker2').datepicker('setStartDate',null);
  });

  $("#monthpicker2").datepicker({
        format: 'mm-yyyy',
        viewMode: 'months',
        minViewMode:'months',
        allowInputToggle:true,
        autoclose:true
        
        }).on('changeDate', function (selected) {
          var endDate = new Date(selected.date.valueOf());
          $('#monthpicker1').datepicker('setEndDate', endDate);
      }).on('clearDate', function (selected) {
          $('#monthpicker1').datepicker('setEndDate',null);
  })

  $("#summary_year").datepicker({
    format:"yyyy",
    viewMode: "years",
    minViewMode: "years",
    allowInputToggle: true,
    autoclose: true
  })   

});

  