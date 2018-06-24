<?

class sitemap {

    function __construct() {
        global $menu;
        global $func;
        global $lang;
        global $termek;

        //QUERY
        $this->lista_query = mysql_query("SELECT termekek.id, termekek.termeknev, termekek.opcio, termekek.kisker_ar, termekek.akcios_kisker_ar, termekek.szin, termekek.markaid,
					markak.markanev, termekek.klub_ar, termekek.klub_termek, termekek.dealoftheweek, (CASE WHEN termekek.akcios_kisker_ar>0 THEN termekek.akcios_kisker_ar ELSE termekek.kisker_ar END) vegleges_ar,
					termekek.fokep, CONCAT(termekek.termeknev, ' ', termekek.szin, ' ', markak.markanev, ' ', k.megnevezes) keresheto,
					ifnull((SELECT GROUP_CONCAT(megnevezes) FROM vonalkodok WHERE id_termek=termekek.id AND aktiv=1 AND keszlet_1>0), ' ') meretek
					FROM termekek
					INNER JOIN vonalkodok vk ON (vk.id_termek=termekek.id AND vk.aktiv=1 AND (keszlet_1>0) )
					LEFT JOIN markak ON termekek.markaid=markak.id
					LEFT JOIN termek_kategoria_kapcs tkk ON (tkk.id_termekek = termekek.id)
					LEFT JOIN kategoriak k ON tkk.id_kategoriak=k.id_kategoriak
					WHERE termekek.torolve IS NULL AND termekek.aktiv>=1
					GROUP BY termekek.id");


        $this->meretek_sql = "SELECT vk.megnevezes,
						CONCAT(termekek.termeknev, ' ', termekek.szin, ' ', markak.markanev, ' ', k.megnevezes) keresheto,
						ifnull((SELECT GROUP_CONCAT(megnevezes) FROM vonalkodok WHERE id_termek=termekek.id AND aktiv=1 AND keszlet_1>0), ' ') meretek
						FROM termekek
						INNER JOIN vonalkodok vk ON (vk.id_termek=termekek.id AND vk.aktiv=1 AND (keszlet_1>0 /*OR keszlet_2>0*/) )
						LEFT JOIN markak ON termekek.markaid=markak.id
						LEFT JOIN termek_kategoria_kapcs tkk ON (tkk.id_termekek = termekek.id)
						LEFT JOIN kategoriak k ON tkk.id_kategoriak=k.id_kategoriak
						LEFT JOIN vonalkod_sorrendek vks ON (vk.megnevezes = vks.vonalkod_megnevezes)
						GROUP BY vk.megnevezes
						ORDER BY vks.sorrend, vk.megnevezes";
    }

    function echoRoot() {

        global $menu;
        global $func;
        global $page;
        global $lang;

        if (ISSET($_GET['kategoria'])) {

            $menu->parents = array();
            $parents = $menu->getParents($_GET['kategoria']);
            $menu->childrens = array();
            $childrens = $menu->getChildrens($_GET['kategoria']);

            while ($t = each($childrens)) {
                $sql_in .= $t[1][0] . ",";
            }
            $sql_in = substr($sql_in, 0, -1);
        }

        if (ISSET($_GET['marka'])) {

            $mark = mysql_fetch_array(mysql_query("SELECT markanev FROM markak WHERE id=" . $_GET['marka']));
            if (!empty($mark[0]))
                $marka_str = ' &raquo ' . $mark[0];
        }

        if (ISSET($_GET['opcio'])) {
            switch ($_GET['opcio']) {
                case 'uj' : $root .=('<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termekek_uj . '">Új termékek</a> &raquo ');
                    break;
                case 'akcios' : $root .=('<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termekek_akcios . '">Akciós termékek</a> &raquo ');
                    break;
                case 'web' : $root .=('<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termekek_web . '">Web exclusive</a> &raquo ');
                    break;
                case 'coreclub' : $root .=('<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termekek_coreclub . '">Klub termékek</a> &raquo ');
                    break;
            }
        }

        if (ISSET($_GET['kategoria'])) {

            while ($t = each($parents)) {

                if (key($parents) == "" && (int) $_GET['marka'] < 1) {

                    $root .= $t[1][1];
                } else {

                    $root .= "<a href=\"/$page/" . $func->convertString($t[1][1]) . "/" . $t[1][0] . "\">" . $t[1][1] . "</a>";
                }

                $root .= " &raquo; ";
            }
            $root = substr($root, 0, -8);
        }

        if ($_POST['keresendo'] != "")
            echo 'keresendő: <b>' . htmlspecialchars($_POST['keresendo']) . '</b>';
        else
            echo $root . $marka_str;
    }

    function getTitleRoot($separator = ", ") {

        global $menu;
        global $func;
        global $page;
        global $lang;

        if (ISSET($_GET['kategoria'])) {

            $menu->parents = array();
            $parents = $menu->getParents($_GET['kategoria']);
            $menu->childrens = array();
            $childrens = $menu->getChildrens($_GET['kategoria']);

            while ($t = each($childrens)) {
                $sql_in .= $lang->$t[1][0] . ",";
            }
            $sql_in = substr($sql_in, 0, -1);
        }

        if (ISSET($_GET['marka'])) {

            $mark = mysql_fetch_array(mysql_query("SELECT markanev FROM markak WHERE id=" . $_GET['marka']));
            if (!empty($mark[0]))
                $marka_str = $lang->$mark[0] . ' ' . $separator . ' ';
        }

        /* if (ISSET($_GET['opcio'])){
          switch ($_GET['opcio']){
          case 'uj' : $root .= 'Új termékek '.$separator.' '; break;
          case 'akcios' : $root .= 'Akciós termékek '.$separator.' '; break;
          case 'web' : $root .=  'Web exclusive '.$separator.' '; break;
          case 'klub' : $root .=  'Klub termékek '.$separator.' '; break;
          }
          } */

        if (ISSET($_GET['kategoria'])) {

            while ($t = each($parents)) {

                $root .= ucfirst($lang->$t[1][1] . "$separator ");
            }
            $root = substr($root, 0, -3);
        }

        //return $root.$marka_str;
        return $marka_str . $root;
    }

    function echoProductTM($arr) {

        global $func;
        global $lang;

        echo '<div class="product-thumb" onclick="location.href=\'/' . $_SESSION["langStr"] . '/' . $lang->_termek . '/' . $func->convertString($arr['markanev']) . '-' . $func->convertString($arr['termeknev']) . '/' . $arr['id'] . '\'" style="cursor:pointer;">';

        if ($arr['dealoftheweek'] == 1)
            echo '<div class="product-image-container-horizontal-dotw">
				<img src="/images/coreshop_dealoftheweek_small.png" />
			</div>';

        // opcio icon
        echo '<div class="product-opcio-container">';
        // DEAL OF THE WEEK
        if ($arr['opcio'] == 'ZZZ_DOTW') {
            if ($func->isMobile() != 0)
                echo '<span class="dotw">ajándék napszemüveggel</span>';
            else {
                echo '<span class="dotw">Deal of the Week</span>';
                echo '<span class="dotw_bottom">ajándék<br />vans napszemüveggel</span>';
            }
        }
        /* if($arr['opcio'] == 'ZZ_TOP') echo '<span class="top">TOP</span>';
          if($arr['opcio'] == 'Z_CARRYOVER') echo '<span class="classic">Classic</span>';
          if($arr['opcio'] == 'UJ') echo '<span class="uj">Új</span>';
          if($arr['akcios_kisker_ar'] > 0) echo '<span class="akcio">%</span>'; */

        echo '</div>';

        $directory = $func->getHDir($arr['id']);

        if (!is_file($directory . '/' . $arr['fokep'] . '_small.jpg')) {
            //if(!is_file($directory.'/'.$arr['fokep'].'_large.jpg'))

            echo '<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termek . '/' . $func->convertString($arr['markanev']) . '-' . $func->convertString($arr['termeknev']) . '/' . $arr['id'] . '"><img src="/images/none.jpg?17" alt="' . $arr['markanev'] . ' - ' . $arr['termeknev'] . '"  /></a>';
        } else {

            echo '<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termek . '/' . $func->convertString($arr['markanev']) . '-' . $func->convertString($arr['termeknev']) . '/' . $arr['id'] . '">';
            echo '<img src="/' . $directory . '/' . $arr['fokep'] . '_small.jpg?17" alt="' . $arr['markanev'] . ' - ' . $arr['termeknev'] . '" />';
            //echo '<img src="/image_resize.php?w=300&img=/'.$directory.'/1_large.jpg" alt="'.$arr['markanev'].' - '.$arr['termeknev'].'" />';
            echo '</a>';
        }


        // mobile nezetnel rovid nev
        /* if ($func->isMobile()!=0)	{
          $arr['termeknev']=$func->trim_text($arr['termeknev'], 2);
          $arr['szin']=$func->trim_text($arr['szin'], 1);
          } */

        if (empty($arr['szin']))
            $arr['szin'] = '&nbsp;';  // ha nincs szin, akkor kell a sor a tarto div magassag miatt

        $arr['szin_full'] = $arr['szin']; // szin teljes neve tarolva
        /* if(strlen($arr['szin'])>30) $arr['szin']=substr($arr['szin'],0,30).'..';	// szin string levagva, ha tobb mint 30 karakter

          if(strlen($arr['termeknev'])>30) $arr['termeknev']=substr($arr['termeknev'],0,30).'..';	// termeknev string levagva, ha tobb mint 30 karakter */

        echo '<div class="product-info">

	<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termek . '/' . $func->convertString($arr['markanev']) . '-' . $func->convertString($arr['termeknev']) . '/' . $arr['id'] . '"><h2>' . $arr['markanev'] . '
	' . $arr['termeknev'] . '</h2></a>
	<a href="/' . $_SESSION["langStr"] . '/' . $lang->_termek . '/' . $func->convertString($arr['markanev']) . '-' . $func->convertString($arr['termeknev']) . '/' . $arr['id'] . '">' . $arr['szin'] . '</a>';


        echo '<div class="products-prise-container">';

        if ($lang->defaultCurrencyId == 0) { //MAGYARORSZ�?G ESETÉN
            if ($arr['akcios_kisker_ar'] > 0) {
                //echo '<span class="products-thumb-saleprise">'.number_format($arr['akcios_kisker_ar'],0,'','.').' Ft</span>';
                //if ($func->isMobile()==0)
                echo '<span class="products-thumb-originalprise"><del>' . number_format($arr['kisker_ar'], 0, '', '.') . '</del> Ft</span><br />';
                echo '<span class="products-thumb-saleprise">' . number_format($arr['akcios_kisker_ar'], 0, '', '.') . ' Ft</span>';
            } else
                echo $lang->Ar . ' ' . number_format($arr['kisker_ar'], 0, '', '.') . ' Ft';
        }else {

            //�?TV�?LT�?S

            if ($arr['akcios_kisker_ar'] > 0) {
                echo '<span class="products-thumb-originalprise">€ <del>' . $func->toEUR($arr['kisker_ar']) . '</del></span><br />';
                echo '<span class="products-thumb-saleprise">€ ' . $func->toEUR($arr['akcios_kisker_ar']) . '</span>';
            } else
                echo $lang->Ar . ' € ' . $func->toEUR($arr['kisker_ar']);
        }

/////////////////////////////////////////

        /* if($_GET["kategoria"]==95) {
          echo '<br />';
          //echo $termek->getSizes($arr['id'], 1, '<p class="sizeButton2">', '</p>', ' ');
          } */

/////////////////////////////////////////

        echo '</div>
	  </div>
   </div>';
    }

    function echoPageStepper() {

        global $lang;

        if ($this->pagenum > 0) {
            if (!ISSET($_GET['list_all'])) {

                //keres
                if (!empty($_REQUEST['keresendo']))
                    $keresendo = '&keresendo=' . $_REQUEST['keresendo'];
                else
                    $keresendo = '';

                //meret
                $meretek = '';
                if (!empty($_GET['meretek'])) {
                    $meretek = '&meretek=' . $_GET['meretek'];
                }

                if (!empty($_GET['orderby'])) {
                    $orderby = '&orderby=' . $_GET['orderby'];
                }

                echo '<div class="pagestepper">'; // pagestepper container div

                if ($_REQUEST['oldal'] > 0)
                    echo '&lsaquo; <a href="?oldal=' . ($_REQUEST['oldal'] - 1) . $meretek . $orderby . $keresendo . '">' . $lang->elozo_oldal . '</a>&nbsp;&nbsp;&nbsp;';

                for ($go = 1; $go <= $this->pagenum; $go++) {

                    if ($go > 1) {
                        echo('&nbsp;&nbsp;');
                    }
                    if (($_REQUEST['oldal'] + 1) == $go) {

                        echo '<span class="pagenum">' . $go . '</span> ';
                    } else {
                        echo '<a href="?oldal=' . ($go - 1) . $meretek . $orderby . $keresendo . '" class="pagenum_inactive">' . $go . '</a> ';
                    }
                }

                if (($_REQUEST['oldal'] + 1) < $this->pagenum)
                    echo '&nbsp;&nbsp;&nbsp; <a href="?oldal=' . ($_REQUEST['oldal'] + 1) . $meretek . $orderby . $keresendo . '">' . $lang->kovetkezo_oldal . '</a> &rsaquo;';

                echo '</div>'; // endof class pagestepper
            }
        }
    }

}

?>