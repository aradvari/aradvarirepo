<?
// Net-Position javaslat:
if($_SESSION["langStr"]==='hu')	{
	$title = $func->getMainParam('MAIN_PAGE').' - gördeszkás webshop: Vans, DC, etnies, Emerica, Fallen, Volcom, Skullcandy, Bëlga';

	$description = 'Gördeszkás webshop Vans, DC, etnies, Emerica, Fallen, Volcom termékek széles raktárkészlettel, azonnali szállítással. Coreshop a gördeszka, cipő, ruházat és kiegészítő termékek webshopja';
	
	$keywords = 'coreshop, webshop, vans webshop, dc webshop, etnies webshop, emerica webshop, fallen webshop, volcom webshop, bëlga webshop, skullcandy webshop, gördeszka webshop';
}
else	{
	$title = $func->getMainParam('MAIN_PAGE').' - skateboard webshop: Vans, DC, etnies, Emerica, Fallen, Volcom, Skullcandy, Bëlga';

	$description = 'Skateboard webshop Vans, DC, etnies, Emerica with whole stock for 24 hours shipping. Coreshop is a skateboard, shoes, goods accessories webshop';
	
	$keywords = 'coreshop, webshop, vans webshop, dc webshop, etnies webshop, emerica webshop, fallen webshop, volcom webshop, bëlga webshop, skullcandy webshop, skateboard webshop';
}
	
    switch ($page){
        
        case "termekek":
			
            $keywords = $termekek->getTitleRoot(" | ");
			
			/* if ($_REQUEST['keresendo'])	{
				if ($keywords)
					$keywords .= ' | '.ucfirst($_REQUEST['keresendo']);
				else
					$keywords = ucfirst($_REQUEST['keresendo']);
				} */
		
			// uj / akcios
			if(!empty($_SESSION['opcio']))	{
				if($_SESSION['opcio']=='akcios')	$opcio='Akciós';				
				if($_SESSION['opcio']=='uj')	$opcio='Újdonságok';
				
				$keywords=$opcio.' | '.$keywords;
				}
			
			$title = $keywords.' Coreshop.hu';
			$title = str_replace("|   |", " | ", $title);
            $description = $keywords. ' - Coreshop.hu';
			$keywords = strtolower(str_replace('|', ',', $keywords)); 
			
			// VANS egyeni title, desc szovegek	/////////////////////////////////////////
			
			if($_SESSION['marka']==41)
				{
					// Vans marka oldal
					if ($_SESSION['kategoria'] == 0)	{
					$title = "Vans cipők webshop hatalmas választékban";

					$description  = "Vans webshop! Kedvező árak, gyere, nézz be hozzánk!";
					
					$keywords= "vans, vans cipők, vans webshop";
					}
								
							
					switch($_SESSION['kategoria']) {
						
						// cipo ferfi
						case 94:		
							$title = 'Vans shop férfi cipők | ISO 1.5, Atwood, Old Skool, Era, Authentic, Slip-On, TNT SG, Half Cab, Sk8-Hi'; /* vans ferfi cipo */
							$description = 'Vans shop márkás sport férfi cipők, nem csak gördeszkásoknak!';
							$keywords= 'vans shop, vans cipő, vans férfi cipő';
						break;
						
						// cipo noi
						case 95:
							$title = 'Vans női cipő - Coreshop';
							$description = 'Márkás női sport cipők a Vans webshopból a legújabb kollekcióból, nagy választékban! Minőség, trendi design, sport és kedvező árak - mi kell még?';
						break;
						
						// polo ferfi
						case 92:
							$title = 'Póló a Vans webshopból - Coreshop';
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
							$description = 'Sportos, divatos, márkás: Vans, DC, Emerica, Enjoi, Etnies, Fallen nadrágok nagy választékban, kedvező árakon, online rendeléssel.';
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
							$description = 'Azt nem garantálhatjuk, hogy a zoknimanók nem tüntetik el a mosógépből a fél pár zoknit, de a Vans márka mindenesetre jó választás a minőség terén.';
						break;
					}
				
				}
				
			///////////////////////////////////////////////////////////////////////////////
            
        break;
		
		case "termekek_uj":
			
            $keywords = "Új ".$termekek->getTitleRoot(" | ");
			
			/*if ($_REQUEST['keresendo'])
				$keywords .= ' - '.$_REQUEST['keresendo']; */
		
			$title = $keywords.' - Coreshop';
			$title = str_replace("|   |", " | ", $title);
            $description = $keywords. ' - Coreshop';
			$keywords = strtolower(str_replace('|', ',', $keywords));
		
		break;
		
		case "termekek_akcios":
			
            $keywords = "Akciós ".$termekek->getTitleRoot(" | ");
			
			/* if ($_REQUEST['keresendo'])
				$keywords .= ' - '.$_REQUEST['keresendo']; */
		
			$title = $keywords.' - Coreshop';
			$title = str_replace("|   |", " | ", $title);
            $description = $keywords. ' - Coreshop';
			$keywords = strtolower(str_replace('|', ',', $keywords));
		
		break;

        case "termek":
			
            $keywords = $termek->termek['markanev']." ".$termek->termek['termeknev']." ".$termek->termek['szin'];
			
			/*if ($_REQUEST['keresendo'])
				$keywords .= ' - '.$_REQUEST['keresendo']; */
				
            $title = $keywords.' - Coreshop';
			$keywords = strtolower(str_replace('|', ',', $keywords));
            
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
			$title = 'etnies birthday pack 1986-2016 - '.$func->getMainParam('MAIN_PAGE');;
		

    }
	
	// ha van GET kereses (POST-ra nem muxik
	if ($_REQUEST['keresendo'])	{
				$title = ucfirst($_REQUEST['keresendo']).'  -  '.$title;
				$keywords = $_REQUEST['keresendo'].', '.$keywords;
				}
	
    echo '<meta name="keywords" content="'.$keywords.'" />';
    echo "\n";
    echo '<meta name="description" content="'.$description.'" />';
    echo "\n";
    echo '<title>'.$title.'</title>';
    echo "\n";
    
?>