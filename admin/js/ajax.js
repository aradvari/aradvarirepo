function divOrszagSelect(id_orszag){

    if (id_orszag=="1"){
        
        $('hun1').show();
        $('hun2').show();
        $('eng1').hide();
        $('eng2').hide();
        
    }else{
        
        $('hun1').hide();
        $('hun2').hide();
        $('eng1').show();
        $('eng2').show();

    }
    
}

function divHelysegek(divName, id_megye, selectName, selectedId){
    new Ajax.Updater(divName, "ajax/ajax.helysegek.php", { 
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
    new Ajax.Request('ajax/ajax.iranyitoszam.php',   {     
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

function checkSession(){
    new Ajax.PeriodicalUpdater("session", "ajax/ajax.felhasznalok.php", { 
        method: 'post',
        frequency: 5,
        decay: 2, 
        parameters: {
            none: ''
        },
        onFailure: function(){ 
            //alert('AJAX adatbázis hiba történt. Kérjük próbálja meg újra!');
        }   
    });
}
