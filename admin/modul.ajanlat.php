<?
// img upload	
$folder = '../coreshop.hu/banner/2014/index/';

$spot_folder = '../coreshop.hu/banner/'.date('Y').'/';

	
// save banner bottom
if (!empty($_POST['banner-bottom']))
	{
		
	$url = str_replace("http://coreshop.hu", "", $_POST['banner_url']);
	
	$query = 'UPDATE index_ajanlat SET img="'.$_FILES["file"]["name"].'", url="'.$url.'", alt="'.$_POST['banner_alt'].'" WHERE pozicio='.$_POST['banner-bottom'];
	
	
	if(mysql_query($query))
		echo '<div class="green-box">BANNER HOZZÁADVA &#10003;</div><br />';
			
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/png")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/pjpeg"))
	&& ($_FILES["file"]["size"] < 200000000) )
	  {
	  if ($_FILES["file"]["error"] > 0)
		{
		echo "<div class='red-box'>Return Code: " . $_FILES["file"]["error"] . "</div>";
		}
	  else
		{

		if (file_exists($folder.$_FILES["file"]["name"]))
		  {
		  echo '<div class="red-box">A fájl (<b>'.$_FILES["file"]["name"].'</b>) már létezik. </div>';
		  }
		else
		  {
		  move_uploaded_file($_FILES["file"]["tmp_name"], $folder.$_FILES["file"]["name"]);
		  echo 'Banner hozzáadva &#10003;';
		  }
		}
	  }
	else
	  {
	  echo '<div class="red-box">Hibás, vagy érvénytelen fájl</div>';
	  }	
	
	}

	
	

// save termekajanlat

if (!empty($_POST['pozicio']))	{	
	
	$keszlet = mysql_fetch_array(mysql_query('SELECT sum(keszlet_1) FROM `vonalkodok` WHERE id_termek='.$_POST['id_termek']));
	
	if ($keszlet[0]>0)	{
		mysql_query('UPDATE index_ajanlat SET id_termek='.$_POST['id_termek'].' WHERE pozicio='.$_POST['pozicio']);
		echo '<div class="green-box">Elmentve &#10003;<br /> ID: '.$_POST['id_termek'].'</div>';
		}
	else
		echo '<div class="red-box">Nincs készleten a megadott termék!<br /> ID: '.$_POST['id_termek'].'</div>';
}


// save spot

if (!empty($_POST['banner-spot']))	{		
		
	$url = str_replace("http://coreshop.hu", "", $_POST['spot_url']);
	$app_url = str_replace("http://coreshop.hu", "", $_POST['spot_app_url']);
	
	$query = 'INSERT INTO index_spot (aktiv, lang, img, url, app_url, alt, added) VALUES (
				0, 
				"'.$_POST['lang'].'", 
				"/banner/'.date('Y').'/'.$_FILES['spot_file']['name'].'", 
				"'.$url.'", 
				"'.$app_url.'", 
				"'.$_POST['spot_alt'].'",
				"'.date('Y-m-d H:i:s').'")';				
	
	if(mysql_query($query))
		echo '<div class="green-box">Banner hozzáadva &#10003;</div><br />';
			
	if ((($_FILES["spot_file"]["type"] == "image/gif")
	|| ($_FILES["spot_file"]["type"] == "image/png")
	|| ($_FILES["spot_file"]["type"] == "image/jpeg")
	|| ($_FILES["spot_file"]["type"] == "image/pjpeg"))
	&& ($_FILES["spot_file"]["size"] < 200000000) )
	  {
	  if ($_FILES["spot_file"]["error"] > 0)
		{
		echo "<div class='red-box'>Return Code: " . $_FILES["spot_file"]["error"] . "</div>";
		}
	  else
		{

		if (file_exists($spot_folder.$_FILES["spot_file"]["name"]))
		  {
		  echo '<div class="red-box">A fájl (<b>'.$_FILES["spot_file"]["name"].'</b>) már létezik. </div>';
		  }
		else
		  {
		  move_uploaded_file($_FILES["spot_file"]["tmp_name"], $spot_folder.$_FILES["spot_file"]["name"]);
		  echo '<div class="green-box">File feltöltve: '.$_FILES['spot_file']['name'].' &#10003;</div>';
		  }
		}
	  }
	else
	  {
	  echo '<div class="red-box">Hibás, vagy érvénytelen fájl</div>';
	  }	
	
	}
	
// update spot
if(ISSET($_POST['spot_id']))	{
	if(!$_POST['aktiv']) $_POST['aktiv']=0;
	$query= 'UPDATE index_spot SET aktiv='.$_POST['aktiv'].' WHERE id='.$_POST['spot_id'];
	mysql_query($query);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//// KEZDOLAP AJANLO //////////////////////////////////////////////

echo '<div>';

$sql = "SELECT
		ia.pozicio,
		m.markanev,
		t.termeknev,
		t.klub_ar,
		t.kisker_ar,
		t.akcios_kisker_ar,
		t.id,
		t.opcio,
		t.fokep
		
		FROM index_ajanlat ia

		LEFT JOIN termekek t ON (ia.id_termek = t.id)
		LEFT JOIN markak m ON (m.id = t.markaid)
		
		ORDER BY ia.pozicio
		
		LIMIT 10 /* a 11, 12 az also banner */
		";
      
      $query = mysql_query($sql);
	
	
	echo '<table cellspacing="10" cellpadding="10" width=600 border=0>';
	
	echo '<tr><td colspan="5" class="darkCell">Kezdőlap termékajánló</td></tr>';

	while ($adatok = mysql_fetch_array($query)){
	  
	  $i++;
	  if ($i==1) echo '<tr>';
    ?>
    
        <td valign="top" align="center" style="width:115px;" class="lightCell">
		
		<form action="" method="POST" name="ajanlat<?=$adatok['pozicio'];?>" style="margin:0; padding:0;">
			
			ID: <input type="text" value="<?=$adatok['id'];?>" size="7" name="id_termek" onChange="document.ajanlat<?=$adatok['pozicio']?>.submit();" /><br /><br />
			
			<input type="hidden" name="pozicio" value="<?=$adatok['pozicio']?>" />
                  
          <?			
          
            $kep = $func->getHDir($adatok['id']).$adatok['fokep']."_small.jpg";          
			
			echo '<img src="http://coreshop.hu/'.$kep.'" width="105" align="center"><br />';                
          
          ?>          
            
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
    }
    ?>  
	
	</table>
	
	<!-- endof kezoldap ajanlo -->
	</div>
	
	<!-- kezdolap banner -->
	
	<table width=600 border=0 style="margin:40px;">

	<tr><td colspan=2 class="darkCell">Kezdőlap banner (alul)<span style="float:right;font-weight:bold">Kép könyvtár: <?=$folder?></span></td></tr>
	
		<!-- 1 -->
		<td align="left" width="50%">
			
			<form method="POST" action="" enctype="multipart/form-data" >
				
				<?
				$banner1 = mysql_fetch_array(mysql_query('SELECT * FROM index_ajanlat WHERE pozicio=11'));
				$folder = str_replace('../', 'http://', $folder);
				?>

				<b><?=$banner1['alt']?></b>
				<br />
				<br />
				<b><?=$banner1['url']?></b>
				<br />
				<br />
				
				<!-- 11 a bal also banner szama @index_ajanlat -->
				<input type="hidden" name="banner-bottom" value=11 />
				
				<img src="<?=$folder.$banner1['img'];?>" alt="<?=$folder.$banner1['img'];?>" style="width:260px" /><br />
				
				<hr>
				
				+ Új banner hozzáadása
				
				<input type="text" name="banner_alt" style="width:94%;padding:5px;margin:5px;" placeholder="Név ( Vans Old Skool Navy )" /> <br />
				
				<input type="text" name="banner_url" style="width:94%;padding:5px;margin:5px;" placeholder="URL ( /hu/termek/old_skool/4455 )" /> <br />
				
				<input type="file" id="file" name="file" style="width:94%;padding:5px;margin:5px;" /> <br />
				
				<input type="submit" value="mentés" style="width:94%;padding:5px;margin:5px;" />	<br />		
			</form>
			
		</td>
		
		<!-- 2 -->
		<td align="left" width="50%">
		
			<form method="POST" action="" enctype="multipart/form-data" >
				
				<?
				$banner1 = mysql_fetch_array(mysql_query('SELECT * FROM index_ajanlat WHERE pozicio=12'));
				$folder = str_replace('../', 'http://', $folder);
				?>

				<b><?=$banner1['alt']?></b>
				<br />
				<br />
				<b><?=$banner1['url']?></b>
				<br />
				<br />
				
				<!-- 12 a jobb also banner szama @index_ajanlat -->
				<input type="hidden" name="banner-bottom" value=12 />
				
				<img src="<?=$folder.$banner1['img'];?>" alt="<?=$folder.$banner1['img'];?>" style="width:260px" /><br />
				
				<hr>
				
				+ Új banner hozzáadása
				
				<input type="text" name="banner_alt" style="width:94%;padding:5px;margin:5px;" placeholder="Név ( Vans Old Skool Navy )" /> <br />
				
				<input type="text" name="banner_url" style="width:94%;padding:5px;margin:5px;" placeholder="URL ( /hu/termek/old_skool/4455 )" /> <br />
				
				<input type="file" id="file" name="file" style="width:94%;padding:5px;margin:5px;" /> <br />
				
				<input type="submit" value="mentés" style="width:94%;padding:5px;margin:5px;" />	<br />		
			</form>
		
		</td>
		
	</tr>	
	</table>

	<!-- index spot -->
	
	<table width=600 border=0 style="margin:40px;">
	
	<tr><td colspan=2 class="darkCell">Index Spot<span style="float:right;font-weight:bold">Spot könyvtár: <?=$spot_folder?></span></td></tr>
	
	<!-- add -->
	<tr>
		<td colspan=2>		
		
		<form method="POST" action="" enctype="multipart/form-data"  />
		
		<input type="hidden" name="banner-spot" value=1 />
		
		+ index spot hozzáadása / nyelvválasztás:
		
		<select name="lang">
			<option value="hu">HU</option>
			<option value="en">EN</option>
		</select>
				
		<input type="text" name="spot_alt" style="width:98%;padding:5px;margin:5px;" placeholder="Név ( Vans Old Skool Navy )" /> <br />
		
		<input type="text" name="spot_url" style="width:98%;padding:5px;margin:5px;" placeholder="WEBSHOP URL ( /hu/termek/old_skool/4455 ) *" /> <br />
		
		<input type="text" name="spot_app_url" style="width:98%;padding:5px;margin:5px;" placeholder="APP URL ( /appshop/navigacio/ferfi_cipo/94?brand=41&brandname=Vans&size= ) *" /> <br />
		
		<input type="file" id="spot_file" name="spot_file" style="width:98%;padding:5px;margin:5px;" /> <br />
		
		<input type="submit" value="mentés" style="width:98%;padding:5px;margin:5px;" />
		
		</form>
				
		</td>		
		
	</tr>
	
	<tr>
		<!-- hu -->
		<td valign="top" style="width:50%;">
		<img src="http://coreshop.hu/images/flags/0.jpg" /> coreshop.hu <br /><br />
		<?
		$res = mysql_query('SELECT * FROM index_spot WHERE lang="hu" ORDER BY added DESC, aktiv DESC LIMIT 10');	// HU
		
		while($row=mysql_fetch_array($res))	{
			echo '<div style="border-top:1px dotted #333; margin:5px 0;">';
			
			$opacity=0.3;
			$check="";
			if($row['aktiv']==1) { $check="checked"; $opacity=1; }
			
			echo '<form method="POST" action="" name="spot_active" />';
			echo '<input type="hidden" name="spot_id" value='.$row['id'].' />';
			echo '<img src="http://coreshop.hu'.$row['img'].'" alt="'.$row['alt'].'" style="width:50%;opacity:'.$opacity.';border:0px solid blue;" /><br /><br />';
			echo '<input type="checkbox" value=1 name="aktiv" '.$check.' onclick="this.form.submit();" /> Aktív | '.strtoupper($row['lang']).' &middot; '.$row['alt'].' &middot; | '.$row['added'];
			echo '<input type="text" value="'.$row['alt'].'" name="alt" /><br />';
			echo '<input type="text" value="" name="" /><br />';
			echo '<input type="text" value="" name="" /><br />';
			echo '<input type="text" value="" name="" /><br />';
			echo '</form>';
		
			echo '</div>';
		}
		?>
		</td>
		
		
		<!-- en -->
		<td valign="top" style="width:50%;">
		<img src="http://coreshop.hu/images/flags/1.jpg" /> skateboardshoes.eu <br /><br />		
		<?
		$res = mysql_query('SELECT * FROM index_spot WHERE lang="en" ORDER BY added DESC, aktiv DESC LIMIT 10');	// EN
		
		while($row=mysql_fetch_array($res))	{
			
			$opacity=0.3;
			$check="";
			if($row['aktiv']==1) { $check="checked"; $opacity=1; }
			
			echo '<form method="POST" action="" name="spot_active" />';
			echo '<input type="hidden" name="spot_id" value='.$row['id'].' />';
			echo '<img src="http://coreshop.hu'.$row['img'].'" alt="'.$row['alt'].'" style="width:290px;opacity:'.$opacity.'" /><br /><br />';
			echo '<input type="checkbox" value=1 name="aktiv" '.$check.' onclick="this.form.submit();" /> '.strtoupper($row['lang']).' &middot; '.$row['alt'].' &middot; | '.$row['added'];
			echo '</form>';
		
			echo '<hr>';
		}
		?>
		</td>
	</tr>
	
	</table>