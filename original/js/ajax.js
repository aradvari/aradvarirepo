function getGiftEgyenleg(code){
    new Ajax.Request('/ajax/ajax.gift_ellenorzes.php',   {     
        method:'post',  
        parameters: {
          code: code,
          egyenleg:1
        },   
        onSuccess: function(transport){       
            var response = transport.responseText;   
            var ad = response.split ("###");
            $('giftcimsor').innerHTML = ad[0];
            $('giftegyenleg').innerHTML = ad[1];
        },     
        onFailure: function(){ 
            alert('AJAX hiba, a rögzítés sikertelen volt. Kérjük próbálja meg újra!') 
        }   
    }); 
}

function divKosar(divName, kedvezmeny, szallitasi_mod){
    new Ajax.Updater(divName, "/ajax/ajax.kosar.php", { 
        method: 'post',
        parameters: {
          kedvezmeny: kedvezmeny,
          szallitasi_mod: szallitasi_mod
        },   
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function checkGiftCardCode(code,transId){
    new Ajax.Request('/ajax/ajax.gift_ellenorzes.php',   {     
        method:'post',  
        parameters: {
          code: code
        },   
        onSuccess: function(transport){       
            var response = transport.responseText;   
            var ad = response.split ("###");

            $('errorDiv').innerHTML = ad[0];
            divKosar('kosar', ad[1],transId);
        },     
        onFailure: function(){ 
            alert('AJAX hiba, a rögzítés sikertelen volt. Kérjük próbálja meg újra!') 
        }   
    }); 
}

function searchAjax()
{
	new Ajax.Request('/ajax/ajax.search.php',   {     
        method:'post',
        parameters: {
          code: code
        },   
        onSuccess: function(transport){       
            var response = transport.responseText;   
            var ad = response.split ("###");

            $('errorDiv').innerHTML = ad[0];
            divKosar('kosar', ad[1],transId);
        },     
        onFailure: function(){ 
            alert('AJAX hiba, a rögzítés sikertelen volt. Kérjük próbálja meg újra!') 
        }   
    }); 
}

function checkGiftCode(code){
    new Ajax.Request('/ajax/ajax.gift.php',   {     
        method:'post',  
        parameters: {
          code: code
        },   
        onSuccess: function(transport){       
            var response = transport.responseText;   
            var ad = response.split ("###");
            $('errorDiv').innerHTML = ad[1];
            
            if (ad[0]=='ERROR'){
                 $('row0').hide();
                 $('row1').hide();
                 $('row2').hide();
            }else{
                 $('row0').show();
                 $('row1').show();
                 $('row2').show();
            }
        },     
        onFailure: function(){ 
            alert('AJAX hiba, a rögzítés sikertelen volt. Kérjük próbálja meg újra!') 
        }   
    }); 
}

function divKeszletMobile(divName, vonalkod){
    new Ajax.Updater(divName, "/ajax/ajax.keszlet.php", { 
        method: 'post',
        parameters: {
            vonalkod: vonalkod 
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divHelysegek(divName, id_megye, selectName, selectedId){
    new Ajax.Updater(divName, "/ajax/ajax.helysegek.php", { 
        method: 'post',
        parameters: {
            selectedid: selectedId, 
            selectname: selectName,
            id_megye: id_megye,
            uzenet: 'Kérem válassza ki a megyét!'
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divHelysegekNoString(divName, id_megye, selectName, selectedId){
    new Ajax.Updater(divName, "ajax/ajax.helysegek.php", { 
        method: 'post',
        parameters: {
            selectedid: selectedId, 
            selectname: selectName,
            id_megye: id_megye,
            uzenet: ''
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divJelszo(){
    new Ajax.Updater("generalt_jelszo", "ajax/ajax.jelszogeneralas.php", { 
        onSuccess: function(transport){       
            var response = transport.responseText;   
            $('jelszo_uj1').value = response;
            $('jelszo_uj2').value = response;
        }, 
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divKategoriak(id){
    new Ajax.Updater("kategoriavalaszto", "ajax/ajax.kategoriak.php", { 
        method: 'post',
        parameters: {
            kategoria: id 
        },
        onSuccess: function(transport){    
            //divIdotartam(id);   
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divKategoriak_modositas(id, selectedid){
    new Ajax.Updater("kategoriavalaszto", "ajax/ajax.kategoriak.php", { 
        method: 'post',
        parameters: {
            kategoria: id 
        },
        onSuccess: function(transport){    
            //divIdotartam_modositas(id, selectedid);   
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divIdotartam(id){
    new Ajax.Updater("idotartamDiv", "ajax/ajax.idotartam.php", { 
        method: 'post',
        parameters: {
            kategoria: id
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function divIdotartam_modositas(id, selectedid){
    new Ajax.Updater("idotartamDiv", "ajax/ajax.idotartam.php", { 
        method: 'post',
        parameters: {
            kategoria: id,
            selectedid: selectedid
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function getWhitePostCode(isz, obj, vName, divName){
    new Ajax.Request('/ajax/ajax.iranyitoszam.php',   {     
        method:'post',  
        parameters: {
          iszam: isz
        },   
        onSuccess: function(transport){       
            var response = transport.responseText;   
            var ad = response.split ("#");
            if (ad[0]!='') {
              i = obj.selectedIndex=ad[0];
            }
            if (ad[1]!='') {
              divHelysegek(divName, obj.options[obj.selectedIndex].value, vName, ad[1]);
            }
        },     
        onFailure: function(){ 
            alert('AJAX hiba, a rögzítés sikertelen volt. Kérjük próbálja meg újra!') 
        }   
    }); 
}

function addKeyword(kw){
    new Ajax.Updater('kws', 'ajax/ajax.kulcsszotarolas.php',   {     
        method: 'post',
        parameters: {
            kulcsszo: kw
        },
        onSuccess: function(){
            $('kulcsszo').value='';
            $('kulcsszo').focus();
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

function delKeyword(kw){
    new Ajax.Updater('kws', 'ajax/ajax.kulcsszotarolas.php',   {     
        method: 'post',
        parameters: {
            torol: kw
        },
        onFailure: function(){ 
            alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}

