$(".hida_item").on('click', function() {
    $(".multiselect_item").slideToggle('fast');
});

$('.multiselect_item').on('click', '.par', function (e) {//don't toggle the span tag which contains the + or - signs
    if(e.target == e.currentTarget) {//check whether parent element is clicked
        //alert('parent element clicked');
        $(this).children().not("#sign").toggle();
    }

    var id = $(this).attr('id');//get value of id attribute to add in html()
    //check action of toggle is visible or hidden
    var isVisible = $(this).children().is(":visible");//if visible , return true
    var isHidden = $(this).children().is(":hidden");//if hidden , return false
    if(isVisible){
        $(this).children('span').text("- ");
    }
    if(isHidden){
        $(this).children('span').text("+ ");
    }
});
//can check only one checkbox

$('.multiselect_item').on('click', '.item_check', function () {
    $('.item_check').not(this).prop('checked',false);
});

//pass checkbox value to text box
$('.multiselect_item').on('click', '.item_check', function () {
    var res = $(this).val();
    //alert(res);
    $('#category').val(res);
});

/**
 * Created by Dell on 3/24/2016.
 */

$(document).ready(function(){

    $('.sub').hide();
    $('.selectedValue').hide();
    $('.multiselect').hide();


    $(".hida").on('click', function() {
        $(".multiselect").slideToggle('fast');
    });

    $('.multiselect').find('.main').click(function(){
        $(this).next().toggle(); //Expand or collapse this panel
        var id = $(this).attr('id');//get value of id attribute to add in html()
        //check action of toggle is visible or hidden
        var isVisible = $(this).next().is(":visible");//if visible , return true
        var isHidden = $(this).next().is(":hidden");//if hidden , return false
        if(isVisible){
            $(this).html("-"+id);//change + to -
        }
        if(isHidden){
            $(this).html("+ "+id);//change - to +
        }
    });

    //Displaying selected value in span
    $('.sub input[type="checkbox"]').on('click', function() {

       $(".hida").hide();
        $('.selectedValue').show();


        var title  = $(this).parent().find('span').html(),
            title=$(this).parent().find('span').html()+",";


        if ($(this).is(':checked')) {
            var html = '<span title="' + title + '">' + title + '</span>';
            $('.selectedValue').append(html);

        } else {
            $('span[title="' + title + '"]').remove();
        }
    });

});
