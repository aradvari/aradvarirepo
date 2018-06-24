<?
echo '<table width="100%"><tr>';

$fokat = array('Férfi ruházat' => '/termekek/ferfi_ruhazat/92',
				'Női ruházat' => '/termekek/noi_ruhazat/116',
				'Férfi cipő' => '/termekek/ferfi_cipo/94',
				'Női cipő' => '/termekek/noi_cipo/95',
				'Kiegészítő' => '/termekek/kiegeszito/110',
				'Gördeszka' => '/termekek/gordeszka/114',
				'BMX' => '/termekek/bmx/144' );

foreach($fokat as $fk => $fk_url)
	echo '<td><a href="'.$fk_url.'">'.$fk.'</a></td>';

echo '</tr></table>';