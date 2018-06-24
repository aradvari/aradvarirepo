MEGRENDELES 2 PAGE
<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/ajax.2015.js?refresh" type="text/javascript"></script>

<style>
	/*div {
	  margin: 0 0 0.75em 0;
	}*/

	input[type="radio"] {
	  display: none;
	}

	input[type="radio"] + label {
	  color: #444;
	  font-family: Arial, sans-serif;
	  font-size: 14px;
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
	  background-color: #78CDD1;
	}

	input[type="radio"] + label span,
	input[type="radio"]:checked + label span {
	  -webkit-transition: background-color 0.4s linear;
	  -o-transition: background-color 0.4s linear;
	  -moz-transition: background-color 0.4s linear;
	  transition: background-color 0.4s linear;
	}

</style>

<form method="post" name="delCatForm" id="delCatForm">
 <input type="hidden" id="delid_kosar" name="delid_kosar" />
</form>


<?

if($user->isLogged())
{
	
	include 'inc/inc.islogged.php';
	
	//1x belepes user ID tarolva cookie-ban 1 evig
	if($_SESSION['felhasznalo']['aktivacios_kod']=='login_once')
	setcookie('coreShopLoginID', $_SESSION['felhasznalo']['id'], time() + 86400 * 365);

}

else
	
{ 
?>
	 
	<div class="textbox">
	<? include 'inc/inc.login_member.php'; ?>
	</div>

	
	<? 
	// desktop 1x login
	//if(!$func->isMobile())	{
		echo 'UJJJ MODD<div class="textbox">';
		include 'inc/inc.login_once2.php';
		echo '</div>';		
	/*}
	// mobil, tablet, kulon oldalon jelenik meg az egyszeri regisztracio
	else		{
		echo '<div class="textbox">';
		echo '<p>Megrendelés regisztráció nélkül</p>';
		echo '<a href="/hu/loginonce"><input type="submit" value="Megrendelés regisztráció nélkül" style="background-color:#1a3766; color:#fff; padding:10px; width:100%;"  /></a>';
		echo '</div>';
	}*/
	
}

?>
  

  
  
  <div class="content-right-headline" style="clear:both;"><?=$lang->Kosarad_tartalma ?></div>
  
  <div id="kosar" style="clear:both;">
  </div>
  


 <script>
  function delItem(str) {

   if (confirm("<?=$lang->Valoban_torli_a_kosarbol_a_termeket ?>")) {

    document.getElementById("delid_kosar").value = str;
    //document.delCatForm.delid_kosar.value=str;
    document.delCatForm.submit();

   }

  }

  function getCart() {

   divKosar('kosar', <?=(int)$_POST['kedvezmeny'] ?>, jQuery('input[name=szallitasi_mod]:checked').val());
   //checkGiftCardCode($('ajandek_kod').value, $('szallitasi_mod').value);	//ez nem jelenik meg
  }

  divHelysegek('helysegekdiv', '<?=$_POST['megye'] ?>', 'varos', '<?=$_POST['varos'] ?>');
  getCart();

 </script>

</div>


<?
/* // ajanlo, ha ures a kosar
if(count($_SESSION['kosar']) < 1)
{
 echo '<br />';
 include 'inc/welcome.ajanlo.php';
} */
?>