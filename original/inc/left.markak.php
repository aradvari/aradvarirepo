<?
	
	$query=mysql_query('
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
					69=>'Blind',
					84=>'Tensor',
					58=>'Volcom',
					101=>'Dragon',					
					108=>'Skullcandy',
					68=>'Fallen',
					103=>'Nike SB',
					102=>'Nike 6.0'
					);
	
?>

<table border="0" align="center" class="leftpanel">

  <tr><th>Főbb márkáink</th></tr>
  
  <tr>
    <td align="center">
      <? 
		//while($row=mysql_fetch_array($query))	{
		foreach	($brands as $markaid => $markanev)	{
			echo '
				<a href="/termekek/0/0/'.$markanev.'/'.$markaid.'"><img src="http://coreshop.hu/pictures/markak40x40/'.$markaid.'.png" style="height:40px; margin:3px;" alt="'.$markanev.'" title="'.$markanev.'" /></a>';
		}
	  ?>
    </td>
  </tr>
  
</table>