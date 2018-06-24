<?

ini_set("display_errors", 0);

if(isset($_POST['login_once']))	{	
	
	// teljes nev elvalasztas
	if(!empty($_POST['teljes_nev']))	{			
	
			$teljes_nev=explode(" ", $_POST['teljes_nev']);
			$_POST['vezeteknev']=$teljes_nev[0];
			$_POST['keresztnev']=$teljes_nev[1];	
			$_POST['keresztnev'].= ' '.$teljes_nev[2];	
			$_POST['keresztnev'].= ' '.$teljes_nev[3];	
			$_POST['keresztnev'].= ' '.$teljes_nev[4];	
			$_POST['keresztnev'].= ' '.$teljes_nev[5];	
			
			if ( strlen( $teljes_nev[0] ) >= 2 )	{
				
				if (  strlen( $teljes_nev[1] ) >3 )		{
				
					if(!empty($_POST['iranyitoszam']))	{
					
					
						// utca kozterulet elvalasztas
						if(!empty($_POST['utcanev']))	{
							
							
							$kozterulet_nev = mysql_fetch_array(mysql_query('SELECT megnevezes FROM kozterulet WHERE id_kozterulet='.$_POST['kozterulet']));
							
								
							if(empty($_POST['hazszam'])) $hiba[]="Házszám megadása kötelező!";
							
							
							// email check
							if(!empty($_POST['email']))	{

									if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_POST['email']))
										$hiba[]='Az e-mail cím formátuma nem megfelelő!';
									
							
									//tel check
									if ( (!empty($_POST['telefonszam1_1'])) && (!empty($_POST['telefonszam1_2'])) )	{
									
										
										$tel1 = $_POST['telefonszam1_0']." ".$_POST['telefonszam1_1']." ".$_POST['telefonszam1_2'];
										
										if ( (!empty($_POST['telefonszam2_1'])) && (!empty($_POST['telefonszam2_2'])) )
											$tel2 = $_POST['telefonszam2_0']." ".$_POST['telefonszam2_1']." ".$_POST['telefonszam2_2'];
										
										}							
								
								else
									$hiba[]='Telefonszám megadása kötelező!';
									// end of tel check
							
							}
							
							else
									$hiba[]='E-mail cím megadása kötelező!';
									// endof email check
							
							
							
						}

					else	
						$hiba[]="Utcanév megadása kötelező!";							
					
					}
				
				else
					$hiba[]="Irányítószám megadása kötelező!";
				
				}
			
			else
					$hiba[]="A keresztnév túl rövid!";
			
			}
			
			else
					$hiba[]="A vezetéknév túl rövid!";

		}
			
		else	
			$hiba[]="Név megadása kötelező!";
	
			
	$_POST['orszag']=1;		// Magyarorszag
	$orszag_nev='Magyarország';
	$megye_nev = @mysql_result(@mysql_query("SELECT megye_nev FROM megyek WHERE id_megye=".(int)$_POST['megye']), 0);  
	$varos_nev = @mysql_result(@mysql_query("SELECT helyseg_nev FROM helyseg WHERE id_helyseg=".(int)$_POST['varos']), 0);  		
	$_POST['jelszo']='nopassword';		//egyszeri vasarlashoz ugyanaz a reg. jelszo
	$aktivacios_kod='login_once';
	

	// insert
	$query = "
                    INSERT INTO felhasznalok
                    (vezeteknev,
                     keresztnev,
                     cegnev,
                     orszag_nev,
                     id_orszag,
                     irszam,
                     id_megye,
                     megye_nev,
                     id_varos,
                     varos_nev,
                     utcanev,
                     id_kozterulet,
                     kozterulet_nev,
                     hazszam,
                     emelet,
                     email,
                     telefonszam1,
                     telefonszam2,
                     jelszo,
                     hirlevel,
                     aktivacios_kod,
                     regisztralva)
                     VALUES
                     ('".$func->upperFirstChars($_POST['vezeteknev'])."',
                     '".$func->upperFirstChars($_POST['keresztnev'])."',
                     '".trim($_POST['cegnev'])."',
                     '$orszag_nev',
                     ".(int)$_POST['orszag'].",
                     '".trim($_POST['iranyitoszam'])."',
                     ".(int)$_POST['megye'].",
                     '$megye_nev',
                     ".(int)$_POST['varos'].",
                     '$varos_nev',
                     '".$func->upperFirstChars($_POST['utcanev'])."',
                     ".(int)$_POST['kozterulet'].",
                     '$kozterulet_nev[0]',
                     '".trim($_POST['hazszam'])."',
                     '".trim($_POST['emelet'])."',
                     '".trim($_POST['email'])."',
                     '$tel1',
                     '$tel2',                     
                     '".md5($_POST['jelszo'])."',
                     ".(ISSET($_POST['hirlevel'])?1:0).",
                     '$aktivacios_kod',
                     NOW())
                ";
				
				
				if(empty($hiba))	{	
					
					//echo nl2br($query);
					if (mysql_query($query))	{
						echo $user->loginUser($_POST['email'], $_POST['jelszo']);
						header("Location: /".$lang->defaultLangStr."/".$lang->_megrendeles); die();
						}
				}
	}				
	
?>

<!-- login_once -->
<div class="login_once">

<form action="" method="POST" autocomplete="on">

<input type="hidden" name="login_once" id="login_once" value=1 />

<?
if(!empty($hiba))	{
	foreach ($hiba as $hibauzenet)
		//echo '<p class="alert_red" style="color:#fff;background:none;padding:10px;margin-bottom:4px;">'.$hibauzenet.'</p>';
		echo '<div class="alertbox">'.$hibauzenet.'</div>';
	}
?>

<p>Megrendelés regisztráció nélkül</p>

<!-- <p>Név</p> -->
<input type="text" name="teljes_nev" id="teljes_nev" placeholder="<?=$lang->Vezeteknev?> <?=$lang->Keresztnev?>" value="<?=$_POST['teljes_nev'];?>" onChange="document.getElementById('iranyitoszam').focus();" style="text-transform:capitalize;" />


<p><?=$lang->Szallitasi_cim?></p>

<?
/*
// ORSZAG
if(!($_POST['orszag'])) $_POST['orszag']=1;	//default
	echo $func->createSelectBox("SELECT id_orszag, nyelvi_kulcs FROM orszag ORDER BY id_orszag", $_POST['orszag'], "name=\"orszag\" id=\"orszag\" onchange=\"changeOrszag(this.options[this.selectedIndex].value)\" style=\"width:61%;\" "); */
?>

<input type="text" name="iranyitoszam" id="iranyitoszam" 
onChange="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv'); document.getElementById('utcanev').focus();" 
onKeyup="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv');" 
onKeydown="getWhitePostCode(this.value, $('megye'), 'varos', 'helysegekdiv');" 
placeholder="<?=$lang->Iranyitoszam?>" 
value="<?=$_POST['iranyitoszam']?>"
maxlength="4" style="width:30%;" />

<?
// megye select nem lathato
echo $func->createSelectBox("SELECT * FROM megyek ORDER BY megye_nev",$_POST['megye'], "readonly name=\"megye\" id=\"megye\"  
onchange=\"divHelysegek('helysegekdiv', this.options[this.selectedIndex].value, 'varos') document.getElementById('utcanev').focus(); \" style=\"width:67%;v_isibility:hidden;\" ", "Válassz megyét");
?>

<div id="helysegekdiv"></div>

<?php /* if (isset($_POST['megye'])) { ?>
<script language="javascript">
	//divHelysegek('helysegekdiv', <?=$_POST['megye']; ?>, 'varos');
	getWhitePostCode(<?=$_POST['iranyitoszam'] ?>, $('megye'), 'varos', 'helysegekdiv');
</script>
<?php } */?>

<br />

<input type="text" id="utcanev" name="utcanev" placeholder="Utcanév *" value="<?=$_POST['utcanev'] ?>" maxlength="100" style="width:44%;text-transform:capitalize;">
<?	echo $func->createSelectBox("SELECT * FROM kozterulet ORDER BY megnevezes", 6,"name=\"kozterulet\" style=\" width:28%; \" ");	?>
<input type="text" id="hazszam" name="hazszam" placeholder="Házszám *" value="<?=$_POST['hazszam'] ?>" maxlength="10" size="5" style="width:26%; float:right">
<input type="text" id="emelet" name="emelet" value="<?=$_POST['emelet'];?>" placeholder="<?=$lang->Emelet_ajto_egyeb;?>"  maxlength="20">

<p>Elérhetőség</p>
<input type="text" name="email" id="email" placeholder="<?=$lang->Email_cim?>" value="<?=$_POST['email']?>" onChange="document.getElementById('telefonszam1_1').focus();" style="text-transform:none;" />
<!-- <input type="text" name="tel" id="tel" placeholder="<?=$lang->Telefonszam?> (Pl.: 06 30 555 1234)" value="<?=$_POST['tel']?>" /> -->

<?
// tel
if(!isset($_POST['telefonszam1_0'])) $_POST['telefonszam1_0']="+36";
if(!isset($_POST['telefonszam2_0'])) $_POST['telefonszam2_0']="+36";
?>
<?=$lang->Telefonszam?> 1
<br />
<input type="text" name="telefonszam1_0" id="telefonszam1_0" value="<?=$_POST['telefonszam1_0']?>" size="3" maxlength="4" style="width:20%;" />
<input type="text" name="telefonszam1_1" id="telefonszam1_1" value="<?=$_POST['telefonszam1_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==2) $('telefonszam1_2').focus()" style="width:20%;">
<input type="text" name="telefonszam1_2" id="telefonszam1_2" value="<?=$_POST['telefonszam1_2']?>" maxlength="7" onkeyup="if (this.value.length==7) $('telefonszam2_1').focus()" style="float:right; width:58%;">

<br />

<?=$lang->Telefonszam?> 2 (<?=$lang->nem_kotelezo?>)
<br />
<input type="text" name="telefonszam2_0" id="telefonszam2_0" value="<?=$_POST['telefonszam2_0']?>" size="3" maxlength="4" style="width:20%;" />
<input type="text" name="telefonszam2_1" id="telefonszam2_1" value="<?=$_POST['telefonszam2_1']?>" size="3" maxlength="3" onkeyup="if (this.value.length==2) $('telefonszam2_2').focus()" style="width:20%;">
<input type="text" name="telefonszam2_2" id="telefonszam2_2" value="<?=$_POST['telefonszam2_2']?>" maxlength="7" style="float:right; width:58%;">



<? if( !$func->isMobile() )	{ ?>
<br />
<br />
<label><input type="checkbox" name="hirlevel" checked > <?=$lang->Feliratkozom_a_hirlevelre?></label>
<br />
<label><input type="checkbox" name="aszf" checked > Elfogadom az <a href="/hu/altalanos-szerzodesi-feltetelek" target="_blank">Általános szerződési feltételeket</a> (<a href="/coreshop_aszf.pdf" target="_blank">&dArr; PDF</a>)</label>

<br />
<br />
<? } ?>

<input type="submit" value="Tovább a megrendeléshez" class="arrow_box" />

</form>

</div>
<!-- login_once vege -->