<?
/**
* Nyelvesítés osztály
*/
class Lang {
    
    public $defaultLangId;
    public $defaultLangStr;
    public $defaultCurrencyId;
    private $langDataSet = array();
    
    function Lang(){

        $languages[] = array(0, "hu"); 
        $languages[] = array(1, "en"); 
        //$languages[] = array(2, "de"); 

        $currencys[] = array(0, "HUF");
        $currencys[] = array(1, "EUR");
		
		//default
		if (!isset($_SESSION["langId"]))	{
		
			//if ($_SERVER['SERVER_NAME']==='coreshop.hu' || $_SERVER['SERVER_NAME']==='belga.coreshop.hu')	{
			if ($_SERVER['SERVER_NAME']==='coreshop.hu')	{
		
				$_SESSION["langId"] = $languages[0][0];			//0
				$_SESSION["langStr"] = $languages[0][1];		//hu
				$_SESSION["currencyId"] = $currencys[0][0];		//0
			}
			
			/* elseif ( ($_SERVER['SERVER_NAME']==='coreskate.eu') || ($_SERVER['SERVER_NAME']==='skateboardshoes.eu') )	{
				
				$_SESSION["langId"] = $languages[1][0];			//1
				$_SESSION["langStr"] = $languages[1][1];		//en
				$_SESSION["currencyId"] = $currencys[1][0];		//1				
			} */
		}

		
		// post select language
        if (ISSET($_POST["selectedLang"])){
            
            $_SESSION["langId"] = $languages[$_POST["selectedLang"]][0];
            $_SESSION["langStr"] = $languages[$_POST["selectedLang"]][1];
            
            if ((int)$_POST["selectedLang"]>0){ //KÜLFÖLDI NYELV KIVÁLASZTÁSA ESETÉN A PÉNZNEMET EURÓRA VÁLTJUK
                
                $_SESSION["currencyId"] = $languages[1][0];
                
            }

            if ((int)$_POST["selectedLang"]==0){ //MAGYAR NYELV KIVÁLASZTÁSA ESETÉN A PÉNZNEMET FORINTRA VÁLTJUK
                
                $_SESSION["currencyId"] = $languages[0][0];
                
            }
			
			$_SESSION["check"] = 'post';

        }
        
		// post select currency
        if (ISSET($_POST["selectedCurrency"])){
            
            $_SESSION["currencyId"] = $languages[$_POST["selectedCurrency"]][0];
            
        }
        
		/*
        //URL vizsgálat, nyelv feldolgozás
        $exp = explode("/", $_GET['query']);
        $_GET['langStr'] = (string)$exp[0];
				
        if ($_GET['langStr']=="hu"){		
            
            $_SESSION["langId"] = 0;    
            $_SESSION["langStr"] = 'hu';   
            //if (!ISSET($_SESSION["currencyId"])) 
			$_SESSION["currencyId"] = 0; 
            
        }elseif ($_GET['langStr']=="en"){
            
            $_SESSION["langId"] = 1;    
            $_SESSION["langStr"] = 'en';   
            //if (!ISSET($_SESSION["currencyId"])) 
			$_SESSION["currencyId"] = 1; 
            
        }*/

		/*
		// Ha meg nincs POST, vagy GET nyelvvalasztas, akkor alap nyelv a bongeszo alapjan
		if ( (!$_SESSION["langId"]) || (!$_SESSION["currencyId"]))	{
			
			$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			
			if ($browser_lang=="hu"){
				
				$_SESSION["langId"] = 0;    
				$_SESSION["langStr"] = 'hu';   
				//if (!ISSET($_SESSION["currencyId"])) 
				$_SESSION["currencyId"] = 0; 
				
			}else {
			
				$_SESSION["langId"] = 1;    
				$_SESSION["langStr"] = 'en';   
				//if (!ISSET($_SESSION["currencyId"])) 
				$_SESSION["currencyId"] = 1;             
			}
		}*/
		
        
        $this->defaultLangId = $_SESSION["langId"]; 
        $this->defaultLangStr = $_SESSION["langStr"]; 
        $this->defaultCurrencyId = $_SESSION["currencyId"]; 
        $this->readLangFile();

    }
    
    function readLangFile(){
        
        if (is_file("lang/language.csv")) $file = "lang/language.csv";
        elseif (is_file("../lang/language.csv")) $file = "../lang/language.csv";
        
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                
                if (!empty($data[0])){
                
                    $this->langDataSet[$data[0]] = array();
                    $num = count($data);
                    for ($c=1; $c < $num; $c++) {
                        
                        array_push($this->langDataSet[$data[0]], $data[$c]);
                        
                    }
                
                }

            }
            fclose($handle);
        }
        
        while ($word = each($this->langDataSet)){

            $this->$word[0] = $word["value"][$this->defaultLangId];
            
        }
        
    }
    
    function getWord($key){
        
        $word = $this->langDataSet[$key][$this->defaultLangId];
        
        if (empty($word)) return "*******";
        return $word;
        
    }
    
    /**
     * Overloading
    */
    
    public function __get($name)
    {
        //if ($this->$name=="") return "***$name***";
        if ($this->$name=="") return "$name";
        return $this->$name;
    }
            
}

?>