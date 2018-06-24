<?
//LAPLÉPTETŐ FORM
echo '<form method="post" name="pageStepForm" id="pageStepForm">';
echo '<input type="hidden" name="oldal" id="oldal" />';
//echo '<input type="hidden" name="meretek" id="meretek" value="'.htmlspecialchars($_POST['meretek']).'" />';
echo '<input type="hidden" name="keresendo" value="'.htmlspecialchars($_POST['keresendo']).'" />';
echo '</form>';
  
// Belga shop img
$belga_kategoriak=array(155,154,150,151,152,153);
$exp = explode("/", $_GET['query']);
$kat = $exp[3];
if (in_array($kat, $belga_kategoriak))	{	
	//echo '<a href="/'.$_SESSION["langStr"]."/".$lang->_termekek.'/belga/150" ><img src="/images/belga.coreshop.hu.mod.jpg" alt="belga.coreshop.hu" style="margin-bottom:10px;" /></a>';
	
	// Sanyi fejlec
	echo '<a href="/'.$_SESSION["langStr"]."/".$lang->_termekek.'/belga/150" ><img src="/images/belga.coreshop.hu.sanyi.jpg" alt="belga.coreshop.hu" style="margin-bottom:10px;" /></a>';
	}
  
?>

<!-- transparent container eleje -->
<div class="right-container">

<!-- alkategoriak -->
<?
if($_GET['kategoria']<>0)	{
	
	echo '<div class="subcat-container">';
	
	$i=0;
	foreach($edit->alkategoriak as $alkat)	{
	$i++;
	if($i==count($edit->alkategoriak)) $style="style=\"border-right:none;\"";		// utolso elem jobb border nelkul
		
		if ($alkat["selected"])	{ //Ha ki van választva a kategória
		
		?>
				<a href="<?="/".$_SESSION["langStr"]."/".$lang->_termekek."/".$func->convertString($lang->$alkat["nyelvi_kulcs"])."/".$alkat["id_kategoriak"]?>" <?=$style;?> >
					<b><?=$lang->$alkat['nyelvi_kulcs']?></b>
				</a>
		<?
		
		}else{
		
		?>
				<a href="<?="/".$_SESSION["langStr"]."/".$lang->_termekek."/".$func->convertString($lang->$alkat["nyelvi_kulcs"])."/".$alkat["id_kategoriak"]?>" <?=$style;?>>
					<?=$lang->$alkat['nyelvi_kulcs']?>
				</a>
		<?		
		}
	}
	
	echo '</div>';
}
?>


<?
/*if (count($edit->markak)>0){
?>

<!-- Márkák -->
<select onchange="document.location.href=this.value">
    <option value="<?="/".$_SESSION["langStr"]."/".$lang->_termekek."/".$edit->kURL?>"><?=$lang->osszes_marka?></option>
<?

foreach($edit->markak as $marka){
    
    ?>
        <option 
            <?=((int)$_GET['marka']==$marka["id"]?"selected='selected'":"")?> 
            value="<?="/".$_SESSION["langStr"]."/".$lang->_termekek."/".$edit->kURL.$func->convertString($marka["markanev"])."/".$marka["id"]?>">
            <?=$marka["markanev"]?>
        </option>
    <?
    
}

?>
</select>

<?
}*/
?>

<!-- filter -->
<div class="grey-container" style="font-size:12px;"><?=$edit->filter?></div>

<center>

<div class="pagestepper"><? $edit->echoPageStepper();?></div>



<!-- termék thumbnail-ek -->
<table align="center" class="products_table" >
  
  <?
    $num=0;
	$row=0;
    while ($lista=mysql_fetch_array($edit->lista_query)) { 
		
        if (++$num==1) {
					echo '<tr>';
					$row++;
					}
		
		$notopborder='';
		if ($row==1)	$notopborder='border-top:none;';
		
		$noleftborder='';
		if ($num%5==1)	$noleftborder='border-left:none;';
     
        echo '<td align="center" valign="top" style="'.$noleftborder.$notopborder.'">';
        
        $edit->echoProductTM($lista);
        
        echo '</td>';
        
        if ($num==5){
        
            echo '</tr>';
            $num=0;
            
        }
        
    }
    
    if ($num<>0) echo '</tr>';
      
      

      
  ?>
  
</table>

<div style="margin-top:10px;"><? $edit->echoPageStepper();?></div>

</center>
<!-- termék thumbnail-ek vége -->

</div>
<!-- transparent container vege -->