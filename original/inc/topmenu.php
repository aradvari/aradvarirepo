<!-- <div class="cont"> -->

	<a href="/hu/termekek/polo/92"><div class="mainmenu_1">férfi ruha</a>
	<div class="mainmenu_content_1">	
		<div class="mainmenu_container">
			
			<div class="subitem" id="kep">
			<img src="/banner_header/2017/1201xmas/ferfi_ruha_menu.jpg?" alt="Férfi ruházat" title="Férfi ruházat" />
			</div>
			
			<div class="subitem" id="alkategoria">
			<p>férfi ruha kategóriák</p>
			
			<?			
			$subcat=$func->header_subcategories(90);			
							
			while ($row=mysql_fetch_array($subcat))	{	
				echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'"><h3 title="'.$lang->$row['nyelvi_kulcs'].'">'.$lang->$row['nyelvi_kulcs'].'</h3></a>';
			}
			?>
			</div>
			
			
			<div class="subitem" id="legnepszerubb">
			<p>legnépszerűbb termékek</p>
			
			<? $ferfi_ruha_keywords = array(
			"/hu/termekek/polo/92/vans/41"=>"Vans póló",
			"/hu/termekek/pulover/105/vans/41"=>"Vans pulóver",
			"/hu/termekek/baseball-sapka/96/vans/41"=>"Vans baseball sapka",
			"/hu/termekek/nadrag/103/vans/41"=>"Vans farmer",
			"/hu/termekek/polo/92/etnies/42"=>"Etnies póló",
			"/hu/termekek/baseball-sapka/96/etnies/42"=>"Etnies baseball sapka",
			"/hu/termekek/polo/92/emerica/44"=>"Emerica póló",
			"/hu/termekek/baseball-sapka/96/emerica/44"=>"Emerica baseball sapka",
			"/hu/termekek/baseball-sapka/96/altamont/125"=>"Altamont baseball sapka",
			"/hu/termekek/polo/92/volcom/58"=>"Volcom póló",			
			);
			
			foreach ($ferfi_ruha_keywords as $url=>$keyword)
				echo '<a href="'.$url.'"><h4 title="'.$keyword.'">'.$keyword.'</h4></a>';
			?>
			
			</div>
			
			
			<div class="subitem" id="leiras">
			<p>leírás</p>
			<?=nl2br('Gördeszkás ruházat az év minden napjára.

					Póló, pulóver, sapka, nadrág, kabát, rövidnadrág: Válogass kedvenc márkáidból!');?>
			</div>
			
		</div>	  
	</div>
	</div>
	
	<a href="/hu/termekek/polo/116"><div class="mainmenu_2">női ruha</a>
	<div class="mainmenu_content_2">	
	<div class="mainmenu_container">
			
			<div class="subitem" id="kep">
			<img src="/banner_header/2017/1201xmas/noi_ruha_menu.jpg?" alt="Női ruházat" title="Női ruházat" />
			</div>
			
			<div class="subitem" id="alkategoria">
			<p>női ruha kategóriák</p>
			
			<?			
			$subcat=$func->header_subcategories(91);			
							
			while ($row=mysql_fetch_array($subcat))	{	
				echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'"><h3 title="'.$lang->$row['nyelvi_kulcs'].'">'.$lang->$row['nyelvi_kulcs'].'</h3></a>';
			}
			?>
			</div>
			
			
			<div class="subitem" id="legnepszerubb">
			<p>legnépszerűbb termékek</p>
			
			<? $noi_ruha_keywords = array(
			"/hu/termekek?keresendo=omg"=>"OMG/WTF (Anti Valentine)",
			"/hu/termekek?keresendo=toy%20story"=>"Toy Story",
			"/hu/termekek/polo/116"=>"Vans női póló",
			"/hu/termekek/pulover/108"=>"Vans női pulóver",
			"/hu/termekek/baseball-sapka/97"=>"Vans Beach Girl Trucker",
			"/hu/termekek/taska/157"=>"Vans női táska",			
			);
			
			foreach ($noi_ruha_keywords as $url=>$keyword)
				echo '<a href="'.$url.'"><h4 title="'.$keyword.'">'.$keyword.'</h4></a>';
			?>
			
			
			
			</div>
			
			
			<div class="subitem" id="leiras">
			<p>leírás</p>
			Egyedi mintázatú női Vans  ruházat és kiegészítők azoknak a lányoknak, akik a dél-kaliforniai stílusból merítenének inspirációt.
			</div>
			
		</div>	
	</div>
	</div>
	
	<a href="/hu/termekek/ferfi-cipo/94"><div class="mainmenu_3">cipő</a>
	<div class="mainmenu_content_3">	
	<div class="mainmenu_container">
			
			<div class="subitem" id="kep">
			<img src="/banner_header/2017/1201xmas/cipo_menu.jpg?" alt="Gördeszkás cipők" title="Gördeszkás cipők" />
			</div>
			
			<div class="subitem" id="alkategoria">
			
			<?			
			$subcat=$func->header_subcategories(89);			
							
			while ($row=mysql_fetch_array($subcat))	{	
				echo '<div style="float:left;width:50%;">';
				/*echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'">
				<h3 title="'.$lang->$row['nyelvi_kulcs'].'" style="width:100%">'.$lang->$row['nyelvi_kulcs'].'</h3></a>';*/
				
				//echo '<p><a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'" style="color:#2a87e4;">'.$lang->$row['nyelvi_kulcs'].'</a></p>';
				echo '<p>'.$lang->$row['nyelvi_kulcs'].'</p>';
				
				$cipomarkak=mysql_query('SELECT m.id, m.markanev
										FROM termekek t
										LEFT JOIN vonalkodok v ON t.id = v.id_termek
										LEFT JOIN markak m ON t.markaid = m.id
										WHERE v.keszlet_1>0
										AND t.aktiv=1
										AND t.kategoria='.$row['id_kategoriak'].'
										AND m.id NOT IN (40,68) /* DC, Fallen nem jelenik meg */
										GROUP BY m.id');
										
				while ($marka=mysql_fetch_array($cipomarkak))
					echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'/'.strtolower($marka['markanev']).'/'.$marka['id'].'">
					<h3 title="'.$marka['markanev'].' '.strtolower($lang->$row['nyelvi_kulcs']).'">'.$marka[1].'</h3></a>';
					
					
					echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'" ><h3 title="Összes '.strtolower($lang->$row['nyelvi_kulcs']).'" style="width:100%;">Mutasd mind</h3></a>';
				
				echo '</div>';
			}
			?>
			</div>
			
			
			<div class="subitem" id="legnepszerubb">
			<p>legnépszerűbb férfi cipők</p>
			
			<?
			$ffi_cipo_top = array (
									'Ultrarange'=>'ultrarange',
									'Old Skool'=>'old%20skool',	
									'Kyle Walker' => 'kyle%20walker',
									'Iso 1.5'=>'iso',
									'Atwood'=>'atwood',
									'TNT SG'=>'tnt',
									'AV Rapidweld'=>'rapidweld',
									'Sk8-Hi'=>'sk8-hi',
									'Half Cab'=>'half%20cab',
									/*'Authentic'=>'authentic',*/								
									'Era'=>'era'
									);
									
			foreach($ffi_cipo_top as $nev=>$keres)
				echo '<a href="/hu/termekek/ferfi-cipo/94/vans/41?keresendo='.$keres.'"><h4 title="Vans '.$nev.'">'.$nev.'</h4></a>';
			?>			
			
			<a href="/hu/termekek/ferfi-cipo/94/vans/41"><h4 title="Akciós Vans cipők">Vans cipők</h4></a>
			
			<a href="/hu/termekek_akcios/ferfi-cipo/94/vans/41"><h4 title="Akciós Vans cipők">Akciós Vans cipők</h4></a>
			
			<a href="/hu/termekek/ferfi-cipo/94/etnies/42"><h4 title="Etnies cipők">Etnies cipők</h4></a>
			
			<a href="/hu/termekek/ferfi-cipo/94/emerica/44"><h4 title="Emerica cipők">Emerica cipők</h4></a>
			
			<a href="/hu/termekek/ferfi-cipo/94/es/43"><h4 title="éS Footwear cipők">éS cipők</h4></a>
			
			<a href="/hu/termekek/ferfi-cipo/94"><h4 title="Gördeszkás cipők">Gördeszkás cipők</h4></a>
			
			
			
			<p>legnépszerűbb női cipők</p>
			<?
			$noi_cipo_top = array (
									'Peanuts (Snoopy)'=>'peanuts',
									'Old Skool'=>'old%20skool',																		
									'Sk8-Hi'=>'sk8-hi',
									'Slip-On'=>'slip%20on',
									'Authentic'=>'authentic',
									'Era'=>'era',
									'Iso 1.5'=>'iso',
									);
									
			foreach($noi_cipo_top as $nev=>$keres)
				echo '<a href="https://coreshop.hu/hu/termekek/noi-cipo/95/vans/41?keresendo='.$keres.'"><h4 title="Vans '.$nev.'">'.$nev.'</h4></a>';
			?>
			
			</div>
			
			
			<div class="subitem" id="leiras">
			<p>leírás</p>
			<?=nl2br('Gördeszkás cipők az év minden napjára. Kínálatunkban egyaránt megtalálod a szezon legújabb férfi cipő modelljeit és a legkedveltebb klasszikusokat. Legyen szó a dél-kaliforniai Vans örökzöldekről, mint a Vans Old Skool, Vans Authentic, Vans Era vagy a SOLE Technology éS, Etnies, Emerica gördeszkás cipőiről.');?>
			</div>
			
		</div>	
	</div>
	</div>
	
	<a href="/hu/termekek/kotott-sapka/149"><div class="mainmenu_4">kiegészítő</a>
	<div class="mainmenu_content_4">	
	<div class="mainmenu_container">
			
			<div class="subitem" id="kep">
			<img src="/banner_header/2017/1201xmas/kiegeszito_menu.jpg?" alt="Kiegészítők" title="Kiegészítők" />
			</div>
			
			<div class="subitem" id="alkategoria">
			<p>Kiegészítő kategóriák</p>
			
			<?			
			$subcat=$func->header_subcategories(98);			
							
			while ($row=mysql_fetch_array($subcat))	{	
				echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'"><h3 title="'.$lang->$row['nyelvi_kulcs'].'">'.$lang->$row['nyelvi_kulcs'].'</h3></a>';
			}
			?>
			</div>
			
			
			<div class="subitem" id="legnepszerubb">
			<p>legnépszerűbb termékek</p>
			
			
			<? $kiegeszito_keywords = array(
			"/hu/termekek/napszemuveg/121/vans/41"=>"Vans napszemüveg",
			"/hu/termekek/napszemuveg/121/vans/41?keresendo=spicoli"=>"Spicoli 4 Shades",			
			"/hu/termekek/napszemuveg/121/vans/41?keresendo=squared"=>"Squared OFF",			
			"/hu/termekek/baseball-sapka/148/vans/41?keresendo=trucker"=>"Classic Patch Trucker",			
			"/hu/termekek/ovek/100/vans/41"=>"Vans öv",			
			"/hu/termekek/taska/110/vans/41"=>"Vans hátizsák",			
			"/hu/termekek/taska/110/vans/41?keresendo=benched"=>"Vans tornazsák",			
			"/hu/termekek/penztarca/99/vans/41"=>"Vans pénztárca",			
			"/hu/termekek/zokni/145/vans/41"=>"Vans zokni",			
			"/hu/termekek/napszemuveg/121/oakley/114"=>"Oakley napszemüveg",			
			"/hu/termekek/ora/156/neff/123"=>"Neff óra",			
			"/hu/termekek/ovek/100/etnies/42"=>"Etnies öv",			
			"/hu/termekek/ovek/100/emerica/44"=>"Emerica öv",			
			"/hu/termekek/penztarca/99/emerica/44"=>"Emerica pénztárca",			
			);
			
			foreach ($kiegeszito_keywords as $url=>$keyword)
				echo '<a href="'.$url.'"><h4 title="'.$keyword.'">'.$keyword.'</h4></a>';
			?>
			
			</div>
			
			
			<div class="subitem" id="leiras">
			<p>leírás</p>
			<?=nl2br('A gördeszkás stílus elengedhetetlen kiegészítői a Coreshop-on!

			A tredi külső mellett praktikusság jellemzi a népszerű Vans táskákat és kiegészítőket. Mindenki ruhatárában jól mutathat egy Vans napszemüveg, öv, sapka vagy pénztárca. Vans baseball sapkáinknál pedig egyaránt megtalálod a trucker és a fullcap modelleket.');?>
			</div>
			
		</div>
	</div>
	</div>
	
	<a href="/hu/termekek/gordeszka-lapok/114"><div class="mainmenu_5">gördeszka</a>
	<div class="mainmenu_content_5">	
	<div class="mainmenu_container">
			
			<div class="subitem" id="kep">
			<img src="/banner_header/2017/1201xmas/gordeszka_menu.jpg?" alt="Gördeszkák" title="Gördeszkák" />
			</div>
			
			<div class="subitem" id="alkategoria">
			<p>gördeszka kategóriák</p>
			
			<?			
			$subcat=$func->header_subcategories(112);			
							
			while ($row=mysql_fetch_array($subcat))	{	
				echo '<a href="/'.$_SESSION["langStr"].'/'.$lang->_termekek.'/'.$func->convertString($row['megnevezes']).'/'.$row['id_kategoriak'].'"><h3 title="'.$lang->$row['nyelvi_kulcs'].'">'.$lang->$row['nyelvi_kulcs'].'</h3></a>';
			}
			?>
			</div>
			
			
			<div class="subitem" id="legnepszerubb">
			<p>legnépszerűbb termékek</p>
			
			<? $gordeszka_keywords = array(
			
			"/hu/termekek/gordeszka-lapok/114/sk8mafia/55" => "Sk8mafia gördeszkalap",
			"/hu/termekek/gordeszka-lapok/114/jart/118" => "Jart gördeszkalap",
			
			"/hu/termekek/gordeszka-lapok/114/almost/70"=>"Almost gördeszkalap",
			"/hu/termekek/gordeszka-lapok/114/enjoi/71"=>"Enjoi gördeszkalap",			
			"/hu/termekek/gordeszka-lapok/114/darkstar/72"=>"Darkstar gördeszkalap",			

			"/hu/termekek/mini-cruiser/158/baby%20miller/128"=>"Baby Miller Mini Cruiser",			
			"/hu/termekek/kerek/120"=>"Gördeszka kerék",			
			"/hu/termekek/felfuggesztes/113"=>"Gördeszka felfüggesztés",			
			"/hu/termekek/csapagy/136"=>"Gördeszka csapágy",			
			"/hu/termekek/egyeb/119"=>"Csavarkészlet",			
						
			);
			
			foreach ($gordeszka_keywords as $url=>$keyword)
				echo '<a href="'.$url.'"><h4 title="'.$keyword.'">'.$keyword.'</h4></a>';
			?>
			
			</div>
			
			
			<div class="subitem" id="leiras">
			<p>leírás</p>
			<?=nl2br('Folyamatosan bővülő kínálatunkban egyaránt megtalálod a legmenőbb vagy épp a legrégebbi amerikai gördeszka cégek deszkáit, komplett gördeszkáit. Továbbá igyekszünk gördeszka kiegészítőkkel, kerekekkel, felfüggesztésekkel, csavarkészletekkel is színesíteni kínálatunk.');?>
			</div>
			
		</div>	  
	</div>
	</div>
	
	
	<div class="mainmenu_6"><a href="/hu/termekek/ferfi-cipo/160" style="color:red;">SALE %</a></div>
  
<!-- </div> -->