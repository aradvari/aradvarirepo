<?
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=ISO-8859-2");

require('include/login.php');

mysql_query("SET NAMES 'latin2';");

require ("classes/functions.class.php");
$func = new functions();

/**
* A megadott statisztikai ID alapján, letöltésre adja át a generált statisztikát
*/
$query = mysql_query($_SESSION['gls_rendelesek']); 



$response='';
while ($adatok = mysql_fetch_row($query)){
				
		//$response.= $adatok[0].";";	// mf.id_megrendeles_fej
		$response.= $adatok[6].";";
				
		if(!empty($adatok[9]))
				$response.=$adatok[1]."- ".preg_replace( "/\r|\n/", "", $adatok[9] ).";";		// ha van megjegyzes
		
		else
				$response.=$adatok[1].";";

		$response.=
				$adatok[2].";".
				$adatok[3].";".
				$adatok[4].";".
				$adatok[5].";".
				$adatok[7].";".
				$adatok[8].";";
				
		// tetel kategoria nevek
		$kat_nev = mysql_query('SELECT k.megnevezes FROM megrendeles_tetel mt 
								LEFT JOIN termekek t ON t.id = mt.id_termek
								LEFT JOIN kategoriak k ON t.kategoria = k.id_kategoriak
								WHERE mt.id_megrendeles_fej='.$adatok[0].'
								GROUP BY k.megnevezes');
		$i=0;		
		while ($kat_nevek = mysql_fetch_array($kat_nev))	{
			
			if($kat_nevek['megnevezes'] == 'Férfi cipő') $kat_nevek['megnevezes']='Cipő';
			if($kat_nevek['megnevezes'] == 'Női cipő') $kat_nevek['megnevezes']='Cipő';			
			
			if($i>0) $response .= ', ';
			$response .= $kat_nevek['megnevezes'];			
			$i++;
		}
		
		$response .= "\n";
}


$datetime=date('Y-m-d_Hi');

/**
* @desc HEADER-be írás
*/
ob_start();

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");

header("Content-disposition: attachment; filename=GLS_import_".$datetime.".csv");    

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;

/*
header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");

header("Content-disposition: attachment; filename=GLS_".$date_time.".xls");    

$header = <<<EOH
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">

                <head>
                <meta http-equiv=Content-Type content="text/html; charset=ISO-8859-2">
                <meta name=ProgId content=Excel.Sheet>
                <!--[if gte mso 9]><xml>
                 <o:DocumentProperties>
                  <o:LastAuthor>Sriram</o:LastAuthor>
                  <o:LastSaved>2005-01-02T07:46:23Z</o:LastSaved>
                  <o:Version>10.2625</o:Version>
                 </o:DocumentProperties>
                 <o:OfficeDocumentSettings>
                  <o:DownloadComponents/>
                 </o:OfficeDocumentSettings>
                </xml><![endif]-->
                <style>
                <!--table
                    {mso-displayed-decimal-separator:"\.";
                    mso-displayed-thousand-separator:"\,";}
                @page
                    {margin:1.0in .75in 1.0in .75in;
                    mso-header-margin:.5in;
                    mso-footer-margin:.5in;}
                tr
                    {mso-height-source:auto;}
                col
                    {mso-width-source:auto;}
                br
                    {mso-data-placement:same-cell;}
                .style0
                    {mso-number-format:General;
                    text-align:general;
                    vertical-align:bottom;
                    white-space:nowrap;
                    mso-rotate:0;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    color:windowtext;
                    font-size:10.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:Arial;
                    mso-generic-font-family:auto;
                    mso-font-charset:0;
                    border:none;
                    mso-protection:locked visible;
                    mso-style-name:Normal;
                    mso-style-id:0;}
                td
                    {mso-style-parent:style0;
                    padding-top:1px;
                    padding-right:1px;
                    padding-left:1px;
                    mso-ignore:padding;
                    color:windowtext;
                    font-size:10.0pt;
                    font-weight:400;
                    font-style:normal;
                    text-decoration:none;
                    font-family:Arial;
                    mso-generic-font-family:auto;
                    mso-font-charset:0;
                    mso-number-format:General;
                    text-align:general;
                    vertical-align:bottom;
                    border:none;
                    mso-background-source:auto;
                    mso-pattern:auto;
                    mso-protection:locked visible;
                    white-space:nowrap;
                    mso-rotate:0;}
                .xl24
                    {mso-style-parent:style0;
                    white-space:normal;}
                -->
                </style>
                <!--[if gte mso 9]><xml>
                 <x:ExcelWorkbook>
                  <x:ExcelWorksheets>
                   <x:ExcelWorksheet>
                    <x:Name>Excel download</x:Name>
                    <x:WorksheetOptions>
                     <x:Selected/>
                     <x:ProtectContents>False</x:ProtectContents>
                     <x:ProtectObjects>False</x:ProtectObjects>
                     <x:ProtectScenarios>False</x:ProtectScenarios>
                    </x:WorksheetOptions>
                   </x:ExcelWorksheet>
                  </x:ExcelWorksheets>
                  <x:WindowHeight>10005</x:WindowHeight>
                  <x:WindowWidth>10005</x:WindowWidth>
                  <x:WindowTopX>120</x:WindowTopX>
                  <x:WindowTopY>135</x:WindowTopY>
                  <x:ProtectStructure>False</x:ProtectStructure>
                  <x:ProtectWindows>False</x:ProtectWindows>
                 </x:ExcelWorkbook>
                </xml><![endif]-->
                </head>

                <body link=blue vlink=purple>
                <table x:str border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;table-layout:fixed;'>
EOH;

$ph = $header.$response."</table></body></html>";

header("Content-length: ".strlen($ph));

print $ph;

*/

ob_end_flush();

die();

?>