$('#order-form select[name="s"]').change(function () {
    $('#order-form').submit();
});

var addNotice = function (message, url) {
    $("html, body").animate({scrollTop: 0}, 200, function () {
        if (url)
            $('.notice').attr('onclick', 'document.location.href="' + url + '"');
        $('.notice').html(message).fadeIn();
    });
}

var refreshCartCount = function () {

    $.ajax({
        method: "GET",
        url: "/cart/get-cart-count",
    }).done(function (result) {
        $('.cart-count').html('(' + result.count + ')')
    });

}

var getCart = function () {

    $.ajax({
        method: "GET",
        url: "/cart/get-cart",
    }).done(function (result) {
        $('.cart-container').html(result);
        $('.cart-container-top').html(result);
    });

}

var deleteCartItem = function (meret) {

    $.ajax({
        method: "POST",
        url: "/cart/ajax-delete-cart-item",
        data: {
            'meret': meret
        }
    }).done(function (result) {
        refreshCartCount();
        getCart();
    });

}

$(document).on("change", 'select[name="quantity"]', function () {

    var prop = $(this).val().split('#');

    $.ajax({
        method: "POST",
        url: "/cart/ajax-add-item",
        data: {
            'meret': prop[1],
            'mennyiseg': prop[0],
            'modify': true,
        }
    }).done(function (result) {

        refreshCartCount();
        getCart();

    });

});

$(document).on("change", 'input[name="kupon"]', function () {

    $.ajax({
        method: "POST",
        url: "/cart/ajax-set-code",
        data: {
            'kupon': $(this).val(),
        }
    }).done(function (result) {

        getCart();

    });

});

$(function () {
    refreshCartCount();
    getCart();

    $('[data-toggle="tooltip"]').tooltip()

    $('.navbar .dropdown').hover(function () {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();

    }, function () {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

    });

    $('.navbar .dropdown > a').click(function () {
        location.href = this.href;
    });
});

/* Customer logo */
$('#customerLogos').on('slide.bs.carousel', function (e) {

    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 4;
    var totalItems = $('#customerLogos.carousel-item').length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $('#customerLogos.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('#customerLogos.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});

/* Product list */
$('#productList').on('slide.bs.carousel', function (e) {

    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 4;
    var totalItems = $('#productList.carousel-item').length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $('#productList.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('#productList.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});


$('#my-orders td').click(function (e) {
    var id = $(this).closest('tr').data('token');
    if (!$('#my-orders tr[data-parent-token="' + id + '"]').length)
        $(this).closest('tr').after('<tr data-parent-token="' + id + '" style="display:none"><td colspan="4">SOR</td></tr>');

    $.ajax({
        method: "POST",
        url: "/order/ajax-get-order",
        data: {'id': id}
    }).done(function (result) {

        $('#my-orders tr[data-parent-token="' + id + '"] td').html(result);
        $('#my-orders tr[data-parent-token="' + id + '"]').toggle('slow');

    });
});