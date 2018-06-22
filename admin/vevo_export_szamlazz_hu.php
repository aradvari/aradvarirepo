<?
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("content-type:application/csv;charset=UTF-8");
//header("Content-type:text/html; charset=ISO-8859-2");

require('include/login.php');

mysql_query("SET NAMES 'latin2';");


require ("classes/functions.class.php");
$func = new functions();
			
$query = "SELECT 
				szamlazasi_nev as nev,
				id_felhasznalo as id,
				szamlazasi_irszam as irsz,
				szamlazasi_varos as varos,
				CONCAT(szamlazasi_utcanev,' ',szamlazasi_kozterulet,' ',szamlazasi_hazszam) as utcanev,
				id_fizetesi_mod
					
				FROM megrendeles_fej
				WHERE
				
				id_statusz=1 AND
				id_szallitasi_mod=1
				";

			
$query_data = mysql_query($query);

//header
$response='"partner neve","partner azonosító","ország","irányítószám","település","utca és házszám","számla típus (E/P/EP)","alapértelmezett fizetési mód","fizetési határidő (nap)"';
$response.="\n";

//"Csaba Norbert","",,"2316","Tököl","Állomás utca 37","",,"","","","",,"","EP","bankkártya","0",,,,,


$fiz_modok = array(1 => 'utánvét', 2 => 'bankkártya');

while ($adatok = mysql_fetch_row($query_data)) {
	
	$fiz_mod=$fiz_modok[$adatok[5]];
	
	$response.= '"'.$adatok[0].'","'.$adatok[1].'","Magyarország","'.$adatok[2].'","'.$adatok[3].'","'.$adatok[4].'","EP","'.$fiz_mod.'","5"';
	$response.="\n";
    
}

/**
* @desc HEADER-be írás
*/
ob_start();

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

//header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");
header("content-type:application/csv;charset=UTF-8");

header("Content-disposition: attachment; filename=szamlazz.hu_vevok_".date('Ymd_Hi').".csv");

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;

ob_end_flush();

die();

?>