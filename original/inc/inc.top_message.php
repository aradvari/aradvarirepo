<style type="text/css">
<!--

.top_message { 
				position:absolute;
				top:0;
				left:0;
				width:80%;
				/*line-height:50px;*/
				background-color:rgba(0,0,0,0.8);
				color:#fff;
				font-weight:normal; 
				padding:10px 10%;
				text-align:center;
				display:block;
				z-index:1000;
			}

-->
</style>

<form method="POST" action="">
<input type="hidden" name="refresh" value=1>
<? $_SESSION['refresh']=1; ?>
<div class="top_message">Kedves Látogatónk!<br />Kérjük böngésződben FRISSÍTSD AZ OLDALT a CTRL + F5 billentyű kombinációval, egyes új funkciók hibátlan müködése érdekében. Köszönjük. <input type="submit" value="Bezárás" class="arrow_box_light" style="background-color:yellow; margin:0;" onclick="window.location.reload(true);" /></div>
</form>