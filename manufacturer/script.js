$(function(){
   $('[data-toggle="tooltip"]').tooltip();
   $("#invalid_cred_alert").fadeTo(3000, 1000).slideUp(500, function(){
  	  $("#invalid_cred_alert").alert('close');
	});

   // Adding a new Product
	$("#addNewProductForm").submit(function(e) {
		e.preventDefault(); // avoid to execute the actual submit of the form.

		// Move cropped image data to hidden input
        var imageData = $('#image-cropper').cropit('export');
        $('.cropped-image').val(imageData);

	    var url = "../api/v1/manufacturer/product"; // the script where you handle the form input.

	    $.ajax({
	           type: "POST",
				url: url,
	           data: $('#addNewProductForm').serialize(),
	            beforeSend: function() {
	            	$('#addNewProductFormFieldset').attr('disabled','disabled');
	           		$('#addProductStatusWindow').html("<i class=\"fa fa-spin fa-circle-o-notch fa-5x\" style=\"color:green\"></i>");
	           },
	           success: function(data)
	           {
	           		if(data.status == "success"){
	           			$('#addNewProductFormFieldset').slideUp('400');
	           			$('#addProductStatusWindow')
	           			.html("<div class=\"alert alert-success\"><strong>Success!<\/strong> Your Product was Added.<\/div>"); 
	           		}
	           }
	         });
	    return false;
	     
	});
	
	// Reset the Add Product Modal for the next call
	$('#addNewProductModal').on('show.bs.modal', function (event) {
			$('#addNewProductFormFieldset').removeAttr('disabled');
			$("#addNewProductForm")[0].reset();
			$('.cropit-image-preview').removeAttr('style');
			$('#addProductStatusWindow').html("");
			$('#addNewProductFormFieldset').show();
	});

	// Show all Products Button
	$('#showAllProductsBtn').click(function(){

		if($('#searchSorting').prop('checked')){var sort='A';}else{var sort='D';} 

		 var url = "../api/v1/manufacturer/product/search/*"; // the script where you handle the form input.

		 var token = $('#token').val();

	    $.ajax({
	           type: "GET",
				url: url,
	            data: {'token' : token,'sort' : sort},
	            beforeSend: function() {
	            	//$('#addNewProductFormFieldset').attr('disabled','disabled');
	           		//$('#addProductStatusWindow').html("<i class=\"fa fa-spin fa-circle-o-notch fa-5x\" style=\"color:green\"></i>");
	           },
	           success: function(data)
	           {
	           		/*if(data.status == "success"){
	           			$('#addNewProductFormFieldset').slideUp('400');
	           			$('#addProductStatusWindow')
	           			.html("<div class=\"alert alert-success\"><strong>Success!<\/strong> Your Product was Added.<\/div>"); 
	           		}*/
	           }
	         });

	})
	
});