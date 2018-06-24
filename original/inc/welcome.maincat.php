<?

$fokat = array(92 => array('ferfi_ruhazat', 92, 'ferfi_ruhazat', 90),		
		   107 => array('noi_ruhazat', 116, 'noi_ruhazat', 91),
		   94 => array('cipo', 94, 'cipo', 89),
		   149 => array('kiegeszito', 149, 'kiegeszito', 98),
		   114 => array('gordeszka', 114, 'gordeszka', 112),
		   159 => array('akcios-ferfi-cipo', 160, 'outlet', 160)
		   );


// mobile main menu
//echo '<div class="mobile-menu" id="mobile-menu">';

// fokategoriak
foreach($fokat as $fk)	{	

	if($_SESSION['kategoria']==$fk[1]) $maincat='mobile-maincat-selected'; else $maincat='mobile-maincat';
	
	echo '<div class="'.$maincat.'">
	<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($lang->$fk[0]).'/'.$fk[1].'">
	'.$lang->$fk[2].'</a>
	</div>';	
	}
	
//echo '</div>';