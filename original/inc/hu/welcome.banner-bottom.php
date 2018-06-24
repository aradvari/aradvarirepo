<?

$folder = '/banner/2014/index/';


/*echo '<div style="width:1024px; border:0px solid black; ">';

	for($i=11; $i<=12; $i++)	{
			
		$row = mysql_fetch_array(mysql_query('SELECT * FROM index_ajanlat WHERE pozicio='.$i));
		
		//echo '<div style="float:left; margin:10px 10px 0 10px; border:1px dotted black;">
		
		if($i==11)		// leftbanner
			$margin = "margin:10px 10px -10px 0; border-right:1px dotted #333;";
		else
			$margin = "margin:10px 0 -10px 5px";
		
			echo '<a href="'.$row['url'].'" title="'.$row['alt'].' &rsaquo;">
				<img src="'.$folder.$row['img'].'" style="width:490px; '.$margin.'; padding:0 5px" alt="'.$row['alt'].' - Coreshop.hu" />
			</a>';
		
			//</div>';
		
		}

echo '</div>'; */



?>

<table align="center" style="margin:10px 0 -10px 0;" border=0>
	<tr>
	
		<?
		
		for($i=11; $i<=12; $i++)	{
			
		$row = mysql_fetch_array(mysql_query('SELECT * FROM index_ajanlat WHERE pozicio='.$i));
		
		if($i==11) $border='border-right:1px solid #333;'; else $border='border-left:1px solid #000;';
		
		echo '<td style="padding:0; margin:0; '.$border.'">
		
			<a href="'.$row['url'].'" title="'.$row['alt'].' &rsaquo;">
				<img src="'.$folder.$row['img'].'" style="width:510px;" alt="'.$row['alt'].' - Coreshop.hu" />
			</a>
		
			</td>';
		}
	
		?>
		
	</tr>
</table>

