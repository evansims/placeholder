# What is php-placeholder?
It's a PHP based script that generates placeholder graphics for use in visual mockups, design prototypes, and so on. When you're "in the zone" with your code and you don't want to break out Photoshop or Pixelmator, just have this script accessible somewhere, hot link it in with the appropriate parameters for your situation and you're good to go.

php-placeholder includes [Jason Kottke's Silkscreen font](http://kottke.org/plus/type/silkscreen/) for generated text.

## Examples
![php-placeholder-1](http://dl.dropbox.com/u/23890/ex/php-placeholder-1.png) &nbsp; ![php-placeholder-2b](http://dl.dropbox.com/u/23890/ex/php-placeholder-2b.png)

## Installation
Couldn't be simpler. Download it, drop it in a folder, and hot link to the script from your page. It just requires a relatively recent version of PHP with GD installed.

## Customizing
You can customize the output of the placeholder art by passing URL parameters to the script. Supported options include: width, height, color, text, font, fontsize, rounded (enabled by default, pass it false to disable.) and grid.

Example: `<img src="./placeholder.php?width=320&amp;height=240&amp;text=Hi!" />`

The Grid option overrides the default "X" styling and instead renders a rectangular grid pattern, the size of which is assigned by the "grid" parameter. If you want a grid with 20px blocks, you'd set grid=20. Simple, eh?