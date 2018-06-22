function showHide(id)
{
	if (document.getElementById(id).style.display == "none")
	{
		document.getElementById(id).style.display = '';
	}else if (document.getElementById(id).style.display == "")
	{
		document.getElementById(id).style.display = 'none';
	}
}


function convertString(str){

    var ekezet=new Array("Ö","ö","Ü","ü","Ó","ó","Õ","õ","Ú","ú","Á","á","Û","û","É","é","Í","í"," ");
    var kodolt=new Array("O","o","U","u","O","o","O","o","U","u","A","a","U","u","E","e","I","i","_");
    
    for (i=0;i<ekezet.length;i++){
        kif = "/"+ekezet[i]+"/g";
        mire = kodolt[i];
        str=str.replace(eval(kif),mire);
    }
    
    return str;

}

function convertStrToInt(value){

    var ertek = parseFloat(value).toString();
    if (ertek=="NaN") ertek=0;
    return ertek;
}

var STR_PAD_LEFT = 1;
var STR_PAD_RIGHT = 2;
var STR_PAD_BOTH = 3;
 
function pad(str, len, pad, dir) {
 
    if (typeof(len) == "undefined") { var len = 0; }
    if (typeof(pad) == "undefined") { var pad = ' '; }
    if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }
 
    if (len + 1 >= str.length) {
 
        switch (dir){
 
            case STR_PAD_LEFT:
                str = Array(len + 1 - str.length).join(pad) + str;
            break;
 
            case STR_PAD_BOTH:
                var right = Math.ceil((padlen = len - str.length) / 2);
                var left = padlen - right;
                str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
            break;
 
            default:
                str = str + Array(len + 1 - str.length).join(pad);
            break;
 
        } // switch
 
    }
 
    return str;
 
}

function generateBarcode(id){
    
   var u = (Math.round(new Date().getTime()/1000));
   u = u + "";
   var d1 = u.substr(1,3);
   var d2 = u.substr(6,2);
   var d3 = u.substr(8,2);
   var tid = pad(id+"", 5, '0', STR_PAD_RIGHT)
   return (tid+d3+d1+d2);
    
}

//------------------------------------------------
function input_clear(name) //input form torlese
	{
	//document.login.email.value="";
  document.getElementById(name).value="";
	}
//------------------------------------------------