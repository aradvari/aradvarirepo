<?php
  function GetColor($number)
   {
        $color =
        array(
        '#ff0000',
        '#00ff00',
        '#0000ff',
        '#ffff00',
        '#ff00ff',
        '#00ffff',
        '#cc0000',
        '#00cc00',
        '#0000cc',
        '#990000',
        '#009900',
        '#000099',
        '#660000',
        '#006600',
        '#000066',
        '#330000',
        '#003300',
        '#000033',

        '#ff0000',
        '#00ff00',
        '#0000ff',
        '#ffff00',
        '#ff00ff',
        '#00ffff',
        '#cc0000',
        '#00cc00',
        '#0000cc',
        '#990000',
        '#009900',
        '#000099',
        '#660000',
        '#006600',
        '#000066',
        '#330000',
        '#003300',
        '#000033');
        return $color[$number];
  }

function replaceMessage($message) {
   $message    = str_replace ("\n", "<BR>", "$message");

   $message    = str_replace ("[U]", "<U>", "$message");
   $message    = str_replace ("[/U]", "</U>", "$message");
   $message    = str_replace ("[I]", "<I>", "$message");
   $message    = str_replace ("[/I]", "</I>", "$message");
   $message    = str_replace ("[B]", "<B>", "$message");
   $message    = str_replace ("[/B]", "</B>", "$message");

   return $message;
}
 
 //�rt�k �talak�t�sa p�nz�sszeg�v�		-		inttohuf('23000') -> 23.000
	function inttohuf($huf) {
	  $huf = (string)$huf;
	  $ertek='';$how=1;
	  for ($go=strlen($huf)-1; $go>=0; $go--){
	    if ($how>3){$ertek='.'.$ertek;$how=1;}
	    $how++;
	    $ertek=$huf[$go].$ertek;
	  }
	return $ertek;
	}
  
  //�kezetek �s sz�k�z�k elt�ntet�se   -   nullekezet('B�la sz�linapja') -> bela-szulinapja
  function nullekezet($str)
  {
    $ekezet=array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�"," ");
    $nekezet=array("O","o","U","u","O","o","O","o","U","u","A","a","U","u","E","e","I","i","-");
    return(str_replace($ekezet,$nekezet,$str));
  }

  //f�jlfelt�lt�s JPG   -   file_feltoltes('arad.jpg', '/pictures/kepek', 'feltoltott_arad.jpg');
  function file_feltoltes($filenev, $hova, $atnevez){
	if (is_uploaded_file($filenev['tmp_name'])){
      move_uploaded_file($filenev['tmp_name'], $hova.$atnevez); 
      chmod ($hova.$atnevez, 0777);
    }
  }
  
  
  //String Integerr� alak�t�sa
  function convertToInt($string) {
   $y = ltrim($string, '0');
   $z = 0 + $y;
   return $z;
  }
  
?>