<div class="sitemenu-logo">
	<a href="/"><img src="/images/coreshop-logo.png" alt="Coreshop - Online gördeszkás áruház" style="width:264px; height:48px;" /></a>
</div>
	

<? $menuitems=array( "Vásárlás" => "vasarlas",
					"Szállítás" => "szallitas",
					"Szavatossag" => "szavatossag",
					"Termékcsere" => "termekcsere",
					"Kapcsolat" => "kapcsolat",
					"<img src='/images/coreclub-logo.png' style='vertical-align:middle;' />" => "coreclub");
	
	foreach ($menuitems as $menuname => $menuurl)	{
		echo '<a href="/'.$menuurl.'">'.$menuname.'</a>';
	}