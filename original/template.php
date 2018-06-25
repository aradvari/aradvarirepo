	<?
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)	{			
		header('Location: https://coreshop.hu/browser_support.php');
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="hu">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="google-site-verification" content="FJXmdPLEe96Ga1GQNgZjWfg3t7beMJ3rinqkDDVt9CA" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes" />
<meta name="google" content="notranslate">
<meta name="format-detection" content="telephone=no">
<meta name="robots" content="all" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />


<meta property="og:title" content="Kezdőlap"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="https://coreshop.hu/"/>
<meta property="og:image" content="https://coreshop.hu/images/coreshop-logo-social.png" />
<meta property="og:description" content="Gördeszkás webshop Vans, Etnies, éS Footwear, Emerica, Volcom termékek, azonnali szállítással. Coreshop a gördeszka, cipő, ruházat és kiegészítők webáruháza" />

<meta property="article:publisher" content="https://www.facebook.com/coreshop" />

<meta property="article:publisher" content="https://plus.google.com/+coreshop" />


<link rel="icon" href="/favicon.ico" type="image/png" />
<link rel="apple-touch-icon" href="/images/coreshop-logo-social.png">

<?
// metatags title / description / keywords
include('config/optimalize.php');
?>

<link rel="stylesheet" href="<?=$func->getMainParam("main_css")?>" type="text/css" media="screen" />	<? // @param ?> 

<!-- highslide JS -->
<script type="text/javascript" src="/js/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="/js/highslide.css" />

<script type="text/javascript">
    hs.graphicsDir = '/js/graphics/';
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.outlineType = 'glossy-dark';
    hs.wrapperClassName = 'dark';
    hs.fadeInOut = true;
    //hs.dimmingOpacity = 0.75;


    // Add the controlbar
    if (hs.addSlideshow) hs.addSlideshow({
        //slideshowGroup: 'group1',
        interval: 5000,
        repeat: false,
        useControls: false,
        fixedControls: 'fit',
        overlayOptions: {
            opacity: .6,
            position: 'bottom center',
            hideOnMouseOut: true
        }
    });
</script>
<!-- end of highslide JS -->


<!-- my javascripts -->
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/coreshop20170216.js"></script>

<!-- facebox -->
<link rel="stylesheet" href="/css/facebox_20170401.css" type="text/css" media="screen" />

<script type="text/javascript" src="/js/facebox.js"></script>

<script type="text/javascript" src="/js/ajax.search.js"></script>
<!-- end of facebox -->

<? /*
<!-- g+ fb like plugin from sharethis.com -->
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "04f0e8bd-db03-42a4-b09b-2078b1e3567c", doNotHash: true, doNotCopy: true, hashAddressBar: false});</script>
 */ ?>


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '1425657147763024');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1425657147763024&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


<!-- Google Analytics Universal -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-17488049-1', 'auto');
  ga('require', 'displayfeatures');
  ga('require', 'linkid', 'linkid.js');
<?if(['page']==='termek' && $_SESSION['alkategoria']== 94)
	{
		echo 'ga("set","dimension1",';
		echo json_encode($_SESSION['termek_id']);
		echo ');'; 
		echo "ga('set','dimension2','offerdetail');"; 
	}
?>
  ga('send', 'pageview');
</script>




</head>
<body>

<!-- fb like at product page -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.7&appId=200682880101291";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>




<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#252e39"
    },
    "button": {
      "background": "#14a7d0"
    }
  },
  "position": "bottom-right",
  "content": {
    "message": "Az oldal Cookie-kat (sütiket) használ a felhasználói élmény fokozása érdekében.",
    "dismiss": "Elfogadom",
    "link": "Részletek"
  }
})});
</script>
<!-- End Cookie Consent plugin -->

  <?  
  
  include 'inc/messagebox.php';							// error message facebox style  
    
  //include 'inc/inc.checkout.php';						// checkout
  
  if($_SESSION['page']==='termek')	{					// merettablazat @ termek page
		include 'inc/inc.merettablazat.php'; 
	}
    
 // include 'inc/hu/welcome_message_hu.php';			// welcome message, optional
  
  ?>
  
 
  <div align="center">
  
 
  
	<!-- header -->
	<? include 'inc/header.php'; ?>
	
	<!-- main -->
	<div class="main"> 
	

	<!-- CONTENT FRONTPAGE / PAGES -->  
	  <?
		
		$exp = explode("/", $_GET['query']);
		
		if ( (!empty($exp[0])) && ( $exp[0] !== 'hu' ) )			
			//include 'pages/page.error404.php';
			header("Location: /hu/".$_GET['query']);
	
		else {
			if($page=="")
				include 'inc/welcome.php';	//frontpage desktop
			else
				include 'inc/content.php';	//pages
		}
		
	  ?>		
	

  <!-- main end-->
  </div>  
  
  <!-- center end -->  
  </div>
  
  <div class="clrb"></div>
  <div id="backtotop"><a href="#top"><img src="/images/backtotop.png" alt="Coreshop - Back to top"/></a></div>

	<?
	/* 3x infobox OFF
	$pages= array('termek', 'termekek', 'vans-benched-bag-2015');

	if (in_array($_SESSION['page'], $pages))
		include 'inc/'.$lang->defaultLangStr.'/welcome.infobox.php';		// 3 info line */
	?>
	
  <div class="footer"><? include 'inc/'.$lang->defaultLangStr.'/footer.php'; ?></div>
  
  <div class="footer-mobile"><? include 'inc/'.$lang->defaultLangStr.'/footer-mobile.php'; ?></div>
  
  </div>
  
  

<!-- belga.coreshop.hu analytics -->
<?
if ($_SERVER['SERVER_NAME']==='belga.coreshop.hu')	{
?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-42970711-1', 'coreshop.hu');
	  ga('send', 'pageview');

	</script>
<? } ?>


<script type="text/javascript">
    
jQuery(document).ready(function($) {

    $.facebox.settings.opacity = 0.6;
    $('a[rel*=facebox]').facebox({
        loadingImage : '/js/loading.gif',
        closeImage   : '/js/closelabel.png'
    })
    
    //alert
    <? /* if(isset($error->error)) {?>
        jQuery.facebox({ div:'#hibauzenet' });
    <? } */ ?>
    
    //checkout
    <? /* if(isset($error->cart)) {?>
        jQuery.facebox({ div:'#checkout' });
    <? } */ ?>
	
	// facebox popup message
    <? /* if(!ISSET($_SESSION["welcome"])) { 
			$_SESSION["welcome"] = true; ?>		
        jQuery.facebox({ div:'#welcome_message' });
    <? } */?>
		
	
	//back to top
	jQuery('#backtotop a').click(function(){
			jQuery('html, body').animate({scrollTop:0}, 'slow'); 
			return false; 
		}); 

	//mobile menu
	jQuery('#menubutton').click(function() {
	  if ( $("#mobile-menu").is( ":hidden" ) ) {
		$("#mobile-menu").slideDown( 350 );
	  } else {
		$("#mobile-menu").slideUp( 350 );
	  }
	} );
	
	//mobile menu lenyilo alkategoriak
	<? for($i=0;$i<=5;$i++)	{ ?>
	//mobile menu
	jQuery("#menu-maincat-<?=$i?>").click(function() {
		
		// osszes nyitott menu bezar
		$("#menu-subcat-0").slideUp( 500 );
		$("#menu-subcat-1").slideUp( 500 );
		$("#menu-subcat-2").slideUp( 500 );
		$("#menu-subcat-3").slideUp( 500 );
		$("#menu-subcat-4").slideUp( 500 );
		$("#menu-subcat-5").slideUp( 500 );	// sale % menu
		
	  if ( $("#menu-subcat-<?=$i?>").is( ":hidden" ) ) {
		$("#menu-subcat-<?=$i?>").slideDown( 500 );
	  } else {
		$("#menu-subcat-<?=$i?>").slideUp( 500 );
	  }
	} );		
	<? } ?>	
	
	
	//mobile search
	jQuery('#mobile-search-icon').click(function() {
	  if ( $("#mobile-search").is( ":hidden" ) ) {
		$("#mobile-search").slideDown( 350 );
	  } else {
		$("#mobile-search").slideUp( 350 );
	  }
	} );
	
	// termekoldal image zoom
	jQuery('#zoom-icon').click(function() {
	  if ( $("#zoom-div").is( ":hidden" ) ) {
		$("#product-thumbs-zoom").slideDown( 400 );
		$("#zoom-div").slideDown( 400 );		
		$("#zoom-close").slideDown( 400 );
	  } else {
		$("#product-thumbs-zoom").slideUp( 400 );
		$("#zoom-div").slideUp( 400 );		
		$("#zoom-close").slideUp( 400 );
	  }
	} );
	
	// termekoldal zoom close
	jQuery('#zoom-close').click(function() {
	  if ( $("#zoom-div").is( ":visible" ) ) {
		$("#product-thumbs-zoom").slideUp( 400 );
		$("#zoom-div").slideUp( 400 );		
		$("#zoom-close").slideUp( 400 );
	  } 
	} );
	
})

</script>

<? if(!$func->isMobile())	{ ?>
	<!--Start of Zopim Live Chat Script-->
<!--	<script type="text/javascript">-->
<!--	window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=-->
<!--	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.-->
<!--	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');-->
<!--	$.src='//v2.zopim.com/?202cSj12Xz1Jgy6z2VgulM9UBcckt1EI';z.t=+new Date;$.-->
<!--	type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');-->
<!--	</script>-->
	<!--End of Zopim Live Chat Script-->
<? } ?>

<? // enable cookies 
//<script type="text/javascript" src="//cdn.jsdelivr.net/cookie-bar/1/cookiebar-latest.min.js?top=1"></script>
?>
</body>

</html>