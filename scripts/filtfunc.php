<?
function filter($action){
	global $username;
	if (is_numeric(get("admin"))){
		$action = str_replace("&","&#38;",$action);
		$action = str_replace("<","&#60;",$action);
		$action = str_replace(":","&#58;",$action);
	}
	$actionback = explode(" ",$action);
	$action = str_replace("[i]","",$action);
	$action = str_replace("[/i]","",$action);
	$action = str_replace("[u]","",$action);
	$action = str_replace("[/u]","",$action);
	$action = str_replace("[b]","",$action);
	$action = str_replace("[/b]","",$action);
	$action = explode(" ",$action);
	for ($cfi = 0; $cfi < count($action); $cfi++){
		if (stristr($action[$cfi],"flarlar") !== false || stristr($action[$cfi],"flarlar") == "flarlar" || strtolower($action[$cfi]) == "flarlar"){
			$actionback[$cfi] = "<FONT COLOR=red>(censored)</FONT>";
		}
	}
	$actionback = implode(" ",$actionback);
	$action = $actionback;
	$numi = substr_count($action,"[i]");
	$numix = substr_count($action,"[/i]");
	for ($cfi = $numi - $numix; $cfi > 0; $cfi--) $action .= "[/i]";
	$numb = substr_count($action,"[b]");
	$numbx = substr_count($action,"[/b]");
	for ($cfi = $numb - $numbx; $cfi > 0; $cfi--) $action .= "[/b]";
	$numu = substr_count($action,"[u]");
	$numux = substr_count($action,"[/u]");
	for ($cfi = $numu - $numux; $cfi > 0; $cfi--) $action .= "[/u]";
	$action = str_replace("[i]","<I>",$action);
	$action = str_replace("[/i]","</I>",$action);
	$action = str_replace("[b]","<B>",$action);
	$action = str_replace("[/b]","</B>",$action);
	$action = str_replace("[u]","<U>",$action);
	$action = str_replace("[/u]","</U>",$action);
	$action = str_replace("[dnote]","&#9835;",$action);
	$action = str_replace("[snote]","&#9834;",$action);
	$action = str_replace("[diamond]","&#9830;",$action);
	$action = str_replace("[heart]","&#9829;",$action);
	$action = str_replace("[club]","&#9827;",$action);
	$action = str_replace("[spade]","&#9824;",$action);
	$action = str_replace("[rt]","&#174;",$action);
	$action = str_replace("[deg]","&#176;",$action);
	$action = str_replace("[cr]","&#169;",$action);
	$action = str_replace("[tm]","&#8482;",$action);
	$action = str_replace("[sm]","&#8480;",$action);
	$action = str_replace("[inf]","&#8734;",$action);
	$action = str_replace("[wsmile]","&#9787;",$action);
	$action = str_replace("[bsmile]","&#9786;",$action);
	$action = str_replace("[girl]","&#9792;",$action);
	$action = str_replace("[boy]","&#9794;",$action);
	return $action;
}
function afilter($action){
	global $username;
	if (is_numeric(get("admin"))){
		$action = str_replace("&","&#38;",$action);
		$action = str_replace(":","&#58;",$action);
	}
	$actionback = explode(" ",$action);
	$action = str_replace("[i]","",$action);
	$action = str_replace("[/i]","",$action);
	$action = str_replace("[u]","",$action);
	$action = str_replace("[/u]","",$action);
	$action = str_replace("[b]","",$action);
	$action = str_replace("[/b]","",$action);
	$action = explode(" ",$action);
	for ($cfi = 0; $cfi < count($action); $cfi++){
		if (stristr($action[$cfi],"shit") !== false || stristr($action[$cfi],"fuck") !== false || stristr($action[$cfi],"cunt") !== false || stristr($action[$cfi],"wanker") !== false || stristr($action[$cfi],"ass") == "asshole" || strtolower($action[$cfi]) == "dumbass"){
			$actionback[$cfi] = "<FONT COLOR=red>(censored)</FONT>";
		}
	}
	$actionback = implode(" ",$actionback);
	$action = $actionback;
	$numi = substr_count($action,"[i]");
	$numix = substr_count($action,"[/i]");
	for ($cfi = $numi - $numix; $cfi > 0; $cfi--) $action .= "[/i]";
	$numb = substr_count($action,"[b]");
	$numbx = substr_count($action,"[/b]");
	for ($cfi = $numb - $numbx; $cfi > 0; $cfi--) $action .= "[/b]";
	$numu = substr_count($action,"[u]");
	$numux = substr_count($action,"[/u]");
	for ($cfi = $numu - $numux; $cfi > 0; $cfi--) $action .= "[/u]";
	$action = str_replace("[i]","<I>",$action);
	$action = str_replace("[/i]","</I>",$action);
	$action = str_replace("[b]","<B>",$action);
	$action = str_replace("[/b]","</B>",$action);
	$action = str_replace("[u]","<U>",$action);
	$action = str_replace("[/u]","</U>",$action);
	$action = str_replace("[dnote]","&#9835;",$action);
	$action = str_replace("[snote]","&#9834;",$action);
	$action = str_replace("[diamond]","&#9830;",$action);
	$action = str_replace("[heart]","&#9829;",$action);
	$action = str_replace("[club]","&#9827;",$action);
	$action = str_replace("[spade]","&#9824;",$action);
	$action = str_replace("[rt]","&#174;",$action);
	$action = str_replace("[deg]","&#176;",$action);
	$action = str_replace("[cr]","&#169;",$action);
	$action = str_replace("[tm]","&#8482;",$action);
	$action = str_replace("[sm]","&#8480;",$action);
	$action = str_replace("[inf]","&#8734;",$action);
	$action = str_replace("[wsmile]","&#9787;",$action);
	$action = str_replace("[bsmile]","&#9786;",$action);
	$action = str_replace("[girl]","&#9792;",$action);
	$action = str_replace("[boy]","&#9794;",$action);
	return $action;
}
?>