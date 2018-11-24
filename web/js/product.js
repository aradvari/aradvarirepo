function selectSize(vonalkod) {
    console.log('selectSize:' + $('label[for="v_' + vonalkod + '"]').data('trigger'));
    // $('label[for="v_' + vonalkod + '"]').tooltip('show');

    $('#meret option[value="' + vonalkod + '"]').prop('selected', true).trigger('change');
}

var showSelect = function (on) {

    if (on) {
        $('#keszlet').show();
        $('.cart-form button').prop('disabled', false).html('Hozzáadás a kosárhoz');
    } else {
        $('#keszlet').hide();
        $('.cart-form button').prop('disabled', true).html('Válassz méretet...');
        $('input[name="meret_radio"]').prop('checked', false);
    }

}

$('#meret, input[name="sizes"]').change(function (event) {

    var code = $(this).val();

    $.ajax({
        method: "POST",
        url: "/termekek/ajax-get-quantity",
        data: {vonalkod: code}
    }).done(function (result) {

        var selector = '#keszlet > select[name="mennyiseg"]';
        $(selector).find('option').remove().end();

        $("a[data-slug]").each(function (obj, o) {
            if (result.products[$(this).data('slug')] == undefined) {
                $(this).css('opacity', '0.2');
            } else {
                $(this).css('opacity', '1');
                this.href = $(this).data('url') + "?size=" + result.selectedSize;
            }
        });

        if (result.quantity > 0) {
            for (var i = 1; i <= result.quantity; i++) {

                $(selector).append($("<option/>", {
                    value: i,
                    text: i
                }));

            }
        } else {
            showSelect(false);
        }

        showSelect(true);
    });

});

$('.cart-form').submit(function (event) {

    event.preventDefault();

    $.ajax({
        method: "POST",
        url: "/cart/ajax-add-item",
        data: $('.cart-form').serialize()
    }).done(function (result) {

        if (result.mennyiseg > 0) {
            addNotice('A termék a kosárba került. <br /><b>' + result.termek.ar + ' Ft</b>', '/kosar');

            glami('track', 'AddToCart', {
                item_ids: [result.termek.id + '-' + result.meret], // product ID currently added to a cart. Use the same ID as you use in the feed (ITEM_ID).
                product_names: [result.termek.megnevezes], // product name currently added to a cart. Use the same names as you use in the feed (PRODUCTNAME).
                value: result.termek.megnevezes.replace(' ', ''), // product price
                currency: 'HUF' // product price currency
            });

        }else {
            addNotice('A termékből nincs elegendő mennyiség, hogy a kosaradba helyezd!', '/kosar');
        }

        if ($('input[name="meret_radio"]').length > 1) {

            $("input:radio").attr("checked", false);
            $("input:radio").removeAttr("checked");
            $('.cart-form')[0].reset();
            showSelect(false);

        }

        //Szinszűrés deafult
        $("a[data-slug]").each(function (obj, o) {
            $(this).css('opacity', '1');
            this.href = $(this).data('url');
        });

        refreshCartCount();
        getCart();
    });

});

$(function () {
    // $('.carousel').each(function () {
    //     var $carousel = $(this);
    //     var hammertime = new Hammer(this, {
    //         recognizers: [
    //             [Hammer.Swipe, {direction: Hammer.DIRECTION_HORIZONTAL}]
    //         ]
    //     });
    //     hammertime.on('swipeleft', function () {
    //         $carousel.carousel('next');
    //     });
    //     hammertime.on('swiperight', function () {
    //         $carousel.carousel('prev');
    //     });
    // });
});