<?
// Szamla atadas szamlazz.hu-nak

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


$fizetesi_modok = array(1=>"Ut�nv�t", 2=>"Bankk�rty�s fizet�s", 3=>"K�szp�nz");

if(!empty($_GET['id_megrendeles_fej']))	{
	
$query = mysql_query('SELECT 
				mf.id_megrendeles_fej,
				mf.szamlazasi_nev,
				mf.szamlazasi_irszam,
				mf.szamlazasi_varos,
				mf.szamlazasi_utcanev,
				mf.szamlazasi_kozterulet,
				mf.szamlazasi_hazszam,
				mf.szallitasi_dij,
				mf.id_fizetesi_mod,
				mf.giftcard_osszeg,
				bt.anum									
				FROM megrendeles_fej mf					
				LEFT JOIN bank_tranzakciok bt ON bt.id_megrendeles_fej = mf.id_megrendeles_fej					
				WHERE mf.id_megrendeles_fej='.$_GET['id_megrendeles_fej']);
}

else
	
$query = mysql_query('SELECT 
					mf.id_megrendeles_fej,
					mf.szamlazasi_nev,
					mf.szamlazasi_irszam,
					mf.szamlazasi_varos,
					mf.szamlazasi_utcanev,
					mf.szamlazasi_kozterulet,
					mf.szamlazasi_hazszam,
					mf.szallitasi_dij,
					mf.id_fizetesi_mod,
					mf.giftcard_osszeg,
					bt.anum				
					
					FROM megrendeles_fej mf
					
					LEFT JOIN bank_tranzakciok bt ON bt.id_megrendeles_fej = mf.id_megrendeles_fej
					
					WHERE mf.id_statusz=1 AND
					mf.id_szallitasi_mod=1
					
					ORDER BY mf.id_megrendeles_fej DESC
					');


// fejlec
$response=';;Sz�ml�z�si c�m;;;;;;;Levelez�si c�m;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;Partner megnevez�se:;Ir�ny�t�sz�m;Telep�l�s;Utca, h�zsz�m;Fizet�si m�d;Kelt;Teljes�t�s;Fizet�si hat�rid�;N�v;Ir�ny�t�sz�m;Telep�l�s;Utca, h�zsz�m;Megjegyz�s;Sz�ll�t� banksz�mlasz�ma;Email;Nyelv;Log�f�jl neve;Rendel�ssz�m;Partner ad�sz�ma;Vev� f�k�nyvi sz�m;Vev� f�k�nyvi azonos�t�;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;T�tel megnevez�s;Mennyis�g;Mennyis�gi egys�g;Nett� egys�g�r;�fakulcs;T�tel nett�;T�tel �fa;T�tel brutt�;T�tel megjegyz�s;�rbev�tel f�k�nyvi sz�m;�fa f�k�nyvi sz�m;Gazdas�gi esem�ny azonos�t�;�fa gazdas�gi esem�ny azonos�t�;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
';



while ($adatok = mysql_fetch_row($query))	{
	
		if($adatok[8]==1)	$fizetesi_hatarido = date('Y.m.d', strtotime('+5 day'));	// utanvet +5 nap fiz hatarido
		if($adatok[8]==2)	$fizetesi_hatarido = date('Y.m.d');							// bankkartyas, fiz hatarido 0
		
		
		if(!empty($_GET['fizetesi_mod']))			
			$fizetesi_mod = $fizetesi_modok[$_GET['fizetesi_mod']];		
		else			
			$fizetesi_mod = $fizetesi_modok[$adatok[8]];
			
			
		$response .= $adatok[0].';'.$adatok[1].';'.$adatok[2].';'.$adatok[3].';'.$adatok[4].' '.$adatok[5].' '.$adatok[6].';'.$fizetesi_mod.';'.date('Y.m.d').';'.date('Y.m.d').';'.$fizetesi_hatarido.';;;;;;;;;;;;311;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
		$response .= "\n";

		
		$tetel_query = mysql_query('SELECT
							mt.id_termek,
							m.markanev,
							mt.termek_nev,
							mt.szin,
							mt.tulajdonsag,
							mt.termek_ar,
							mt.vonalkod
							
							FROM megrendeles_tetel mt
							
							LEFT JOIN markak m ON m.id = mt.id_marka
							
							WHERE id_megrendeles_fej='.$adatok[0]);
							
		while ($tetel = mysql_fetch_row($tetel_query))	{					
					// tetel
					//;Alap csomag havid�j;1;db;3325;27;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
					
					$tetel_teljes_nev = $tetel[0].' - '.$tetel[1].' '.$tetel[2];

					if (($tetel[3]) && ($tetel[3]!=='-')) $tetel_teljes_nev .= ' '.$tetel[3];		//	szin, ha meg van adva
					if (($tetel[4]) && ($tetel[4]!=='-')) $tetel_teljes_nev .= ' ('.$tetel[4].')';		//	(meret), ha meg van adva
					
					//ha van fekhasznalt kuponkedvezmeny
					if($adatok[9]>0)	{
						
						$teljesaru_vans = mysql_fetch_array(mysql_query('SELECT markaid, akcios_kisker_ar FROM termekek WHERE id ='.$tetel[0]));

						//echo 'elotte tetel 5: '.$tetel[5].'<br /><br />';						
						
						if( ($teljesaru_vans[0]==41) && ($teljesaru_vans[1]==0) )
							$tetel[5] = $tetel[5]*0.8;
						
											
						$tetel[5] = round($tetel[5]/5) * 5;	//5 ft-ra kerekites
					}
					
					$tetel_netto = $tetel[5]/1.27;
					$tetel_afa = $tetel[5] - $tetel_netto;
					
					$tetel_netto = round($tetel_netto);
					$tetel_afa = round($tetel_afa);
					
					$tetel_brutto = $tetel[5];
					
					$afakulcs = 27;
					
					
					
					//$response .= ';'.$tetel_teljes_nev.';1;db;'.$tetel_netto.';'.$afakulcs.';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					
					//Nett� egys�g�r;�fakulcs;T�tel nett�;T�tel �fa;T�tel brutt�;
					//780;27;780;210;990;
					
					$response .= ';'.$tetel_teljes_nev.';1;db;'.$tetel_netto.';'.$afakulcs.';'.$tetel_netto.';'.$tetel_afa.';'.$tetel_brutto.';(EAN - '.$tetel[6].');911;467;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					
					$response .= "\n";
					}
					
					/*	// giftcard, kupon osszeg, ha van
					if($adatok[9]>0)	{
						
						$kedvezmeny_brutto = $adatok[9];
					
						$kedvezmeny_netto = round($kedvezmeny_brutto/1.27);
						
						$kedvezmeny_afa = round($kedvezmeny_brutto - $kedvezmeny_netto);
					
					$response .= ';Kuponk�d kedvezm�ny;1;db;'.$kedvezmeny_netto.';'.$afakulcs.';'.($kedvezmeny_netto*-1).';'.($kedvezmeny_afa*-1).';'.($kedvezmeny_brutto*-1).';;911;467;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					$response .= "\n";
					}*/
					
					
					// szallitasi dij, ha van
					if($adatok[7]>0)	{
					$response .= ';Sz�ll�t�si d�j;1;db;780;27;780;210;990;;911;467;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					$response .= "\n";
					}
		
}


// convert UTF-8 to ANSI
$response = iconv("ISO-8859-1", "WINDOWS-1252", $response);

$datetime=date('Ymd-Hi');

/**
* @desc HEADER-be �r�s
*/
ob_start();

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");     

header("Content-type: application/vnd.ms-excel");
header("Content-Transfer-Encoding: Binary");
header("Accept-Ranges: bytes");

header("Content-disposition: attachment; filename=szamlazzhu-".$datetime.".csv");    

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;


ob_end_flush();

die();

?>