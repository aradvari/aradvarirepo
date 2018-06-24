<?
//echo 'termek kiegeszito infok<br />';
//echo '<div class="termek-kieg-infobox">';
$info = array (
	'1' => 'Ingyenes szállítás 10.000 ft felett',
	/*'2' => 'Ajándék "Coreshop Cinch Bag" minden megrendeléshez',*/
	'3' => 'Személyes átvétel irodánkban',
	'4' => 'Telefonos rendelés: 06-70-676-2673'
);

// varhato kiszallitas
echo '<div class="termek-kieg-infobox">';
echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_aszf.'#3">
		A kiszállítás az alábbi napon várható:<br />
		<b style="color:#ff9900;">'.$func->dateToHU($func->GLSDeliveryDate('HU')).'</b></a>';
echo '</div>';

$size=sizeof($info);
$width=round(100/$size);

foreach($info as $url=>$text)	{
	echo '<div class="termek-kieg-infobox">';
	echo '<a href="'.$url.'">'.$text.'</a>';
	echo '</div>';
	}

//echo '</div>';