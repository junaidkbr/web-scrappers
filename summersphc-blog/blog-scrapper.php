<?php
include_once 'HtmlWeb.php';
use simplehtmldom\HtmlWeb;

// get DOM from URL or file
$doc = new HtmlWeb();

//Load file
$csvFile = file("blogsList.csv");

foreach ($csvFile as $k => $line) {
	$blogDetails = [];
	$url = trim('https://www.summersphc.com'. $line);
	$html = $doc->load( $url );

	$blogDetails[] = $html->find('head link[rel=canonical]', 0)->href;
	$blogDetails[] = $html->find('head meta[name=description]', 0)->content;
	$blogDetails[] = $html->find('head meta[property=og:title]', 0)->content ?? '';
	$blogDetails[] = $html->find('head meta[property=og:description]', 0)->content ?? '';
	$blogDetails[] = $html->find('head meta[property=og:image]', 0)->content ?? '';
	$blogDetails[] = $html->find('head meta[name=twitter:card]', 0)->content ?? '';
	$blogDetails[] = $html->find('head meta[name=twitter:title]', 0)->content ?? '';
	$blogDetails[] = $html->find('head meta[name=twitter:description]', 0)->content ?? '';
	$blogDetails[] = $html->find('head meta[name=twitter:image]', 0)->content ?? '';
	$blogDetails[] = $html->find('article[id=MainZone] h1[itemprop=headline]', 0)->plaintext;
	$blogDetails[] = $html->find('article[id=MainZone] img', 0)->src;
	$blogDetails[] = $html->find('article[id=MainZone] time', 0)->plaintext;
	$blogDetails[] = trim(str_replace(',', '|||||', $html->find('.content-box', 0)));
	// echo '<pre>';
	// print_r( $blogDetails );exit;

	$result = writeCsv( $blogDetails );
	echo 'done';
	break;
}

function writeCsv( $data )
{

	  $file = fopen( "blogs.csv","a+" );

	  fputcsv($file, $data);

	  fclose($file);
	  return;
}