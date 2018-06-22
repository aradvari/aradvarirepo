<?
// save
if (!empty($_POST))	{
	if (mysql_query('UPDATE index_infobox SET url="'.$_POST['url'].'", szoveg="'.$_POST['szoveg'].'", lang="'.$_POST['lang'].'" WHERE id='.$_POST['iiid'].''))
		echo '<div style="padding:10px;margin:5px 0;border:1px solid green;color:green;background-color:#ccff99;">Elmentve</div>';
}


$sql = "SELECT *
		
		FROM index_infobox ii
		
		ORDER BY ii.lang asc";
      
$query = mysql_query($sql);
  
echo '<table border=0 cellspacing=10 cellpadding=10>';

echo '<tr><td colspan="5" class="darkCell">Index Infobox</td></tr>';

while ($adatok = mysql_fetch_array($query))	{
	echo '<tr><td>
			<form action="" method="POST" name="ii'.$adatok['id'].'"/>
			<input type="hidden" name="iiid" value="'.$adatok['id'].'" />
			Link: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="'.$adatok['url'].'" size="40" name="url" onChange="document.ii'.$adatok['id'].'.submit();" />
			<br />
			Szöveg: <input type="text" value="'.$adatok['szoveg'].'" size="34" name="szoveg" onChange="document.ii'.$adatok['id'].'.submit();" />
			<br />
			Nyelv: &nbsp;&nbsp;&nbsp;<input type="text" value="'.$adatok['lang'].'" size="1" name="lang" onChange="document.ii'.$adatok['id'].'.submit();" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<input type="submit" value="ok" />
			</form>
	</td></tr>';
}
	
	
	
	

	/*while ($adatok = mysql_fetch_array($query)){
	  
	  $i++;
	  if ($i==1) echo '<tr>';
    ?>
    
        <td valign="top" align="center" style="width:115px;" class="lightCell">
		
		<form action="" method="POST" name="ajanlat<?=$adatok['pozicio'];?>" style="margin:0; padding:0;">
			
			ID: <input type="text" value="<?=$adatok['id'];?>" size="7" name="id_termek" onChange="document.ajanlat<?=$adatok['pozicio']?>.submit();" /><br /><br />
			
			<input type="hidden" name="pozicio" value="<?=$adatok['pozicio']?>" />
            
			<div align="right">
			
            <b><?=$adatok['markanev']?></b><br />
            <?=substr($adatok['termeknev'],0,14)?><br />			
			
			<?
			if ($adatok['akcios_kisker_ar']>0)	{
					echo	'<del>'.number_format($adatok['kisker_ar'], 0, '', ' ').' Ft</del><br />';	// eredeti ar athuzva
					echo	'Akció: '.number_format($adatok['akcios_kisker_ar'], 0, '', ' ').' Ft<br />';	//akcios ar
					}
			else
					echo	'<br />kisker ár: '.number_format($adatok['kisker_ar'], 0, '', ' ').' Ft<br />';
                  
            if ($adatok['klub_ar']>0) echo 'Club ár: '.number_format($adatok['klub_ar'],0,'',' ').' Ft';
			?>
			
			</div>
			
			</form>
			
			</td>
    
    <?
	if ($i%5==0) echo '</tr>';
    }*/
?>  

</table>