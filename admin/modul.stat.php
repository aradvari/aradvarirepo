STAT
</br>
</br>


<?php
	$poll = false;
	

	$pollQuery = mysql_query("SELECT * FROM `szavazas_szavazat`INNER JOIN `szavazas_valasz` ON (szavazas_valasz.valasz_id=szavazas_szavazat.valasz_id) WHERE szavazas_szavazat.kerdes_id=12 ORDER BY szavazas_szavazat.szavazat DESC");
	
?>

<?php while ($row = mysql_fetch_assoc($pollQuery)): ?>
<?=$row['valasz']?>: 
<?=$row['szavazat']?></br>
<? $i=$i+$row['szavazat']; ?>
	<?php endwhile; ?>
	
</br>
</br>
<?='Összesen: '.$i;?>