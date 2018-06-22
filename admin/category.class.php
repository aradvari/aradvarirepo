<?
class categorys extends functions{
      
      var $div = 0; 
      var $rtn = '';
      var $childrens = array();
      var $parents = array();
      var $sorrend = array();
      
      function getArray($sql){
          
          $query = mysql_query($sql);
          
          while ($adatok = mysql_fetch_array($query)){
            $tomb[]=$adatok;
          }
          
          return $tomb;
          
      }

      function getAllLastCategory(){
      
          $rtn = array();
          
          $query = @mysql_query("
            SELECT tk1.* FROM kategoriak tk1
            LEFT JOIN kategoriak tk2 ON (tk1.id_kategoriak=tk2.szulo AND tk2.sztorno IS NULL)
            WHERE tk1.sztorno IS NULL AND tk2.id_kategoriak IS NULL
            GROUP BY tk1.id_kategoriak
          ");
          
          $num=0;
          while ($adatok = mysql_fetch_array($query)){
              
              $this -> parents = array();                       
              $tomb = $this->getParents($adatok['id_kategoriak']);
              while ($kiir = each($tomb)){
              
                  //echo $kiir[1][0].' - ';
                  $rtn[$num][] = $kiir[1];
                  
              }
              $num++;
              
          }
          
          return $rtn;
          
      }
      
      function checkNextItem($id){

          $qr = mysql_fetch_array(mysql_query("SELECT id_kategoriak FROM kategoriak WHERE sztorno IS NULL AND szulo=$id"));

          if( empty($qr) ) { return false;} else {return true;}

      }
      
      function getChildrens($id){
          
          $query = mysql_fetch_array(mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND id_kategoriak=$id"));
          
          $this -> childrens[] = $query;
          
          $alquery = mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo=".$query['id_kategoriak']);
          
          while ($adatok = mysql_fetch_array($alquery)){
              
              $this -> getChildrens($adatok['id_kategoriak']);
              
          }
          
          return $this -> childrens;
          
      }
      
      function getParents($id){
          
          $query = @mysql_fetch_array(mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND id_kategoriak=$id"));
          
          $this -> array_insert ($this -> parents, $query, 0);
          
          $alquery = @mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND id_kategoriak=".$query['szulo']);
          
          while ($adatok = @mysql_fetch_array($alquery)){
              
              $this -> getParents($adatok['id_kategoriak']);
              
          }
          
          return $this -> parents;
          
      }

      function array_insert(&$array, $insert, $position = -1) {
          $position = ($position == -1) ? (count($array)) : $position ;
          if($position != (count($array))) {
               $ta = $array;
               for($i = $position; $i < (count($array)); $i++) {
                    if(!isset($array[$i])) {
                         die("Ajajarray");
                    }
                    $tmp[$i+1] = $array[$i];
                    unset($ta[$i]);
               }
               $ta[$position] = $insert;
               $array = $ta + $tmp;
               //print_r($array);
          } else {
               $array[$position] = $insert;          
          }
      }
      
      function sortCategorys(){
          
          $query = mysql_query("SELECT szulo FROM kategoriak WHERE sztorno IS NULL GROUP BY szulo");
          
          while ($adatok = mysql_fetch_array($query)){
              
              $query2 = mysql_query("SELECT id_kategoriak FROM kategoriak WHERE sztorno IS NULL AND szulo='".$adatok['szulo']."' ORDER BY sorrend");
              
              $num=0;
              while ($adatok2 = mysql_fetch_array($query2)){
                  
                  $num++;
                  mysql_query("UPDATE kategoriak SET sorrend=$num WHERE id_kategoriak=".$adatok2['id_kategoriak']);
                  
              }
              
          }
          
      }
            
      function createMenu($id=0, $lepcso=0){

          //$this->rtn='';

          $Colors[1][0]="#7CA4CE";  
          $Colors[1][1]="#7CA4CE";  

          $Colors[2][0]="#B9D6B5";
          $Colors[2][1]="#B9D6B5";

          $Colors[3][0]="#E9D3C3";
          $Colors[3][1]="#E9D3C3";

          $Colors[4][0]="#D0E6EC";
          $Colors[4][1]="#D0E6EC";

          $Colors[5][0]="#DBC8D3";
          $Colors[5][1]="#DBC8D3";    

          $qr = $this->getArray("SELECT 
                                 k.*, count(k2.id_kategoriak) db 
                                 FROM kategoriak k
                                 LEFT JOIN kategoriak k2 ON (k2.szulo = k.id_kategoriak AND k2.sztorno IS NULL)
                                 WHERE 
                                 k.sztorno IS NULL AND 
                                 k.szulo=$id 
                                 GROUP BY k.id_kategoriak
                                 ORDER BY k.szulo, k.sorrend
                                 ");
          
          if( !empty($qr) ) {
            $lepcso++;
            foreach ($qr as $key => $adatok) {           
                
                $this->getChildrens($adatok['id_kategoriak']);
                $nn='';
                while ($cha = each($this->childrens)){
                    $nn .= $cha[1]['id_kategoriak'].',';
                }
                $notin = substr($nn, 0, -1);
                $this->childrens=array();
                
                $select = $this -> createSelectBox("SELECT id_kategoriak, megnevezes FROM kategoriak WHERE id_kategoriak NOT IN ($notin) AND sztorno IS NULL", $adatok['szulo'], "name=\"szulo_".$adatok['id_kategoriak']."\"", "Főkategória", 0);
                $pselect = $this -> createArraySelectBox(array(1=>"Igen",2=>"Nem"), $adatok['publikus'], "name=\"publikus_".$adatok['id_kategoriak']."\"");

                //Törölhető e az adott kategória?
                if ($adatok['db']==0){
                    $torles = '<img style="cursor:pointer" onclick="delCategory('.$adatok['id_kategoriak'].')" src="images/icons/delete.png" width="13" alt="kategória törlése">';
                }else{
                    $torles = '';
                }
                    
                if (!empty($qr[$key-1])) $arrows = '<img style="cursor:pointer" src="images/icons/up_arrow.png" width="13" alt="Kategória sorrend (fel)" onclick="moveCategory('.$adatok['id_kategoriak'].', '.$adatok['sorrend'].', \'up\', '.$adatok['szulo'].')">'; else $arrows = '';
                if (!empty($qr[$key+1])) $arrows2 = ' <img style="cursor:pointer" src="images/icons/down_arrow.png" width="13" alt="Kategória sorrend (le)" onclick="moveCategory('.$adatok['id_kategoriak'].', '.$adatok['sorrend'].', \'down\', '.$adatok['szulo'].')">'; else $arrows2 = '';
                
                if ($color=="7CA4CE") $color="97BADE"; else $color="7CA4CE";
                
                $this->rtn .= '<tr style="background-color:#'.$color.'; height:25px">';
                $this->rtn .= '<td align="center"><img style="cursor:pointer" onclick="document.location.href=\'index.php?lap=kategoriak&sc='.$adatok['id_kategoriak'].'\'" src="images/icons/open.png" width="13" alt="alkategóriák megtekíntése"></td>';
                $this->rtn .= '<td><input type="text" style="width:180px" value="'.htmlspecialchars($adatok['megnevezes'], ENT_QUOTES).'" name="megnevezes_'.$adatok['id_kategoriak'].'"></td>';
                $this->rtn .= '<td align="left">'.$select.'</td>';
                $this->rtn .= '<td style="font-size:11px; color:white">'.($adatok['db']>0?$adatok['db'].' db':'-').'</td>';
                $this->rtn .= '<td>'.$pselect.'</td>';
                $this->rtn .= '<td align="center">'.$torles.'</td>';
                $this->rtn .= '<td align="center">'.$arrows.$arrows2.'</td>';
                $this->rtn .= '</tr>';

            }
            
          }else{
              
              //$this->rtn .= '<div class="celldiv" style="width: 980px;" id="footer">Nincs rögzített kategória.</div>';    
              
          }
          
          return $this->rtn;
          
      }

      function _createMenu($id=0, $lepcso=0){

          //$this->rtn='';

          $Colors[1][0]="#7CA4CE";  
          $Colors[1][1]="#7CA4CE";  

          $Colors[2][0]="#B9D6B5";
          $Colors[2][1]="#B9D6B5";

          $Colors[3][0]="#E9D3C3";
          $Colors[3][1]="#E9D3C3";

          $Colors[4][0]="#D0E6EC";
          $Colors[4][1]="#D0E6EC";

          $Colors[5][0]="#DBC8D3";
          $Colors[5][1]="#DBC8D3";    

          $qr = $this->getArray("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo=$id ORDER BY szulo, sorrend");
          
          if ($this->div==0) $this->rtn .= '<div class="tablediv">
                                                <div class="rowdiv">
                                                    <div class="celldiv" style="width: 300px;" id="header">Kategória megnevezése</div>
                                                    <div class="celldiv" style="width: 250px;" id="header">Szülő kategória</div>
                                                    <div class="celldiv" style="width: 80px;" id="header">Alkat.</div>
                                                    <div class="celldiv" style="width: 70px;" id="header">Publikus</div>
                                                    <div class="celldiv" style="width: 45px;" id="header"><img onclick="showHide(\'add_0\')" src="images/icons/add.png" width="13"></div>
                                                    <div class="celldiv" style="width: 45px;" id="header">&nbsp;</div>
                                                </div>
                                            </div>
                                            <div id="add_0" style="display: none;"><div class="celldiv" style="width: 800px; background-color:'.$Colors[1][1].';"><div class="mainStr">Új kategória: <input type="text" style="width:300px;" name="kategoria_0_0"></div></div></div>';
          
          if( !empty($qr) ) {
            $lepcso++;
            foreach ($qr as $key => $adatok) {           
                
                if ($divColor==0) $divColor=1; else $divColor=0;
                
                if (empty($qr[$key-1][1])){ $this->div++; $this->rtn .= '<div id="csoport_'.($this->div).'" class="tablediv"><div class="rowdiv">'; }   
                
                if ($this->checkNextItem($adatok['id_kategoriak'])){
                    $onclick = "showHide('csoport_".($this->div+1)."');";
                }
                
                $alkategoriak = count($this->getChildrens($adatok['id_kategoriak']))-1;
                $nn='';
                while ($cha = each($this->childrens)){
                    $nn .= $cha[1]['id_kategoriak'].',';
                }
                $notin = substr($nn, 0, -1);
                $this->childrens=array();
                
                $select = $this -> createSelectBox("SELECT * FROM kategoriak WHERE id_kategoriak NOT IN ($notin) AND sztorno IS NULL", $adatok['szulo'], "name=\"szulo_".$adatok['id_kategoriak']."\"", "Főkategória", 0);

                $pselect = $this -> createArraySelectBox(array(1=>"Igen",2=>"Nem",3=>"Auto"), $adatok['publikus'], "name=\"publikus_".$adatok['id_kategoriak']."\"");

                //Törölhető e az adott kategória?
                if ($alkategoriak==0)
                    $torles = '<img onclick="delCategory('.$adatok['id_kategoriak'].')" src="images/icons/delete.png" width="13" alt="kategória törlése">';
                else
                    $torles = '';
                    
                if (!empty($qr[$key-1][1])) $arrows = '<img src="images/icons/up_arrow.png" width="13" alt="Kategória sorrend (fel)" onclick="moveCategory('.$adatok['id_kategoriak'].', '.$adatok['sorrend'].', \'up\', '.$adatok['szulo'].')">'; else $arrows = '';
                if (!empty($qr[$key+1][1])) $arrows2 = ' <img src="images/icons/down_arrow.png" width="13" alt="Kategória sorrend (le)" onclick="moveCategory('.$adatok['id_kategoriak'].', '.$adatok['sorrend'].', \'down\', '.$adatok['szulo'].')">'; else $arrows2 = '';
                
                $this->rtn .= '<div class="celldiv" style="width: 300px; background-color:'.$Colors[$lepcso][$divColor].';" onclick="'.$onclick.'"><span style="margin-left: '.(($lepcso-1)*17).'px"><input type="text" style="width:180px" value="'.$adatok['megnevezes'].'" name="megnevezes_'.$adatok['id_kategoriak'].'"></span></div>';
                $this->rtn .= '<div class="celldiv" style="width: 250px; background-color:'.$Colors[$lepcso][$divColor].';">'.$select.'</div>';
                $this->rtn .= '<div class="celldiv" style="width: 80px; background-color:'.$Colors[$lepcso][$divColor].'; font-size:11px; color:black">'.$alkategoriak.' db</div>';
                $this->rtn .= '<div class="celldiv" style="width: 70px; background-color:'.$Colors[$lepcso][$divColor].';">'.$pselect.'</div>';
                $this->rtn .= '<div class="celldiv" style="width: 45px; background-color:'.$Colors[$lepcso][$divColor].';"><img onclick="showHide(\'add_'.$adatok['id_kategoriak'].'\')" src="images/icons/add.png" width="13" alt="új alkategória"> '.$torles.'</div>';
                $this->rtn .= '<div class="celldiv" style="width: 45px; background-color:'.$Colors[$lepcso][$divColor].';">'.$arrows.$arrows2.'</div>';

                $this->rtn .= '<div id="add_'.$adatok['id_kategoriak'].'" style="display: none;"><div class="celldiv" style="width: 800px; background-color:'.$Colors[$lepcso+1][$divColor].';"><div style="margin-left: '.(($lepcso-1)*17).'px" class="mainStr">Új kategória: <input type="text" style="width:300px;" name="kategoria_'.$adatok['id_kategoriak'].'_'.$adatok['szulo'].'"></div></div></div>';

                $this->createMenu($adatok['id_kategoriak'], $lepcso);
                
                if (empty($qr[$key+1][1])){ 
                    //if ($divColor==0) $divColor=1; else $divColor=0;
                    //$form = '<form method="post"><input type="hidden" name="szulo" value="'.$adatok['szulo'].'"><input type="text" style="width:200px"> <input type="button" id="submit_small" value="kategória rögzítése"></form>';
                    //$this->rtn .= '<div class="categoryDiv" style="background-color:'.$Colors[$lepcso][$divColor].'"><span style="margin-left: '.(($lepcso-1)*17).'px">'.$form.'</span></div>';
                    $this->rtn.= '</div></div>'; 
                }

            }
            
          }else{
              
              //$this->rtn .= '<div class="celldiv" style="width: 980px;" id="footer">Nincs rögzített kategória.</div>';    
              
          }
          
          return $this->rtn;
          
      }
  
  }
?>