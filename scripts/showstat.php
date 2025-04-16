<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/statspage.css">
</head>

<body>
<div class="wrap">

<?
$command = 1;
$name = get("name");
$race = get("race");
$guild = get("guild");
$clan = get("clan");
$militia = get("militia");
$rank = get("rank");
if (!$clan) $clan = "no clan";
if (!$guild) $guild = "no guild";
if (!$militia) $militia = "no militia";
$class = get("class");
$gender = get("gender");
$eyes = get("eyes");
$hair = get("hair");
$skin = get("skin");
$height = get("height");
$build = get("build");
$plane = get("plane");
$spouse = get("spouse");
$fame = get("famerank");
$piety = get("piety");
$proficiency = get("proficiency");
$quests = get("quests");
$deity = get("deity");
$home = get("hometown");
$birth = date("l, n/j/Y",get("created"));
$p = get("recallplane");
if (get("recall") == "") $recall = "none"; else $recall = getlevel("$p",get("recall"),"title");
$flaginfo = get("flags");
?>

<div class="first">
<div class="name">
<h1><?=$name?></h1>
</div>
<div class="org">
Member of <?=$clan?>, <?=$guild?>, <?=$militia?>
</div>
</div>

<div class="second">
<div class="stats">
<ul>
<li>Date Created: <?=$birth?></li>
</ul>
</div>

<div class="recall">
Recall Point: <?=$recall?>
</div>
</div>

<div class="main">
<div class="flags">
<h3>Languages Spoken</h3>
<hr/>
<?
if (strpos($flaginfo,"(alltongues)") !== false) echo "You are fluent in every language.<br>\n";
if (strpos($flaginfo,"(Avian)") !== false) echo "You speak the Avian language.<br>\n";
if (strpos($flaginfo,"(Delanian)") !== false) echo "You speak the Delanian language of the Deep Elves.<br>\n";
if (strpos($flaginfo,"(Draken)") !== false) echo "You speak the Draken language of the dragonkin.<br>\n";
if (strpos($flaginfo,"(Drow)") !== false) echo "You speak the Drow language.<br>\n";
if (strpos($flaginfo,"(Dwarvish)") !== false) echo "You speak the Dwarvish language.<br>\n";
if (strpos($flaginfo,"(Elvish)") !== false) echo "You speak the Elvish language.<br>\n";
if (strpos($flaginfo,"(Faelen)") !== false) echo "You speak the fae language, Fae'len.<br>\n";
if (strpos($flaginfo,"(LoHi)") !== false) echo "You speak the Sehraka language, Lo'Hi.<br>\n";
if (strpos($flaginfo,"(Common-sign)") !== false) echo "You speak the Common Sign language.<br>\n";
if (strpos($flaginfo,"(Drow-sign)") !== false) echo "You speak the Drow Sign language.<br>\n";
if (strpos($flaginfo,"(Jangala)") !== false) echo "You speak the Jangal language, Jangal'a.<br>\n";
if (strpos($flaginfo,"(TideTongue)") !== false) echo "You speak the Tidebroken language, TideTongue.<br>\n";
?>
</br>

<h3>Skills Earned</h3>
<hr/>
<?
if (strpos($flaginfo,"(agility)") !== false) echo "You are skilled in agility.<br>\n";
if (strpos($flaginfo,"(alchemy)") !== false) echo "You are skilled in alchemy.<br>\n";
if (strpos($flaginfo,"(archery)") !== false) echo "You are skilled in archery.<br>\n";
if (strpos($flaginfo,"(aura)") !== false) echo "You are shielded by a magical aura.<br>\n";
if (strpos($flaginfo,"(battle)") !== false) echo "You are skilled in battling.<br>\n";
if (strpos($flaginfo,"(brawl)") !== false) echo "You are skilled in brawling.<br>\n";
if (strpos($flaginfo,"(breathattack)") !== false) echo "You possess dragon's breath.<br>\n";
if (strpos($flaginfo,"(brew)") !== false) echo "You are skilled in brewing.<br>\n";
if (strpos($flaginfo,"(climb)") !== false) echo "You are skilled in climbing.<br>\n";
if (strpos($flaginfo,"(cook)") !== false) echo "You are skilled in cooking.<br>\n";
if (strpos($flaginfo,"(craft)") !== false) echo "You are skilled in crafting.<br>\n";
if (strpos($flaginfo,"(dark)") !== false) echo "You are able to see in the dark.<br>\n";
if (strpos($flaginfo,"(diffuse)") !== false) echo "You can diffuse magical barriers.<br>\n";
if (strpos($flaginfo,"(dig)") !== false) echo "You are skilled in digging.<br>\n";
if (strpos($flaginfo,"(disarm)") !== false) echo "You are skilled in disarming.<br>\n";
if (strpos($flaginfo,"(dust)") !== false) echo "You are protected with fae dust.<br>\n";
if (strpos($flaginfo,"(dbraille)") !== false) echo "You are able to read Velkyn Xan'ss, the drow braille system.<br>\n";
if (strpos($flaginfo,"(evision)") !== false) echo "You possess the vision of an eagle.<br>\n";
if (strpos($flaginfo,"(hide)") !== false) echo "You are skilled in hiding.<br>\n";
if (strpos($flaginfo,"(feather)") !== false) echo "You are able to fall as lightly as a feather.<br>\n";
if (strpos($flaginfo,"(fish)") !== false) echo "You are skilled in fishing.<br>\n";
if (strpos($flaginfo,"(fly)") !== false) echo "You possess the ability to fly.<br>\n";
if (strpos($flaginfo,"(forage)") !== false) echo "You are skilled in foraging.<br>\n";
if (strpos($flaginfo,"(forge)") !== false) echo "You are skilled in forging.<br>\n";
if (strpos($flaginfo,"(fwalk)") !== false) echo "You are skilled in firewalking.<br>\n";
if (strpos($flaginfo,"(heal)") !== false) echo "You are skilled in healing.<br>\n";
if (strpos($flaginfo,"(heft)") !== false) echo "You are skilled in hefting large objects.<br>\n";
if (strpos($flaginfo,"(hide)") !== false) echo "You can cloak.<br>\n";
if (strpos($flaginfo,"(hunt)") !== false) echo "You are skilled in hunting.<br>\n";
if (strpos($flaginfo,"(hypno)") !== false) echo "You are skilled in hypnosis.<br>\n";
if (strpos($flaginfo,"(illusion)") !== false) echo "You are skilled in the art of illusion.<br>\n";
if (strpos($flaginfo,"(infravision)") !== false) echo "You possess infravision.<br>\n";
if (strpos($flaginfo,"(interpret)") !== false) echo "You are skilled in interpreting manuscripts.<br>\n";
if (strpos($flaginfo,"(items)") !== false) echo "You know much about items.<br>\n";
if (strpos($flaginfo,"(levitate)") !== false) echo "You are able to levitate.<br>\n";
if (strpos($flaginfo,"(lockpick)") !== false) echo "You are skilled in lockpicking.<br>\n";
if (strpos($flaginfo,"(magic)") !== false) echo "You are skilled in magic.<br>\n";
if (strpos($flaginfo,"(martial)") !== false) echo "You are skilled in martial arts.<br>\n";
if (strpos($flaginfo,"(might)") !== false) echo "You possess great might.<br>\n";
if (strpos($flaginfo,"(mindcontrol)") !== false) echo "You are able to control the minds of others.<br>\n";
if (strpos($flaginfo,"(morph)") !== false) echo "You can morph.<br>\n";
if (strpos($flaginfo,"(mshield)") !== false) echo "Your mind is shielded from telepathic intrusion.<br>\n";
if (strpos($flaginfo,"(music)") !== false) echo "You are skilled in music.<br>\n";
if (strpos($flaginfo,"(navigate)") !== false) echo "You are skilled in navigation.<br>\n";
if (strpos($flaginfo,"(ntalk)") !== false) echo "You can communicate with nature.<br>\n";
if (strpos($flaginfo,"(perc)") !== false) echo "You are skilled in perception.<br>\n";
if (strpos($flaginfo,"(phase)") !== false) echo "You can pass through solid objects.<br>\n";
if (strpos($flaginfo,"(poison)") !== false) echo "You know much about poison.<br>\n";
if (strpos($flaginfo,"(read)") !== false) echo "You are a skilled reader.<br>\n";
if (strpos($flaginfo,"(recall)") !== false) echo "You possess Recall.<br>\n";
if (strpos($flaginfo,"(resurrect)") !== false) echo "You have the power of resurrection.<br>\n";
if (strpos($flaginfo,"(seaman)") !== false) echo "You are a skilled seaman.<br>\n";
if (strpos($flaginfo,"(seduction)") !== false) echo "You are skilled in seduction<br>\n";
if (strpos($flaginfo,"(shift)") !== false) echo "You can shift sizes.<br>\n";
if (strpos($flaginfo,"(sneak)") !== false) echo "You are skilled in stealth.<br>\n";
if (strpos($flaginfo,"(survival)") !== false) echo "You are skilled in survival.<br>\n";
if (strpos($flaginfo,"(speed)") !== false) echo "You are very fast.<br>\n";
if (strpos($flaginfo,"(swim)") !== false) echo "You are a skilled swimmer.<br>\n";
if (strpos($flaginfo,"(sword)") !== false) echo "You are a skilled swordsman.<br>\n";
if (strpos($flaginfo,"(tattoo)") !== false) echo "You are a skilled tattooist.<br>\n";
if (strpos($flaginfo,"(torture)") !== false) echo "You are skilled in the art of torture.<br>\n";
if (strpos($flaginfo,"(tk)") !== false) echo "You possess telekinesis.<br>\n";
if (strpos($flaginfo,"(tp)") !== false) echo "You possess telepathy.<br>\n";
if (strpos($flaginfo,"(waterwalk)") !== false) echo "You are able to walk on water.<br>\n";
if (strpos($flaginfo,"(wbreathe)") !== false) echo "You can breathe underwater.<br>\n";
?>
<br/>

<h3>Exploration</h3>
<hr/>
<?
if (strpos($flaginfo,"(nameless)") !== false) echo "You have witnessed the Eldritch Cairn in the Nameless City. You can now <i>recall Nameless</i>.<br>\n";
if (strpos($flaginfo,"(adrasei)") !== false) echo "You have traveled to the city of Adrasei. You can now <i>recall Adrasei</i>.<br>\n";
if (strpos($flaginfo,"(haven)") !== false) echo "You have traveled to the Island of Haven. You can now <i>recall Haven</i>.<br>\n";
if (strpos($flaginfo,"(illynfel)") !== false) echo "You have traveled to Illynfel Island. You can now <i>recall Illynfel</i>.<br>\n";
if (strpos($flaginfo,"(miriton)") !== false) echo "You have traveled to Miriton. You can now <i>recall Miriton</i>.<br>\n";
if (strpos($flaginfo,"(tal)") !== false) echo "You have traveled to the Great Tal. You can now <i>recall Tal</i>.<br>\n";
if (strpos($flaginfo,"(jangal)") !== false) echo "You have traveled to the Jangalan Subcontinent. You can now <i>recall Jangal</i>.<br>\n";
if (strpos($flaginfo,"(ankou)") !== false) echo "You have traveled to the Ankou Ennis Island. You can now <i>recall Ankou</i>.<br>\n";
if (strpos($flaginfo,"(soteri)") !== false) echo "You have traveled to the floating island of Soteri. You can now <i>recall Soteri</i>.<br>\n";
if (strpos($flaginfo,"(astaria)") !== false) echo "You have traveled to the city of Astaria. You can now <i>recall Astaria</i>.<br>\n";
if (strpos($flaginfo,"(shire)") !== false) echo "You have traveled to the Hobbit Shire.<br>\n";
if (strpos($flaginfo,"(abyss)") !== false) echo "You have traveled to the Abyss. You can now <i>recall Abyss</i>.<br>\n";
if (strpos($flaginfo,"(rosfjorn)") !== false) echo "You have traveled to Rosfjorn Island. You can now <i>recall Rosfjorn</i>.<br>\n";
?>
<br/>

<h3>Quests Completed: <?=$quests?></h3>
<hr/>
<?
if (strpos($flaginfo,"(deadskel1)") !== false) echo "You destroyed one of the Skeletal warriors in Soteri.<br>\n";
?>
</br>

<h3>Special Achievements</h3>
<hr/>
<br/>
</div>

<div class="info">
<?	echo getfile("rpinfo");
?>
</div>

</div>
</body>
</html>