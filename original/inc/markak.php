<?
	
	$query = mysql_query('
			SELECT * FROM vonalkodok t 
			JOIN termekek m 
			ON t.id_termek = m.id
			JOIN markak u 
			ON u.id = m.markaid 
			WHERE t.keszlet_1>0
			GROUP BY m.markaid
			/*ORDER BY RAND()*/
			LIMIT 16');
			
	$brands = array (
					41=>'Vans',
					40=>'DC',
					42=>'Etnies',					
					43=>'éS',
					44=>'Emerica',
					70=>'Almost',
					71=>'Enjoi',
					72=>'Darkstar',
					51=>'Cliché',
					106=>'Superior',
					73=>'Speed Demons',					
					84=>'Tensor',
					68=>'Fallen',
					58=>'Volcom',					
					108=>'Skullcandy',					
					/*114=>'Oakley',*/
					109=>'WTP'
					);
					
//echo '<div class="headline">Főbb márkáink</div>';
	
echo '<div class="brands">';
	
		foreach	($brands as $markaid => $markanev)	{
			echo '
				<div class="brand"><a href="/termekek/0/0/'.$markanev.'/'.$markaid.'"><img src="/images/markak-top/'.$markaid.'.png" alt="'.$markanev.'" /></a></div>';
				
			//echo '<a href="/termekek/0/0/'.$markanev.'/'.$markaid.'">'.$markanev.'</a> &middot; ';
			
			//echo '<div class="brand">'.$markanev.'</div>';
		}

echo '</div>';