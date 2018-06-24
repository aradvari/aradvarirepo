<?
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i: s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0",false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=UTF-8");

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");
require_once ("../classes/user.class.php");
require_once ("../classes/Lang.class.php");

$db=new connect_db();

if(!$db->connect(DB_HOST,DB_USER,DB_PW))
 die("adatbázis kapcsolódási hiba: ".$db->error);

if(!$db->select_db(DB_DB))
 die("adatbázis választási hiba: ".$db->error);

$func=new functions();
$lang=new Lang();

/*if( (trim($_POST['code']) == "xmas") && (date('Y-m-d')<'2014-01-01') )
{

 $kosar_fizetendo=0;
 if(ISSET($_SESSION['kosar']))
 {

  reset($_SESSION['kosar']);

  while($reszletek=current($_SESSION['kosar']))
  {
   $kosar_fizetendo=$kosar_fizetendo + ( $reszletek[3] * $reszletek[2] );
   next($_SESSION['kosar']);
  }
 }

 if($kosar_fizetendo > 10000 && $kosar_fizetendo <= 15000)
  $osszeg=2000;
 elseif($kosar_fizetendo > 15000 && $kosar_fizetendo <= 25000)
  $osszeg=3000;
 elseif($kosar_fizetendo > 25000)
  $osszeg=5000;
 else
 {
  $osszeg_tol=2000;
  $osszeg_ig=5000;
 }
}*/

if ( (trim(strtolower($_POST['code'])) == "xmas") && (date('Y-m-d')>='2017-12-12') && (date('Y-m-d')<='2017-12-17') )
	//if (trim($_POST['code']) == "app")
	{
		if(ISSET($_SESSION['kosar']))
		{
		reset($_SESSION['kosar']);

		while($reszletek=current($_SESSION['kosar']))
			{		
			/* // Vans 20%
			if (($reszletek[4]==='Vans') && ($reszletek[7]!="AKCIOS")) 
				$osszeg=round(($osszeg + (($reszletek[3] * $reszletek[2]) * 0.2)), -1); // 20%-os akcio vans termekre */
			
			if ($reszletek[7]!="AKCIOS")	// akcios termeket nem akcioz tovabb	
				$osszeg=round(($osszeg + (($reszletek[3] * $reszletek[2]) * 0.2)), -1); // 20%-os akcio
				
			
			//$osszeg= $osszeg + (($reszletek[3] * $reszletek[2]) * 0.2);

			next($_SESSION['kosar']);
			}
		}
	}
else
{
 $sql="SELECT osszeg FROM giftcard WHERE azonosito_kod='".trim($_POST['code'])."' AND ervenyes_tol<=NOW() AND ervenyes_ig>NOW() AND fizetve IS NOT NULL AND felhasznalva IS NULL";
 $osszeg=@mysql_result(@mysql_query($sql),0);
}



if(ISSET($_POST['egyenleg']))
{

 $_SESSION['giftcard_egyenleg']=$osszeg;
 echo 'A kártyához tartozó egyenleg: (Ft)###<img src="/classes/captcha/get.php" />';
}
elseif(isset($_POST['code']) && $_POST['code'] != "")
{

 if((int)$osszeg_tol > 0 && (int)$osszeg_ig > 0)
 {
  echo '<span class="alert_green">'.$lang->kedvezmeny_osszeg.': még 0 Ft</span>###0';
 }
 else
 {
  if((int)$osszeg > 1)
  {
	//echo '<span class="alert_green">'.$lang->kedvezmeny_osszeg.': '.number_format($osszeg,0,'',' ').' Ft</span>###'.(int)$osszeg;
	echo $lang->kedvezmeny_osszeg.': '.number_format($osszeg,0,'',' ').' Ft ###'.(int)$osszeg;
  }
  else
  {
   //echo '<span class="alert_red">'.$lang->ervenytelen_kod.'</span>###'.(int)$osszeg;
  // echo '<span class="alert_red">'.$lang->ervenytelen_kod.'</span>';
  echo $lang->ervenytelen_kod;
  }
 }
}
?>