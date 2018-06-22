<?

//$table="termekek_20150507";
$table="termekek";

if(isset($_GET['kategoria'])) $_SESSION['termekek']['kategoria']=$_GET['kategoria'];

if ( isset($_POST['id']) && isset($_POST['position']) )	{
	
	$query0=('UPDATE '.$table.' SET opcio_sorrend='.$_POST['position_aktualis'].' WHERE kategoria='.$_SESSION['termekek']['kategoria'].' AND opcio_sorrend='.$_POST['position']);
	$query1=('UPDATE '.$table.' SET opcio_sorrend='.$_POST['position'].' WHERE id='.$_POST['id'] );
	
	//mysql_query($query0);
	//mysql_query($query1);
	
	echo $query0.'<br />';
	echo $query1;
}

	

echo '<form methon="GET" action="" />

		<input type="hidden" name="lap" value="termekek_top" />
		
		<table width="400" border="0" cellspacing="1" cellpadding="6">
		
		<tr><td class="lightcell" style="font-weight:bold; color:red;">FEJL. ALATT</td></tr>
		
		<tr><td class="darkcell">	
		Válassz kategóriát:
		<select name="kategoria" onChange="this.form.submit()" >
            <option value="">Mindegyik</option>'; 
			
 $q = mysql_query("SELECT * FROM kategoriak WHERE szulo=0 AND sztorno IS NULL");
              
              while ($adatok=mysql_fetch_array($q)){
                  
                  $alquery = mysql_query("SELECT * FROM kategoriak WHERE szulo=".$adatok[0]." AND sztorno IS NULL");
                
                  while ($aladatok=mysql_fetch_array($alquery)){
                  
                      echo('<option value="'.$aladatok[0].'" '.(ISSET($_SESSION['termekek']['kategoria'])?($_SESSION['termekek']['kategoria']==$aladatok[0]?'SELECTED':''):'').'>'.$adatok[1].' &raquo; '.$aladatok[1].'</option>');
                 
                  }
                  
              }
			  
echo '</select>
		</td>
		</tr>';
		
echo '</table>
		</form>'; 
		
		
if (isset($_SESSION['termekek']['kategoria']))	{
// LIST

//$sql = "SELECT * FROM termekek WHERE opcio like '%TOP' and kategoria=".$_SESSION['termekek']['kategoria'];

$sql="SELECT
		m.markanev,
		t.termeknev,
		t.klub_ar,
		t.kisker_ar,
		t.akcios_kisker_ar,
		t.id,
		t.opcio,
		t.szin,
		t.fokep,
		t.opcio_sorrend
		
		FROM ".$table." t

		LEFT JOIN markak m ON (m.id = t.markaid)
		LEFT JOIN vonalkodok v ON t.id=v.id_termek
		
		WHERE opcio like '%TOP' and kategoria=".$_SESSION['termekek']['kategoria']." AND
		v.keszlet_1>0 AND
		t.aktiv=1
		
		GROUP BY v.id_termek
		
		ORDER BY opcio_sorrend ASC";
 
//$query = mysql_query($sql);
$numoftops = mysql_num_rows($query);


echo '<table cellspacing="10" cellpadding="10" width=600 border=0>';

//echo '<tr><td colspan="5" class="darkCell">TOP</td></tr>';

/*$query = mysql_query($sql);
while ($adatok = mysql_fetch_array($query)){
	$os[].=$adatok['opcio_sorrend'];
}*/

$query = mysql_query($sql);
while ($adatok = mysql_fetch_array($query)){
  
  $i++;
  if ($i==1) echo '<tr>';


	echo '<td valign="top" align="center" style="width:115px; position:relative; " class="lightCell">
	
	<form action="" method="POST" name="top'.$i.'" style="margin:0; padding:0;">';
		
		
				
		
		echo '<input type="hidden" name="id" value="'.$adatok['id'].'" />';
		echo '<input type="hidden" name="position_aktualis" value="'.$i.'" />';
		
		if($adatok['opcio_sorrend'])
			echo '<b>'.$adatok['opcio_sorrend'].'</b><br /><br />';
		else
			echo 'NULL<br /><br />';
	
	  
		$kep = $func->getHDir($adatok['id']).$adatok['fokep']."_small.jpg";          
		
		echo '<img src="http://coreshop.hu/'.$kep.'" width="160" align="center" title="'.$adatok['id'].'" alt="'.$adatok['id'].'" ><br />';                
	            
		
		echo '<div align="left" style="width:140px; position:relative;">';
		
		echo '<select name="position" id="position" onChange="document.top'.$i.'.submit();" style="position:absolute; top:10px; right:0px; width:46px;" >';
		
		echo '<option> </option>';
		
		for($j=1; $j<=$numoftops; $j++)	{
			
			if($j!=$i)
				echo '<option value="'.$j.'" >'.$j.'</option>';
		}
		
		/* $j=0;
		foreach ($os as $item)	{
			$j++;
			if($i!=$item)
				echo '<option value="'.$item.'" >'.$i.' -&rsaquo; '.$j.'</option>';
			
			if($item===99)
					echo '<option value="'.$i.'" >'.$i.'</option>';
		} */
		
		echo '</select><br />';
		
		
		echo '<b>'.$adatok['markanev'].'</b><br />
		'.substr($adatok['termeknev'],0,30).'<br />		
		'.substr($adatok['szin'],0,40).'';			
		
		
		
		echo '</div>
		
		</form>
		
		</td>';

if ($i%5==0) echo '</tr>';

//$os[].=$adatok['opcio_sorrend'];
}

echo '</table>';

 } 