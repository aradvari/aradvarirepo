<form method="post" id="megrForm" name="megrForm" autocomplete="off">

<style>
	.radioSelect {
	  margin: 0 0 0.75em 0;
	}

	.radioSelect div{
		display: inline-block;
		margin: 0px 10px;
		width: 40%;
	}

	input[type="radio"] {
	  display: none;
	  
	}
	
	input[type="radio"] + label {
	  /*color: #666;
	  font-family: Arial, sans-serif;*/
	  font-size: 18px;
	  color:#222;
	  cursor: pointer;
	}

	input[type="radio"] + label span {
	  display: inline-block;
	  width: 19px;
	  height: 19px;
	  margin: -1px 4px 0 0;
	  vertical-align: middle;
	  cursor: pointer;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	}

	input[type="radio"] + label span {
	  background-color: #444;
	}

	input[type="radio"]:checked + label span {
	  background-color: #2a87e4;
	}
	
	input[type="radio"]:checked+label{color:#2a87e4;}

	input[type="radio"] + label span,
	input[type="radio"]:checked + label span {
	  -webkit-transition: background-color 0.4s linear;
	  -o-transition: background-color 0.4s linear;
	  -moz-transition: background-color 0.4s linear;
	  transition: background-color 0.4s linear;
	}


	input[type="radio"]:checked+label{
		background: transparent !important;
	}

		@media screen and (max-width: 720px) {
	input[type="radio"] + label {
	  color: #666;
	  font-family: Arial, sans-serif;
	  font-size: 14px !important;
	  text-align: center !important;
	  cursor: pointer;
	  line-height: 20px;
	  } 
	  
	input[type="radio"] + label span {
	  display: inline-block;
	  width: 10px !important;
	  height: 10px !important;
	  margin: -1px 4px 0 0;
	  vertical-align: middle;
	  cursor: pointer;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	}
	
	.radioSelect div{
		display: inline-block;
		margin: 0px 10px;
		width: 100%;
	}
	} 
	
</style>

<div class="content-right-headline"><?=$lang->megrendeles_veglegesitese ?></div>

<center>


<!-- szallitasi adatok -->
<div class="textbox">

	<table class="table-reg" border=0>

	 <tr>
	  <th colspan=2><?=$lang->Szallitasi_adatok ?> <a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_adataim ?>" style="text-transform:none; float:right;">(<?=$lang->szerkesztes ?>)</a></th>
	 </tr>

	 <?
	 $megrendelo_neve=$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev']." (".$_SESSION['felhasznalo']['cegnev'].")";
	 $megrendelo_neve=str_replace("()","",$megrendelo_neve);
	 ?>
	 <tr>
	  <td><?=$lang->Szallitasi_nev ?></td>
	  <td style="text-align:left;"><a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_adataim ?>"><?=$megrendelo_neve ?></a></td>
	 </tr>

	 <tr>
	  <td><?=$lang->Szallitasi_cim ?></td>
	  <td style="text-align:left;"><a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_adataim ?>">
	  <?=$lang->$_SESSION['felhasznalo']['orszag_nev']."<br />".
	  $_SESSION['felhasznalo']['irszam']." ".$_SESSION['felhasznalo']['varos_nev']."<br />".
	  $_SESSION['felhasznalo']['utcanev']." ".$_SESSION['felhasznalo']['kozterulet_nev']." ".$_SESSION['felhasznalo']['hazszam']."<br />".
	  $_SESSION['felhasznalo']['emelet'] ?></a>
	  </td>
	 </tr>

	 <tr>
	  <td><?=$lang->Email_cim ?></td><td style="text-align:left;"><a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_adataim ?>"><?=$_SESSION['felhasznalo']['email'] ?></a></td>
	 </tr>
	 
	 
	 <tr>
	  <td><?=$lang->Telefonszam ?></td><td style="text-align:left;"><a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_adataim ?>">
	  <?=$_SESSION['felhasznalo']['telefonszam1']."<br />".
	  $_SESSION['felhasznalo']['telefonszam2'] ?></a></td>
	 </tr>
	 
	 </table>

<!-- endof szallitasid adatok -->
</div>


<!-- szamlazasi adatok -->

<div class="textbox">

<table class="table-reg" border=0>

<!-- szamlazasi cim -->
<tr><th colspan=2>Számla</th></tr>

<tr>
  <td><?=$lang->Szamlazasi_nev ?>, <?=$lang->cegnev ?></td>
  <td style="text-align:left;"><input type="text" name="szamlazasi_nev" value="<?=$_POST['szamlazasi_nev'] == "" ? $megrendelo_neve : $_POST['szamlazasi_nev'] ?>" maxlength="200" /></td>
 </tr>
 <?
 if($_SESSION['felhasznalo']["id_orszag"] == 1)
 { //MAGYARORSZÁG ESETÉN
  ?>

  <tr>
   <td><?=$lang->Szamlazasi_cim ?></td>
   <td>
	<div style="float:left">
	
	
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
onchange=\"divHelysegek('helysegekdiv', this.options[this.selectedIndex].value, 'varos')\" style=\"width:67%; margin-right:0; \" ", "Válassz megyét");
?>

<div id="helysegekdiv"></div>
	
	
   </td>
  </tr>
  <tr>
   <td>&nbsp;</td>
   <td style="text-align:left;">
	<input type="text" id="utcanev" name="utcanev" placeholder="utcanév" value="<?=$_POST['utcanev'] ?>" maxlength="100" style="width:60%;">
	<?
	echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes",$_POST['kozterulet'],"name=\"kozterulet\" style=\" width:30%; \" ");
	?>
	<input type="text" id="hazszam" name="hazszam" placeholder="házszám" value="<?=$_POST['hazszam'] ?>" maxlength="10" size="5" style="width:60%;">
   </td>
  </tr>

  <?
 }
 else
 {
  ?>

  <tr>
   <td><?=$lang->Szamlazasi_cim ?></td>
   <td style="text-align:left;">
	<?=$lang->$_SESSION['felhasznalo']['orszag_nev'] ?>
	<input type="text" name="iranyitoszam" id="iranyitoszam" value="<?=$_POST['iranyitoszam'] ?>" maxlength="10" size="4" />
	<input type="text" id="varos_nev" name="varos_nev" value="<?=$_POST['varos_nev'] ?>" maxlength="150" /><br />
	<input type="text" id="utcanev" name="utcanev" value="<?=$_POST['utcanev'] ?>" maxlength="100">
	<input type="text" id="hazszam" name="hazszam" value="<?=$_POST['hazszam'] ?>" maxlength="10" size="5">
   </td>
  </tr>

  <?
 }
 ?>

</table>

</div>

<!-- endof szamlazasi adatok -->


<div class="textbox" style="margin-top:4%; width:92%; ">
<!-- fizetes, ajandekkartya kod, megjegyzes -->
<table class="table-reg">
  <th colspan=2><?=$lang->Szallitas ?>, <?=$lang->Fizetes_modja ?></th>

 <tr>
  <td><?=$lang->Szallitas_modja ?></td>
  <td style="text-align:left;">
	<div class="radioSelect">
	  	<div>
		  	<input checked type="radio" id="szallitasi_mod1" name="szallitasi_mod" value="1"   onchange="getCart()"/>
		  	<label for="szallitasi_mod1"><span></span>Csomagküldő szolgálattal</label>
		</div>

		<div>
		 	<input onclick='getCart()' type="radio" id="szallitasi_mod2" name="szallitasi_mod" value="2"/>
		 	<label onclick='getCart()' for="szallitasi_mod2"><span></span>Személyes átvétel irodánkban</label>
		</div>
	</div>
   <?
   /*
   if($_SESSION["felhasznalo"]["id_orszag"] == 1)
	$szallitasi_modok=array(1=>"Csomagkuldo_szolgalattal",2=>"Szemelyes_atvetel");
   else
	$szallitasi_modok=array(1=>"Csomagkuldo_szolgalattal");



   echo $func->createArraySelectBox($szallitasi_modok,$_POST['szallitasi_mod'] == "" ? 1 : $_POST['szallitasi_mod'],"name=\"szallitasi_mod\" id=\"szallitasi_mod\" onchange='getCart()'  ","");
   */
   ?>
  </td>
 </tr>

 <tr>
  <td><?=$lang->Fizetes_modja ?></td>
  <td style="text-align:left;">
  	<div class="radioSelect">
  		<div>
		  	<input checked type="radio" id="fizetesi_mod1" name="fizetesi_mod" value="1"  onchange="getCart()"/>
		  	<label for="fizetesi_mod1"><span></span>Utánvét (készpénz)</label>
		</div>

		<div>
		 	<input type="radio" id="fizetesi_mod2" name="fizetesi_mod"  value="2"   onchange="getCart()"/>
		 	<label for="fizetesi_mod2"><span></span>Bankkártyás fizetés</label>
		</div>
	</div>
   <?
   /*
   if($_SESSION["felhasznalo"]["id_orszag"] == 1)
	$fizetesi_modok=array(1=>"Utanvetel",2=>"Bankkartyas_fizetes");
   else
	$fizetesi_modok=array(2=>"Bankkartyas_fizetes");
   echo $func->createArraySelectBox($fizetesi_modok,$_POST['fizetesi_mod'] == "" ? 1 : $_POST['fizetesi_mod'],"name=\"fizetesi_mod\"  ","");

   */
   ?>
   <!--
   <br />
   Utánvétnél készpénzben a futárnál &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VAGY <br />a feltüntetett bankkártya típusokkal: <a href="/<?=$lang->defaultLangStr ?>/<?=$lang->_kartyas_fizetes ?>"><img src="/images/cib-bankkartya-logok.png" style="width:120px;vertical-align:middle;" alt="<?=$lang->Elfogadott_bankkartya_tipusok ?>" /> 
   (<?=$lang->Tajekoztato_a_kartyas_fizetesrol ?>)</a>
   -->
  </td>
 </tr>

 <tr><td colspan="2"></td></tr>

 <tr>
  <td style="color:#2a87e4;"><?=$lang->Ajandek_kartya_kod ?></td>
  <td style="text-align:left;"><input type="text" name="ajandek_kod" id="ajandek_kod" value="<?=$_POST['ajandek_kod'] ?>" style="border: 1px solid #2a87e4;" maxlength="30" onkeypress="checkGiftCardCode(this.value)" onclick="checkGiftCardCode(this.value)" onkeyup="checkGiftCardCode(this.value)" onkeydown="checkGiftCardCode(this.value)" onchange="checkGiftCardCode(this.value)" /> <p id="errorDiv" style="border:none;"></p></td>
 </tr>

 <tr>
  <td><?=$lang->Megjegyzes ?></td>
  <td style="text-align:left;">
   <textarea name="megjegyzes" placeholder='Pl: csomagátvétellel kapcsolatos információk'><?=$_POST['megjegyzes'] ?></textarea>
  </td>
 </tr>


</table>
</div>
<!-- endof fizetes, ajandekkartya kod, megjegyzes -->

</center>

</form>	