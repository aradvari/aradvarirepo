<?
$date=date('Y-m-d H:i:s');

if(isset($_GET['del']))
	$query="DELETE FROM app_news WHERE id=".$_GET['id'];
	
if(!empty($_POST))	{
	
	if(isset($_POST['id']))
		// update
		$query='UPDATE app_news SET title="'.$_POST['title'].'", message="'.$_POST['message'].'",url="'.$_POST['url'].'" WHERE id='.$_POST['id'];
	else
		{ if( (!empty($_POST['title'])) && (!empty($_POST['message'])) && (!empty($_POST['url'])) )
		// insert
		$query='INSERT INTO app_news (date,title,message,url)
					VALUES ("'.$date.'", "'.$_POST['title'].'", "'.$_POST['message'].'", "'.$_POST['url'].'")';
		}
}

// query

if(mysql_query($query));


echo '<table cellspacing="10" cellpadding="10">';
	
	echo '<tr><td colspan="5" class="darkCell">Coreshop APP hírek</td></tr>';
	
echo '<tr>
		<form action="" method="POST" autocomplete="off" />
		<td class="lightCell" colspan=5>		
		<span style="float:right;">'.$date.'</span><br />
		<input type="text" name="title" placeholder="TITLE" autofocus style="width:100%;" /><br />
		<textarea name="message" placeholder="MESSAGE (128 char)" maxlength="128" style="width:100%;height:60px;"></textarea><br />
		<input type="text" name="url" placeholder="URL" style="width:100%;" />
		<input type="submit" value="+ ÚJ HÍR HOZZÁADÁSA" style="width:100%;" />
		</form>
	</tr>';
	
echo '<tr><td colspan=5 style="height:60px;border-bottom:none;">SZERKESZTÉS</td></tr>';

// 10 LISTAZOTT HIR

$res=mysql_query('SELECT * FROM app_news ORDER BY date DESC LIMIT 10');

while($row=mysql_fetch_array($res))	{
	if($cell=='darkCell') $cell='lightCell'; else $cell='darkCell';
	echo '<form action="" method="POST" name="edit" />';
	echo '<tr>';
	echo '<td class="'.$cell.'" style="border-bottom:none;border-top:2px solid blue;" colspan=5><span style="float:right;color:blue;font-weight:normal;">'.$row['id'].' / '.$row['date'].' | <a href="?lap='.$_GET['lap'].'&id='.$row['id'].'&del=1">Törlés [X]</a></span><input type="hidden" name="id" value="'.$row['id'].'" />
		<input type="text" name="title" value="'.$row['title'].'" onChange="this.form.submit();" style="border:none;padding:none;width:100%;background:none;" /><br />
		
		<textarea name="message" onChange="this.form.submit();" style="border:none;padding:none;width:100%;background:none;" />'.$row['message'].'</textarea><br />
		
		<input type="text" name="url" value="'.$row['url'].'" onChange="this.form.submit();" style="border:none;padding:none;width:100%;background:none;" /></td>';
	
	echo '</tr>';
	echo '</form>';
}

echo '</table>';