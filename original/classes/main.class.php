<?

class main{
    
    function __construct(){
    
        if (!ISSET($_SESSION['main_font_size'])) $_SESSION['main_font_size'] = 11;
        if (!ISSET($_SESSION['main_class'])) $_SESSION['main_class'] = 'main';
        
        if (ISSET($_POST['optioner'])){

            switch ($_POST['optioner']){
            
                case "largeFont":
                    if ($_SESSION['main_font_size']<20) $_SESSION['main_font_size']++;
                break;
                
                case "smallFont":
                    if ($_SESSION['main_font_size']>10) $_SESSION['main_font_size']--;
                break;
                
                case "wrongEye":
                    if ($_SESSION['main_class']=='main_eye'){
                        
                        $_SESSION['main_class']='main';
                        $_SESSION['main_font_size']=11;
                        
                    }else{
                        
                        $_SESSION['main_class']='main_eye';
                        $_SESSION['main_font_size']=20;
                        
                    }
                break;
                
            }
            
        }
        
    }  
          
}

?>