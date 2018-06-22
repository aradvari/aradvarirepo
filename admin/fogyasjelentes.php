<?
ob_start();

session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i: s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type:text/html; charset=ISO-8859-2");

require('include/login.php');

mysql_query("SET NAMES 'utf-8';");

require ("classes/functions.class.php");
$func = new functions();

/**
* A megadott statisztikai ID alapján, letöltére adja át a generált statisztikát
*/

/*
$vmi= "SELECT
mf.datum,
mf.megrendeles_szama,
mt.*
FROM megrendeles_tetel mt

LEFT JOIN megrendeles_fej mf ON (mt.id_megrendeles_fej = mf.id_megrendeles_fej)
LEFT JOIN megrendeles_statuszok ms ON (mf.id_statusz = ms.id_megrendeles_statusz) 

WHERE mf.sztorno IS NULL AND mt.sztorno IS NULL AND DATE_FORMAT(mf.datum, '%Y-%m-%d') >= DATE_FORMAT('2011-12-01', '%Y-%m-%d') AND DATE_FORMAT(mf.datum, '%Y-%m-%d') <= DATE_FORMAT('2011-12-02', '%Y-%m-%d') GROUP BY mf.id_megrendeles_fej ORDER BY mf.datum ASC";*/

//$query = mysql_query($vmi);
$query = mysql_query($_SESSION['fogyasjelentes']); 

$response='<tr>';
$i = 0;
while ($i < mysql_num_fields($query)) {
    $meta = mysql_fetch_field($query, $i);
    $response.= '<th>'.str_replace("k1", "készleten", $meta->name).'</th>';
    $i++;
}
$response.='</tr>';

while ($adatok = mysql_fetch_row($query)){
    
    $response.= '<tr>';
    while ($cell = each($adatok)){
        
        $response.= '<td>'.$cell[1].'</td>';        
        
    }
    $response.= '</tr>';
    
}

/**
* @desc HEADER-be írás
*/
//ob_start();

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");

header("Content-disposition: attachment; filename=Coreshop_fogyasjelentes_".date('Ymd').".xls");    

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

ob_end_flush();

die();

?>