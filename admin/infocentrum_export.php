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

//title
$response = "ID;NAME;ZIP;CITY;ADDRESS;PHONE;FAX;EMAIL;CONTACT;POSTNAME;POSTZIP;POSTCITY;POSTADDRESS;ACCOUNTPREFIX;ACCOUNTNR;TAXNR;EUTAXNR;DISCOUNT;COMMENT;RELIABILITY;";
$response .= "\n";

$last_id=0;
while ($adatok = mysql_fetch_row($query)){
    	
	$response.= $adatok[0].';'	//id
				.trim($adatok[1]).';'	//nev
				.trim($adatok[3]).';'	//irsz
				.trim($adatok[4]).';'	//varos
				.trim(str_replace('()', '', $adatok[5])).';'	//utca hsz em
				.trim(str_replace('', '', $adatok[6]))	//tel
				.';"";'
				.trim($adatok[2])	//email
				.';'
				.trim($adatok[1]).';'	//nev
				.trim($adatok[3]).';'	//irsz
				.trim($adatok[4]).';'	//varos
				.trim(str_replace('()', '', $adatok[5])).';'	//utca hsz em
				.'"";'
				.'"";'
				.'"";'
				.'"";'
				.'"";'
				.'"";'	//szla szam
				.'"";'
				.'"";'				
				."\n";
				
    
	$last_id = $adatok[0];
}

// utolso id

if (isset( $_SESSION['felhasznalok']['id_ig'] ))
	$last = $_SESSION['felhasznalok']['id_ig'];
else
	$last = $last_id;

/**
* @desc HEADER-be írás
*/

$date=date('Ymd');

ob_start();

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");

header("Content-disposition: attachment; filename=IC-CORE-".$date."-felh-".$_SESSION['felhasznalok']['id_tol']."-".$last.".csv");    

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;

ob_end_flush();

die();

?>