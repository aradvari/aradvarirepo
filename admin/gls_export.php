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


/*
// clean up lekerdezes 2011.01.01.-tol
$query = mysql_query("SELECT f.id, (
			CASE WHEN LENGTH( f.cegnev ) <3
			THEN CONCAT( f.vezeteknev,  ' ', f.keresztnev ) 
			ELSE f.cegnev
			END
			), f.email, f.irszam, f.varos_nev, CONCAT( f.utcanev,  ' ', f.kozterulet_nev,  ' ', f.hazszam,  ' (', f.emelet,  ')' ) , CONCAT( f.telefonszam1,  ' ', f.telefonszam2 ) 
			FROM felhasznalok f
			WHERE f.torolve IS NULL ".$_SESSION['felhasznalok_query']."
			AND ( (aktivacios_kod IS NULL) OR (aktivacios_kod =  '') )
			AND f.utolso_belepes >  '2011-01-01'
			ORDER BY f.id DESC"); */



$response='';
while ($adatok = mysql_fetch_row($query)){
	
	/*$response.= 
				$adatok[0].";".
				trim($adatok[1]).";".
				trim(str_replace("()", "", $adatok[5])).";".
				trim($adatok[4]).";".
				trim($adatok[3]).";Magyarország;".	
				trim(str_replace(" ", " ", $adatok[6])).";".
				trim($adatok[2]).";\n";*/
				
	$response.= 
				$adatok[0].";".
				trim($adatok[1]).";".
				trim(str_replace("()", "", $adatok[5])).";".
				trim($adatok[4]).";".
				trim($adatok[3]).";".
				$adatok[7].";".	
				trim(str_replace(" ", " ", $adatok[6])).";".
				trim($adatok[2]).";\n";
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

header("Content-disposition: attachment; filename=gls.csv");    

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;

ob_end_flush();

die();

?>