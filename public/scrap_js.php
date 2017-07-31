<?php
require("../includes/helpers.php");
if($_SERVER["REQUEST_METHOD"]==="GET"){
	if(empty($_GET[link])){
		$data="pelase provide the link";
		header("Content-type: application/json") ;
		print(json_encode($data,JSON_PRETTY_PRINT)) ;
		die();
	}
	//getting contents of link
	$source=file_get_contents($_GET[link]);
	$data='<div class="container"> ';
	//scrap the name of the colleges
	if(preg_match_all('@<h2 class="tuple-clg-heading"><a href="[^"]+" target="_blank">\s*(.+)@',$source,$matches)){
			
			//scraping the individual link of each college
			preg_match_all('@<h2 class="tuple-clg-heading"><a href="(.+)" target="_blank">@',$source,$links);
			
			
			
				for($i=0;$i<count($matches[1]);$i++){
				
					$clg=file_get_contents($links[1][$i],False,$cxContext);
					if(preg_match_all('@<a class="[^"]+">\s*(.+)\s*</a>@',$clg,$facilities)){
					
						preg_match_all('@<span class="location-of-clg">, (.+)</span></h1>@',$clg,$address);
						$data=$data.'<table class="table table-bordered">
									<thead>
	    								<tr>
	      								<th> <p align="justify">'.$facilities[1][0].$matches[1][$i].'</p> </th>
										</tr>
    								</thead>
    							<tbody>
    							<tr>';
						$data=$data.'<td align="left">'.$address[1][0].'</td>
        								</tr>
    									<tr>
    								<td  align="left">';
						
						preg_match_all('@Showing [\d*] of (\d+) reviews@',$clg,$review);
						$fac='';
						for($j=1;$j<count($facilities[1]);$j++){
							$fac = $fac.'<button type="button" class="btn btn-default">'.$facilities[1][$j] ;
						}
						$data = $data.$fac;
						$data=$data.'</tr>';
						/*$connect=database_connect();
						
					
						
						$add=$address[1][0];
						$college=$matches[1][$i];
						$reviews=$review[1][0];
					//	$query="INSERT INTO `colleges` (`college`, `addresss`,  `reviews`) VALUES ('$college','$add','$reviews');";
					//	$stat=query($connect,$query);*/
						
						$data=$data.' <tr>
    								<td align="left">';
						if(preg_match_all('@Showing [\d*] of (\d+) reviews@',$clg,$review))
							$data = $data.'<span>no of reviews '.$review[1][0].'</span></td></tr>';
						else
							$data = $data.'<span>no of reviews 0</span></td></tr>';
						$data=$data.'</tbody>
									</table>';
					}
					sleep(1);
				}	
				
			
		}
		else{
			$data="provide a valid link";
			
		}
		$data=$data.'</div>';
	header("Content-type: application/json") ;
	print(json_encode($data,JSON_PRETTY_PRINT)) ;	
}
?>
