
var URL = window.location.host;

var  productDetailCount = $('#product_detail_count').val();    
var  productDetailRunningNo = 0;

// $("button.btn-add-product-detail").live('click', function() {

//     var productDetailRunningNo = 0;
//     var count = $("#product_detail_count").val() - 0;

//     $("#product_detail_count").val(++count);
//     productDetailCount++;

//     var $tr = $("#product_detail_table tbody tr:first");
//     var $clone = $tr.html();
    
//     var $form="<tr>"+$clone+"</tr>";  

//     $('#product_detail_table tbody tr:last').after($form);

// }); 


// $("button.btn-remove-product-detail").live('click',function(){
//     if(productDetailCount==0){
//         alert("There must be at least one item!");
//         return false;
//     }

// 	$(this).closest('tr').remove();

// 	productDetailCount--;

// 	var count = $("#product_detail_count").val() - 0;
// 	$("#product_detail_count").val(--count);
	
// });

function addContinent(){
    // let productDetailCount = 0; 
    var count       = $("#product_detail_count").val() ;   
    var counter     = 2;
        if(count <= counter){
        console.log(count + 'counter is  ' + counter);
         $("#product_detail_count").val(++count);
            productDetailCount++;
            var $tr = $("#product_detail_table tbody tr:first").clone(true).find(".rm-attr-0").removeAttr("selected").end();
            $button = $('<button type="button" class="btn red  btn-remove-product-detail" onclick="removeContinent(this)"><span class="glyphicon-minus">Remove</span></button>');
            if ($('#is_update').val()) {
            var $btn = $tr.find('.btn-add-product-detail');
            $button.insertAfter($btn);
            }
            var $clone = $tr.html();
            
            var $form="<tr>"+$clone+"</tr>";  

            $('#product_detail_table tbody tr:last').after($form);
            }
            else{
                  alert("Only 3 textboxes allow");
            }
}


function removeContinent(x) {
    if(productDetailCount==1){
        alert("There must be at least one item!");
        return false;
    }

    x.closest('tr').remove();

    productDetailCount--;

    var count = $("#product_detail_count").val() - 0;
    $("#product_detail_count").val(--count);
    
}


$("button.btn-add-product-detail-edit").live('click', function() {

    var productDetailRunningNo = 0;
    var count = $("#product_detail_count").val() - 0;
    console.log(count + 'proudct' + productDetailRunningNo);    

    $("#product_detail_count").val(++count);
    productDetailCount++;

    var $tr = $("#product_detail_table tbody tr:first");
    var $clone = $tr.html();
    var $form = $("<tr>" + $clone + "</tr>");
    $form.find(":input").val("");
    
    $('#product_detail_table tbody tr:last').after($form);

}); 


$("button.btn-remove-product-detail-edit").live('click',function(){
    
    if(productDetailCount==1){
        alert("There must be at least one item!");
        return false;
    }

    // var parentRow = $(this).closest('tr');

    // // //delete using ajax
    // $.get('/product/detail/destroy/'+ $(this).closest('tr').find('#product_detail_id').val(), 
    // function(data, status, xhr){       

    //     parentRow.remove();
        
    //     productDetailCount--;

    //     var count = $("#product_detail_count").val() - 0;
    //     $("#product_detail_count").val(--count);

    // });    

    $(this).closest('tr').remove();
    productDetailCount--;
    var count = $("#product_detail_count").val() - 0;
    $("#product_detail_count").val(--count);
});



var  productGalleryCount = $('#gallery_count').val();

var  productGalleryRunningNo = 0;

$("button.btn-add-product-gallery").live('click', function() {

    var productGalleryRunningNo = 0;
    var count = $("#product_gallery_count").val() - 0;

    $("#product_gallery_count").val(++count);
    productGalleryCount++;

    var $tr = $("#product_gallery_table tbody tr:first");
    var $clone = $tr.html();

    var $form=$("<tr>"+$clone+"</tr>");  
    $form.find("img").attr("src","");
    $('#product_gallery_table tbody tr:last').after($form);

}); 

$("button.btn-remove-product-gallery").live('click',function(){

    console.log(productGalleryCount);

    if(productGalleryCount==0){
        alert("There must be at least one item!");
        return false;
    }

    $(this).closest('tr').remove();
    productGalleryCount--;

    var count = $("#product_gallery_count").val() - 0;
    $("#product_gallery_count").val(--count);
    
});

$("button.btn-add-product-gallery-edit").live('click', function() {

    var productGalleryRunningNo = 0;
    var count = $("#product_gallery_count").val() - 0;

    $("#product_gallery_count").val(++count);
    productGalleryCount++;

    var $tr = $("#product_gallery_table tbody tr:first");
    var $clone = $tr.html();

    var $form=$("<tr>"+$clone+"</tr>");  
    $form.find("img").attr("src","");
    $form.find(":input").val("");
    $('#product_gallery_table tbody tr:last').after($form);

}); 

//image gallery remove 
$("button.btn-remove-product-gallery-edit").live('click',function(){

    var parentRow = $(this).closest('tr');
    var row  = $(this).closest('tr').find('#product_gallery_id').val();
    
    if(productGalleryCount==1){
        alert("There must be at least one image!");
        return false;
    }    

    if(row){

        window.location ="/admin/product/gallery/destroy/"+ row;

    }else{
        $(this).closest('tr').remove();
        productGalleryCount--;
        var count = $("#product_gallery_count").val() - 0;
        $("#product_gallery_count").val(--count);
    }
    // //delete using ajax
    // $.get('/product/gallery/destroy/'+ $(this).closest('tr').find('#product_gallery_id').val(), {
        
    // }, function(data, status, xhr){

    //     alert(data);
    //     console.log(xhr);

    //     parentRow.remove();
    //     productGalleryCount--;

    //     var count = $("#product_gallery_count").val() - 0;
    //     $("#product_gallery_count").val(--count);

    // });

   
});