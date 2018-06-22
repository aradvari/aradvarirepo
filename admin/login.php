<?

$headline = 'Coreshop - ADM';

$mainpage ='index.php';

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">

<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes" />
<meta name="google" content="notranslate">

<title><?=$headline;?></title>

<link href="style/adm_style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function setFocus()
{
     document.getElementById("username").focus();
}
</script>

</head>

<body onload="setFocus()">

<center>
	
	<div class="login">
		
		<form name="loginform" method="post" action="">
		
		<table style="min-width:0;width:100%;">
		
		<tr><td colspan=2><h3><?=$headline;?></h3>Belépés a rendszerbe</td></tr>
		
		<tr><td colspan=2><h6>Felhasználónév:</h6><input name="username" type="text" class="form" id="username" style="width:100%" /></td></tr>
		
		<tr><td colspan=2><h6>Jelszó:</h6><input name="password" type="password" class="form" id="password" style="width:100%" /></td></tr>
		
		<tr><td colspan=2 align="center"><input name="belepesarendszerbe" type="submit" class="formColor" id="belepesarendszerbe" value="Belépés" style="width:100%" /></td></tr>
		
		</table>
		
		</form>
		
	</div>
	
</center>

</body>

</html>