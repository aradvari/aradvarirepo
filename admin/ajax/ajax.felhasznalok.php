<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=ISO-8859-2");

require_once ("../config/config.php");
require_once ("../classes/connect.class.php");
require_once ("../classes/functions.class.php");

$db = new connect_db();

if (!$db->connect(DB_HOST, DB_USER, DB_PW)) die("adatbázis kapcsolódási hiba: ".$db->error);

if (!$db->select_db(DB_DB)) die("adatbázis választási hiba: ".$db->error);

$func = new functions();

// /web/tmp -> session fileok

function unserializesession($data) {
    $vars=preg_split('/([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff^|]*)\|/',
              $data,-1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    for($i=0; $vars[$i]; $i++) $result[$vars[$i++]]=unserialize($vars[$i]);
    return $result;
}

function put($str){

    echo iconv("UTF-8", "ISO-8859-2", $str);

}

$sql = "SELECT session_id FROM felhasznalok WHERE session_id IS NOT NULL";
$query = mysql_query($sql);

while ($s = mysql_fetch_assoc($query)){


    $filename='sess_'.$s['session_id'];

    $f = fopen("/web/tmp/$filename", "r");

    $ft = filectime("/web/tmp/$filename");
    
    $session = fread($f, filesize("/web/tmp/$filename"));

    //echo strtotime("-3 MINUTE")." < ".date("Y-m-d H:i:s", $ft);

    $adatok = unserializesession($session);

    fclose($f);
    
    if ($adatok['felhasznalo']!=false && (strtotime("-10 MINUTE")<$ft)){

    // KIIRATÁS

    put ('<table cellpadding="5">
              <tr>
                <td class="darkCell" width="200">Nev:</td>
                <td class="lightCell" width="400">'.$adatok['felhasznalo']['vezeteknev']." ".$adatok['felhasznalo']['keresztnev'].' '.$adatok['felhasznalo']['cegnev'].'</td>
              </tr>
              <tr>  
                <td class="darkCell">Belepett / oldalt frissitett:</td>
                <td class="lightCell">'.$adatok['felhasznalo']['utolso_belepes'].' | '.date("Y-m-d H:i:s", $ft).'</td>
              </tr>
              <tr>  
                <td class="darkCell">URL:</td>
                <td class="lightCell"><a href="http://www.coreshop.hu/'.$adatok['url'].'" target="_blank">'.($adatok['url']==''?'/':$adatok['url']).'</a></td>
              </tr>
          </table>');


    // KOSÁR VÉGLEGES ÖSSZESÍTÉSE
    $kosar_db=0;
    $kosar_fizetendo=0;
    if (ISSET($adatok['kosar'])){
    if (count($adatok['kosar'])>0) {
        
    ?>

    <table cellpadding="5">

    <tr class="darkCell">
    <td width="60">Márka</td>
    <td width="150">Terméknév</td>
    <td width="100">Szín</td>
    <td width="60">Méret</td>
    <td width="50">Egységár</td>
    <td width="50">Mennyiség</td>
    <td width="50" align="center">Összesen</td>
    </tr>

    <?
        
      
      while($reszletek=current($adatok['kosar'])){
      
          put ('
              <tr class="lightCell">
                <td><a target="_blank" href="http://www.coreshop.hu/termek/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'"><span class="alert">'.$reszletek[4].'</span></a></td>
                <td><a target="_blank" href="http://www.coreshop.hu/termek/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'"><span class="alert">'.$reszletek[5].'</span></a></td>
                <td><a target="_blank" href="http://www.coreshop.hu/termek/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'"><span class="alert">'.$reszletek[9].'</span></a></td>
                <td><a target="_blank" href="http://www.coreshop.hu/termek/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'"><span class="alert">'.$reszletek[1].'</span></a></td>
                <td align="right"><span class="alert">'.number_format($reszletek[3], 0, '', ' ').'</span></td>
                <td align="right"><span class="alert">'.number_format($reszletek[2], 0, '', ' ').'</span></td>
                <td align="right"><span class="alert">'.number_format($reszletek[2] * $reszletek[3], 0, '', ' ').'</span></td>
              </tr>
               ');
          
          $kosar_db = $kosar_db + $reszletek[2];
          
          $kosar_fizetendo = $kosar_fizetendo + ( $reszletek[3] * $reszletek[2] );
          
          next ($adatok['kosar']);
          
      }

    }

    if ($kosar_db>0){
    ?>

      <tr class="darkCell"><td colspan="6" align="right">Összesen:</td>  <td align="right"><span class="alert"><?=number_format($kosar_fizetendo, 0, '', ' ')?></span></td></tr>
      <tr class="darkCell"><td colspan="6" align="right">Szállítási díj:</td>   <td align="right"><span class="alert"><?=number_format($func->getMainParam("szallitasi_dij"), 0, '', ' ')?></span></td></tr>
      <tr class="darkCell"><td colspan="6" align="right">Összesen fizetendõ:</td>  <td align="right"><span class="alert"><?=number_format($kosar_fizetendo + $func->getMainParam("szallitasi_dij"), 0, '', ' ')?></span></td></tr>
      
    </table>
    
<?
	}
            }
        }
        
        if ($adatok['felhasznalo']!=false && (strtotime("-10 MINUTE")<$ft)) echo '<hr>';

    }
?>