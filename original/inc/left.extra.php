<?
    $sql1 = "
        SELECT
         k1.id_kategoriak, k2.megnevezes
        FROM termekek t
        INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0 OR keszlet_2>0) )
        LEFT JOIN kategoriak k1 ON (k1.id_kategoriak = t.kategoria)
        LEFT JOIN kategoriak k2 ON (k2.id_kategoriak = k1.szulo)
        WHERE
        t.aktiv=1 AND
        t.torolve IS NULL AND
        t.opcio='UJ'
        ORDER BY k2.sorrend, k1.sorrend
        LIMIT 0, 1
    ";

    $sql2 = "
        SELECT
         k1.id_kategoriak, k2.megnevezes
        FROM termekek t
        INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0 OR keszlet_2>0) )
        LEFT JOIN kategoriak k1 ON (k1.id_kategoriak = t.kategoria)
        LEFT JOIN kategoriak k2 ON (k2.id_kategoriak = k1.szulo)
        WHERE
        t.aktiv=1 AND
        t.torolve IS NULL AND
        t.klub_termek=1
        ORDER BY k2.sorrend, k1.sorrend
        LIMIT 0, 1
    ";

    $sql3 = "
        SELECT
         k1.id_kategoriak, k2.megnevezes
        FROM termekek t
        INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0 OR keszlet_2>0) )
        LEFT JOIN kategoriak k1 ON (k1.id_kategoriak = t.kategoria)
        LEFT JOIN kategoriak k2 ON (k2.id_kategoriak = k1.szulo)
        WHERE
        t.aktiv=1 AND
        t.torolve IS NULL AND
        t.opcio='AKCIOS'
        ORDER BY k2.sorrend, k1.sorrend
        LIMIT 0, 1
    ";

    $sql4 = "
        SELECT
         k1.id_kategoriak, k2.megnevezes
        FROM termekek t
        INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0 OR keszlet_2>0) )
        LEFT JOIN kategoriak k1 ON (k1.id_kategoriak = t.kategoria)
        LEFT JOIN kategoriak k2 ON (k2.id_kategoriak = k1.szulo)
        WHERE
        t.aktiv=1 AND
        t.torolve IS NULL AND
        t.opcio='CLUB-EXCLUSIVE'
        ORDER BY k2.sorrend, k1.sorrend
        LIMIT 0, 1
    ";

    $uj = mysql_fetch_assoc(mysql_query($sql1));
    $coreclub = mysql_fetch_assoc(mysql_query($sql2));
    $akcios = mysql_fetch_assoc(mysql_query($sql3));
    $clubexclusive = mysql_fetch_assoc(mysql_query($sql4));

?>
<table>
  
  <tr><th style="background:none;padding:1px;text-align:center;border:none;"><a href="/termekek_coreclub/<?=$func->convertString($uj['megnevezes'])."/".$coreclub['id_kategoriak']?>"><img src="/images/extra-coreclub.png"></a></th></tr>

  <?

    if ($_GET['opcio']=='coreclub') {
        
        echo "<tr><td>";
        $menu->createBasicMenu("termekek_coreclub", "coreclub");
        echo "</td></tr>";
        
    }

  ?>

  <tr><th style="background:none;padding:1px;text-align:center;border:none;"><a href="/termekek_uj/<?=$func->convertString($uj['megnevezes'])."/".$uj['id_kategoriak']?>"><img src="/images/extra-uj.png"></a></th></tr>
  
  <?
  
    if ($_GET['opcio']=='uj') {
        
        echo "<tr><td>";
        $menu->createBasicMenu("termekek_uj", "uj");
        echo "</td></tr>";
        
    }
  
  ?>
  
  <tr><th style="background:none;padding:1px;text-align:center;border:none;"><a href="/termekek_akcios/<?=$func->convertString($uj['megnevezes'])."/".$akcios['id_kategoriak']?>"><img src="/images/extra-akcios.png"></a></th></tr>
  
  <?
  
    if ($_GET['opcio']=='akcios') {
        
        echo "<tr><td>";
        $menu->createBasicMenu("termekek_akcios", "akcios");
        echo "</td></tr>";
        
    }
  
  ?>

</table>

<br />
<br />