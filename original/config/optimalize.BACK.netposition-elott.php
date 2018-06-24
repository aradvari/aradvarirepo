<?

    $k = mysql_query("SELECT megnevezes FROM kategoriak WHERE szulo=0");
    while ($kategoria = mysql_fetch_assoc($k)) $kategoriak[] = $lang->$kategoria["megnevezes"];
    $kategoriak = implode(" ", $kategoriak);
    $m = mysql_query("SELECT markanev FROM markak WHERE sztorno IS NULL");
    while ($marka = mysql_fetch_assoc($m)) $markak[] = $lang->$marka["megnevezes"];
    $markak = implode(" ", $markak);
    
    $title = $func->getMainParam('MAIN_PAGE');
    $keywords = $title.", ".$kategoriak.", ".$markak;
    $description = $title." - Online gördeszkás ruházati webáruház";

    switch ($page){
        
        case "termekek":

            $keywords = $termekek->getTitleRoot(" | ");
            //$title = $title." - ".$keywords;
			$title = $keywords." | ".$title;
			$title = str_replace("|   |", " | ", $title);
            $description = $keywords;
            
        break;

        case "termek":
			
            $keywords = $termek->termek['markanev']." ".$termek->termek['termeknev']." ".$termek->termek['szin'];
            //$title = $title." - ".$keywords;
            $title = $keywords." | ".$title;
            $description = $keywords;
            
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

    }

    if (empty($title)) $title = MAIN_PAGE;
    if (empty($keywords)) $keywords = $title.", ".$kategoriak.", ".$markak;
    if (empty($description)) $description = $title." - Online gördeszkás ruházati webáruház";
	
    
    echo '<meta name="keywords" content="'.$keywords.'" />';
    echo "\n";
    echo '<meta name="description" content="'.$description.'" />';
    echo "\n";
    echo '<title>'.$title.'</title>';
    echo "\n";
    
?>