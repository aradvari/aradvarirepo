<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/ajax.2015.js" type="text/javascript"></script>
<script src="/js/passwordmeter.js" type="text/javascript"></script>

<div class="content-right-headline" >Új <?=strtolower($lang->regisztracio)?></div>


<form action="" method="POST" a_utocomplete="off">


<div class="textbox">
	<div class="login_once">
	<p><?=$lang->Szallitasi_nev?></p>
	<input type="text" name="vezeteknev" placeholder="Vezetéknév *" value="<?=$_POST['vezeteknev']?>" maxlength="50" style="width:50%;">
	<input type="text" name="keresztnev" placeholder="Keresztnév *" value="<?=$_POST['keresztnev']?>" maxlength="50" style="width:49%; float:right;">
	<br />
	<br />
	<input type="text" name="cegnev" placeholder="Cégnév" value="<?=$_POST['cegnev']?>">
	<br />
	<br />
	<p><?=$lang->Szallitasi_cim?></p>
	<?
	if(!($_POST['orszag'])) $_POST['orszag']=1;	//default
		echo $func->createSelectBox("SELECT id_orszag, nyelvi_kulcs FROM orszag ORDER BY id_orszag", $_POST['orszag'], "name=\"orszag\" id=\"orszag\" onchange=\"changeOrszag(this.options[this.selectedIndex].value)\" ");
	?>
	<input type="text" name="iranyitoszam" id="iranyitoszam" 
	onChange="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv'); document.getElementById('utca_kozterulet').focus();" 
	onKeyup="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv');" 
	onKeydown="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv');" 
	placeholder="<?=$lang->Iranyitoszam?> *" 
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
	
	<input type="text" id="utcanev" name="utcanev" placeholder="Utcanév *" value="<?=$_POST['utcanev'] ?>" maxlength="100" style="width:48%;">
	<?	echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes", 6,"name=\"kozterulet\" style=\" width:30%; \" ");	?>
	<input type="text" id="hazszam" name="hazszam" placeholder="házszám *" value="<?=$_POST['hazszam'] ?>" maxlength="10" size="5" style="width:20%; float:right">
	<input type="text" id="emelet" name="emelet" value="<?=$_POST['emelet'];?>" placeholder="<?=$lang->Emelet_ajto_egyeb;?>"  maxlength="20">
	
	</div>
</div>



<div class="textbox">
	<div class="login_once">
	
	<p>Elérhetőség</p>
	<input type="text" id="email" name="email" value="<?=$_POST['email']?>" placeholder="E-mail cím *" />	
	<br />
	<br />
	
	<?=$lang->Telefonszam?> 1
	<br />
	<input type="text" name="telefonszam1_0" id="telefonszam1_0" value="<?=($_POST['telefonszam1_0']==""?"+36":$_POST['telefonszam1_0'])?>" size="3" maxlength="4" style="width:20%;" />
	<input type="text" name="telefonszam1_1" id="telefonszam1_1" value="<?=$_POST['telefonszam1_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==2) $('telefonszam1_2').focus()" style="width:20%;">
	<input type="text" name="telefonszam1_2" id="telefonszam1_2" value="<?=$_POST['telefonszam1_2']?>" maxlength="7" style="float:right; width:58%;">

	<br />

	<?=$lang->Telefonszam?> 2 (<?=$lang->nem_kotelezo?>)
	<br />
	<input type="text" name="telefonszam2_0" id="telefonszam2_0" value="<?=($_POST['telefonszam2_0']==""?"+36":$_POST['telefonszam1_0'])?>" size="3" maxlength="4" style="width:20%;" />
	<input type="text" name="telefonszam2_1" id="telefonszam2_1" value="<?=$_POST['telefonszam2_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==2) $('telefonszam2_2').focus()" style="width:20%;">
	<input type="text" name="telefonszam2_2" id="telefonszam2_2" value="<?=$_POST['telefonszam2_2']?>" maxlength="7" style="float:right; width:58%;">
	
	
	<p>Jelszó *</p>
	
	<input type="password" name="jelszo" onkeyup="$('erosseg').innerHTML='&nbsp;' + testPassword(this.value)"><span id="erosseg"></span><br />
	
	Jelszó megerősítése *
	<input type="password" name="jelszo2">
	
	
	<br />
	<br />
	<input type="submit" name="regisztracio" value="<?=$lang->Regisztracios_adatok_elkuldese?>" class="arrow_box" />
	
	
	
	</div>
</div>



<?

/*
<table class="table-reg" border=0>

<tr>
	<th colspan=2><?=$lang->Szemelyes_adatok?>:
	</th>
</tr>

<tr>
  <td align="right"  width="40%"><?=$lang->Vezeteknev?></td>
  <td align="left"><input type="text" name="vezeteknev" width="60%" value="<?=$_POST['vezeteknev']?>" maxlength="50"> *</td>
</tr>

<tr>
  <td align="right" ><?=$lang->Keresztnev?></td>
  <td align="left"><input type="text" name="keresztnev" value="<?=$_POST['keresztnev']?>" maxlength="50"> *</td>
</tr>

<tr>
	<th colspan=2><?=$lang->Cegnev?>:
	</th>
</tr>

<tr>
  <td align="right" ><?=$lang->Cegnev?></td>
  <td align="left"><input type="text" name="cegnev" value="<?=$_POST['cegnev']?>" maxlength="200"> <font style="display:none;">(<?=$lang->nem_kotelezo?>)</font></td>
</tr>

<tr>
	<th colspan=2><?=$lang->Szallitasi_cim?>:
	<font style="float:right; text-transform:none; display:none;">(<?=$lang->eltero_szamlazas_szoveg?>)</font>
	</th>
</tr>

<tr>
  <td align="right" ><?=$lang->Orszag?></td>
  <td align="left">
      <div>    
        <div style="float:left">
        <?
		if(!($_POST['orszag'])) $_POST['orszag']=1;	//default
            echo $func->createSelectBox("SELECT id_orszag, nyelvi_kulcs FROM orszag ORDER BY id_orszag", $_POST['orszag'], "name=\"orszag\" id=\"orszag\" onchange=\"changeOrszag(this.options[this.selectedIndex].value)\"");
        ?>
        </div>
      </div>
  </td>
</tr>

<tr class="hun">
  <td align="right" ><?=$lang->Iranyitoszam?></td>
  <td align="left"><input type="text" name="iranyitoszam" id="iranyitoszam" 
  onkeydown="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv')" 
  onkeyup="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv')" 
  onchange="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv')" 
  value="<?=$_POST['iranyitoszam']?>" maxlength="4"> *</td>
</tr>

<tr class="hun">
  <td align="right" ><?=$lang->Megye_Varos?></td>
  <td align="left">
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
  <td align="left">
  <input type="text" id="utcanev" value="<?=($_POST['utcanev']==""?$lang->Utcanev:$_POST['utcanev'])?>" onclick="input_clear('utcanev');" name="utcanev" maxlength="100"> *
  <?
    echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes", $_POST['kozterulet'], "name=\"kozterulet\"");
  ?>
  * <font style="display:none;">(<?=$lang->valaszd_ki_a_megfelelo_helysegnevet?>)</font>

  <br />
  <input type="text" id="hazszam" value="<?=($_POST['hazszam']==""?$lang->Hazszam:$_POST['hazszam'])?>" onclick="input_clear('hazszam');" name="hazszam" maxlength="10"> *
  <br />
  
  <input type="text" id="emelet" value="<?=($_POST['emelet']==""?$lang->Emelet_ajto_egyeb:$_POST['emelet'])?>" onclick="input_clear('emelet');" name="emelet" maxlength="20">
  </td>
</tr>

<tr class="eng">
  <td align="right" ><?=$lang->Iranyitoszam?></td>
  <td align="left"><input type="text" name="iranyitoszam" id="iranyitoszam" value="<?=$_POST['iranyitoszam']?>" maxlength="10" /> *</td>
</tr>

<tr class="eng">
  <td align="right" ><?=$lang->Varos?></td>
  <td align="left"><input type="text" id="varos_nev" name="varos_nev" value="<?=$_POST['varos_nev']?>" maxlength="150" /> *</td>
</tr>

<tr class="eng">
	<td align="right"><?=$lang->Utcanev?></td>
	<td align="left"><input type="text" id="utcanev" value="<?=($_POST['utcanev']==""?$lang->Utcanev:$_POST['utcanev'])?>" onclick="input_clear('utcanev');" name="utcanev" maxlength="100"> *</td>
</tr>

<tr class="eng">
	<td align="right"><?=$lang->Hazszam?></td>
	<td align="left"><input type="text" id="hazszam" value="<?=($_POST['hazszam']==""?$lang->Hazszam:$_POST['hazszam'])?>" onclick="input_clear('hazszam');" name="hazszam" maxlength="10"> *</td>
</tr>

<tr class="eng">
	<td align="right"><?=$lang->Emelet_ajto_egyeb?></td>
	<td align="left"><input type="text" id="emelet" value="<?=($_POST['emelet']==""?$lang->Emelet_ajto_egyeb:$_POST['emelet'])?>" onclick="input_clear('emelet');" name="emelet" maxlength="20"></td>
</tr>


<tr>
	<th colspan=2><?=$lang->Kapcsolat?>:
	</th>
</tr>

<tr>
  <td align="right" ><?=$lang->Email_cim?></td>
  <td align="left"><input type="text" name="email" value="<?=$_POST['email']?>"> *
  </td>
</tr>

<tr>
  <td align="right" ><?=$lang->Telefonszam?></td>
  <td align="left">
    <input type="text" name="telefonszam1_0" value="" value="<?=$_POST['telefonszam1_0']?>" size="3" maxlength="4" class="phone_code" />
    <input type="text" name="telefonszam1_1" id="telefonszam1_1" value="<?=$_POST['telefonszam1_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==3) $('telefonszam1_2').focus()">
    <input type="text" name="telefonszam1_2" id="telefonszam1_2" value="<?=$_POST['telefonszam1_2']?>" maxlength="7">
  *</td>
</tr>

<tr>
  <td align="right" ><?=$lang->Telefonszam?> 2</td>
  <td align="left">
    <input type="text" name="telefonszam2_0" value="" value="<?=$_POST['telefonszam2_0']?>" size="3" maxlength="4" class="phone_code" />
    <input type="text" name="telefonszam2_1" id="telefonszam2_1" value="<?=$_POST['telefonszam2_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==3) $('telefonszam2_2').focus()">
    <input type="text" name="telefonszam2_2" id="telefonszam2_2" value="<?=$_POST['telefonszam2_2']?>" maxlength="7">
  <font>(<?=$lang->nem_kotelezo?>)</font></td>
</tr>

<tr>
  <td align="right" ><?=$lang->Jelszo?></td>
  <td align="left"><input type="password" name="jelszo" onkeyup="$('erosseg').innerHTML='&nbsp;' + testPassword(this.value)"> * <span id="erosseg"></span></td>
</tr>

<tr>
  <td align="right" ><?=$lang->jelszo_ismetlese?></td>
  <td align="left"><input type="password" name="jelszo2"> *</td>
</tr>

<tr>
	<th colspan=2><?=$lang->Hirlevel?>:
	</th>
</tr>

<tr>
  <td align="right" >&nbsp;</td>
  <td align="left"><input type="checkbox" name="hirlevel" checked> <?=$lang->Feliratkozom_a_hirlevelre?></td>
</tr>

<tr>
  <td colspan=2 align="center"><input type="submit" name="regisztracio" value="<?=$lang->Regisztracios_adatok_elkuldese?>" class="button-blue" style="text-align-center; width:500px;" /></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td><br /><font style="float:right;"><?=$lang->A_csillaggal_jelolt_mezok_kitoltese_kotelezo?>!</font></td>
</tr>

</table>
*/
?>




</form>


<script>
    divHelysegek('helysegekdiv', '<?=$_POST['megye']?>', 'varos', '<?=$_POST['varos']?>');
    
    function changeOrszag(id){
        
        if (id==1){ /* MAGYARORSZÁG*/
         
            jQuery('.hun').show();
            jQuery('.eng').hide();
            jQuery('.hun input').attr("disabled", "");
            jQuery('.eng input').attr("disabled", "disabled");
            jQuery('.phone_code').val("+36");
            
        }else{ /* KÜLFÖLD */
        
            jQuery('.hun').hide();
            jQuery('.eng').show();
            jQuery('.hun input').attr("disabled", "disabled");
            jQuery('.eng input').attr("disabled", "");
            jQuery('.phone_code').val("+");
        
        }
        
    }
    changeOrszag('<?=$_POST['orszag']?>');
</script>