<!-- div login -->
<div class="login_once">

<p><?=$lang->Megrendeleshez_jelentkezz_be_oldalunkra ?></p>

<form action="" method="POST" style="padding:0; margin:0;">

<input type="text" name="login_email" id="login_email" placeholder="<?=$lang->Email_cim ?>" style="margin-bottom:10px;" />

<input type="password" placeholder="<?=$lang->Jelszo ?>" name="login_password" id="login_password" style="margin-bottom:10px;" />

<input type="submit" value="<?=$lang->Bejelentkezes ?>" class="arrow_box" style="margin-bottom:10px;" />

<?
/* mobilnál nem jelenik meg pár kieg link */
if( !$func->isMobile() )	{
?>
	
	<br />
	<br />
	
	<label><input type="checkbox" name="aszf" checked > Elfogadom az <a href="/hu/altalanos-szerzodesi-feltetelek" target="_blank">Általános szerződési feltételeket</a> (<a href="/coreshop_aszf.pdf" target="_blank">&dArr; PDF</a>)</label>
	
	<br />
	<br />
	<label><input type="checkbox" name="rememberLogin" style="vertical-align:middle;" /> <?=$lang->maradjak_bejelentkezve ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
	<a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_elfelejtett_jelszo ?>"><?=$lang->Elfelejtetted_jelszavad ?></a>
	
	<br />
	<br />
	
	<?=$lang->Nincs_meg_felhasznaloi_azonositod ?>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_regisztracio ?>"><?=$lang->Regisztralj_most_a_coreshop_hu_ra ?></a>
<? 
} 
else
	{
	echo '<a href="/'.$lang->defaultLangStr.'/'.$lang->_regisztracio.'"><'.$lang->Regisztralj_most_a_coreshop_hu_ra.'></a>';
	}
?>

</form>


<? if(!$func->isMobile())	{
	echo '<img src="/images/cxs-logo.png" style="width:40%; margin:100px 0 20px 0; opacity:0.8; padding:0 30%;" />';
	echo '<img src="/images/gls-small.png" style="margin:0 10px 0px 0;" />Kiszállítás: <font style="color:#2a87e4;">'.$func->dateToHU($func->GLSDeliveryDate('HU')).'</font> / 8:00 - 16:00 óra között.';
}
?>

</div>
<!-- endof div login -->