<?php
if(isset($_GET["page"])){
	$page = $_GET["page"];
}
else {
	$page = 1;
}

$start = $page*10-10;
$query = "*%3A*";
$url = "http://localhost:8983/solr/jcg/select?q=".$query."&wt=php";
$file = file_get_contents($url."&start=".$start);
eval("\$result = " . $file . ";");
$numOfPages = ceil($result["response"]["numFound"]/10);



for($i=0; $i<count($result["response"]["docs"]) ; $i++){
	echo "=========Result ".($i+$start+1)."=========<br>";
	foreach($result["response"]["docs"][$i] as $k=>$v){
		display($k,$v);
		echo "<br>";
	}
	echo "<br>";
}

function display($k,$x){
	if($k=="_version_"){
		return;
	}
	
	echo $k.": ";
	
	if(!is_array($x)){
		echo $x;
		return;
	}
	
	for($i=0; $i<count($x); $i++){
		echo $x[$i]."-";
	}
}

for($i=0; $i<$numOfPages; $i++){
	echo "<a href='Attempt.php?page=".($i+1)."'>[".($i+1)."]</a> ";
}
?>
