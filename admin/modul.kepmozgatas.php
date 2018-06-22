<?

    $ok = 0; $error = 0;
    
    if (ISSET($_POST['rename'])){
    
        $small_directory = $func->getMainParam('small_file_dir');
        $large_directory = $func->getMainParam('large_file_dir');

        foreach (glob($small_directory."/*.jpg") as $filename) {
        
            $exp = explode("_", basename($filename));
            $id = $exp[0];
            $newname = str_replace(".jpg", "", $exp[1]);
            
            if (@rename($filename, $func->createHDIR($id, "../coreshop.hu/pictures/termekek/").$newname."_small.jpg")) $ok++; else $error++;
            
        }
        
        foreach (glob($large_directory."/*.jpg") as $filename) {
        
            $exp = explode("_", basename($filename));
            $id = $exp[0];
            $newname = str_replace(".jpg", "", $exp[1]);
            
            if (@rename($filename, $func->createHDIR($id, "../coreshop.hu/pictures/termekek/").$newname."_large.jpg")) $ok++; else $error++;
            
        }
        
    }
    
?>
<br>
<form method="post">
<table width="400" border="0" cellspacing="1" cellpadding="6">
  <tr>
    <td class="darkCell">Sikeresen átmozgatott file-ok száma:</td>
    <td class="lightCell"><?=$ok?> db</td>
  </tr>
  <tr>
    <td class="darkCell">Nem mozgatható file-ok száma:</td>
    <td class="lightCell"><?=$error?> db</td>
  </tr>
  <tr>
    <td class="darkCell" colspan="2"><input type="submit" name="rename" value="File-ok másolása" class="form"></td>
  </tr>
</table>
</form>
