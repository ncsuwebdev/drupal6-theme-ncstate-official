<?php

//needs to be cleaned up and validated/verified that there's no holes in it...but it works for now...

// get the text from the variable passed to it, and convert to upper case (as per branding styles)
$width = $_GET['width'];
$boldText = $_GET['boldText'];
$regularText = $_GET['regularText'];

// Create a ? x 40 image (the space available in the header section of the theme)
$height = 40;

// set the height of the font (used for the height of the image too + some padding)
$fontSize = 35;

// set up base image, and colors to be used in the image (black not used for this page, but left for reference later)
$im = imagecreatetruecolor($width, $height);
$black = imagecolorallocate($im, 0, 0, 0);
$red = imagecolorallocate($im, 196, 10, 20);
$white = imagecolorallocate($im, 255, 255, 255);

// Set the background to be red (the base color of the header region where this will be placed)
imagefilledrectangle($im, 0, 0, $width, 299, $red);

// Path to our font files
$regularFont = 'UVC_____.TTF';
$boldFont = 'UVCB____.TTF';

// First we create our bounding box for the first text
$boldBox = imagettfbbox($fontSize, 0, $boldFont, $boldText);

// This is our cordinates for X and Y for the bold text
$boldX = $boldBox[0]; // bottom left corner of the box
$boldY = $boldBox[1] + imagesy($im) - 4; // bottom left corner of the box -4 for adjustment to fit inside bounding box

// Write it
imagettftext($im, $fontSize, 0, $boldX, $boldY, $white, $boldFont, $boldText);

// Create the next bounding box for the second text
$regbox = imagettfbbox($fontSize, 0, $regularFont, $regularText);

// Set the cordinates so its next to the first text
$regX = $boldBox[4] + 20; // top right of bold text, + 20px padding to move it far enough away
$regY = $boldBox[1] + imagesy($im) - 4; // same Y coords as the bold box, as you want it on the same horizontal line too.

// Write it
imagettftext($im, $fontSize, 0, $regX, $regY, $white, $regularFont, $regularText);

// uncomment this line to make the image have a transparent background (it leaves some artifacts around the text, so it might be easier to just set the background color like we did with $red)
imagecolortransparent ($im,$red);

//write the image to the <THEMEROOT>/images/base directory for use in page.tpl.php
imagepng($im, '../images/base/site_title_image.png');

/*
 * 
 * COMMENTED OUT BELOW WHEN CHANGED FROM RETURNING THE PNG TO SAVING IT IN A DIRECTORY 
 *
*/

// Output to browser
 header('Content-type: image/png');
 imagepng($im);
imagedestroy($im);
?>
