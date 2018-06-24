<?
// 2017 XMAS KIEGESZITOK
?>
<style type="text/css">
<!--

.vans-accessories	{
	padding:1%;
	background-color:#a4e0fc;
	background:url(/banner/2017/20171201-vans-accessories/20171201-xmas-slider-only-bg.jpg) top center;
	background-size:100% auto;
	color:#000;
	overflow:auto;	
	letter-spacing:0;
	font-size:1.2em;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	max-width:1250px;
	margin-top:-10px;
	}

.vans-accessories	span	{
	color:#e86378; 
	background:#fff5aa;
	display:block;
	margin-bottom:10px;
	text-align:center;
	padding:10px;
	text-shadow:none;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	}

.vans-accessories-cont	{
	text-align:center;
}
	
.vans-accessories-thumb	{
	position:relative; 
	margin-top:10px;
	width:calc(100%/3);
	float:left;
}

.vans-accessories-thumb a {
	color:#000;
}

.vans-accessories-thumb p { text-align:center; white-space: nowrap; color:#e86378; background:#fff5aa; padding:4px; margin:0 8px; font-size:0.8em; text-transform:none; -webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px; }

.vans-accessories-number { 
	display:none;
	position:absolute; 
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	background:#2a87e4;
	top:0px;
	left:10px;
	padding:2px 6px;
	color:#fff;
	font-weight:bold;
	font-size:0.8em;
	}

.vans-accessories-thumb img	{
	width:50%;
	border:none;
	margin:0;
}


@media screen and (max-width: 780px) {
	.vans-accessories { font-size:0.8em;}
	.vans-accessories-thumb img	{width:60%;}
	 }
	 
@media screen and (max-width: 580px) {
	.vans-accessories-thumb { width:calc(100%/2);
	}
}


	
-->
</style>


<div class="vans-accessories">
<a href=""><span>Decemberben minden 20.000 Ft feletti rendelés mellé <strong>VANS</strong> kiegészítőt ajándékozunk!</span></a>
<div class="vans-accessories-cont">
A megrendelés oldalon írd be a MEGJEGYZÉS mezőbe, hogy melyik <strong>SZÁMÚ</strong> kiegészítőt választod az alábbiak közül:<br />

	<?
	$accessories = array(/*7283=>'Pom Beanie<br />kötött sapka',*/ /*7284=>'Grove MTE Beanie<br />kötött sapka',*/ /*7278=>'Mismoedig Beanie<br />kötött sapka',*/ /*5306=>'Patch Trucker<br />baseball sapka',*/ 1627=>'Slipped<br />pénztárca', 6294=>'Benched Bag<br />tornazsák', 5495=>'Spicoli 4 Shades<br />napszemüveg', /*4411=>'Conductor<br />textil öv'*/ );

	$i=1;
	foreach($accessories as $accessorie=>$name)	{

		/* echo '<div class="vans-accessories-thumb">
		<a href="/banner/2015/vans-accessories/large/'.$beanie.'.jpg" class="highslide" onclick="return hs.expand(this)">
		<img src="/banner/2015/vans-accessories/small/'.$beanie.'.jpg" />
		'.$color.'</a>
		</div>'; */
		
		
		$img = $func->getHDir($accessorie);
		
		echo '<div class="vans-accessories-thumb">
		<div class="vans-accessories-number">'.$i.'</div>
		<a href="/'.$img.'1_large.jpg" class="highslide" onclick="return hs.expand(this)">
		<img src="/banner/2017/20171201-vans-accessories/'.$accessorie.'.png" alt="Vans '.$name.'" title="Vans '.$name.'" />
		<p>'.$name.'</p></a>
		</div>';
		
		$i++;
		}
	?>
</div>
</div>