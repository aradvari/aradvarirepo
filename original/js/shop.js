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

    var ekezet=new Array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�"," ");
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
