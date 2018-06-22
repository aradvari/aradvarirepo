<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">

<?php
  if (ISSET($_POST['modosit'])){
    mysql_query("DELETE FROM termekkapcsolatok WHERE kategoriaid=".$_POST['kategoria']);
	for ($go=1; $go<=$_POST['rows']; $go++){
	  if (ISSET($_POST['checkbox'.$go])){mysql_query('INSERT INTO termekkapcsolatok SET kategoriaid='.$_POST['kategoria'].', kapcsolat='.$_POST['checkbox'.$go]);}
	}
  }
?>

            <form name="kategoriamodositas2" method="post" action="">
              <table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td><table width="466" border="0" cellspacing="1" cellpadding="6">
                    <tr>
                      <td width="161" class="darkCell">Kiválasztott kategória:</td>
                      <td width="278" class="lightCell">
                        <select name="kategoria" class="form" id="kategoria" onChange="document.kategoriamodositas2.submit();">
                          <?php
				if (!ISSET($_POST['kategoria'])){echo('<option value="">Válasszon</option>');}
				  $query = mysql_query("SELECT * FROM kategoriak WHERE szulo=0");
				  while ($adatok=mysql_fetch_array($query)){
				    $alquery = mysql_query("SELECT * FROM kategoriak WHERE szulo=".$adatok[0]);
				    while ($aladatok=mysql_fetch_array($alquery)){
					  echo('<option value="'.$aladatok[0].'" '.(ISSET($_POST['kategoria'])?($_POST['kategoria']==$aladatok[0]?'SELECTED':''):'').'>'.$adatok[1].'->'.$aladatok[1].'</option>');
 				    }
				  }
				?>
                        </select>
                      </a></td>
                    </tr>
                    <tr>
                      <?php
				    if (ISSET($_POST['kategoria'])){
					echo(' <td valign="top" class="darkCell">Csatolt kategória:</td><td class="lightCell"><table width="100%" border="0" cellspacing="2" cellpadding="2">');
					$query = mysql_query("SELECT * FROM kategoriak WHERE szulo=0"); $num=0;
				    while ($adatok=mysql_fetch_array($query)){
				      $alquery = mysql_query("SELECT * FROM kategoriak WHERE szulo=".$adatok[0]);
				      while ($aladatok=mysql_fetch_array($alquery)){
						$qr=mysql_query("SELECT * FROM termekkapcsolatok WHERE kategoriaid=".$_POST['kategoria']);$oldnum=$num;
						while ($ertekek=mysql_fetch_array($qr)){
						  if ($ertekek[2]==$aladatok[0]){
						    $num++;echo('<tr><td width="15%"><div align="center"><input type="checkbox" name="checkbox'.$num.'" value="'.$aladatok[0].'" class="form" checked="checked"></div></td><td width="85%" class="mediumCell"> '.$adatok[1].'->'.$aladatok[1].'</td></tr>');
						  }
						}
						if ($num==$oldnum){$num++;echo('<tr><td width="15%"><div align="center"><input type="checkbox" name="checkbox'.$num.'" value="'.$aladatok[0].'" class="form"></div></td><td width="85%" class="mediumCell"> '.$adatok[1].'->'.$aladatok[1].'</td></tr>');}
				      }
 				    }
					  echo('<input type="hidden" value="'.$num.'" name="rows" id="rows">');echo('</table></td></tr><tr><td colspan="2" class="darkCell"><p><input name="modosit" type="submit" class="form" id="modosit" value="módosítás"></p></td></tr>');
					}
				  ?>
                                    </table></td>
                </tr>
              </table>
            </form>			