<?
// TOMB LOGIKA: fokategoria ID( kat_url, alapertelmezett alkategoria, nev, szulo kategoria )
$fokat = array(92 => array('ferfi_ruhazat', 105, 'ferfi_ruhazat', 90),		
		   107 => array('noi_ruhazat', 116, 'noi_ruhazat', 91),
		   94 => array('cipo', 94, 'cipo', 89),
		   121 => array('kiegeszito', 121, 'kiegeszito', 98),
		   114 => array('gordeszka', 114, 'gordeszka', 112)
		   );
		   
foreach($fokat as $fk)	{
	$i++;	
	
	if($fk[3]==$_SESSION['kategoria'])
		$style='style="border-bottom:4px solid #2a87e4;margin:-4px;"';
	else
		$style='';
	
	echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($lang->$fk[0]).'/'.$fk[1].'" class="maincat" title="'.$selected.'" '.$style.'>'.$lang->$fk[2].'</a> ';
	}