<?

$k = mysql_query("SELECT megnevezes FROM kategoriak WHERE szulo=0 AND publikus=1");
    while ($kategoria = mysql_fetch_assoc($k)) $kategoriak[] = $lang->$kategoria["megnevezes"];
    $kategoriak = implode(" ", $kategoriak);
    $m = mysql_query("SELECT markanev FROM markak WHERE sztorno IS NULL");
    while ($marka = mysql_fetch_assoc($m)) $markak[] = $lang->$marka["megnevezes"];
    $markak = implode(" ", $markak);
	
	$title = $func->getMainParam('MAIN_PAGE');
    $keywords = $title.", ".$kategoriak.", ".$markak;
    
	
	
// Net-Position javaslat:
if($_SESSION["langStr"]==='hu')	{
	$title = $func->getMainParam('MAIN_PAGE').' - gördeszkás webshop: Vans,éS Footwear,Etnies,Emerica';

	$description = 'Gördeszkás webshop Vans, Etnies, éS Footwear, Emerica, Volcom termékek, azonnali szállítással. Coreshop a gördeszka, cipő, ruházat és kiegészítők webáruháza';
	
	//$keywords = 'coreshop, webshop, vans webshop, etnies webshop, emerica webshop, fallen webshop, volcom webshop, gördeszkás webshop';
}
else	{
	$title = $func->getMainParam('MAIN_PAGE').' - Skateboard webshop: Vans,éS Footwear,Etnies,Emerica,';

	$description = 'Skateboard webshop Vans, etnies, Emerica with whole stock for 24 hours shipping. Coreshop is a skateboard, shoes, goods accessories webshop';
	
	//$keywords = 'coreshop, webshop, vans webshop, etnies webshop, emerica webshop, fallen webshop, volcom webshop, skateboard webshop';
}
	
    switch ($page){
        
        case "termekek":
			
            $keywords = $termekek->getTitleRoot(" - ");
			
			/* if ($_REQUEST['keresendo'])	{
				if ($keywords)
					$keywords .= ' - '.ucfirst($_REQUEST['keresendo']);
				else
					$keywords = ucfirst($_REQUEST['keresendo']);
				} */
		
			// uj / akcios
			if(!empty($_SESSION['opcio']))	{
				if($_SESSION['opcio']=='akcios')	$opcio='Akciós';				
				if($_SESSION['opcio']=='uj')	$opcio='Újdonságok';
				
				$keywords=$opcio.' - '.$keywords;
				}
			
			$title = $keywords.' - '.$func->getMainParam('MAIN_PAGE');
			$title = str_replace("-   -", " - ", $title);
            $description = $keywords. ' - '.$func->getMainParam('MAIN_PAGE');
			$keywords = strtolower(str_replace('-', ',', $keywords)); 
			
			// VANS egyeni title, desc szovegek	/////////////////////////////////////////
			
			if($_SESSION['marka']==41)
				{
					// Vans marka oldal
					if ($_SESSION['kategoria'] == 0)	{
					$title = "Vans cipők - ".$func->getMainParam('MAIN_PAGE');

					$description  = "Vans cipők és ruházat a Coreshop.hu webshop-nál";
					
					$keywords= "vans, vans cipők, vans férfi cipők, vans webshop, vans old skool";
					}
								
							
					switch($_SESSION['kategoria']) {
						
						// cipo ferfi
						case 94:		
							//$title = 'Vans férfi cipők - ISO 1.5, Atwood, Old Skool, Era, Authentic, Slip-On, TNT SG, Half Cab, Sk8-Hi'; /* vans ferfi cipo */
							$title = 'Vans férfi cipők'; /* vans ferfi cipo */
							$description = 'Vans férfi cipők, nem csak gördeszkásoknak!';
							$keywords= 'vans shop, vans cipő, vans férfi cipő';
						break;
						
						// cipo noi
						case 95:
							$title = 'Vans női cipő - Coreshop';
							$description = 'Márkás női sport cipők a Vans webshopból a legújabb kollekcióból, nagy választékban! Minőség, trendi design, sport és kedvező árak - mi kell még?';
						break;
						
						// polo ferfi
						case 92:
							//$title = 'Póló a Vans webshopból - Coreshop';
							$title = 'Vans póló - Coreshop';
							$description = 'Ha gördeszkás vagy, azért. Ha más sportolsz, azért. Ha csak kedveled a sportos és minőségi pólókat, akkor azért. Vans pólók hatalmas választékban, jó áron!';
						break;
								
						// rovidnadrag ferfi
						case 134:
							$title = 'Vans rövidnadrágok - Coreshop';
							$description = 'Vagány és sportos megjelenés nem csak gördeszkásoknak: trendi rövidnadrágok a Vans webshopból óriási választékban, kedvező áron. Beruházol velünk?';
						break;
						
						// hosszuujju polo ferfi
						case 117:
							$title = 'Vans hosszúujjú pólók - Coreshop';
							$description = 'Trendi, márkás hosszúujjú pólók a Vans webshop kínálatából szuper áron, más márkák is - Emerica, Etnies, Fallen, Volcom';
						break;
						
						// pulover ferfi
						case 105:
							$title = 'Vans pulóver - Coreshop';
							$description = 'Trendi Vans pulóverek és egyéb ruházati termékek óriási választékban, továbbá egyéb sport márkák a Vans webshopból. Nézz be hozzánk!';
						break;
						
						// nadrag ferfi
						case 103:
							$title = 'Vans nadrág - Coreshop';
							$description = 'Sportos, divatos, márkás: Vans, Emerica, Enjoi, Etnies, Fallen nadrágok nagy választékban, kedvező árakon, online rendeléssel.';
						break;
						
						// ing ferfi
						case 93:
							$title = 'Vans ing - Coreshop';
							$description = 'A trendi Vans márka kínálatából természetesen nem hiányozhatnak az ingek sem az egyéb ruházati termékek mellett. Nézz be hozzánk!';
						break;
						
						// kabat ferfi
						case 106:
							$title = 'Vans kabát - Coreshop';
							$description = 'J-Lay Cuda Chocolate - egy vagány, sportos kabát a Vans webshop kínálatából, de több trendi ruházati terméket is taláslz nálunk kedvező áron, nézz be!';
						break;
						
						// rovidnadrag noi
						case 126:
							$title = 'Vans női rövidnadrág - Coreshop';
							$description = 'Sportos női rövidnadrágok a Vans márka kínálatából, és egyéb márkás ruhák, cipők hatalmas választékban, online rendeléssel, gyors szállítással.';
						break;
						
						// nadrag noi
						case 107:
							$title = 'Vans női nadrág - Coreshop';
							$description = 'Itt a legújabb kollekció a Vans webshop kínálatában: skinny style női nadrágok több színben és méretben a laza, sportos utcai viseletek kedvelőinek.';
						break;
						
						// napszemuveg						
						case 121:
							$title = 'Vans napszemüveg - Coreshop';
							$description = 'Vintage napszemüvegek a Vans webshoptól! \'80-as évek inspirálta napszemüvegek, UV-védelemmel ellátott lencsékkel, szárra festett Vans-logóval';
						break;
						
						// baseball sapka
						case 148:
							$title = 'Vans baseball sapka - Coreshop';
							$description = 'Trendi baseball sapkák a Vans webshop választékából kedvező áron, több színvariációban. Nézd meg többi ruházati termékünket is!';
						break;
						
						// ov
						case 100:
							$title = 'Vans öv - Coreshop';
							$description = 'A \'80-as évek hangulatát idéző vintage övek nagy választékban - Vans ruházat, cipő és kiegészítő termékek korrekt áron, 24 órás kiszállítással! Nézz be hozzánk!';
						break;
						
						// penztarca
						case 99:
							$title = 'Vans pénztárca - Coreshop';
							$description = 'Textil pénztárca a Vans webshop kínálatában, valamint sok más termék: pólók, pulóverek, nadrágok, cipők, övek, napszemüvegek...';
						break;
						
						// kotott sapka
						case 149:
							$title = 'Vans kötött sapka - Coreshop';
							$description = 'Kötött sapka a hűvösebb napokra hamisítatlan Vans stílusban: laza, trendi, sportos. Egyéb márkákból is csemegézhetsz webshopunkban, nézz be hozzánk!';
						break;
						
						// taska, hatizsak
						case 110:
							$title = 'Vans hátizsák, táska - Coreshop';
							$description = 'Kiránduláshoz vagy biciklizéshez, a napi munkába járáshoz ideális táskák a Vans webshoptól. Tekintsd meg választékunkat, árainkat!';
						break;
						
						// zokni
						case 145:
							$title = 'Vans zokni - Coreshop';
							$description = 'Vans cipőkhöz Vans zoknik a Coreshop kínálatában.';
						break;
					}
				
				}

			if ($_REQUEST['keresendo'] AND isset($title)) {
				$title .= " - " . htmlspecialchars($_REQUEST['keresendo']);
				$description .= " - " . htmlspecialchars($_REQUEST['keresendo']);
				$keywords .= "," . htmlspecialchars($_REQUEST['keresendo']);
			}

			if ($_REQUEST['meretek'] AND isset($title)) {
				$title .= " - " . htmlspecialchars($_REQUEST['meretek'])." méret";
				$description .= " - " . htmlspecialchars($_REQUEST['meretek'])." méret";
				$keywords .= "," . htmlspecialchars($_REQUEST['meretek'])." méret";
			}

			if ($_REQUEST['oldal'] AND isset($title)) {
				$title .= " - " . ((int)$_REQUEST['oldal']+1).". oldal";
				$description .= " - " . ((int)$_REQUEST['oldal']+1).". oldal";
				$keywords .= "," . ((int)$_REQUEST['oldal']+1).". oldal";
			}

			///////////////////////////////////////////////////////////////////////////////
            
        break;
		
		case "termekek_uj":
			
            $keywords = "Új ".$termekek->getTitleRoot(" - ");
			
			/*if ($_REQUEST['keresendo'])
				$keywords .= ' - '.$_REQUEST['keresendo']; */
		
			$title = $keywords.' - Coreshop';
			$title = str_replace("-   -", " - ", $title);
            $description = $keywords. ' - Coreshop';
			$keywords = strtolower(str_replace('-', ' ', $keywords));
		
		break;
		
		case "termekek_akcios":
			
            $keywords = "Akciós ".$termekek->getTitleRoot(" - ");
			
			/* if ($_REQUEST['keresendo'])
				$keywords .= ' - '.$_REQUEST['keresendo']; */
		
			$title = $keywords.' - Coreshop';
			$title = str_replace("-   -", " - ", $title);
            $description = $keywords. ' - Coreshop';
			$keywords = strtolower(str_replace('-', ' ', $keywords));
		
		break;

        case "termek":
			
            $keywords = $termek->termek['markanev']." ".$termek->termek['termeknev']." ".$termek->termek['szin']." ".strtolower($termek->termek['kategorianev']);
			
			if ($_REQUEST['keresendo'])
				$keywords .= ' - '.$_REQUEST['keresendo'];
			
			// Google FONTOS!
			/* if(!empty($termek->termek['leiras']))
				$description = $termek->termek['leiras'];
			else */
			// szin kieg a leirashoz
			if(!empty($termek->termek['szin'])) $szinben = $termek->termek['szin'].' színben';
			
				$description = $termek->termek['markanev'].' '.$termek->termek['termeknev'].' '.strtolower($termek->termek['kategorianev']).' '.$szinben.' '.number_format($termek->termek['vegleges_ar'], 0, '.', '.').' Ft-os áron a Coreshop-nál.';
				
				if(!empty($termek->termek['leiras']))
					$description .= ' '.$termek->termek['leiras'];
			
            $title = $keywords.' - Coreshop';
			$keywords = strtolower(str_replace('-', ' ', $keywords));
            
			/* og for facebook sharing */
			
		$og = '<meta property="og:type" content="product" />
		<meta property="og:title" content="'.$termek->termek['markanev'].' '.$termek->termek['termeknev'].' '.$termek->termek['szin'].' - Coreshop.hu" />
		<meta property="og:site_name" content="Coreshop.hu" />
		<meta property="og:description" content="'.$termek->termek['leiras'].'" />
		<meta property="og:url" content="https://coreshop.hu/hu/termek/'.strtolower($termek->termek['markanev']).'-'.$func->convertString(strtolower($termek->termek['termeknev'])).'/'.$termek->termek['id'].'" />
		<meta property="og:image" content="https://coreshop.hu/'.$func->getHDir($_SESSION['termek_id']).'1_large.jpg" />
		<meta property="og:image:width" content="920" />
		<meta property="og:image:height" content="920" />
		';
	
        break;		
		
		case "uzletunk":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->uzletunk;
            $title = $keywords;
            $description = $keywords." - Coreshop üzlet 1163 Budapest, Cziráki utca 26-32. földszint 24/A";            
        break;

        case "regisztracio":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->regisztracio;
            $title = $keywords;
            $description = $keywords." - új felhasználó regisztrálása";            
        break;

        case "elfelejtett_jelszo":
            $keywords = $func->getMainParam('MAIN_PAGE')." - Elfelejtett jelszó, aktivációs levél";
            $title = $keywords;
            $description = $keywords." - elfelejtett jelszó újraküldése - aktivációs levél újraküldése";            
        break;

        case "vasarlas":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->vasarlas;
            $title = $keywords;
            $description = $keywords." - regisztráció - kosárhasználat - megrendelés menete - adatvédelem - felelőségek - jogi háttér";            
        break;

        case "szallitas":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->szallitas;
            $title = $keywords;
            $description = $keywords." - Szállítás és fizetés módja - A csomagküldés díja";            
        break;

        case "szavatossag":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->szavatossag;
            $title = $keywords;
            $description = $keywords." - Szavatossági igény";            
        break;

        case "termekcsere":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->termekcsere;
            $title = $keywords;
            $description = $keywords." - Megvásárolt és kiszállított termékek cseréje";            
        break;

        case "kapcsolat":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->kapcsolat;
            $title = $keywords." - Elérhetőség - Térkép";
            $description = $title." - Megközelíthetőség - Kontakt";            
        break;
		
		case "altalanos_szerzodesi_feltetelek":
            $keywords = $func->getMainParam('MAIN_PAGE')." - ".$lang->aszf;
            $title = $keywords;
            $description = $keywords." - Általános szerződési feltételek";            
        break;
		
		case "app":		
			$keywords = "Coreshop, mobil alkalmazás, mobil app, iOS, Android, letöltés";
            $title = $func->getMainParam('MAIN_PAGE')." - Mobil alkalmazás";
            $description = $func->getMainParam('MAIN_PAGE')." - Mobil alkalmazás (iOS, Android)";
		break;
		
		case "kartyas_fizetes":
			$keywords = "Coreshop, ".$lang->kartyas_fizetes.", CIB Bank, Visa, MasterCard, Visa Electron, Maestro";
			$title = $func->getMainParam('MAIN_PAGE')." - ".$lang->kartyas_fizetes;
			$description = $func->getMainParam('MAIN_PAGE')." - ".$lang->kartyas_fizetes.", CIB Bank";
		break;
		
		case "megrendeles":
			if($user->isLogged())	{
			$keywords = "Coreshop, ".$lang->megrendeles;
			$title = $func->getMainParam('MAIN_PAGE')." - ".$lang->megrendeles;
			$description = $func->getMainParam('MAIN_PAGE')." - ".$lang->megrendeles;
			}
			else	{
			$keywords = "Coreshop, ".$lang->Bejelentkezes;
			$title = $func->getMainParam('MAIN_PAGE')." - ".$lang->Bejelentkezes;
			$description = $func->getMainParam('MAIN_PAGE')." - ".$lang->Bejelentkezes;
			}
		break;
		
		case "marka":
			//$keywords = "Coreshop, Sikeres vásárlás";
			//$title = $_SESSION['marka'];
			$title = $func->getMainParam('MAIN_PAGE');
			//$description = $func->getMainParam('MAIN_PAGE')." - Sikeres vásárlás";
		break;
		
		// egyedi oldalak
		
		case "etnies_birthday_pack":
			$title = 'etnies birthday pack 1986-2016 - '.$func->getMainParam('MAIN_PAGE');
			
		
		case "akcio":
			$title = 'Nyári akció a Coreshop-on!';
			
		case "vans-old-skool":
			$title = 'Vans Old Skool cipők - '.$func->getMainParam('MAIN_PAGE');
		

    }
	
	// ha van GET kereses (POST-ra nem muxik
	if ($_REQUEST['keresendo'])	{
				$title = str_replace('-', '', $title);
				//$title = ucwords($_REQUEST['keresendo']).' -  '.$title;	//ucfirst
				$title = ucwords($_REQUEST['keresendo']).' -  '.$func->getMainParam('MAIN_PAGE');
				$keywords = $_REQUEST['keresendo'].' '.$keywords;
				}
				
	// 404
	$exp = explode("/", $_GET['query']);
	if ( (!empty($exp[0])) && ( $exp[0] !== 'hu' ) )
		$title = $func->getMainParam('MAIN_PAGE').' - 404';
	
	/*
	if(ISSET($og))	{
		echo $og;	// termek oldal og: tag
	}
	else {
		echo '<meta property="og:image" content="/images/coreshop-logo-social.png" />';	// default logo
	
    echo '<meta name="keywords" content="'.$keywords.'" />';
    echo "\n";
    echo '<meta name="description" content="'.$description.'" />';
    echo "\n";
	}
	*/
	
	echo '<meta name="keywords" content="'.$keywords.'" />';
    echo "\n";
    echo '<meta name="description" content="'.substr($description,0,160).'" />';	// Google 160 karakterig jeleniti meg a leirast
    echo "\n";
	echo '<title>'.$title.'</title>';
    echo "\n";
    echo "\n";
	
	echo $og;	// termek oldal og: tag
	echo '<meta property="og:image" content="/images/coreshop-logo-social.png" />';	// default logo
		
    
    
?>