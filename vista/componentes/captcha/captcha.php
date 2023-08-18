<?php

header("content-type: image/png");

$imagen = imagecreatetruecolor(200, 50);
imageantialias($imagen, true);

$colors = [];

$red = rand(125, 175);
$green = rand(125, 175);
$blue = rand(125, 175);


$black = imagecolorallocate($imagen, 0, 0, 0);
$white = imagecolorallocate($imagen, 255, 255, 255);
$textcolors = [$black, $white];
 
$fonts = ['Cookie.ttf', 'acme.ttf'];
 
$string_length = 4;

for($i = 0; $i < 5; $i++) {
	$colors[] = imagecolorallocate($imagen, $red - 20*$i, $green - 20*$i, $blue - 20*$i);
}

imagefill($imagen, 0, 0, $colors[0]);

for($i = 0; $i < 10; $i++) {
	imagesetthickness($imagen, rand(2, 10));
	$rect_color = $colors[rand(1, 4)];
	imagerectangle($imagen, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $rect_color);
}

$color_fondo = imagecolorallocate($imagen, 59, 66, 255);

$color_texto = imagecolorallocate($imagen, 255, 255, 255);

function generar_caracteres($chars, $length){

	$captcha = null;
	for ($i=0; $i < $length; $i++) {

		$rand = rand(0, count($chars)-1);
		$captcha .= $chars[$rand];
	}

	return $captcha;
}

$captcha = generar_caracteres(array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'), 4);

for($i = 0; $i < $string_length; $i++) {
  $letter_space = 170/$string_length;
  $initial = 15;
   
  imagettftext($imagen, 20, rand(-15, 15), $initial + $i*$letter_space, rand(20, 40), $textcolors[rand(0, 1)], $fonts[array_rand($fonts)], $captcha[$i]);
}
 
imagepng($imagen); 

setcookie("captcha", sha1($captcha), time()+ 86400, "/");

?>