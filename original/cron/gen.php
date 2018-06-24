<?
require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
require_once ("../classes/phpmailer/class.phpmailer.php");

$db = new connect_db();
$mail = new PHPMailer();
$func = new functions();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$sql = "SELECT * FROM felhasznalok WHERE (aktivacios_kod IS NULL OR aktivacios_kod='') AND torolve IS NULL";
$query = mysql_query($sql);

while ($adatok = mysql_fetch_assoc($query)){

    $hash = date("i").mt_rand(10,99).str_pad($adatok['id'], 4, "0", STR_PAD_LEFT).date("s");
    
    $sql = "INSERT INTO giftcard 
            (azonosito_kod, trid, osszeg, min_vasarlas_osszeg, ervenyes_tol, ervenyes_ig, felado_nev, felado_email, cimzett_nev, cimzett_email, id_kuldo, fizetve)
            VALUES ('".$hash."', '".$hash."', 2000, 5000, NOW(), '2010-12-31 23:59:59', 'coreshop', 'info@coreshop.hu', '".$adatok['vezeteknev']." ".$adatok['keresztnev']."', '".$adatok['email']."', 0, NOW())
            ";
            
    if (!mysql_query($sql)) echo mysql_error()."<br>";
    
}

?>