<?
//error_reporting(E_ALL);

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
require_once ("../classes/tranzakcio.class.php");
require_once ('../cib/cib.class.php');
require_once ("../classes/error.class.php");
require_once ("../classes/user.class.php");

$db = new connect_db();
$func = new functions();
$error = new error();
$user = new user();
$trans = new tranzakcio();
$cib = new cibClass();

$cib->csh_file="../../cib.security/cib/CSH.des";

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("database connect error: ".$db->error);
if (!$db->select_db(DB_DB)) die("database select error: ".$db->error);

$sql = "
SELECT bt.* 
FROM bank_tranzakciok bt
WHERE 
  bt.lezarva IS NULL AND 
  DATE_ADD(bt.datum, INTERVAL 15 MINUTE) < NOW() 
";

$query = mysql_query($sql);

while ($adatok = mysql_fetch_assoc($query)){
    
    $cib->msg32($adatok["trid"], $adatok['amo']); //Lezárás
    
    $response = $cib->msg33($adatok["trid"], $adatok['amo']);

    $trans->cronCloseTrans($adatok['id_felhasznalo'], $response["TRID"], $response["RC"], iconv("ISO-8859-2", "UTF-8", $response["RT"]), "../classes/phpmailer/class.phpmailer.php");
    
    echo "<pre>";
    print_r($adatok);
    print_r($response);
    echo "</pre><hr>";
    
}

/*$f = fopen("run.txt", "a");
fwrite($f, date("Y-m-d G:i:s\n"));
fclose($f);*/

?>