<?php

	putenv('GDFONTPATH=' . realpath('.'));

	$width = (isset($_GET['width']) ? (int)$_GET['width'] : 400);
	$height = (isset($_GET['height']) ? (int)$_GET['height'] : 200);
	$color = (isset($_GET['color']) ? $_GET['color'] : 'black');
	$grid = (isset($_GET['grid']) ? (int)$_GET['grid'] : 'no');
	$text = (isset($_GET['text']) ? $_GET['text'] : "{$width} x {$height}");
	$font = (isset($_GET['font']) ? $_GET['font'] : realpath('slkscr.ttf'));
	$fontsize = (isset($_GET['fontsize']) ? $_GET['fontsize'] : 8);
	$rounded = (isset($_GET['rounded']) ? (bool)$_GET['rounded'] : true);

	$canvas = imagecreatetruecolor($width, $height);

	$backdrop = imagecolorallocatealpha($canvas, 255, 0, 255, 127);
	imagesavealpha($canvas, true);
	imagealphablending($canvas, false);
	imagefill($canvas, 0, 0, $backdrop);

	$white = imagecolorallocate($canvas, 255, 255, 255);
	$black = imagecolorallocate($canvas, 0, 0, 0);

	if($color == 'white'):
		$color = $white; // white
	elseif($color == 'red'):
		$color = imagecolorallocate($canvas, 255, 0, 0);
	elseif($color == 'green'):
		$color = imagecolorallocate($canvas, 0, 255, 0);
	elseif($color == 'blue'):
		$color = imagecolorallocate($canvas, 0, 0, 255);
	elseif($color == 'yellow'):
		$color = imagecolorallocate($canvas, 255, 255, 0);
    elseif(strlen($color) == 6):
    	if($color == '000000'):
    		$color = $black;
    	elseif($color == 'FFFFFF'):
    		$color = $white;
	    else:
	    	$color = imagecolorallocate($canvas,
		    	base_convert(substr($color, 0, 2), 16, 10),
		    	base_convert(substr($color, 2, 2), 16, 10),
		    	base_convert(substr($color, 4, 2), 16, 10)
		    );
		endif;
	else:
		$color = $black; // black
	endif;

	if($grid == 'no'):
		imageline($canvas, 0, 1, $width, $height - 1, $color);
		imageline($canvas, $width, 1, 0, $height - 1, $color);
		imagerectangle($canvas, 0, 0, $width-1, $height-1, $color);
	elseif(is_numeric($grid)):
		for($y = $grid; $y < $height; $y = $y + $grid):
			imageline($canvas, 0, $y, $width, $y, $color);
		endfor;

		for($x = $grid; $x < $width; $x = $x + $grid):
			imageline($canvas, $x, 0, $x, $height, $color);
		endfor;

		imagerectangle($canvas, 0, 0, $width-1, $height-1, $color);
	endif;

	if($rounded):
		imagesetpixel($canvas, 0, 0, $backdrop);
		imagesetpixel($canvas, 0, $height -1, $backdrop);
		imagesetpixel($canvas, $width -1, 0, $backdrop);
		imagesetpixel($canvas, $width -1, $height -1, $backdrop);
	endif;

	if(strlen($text)):
		$box = imagettfbbox(8, 0, $font, $text);
		$tx = floor($width / 2) - floor($box[2] / 2);
		$ty = floor($height / 2) + floor($fontsize / 2);

		// Draw text backdrop.
		imagefilledrectangle($canvas, $tx - 5, $ty - 11, $tx + $box[2] + 3, $ty + ($fontsize / 2), $color);

		// Add some rounded border flourish for good measure.
		if($rounded):
			imagesetpixel($canvas, $tx - 5, $ty - 11, $backdrop);
			imagesetpixel($canvas, $tx + $box[2] + 3, $ty - 11, $backdrop);
			imagesetpixel($canvas, $tx - 5, $ty + ($fontsize / 2), $backdrop);
			imagesetpixel($canvas, $tx + $box[2] + 3, $ty + ($fontsize / 2), $backdrop);
		endif;

		imagealphablending($canvas, true);
		//imagettftext($canvas, 8, 0, $tx+1, $ty+1, -$black, $font, $text); // Text shadow.
		imagettftext($canvas, 8, 0, $tx, $ty, -$white, $font, $text);
	endif;

	header("Content-Type: image/png");
	imagepng($canvas);
	imagedestroy($canvas);
