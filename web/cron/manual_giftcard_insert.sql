insert into giftcard

  (azonosito_kod, trid, osszeg, min_vasarlas_osszeg, ervenyes_tol, ervenyes_ig, felado_nev, felado_email, cimzett_nev, cimzett_email, uzenet, fizetve)

values (

  concat(date_format(NOW(), "%i"), round(rand()*100), substring(round(now()+0), 8), date_format(NOW(), "%s")),

  '9999999999999999',

  1550, /* Lev�s�rolhat� �sszeg */

  0, /* min. v�s�roland� �sszeg */

  '2011-04-01', /* k�d �rv�nyess�ge, -t�l */

  '2011-07-31', /* k�d �rv�nyess�ge, -ig */

  'coreshop',

  'info@coreshop.hu',

  'Fut� G�bor', /* c�mzett neve */

  'info@eyecandy.hu', /* c�mzett e-mail c�me */

  '', /* �zenet sz�vege, ha van */

  NOW()

)
