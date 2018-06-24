<?
  class panelMenu extends functions{
      
      var $div = 0;  
      var $opened=array();   
      var $parents_source=array();
      var $childrens_source=array();
      
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

      function getArray($sql){
          
          $query = mysql_query($sql);
          
          while ($adatok = mysql_fetch_array($query)){
            $tomb[]=$adatok;
          }
          
          return $tomb;
          
      }

      function checkNextItem($id){
          $qr = mysql_fetch_array(mysql_query("SELECT id_kategoriak FROM kategoriak WHERE sztorno IS NULL AND szulo=$id"));
          if( empty($qr) ) { return false;} else {return true;}
      }
      
      function createMenu($id=0, $lepcso=0){
          global $db;

          $qr = $this->getArray("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo=$id ORDER BY szulo, sorrend, id_kategoriak");
          if( !empty($qr) ) {
            $lepcso++;
            foreach ($qr as $key => $adatok) {
                
                if ($lepcso>1) $show="display:none"; else $show="";
                
                if (empty($qr[$key-1][1])){ $this->div++; echo '<div id="csoport_'.$adatok['id_kategoriak'].'" style="'.$show.'"><div>'; }   
                
                if ($this->checkNextItem($adatok['id_kategoriak'])){
                    $op = mysql_result(mysql_query("SELECT id_kategoriak FROM kategoriak WHERE sztorno IS NULL AND szulo=".$adatok['id_kategoriak']." ORDER BY szulo, sorrend, id_kategoriak"), 0);
                    //$onclick = "showHide('csoport_".$op."');";
                }else{         
                    //$onclick = "";
                }
                
                if ($lepcso==0){
                    
                    echo '<tr><th><a href="index.php?mainpage=products&menu='.$fomenu[0].'">'.$fomenu[1].'</a></th></tr>';

                    echo '<div class="left_menu'.$lepcso.'" onclick="'.$onclick.'" onmouseover="this.className=\'left_menu'.$lepcso.'_on\';" onmouseout="this.className=\'left_menu'.$lepcso.'\';">';
                    
                    if (in_array($adatok['id_kategoriak'], $this->opened)){
                        
                        echo "<a style=\"color:#ff9a04\" href=\"/".$this->convertString($adatok['nyelvi_kulcs'])."_k".$adatok['id_kategoriak']."\">".$adatok['nyelvi_kulcs']."</a>";
                        
                    }else{
                        
                        echo "<a href=\"/".$this->convertString($adatok['nyelvi_kulcs'])."_k".$adatok['id_kategoriak']."\">".$adatok['nyelvi_kulcs']."</a>";
                        
                    }

                }else{

                    echo '<div class="left_menu'.$lepcso.'" onclick="'.$onclick.'" onmouseover="this.className=\'left_menu'.$lepcso.'_on\';" onmouseout="this.className=\'left_menu'.$lepcso.'\';">';
                    
                    if (in_array($adatok['id_kategoriak'], $this->opened)){
                        
                        echo "<a style=\"color:#ff9a04\" href=\"/".$this->convertString($adatok['nyelvi_kulcs'])."_k".$adatok['id_kategoriak']."\">".$adatok['nyelvi_kulcs']."</a>";
                        
                    }else{
                        
                        echo "<a href=\"/".$this->convertString($adatok['nyelvi_kulcs'])."_k".$adatok['id_kategoriak']."\">".$adatok['nyelvi_kulcs']."</a>";
                        
                    }

                }
                
                echo '</div>'; 

                $this->createMenu($adatok['id_kategoriak'], $lepcso);

                if (empty($qr[$key+1][1])){ echo '</div></div>'; }
                
            }
          }
      }
      
      function createBasicMenu($lap='', $opcio='', $all=true){
      
        global $lang;
      
        if ($lap==""){
            $lap = $_SESSION["langStr"]."/".$lang->_termekek;
        }
      
        if ($opcio=='coreclub'){
            
            $opt = " AND t.klub_termek=1";
            
        }elseif ($opcio!=""){
            
            $opt = " AND t.opcio='$opcio'";
            
        }else{
            
            $opt = '';
            
        }

        global $func; 
      
        $this->parents = array();
        $szulok_forras = $this->getParents($_GET['kategoria']);
        $szulok=array();
        while ($pr = each($szulok_forras)) $szulok[] = $pr[1][0];

        $menu_query=mysql_query("SELECT 
                                 k.* 
                                 FROM kategoriak k 
                                 INNER JOIN kategoriak k2 ON (k2.szulo = k.id_kategoriak)
                                 INNER JOIN termekek t ON (t.kategoria=k2.id_kategoriak AND aktiv=1 AND torolve IS NULL $opt)
                                 INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
                                 WHERE k.szulo=0 AND 
                                 k.sztorno IS NULL
                                 GROUP BY k.id_kategoriak ORDER BY k.sorrend
                                 ");

        while ($fomenu = mysql_fetch_array($menu_query)){

            if (in_array($fomenu[0], $szulok) && $all) $class="selected"; else $class="";
            
            $this->childrens=array();
            $gyerekek = $this->getChildrens($fomenu[0]);
            while ($a = each($gyerekek)){
            
                $idk = @mysql_result(mysql_query("SELECT kategoria 
                                                  FROM termekek t
                                                  LEFT JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
                                                  WHERE 
                                                  t.kategoria=".$a[1][0]." AND 
                                                  t.aktiv=1 AND 
                                                  t.torolve IS NULL ".$opt."
                                                  GROUP BY t.id
                                                  LIMIT 1"), 0);

                if ((int)$idk>0) break;
                
            }
			
            //nyelvesítés
            $fomenu['nyelvi_kulcs'] = $lang->$fomenu['nyelvi_kulcs'];

			//menuitem color switch
			if ($opcio=='coreclub') $menucolor='menuitem-coreclub';
			else $menucolor	= 'menuitem';

            echo '<table class='.$menucolor.'>
                  <tr><th><a href="/'.$lap.'/'.$func->convertString($fomenu['nyelvi_kulcs']).'/'.$idk.'" class="'.$class.'">'.$fomenu['nyelvi_kulcs'].'</a></th></tr>';

            $almenu_query=mysql_query("SELECT 
                                       k.* 
                                       FROM kategoriak k 
                                       INNER JOIN termekek t ON (t.kategoria=k.id_kategoriak AND aktiv=1 AND torolve IS NULL ".$opt.") 
                                       INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (keszlet_1>0) )
                                       WHERE k.szulo=".$fomenu['id_kategoriak']." AND 
                                       k.sztorno IS NULL 
                                       GROUP BY k.id_kategoriak ORDER BY k.sorrend"); 

            if ($all){
                
                while ($almenu=mysql_fetch_array($almenu_query)){

                    $almenu['nyelvi_kulcs'] = $lang->$almenu['nyelvi_kulcs'];

                    if ($class=="selected"){
                    
                        if ($_GET['kategoria']==$almenu[0]) $class2="selected"; else $class2="";
                                 
                        echo '<tr>
                                <td><a href="/'.$lap.'/'.$func->convertString($almenu['nyelvi_kulcs']).'/'.$almenu['id_kategoriak'].'" class="'.$class2.'">'.$almenu['nyelvi_kulcs'].'</a></td></tr>';
                        
                        $marka_query=mysql_query("SELECT DISTINCT 
                                                    markak.id, 
                                                    markak.markanev 
                                                  
                                                  FROM termekek t  
                                                  INNER JOIN vonalkodok vk ON (vk.id_termek=t.id AND vk.aktiv=1 AND (vk.keszlet_1>0) )
                                                  INNER JOIN markak ON t.markaid=markak.id 
                                                  
                                                  WHERE 
                                                  t.kategoria=".$almenu[0]." AND 
                                                  t.aktiv=1 AND
                                                  t.torolve IS NULL
                                                   ".$opt."
                                                  
                                                  GROUP BY markak.id
                                                  
                                                  ORDER BY 
                                                  markak.markanev");
                        
                        if ($class2=="selected"){
                        
                            while ($marka=mysql_fetch_array($marka_query)){

                                //$marka[1] = $lang->$marka[1];

                                if ($_GET['marka']==$marka[0]) $class3="-selected"; else $class3="";
                                
                                echo '<tr>
                                      <td class="'.$menucolor.'-brand'.$class3.'"><a href="/'.$lap.'/'.$func->convertString($almenu['nyelvi_kulcs']).'/'.$almenu['id_kategoriak'].'/'.$func->convertString($marka[1]).'/'.$marka[0].'">'.$marka[1].'</a></td></tr>';
                                                    
                            }                       
                            
                        }                                                                                           
                        
                    }

                }
                
            }
            
            //echo '</td></tr></table>';
            echo '</table>';
            
        }          
      }
      
      function openMenus($id){

          $this -> parents = array();
          $parents = $this -> getParents($id);
          echo '<script>';
          while ($a = each($parents)){
          
              $op = @mysql_result(mysql_query("SELECT id_kategoriak FROM kategoriak WHERE szulo=".$a[1]['id_kategoriak']." AND sztorno IS NULL ORDER BY sorrend LIMIT 0, 1"), 0);
              echo "document.getElementById('csoport_".$op."').style.display='';";
              
          }   
          echo '</script>';
          
      }
      
      function readOpenedMenus($id){

          $this -> parents = array();
          $parents = $this -> getParents($id);
          while ($a = each($parents)){
              $this->opened[]=$a[1]['id_kategoriak'];
          }   
          
      }
      
      function getChildrens($id){
          
          $query = mysql_fetch_array(mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND id_kategoriak=$id"));
          
          $this -> childrens[] = $query;
          
          $alquery = mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND szulo=".$query['id_kategoriak']." ORDER BY SORREND");
          
          while ($adatok = mysql_fetch_array($alquery)){
              
              $this -> getChildrens($adatok['id_kategoriak']);
              
          }
          
          return $this -> childrens;
          
      }
      
      function getParents($id){
          
          $query = @mysql_fetch_array(mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND id_kategoriak=$id"));
          
          $this -> array_insert ($this -> parents, $query, 0);
          
          $alquery = @mysql_query("SELECT * FROM kategoriak WHERE sztorno IS NULL AND id_kategoriak=".$query['szulo']." ORDER BY SORREND");
          
          while ($adatok = @mysql_fetch_array($alquery)){
              
              $this -> getParents($adatok['id_kategoriak']);
              
          }
          
          return $this -> parents;
          
      }      
  
  }
?>