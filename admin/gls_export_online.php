<?
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=ISO-8859-2");

require('include/login.php');

mysql_query("SET NAMES 'latin2';");

require ("classes/functions.class.php");
$func = new functions();

/**
* A megadott statisztikai ID alapján, letöltére adja át a generált statisztikát
*/
$query = mysql_query($_SESSION['gls_export']); 


$response='';
while ($adatok = mysql_fetch_row($query)){
    
    if(!$lastid) $lastid = $adatok[0];	// utolso ID az elso lekerdezett sorba kerul be
	
	$response.=

ucwords(trim($adatok[1])).";"											//nev
.ucwords(trim($adatok[1])).";"											//rovid nev
.ucwords(trim($adatok[4])).";"											//varos
.trim($adatok[3]).";HU;"										//irsz orsz.kod
.ucfirst(trim(str_replace("()", "", $adatok[5]))).";;"					//cim + ures kod
.trim(str_replace("", "", $adatok[6])).";"						//tel
.trim($adatok[2]).";\n";										//mail

}

/**
* @desc HEADER-be írás
*/
ob_start();

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");

header("Content-disposition: attachment; filename=gls-".$_SESSION['felhasznalok']['id_tol']."-".$lastid.".csv");

// header
$ph = "cimzett neve; rovid nev; varos; irsz; orszagkod; cim;  kapcsolattarto; telszam; email;\n";

$ph .= $response;

header("Content-length: ".strlen($ph));

print $ph;

ob_end_flush();

die();

?>