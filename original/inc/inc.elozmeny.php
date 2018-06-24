<?

$prev_all = array ( $_COOKIE['prev1'], $_COOKIE['prev2'], $_COOKIE['prev3'], $_COOKIE['prev4'], $_COOKIE['prev5']);

if( !in_array($_SESSION['termek_id'], $prev_all) ) {

	//shift
	setcookie( 'prev2', $_COOKIE['prev1'], strtotime( '+30 days' ), '/' );
	setcookie( 'prev3', $_COOKIE['prev2'], strtotime( '+30 days' ), '/' );
	setcookie( 'prev4', $_COOKIE['prev3'], strtotime( '+30 days' ), '/' );
	setcookie( 'prev5', $_COOKIE['prev4'], strtotime( '+30 days' ), '/' );
	
	//latest item 1st
	//unset($_COOKIE['prev1']);
	setcookie( 'prev1', $_SESSION['termek_id'], strtotime( '+30 days' ), '/' );
}


	
	
if (!empty($_COOKIE['prev1']))	{ 

echo '<div class="content-right-headline" style="clear:both;">'.$lang->legutobb_megtekintett_termekek.'</div>

	<div class="ajanlo-container">
	
	<div class="thumbnail-container" style="max-width:1280px;">';
	
	// 5 thumbs
	for ($i=1; $i<=5; $i++)	{
		if (!empty($_COOKIE['prev'.$i])) echo $func->thumb($_COOKIE['prev'.$i]);
	}

echo '</div>';
}