insert into giftcard

  (azonosito_kod, trid, osszeg, min_vasarlas_osszeg, ervenyes_tol, ervenyes_ig, felado_nev, felado_email, cimzett_nev, cimzett_email, uzenet, fizetve)

values (

  concat(date_format(NOW(), "%i"), round(rand()*100), substring(round(now()+0), 8), date_format(NOW(), "%s")),

  '9999999999999999',

  1550, /* Levásárolható összeg */

  0, /* min. vásárolandó összeg */

  '2011-04-01', /* kód érvényessége, -tól */

  '2011-07-31', /* kód érvényessége, -ig */

  'coreshop',

  'info@coreshop.hu',

  'Futó Gábor', /* címzett neve */

  'info@eyecandy.hu', /* címzett e-mail címe */

  '', /* üzenet szövege, ha van */

  NOW()

)
