<? 
$query=mysql_query("SELECT * FROM index_infobox WHERE lang='HU'");

$infobox_icons=array('free-shipping-icon.png', 'cxs-icon.png', 'phone-icon.png' );

$j=0;
while ($adatok = mysql_fetch_array($query))	{	
	
	
	
	if ($j==1)
		$style='style="margin:0 5%;"';	// kozepso div elvalasztva
	else
		$style='';
		
	echo '<div class="new-welcome-infobox" '.$style.'>';
	echo '<a href="'.$adatok['url'].'"><img src="/images/'.$infobox_icons[$j].'?17" alt="'.$adatok['alt'].'" />'.$adatok['szoveg'].'</a>';
	echo '</div>';	
	
	$j++;
	
	}