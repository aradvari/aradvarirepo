<style type="text/css">
<!--
.vansform {margin:20px 10px; padding:20px; }
.vanskep {width:200px; display:inline-block; margin:5px; }
-->
</style>

<? // http://images.vans.com/is/image/Vans/48AM4Z-HERO?id=2dqqn2&wid=2000&hei=2000 ?>
	
<form action="" method="POST">
	<input type="text" name="cikkszam" placeholder="Vans cikkszám" style="width:200px;" value="<?=$_POST['cikkszam']?>" class="vansform" />
	<input type="submit" value=" keres &rsaquo;" class="vansform">
</form>





<?

//	48AM4Z

//	VA348AM4Z

$cikkszam = $_POST['cikkszam'];

//$cikkszam = substr($_POST['cikkszam'], 3, 9); // returns "de"

echo '.COM<br /><br />';

echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-HERO?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT1?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT2?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT3?id=2dqqn2&wid=920&hei=920" class="vanskep" /><br />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT4?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT5?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT6?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT7?id=2dqqn2&wid=920&hei=920" class="vanskep" /><br />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT8?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT9?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT10?id=2dqqn2&wid=920&hei=920" class="vanskep" />';
echo '<img src="http://images.vans.com/is/image/Vans/'.$cikkszam.'-ALT11id=2dqqn2&wid=920&hei=920" class="vanskep" />';


echo '<br /><br />.EU<br /><br />';


echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-HERO?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT1?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT2?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT3?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" /><br />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT4?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT5?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT6?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
echo '<img src="https://images.vans.com/is/image/VansEU/'.$cikkszam.'-ALT7?fit=constrain%2C1&wid=920&hei=920&fmt=jpg" class="vanskep" />';
