<?
// user check
//if ($page == "adataim" && !$user->isLogged())
	//Header("Location: /" . $lang->defaultLangStr . "/" . $lang->_regisztracio);
	
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>


<div style="float:left; width:20%; border-right:1px solid #444; margin-top:4%;">
<p style="padding:10px 10px 0 10px; margin:0; color:#78CDD1">BEJELENTKEZVE</p>
<p style="border-bottom:10px solid #444; padding:10px; margin-bottom:10px; ">
	<?
	echo $_POST['vezeteknev'].' '.$_POST['keresztnev'];
	if(!empty($_POST['cegnev']))
		echo ' ( '.$_POST['cegnev'].' )';
	?>
</p>

<a href="?mod=" style="display:block; margin-bottom:10px; padding:10px; background-color:;" />SZEMÉLYES ADATOK</a>

<a href="?mod=" style="display:block; margin-bottom:10px; padding:10px; background-color:;" />SZÁLLÍTÁSI ADATOK</a>

<a href="?mod=rendelesek" style="display:block; margin-bottom:10px; padding:10px; background-color:;" />RENDELÉSEK</a>

<a href="?mod=" style="display:block; margin-bottom:10px; padding:10px; background-color:;" />KIJELENTKEZÉS</a>


</div>


<?
if(isset($_GET['mod']))	{
	if($_GET['mod']=='rendelesek') include 'inc/felhasznalo.rendelesek.inc.php';
}

?>


<? //// ADATSZERKESZTES //////////////////////////////////////////// ?>

<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/ajax.2015.js" type="text/javascript"></script>
<script src="/js/passwordmeter.js" type="text/javascript"></script>

<!-- <div class="content-right-headline"><?=$lang->Regisztracios_adatok_modositasa?></div> -->

<form action="" method="POST" autocomplete="off">

<div class="textbox" style="width:30%;">
	<div class="login_once">

	<p>Név</p>
	<input type="text" name="vezeteknev" placeholder="Vezetéknév"  value="<?=$_POST['vezeteknev']?>" maxlength="50" style="width:50%;">
	<input type="text" name="keresztnev" placeholder="Keresztnév" value="<?=$_POST['keresztnev']?>" maxlength="50" style="float:right;width:48%;">
	<br />
	<br />
	<input type="text" name="cegnev" placeholder="Cégnév (<?=$lang->nem_kotelezo?>)" value="<?=$_POST['cegnev']?>" maxlength="200">
	<br />
	<br />
	<p><?=$lang->Szallitasi_cim?></p>
    <?
	echo $func->createSelectBox("SELECT id_orszag, nyelvi_kulcs FROM orszag ORDER BY id_orszag", $_POST['orszag'], "name=\"orszag\" id=\"orszag\" onchange=\"changeOrszag(this.options[this.selectedIndex].value)\"");
	?>
	
	<input type="text" name="iranyitoszam" id="iranyitoszam" 
	onChange="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv'); document.getElementById('utca_kozterulet').focus();" 
	onKeyup="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv');" 
	onKeydown="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv');" 
	placeholder="<?=$lang->Iranyitoszam?>" 
	value="<?=$_POST['iranyitoszam']?>"
	maxlength="4" style="width:30%; margin-right:1%;" />
	<?
	// megye select nem lathato
	echo $func->createSelectBox("SELECT * FROM megyek ORDER BY megye_nev",$_POST['megye'], "name=\"megye\" id=\"megye\"  
	onchange=\"divHelysegek('helysegekdiv', this.options[this.selectedIndex].value, 'varos')\" style=\"width:68%; float:right; margin-right:0; \" ", "Válassz megyét");
	?>
	<div id="helysegekdiv"></div>
	
	<br />
	<br />
	
	<input type="text" id="utcanev" name="utcanev" placeholder="utcanév" value="<?=$_POST['utcanev'] ?>" maxlength="100" style="width:60%;">
	<?
	echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes",$_POST['kozterulet'],"name=\"kozterulet\" style=\" width:30%; \" ");
	?>
	<input type="text" id="hazszam" name="hazszam" placeholder="házszám" value="<?=$_POST['hazszam'] ?>" maxlength="10" size="5" style="width:60%;">
	

	</div>
</div>


<div class="textbox" style="width:30%;">
	<div class="login_once">
	<p>Elérhetőség</p>
	
	<!-- <input type="text" name="email" placeholder="E-mail cím" value="<?=$_POST['email'];?>"> -->
	A regisztrációnál megadott "<b><?=$_POST['email'];?></b>" e-mail címedet az Adminisztrátor módosíthatja.
	<br /><a href="mailto:info@coreshop.hu?subject=Regisztrációs e-mail cím módosítás">Módosítási levél küldése az adminisztrátornak</a>.</font>
	
	<br />
	<br />

	<?=$lang->Telefonszam?> 1
	<br />
	<input type="text" name="telefonszam1_0" id="telefonszam1_0" value="<?=$_POST['telefonszam1_0']?>" size="3" maxlength="4" style="width:20%;" />
	<input type="text" name="telefonszam1_1" id="telefonszam1_1" value="<?=$_POST['telefonszam1_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==2) $('telefonszam1_2').focus()" style="width:20%;">
	<input type="text" name="telefonszam1_2" id="telefonszam1_2" value="<?=$_POST['telefonszam1_2']?>" maxlength="7" style="float:right; width:58%;">

	<br />

	<?=$lang->Telefonszam?> 2 (<?=$lang->nem_kotelezo?>)
	<br />
	<input type="text" name="telefonszam2_0" id="telefonszam2_0" value="<?=$_POST['telefonszam2_0']?>" size="3" maxlength="4" style="width:20%;" />
	<input type="text" name="telefonszam2_1" id="telefonszam2_1" value="<?=$_POST['telefonszam2_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==2) $('telefonszam2_2').focus()" style="width:20%;">
	<input type="text" name="telefonszam2_2" id="telefonszam2_2" value="<?=$_POST['telefonszam2_2']?>" maxlength="7" style="float:right; width:58%;">

	<br />
	<br />
	
	<p><span id="erosseg"></span> <?=$lang->Jelszo?></p>
	<input type="password" name="jelszo" onkeyup="$('erosseg').innerHTML='&nbsp;' + testPassword(this.value)">
	<br />
	<?=$lang->jelszo_ismetlese?>
	<input type="password" name="jelszo2">
  
	<br />
	<br />
	
	<input type="submit" name="modositas" value="Mentés" class="arrow_box">
	</div>
</div>

</form>


<script>
    divHelysegek('helysegekdiv', '<?=$_POST['megye']?>', 'varos', '<?=$_POST['varos']?>');

    function changeOrszag(id){
        
        if (id==1){ // MAGYARORSZÁG
         
            jQuery('.hun').show();
            jQuery('.eng').hide();
            jQuery('.hun input').attr("disabled", "");
            jQuery('.eng input').attr("disabled", "disabled");
            jQuery('.phone_code').val("+36");
            
        }else{ // KÜLFÖLD 
        
            jQuery('.hun').hide();
            jQuery('.eng').show();
            jQuery('.hun input').attr("disabled", "disabled");
            jQuery('.eng input').attr("disabled", "");
            jQuery('.phone_code').val("+");
        
        }

    }
    changeOrszag('<?=$_POST['orszag']?>');
</script>

<? //// ADATSZERK. VEGE //////////////////////////////////////////// ?>