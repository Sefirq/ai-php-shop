
$(document).ready(function (){
    //alert("hehe");
    var height = 0;
    $('tr').not(document.getElementsByClassName("header")).each(function(){
        height = jQuery(this).height() > height ? jQuery(this).height() : height;
    }).height(height);
});

$(document).ready(function () {
    $('.link_dialog').on('click', function (e) {
        $('#opened').css('visibility', 'visible');
        var link = this;
        e.preventDefault();
        $('#opened').dialog({
            autoOpen: true,
            modal: true,
            title: 'Choose number of items',
            buttons: {
                'OK': function () {
                    var name = $('input[name="name"]').val();
                    var togo = link.href.concat('&nr=', name);
                    window.location.replace(togo);
                    $(this).dialog('close');
                },
                'Cancel': function () {
                    $(this).dialog('close');
                }
            }
        });

        function storeData(name) {
            // do whatever you want here, like an alert
            // alert(name);
        }
    });
});

$(document).ready(function () {
    var sum = 0;
    var $dataRows=$("#baskettable tr:not('.header')");
    $dataRows.each(function() {
        $(this).find('.price').each(function(){
            price=parseFloat( $(this).html());
        });
        $(this).find('.number').each(function(){
            number=parseInt( $(this).html());
        });
        sum += parseFloat(price) * parseInt(number);
    });
    if (isNaN(sum)){
        $('#totalprice').text('0');
    }
    else{
        $('#totalprice').text(String(sum));
    }
});
