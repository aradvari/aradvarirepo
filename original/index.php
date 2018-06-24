<?
session_start();

ini_set("display_errors", 0);
error_reporting(E_ALL & ~E_NOTICE);

setlocale(LC_ALL, "hu_HU.UTF-8");

header("X-UA-Compatible: IE=8");
header('Content-type: text/html; charset=UTF-8');

require_once ("config/config.php");
require_once ("classes/Lang.class.php");
require_once ("classes/connect.class.php");
require_once ("classes/functions.class.php");
require_once ("classes/error.class.php");
require_once ("classes/panelmenu.class.php");
require_once ("classes/main.class.php");
require_once ("classes/user.class.php");

$lang = new Lang();

$error = new error();
$func = new functions();
$db = new connect_db();

if (!$db->connect(DB_HOST, DB_USER, DB_PW))
    die("adatbázis kapcsolódási hiba: " . $db->error);

if (!$db->select_db(DB_DB))
    die("adatbázis hiba: " . $db->error);

$main = new main();
$error = new error();
$menu = new panelMenu();
$func = new functions();
$user = new user();

/**
 * @desc KERESOBARAT URL KEZELES
 * @desc AZ ELSO ERTEK MINDIG AZ ALAP, A TOVABBI ERTEKEK SORRENDBE A GET VALTOZO NEVE, ERTEKE
 */
$_SESSION['url'] = $_GET['query'];
$url = $_GET['query'];
$exp = explode("/", $url);
$page = $exp[1];
$_SESSION['page'] = $page;     // page

//if($page==='termekek')
$_SESSION['kategoria'] = $exp[3];   // kategoria
	
$_SESSION['marka'] = $exp[5];    // marka

if($page==='termek')
	$_SESSION['termek_id'] = $exp[3];	// termek ID


// ha a HU kieg hianyzik az URL-bol 
if (($_SESSION["langId"] === 0) && (sizeof($exp) > 0)) {
	
    /*$find = strpos($_GET['query'], 'hu');

    if ($find===FALSE) {
		header("Location: /hu/" . $_GET['query']);
    }*/

    /////// hibas url pl: http://coreshop.hu/hu/0/termek/bridge/4248 /////

    $find2 = strpos($_GET['query'], 'hu/0', '/');

    if ($find2 === 0) {
        $csere = str_replace("hu/0", "hu", $_GET['query']);		
        header("Location: /" . $csere);
    }
}
	

	
for ($go = 2; $go < count($exp); $go++) {

    $_GET[$exp[$go]] = $exp[++$go];
}

if (strstr($page, $lang->_termekek)) {

    if (!empty($exp[3]))
        $_GET['kategoria'] = (int) $exp[3];
    if (!empty($exp[5]))
        $_GET['marka'] = (int) $exp[5];

    $exp2 = explode("_", $page);
    $_GET['opcio'] = $exp2[1];
    $_SESSION['opcio'] = $exp2[1];
    $page = 'termekek';
}

if ($page == $lang->_termek) {

    if (!empty($exp[3]))
        $_GET['id_termek'] = (int) $exp[3];
    $_GET['kep'] = $exp[4];
    $page = "termek";
}

if ($page == $lang->_adataim)
    $page = "adataim";
if ($page == $lang->_megrendeles)
    $page = "megrendeles";
if ($page == $lang->_regisztracio)
    $page = "regisztracio";
if ($page == $lang->_tranzakcio)
    $page = "tranzakcio";
if ($page == $lang->_elfelejtett_jelszo)
    $page = "elfelejtett_jelszo";
if ($page == $lang->_aktivalas)
    $page = "_aktivalas";


if ($page == 'hirlevel') {
    $_GET['ev'] = $exp[2];
    $_GET['szam'] = $exp[3];
}



/**
 * @desc URL kezelés vége
 */
if (is_file("classes/$page.class.php")) {

    require_once ("classes/$page.class.php");
    $$page = new $page;
}


ob_start();
require_once("template.php");
ob_end_flush();
?>