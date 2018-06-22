<?

class functions{

    function createSelectBox($sql, $default="", $html="", $defaultString="Kérem válasszon...", $defaultValue=""){
        
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
    
    function createArraySelectBox($array, $default="", $html="", $defaultString="Kérem válasszon...", $defaultValue=""){
        
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
  
        $ekezet=array("Ö","ö","Ü","ü","Ó","ó","Ő","ő","Ú","ú","Á","á","Ű","ű","É","é","Í","í"," ");
        $nekezet=array("O","o","U","u","O","o","O","o","U","u","A","a","U","u","E","e","I","i","_");
    
        return(strtolower(str_replace($ekezet,$nekezet,$str)));
  
    }    
    
    function createHDir($root='pictures/products/', $dir){
    
        if ((int)$dir==0) return false;
        else $dir.="";
        
        $actdir=$root;
        
        for ($go=0; $go<strlen($dir); $go++){
        
            if (!is_dir($actdir.$dir[$go])) mkdir($actdir.$dir[$go]);
            $actdir.=$dir[$go].'/';
            
        } 
        
        return $actdir;
        
    }
    
}

?>