<?

echo '<a name="t"></a>';


echo '<div class="welcome-mainmenu">';

// fokategoriak
$i=0;
foreach($fokat as $fk)	{	

	if($_SESSION['kategoria']==$fk[1]) $maincat='mobile-maincat-selected'; else $maincat='mobile-maincat';
	
	
	/*echo '<div class="'.$maincat.'" id="menu-maincat-'.$i.'">
	<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($lang->$fk[0]).'/'.$fk[1].'">
	'.$lang->$fk[2].'
	</a>
	</div>';	*/
	
	echo '<div class="'.$maincat.'" id="menu-maincat-'.$i.'"><a href="#t">'.$lang->$fk[2].'</a></div>';
	
	
	$is_fokat=mysql_fetch_array(mysql_query('SELECT id_kategoriak, szulo FROM kategoriak WHERE id_kategoriak='.$fk[1]));
	
	echo '<div class="mobile-subcat" id="menu-subcat-'.$i.'">';
						
	$subcat=mysql_query('SELECT k.id_kategoriak, k.nyelvi_kulcs, k.megnevezes, k.szulo
						FROM kategoriak k
						LEFT JOIN termek_kategoria_kapcs tkk ON tkk.id_kategoriak = k.id_kategoriak
						LEFT JOIN termekek t ON t.id = tkk.id_termekek
						LEFT JOIN vonalkodok v ON v.id_termek = t.id
						WHERE k.sztorno IS NULL
						AND t.aktiv =1
						AND v.keszlet_1 >0
						AND t.torolve IS NULL
						AND k.szulo ='.$is_fokat['szulo'].' 
						GROUP BY k.id_kategoriak
						ORDER BY k.sorrend');	
	
	
	while ($row=mysql_fetch_array($subcat))	{	
	
		//if($_SESSION['kategoria']==$row['id_kategoriak']) $selected='class="selected"'; else $selected='';
		
		
		echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'">'.$lang->$row['nyelvi_kulcs'].'</a> ' ;
	}
	
	echo '</div>';
	
	$i++;
	}
		
echo '</div>';