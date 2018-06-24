<form action="" method="POST">


  <?
    if ($user->isLogged()){
  ?>
  
  Bejelentkezve: <b class="alert"><?=$_SESSION['felhasznalo']['vezeteknev']." ".$_SESSION['felhasznalo']['keresztnev']?></b>
  <!--<input type="button" value="adataim" c-lass="submit" valign="absmiddle" onclick="document.location.href='/adataim'">
  <input type="button" value="vasarlasaim" c-lass="submit" valign="absmiddle" onclick="document.location.href='/vasarlasaim'">-->
  | <a href="/adataim">Adataim módosítása</a> 
  | <img src="/images/info.jpg" align="absmiddle"> <a href="/vasarlasaim">Vásárlásaim megtekintése</a> 
  <input type="submit" value="   Kijelentkezés   " name="logout" class="submit" valign="absmiddle">
  
  <?
    }else{
  ?>
  
  Nem vagy még regisztrálva? : <a href="/regisztracio">Regisztrálj most!</a> | <a href="/elfelejtett_jelszo">Elfelejtetted jelszavad?</a> | Bejelentkezés:
  <input type="text" value="e-mail cím" name="login_email" id="login_email" onfocus="input_clear('login_email');" valign="absmiddle">
  <input type="password" value="jelszó" name="login_password" id="login_password" onfocus="input_clear('login_password');"  valign="absmiddle">
  <input type="checkbox" name="rememberLogin" /> maradjak bejelentkezve
  <input type="submit" value="   Belépés   " class="submit" valign="absmiddle">

  <?
    }
  ?>

</form>