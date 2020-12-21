<?php
include_once 'HtmlWeb.php';
use simplehtmldom\HtmlWeb;

$doc = new HtmlWeb();

$csvFile = file("blogsList.csv");

foreach ($csvFile as $k => $line) {
	$blogDetails = [];
	$url = trim('https://www.summersphc.com'. $line);
	$html = $doc->load($url);

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
	$blogDetails[] = trim( $html->find('.content-box', 0));

	$result = writeCsv($blogDetails);
}

echo "Done";

function writeCsv($data)
{

	  $file = fopen("blogs.csv","a+");

	  fputcsv($file, $data);

	  fclose($file);
}