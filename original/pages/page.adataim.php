<?
// user check
//if ($page == "adataim" && !$user->isLogged())
	//Header("Location: /" . $lang->defaultLangStr . "/" . $lang->_regisztracio);
?>

<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/ajax.2015.js" type="text/javascript"></script>
<script src="/js/passwordmeter.js" type="text/javascript"></script>

<div class="content-right-headline"><?=$lang->Regisztracios_adatok_modositasa?></div>

<form action="" method="POST" autocomplete="off">

<div class="textbox">
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
	
	<input type="text" id="utcanev" name="utcanev" placeholder="utcanév" value="<?=$_POST['utcanev'] ?>" maxlength="100" style="width:44%;">
	<?
	echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes",$_POST['kozterulet'],"name=\"kozterulet\" style=\" width:28%; \" ");
	?>
	<input type="text" id="hazszam" name="hazszam" placeholder="házszám" value="<?=$_POST['hazszam'] ?>" maxlength="10" size="5" style="width:26%;">
	

	</div>
</div>


<div class="textbox">
	<div class="login_once">
	<p>Elérhetőség</p>
	
	<!-- <input type="text" name="email" placeholder="E-mail cím" value="<?=$_POST['email'];?>"> -->
	<?=$_POST['email'];?> <font style="color:#2a87e4;">(adminisztrátor módosíthatja)</font>
	
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





<? /*
<div class="right-container">

<div class="content-right-headline"><?=$lang->Regisztracios_adatok_modositasa?></div>

<center>

<form action="" method="POST" autocomplete="off">

<table class="table-reg">

<tr>
	<th colspan=2><?=$lang->Szemelyes_adatok?>:
	</th>
</tr>

<tr>
  <td align="right" width="35%"><?=$lang->Vezeteknev?></td>
  <td><input type="text" name="vezeteknev" width="65%" value="<?=$_POST['vezeteknev']?>" maxlength="50"> *</td>
</tr>

<tr>
  <td align="right"><?=$lang->Keresztnev?></td>
  <td><input type="text" name="keresztnev" value="<?=$_POST['keresztnev']?>" maxlength="50"> *</td>
</tr>

<tr>
	<th colspan=2><?=$lang->Cegnev?>:
	</th>
</tr>

<tr>
  <td align="right"><?=$lang->Cegnev?></td>
  <td><input type="text" name="cegnev" value="<?=$_POST['cegnev']?>" maxlength="200"> <font>(<?=$lang->nem_kotelezo?>)</font></td>
</tr>

<tr>
	<th colspan=2><?=$lang->Szallitasi_cim?>:
	</th>
</tr>

<tr>
  <td align="right" ><?=$lang->Orszag?></td>
  <td >
      <div>    
        <div style="float:left">
        <?
            echo $func->createSelectBox("SELECT id_orszag, nyelvi_kulcs FROM orszag ORDER BY id_orszag", $_POST['orszag'], "name=\"orszag\" id=\"orszag\" onchange=\"changeOrszag(this.options[this.selectedIndex].value)\"");
        ?>
        </div>
      </div>
  </td>
</tr>

<tr class="hun">
  <td align="right" ><?=$lang->Iranyitoszam?></td>
  <td ><input type="text" name="iranyitoszam" id="iranyitoszam" onchange="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv')" value="<?=$_POST['iranyitoszam']?>" maxlength="4"> *</td>
</tr>

<tr class="hun">
  <td align="right" ><?=$lang->Megye_Varos?></td>
  <td >
      <div>    
        <div style="float:left">
        <?
            echo $func->createSelectBox("SELECT * FROM megyek ORDER BY megye_nev", $_POST['megye'], "name=\"megye\" id=\"megye\" onchange=\"divHelysegek('helysegekdiv', this.options[this.selectedIndex].value, 'varos')\"");
        ?>
        </div>
        <div id="helysegekdiv"></div>
      </div>
  </td>
</tr>

<tr class="hun">
  <td align="right" ><?=$lang->Szallitasi_cim?></td>
  <td >
  <input type="text" id="utcanev" name="utcanev" value="<?=$_POST['utcanev']?>" maxlength="100"> *
  <br />
  
  <?
    echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes", $_POST['kozterulet'], "name=\"kozterulet\"");
  ?>
  * &nbsp;<font>(válaszd ki a megfelelő helységnevet)</font>

  <br />
  <input type="text" id="hazszam" onclick="input_clear('<?=$lang->Hazszam?>');" name="hazszam" value="<?=$_POST['hazszam']?>" maxlength="10"> *
  <br />
  
  <input type="text" id="emelet" onclick="input_clear('<?=$lang->Emelet_ajto_egyeb?>');" name="emelet" value="<?=$_POST['emelet']?>" maxlength="20">
  </td>
</tr>

<tr class="eng">
  <td align="right" ><?=$lang->Iranyitoszam?></td>
  <td ><input type="text" name="iranyitoszam" id="iranyitoszam" value="<?=$_POST['iranyitoszam']?>" maxlength="10" /> *</td>
</tr>

<tr class="eng">
  <td align="right" ><?=$lang->Varos?></td>
  <td ><input type="text" id="varos_nev" name="varos_nev" value="<?=$_POST['varos_nev']?>" maxlength="150" /> *</td>
</tr>

<tr class="eng">
  <td align="right" ><?=$lang->Szallitasi_cim?></td>
  <td >
  <input type="text" id="utcanev" onclick="input_clear('<?=$lang->Utcanev?>');" name="utcanev" value="<?=$_POST['utcanev']?>" maxlength="100"> *
  <br />
  <input type="text" id="hazszam" onclick="input_clear('<?=$lang->Hazszam?>');" name="hazszam" value="<?=$_POST['hazszam']?>" maxlength="10"> *
  <br />
  
  <input type="text" id="emelet" onclick="input_clear('<?=$lang->Emelet_ajto_egyeb?>');" name="emelet" value="<?=$_POST['emelet']?>" maxlength="20">
  </td>
</tr>

<tr>
	<th colspan=2><?=$lang->Kapcsolat?>:
	</th>
</tr>

<tr>
  <td align="right" valign="middle"><?=$lang->Email_cim?></td>
  <td><b style="color:red;"><?=$_POST['email']?></b>&nbsp;
  <font><a href="mailto:<?=$func->getMainParam('main_email')?>?subject=E-mail módosítás"><?=$lang->Modositasi_kerelmed_jelezd_az_adminnak;?></a></font></td>
</tr>

<tr>
  <td align="right" ><?=$lang->Telefonszam?></td>
  <td >
    <input type="text" name="telefonszam1_0" value="" value="<?=$_POST['telefonszam1_0']?>" size="3" maxlength="4" class="phone_code" />
    <input type="text" name="telefonszam1_1" id="telefonszam1_1" value="<?=$_POST['telefonszam1_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==3) $('telefonszam1_2').focus()">
    <input type="text" name="telefonszam1_2" id="telefonszam1_2" value="<?=$_POST['telefonszam1_2']?>" maxlength="7">
  *</td>
</tr>

<tr>
  <td align="right" ><?=$lang->Telefonszam?> 2</td>
  <td >
    <input type="text" name="telefonszam2_0" value="" value="<?=$_POST['telefonszam2_0']?>" size="3" maxlength="4" class="phone_code" />
    <input type="text" name="telefonszam2_1" id="telefonszam2_1" value="<?=$_POST['telefonszam2_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==3) $('telefonszam2_2').focus()">
    <input type="text" name="telefonszam2_2" id="telefonszam2_2" value="<?=$_POST['telefonszam2_2']?>" maxlength="7">
  <font>(<?=$lang->nem_kotelezo?>)</font></td>
</tr>

<tr>
  <td align="right"><?=$lang->Jelszo?></td>
  <td><input type="password" name="jelszo" onkeyup="$('erosseg').innerHTML='&nbsp;' + testPassword(this.value)"> * <span id="erosseg"></span></td>
</tr>

<tr>
  <td align="right"><?=$lang->jelszo_ismetlese?></td>
  <td><input type="password" name="jelszo2"> *</td>
</tr>

<tr>
  <td align="right">&nbsp;</td>
  <td><input type="checkbox" name="hirlevel" checked> Feliratkozom a <b class="alert"><?=strtoupper($func->getMainParam('MAIN_PAGE'))?></b> hírlevélre</td>
</tr>

<tr>
	<th colspan=2>&nbsp;
	</th>
</tr>

<tr>
  <td align="center" colspan=2><input type="submit" name="modositas" value="                   <?=$lang->Adatok_mentese?>                   " class="button-blue" style="width:400px;" /></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td><font style="float:right;"><?=$lang->A_csillaggal_jelolt_mezok_kitoltese_kotelezo?>!</font></td>
</tr>

</table>

</form>

</center>

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

</div>

</div>
*/
?>