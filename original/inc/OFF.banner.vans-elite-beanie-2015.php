<style type="text/css">
<!--

.vans-elite-beanie	{
	border-top:1px solid #1a3766;
	border-bottom:1px solid #1a3766;
	padding:1%;
	background-color:#b0adb4;
	background-image:url(/banner/2015/vans-elite-beanie/vans-elite-beanie-topbanner.jpg);
	background-size:100% auto;
	color:#000;
	overflow:auto;	
	letter-spacing:0;
	font-size:1.2em;
	/*text-shadow:1px 1px #ccc;*/
	}

.vans-elite-beanie	span	{
	color:#fff;
	display:block;
	max-width:720px;
	margin-bottom:10px;
	background-color:#ff4c4b;
	padding:10px;
	text-shadow:none;
	}

.beanie-cont	{
	max-width:720px;
	text-align:center;
}
	
.beanie-thumb	{
	margin-top:10px;
	width:calc(100%/6);
	max-width:120px;
	float:left;
}

.beanie-thumb a {
	color:#000;
}

.beanie-thumb img	{
	width:90%;
	border:none;
	margin:0;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

@media screen and (max-width: 500px) {
	.beanie-thumb	{ font-size:0.6em;	}
}
	
-->
</style>


<div class="vans-elite-beanie">
<a href="/hu/vans-elite-beanie-2015"><span>December 6.-ig minden 20.000 Ft feletti rendelés mellé "VANS Elite Beanie" kötött sapkát ajándékozunk!</span></a>
<div class="beanie-cont">
Írd be a megrendelés oldal MEGJEGYZÉS mezőbe, hogy melyik számú sapkát választod az alábbiak közül:<br />

	<?
	$beanies=array(/*5992=>'Black Iris',*/ 5991=>'Sycamore', 5990=>'French Blue', /*5890=>'Black/Jester Red',*/ 5889=>'Anchorage', 5888=>'Exblusive' );

	foreach($beanies as $beanie=>$color)

		echo '<div class="beanie-thumb">
		<a href="/banner/2015/vans-elite-beanie/large/'.$beanie.'.jpg" class="highslide" onclick="return hs.expand(this)">
		<img src="/banner/2015/vans-elite-beanie/small/'.$beanie.'.jpg" />
		'.$color.'</a>
		</div>';
	?>
</div>
</div>