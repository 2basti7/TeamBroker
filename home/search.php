<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Google</title>
	
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
</head>

<body>		
<form action="search.php" method="get">	
<img src="googleSmall.png" class="img-rounded" alt="google logo" >	
<input type="search" name="q" value="<?=$_GET['q']?>">
<input type="submit" value = "Search!"/>								   
</form>
<!-- content -->

<?php
$searchValue = str_replace(' ', '+', $_GET['q']);
$neu_link = "https://www.google.de/search?hl=en&q=".$searchValue;
$seite = file_get_contents($neu_link);

preg_match_all('/<h3[^>]*><a[^>]+href="([^"]*)"[^>]*>(.+?)<\/a>/', $seite, $result, PREG_SET_ORDER); // RegExp angepasst. Beachte die Ergebnisstruktur (PREG_SET_ORDER)!
$resulthtml = array(); // Stelle das Ergebnis etwas schöner dar (als Verlinkte Aufzählung)
foreach ($result as $r) {
	$urlSub = substr(htmlentities($r[1]), 7);
	$url = explode("&", $urlSub);
$resulthtml[] = array('url' => htmlentities($r[1]), 'linktext' => '<a href="' . $url[0] . '">' . $r[2] . '</a>');
}
$arr = array("url" => "http://teambroker.ddns.net", "linktext" => '<a href="' . 'http://teambroker.ddns.net' . '">' . 'The worlds best <strong>stock analysis</strong> site!' . '</a>');
if (strpos($searchValue,'stock') !== false) {
array_unshift($resulthtml, $arr);
}

echo '<pre>';
//print_r($resulthtml);
echo '</pre>';

// Wenn du nur die Liste mit URLs und Linknamen willst, kannst du auch einfach folgendes machen:
$resultlist = array();
foreach ($result as $r) {
$resultlist[] = array('url' => $r[1], 'linktext' => $r[2] );
}?>

<div class = "row">
<br><br><br>
<div class = "col-md-1">
</div>
<div class = "col-md-6">
<?php
echo '<table style="width:100%" margin-left="2cm">';
foreach($resulthtml as $res){
	
	echo "<tr>";
		echo "<br>";
		echo "<div>".$res['linktext']."<br><br><br></div>";
		//$url = $res['url'];
		//$teile = explode("&", $url);
		//echo $res['url'];
	echo "</tr>";
	
}
echo '</table>';
// $resultlist ist jetzt ein Array von Arrays, das du z.B. so zugreifen kannst:
// $linkurl = $resultlist[13]['url'];
// $linktext = $resultlist[13]['linktext'];

?>
</div>
</body>
</html>
