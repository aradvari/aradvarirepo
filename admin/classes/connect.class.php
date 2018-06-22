<?

class connect_db{
    
    var $error ;
    var $link ;
    
    private function checkConnect(){
    
        
    
    }
    
    function connect($host, $user, $passw){
        
        $this->link = @mysql_connect($host, $user, $passw);
        
        if (!$this->link) {
            
            $this->error = mysql_error();
            return false;
        
        }else{
            
            return true;
        
        }
    
    }
    
    function select_db($database){

        $dbc = @mysql_select_db($database, $this->link);
        
        if (!$dbc) {
            
            $this->error = mysql_error();
            return false;
        
        }else{
            
            mysql_query("SET NAMES utf8");
            return true;
        
        }

    }
    
}

?>