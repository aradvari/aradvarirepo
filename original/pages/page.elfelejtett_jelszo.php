<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/passwordmeter.js" type="text/javascript"></script>

<div class="right-container">

<div class="content-right-headline"><?=$lang->Jelszo_modositasa?></div>



	<div class="blue-container">
	
	<center>
	
	<?=$lang->Jelszo_modositas_bevezeto?>
	
	<br />
	<br />
	
	<form action="" method="POST" autocomplete="off">
	
	<table>
	<tr>
		<td align="right"><?=$lang->Email_cim?></td>
		<td align="left"><input type="text" value="<?=$lang->email?>" id="emailpassresend" onClick="input_clear('emailpassresend');" name="email"></td>
	</tr>
	
	<tr><td colspan="2"><br /></td></tr>
	
	<tr>
		<td align="right"><?=$lang->Uj_jelszo?></td>
		<td align="left"><input type="password" name="jelszo1" size="30" onkeyup="$('erosseg').innerHTML='&nbsp;' + testPassword(this.value)"> * <span id="erosseg" ></span></td>
	</tr>	
	<tr>
		<td align="right"><?=$lang->Uj_jelszo_megerositese?></td>
		<td align="left"><input type="password" name="jelszo2" size="30" onkeyup="$('erosseg').innerHTML='&nbsp;' + testPassword(this.value)"> * <span id="erosseg"></span></td>
	</tr>
	
	<tr><td colspan="2"><br /></td></tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" value="<?=$lang->Jelszo_ujrakuldes?>" class="button-blue" name="elfelejtett_jelszo"></td>
	</tr>
	</table>
	
	</form>
	
	</center>

	</div>

</div>
</div>

<br />
<? include 'inc/welcome.ajanlo.php'; ?>