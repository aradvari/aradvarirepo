function selectSize(vonalkod) {
    $('#meret option[value="' + vonalkod + '"]').prop('selected', true).change();
}

jQuery(function () {
    $("#carousel-thumb").swiperight(function() {
        $(this).carousel('prev');
    });
    $("#carousel-thumb").swipeleft(function() {
        $(this).carousel('next');
    });
});

$('#meret').change(function () {

    $.ajax({
        method: "POST",
        url: "/termekek/ajax-get-quantity",
        data: {vonalkod: $(this).val()}
    }).done(function (result) {

        var selector = '#keszlet > select[name="mennyiseg"]';
        $(selector).find('option').remove().end();

        if (result.quantity > 0) {
            for (var i = 1; i <= result.quantity; i++) {

                $(selector).append($("<option/>", {
                    value: i,
                    text: i
                }));

            }
        } else {
            $('#keszlet').hide();
        }

        $('#keszlet').show();
    });

});

$('.cart-form').submit(function () {

    event.preventDefault();

    $.ajax({
        method: "POST",
        url: "/cart/ajax-add-item",
        data: $('.cart-form').serialize()
    }).done(function (result) {

        if (result.mennyiseg > 0)
            addNotice('A termék a kosárba került. <br /><b>' + result.termek.ar + ' Ft</b>', '/kosar');
        else
            addNotice('A termékből nincs elegendő mennyiség, hogy a kosaradba helyezd!', '/kosar');

        if ($('input[name="meret_radio"]').length > 1) {

            $("input:radio").attr("checked", false);
            $("input:radio").removeAttr("checked");
            $('.cart-form')[0].reset();
            $('#keszlet').hide();

        }

        refreshCartCount();
        getCart();
    });

});