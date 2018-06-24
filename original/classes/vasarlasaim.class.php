<?

  class vasarlasaim {
      
      var $sql;
      
      function __construct(){

          if ((int)$_SESSION['felhasznalo']['id']>0)
          $this->sql = "
            SELECT
            t.id, k.kikerulesi_datum, m.markanev, t.termeknev, t.szin, v.megnevezes, count(k.id_vonalkod) db, k.kikerulesi_ar, DATE_FORMAT(k.kikerulesi_datum, '%Y.%m.%d') datum, DATE_FORMAT(k.kikerulesi_datum, '%H:%i:%s') idopont
            FROM keszlet k
            LEFT JOIN vonalkodok v ON (v.id_vonalkod=k.id_vonalkod)
            LEFT JOIN termekek t ON (t.id=v.id_termek)
            LEFT JOIN markak m ON (m.id=t.markaid)
            WHERE k.id_felhasznalok=".(int)$_SESSION['felhasznalo']['id']."
            GROUP BY k.id_vonalkod, k.kikerulesi_datum, k.kikerulesi_ar
            ORDER BY k.kikerulesi_datum
          ";
      
      }
     
  }

?>