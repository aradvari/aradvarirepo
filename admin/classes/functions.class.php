<?

class functions{

    function getMysqlValue($sql, $column=0){
    
        $adatok = @mysql_fetch_array(@mysql_query($sql));
        
        return $adatok[$column];
        
    }
    
    function getMainParam($name){
    
        return $this->getMysqlValue("SELECT ertek FROM globalis_adatok WHERE kulcs='$name'");
        
    }
    
    function checkInText($text)
        {
            if(eregi("http://([a-zA-Z0-9]+)([\.])(hu|com|info)", $text))
            {
                return true;
            } 
            
            if(eregi("www([\.])([a-zA-Z0-9]+)([\.])(hu|com|info)", $text))
            {
                return true;
            }  
            
            if(eregi("([a-zA-Z0-9]+)([\.])(hu|com|info)([ -]|[/])", $text))
            {
                return true;
            }  
         
            if (eregi("[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[_a-z0-9-]{2,4})", $text))
            {
                return true;
            }    
         
            if (eregi("[0-9]{1,3}([ -]|[/])[0-9]{1,10}([ -]|[/])[0-9]{1,10}", $text) || eregi("[0-9]{7,20}", $text))
            {
                return true;
            }    

        } 
        
    function validIP($ip)
    {
        if (!empty($ip) && ip2long($ip)!=-1)
        {
            $reserved_ips = array (
            array('0.0.0.0','2.255.255.255'),
            array('10.0.0.0','10.255.255.255'),
            array('127.0.0.0','127.255.255.255'),
            array('169.254.0.0','169.254.255.255'),
            array('172.16.0.0','172.31.255.255'),
            array('192.0.2.0','192.0.2.255'),
            array('192.168.0.0','192.168.255.255'),
            array('255.255.255.0','255.255.255.255')
            );

            foreach ($reserved_ips as $r)
            {
                $min = ip2long($r[0]);
                $max = ip2long($r[1]);
                if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
            }

            return true;
        }
        else return false;
    }

    function getIpAddress(){
        if(isset($_SERVER))
            {
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $this->validIP($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            elseif(isset($_SERVER['HTTP_CLIENT_IP']) && $this->validIP($_SERVER['HTTP_CLIENT_IP']))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        else
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        else
            {
        if(getenv('HTTP_X_FORWARDED_FOR') && $this->validIP(getenv('HTTP_X_FORWARDED_FOR')))
                $ip = getenv('HTTP_X_FORWARDED_FOR');
        elseif(getenv('HTTP_CLIENT_IP') && $this->validIP(getenv('HTTP_CLIENT_IP')))
                $ip = getenv('HTTP_CLIENT_IP');
        else
                $ip = getenv('REMOTE_ADDR');
            }
            
        return $ip;
    }
    
    function createSelectBox($sql, $default="", $html="", $defaultString="Válassz...", $defaultValue=""){
        
        $query = mysql_query($sql);
        
        $return = "<select $html>";
        
        if (!empty($defaultString)) $return .= "<option value=\"$defaultValue\">$defaultString</option>";
        
        while ($adatok = mysql_fetch_array($query)){
            
            if ($adatok[0]==$default) $selected="selected=\"selected\""; else $selected = '';
            
            $return .= "<option value=\"".$adatok[0]."\" $selected>".$adatok[1]."</option>";
            
        }
        
        $return .= "</select>";
        
        return $return;
        
    }
    
    function createArraySelectBox($array, $default="", $html="", $defaultString="Válassz...", $defaultValue=""){
        
        $return = "<select $html>";
        
        if (!empty($defaultString)) $return .= "<option value=\"$defaultValue\">$defaultString</option>";

        reset($array);
        while ($adatok = each($array)){
            
            if ($adatok[0]==$default) $selected="selected=\"selected\""; else $selected = '';
            
            $return .= "<option value=\"".$adatok[0]."\" $selected>".$adatok[1]."</option>";
            
        }
        
        $return .= "</select>";
        
        return $return;
        
    }
    
    function convertString($str)
    {
  
        $ekezet=array("Ö","ö","Ü","ü","Ó","ó","Õ","õ","Ú","ú","Á","á","Û","û","É","é","Í","í"," ");
        $nekezet=array("O","o","U","u","O","o","O","o","U","u","A","a","U","u","E","e","I","i","_");
    
        return(strtolower(str_replace($ekezet,$nekezet,$str)));
  
    }    
    
    function createHDir($dir, $root='pictures/termekek/'){
    
        if ((int)$dir==0) return false;
        else $dir.="";
        
        $actdir=$root;
        
        for ($go=0; $go<strlen($dir); $go++){
        
            if (!is_dir($actdir.$dir[$go])) mkdir($actdir.$dir[$go]);
            $actdir.=$dir[$go].'/';
            
        } 
        
        return $actdir;
        
    }
    
    function getHDir($id, $root='pictures/termekek/'){
    
        if ((int)$id==0) return false;
        else $id.="";
        
        $actdir=$root;

        for ($go=0; $go<strlen($id); $go++){
        
            $actdir.=$id[$go].'/';
            
        } 

        return $actdir;

    }
    
    function inttohuf($int){
    
        return number_format((int)$int, 0, '', ' ');
        
    }
    
    function passwordGenerator($length, $upper, $lower, $number, $special){
    
        $jelszo='';
        $opcio=array(1=>false,2=>false,3=>false,4=>false);
        
        $pw[1]=array('Q', 'W', 'E', 'R', 'T', 'Z', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Y', 'X', 'C', 'V', 'B', 'N', 'M');
        $pw[2]=array('q', 'w', 'e', 'r', 't', 'z', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'y', 'x', 'c', 'v', 'b', 'n', 'm');
        $pw[3]=array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $pw[4]=array('-', '*', '_', '+', '.');
        
        for ($go=1; $go<=$length; $go++){
        
            $opcio=array();
            if ($upper) $opcio[]=1;
            if ($lower) $opcio[]=2;
            if ($number) $opcio[]=3;
            if ($special) $opcio[]=4;
            
            $rd = $opcio[rand(0, count($opcio)-1)];
            $jelszo.=$pw[$rd][rand(0, count($pw[$rd])-1)];
            
        }
        
        return $jelszo; 
    
    }
    
    function insertDb($arr, $tablename, $slashes=true) {
    
        $keys = "`".implode(array_keys($arr), "`, `")."`"; 
        
        if ($slashes){
            $values = "'".implode(array_values($arr), "', '")."'"; 
        }else{
            $values = implode(array_values($arr), ", "); 
        }
        
        if (DB_DEBUG) echo "<hr>INSERT INTO $tablename ($keys) VALUES ($values)<hr>";

        if (!@mysql_query("INSERT INTO $tablename ($keys) VALUES ($values)")){
        
            return false;
            
        }else{
            
            return true;
        
        }
        
    }
        
    function updateDb($arr, $tablename, $cond="", $slashes=true) {
    
        $items=array();
        while ($adatok = each($arr)){
        
            if ($slashes){
             
                $items[] = $adatok[0]."='".$adatok[1]."'";
                
            }else{
             
                $items[] = $adatok[0]."=".$adatok[1]."";
                
            }
            
        }
        
        $values = " SET ".implode($items, ", "); 
        
        if (DB_DEBUG) echo "<hr>UPDATE $tablename $values $cond<hr>";
        
        if (!@mysql_query("UPDATE $tablename $values $cond")){
        
            return false;
            
        }else{
            
            return true;
        
        }
        
    }
    
    function upperFirstChars($istr){
    
        $str = strtolower(trim(iconv("UTF-8", "ISO-8859-2", $istr)));
        
        $words = explode (" ", $str);
        
        for ($go=0; $go<count($words); $go++) $words[$go] = iconv("ISO-8859-2", "UTF-8", ucfirst($words[$go]));
        
        return implode (" ", $words);
        
    }
    
    function generateBarCode($id){

        $dt0 = substr(date("U"), 1, 3);
        $dt1 = substr(date("U"), 6, 2);
        $dt2 = substr(date("U"), 8, 2);
        
        return str_pad($id, 5, 0, STR_PAD_RIGHT).$dt1.$dt2.$dt0;

    }

    function isClubUser($userid){
    
        if ($this->getUserClubPrices($userid) >= (int)$this->getMainParam("klub_hatar")) return true;
        
        //echo $this->getUserClubPrices($userid);
        
        return false;
        
    }

    function getUserClubPrices($userid){
    
        $sql = "SELECT sum(kikerulesi_ar) FROM keszlet WHERE id_felhasznalok=$userid";
        $price = (int)mysql_result(mysql_query($sql), 0);

        return $price;
        
    }

    function toHUF($osszeg, $arfolyam="",$numberFormat=true){
        
        $EUR = $this->getMainParam("eur_arfolyam");
        if ($arfolyam=="") $arfolyam = $EUR;
        
        if ($numberFormat)
            return number_format((float)$osszeg*$arfolyam, 2, ".", " ");
        else
            return ($osszeg*$arfolyam);
        
    }  
    
    function toEUR($osszeg, $arfolyam="", $numberFormat=true){
        
        $EUR = $this->getMainParam("eur_arfolyam");
        if ($arfolyam=="") $arfolyam = $EUR;
        
        if ($numberFormat)
            return number_format((float)$osszeg/$arfolyam, 2, ".", " ");
        else
            return ($osszeg/$arfolyam);
        
    }  
    
    function getBruttoToNetto($osszeg){
        
        $afa_kulcs = $this->getMainParam("afa_kulcs");
        
        return ( $osszeg - (($osszeg/100)*$afa_kulcs) );
        
    }
        
    function getAFAFromBrutto($osszeg){
        
        $afa_kulcs = $this->getMainParam("afa_kulcs");
        
        return ( $osszeg * ($afa_kulcs/100) );
        
    }
        
}

?>