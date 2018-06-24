<?
class cibClass{
    
    var $url = 'http://eki.cib.hu:8090/market.saki?';   //ÉLES
    //var $url = 'http://ekit.cib.hu:8090/market.saki?';	//TESZT
    var $url2 = 'https://eki.cib.hu/customer.saki?';    //ÉLES
    //var $url2 = 'https://ekit.cib.hu/customer.saki?';   //TESZT
    var $pid = 'CSH0001';
    var $crypto = '1';
    var $cur = 'HUF';
    var $auth = '0';
    var $lang = 'hu';
    var $redir = "";
    //var $csh_file = '../cib.security/cib_test/CSH.des';
    var $csh_file = '../cib.security/cib/CSH.des';    //ÉLES
    
    var $rc = '';
    
    var $debug = true;

    function __construct($language, $currency){
        
        global $lang;
        
        $this->lang = $language;
        $this->cur = $currency;
        if ($this->cur=='HUF') $this->pid = 'CSH0001'; else $this->pid = 'CSH1001';
        $this->redir = "http://".$_SERVER['HTTP_HOST']."/".$lang->defaultLangStr."/".$lang->_tranzakcio."/";
        
    }
    
    function wecho($str){
        
        $f = fopen("cib/log.txt", "a");
        fwrite ($f, $str."\n");
        fclose($f);
        
    }
    
    function msg10($id, $trid, $uid, $amo, $timestamp){
        
        global $func;
        
        if ($this->debug) $this->wecho("<div style=\"background-color:red;color:white\">MSG10</div>");

        $sql = "INSERT INTO bank_tranzakciok (id_megrendeles_fej, id_felhasznalo, datum, ip_cim, trid, uid, amo, cur, ts) VALUES ($id, ".(int)$_SESSION['felhasznalo']['id'].", NOW(), '".$func->getIpAddress()."', $trid, '$uid', '$amo', '$this->cur', '$timestamp')";
        
        if (!mysql_query($sql) && $this->debug) $this->wecho($sql." - ".mysql_error());
        
        $params = 'PID='.$this->pid.'&CRYPTO='.$this->crypto.'&MSGT=10&TRID='.$trid.'&UID='.$uid.'&AMO='.urlencode($amo).'&CUR='.$this->cur.'&TS='.$timestamp.'&AUTH='.$this->auth.'&LANG='.$this->lang.'&URL='.$this->redir;
        
        $osszeallitott_url = $this->redir.$params;
        if ($this->debug) $this->wecho("Összeállatott URL:<br>".$osszeallitott_url."<hr>");
        
        $out = $this->ekiEncodeUrl($params, $this->csh_file);
        if ($this->debug) $this->wecho("Kódolt URL:<br>".$this->url.$out."<hr>");

        $lines = $this->get_web_page($this->url.$out, "");
        if ($this->debug) $this->wecho("Válasz üzenet:<br>".$lines."<hr>");

        $out = $this->ekiDecodeUrl($lines, $this->csh_file);
        if ($this->debug) $this->wecho("Dekódolt válasz:<br>".$out."<hr>");

        parse_str($out, $parse);
        $this->rc = $parse;
                
        if ($parse['RC'] == "00") {

            $pp = "MSGT=20&TRID=".$trid."&PID=".$this->pid;
            if ($this->debug) $this->wecho("Összeállított paraméterek:<br>".$pp."<hr>");

            $outt = $this->ekiEncodeUrl($pp, $this->csh_file);

            if ($this->debug) $this->wecho('Vásárló URL:<br><a href="'.$this->url2.$outt.'">'.$this->url2.$outt.'</a>');

            return $this->url2.$outt;

        }else{

            return "";

        }

    }
    
    function msg32 ($trid, $amo){
        
        if ($this->debug) $this->wecho("<div style=\"background-color:red;color:white\">MSG32</div>");

        $params = 'PID='.$this->pid.'&CRYPTO='.$this->crypto.'&MSGT=32&TRID='.$trid.'&AMO='.urlencode($amo);
        
        if ($this->debug) $this->wecho("Összeállatott paraméterek:<br>".$params."<hr>");
        
        $out = $this->ekiEncodeUrl($params, $this->csh_file);
        if ($this->debug) $this->wecho("Kódolt paraméterek:<br>".$out."<hr>");

        $lines = $this->get_web_page($this->url.$out, "");
        if ($this->debug) $this->wecho("Válasz üzenet:<br>".$lines."<hr>");

        $out = $this->ekiDecodeUrl($lines, $this->csh_file);
        if ($this->debug) $this->wecho("Dekódolt válasz:<br>".$out."<hr>");

        parse_str($out, $parse);
        
        return $parse;

    }
    
    function msg33 ($trid, $amo){
        
        if ($this->debug) $this->wecho("<div style=\"background-color:red;color:white\">MSG33</div>");

        $params = 'PID='.$this->pid.'&CRYPTO='.$this->crypto.'&MSGT=33&TRID='.$trid.'&AMO='.urlencode($amo);
        
        if ($this->debug) $this->wecho("Összeállatott paraméterek:<br>".$params."<hr>");
        
        $out = $this->ekiEncodeUrl($params, $this->csh_file);
        if ($this->debug) $this->wecho("Kódolt paraméterek:<br>".$out."<hr>");

        $lines = $this->get_web_page($this->url.$out, "");
        if ($this->debug) $this->wecho("Válasz üzenet:<br>".$lines."<hr>");

        $out = $this->ekiDecodeUrl($lines, $this->csh_file);
        if ($this->debug) $this->wecho("Dekódolt válasz:<br>".$out."<hr>");

        parse_str($out, $parse);
        
        return $parse;

    }
    
    function getHistory ($trid, $amo){
        
        if ($this->debug) $this->wecho("<div style=\"background-color:red;color:white\">GET_HISTORY</div>");

        $params = 'PID='.$this->pid.'&CRYPTO='.$this->crypto.'&MSGT=37&TRID='.$trid.'&AMO='.urlencode($amo);
        
        if ($this->debug) $this->wecho("Összeállatott paraméterek:<br>".$params."<hr>");
        
        $out = $this->ekiEncodeUrl($params, $this->csh_file);
        if ($this->debug) $this->wecho("Kódolt paraméterek:<br>".$out."<hr>");

        $lines = $this->get_web_page($this->url.$out, "");
        if ($this->debug) $this->wecho("Válasz üzenet:<br>".$lines."<hr>");

        $out = $this->ekiDecodeUrl($lines, $this->csh_file);
        if ($this->debug) $this->wecho("Dekódolt válasz:<br>".$out."<hr>");

        parse_str($out, $parse);
        
        return $parse["HISTORY"];

    }
    
    function getData($url){
        
        if ($this->debug) $this->wecho("<div style=\"background-color:red;color:white\">GET_DATA</div>");

        $out = $this->ekiDecodeUrl($url, $this->csh_file);
        if ($this->debug) $this->wecho("Dekódolt válasz:<br>".$out."<hr>");

        parse_str($out, $parse);
        $this->rc = $parse;

        return $parse;
                
    }
    
    function getMessage(){
        
        $message = array(
            "01" => "Hiba a kódolásnál"
        );      
        
        $rtn = $message[$this->rc["RC"]];
        
        return $rtn==""?"Ismeretlen hiba":$rtn;
        
    }
    
    
    
    
    
    function get_web_page( $url, $curl_data )
    {

	ob_start();

        $ch      = curl_init($url);

	curl_exec($ch);

	curl_close($ch);

	$retrievedhtml = ob_get_contents();

	ob_end_clean();

        return $retrievedhtml;
    }

/*
        Titkosítás a saki protokoll alapján

        Paraméterek:

        	$plaintext: a titkosítandó string
        	$keyfile: a titkosításhoz szükséges kulcsfile neve

        Visszatérõ érték:

            A titkosított üzenet

    */

    function ekiEncodeUrl($plaintext,$keyfile)
    {
        
        if ($plaintext=="") return false;
        
        $f=fopen($keyfile,"r");
        $keyinfo=fread($f,38);
        fclose($f);
        $k1=substr($keyinfo,14,8);
        $k2=substr($keyinfo,22,8);
        $iv=substr($keyinfo,30,8);
        $key=$k1.$k2.$k1;
        $arr=split("&",$plaintext);
        $outs="";
        $pid="";
        for ($i=0;$i<count($arr);$i++)
        {
            if (strtoupper($arr[$i])!="CRYPTO=1")
                $outs.="&".$arr[$i];
            if (substr(strtoupper($arr[$i]),0,4)=="PID=")
                $pid=substr(strtoupper($arr[$i]),4,7);
        }
        $outs=substr($outs,1);
        $outs=rawurlencode($outs);
        $outs=str_replace("%3D","=",$outs);
        $outs=str_replace("%26","&",$outs);
        $crc=str_pad(dechex(crc32($outs)),8,"0",STR_PAD_LEFT);
        for ($i=0;$i<4;$i++)
            $outs.=chr(base_convert(substr($crc,$i*2,2),16,10));
        $pad=8-(strlen($outs) % 8);
        for ($i=0;$i<$pad;$i++)
            $outs.=chr($pad);
        $td=mcrypt_module_open("tripledes","","cbc","");
        mcrypt_generic_init($td,$key,$iv);
        $outs=mcrypt_generic($td,$outs);
        mcrypt_module_close($td);
        $pad=3-(strlen($outs) % 3);
        for ($i=0;$i<$pad;$i++)
            $outs.=chr($pad);
        $outs=base64_encode($outs);
        $outs=rawurlencode($outs);
        $outs="PID=".$pid."&CRYPTO=1&DATA=".$outs;
        return $outs;
    }

    /*
        Kititkosítás a saki protokoll alapján

        Paraméterek:

        	$crypto: a kititkosítandó string
        	$keyfile: a titkosításhoz szükséges kulcsfile neve

        Visszatérõ érték:

            A kititkosított üzenet, vagy crc hiba esetén üres string

    */

		function ekiDecodeUrl($crypto,$keyfile)
    {

        if ($crypto=="") return false;

        $f=fopen($keyfile,"r");
		$keyinfo=fread($f,38);
        fclose($f);
        $k1=substr($keyinfo,14,8);
        $k2=substr($keyinfo,22,8);
        $iv=substr($keyinfo,30,8);
        $key=$k1.$k2.$k1;
        $arr=split("&",$crypto);
        $outs="";
        $pid="";
        for ($i=0;$i<count($arr);$i++)
        {
            if (substr(strtoupper($arr[$i]),0,5)=="DATA=")
                $outs=substr($arr[$i],5);
            if (substr(strtoupper($arr[$i]),0,4)=="PID=")
                $pid=substr(strtoupper($arr[$i]),4,7);
        }
        $outs=rawurldecode($outs);
        $outs=base64_decode($outs);
        $lastc=ord($outs[strlen($outs)-1]);
        $validpad=1;
        for ($i=0;$i<$lastc;$i++)
            if (ord(substr($outs,strlen($outs)-1-$i,1))!=$lastc)
                $validpad=0;
        if ($validpad==1)
            $outs=substr($outs,0,strlen($outs)-$lastc);
        $td=mcrypt_module_open("tripledes","","cbc","");
        mcrypt_generic_init($td,$key,$iv);
        $outs=mdecrypt_generic($td,$outs);
        mcrypt_module_close($td);
        $lastc=ord($outs[strlen($outs)-1]);
        $validpad=1;
        for ($i=0;$i<$lastc;$i++)
            if (ord(substr($outs,strlen($outs)-1-$i,1))!=$lastc)
                $validpad=0;
        if ($validpad==1)
            $outs=substr($outs,0,strlen($outs)-$lastc);
        $crc=substr($outs,strlen($outs)-4);
        $crch="";
        for ($i=0;$i<4;$i++)
            $crch.=str_pad(dechex(ord($crc[$i])),2,"0",STR_PAD_LEFT);
        $outs=substr($outs,0,strlen($outs)-4);
				$crc=str_pad(dechex(crc32($outs)),8,"0",STR_PAD_LEFT);
        if ($crch!=$crc)
            return "";
        $outs=str_replace("&","%26",$outs);
        $outs=str_replace("=","%3D",$outs);
        $outs=rawurldecode($outs);
        $outs="CRYPTO=1&".$outs;
        return $outs;
    }
 
}
?>