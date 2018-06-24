
<?php
	$poll = false;
	if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['kerdes_id']) && isset($_GET['valasz_id'])){
		$sql = "UPDATE szavazas_szavazat SET szavazat = szavazat + 1 WHERE kerdes_id = '".$_GET['kerdes_id']."' AND valasz_id = '".$_GET['valasz_id']."'";
		mysql_query($sql);
		$poll = true;
		header( "refresh:5;url=/" ); 
	}

	$pollQuery = mysql_query("SELECT * FROM szavazas_valasz WHERE kerdes_id = '12'");
	
?>




<?php if(!$poll): ?>
<h1>Hogyan találtál ránk?</h1> 

Szavazatoddal segíted munkánkat,<br />kérjük válassz az alábbi lehetőségek közül:

<br />
<br />

<style>
	.radioSelect {
	  margin: 0 0 0.75em 0;
	}

	.radioSelect div{
		display: inline-block;
		margin: 5px 10px;
		width: 100%;
	}

	input[type="radio"] {
	  display: none;
	  
	}
	
	input[type="radio"] + label {
	  color: #666;
	  font-family: Arial, sans-serif;
	  font-size: 14px;
	  cursor: pointer;
	}

	input[type="radio"] + label span {
	  display: inline-block;
	  width: 19px;
	  height: 19px;
	  margin: -1px 4px 0 0;
	  vertical-align: middle;
	  cursor: pointer;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	}

	input[type="radio"] + label span {
	  background-color: #444;
	}

	input[type="radio"]:checked + label span {
	  background-color: #78CDD1;
	}

	input[type="radio"] + label span,
	input[type="radio"]:checked + label span {
	  -webkit-transition: background-color 0.4s linear;
	  -o-transition: background-color 0.4s linear;
	  -moz-transition: background-color 0.4s linear;
	  transition: background-color 0.4s linear;
	}


	input[type="radio"]:checked+label{
		background: transparent !important;
	}

		@media screen and (max-width: 720px) {
	input[type="radio"] + label {
	  color: #666;
	  font-family: Arial, sans-serif;
	  font-size: 14px !important;
	  text-align: center !important;
	  cursor: pointer;
	  line-height: 20px;
	  } 
	  
	input[type="radio"] + label span {
	  display: inline-block;
	  width: 10px !important;
	  height: 10px !important;
	  margin: -1px 4px 0 0;
	  vertical-align: middle;
	  cursor: pointer;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	}
	
	.radioSelect div{
		display: inline-block;
		margin: 0px 10px;
		width: 100%;
	}
	} 
	
</style>



	<form action="" id="poll">


	<input type="hidden" name="kerdes_id" value="12"/>
	<div class="radioSelect">
	<?php while ($row = mysql_fetch_assoc($pollQuery)): ?>
		<div>
			<input id="<?=$row['valasz_id']?>" type="radio" name="valasz_id" value="<?=$row['valasz_id']?>"/>
			<label for="<?=$row['valasz_id']?>"><span></span><?=$row['valasz']?></label> 
			
		</div>
	<?php endwhile; ?>
	</div>
	  <br/><br/><input class="arrow" type="submit" value="Szavazok" style="width:100%;" />
	</form>
<?php else: ?>
<h2>Köszönjük!</h2>
<?php endif; ?>

