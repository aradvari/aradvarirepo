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

var getCart = function (containerSelector) {

    if (!$(containerSelector).length)
        return false;

    $.ajax({
        method: "GET",
        url: "/cart/get-cart",
    }).done(function (result) {
        $(containerSelector).html(result);
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
        getCart('.cart-container');
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
        getCart('.cart-container');

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

        getCart('.cart-container');

    });

});

$(function () {
    refreshCartCount();
    getCart('.cart-container');
});