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

    $( '.dropdown-menu a.dropdown-toggle' ).on( 'click', function ( e ) {
        var $el = $( this );
        var $parent = $( this ).offsetParent( ".dropdown-menu" );
        if ( !$( this ).next().hasClass( 'show' ) ) {
            $( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
        }
        var $subMenu = $( this ).next( ".dropdown-menu" );
        $subMenu.toggleClass( 'show' );

        $( this ).parent( "li" ).toggleClass( 'show' );

        $( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function ( e ) {
            $( '.dropdown-menu .show' ).removeClass( "show" );
        } );

        if ( !$parent.parent().hasClass( 'navbar-nav' ) ) {
            $el.next().css( { "top": $el[0].offsetTop, "left": $parent.outerWidth() - 4 } );
        }

        return false;
    } );
});

/* Customer logo */
$('#customerLogos').on('slide.bs.carousel', function (e) {

    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 4;
    var totalItems = $('#customerLogos.carousel-item').length;

    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction=="left") {
                $('#customerLogos.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('#customerLogos.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});
