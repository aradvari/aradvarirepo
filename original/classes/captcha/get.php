<?

  session_start();

  require('php-capthca.inc.php');

  $aFonts = array('/web/zonecsd2/coreshop.hu/classes/captcha/AHGBold.ttf');
  $oVisualCaptcha = new PhpCaptcha($aFonts, 180, 50);
  $oVisualCaptcha->Create(null, $_SESSION['giftcard_egyenleg']==0?$_SESSION['giftcard_egyenleg']."0":$_SESSION['giftcard_egyenleg']);

?>