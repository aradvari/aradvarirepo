<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/ajax.2015.js?refresh" type="text/javascript"></script>

<form method="post" name="delCatForm" id="delCatForm">
 <input type="hidden" id="delid_kosar" name="delid_kosar" />
</form>


<?
// mobil, tablet, kulon oldalon jelenik meg az egyszeri regisztracio

echo '<div class="textbox" style="width:100%;max-width:1000px;">';
include './inc/inc.login_once.php';
echo '</div>';
?>

<div class="content-right-headline" style="clear:both;"><img src="/images/cart-grey.png" alt="Coreshop.hu - <?=$lang->kosar ?>" style="vertical-align:middle; d_isplay:none;" /><?=$lang->Kosarad_tartalma ?></div>
  
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

   divKosar('kosar', <?=(int)$_POST['kedvezmeny'] ?>, jQuery('#szallitasi_mod').val());
   //checkGiftCardCode($('ajandek_kod').value, $('szallitasi_mod').value);	//ez nem jelenik meg
  }

  divHelysegek('helysegekdiv', '<?=$_POST['megye'] ?>', 'varos', '<?=$_POST['varos'] ?>');
  getCart();

 </script>

</div>


<?
// ajanlo, ha ures a kosar
if(count($_SESSION['kosar']) < 1)
{
 echo '<br />';
 include 'inc/welcome.ajanlo.php';
}
?>