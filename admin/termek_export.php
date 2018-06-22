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

$afa = 27;

require ("classes/functions.class.php");
$func = new functions();
$query = "
				SELECT 
				t.id,
				t.cikkszam,			

				CONCAT(m.markanev,' - ', t.termeknev,' - ', t.szin, ' - ', if(v.megnevezes is not null, v.megnevezes,'')) `fullnev`,
				v.vonalkod,
				/*t.kisker_ar*/
				(CASE WHEN t.akcios_kisker_ar<1 THEN t.kisker_ar ELSE t.akcios_kisker_ar END) ar

				FROM termekek t
				LEFT JOIN markak m ON (m.id = t.markaid)
				LEFT JOIN vonalkodok v ON (t.id = v.id_termek)
				WHERE t.torolve IS NULL	
				/*AND v.keszlet_1>0*/
			";

//from ID
if (!empty($_GET['from_id']))	$query.= " AND t.id >= ".$_GET['from_id'];

//to ID
if (!empty($_GET['to_id']))	$query.= " AND t.id <= ".$_GET['to_id'];
			
$query_data = mysql_query($query);

//header
$response= "ID;PRODUCTTYPE;SZJ;NAME;TAX;QU;LISTPRICE;LASTINITIALCOST;ARTICLENR;PRODUCTIONNR;BARCODE;DISCOUNT;QUANTITY;WSQUANTITY;MINIMUMSTOCK;NOTE;DESCRIPTION;ISACTIVE;MODEL;WEIGHT;CATEGORY;";
$response.="\n";

//	25869;2;Teszt termék2;25;db;8992;0;cikk-2;;5990000000024;0;0;0;0;;;1;;0;

while ($adatok = mysql_fetch_row($query_data)){
	
	$response.= ";1;CS".$adatok[0].";".$adatok[2].";".$afa.";db;".str_replace('.', ',', ($adatok[4]/1.27)).";0;".$adatok[1].";;".$adatok[3].";0;0;0;0;;;1;;0;\n";
    
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

header("Content-disposition: attachment; filename=coreshop_cikktorzs_".$_GET['from_id']."_".$_GET['to_id']."_".date('Ymd').".csv");

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;

ob_end_flush();

die();

?>