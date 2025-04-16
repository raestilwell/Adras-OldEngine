<?php

function formatInfo($peep, $attribute) {
	$value = getuser($peep, $attribute);

	if ($value == "") {
		return "";
	} else {
		return "<i>" . $value . "</i>";
	}
}

function formatEquipment($peep, $slot) {
	$item = getuser($peep, $slot);
	return "<i>" . ($item != "" ? $item : "nothing") . "</i>";
}

function getOrganizationInfo($peep, $organizationType, $singular, $plural) {
	$organization = getuser($peep, $organizationType);
	$name = formatInfo($peep, "name"); // Retrieve the name

	if ($organization == "") {
		return "$name is not a member of a $singular.";
	} else {
		return "$name is a member of the $singular <i>" . $organization . "</i>.";
	}
}

function generateRetDescription($peep, $petData) {
	$ret = "The " . get("race") . " known as " . get("name") . " is here";
	if (!empty($petData)) {
		$ret .= " with " . get("pet") . ".";
	} else {
		$ret .= ".";
	}

	return $ret;
}

function getGenderPronouns($gender)
	{
		switch ($gender) {
			case "male":
				return ["He", "he", "his"];
			case "female":
				return ["She", "she", "her"];
			default:
				return ["They", "they", "their"];
		}
	}
			
function getGrammarArticle($word)
		{
			return (in_array(strtolower($word[0]), ['a', 'e', 'i', 'o', 'u'])) ? "an" : "a";
		}
			
function generateArmDescription($peep, $HeShe, $hisher, $gendergrammar, $gender, $head, $ears, $neck, $body, $larm, $rarm, $wrists, $hands, $fingers, $legs, $feet)
		{
			if (strtolower($gender) == "male" || strtolower($gender) == "female") {
				$armDescription = "$HeShe has $head on $hisher head and $ears on $hisher ears. $HeShe has $neck on $hisher neck. $HeShe is wearing $body on $hisher body with $larm on $hisher left arm and $rarm on $hisher right arm and $wrists on $hisher wrists. $HeShe has $hands on $hisher hands with $fingers on $hisher fingers. $HeShe has $legs on $hisher legs and $feet on $hisher feet.";
			} else {
				$armDescription = "$HeShe have $head on $hisher head and $ears on $hisher ears. $HeShe have $neck on $hisher neck. $HeShe are wearing $body on $hisher body with $larm on $hisher left arm and $rarm on $hisher right arm and $wrists on $hisher wrists. $HeShe have $hands on $hisher hands with $fingers on $hisher fingers. $HeShe have $legs on $hisher legs and $feet on $hisher feet.";
			}
		
			return $armDescription;
		}

?>