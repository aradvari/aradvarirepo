<div class="subpages">

<a href="/" style="border:none;"><img src="/images/home.png" stlye="vertical-align:middle;"/></a>

<?
/*
// domain check
if ($_SERVER['SERVER_NAME']==='belga.coreshop.hu')
	$home='http://coreshop.hu/';
else
	$home='/'; */
	
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_aszf).'">'.$lang->aszf.'</a>';
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_aszf).'#1">'.$lang->vasarlas.'</a>';
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_szallitas).'">'.$lang->szallitas.'</a>';
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_aszf).'#7">'.$lang->szavatossag.'</a>';
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->termekcsere).'">'.$lang->termekcsere.'</a>';
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->kapcsolat).'">'.$lang->kapcsolat.'</a>';
echo '<a href="/'.$_SESSION["langStr"].'/'.$func->convertString($lang->_uzletunk).'">'.$lang->uzletunk.'</a>';

?>
	
</div>