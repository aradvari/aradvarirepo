<style type="text/css">
<!--
	.app_banner	{
		width:				100%;
		padding:			5%;
		font-size:			3em; /* 4em */
		text-align:			center;
		color:				#fff;
		
		background-color:	#333;
		background:			-webkit-gradient(linear, 0 0, 0 100%, from(#666), to(#333));
		background:			-moz-linear-gradient(#666, #333);
		background:			-o-linear-gradient(#666, #333);
		background:			linear-gradient(#666, #333);
		
		margin-bottom:		7%;
		
	}
	
	.app_banner a {	
		color:				#eee;		
		letter-spacing:		-2px;
	}
-->
</style>
<?

// check browser for download banner
$browser = $_SERVER['HTTP_USER_AGENT'];

//echo $browser;

// stristr: non case sensitive search

if ( (stristr($browser, 'ios')) || (stristr($browser, 'iphone')) )
//if ( stristr($browser, 'ios') )
	echo '<div class="app_banner">
	<a href="https://itunes.apple.com/us/app/coreshop/id943167839">
	<img src="/appshop/images/icon/appstore_coreshop.png" style="vertical-align:middle" />&nbsp;
	Töltsd le alkalmazásunkat az AppStore-ból!</a>
	</div>';

if ( stristr($browser, 'android') )
	echo '<div class="app_banner">
	<a href="https://play.google.com/store/apps/details?id=hu.coreshop">
	<img src="/appshop/images/icon/google_play_coreshop.png" style="vertical-align:middle" />&nbsp;
	Töltsd le alkalmazásunkat a Play Áruházból!
	</a></div>';