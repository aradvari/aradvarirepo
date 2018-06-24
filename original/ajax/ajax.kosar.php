<?
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i: s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0",false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=UTF-8");

setlocale(LC_ALL,"hu_HU.UTF-8");

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
$user=new user();
$lang=new Lang();

if(count($_SESSION['kosar']) < 1)
 die($lang->ures_a_kosarad);


// table cart  header      desktop/mobile
echo '<table class="table-cart" border=0>';
echo '<tr>';
echo '<th></th>';

if(!$func->isMobile())
	echo '<th style="text-align:left;">'.$lang->Marka_termeknev.'</th>';		//desktop
else
	echo '<th style="text-align:left;">'.$lang->marka.'</th>';					//mobile
	
if(!$func->isMobile())	echo '<th style="text-align:left;">'.$lang->Szin.'</th>';//desktop
	
echo '<th>'.$lang->Meret.'</th>';

if(!$func->isMobile())echo '<th>'.$lang->Egysegar.'</th>';						//desktop

echo '<th>'.$lang->menny.'</th>';

if(!$func->isMobile())	echo '<th>'.$lang->Osszesen.'</th>';					//desktop

echo '<th>'.$lang->Torles.'</th>';
echo '</tr>';

 

// KOSÁR VÉGLEGES ÖSSZESÍTÉSE
 $kosar_db=0;
 $kosar_fizetendo=0;
 if(ISSET($_SESSION['kosar']))
 {

  reset($_SESSION['kosar']);
  $ingyenes_szallitas=false;

  while($reszletek=current($_SESSION['kosar']))
  {

   $termek_adatok=mysql_fetch_array(mysql_query("SELECT
                                                      t.id,
                                                      t.kategoria,
                                                      t.markaid,
                                                      t.termeknev,
                                                      (CASE WHEN t.akcios_kisker_ar<1 THEN t.kisker_ar ELSE t.akcios_kisker_ar END) ar,
                                                      t.klub_ar,
                                                      v.id_vonalkod,
                                                      v.vonalkod,
                                                      v.megnevezes,
                                                      t.szin,
                                                      t.opcio,
                                                      t.cikkszam
                                                      FROM termekek t
                                                      LEFT JOIN markak m ON (m.id = t.markaid)
                                                      LEFT JOIN vonalkodok v ON (v.id_termek = t.id AND v.vonalkod='".$reszletek[8]."')
                                                      WHERE t.id=".(int)$reszletek[0]."
                                                      "));
													  
	
	$directory=$func->getHDir($reszletek[0]);
	
   if($lang->defaultCurrencyId == 0)
   { //MAGYAR
    /*echo '
          <tr>
			<td style="text-align:center;">
			<a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">
			<img src="/'.$directory.'/1_small.jpg" style="padding:1px; border:1px solid #2a87e4; width:50px;height:50px;vertical-align:text-middle;" alt="Coreshop.hu - '.$reszletek[5].'" /></a></td>	
            <td style="border-bottom:1px solid #CCC;text-align:left;">
			<a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[4].'</a> 
            <a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[5].'</a></td>
            <td style="border-bottom:1px solid #CCC;text-align:left;"><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[9].'</a></td>
            <td style="border-bottom:1px solid #CCC;" a_lign="center"><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[1].'</a></td>
            <td style="border-bottom:1px solid #CCC;" a_lign="right">'.number_format($reszletek[3],0,'',' ').' Ft</td>
            <td style="border-bottom:1px solid #CCC;" a_lign="center">'.number_format($reszletek[2],0,'','').' db</td>
            <td style="border-bottom:1px solid #CCC;" a_lign="right">'.number_format($reszletek[2] * $reszletek[3],0,'',' ').' Ft</td>
            <td style="border-bottom:1px solid #CCC;" a_lign="center"><a href="javascript:delItem('.key($_SESSION['kosar']).')"><img src="/images/delete.png" /></a></td>
          </tr>
           ';*/
		   
	echo '<tr>
			<td style="text-align:center;">
			<a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">
			<img src="/'.$directory.'/1_small.jpg" style="padding:1px; border:1px solid #2a87e4; width:50px;height:50px;vertical-align:text-middle;" alt="Coreshop.hu - '.$reszletek[5].'" /></a></td>';
			
    echo '<td style="border-bottom:1px solid #CCC;text-align:left;">
			<a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[4].'</a> 
            <a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[5].'</a></td>';

	// szin
	if(!$func->isMobile()) echo '<td style="border-bottom:1px solid #CCC;text-align:left;"><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[9].'</a></td>';
            
	echo '<td style="border-bottom:1px solid #CCC;"><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'" class="arrow_box">'.$reszletek[1].'</a></td>';
	
    if(!$func->isMobile()) echo '<td style="border-bottom:1px solid #CCC;" a_lign="right">'.number_format($reszletek[3],0,'',' ').' Ft</td>';
	
	echo '<td style="border-bottom:1px solid #CCC;" a_lign="center">'.number_format($reszletek[2],0,'','').' db</td>';
	
    if(!$func->isMobile()) echo '<td style="border-bottom:1px solid #CCC;" a_lign="right">'.number_format($reszletek[2] * $reszletek[3],0,'',' ').' Ft</td>';
	
	echo '<td style="border-bottom:1px solid #CCC;" align="center"><a href="javascript:delItem('.key($_SESSION['kosar']).')"><img src="/images/delete.png" /></a></td>';
	
	echo '</tr>';
   }
   else
   {

    echo '
          <tr>
			<td>
			<a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">
			<img src="/'.$directory.'/1_small.jpg" style="padding:1px; border:1px solid #2a87e4; width:50px;height:50px;vertical-align:text-middle;" alt="Coreshop.hu - '.$reszletek[5].'" /></a></td>
            <td style="border-bottom:1px solid #CCC;text-align:left;""><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[4].'</a> 
            <a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[5].'</a></td>
            <td style="border-bottom:1px solid #CCC;"><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[9].'</a></td>
            <td style="border-bottom:1px solid #CCC;" align="center"><a href="/'.$lang->defaultLangStr.'/'.$lang->_termek.'/'.$func->convertString($reszletek[5]).'/'.$reszletek[0].'">'.$reszletek[1].'</a></td>
            <td style="border-bottom:1px solid #CCC;" align="right">€ '.$func->toEUR($reszletek[3]).'</td>
            <td style="border-bottom:1px solid #CCC;" align="center">'.number_format($reszletek[2],0,'',' ').'</td>
            <td style="border-bottom:1px solid #CCC;" align="right">€ '.$func->toEUR($reszletek[2] * $reszletek[3]).'</td>
            <td style="border-bottom:1px solid #CCC;" align="center"><a href="javascript:delItem('.key($_SESSION['kosar']).')"><img src="/images/delete.png" /></a></td>
          </tr>
           ';
   }

   $kosar_db=$kosar_db + $reszletek[2];

   $kosar_fizetendo=$kosar_fizetendo + ( $reszletek[3] * $reszletek[2] );

   next($_SESSION['kosar']);
  }
 }

//Ajándékkártya kalkuláció, hogy minuszba ne mehessen a megrendelés
 if(($kosar_fizetendo + $szallitasi_dij) >= (int)$_POST['kedvezmeny'])
 {

  $kedvezmeny=(int)$_POST['kedvezmeny'];
 }
 else
 {

  $kedvezmeny=$kosar_fizetendo + $szallitasi_dij;
 }


// INGYENES SZALLITAS MAGYARORSZÁGRA
 if($func->getMainParam("ingyenes_szallitas") > 0 && !$user->isForeign())
 {
  if($kosar_fizetendo - $kedvezmeny > $func->getMainParam("ingyenes_szallitas"))
   $ingyenes_szallitas=true;

// INGYENES SZALLITAS KÜLFÖLDRE
 }elseif($func->getMainParam("ingyenes_szallitas_kulfold") > 0 && $user->isForeign())
 {
  if($func->toEUR($kosar_fizetendo,true) > $func->getMainParam("ingyenes_szallitas_kulfold"))
   $ingyenes_szallitas=true;
 }

//KLUB ESETÉN NINCS SZÁLLÍTÁSI KÖLTSÉGE
 if($user->isClubUser() || $_POST["szallitasi_mod"] == 2)
  $ingyenes_szallitas=true;

 if(!$user->isForeign())
 { //MAGYAR
  $szallitasi_dij=$ingyenes_szallitas ? 0 : (int)$func->getMainParam("szallitasi_dij");
 }
 else
 {
  $szallitasi_dij=$ingyenes_szallitas ? 0 : $func->toHUF((int)$func->getMainParam("szallitasi_dij_kulfold"),false);
 }
 ?>

 <tr><td colspan=8>&nbsp;</td></tr>

 <?
 
 if(!$func->isMobile())	{
	$colspan1='colspan=5';
	$colspan2='colspan=8';
 }
 else	{
	$colspan1='colspan=3';
	$colspan2='colspan=6';
 }
 
 if($lang->defaultCurrencyId == 0)
 { // hu
  ?>
  <tr><td <?=$colspan1?> style="text-align:right;"><?=$lang->Osszesen ?>:</td>  <td style="text-align:right;" colspan=2><?=number_format($kosar_fizetendo,0,'',' ') ?> Ft</td>
  </tr>

  <tr><td <?=$colspan2?> style="border-bottom:1px solid #CCC;"></td></tr>
  <?
 }
 else	// en
 {
  ?>
  <tr><td <?=$colspan1?> style="text-align:right;"><?=$lang->Osszesen ?>:</td>  <td style="text-align:right;" colspan=2>€ <?=$func->toEUR($kosar_fizetendo) ?></td>
  </tr>

  <tr><td <?=$colspan2?> style="border-bottom:1px solid #CCC;"></td></tr>
 <?
}
?>


<?
if((int)$_POST['kedvezmeny'] > 0)
{

 if($lang->defaultCurrencyId == 0)
 { //MAGYAR
  ?>
   <tr><td <?=$colspan1?> style="text-align:right;" style="color:#ccff99;"><?=$lang->Ajandekkartya_egyenlege ?>:</td>   <td style="text-align:right;" colspan=2 style="color:#ccff99;"><?=number_format((int)$_POST['kedvezmeny'],0,'',' ') ?> Ft</td></tr>

   <tr><td <?=$colspan1?> style="text-align:right;" style="color:#ccff99;"><?=$lang->Ajandekkartyarol_felhasznalot_osszeg ?>:</td>   <td style="text-align:right;" colspan=2 style="color:#ccff99;">- <?=number_format($kedvezmeny,0,'',' ') ?> Ft</td></tr>

   <tr><td <?=$colspan1?> style="text-align:right;" style="color:#ccff99;"><?=$lang->Ajandekkartya_aktualis_egyenlege ?>:</td>   <td style="text-align:right;" colspan=2 style="color:#ccff99;"><?=number_format((int)$_POST['kedvezmeny'] - $kedvezmeny,0,'',' ') ?> Ft</td></tr>

   <tr><td <?=$colspan2?> style="border-top:1px solid #CCC;"></td></tr>

   <?
  }
  else
  {
   ?>
   <tr><td <?=$colspan1?> style="text-align:right;color:#ccff99;"><?=$lang->Ajandekkartya_egyenlege ?>:</td>   <td style="text-align:right;color:#ccff99;" colspan=2><?=$func->toEUR((int)$_POST['kedvezmeny']) ?> €</td></tr>

   <tr><td <?=$colspan1?> style="text-align:right;"><span class="alert"><?=$lang->Ajandekkartyarol_felhasznalot_osszeg ?>:</span></td>   <td style="text-align:right;" colspan=2><span class="alert">- <?=$func->toEUR($kedvezmeny) ?> €</span></td></tr>

   <tr><td <?=$colspan1?> style="text-align:right;"><span class="alert"><?=$lang->Ajandekkartya_aktualis_egyenlege ?>:</span></td>   <td style="text-align:right;" colspan=2><span class="alert"><?=$func->toEUR((int)$_POST['kedvezmeny'] - $kedvezmeny) ?> €</span></td></tr>

   <tr><td <?=$colspan2?> style="border-top:1px solid #CCC;"></td></tr>
  <?
 }
}


if($lang->defaultCurrencyId == 0)
{ // hu
 ?>
  <tr><td <?=$colspan1?> style="text-align:right;">+ <?=$lang->Szallitasi_dij ?>:</td>   <td style="text-align:right;" colspan=2><?=number_format($szallitasi_dij,0,'',' ') ?> Ft</td></tr>

  <tr><td <?=$colspan2?> style="border-top:1px solid #CCC;"></td></tr>

  <tr><td <?=$colspan1?> style="text-align:right;color:#999;"><?=$lang->Ebbol_AFA ?>:</td>   <td style="text-align:right;" colspan=2 style="color:#999;"><?=number_format($func->getAFAFromBrutto($kosar_fizetendo + $szallitasi_dij - $kedvezmeny),0,'',' ') ?> Ft</td></tr>

  <tr><td <?=$colspan2?> style="border-bottom:1px solid #2a87e4;"></td></tr>


  <tr><td <?=$colspan1?> style="text-align:right;"><font size=4><?=$lang->Osszesen_fizetendo ?>:</font></td>  <td style="text-align:right;" colspan=2><font size=4><?=number_format($kosar_fizetendo + $szallitasi_dij - $kedvezmeny,0,'',' ') ?> Ft</font></td></tr>

  <tr><td <?=$colspan2?>>&nbsp;</td></tr>

 <?
}
else	//en
{
 ?>
  <tr><td colspan=5 style="text-align:right;">+ <?=$lang->Szallitasi_dij ?>:</td>   <td style="text-align:right;"><span class="alert">€ <?=$func->toEUR($szallitasi_dij) ?></span></td><td>&nbsp;</td></tr>

  <tr><td colspan=8 style="border-top:1px solid #CCC;"></td></tr>

  <tr><td colspan=5 style="text-align:right;" style="color:#444;"><?=$lang->Ebbol_AFA ?>:</td>   <td style="text-align:right;"><span class="alert" style="color:#444;">€ <?=$func->toEUR($func->getAFAFromBrutto($kosar_fizetendo + $szallitasi_dij - $kedvezmeny)) ?></span></td><td>&nbsp;</td></tr>

  <tr><td colspan=8 style="border-bottom:1px solid #2a87e4;"></td></tr>

  <tr><td colspan=5 style="text-align:right;"><font size=4><?=$lang->Osszesen_fizetendo ?>:</font></td>  <td style="text-align:right;"><font size=4>€ <?=$func->toEUR($kosar_fizetendo + $szallitasi_dij - $kedvezmeny) ?></font></td><td>&nbsp;</td></tr>

  <tr><td colspan=8>&nbsp;</td></tr>
  
  

 <?
}



if($user->isLogged())
{
 ?>

  <tr><td colspan=8 align="center">
  <input value="<?=$lang->Megrendeles_elkuldese ?>" class="arrow_box" style="width:100%;font-weight:bold;padding:20px;font-size:18px;" onclick="document.megrForm.submit()" type="button">
  </td></tr>
  
  
  <tr><td colspan=8 align="" class="login_once"><br /><label><input type="checkbox" name="aszf" checked > Megrendelésemmel elolvastam és elfogadtam az <a href="/hu/altalanos_szerzodesi_feltetelek" target="_blank">Általános szerződési feltételeket</a> ( &dArr; Az ÁSZF letölthető <a href="/coreshop_aszf.pdf" target="_blank">ITT</a> pdf formátumban ).</label></td></tr>

 <?
}
?>

</table>
