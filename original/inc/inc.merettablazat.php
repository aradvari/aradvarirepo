<?

//echo '<link rel="stylesheet" href="/css/coreshop2013.css" type="text/css" media="screen"/>';

$tablanev = array ( 
					'94_40' => 'DC férfi cipő mérettáblázat',
					'94_41' => 'Vans férfi cipő mérettáblázat',
					'94_42' => 'etnies férfi cipő mérettáblázat',
					'94_43' => 'éS férfi cipő mérettáblázat',
					'94_44' => 'Emerica férfi cipő mérettáblázat',
					'94_68' => 'Fallen férfi cipő mérettáblázat',					
					'94_58' => 'Volcom férfi cipő mérettáblázat',
					
					'95_40' => 'DC női cipő mérettáblázat',
					'95_41' => 'Vans női cipő mérettáblázat',
					'95_42' => 'etnies női cipő mérettáblázat',
					);




$merettablazat = array(

//ffi DC
'94_40' => array (
					'US'=>array(6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13),
					'EUR'=>array(38, 38.5, 39, 40, 40.5, 41, 42, 42.5, 43, 44, 44.5, 45, 46, 47),
					'cm *'=>array(24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30, 31)
					),

//ffi vans
'94_41' => array (
					'US'=>array(4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13, 14, 15, 16),
					'EUR'=>array(36, 36.5, 37, 38, 38.5, 39, 40, 40.5, 41, 42, 42.5, 43, 44, 44.5, 45, 46, 47, 48, 49, 50),
					'cm *'=>array(22.5, 23, 23.5, 24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30, 31, 32, 33, 34)
					),
					
//ffi etnies
'94_42' => array (
					'US'=>array(6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13),
					'EUR'=>array(38, 38.5, 39, 40, 41, 41.5, 42, 42.5, 43, 44, 45, 45.5, 46, 47),
					'cm *'=>array(24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30, 31)
					),
					
//ffi éS
'94_43' => array (
					'US'=>array(6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13),
					'EUR'=>array(38, 38.5, 39, 40, 41, 41.5, 42, 42.5, 43, 44, 45, 45.5, 46, 47),
					'cm *'=>array(24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30, 31)
					),
					
//ffi emerica
'94_44' => array (
					'US'=>array(6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 13),
					'EUR'=>array(38, 38.5, 39, 40, 41, 41.5, 42, 42.5, 43, 44, 45, 45.5, 46, 47),
					'cm *'=>array(24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30, 31)
					),
					
//ffi fallen
'94_68' => array (
					'US'=>array(8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12),
					'EUR'=>array(41, 42, 42.5, 43, 44, 44.5, 45, 45.5),
					'cm *'=>array(26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30)
					),

//ffi volcom
'94_58' => array (
					'US'=>array(8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12),
					'EUR'=>array(41, 42, 42.5, 43, 44, 44.5, 45, 46),
					'cm *'=>array(26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30)
					),

//noi DC
'95_40' => array (
					'US'=>array(5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5),
					'EUR'=>array(36, 36.5, 37, 37.5, 38, 38.5, 39, 40, 40.5, 41),
					'cm *'=>array(22, 22.5, 23, 23.5, 24, 24.5, 25, 25.5, 26, 26.5)
					),

//noi vans
'95_41' => array (
					'US'=>array(6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10),
					'EUR'=>array(36, 36.5, 37, 38, 38.5, 39, 40, 40.5, 41),
					'cm *'=>array(22.5, 23, 23.5, 24, 24.5, 25, 25.5, 26, 26.5)
					),
					
//noi etnies
'95_42' => array (
					'US'=>array(6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5),
					'EUR'=>array(36, 36.5, 37, 37.5, 38, 38.5, 39, 40),
					'cm *'=>array(22, 22.5, 23, 23.5, 24, 24.5, 25, 25.5)
					),
);



foreach ($tablanev as $kod => $megnevezes)	{
	echo '<div id="'.$kod.'" style="display:none;">';
	

	echo '<table border=0 class="merettabla">';

	echo '<tr><th></th><th colspan=20 style="text-align:left">'.$megnevezes.'</th></tr>';
	
	foreach ($merettablazat[$kod] as $szamozas=>$meretek)	{

		echo '<tr><td style="border:none;text-align:center;">'.$szamozas.'</td>';
		
		foreach($meretek as $meret)
			echo '<td>'.$meret.'</td>';
		}
		
		echo '</tr>';
		
	
	echo '<tr><td colspan=24 style="background:none;margin:10px 0; text-align:right; border:none;">* belső talphosszúság centiméterben</td></tr>';
	
	echo '</table>';
		
	echo '</div>';
}