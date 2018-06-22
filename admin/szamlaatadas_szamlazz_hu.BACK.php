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


$fizetesi_modok = array(1=>"Utánvét", 2=>"Bankkártyás fizetés", 3=>"Készpénz");

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
$response=';;Számlázási cím;;;;;;;Levelezési cím;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;Partner megnevezése:;Irányítószám;Település;Utca, házszám;Fizetési mód;Kelt;Teljesítés;Fizetési határidõ;Név;Irányítószám;Település;Utca, házszám;Megjegyzés;Szállító bankszámlaszáma;Email;Nyelv;Logófájl neve;Rendelésszám;Partner adószáma;Vevõ fõkönyvi szám;Vevõ fõkönyvi azonosító;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;Tétel megnevezés;Mennyiség;Mennyiségi egység;Nettó egységár;Áfakulcs;Tétel nettó;Tétel áfa;Tétel bruttó;Tétel megjegyzés;Árbevétel fõkönyvi szám;Áfa fõkönyvi szám;Gazdasági esemény azonosító;Áfa gazdasági esemény azonosító;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
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
					//;Alap csomag havidíj;1;db;3325;27;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
					
					$tetel_teljes_nev = $tetel[0].' - '.$tetel[1].' '.$tetel[2];

					if (($tetel[3]) && ($tetel[3]!=='-')) $tetel_teljes_nev .= ' '.$tetel[3];		//	szin, ha meg van adva
					if (($tetel[4]) && ($tetel[4]!=='-')) $tetel_teljes_nev .= ' ('.$tetel[4].')';		//	(meret), ha meg van adva
					
					$tetel_netto = $tetel[5]/1.27;
					$tetel_afa = $tetel[5] - $tetel_netto;
					
					$tetel_netto = round($tetel_netto);
					$tetel_afa = round($tetel_afa);
					
					$tetel_brutto = $tetel[5];
					
					$afakulcs = 27;
					
					
					
					//$response .= ';'.$tetel_teljes_nev.';1;db;'.$tetel_netto.';'.$afakulcs.';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					
					//Nettó egységár;Áfakulcs;Tétel nettó;Tétel áfa;Tétel bruttó;
					//780;27;780;210;990;
					
					$response .= ';'.$tetel_teljes_nev.';1;db;'.$tetel_netto.';'.$afakulcs.';'.$tetel_netto.';'.$tetel_afa.';'.$tetel_brutto.';(EAN - '.$tetel[6].');911;467;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					
					$response .= "\n";
					}
					
					// giftcard, kupon osszeg, ha van
					if($adatok[9]>0)	{
						
						$kedvezmeny_brutto = $adatok[9];
					
						$kedvezmeny_netto = round($kedvezmeny_brutto/1.27);
						
						$kedvezmeny_afa = round($kedvezmeny_brutto - $kedvezmeny_netto);
					
					$response .= ';Kuponkód kedvezmény;1;db;'.$kedvezmeny_netto.';'.$afakulcs.';'.($kedvezmeny_netto*-1).';'.($kedvezmeny_afa*-1).';'.($kedvezmeny_brutto*-1).';;911;467;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					$response .= "\n";
					}
					
					
					// szallitasi dij, ha van
					if($adatok[7]>0)	{
					$response .= ';Szállítási díj;1;db;780;27;780;210;990;;911;467;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;';
					$response .= "\n";
					}
		
}


// convert UTF-8 to ANSI
$response = iconv("ISO-8859-1", "WINDOWS-1252", $response);

$datetime=date('Ymd-Hi');

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

header("Content-disposition: attachment; filename=szamlazzhu-".$datetime.".csv");    

$ph = $response;

header("Content-length: ".strlen($ph));

print $ph;


ob_end_flush();

die();

?>