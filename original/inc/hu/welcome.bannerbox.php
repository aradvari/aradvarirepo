<?

//$folder='banner_box/2015/';

$spacer='<span class=\'spacer\'></span></br><span class=\'spacer\'></span>';



// item: image, caption, url, alt, szoveg
$boxes=array(
		
		$item0=array(	'banner_box/2017/20171025_vans_x_peanuts.jpg', 
						'Vans x Peanuts', 
						'/hu/termekek?keresendo=peanuts',
						'Vans x Peanuts', 
						'Charlie Brown és barátai ismét megszállták a legnépszerűbb Vans cipőket'),
						
		/*	$item0=array(	'banner_box/2017/20171108_vansjoy.jpg', 
						'Joy Napok!', 
						'/hu/termekek/ferfi-cipo/94',
						'Joy Napok!', 
						'20% kedvezmény minden Vans termékre!<br />Kuponkód: vansjoynapok'),*/
						
		$item1=array(	'banner_box/2017/20171025_vans_noi_polok.jpg',
						'VANS GIRLS',
						'/hu/termekek/polo/116',
						'Vans női ruházat, pólók, pulóverek',
						'Vans ruházat azoknak a lányoknak, akik a dél-kaliforniai stílusból merítenének inspirációt.'),
						
		$item2=array(	'banner_box/2017/20171025_vans_old_skool.jpg',
						'VANS OLD SKOOL',
						'/hu/vans-old-skool',
						'Vans Old Skool',
						'A Vans kultikus Old Skool modelljéből több mint harminc verziót találsz kínálatunkban.'),
		
);


echo '<div class="new-welcome-banner-box-container">';

$i=0;
foreach ($boxes as $box)	{
	$i++;
	
		
	if ($i==2)
		$style='style="margin:0 5%;"';	// kozepso div elvalasztva
	else
		$style='';
	
	echo '<div class="new-welcome-banner-box" onclick="location.href=\''.$box[2].'\' " '.$style.' >
				
				<div class="new-welcome-banner-box-image">
				<img src="/'.$box[0].'" alt="'.$box[3].'" title="'.$box[3].'" />';				
				
				echo '</div>';
				
				
				
				echo '<div class="new-welcome-banner-box-szoveg">';
					if(!empty($box[1])) echo '<h4>'.$box[1].'</h4>';
					echo $box[4].'					
					<a href="'.$box[2].'"><p>megnézem</p></a>
					</div>';
				
	echo '</div>';
}

echo '</div>';