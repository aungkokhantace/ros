$(document).ready(function(){
	$('.payment-type').click(function(){
		$('.payment-type').removeClass("btn-active");
		payment_id 		= $(this).attr("id");
		$('#' + payment_id).addClass("btn-active");

		//If Click Pay Cash
		if (payment_id == 'payment-cash') {
			$('.pay-cash').show();
			$('.pay-card').hide();
		}

		//If Click Pay Card
		if (payment_id == 'payment-card') {
			$('.pay-card').show();
			$('.pay-cash').hide();
		}
	});

	//If User click Cash Button
	$('.mpu-type').click(function(){
		cash_id 		= $(this).attr("id");
		var dataString = { 
              cash_id : cash_id,
              _token : '{{ csrf_token() }}'
        };
		$.ajax({
			url 	: '/Cashier/transaction_tenders/store',
			type 	: 'POST',
			data 	: dataString,
			dataType: "json",
            cache 	: false,
        	success: function(msg) {
	            alert('Success');
	        },
	        error: function(msg) {
	        	alert('Error');    
	        }
		});
	});

	$('#payment-cash').click();
})