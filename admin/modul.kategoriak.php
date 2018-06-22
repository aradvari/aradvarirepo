<br>
<script src="js/shop.js" type="text/javascript"></script>

<?
    require_once("category.class.php");
   
    $categorys = new categorys();
    
    if ($_POST['ujkategoria']!=''){
        
        $id = (int)$_POST['ujkategoria_szulo'];
        
        $sz = mysql_result(mysql_query("SELECT max(sorrend)+1 FROM kategoriak WHERE sztorno IS NULL AND szulo='$id'"), 0);
        if (empty($sz)) $sz = 1;
        
        mysql_query ("INSERT INTO kategoriak (megnevezes, szulo, publikus, sorrend) VALUES ('".trim(($_POST['ujkategoria']))."', '$id', ".(int)$_POST['ujkategoria_p'].", '$sz')");
    
    }

    if (ISSET($_POST['delid'])){

        $search = mysql_num_rows(mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo = '".(int)$_POST['delid']."'"));
        
        if ($search>0){
            
            $user->error='A megadott kategória nem törölhető, mert alkategóriák vannak hozzárendelve!';
            
        }else{
            
            mysql_query("UPDATE kategoriak SET sztorno=NOW() WHERE id_kategoriak = '".(int)$_POST['delid']."'");
            $user->error='A kategória törlése sikeres volt.';
            
        }
        
    }
    
    if (ISSET($_POST['orderId'])){
    
        //var_dump($_POST); echo '<br>';

        if ($_POST['orderId']>1 && $_POST['option']=='up'){
            
            $tomb=array(); $num=0;
            
            $query = mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo = '".(int)$_POST['parentId']."' AND id_kategoriak != '".(int)$_POST['id']."' ORDER BY sorrend");
            
            while ($adatok = mysql_fetch_array($query)){
            
                $num++;
                
                if ($num==((int)$_POST['orderId']-1)){
                
                    $tomb[] = $_POST['id'];
                }
                
                $tomb[] = $adatok['id_kategoriak'];
                
            }
            
            //Ujra sorrendezés
            $num=0;
            while ($adatok = each($tomb)){
                
                $num++;
                
                mysql_query ("UPDATE kategoriak SET sorrend=$num WHERE id_kategoriak=$adatok[1]");
                
            }

            $user->error='A megadott kategória a felsorolásban feljebb került!';
            
        }elseif ($_POST['option']=='down' && $_POST['orderId']<mysql_result(mysql_query("SELECT max(sorrend) FROM kategoriak WHERE sztorno IS NULL AND szulo = '".(int)$_POST['parentId']."'"), 0)){
            
            $tomb=array(); $num=0;
            
            $query = mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo = '".(int)$_POST['parentId']."' AND id_kategoriak != '".(int)$_POST['id']."' ORDER BY sorrend");
            
            while ($adatok = mysql_fetch_array($query)){
            
                $num++;
                
                $tomb[] = $adatok['id_kategoriak'];

                if ($num==((int)$_POST['orderId'])){
                
                    $tomb[] = $_POST['id'];
                }
                
            }
            
            //Ujra sorrendezés
            $num=0;
            while ($adatok = each($tomb)){
                
                $num++;
                
                mysql_query ("UPDATE kategoriak SET sorrend=$num WHERE id_kategoriak=$adatok[1]");
                
            }

            $user->error='A megadott kategória a felsorolásban lejjebb került!';
            
            
        }else{

            $user->error='A megadott kategória nem mozgatható a kiválasztott irányba!';
        
        }
        
    }

    
    if (ISSET($_POST['modify'])){
    
        //Adatok módosítása
        $keys = array_keys($_POST);
        foreach ($keys as $adatok){
            
            if (strstr($adatok, 'megnevezes')){
                
                $exp = explode("_", $adatok);
                $id = $exp[1];
                $value = $_POST[$adatok];
                
                if ($value<>'') {
                 
                    mysql_query ("UPDATE kategoriak SET megnevezes='".($value)."' WHERE id_kategoriak='$id'");
                    
                }
                
            }

            if (strstr($adatok, 'szulo')){
                
                $exp = explode("_", $adatok);
                $id = $exp[1];
                $value = $_POST[$adatok];
                
                if ($value<>'') {
                 
                    mysql_query ("UPDATE kategoriak SET szulo='$value' WHERE id_kategoriak='$id'").'<br>';
                    
                }
                
            }

            if (strstr($adatok, 'publikus')){
                
                $exp = explode("_", $adatok);
                $id = $exp[1];
                $value = $_POST[$adatok];
                
                if ($value<>'') {
                 
                    mysql_query ("UPDATE kategoriak SET publikus='$value' WHERE id_kategoriak='$id'").'<br>';
                    
                }
                
            }

        }

        $categorys->sortCategorys();
        $user->error='A módosítások sikeresek voltak.';
        
    }

?>

<script>
    
    function delCategory(str){
    
        if (confirm("Valóban törli véglegesen a kategóriát?")){

            document.delCatForm.delid.value=str;
            document.delCatForm.submit();

        }
        
    }
    
    function moveCategory(id, orderid, option, parentid){
    
        document.catMoveForm.id.value=id;
        document.catMoveForm.orderId.value=orderid;
        document.catMoveForm.option.value=option;
        document.catMoveForm.parentId.value=parentid;
        document.catMoveForm.submit();
        
    }
    
</script>

<form method="post" name="delCatForm" id="delCatForm">
    <input type="hidden" id="delid" name="delid" />
</form>

<form method="post" name="catMoveForm" id="catMoveForm">
    <input type="hidden" id="id" name="id" />
    <input type="hidden" id="orderId" name="orderId" />
    <input type="hidden" id="option" name="option" />
    <input type="hidden" id="parentId" name="parentId" />
</form>

<form method="post">

<table border="0" cellpadding="3" cellspacing="1">
<tr id="header" height="25">
    <td style="width: 20px;" class="darkCell">&nbsp;</td>
    <td style="width: 190px;" class="darkCell">Kategória megnevezése</td>
    <td style="width: 250px;" class="darkCell">Szülő kategória</td>
    <td style="width: 80px;" class="darkCell">Alkategória</td>
    <td style="width: 70px;" class="darkCell">Publikus</td>
    <td style="width: 25px;" class="darkCell">&nbsp;</td>
    <td style="width: 45px;" class="darkCell">Sorrend</td>
</tr>
<?
    
   if (!ISSET($_GET['sc'])) $sc=0;
   else $sc = (int)$_GET['sc'];

   $sql = "SELECT * FROM kategoriak WHERE id_kategoriak=".$sc;
   $query = mysql_fetch_array(mysql_query($sql));
   $szulo = $query['szulo'];

?>
<tr style="background-color:#7CA4CE; height:25px;">
    <td align="center">
    <?
    
        if ($szulo!=null) echo '<img onclick="document.location.href=\'index.php?lap=kategoriak&sc='.$szulo.'\'" style="cursor:pointer" src="images/icons/back.png" width="13" alt="visszalépés egy szintet">';
    
    ?>
    </td>
    <td><input type="text" style="width:180px" value="" name="ujkategoria"><input type="hidden" value="<?=$sc?>" name="ujkategoria_szulo"></td>
    <td align="left" style="color:white; font-size: 11px;">&nbsp;<?=$query['megnevezes']==''?'Főkategóriába':'<b>'.$query['megnevezes'].'</b> kategóriába'?></td>
    <td></td>
    <td><?=$categorys->createArraySelectBox(array(1=>"Igen",2=>"Nem"), 0,  "name=\"ujkategoria_p\"", "");?></td>
    <td align="center"><input type="image" name="ujkategoria_hozzaadas" src="images/icons/add.png" alt="kategória hozzáadása" style="background-color:#7ca4ce"></td>
    <td></td>
</tr>
<?

   echo $categorys->createMenu($sc);

?>

<tr>
    <td colspan="7" class="lightCell">
        <input type="submit" class="submitSt" name="modify" value="Módosítások mentése">
    </td>
</tr>

</table>
    
    
</form>

<?

    //if (!empty($user->error)) echo "<script>alert('".$user->error."', false);</script>";

?>
