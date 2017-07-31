<?php
require("../includes/helpers.php");
session_start() ;
if($_SERVER["REQUEST_METHOD"] === "GET"){
	render("search_view.php",["title" => "search"]) ;
}
else{
	if(!empty($_POST[link])){
		$auth = base64_encode('shanigaram:8NJfxQ8x');

		$aContext = array(
			'http' => array(
				'proxy' => 'tcp://202.141.80.24:3128',
				'request_fulluri' => true,
				'header' => "Proxy-Authorization : Basic $auth"
			),
		);
		$cxContext = stream_context_create($aContext);

		$source=file_get_contents($_POST[link], False, $cxContext);
		
		if(preg_match_all('@<h2 class="tuple-clg-heading"><a href="[^"]+" target="_blank">\s*(.+)@',$source,$matches)){
			
			preg_match_all('@<h2 class="tuple-clg-heading"><a href="(.+)" target="_blank">@',$source,$links);
			
			
			
				for($i=0;$i<3;$i++){
				
					$clg=file_get_contents($links[1][$i],False,$cxContext);
					if(preg_match_all('@<a class="[^"]+">\s*(.+)\s*</a>@',$clg,$facilities)){
					
						preg_match_all('@<span class="location-of-clg">, (.+)</span></h1>@',$clg,$address);
						
						echo $matches[1][$i].'--->'.$address[1][0].'<br>';
						
						preg_match_all('@Showing [\d*] of (\d+) reviews@',$clg,$review);
						for($j=0;$j<count($facilities[1]);$j++){
							//preg_match('@\|\s*(.+)@',$address[1][$i],$add);
							echo $facilities[1][$j].'    ' ;
						}
						echo '<br>no of reviews'.$review[1][0].'<br>';			
					
					
					}
					sleep(2);
				}	
				
			
		}
		else{
			$msg="not found";
			var_dump($matches);
			echo $msg."sorry".$source ;
			
		}
	}
	else{
		$msg="you must provide the link";
		apologize($msg);
	}

}
?>
