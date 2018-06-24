<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/passwordmeter.js" type="text/javascript"></script>

<div class="textbox">

<div class="login_once">

<p><?=$lang->Leiratkozas?></p>

	
	<?=$lang->Leiratkozas_bevezeto?>
	
	<br />
	<br />
	
	<form action="" method="POST" autocomplete="off">
	
	<table>
	<tr>
		<td align="right"><?=$lang->Email_cim?></td>
		<td align="left"><input type="text" value="<?=$_GET['m']?>" id="email" name="email"></td>
	</tr>
	
	
	<tr><td colspan="2"><br /></td></tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" value="<?=$lang->Leiratkozas?>" class="button-blue" name="leiratkozas"></td>
	</tr>
	</table>
	
	</form>
	
</div>
</div>

<br />
<? include 'inc/welcome.ajanlo.php'; ?>