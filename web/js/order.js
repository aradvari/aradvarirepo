$('#felhasznalok-irszam, #megrendelesfej-szallitasi_irszam').change(function () {

    if ($(this).attr('id') == 'felhasznalok-irszam') {
        var selectors = {
            'varos': '#felhasznalok-id_varos',
            'varos_nev': '#felhasznalok-varos_nev'
        };
    } else if ($(this).attr('id') == 'megrendelesfej-szallitasi_irszam') {
        var selectors = {
            'varos': '#megrendelesfej-szallitasi_id_varos',
            'varos_nev': '#megrendelesfej-szallitasi_varos',
        };
    }

    $.ajax({
        method: "POST",
        url: "/order/ajax-get-city",
        data: {irsz: $(this).val()}
    }).done(function (result) {

        $(selectors.varos).find('option').remove().end();

        if (result && result.itemsCount > 0) {

            $.each(result.items, function (index, value) {
                $(selectors.varos_nev).val(this.HELYSEG_NEV);
                $(selectors.varos).append($("<option/>", {
                    value: this.ID_HELYSEG,
                    text: this.HELYSEG_NEV,
                }));
            });

            // $(selectors.varos).find('option[value="' + result.selected.ID_HELYSEG + '"]').prop('selected', true).change();

            if (result.itemsCount > 1) {
                $(selectors.varos + '-container').show();
                $(selectors.varos_nev + '-container').hide();
            } else {
                $(selectors.varos + '-container').hide();
                $(selectors.varos_nev + '-container').show();
            }

        } else {

            $(selectors.varos_nev).val('');
            $(selectors.varos + '-container').hide();
            $(selectors.varos_nev + '-container').show();

        }

    }).fail(function (result) {

        // $(selectors.varos).hide();
        $(selectors.varos).find('option').remove().end().append($("<option/>", {
            value: '',
        }));

        $(selectors.varos_nev).val('');
        $(selectors.varos + '-container').hide();
        $(selectors.varos_nev + '-container').show();

    });

});

$('input[name="MegrendelesFej[id_szallitasi_mod]"]').change(function () {

    console.log($(this).val());
    var checked = ($(this).val() == 3);

    if (checked) {

        $('.gls-container').show();
        initGLSPSMap();

    } else {

        $('.gls-container').hide();

    }

    $('#megrendelesfej-szallitasi_irszam').attr('readonly', checked);
    $('#megrendelesfej-szallitasi_varos').attr('readonly', checked);
    $('#megrendelesfej-szallitasi_utcanev').attr('readonly', checked);
    $('#megrendelesfej-szallitasi_hazszam').attr('readonly', checked);
    $('#megrendelesfej-gls_kod').attr('readonly', checked);

});

$('#megrendelesfej-eltero_szallitasi_adatok').change(function () {

    var checked = $(this).is(':checked');

    if (checked) {
        $('.szallitas-container').show();
    } else {
        $('.szallitas-container').hide();
    }

});

window.glsPSMap_OnSelected_Handler = function (data) {
    // $('#megrendelesfej-szallitasi_nev').val(data.name);
    $('#megrendelesfej-szallitasi_irszam').val(data.zipcode);
    $('#megrendelesfej-szallitasi_varos').val(data.city);
    $('#megrendelesfej-szallitasi_utcanev').val(data.address);
    $('#megrendelesfej-gls_kod').val(data.pclshopid);
    $('#megrendelesfej-eltero_szallitasi_adatok').prop('checked', true).trigger('change');
}

$(function () {
    if ($('#felhasznalok-id_varos').val()) {
        $('#felhasznalok-id_varos').show();
    }
    if ($('#megrendelesfej-szallitasi_id_varos').val()) {
        $('#megrendelesfej-szallitasi_id_varos').show();
    }

    $('input[name="MegrendelesFej[id_szallitasi_mod]"]:checked').trigger('change');

    $('#megrendelesfej-eltero_szallitasi_adatok:checked').trigger('change');

});