<?

class functions {

    function getMysqlValue($sql, $column = 0) {

        $adatok = @mysql_fetch_array(@mysql_query($sql));

        return $adatok[$column];
    }

    function getMainParam($name) {

        return $this->getMysqlValue("SELECT ertek FROM globalis_adatok WHERE kulcs='$name'");
    }

    function checkInText($text) {
        if (eregi("http://([a-zA-Z0-9]+)([\.])(hu|com|info)", $text)) {
            return true;
        }

        if (eregi("www([\.])([a-zA-Z0-9]+)([\.])(hu|com|info)", $text)) {
            return true;
        }

        if (eregi("([a-zA-Z0-9]+)([\.])(hu|com|info)([ -]|[/])", $text)) {
            return true;
        }

        if (eregi("[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[_a-z0-9-]{2,4})", $text)) {
            return true;
        }

        if (eregi("[0-9]{1,3}([ -]|[/])[0-9]{1,10}([ -]|[/])[0-9]{1,10}", $text) || eregi("[0-9]{7,20}", $text)) {
            return true;
        }
    }

    function validIP($ip) {
        if (!empty($ip) && ip2long($ip) != -1) {
            $reserved_ips = array(
                array('0.0.0.0', '2.255.255.255'),
                array('10.0.0.0', '10.255.255.255'),
                array('127.0.0.0', '127.255.255.255'),
                array('169.254.0.0', '169.254.255.255'),
                array('172.16.0.0', '172.31.255.255'),
                array('192.0.2.0', '192.0.2.255'),
                array('192.168.0.0', '192.168.255.255'),
                array('255.255.255.0', '255.255.255.255')
            );

            foreach ($reserved_ips as $r) {
                $min = ip2long($r[0]);
                $max = ip2long($r[1]);
                if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max))
                    return false;
            }

            return true;
        } else
            return false;
    }

    function getIpAddress() {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $this->validIP($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            elseif (isset($_SERVER['HTTP_CLIENT_IP']) && $this->validIP($_SERVER['HTTP_CLIENT_IP']))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            else
                $ip = $_SERVER['REMOTE_ADDR'];
        }
        else {
            if (getenv('HTTP_X_FORWARDED_FOR') && $this->validIP(getenv('HTTP_X_FORWARDED_FOR')))
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            elseif (getenv('HTTP_CLIENT_IP') && $this->validIP(getenv('HTTP_CLIENT_IP')))
                $ip = getenv('HTTP_CLIENT_IP');
            else
                $ip = getenv('REMOTE_ADDR');
        }

        return $ip;
    }

    function createSelectBox($sql, $default = "", $html = "", $defaultString = "", $defaultValue = "") {

        global $lang;

        if ($defaultString == "" && $defaultString != null)
            $defaultString = $lang->Valassz;

        $query = mysql_query($sql);

        $return = "<select $html>";

        if (!empty($defaultString))
            $return .= "<option value=\"$defaultValue\">$defaultString</option>";

        while ($adatok = mysql_fetch_array($query)) {

            if ($adatok[0] == $default)
                $selected = "selected=\"selected\"";
            else
                $selected = '';

            $return .= "<option value=\"" . $adatok[0] . "\" $selected>" . $lang->$adatok[1] . "</option>";
        }

        $return .= "</select>";

        return $return;
    }

    function createSelectBox_noLang($sql, $default = "", $html = "", $defaultString = "Válassz...", $defaultValue = "") {

        global $lang;

        $query = mysql_query($sql);

        $return = "<select $html>";

        if (!empty($defaultString))
            $return .= "<option value=\"$defaultValue\">$defaultString</option>";

        while ($adatok = mysql_fetch_array($query)) {

            if ($adatok[0] == $default)
                $selected = "selected=\"selected\"";
            else
                $selected = '';

            $return .= "<option value=\"" . $adatok[0] . "\" $selected>" . $adatok[1] . "</option>";
        }

        $return .= "</select>";

        return $return;
    }

    function createButtonSelectBox($sql, $default = "", $html = "", $defaultString = "", $defaultValue = "") {

        global $lang;

        //if ($defaultString=="") $defaultString = $lang->Minden_meret;

        $query = mysql_query($sql);

        $return = "";

        if (!empty($defaultString))
            $return .= '<input type="submit" value="' . $defaultString . '" ' . $html . ' ' . ($default == "" ? 'class="sizeButtonSelected"' : 'sizeButton') . ' />';

        while ($adatok = mysql_fetch_array($query)) {

            if ($adatok[0] == $default)
                $class = "sizeButtonSelected";
            else
                $class = 'sizeButton';

            $return .= '<input type="submit" value="' . $adatok[0] . '" class="' . $class . '" ' . $html . ' />';
        }

        return $return;
    }

    function createArraySelectBox($array, $default = "", $html = "", $defaultString = "", $defaultValue = "") {

        global $lang;

        if ($defaultString == "" && $defaultString != null)
            $defaultString = $lang->Valassz;

        $return = "<select $html>";

        if (!empty($defaultString))
            $return .= "<option value=\"$defaultValue\">$defaultString</option>";

        reset($array);
        while ($adatok = each($array)) {

            if ($adatok[0] == $default)
                $selected = "selected=\"selected\"";
            else
                $selected = '';

            $return .= "<option value=\"" . $adatok[0] . "\" $selected>" . $lang->$adatok[1] . "</option>";
        }

        $return .= "</select>";

        return $return;
    }

    function createArraySelectBox_noLang($array, $default = "", $html = "", $defaultString = "Válassz...", $defaultValue = "") {

        global $lang;

        $return = "<select $html>";

        if (!empty($defaultString))
            $return .= "<option value=\"$defaultValue\">$defaultString</option>";

        reset($array);
        while ($adatok = each($array)) {

            if ($adatok[0] == $default)
                $selected = "selected=\"selected\"";
            else
                $selected = '';

            $return .= "<option value=\"" . $adatok[0] . "\" $selected>" . $adatok[1] . "</option>";
        }

        $return .= "</select>";

        return $return;
    }
	
	
	function createArrayRadioButton($array, $default = "", $html = "", $defaultString = "", $defaultValue = "") {

        global $lang;

        reset($array);
        while ($adatok = each($array)) {

            if ($adatok[0] == $default)
                $selected = "selected=\"selected\"";
            else
                $selected = '';

			$return .= '<input type="radio" '.$html.' value='. $adatok[0] . ' >';
            //$return .= "<option value=\"" . $adatok[0] . "\" $selected>" . $lang->$adatok[1] . "</option>";
        }

        return $return;
    }

    function convertString($str) {

        $ekezet=array("Ö","ö","Ü","ü","Ó","ó","Ő","ő","Ú","ú","Á","á","Ű","ű","É","é","Ë","ë","Í","í"," ", "%");
        $nekezet=array("O","o","U","u","O","o","O","o","U","u","A","a","U","u","E","e","E","e","I","i","-", "");

        return(strtolower(str_replace($ekezet, $nekezet, $str)));
    }

    function createHDir($dir, $root = 'pictures/termekek/') {

        if ((int) $dir == 0)
            return false;
        else
            $dir.="";

        $actdir = $root;

        for ($go = 0; $go < strlen($dir); $go++) {

            if (!is_dir($actdir . $dir[$go]))
                mkdir($actdir . $dir[$go]);
            $actdir.=$dir[$go] . '/';
        }

        return $actdir;
    }

    function getHDir($id, $root = 'pictures/termekek/') {

        if ((int) $id == 0)
            return false;
        else
            $id.="";

        $actdir = $root;

        for ($go = 0; $go < strlen($id); $go++) {

            $actdir.=$id[$go] . '/';
        }

        return $actdir;
    }

    function inttohuf($int) {

        return number_format((int) $int, 0, '', ' ');
    }

    function passwordGenerator($length, $upper, $lower, $number, $special) {

        $jelszo = '';
        $opcio = array(1 => false, 2 => false, 3 => false, 4 => false);

        $pw[1] = array('Q', 'W', 'E', 'R', 'T', 'Z', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Y', 'X', 'C', 'V', 'B', 'N', 'M');
        $pw[2] = array('q', 'w', 'e', 'r', 't', 'z', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'y', 'x', 'c', 'v', 'b', 'n', 'm');
        $pw[3] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $pw[4] = array('-', '*', '_', '+', '.');

        for ($go = 1; $go <= $length; $go++) {

            $opcio = array();
            if ($upper)
                $opcio[] = 1;
            if ($lower)
                $opcio[] = 2;
            if ($number)
                $opcio[] = 3;
            if ($special)
                $opcio[] = 4;

            $rd = $opcio[rand(0, count($opcio) - 1)];
            $jelszo.=$pw[$rd][rand(0, count($pw[$rd]) - 1)];
        }

        return $jelszo;
    }

    function insertDb($arr, $tablename, $slashes = true) {

        $keys = "`" . implode(array_keys($arr), "`, `") . "`";

        if ($slashes) {
            $values = "'" . implode(array_values($arr), "', '") . "'";
        } else {
            $values = implode(array_values($arr), ", ");
        }

        if (DB_DEBUG)
            echo "<hr>INSERT INTO $tablename ($keys) VALUES ($values)<hr>";

        if (!@mysql_query("INSERT INTO $tablename ($keys) VALUES ($values)")) {

            return false;
        } else {

            return true;
        }
    }

    function updateDb($arr, $tablename, $cond = "", $slashes = true) {

        $items = array();
        while ($adatok = each($arr)) {

            if ($slashes) {

                $items[] = $adatok[0] . "='" . $adatok[1] . "'";
            } else {

                $items[] = $adatok[0] . "=" . $adatok[1] . "";
            }
        }

        $values = " SET " . implode($items, ", ");

        if (DB_DEBUG)
            echo "<hr>UPDATE $tablename $values $cond<hr>";

        if (!@mysql_query("UPDATE $tablename $values $cond")) {

            return false;
        } else {

            return true;
        }
    }

    function upperFirstChars($istr) {

        $str = strtolower(trim(iconv("UTF-8", "ISO-8859-2", $istr)));

        $words = explode(" ", $str);

        for ($go = 0; $go < count($words); $go++)
            $words[$go] = iconv("ISO-8859-2", "UTF-8", ucfirst($words[$go]));

        return implode(" ", $words);
    }

    function toHUF($osszeg, $numberFormat = true) {

        $EUR = $this->getMainParam("eur_arfolyam");

        if ($numberFormat)
            return number_format((float) $osszeg * $EUR, 2, ".", " ");
        else
            return ($osszeg * $EUR);
    }

    function toEUR($osszeg, $numberFormat = true) {

        $EUR = $this->getMainParam("eur_arfolyam");

        if ($numberFormat)
            return number_format((float) $osszeg / $EUR, 2, ".", " ");
        else
            return number_format((float) $osszeg / $EUR, 2, ".", "");

        /* if ($numberFormat)
          return number_format( (round($osszeg/$EUR))-0.05, 2, ".", " ");		// "kerekitve" .95 centre
          else
          number_format( (round($osszeg/$EUR))-0.05, 2, ".", "");				// "kerekitve" .95 centre */
    }

    function getBruttoToNetto($osszeg) {

        $afa_kulcs = $this->getMainParam("afa_kulcs");

        return ( $osszeg - (($osszeg / 100) * $afa_kulcs) );
    }

    function getAFAFromBrutto($osszeg) {

        $afa_kulcs = $this->getMainParam("afa_kulcs");

        return ( $osszeg * ($afa_kulcs / 100) );
    }

    function GlsDeliveryDate($country) {

        //ha be van allitva parameterben egyedi ertek
        $custom_delivery_date = $this->getMainParam('egyedi_szallitas_idopont');

        if (!empty($custom_delivery_date))
            return $custom_delivery_date;


        if ($country = 'HU') {

            $leadas_napi_hatarido = '15:30'; //16 ora

            if (!in_array((date('Ymd')), $unnepnapok)) {

                switch (date('w')) {

                    //vas
                    case 0: $delivery_date = date('Y. F d. D', strtotime("next Tuesday"));
                        break;

                    //csut
                    case 4: {
                            if (date('H:i') < $leadas_napi_hatarido)
                                $delivery_date = date('Y. F d. D', strtotime("+1 day"));
                            else
                                $delivery_date = date('Y. F d. D', strtotime("next Monday"));
                            break;
                        }

                    //pen
                    case 5: {
                            if (date('H:i') < $leadas_napi_hatarido)
                                $delivery_date = date('Y. F d. D', strtotime("next Monday"));
                            else
                                $delivery_date = date('Y. F d. D', strtotime("next Tuesday"));
                            break;
                        }

                    //szo
                    case 6: $delivery_date = date('Y. F d. D', strtotime("next Tuesday"));
                        break;

                    // het, kedd, sze
                    default: {
                            if (date('H:i') < $leadas_napi_hatarido)
                                $delivery_date = date('Y. F d. D', strtotime("+1 day"));
                            else
                                $delivery_date = date('Y. F d. D', strtotime("+2 day"));

                            break;
                        }
                }
            }
            //unnepnapok
            else
                $delivery_date = $unnepnapok[date('Ymd')];
        }

        return $delivery_date;
    }

    function dateToHU($str) {
        $en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
        $hu = array("január", "február", "március", "Április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat", "vasárnap");

        return str_replace($en, $hu, $str);
    }

    function RemainingDispatchTime() {
        $startdate = date("Y-m-d H:i:s"); //current datetime
        // h-cs 15:00 elott
        if ((date('H') < 15) && (date('w') !== 5))
            $enddate = date('Y-m-d H:i:s', strtotime('today 3:00 pm'));
        else
            $enddate = date('Y-m-d H:i:s', strtotime('+1 day 3:00 pm'));


        // hetvegen
        if (date('w') == 0)
            $enddate = date('Y-m-d H:i:s', strtotime('monday 3:00 pm'));

        $diff = strtotime($enddate) - strtotime($startdate);
        //echo "diff in seconds: $diff<br/>\n<br/>\n"; 
        // immediately convert to days 
        $temp = $diff / 86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day 
        // days 
        $days = floor($temp);
        $temp = 24 * ($temp - $days);
        // hours 
        $hours = floor($temp);
        $temp = 60 * ($temp - $hours);
        // minutes 
        $minutes = floor($temp);
        $temp = 60 * ($temp - $minutes);
        // seconds 
        $seconds = floor($temp);

        // nyelvesites
        if ($_SESSION["langStr"] == "hu") {
            /*
              $dispatch = "RendelĂ©sedtĹ‘l szĂˇmĂ­tva a csomagod ";
              if($days>0) $dispatch .= $days." nap ";
              if($hours>0)
              $dispatch .= ($hours+1)." ĂłrĂˇn belĂĽl feladĂˇsra kerĂĽl.";	//+1 ora
              else
              $dispatch .= " 1 ĂłrĂˇn belĂĽl feladĂˇsra kerĂĽl."; */
            $dispatch = "CsomagfeladĂˇs ";
            if ($days > 0)
                $dispatch .= $days . " nap ";
            if ($hours > 0)
                $dispatch .= ($hours + 1) . " ĂłrĂˇn belĂĽl."; //+1 ora
            else
                $dispatch .= " 1 ĂłrĂˇn belĂĽl.";
        }
        else {
            $dispatch = "Dispatch within ";
            if ($days > 0)
                $dispatch .= $days . " day ";
            if ($hours > 0)
                $dispatch .= ($hours + 1) . " hours."; //+1 ora
            else
                $dispatch .= " one hour.";
        }

        // pentek 15:00 utan
        if ((date('w') == 5) && (date('H') >= 15)) {
            if ($_SESSION["langStr"] == "hu")
                $enddate = date('Y-m-d H:i:s', strtotime('nextmonday 3:00 pm'));
            else
                $dispatch = '';
        }

        return $dispatch;
    }

    function isMobile() {

        $mobile_browser = '0';

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|linux|android|ipad)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ( (isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'OperaMini') > 0) {
            $mobile_browser++;
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
            $mobile_browser = 0;
        }

        return $mobile_browser;
    }

    function trim_text($text, $count) {
        $text = str_replace("  ", " ", $text);
        $text = str_replace("/", " ", $text);
        $string = explode(" ", $text);
        for ($wordCounter = 0; $wordCounter <= $count; $wordCounter++) {

            $trimed .= $string[$wordCounter] . ' ';

            /* if ( $wordCounter < $count )	{ $trimed .= " "; } 

              else { $trimed .= "..."; } */
        }

        //$trimed = trim($trimed); 

        return $trimed;
    }
	
	
	function header_subcategories($szulo) {
		
		$subcat=mysql_query('SELECT k.id_kategoriak, k.nyelvi_kulcs, k.megnevezes, k.szulo
							FROM kategoriak k
							LEFT JOIN termek_kategoria_kapcs tkk ON tkk.id_kategoriak = k.id_kategoriak
							LEFT JOIN termekek t ON t.id = tkk.id_termekek
							LEFT JOIN vonalkodok v ON v.id_termek = t.id
							WHERE k.sztorno IS NULL
							AND t.aktiv =1
							AND v.keszlet_1 >0
							AND t.torolve IS NULL
							AND k.szulo ='.$szulo.' 
							GROUP BY k.id_kategoriak
							ORDER BY k.sorrend');
		
		return $subcat;
	}
	
	
	function thumb($id) {
	
	$query_thumb='
	SELECT
	m.markanev,
	t.termeknev,
	t.szin,
	t.klub_ar,
	t.kisker_ar,
	t.akcios_kisker_ar,
	t.dealoftheweek,
	t.id,
	t.opcio,
	t.fokep

	FROM termekek t

	LEFT JOIN markak m ON m.id = t.markaid
	LEFT JOIN vonalkodok v ON v.id_termek=t.id

	WHERE
	t.id = '.$id;  
	  

	$arr = mysql_fetch_array(mysql_query($query_thumb));
		
	$tmb = '<div class="product-thumb">';		
	
	// label kikapcsolva
	$tmb .= '<div class="product-opcio-container">';  
	//if($arr['opcio'] == 'ZZ_TOP') 			$tmb .=  '<span class="top">top</span>';
	if($arr['opcio'] == 'Z_CARRYOVER') 		$tmb .=  '<span class="classic">Classic</span>';	//ez nem szokott menni
	if($arr['opcio'] == 'UJ') 				$tmb .=  '<span class="uj">New 2018</span>';
	//if($arr['akcios_kisker_ar'] > 0) 		$tmb .=  '<span class="akcio">Sale %</span>';
	if($arr['opcio'] == 'AKCIOS') 		$tmb .=  '<span class="akcio">Sale %</span>';
	$tmb .=  '</div>';
	
	
	$tmb .= '<a href="/hu/termek/'.$this->convertString($arr['markanev']).'-'.$this->convertString($arr['termeknev']).'/'.$arr['id'].'">';
				
	$kep = $this->getHDir($arr['id']).$arr['fokep']."_small.jpg"; 

	if(is_file($kep))                       
		$tmb .= '<img src="/'.$kep.'?0705" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'" /></a>';                          
	else
		$tmb .= '<img src="/images/none.jpg?2017" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'" /></a>';      
	
	/* if (!$this -> isMobile() )
		$tmb .= '<div class="product-thumb-rollover"><img src="/image_resize.php?w=400&img=/'.$this->getHDir($arr['id']).'2_large.jpg" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'" /></div></a>'; */
	
			   
	$tmb .= '<div class="product-info">'; 				                
				
	$tmb .= '<a href="/'.$_SESSION["langStr"].'/termek/'.$this->convertString($arr['markanev']).'-'.$this->convertString($arr['termeknev']).'/'.$arr['id'].'">
	<h2>'.$arr['markanev'].' '.$arr['termeknev'].'</h2></a>
	<a href="/'.$_SESSION["langStr"].'/termek/'.$this->convertString($arr['markanev']).'-'.$this->convertString($arr['termeknev']).'/'.$arr['id'].'">'.$arr['szin'].'</a>';
			
	$tmb .= '<div class="products-prise-container">';
				
	if ($lang->defaultCurrencyId == 0){ //MAGYARORSZÁG ESETÉN
		
		if ($arr['akcios_kisker_ar']>0)	{						
				$tmb .= '<span class="products-thumb-originalprise"><del>'.number_format($arr['kisker_ar'],0,'','.').'</del> Ft</span><br />';    
				$tmb .= '<span class="products-thumb-saleprise">'.number_format($arr['akcios_kisker_ar'],0,'','.').' Ft</span>';
				}
		else
				$tmb .=	$lang->Ar.' '.number_format($arr['kisker_ar'], 0, '', ' ').' Ft';

	}else{

		//ÁTVÁLTÁS

		if ($arr['akcios_kisker_ar']>0)	{
				$tmb .=	'<span class="products-thumb-saleprise">€ '.$this->toEUR($arr['akcios_kisker_ar']).'</span>';
				$tmb .=	'<span class="products-thumb-originalprise">€ <del>'.$this->toEUR($arr['kisker_ar']).' </span><br />';    					
				}
		else
				$tmb .=	$lang->Ar.' € '.$this->toEUR($arr['kisker_ar']);
		
	}
	$tmb .= 		'</div>
			</div>
		</div>';
	
	return $tmb;
	
	}

}

?>