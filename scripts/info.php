<?
$command = 1;
$flaginfo = get("flags");

/*Begin Quest Flags*/ 
echo "<br><u>Quests</u><br>\n";


/*Begin Guild Quests*/
echo "<br><u>Guild Quests</u><br>\n";


/*Begin Exploration Quests*/

echo "<br><u>Exploration</u><br>\n";
if (strpos($flaginfo,"(adrasei)") !== false) echo "You have traveled to the city of Adrasei. <i>Big lights, big city.</i><br>\n";
if (strpos($flaginfo,"(haven)") !== false) echo "You have traveled to the Island of Haven. <i>It's a peaceful place, a haven. The war memorial speaks otherwise, though.</i><br>\n";
if (strpos($flaginfo,"(illynfel)") !== false) echo "You have traveled to Illynfel Island. <i>A peaceful island, home of magic.</i><br>\n";
if (strpos($flaginfo,"(miriton)") !== false) echo "You have traveled to Miriton. <i>A land of few with secrets that whisper.</i><br>\n";
if (strpos($flaginfo,"(greattal)") !== false) echo "You have traveled to the Great Tal. <i>If their noses went any higher, they might drown when it rains.</i><br>\n";
if (strpos($flaginfo,"(jangal)") !== false) echo "You have traveled to the Jangalan Subcontinent. <i>All manner of wild things survive here.</i><br>\n";
if (strpos($flaginfo,"(ankou)") !== false) echo "You have traveled to the Ankou Ennis Island. <i>You can't quite gild over a curse.</i><br>\n";
if (strpos($flaginfo,"(soteri)") !== false) echo "You have traveled to the floating island of Soteri. <i>Only death waits, here</i><br>\n";
if (strpos($flaginfo,"(astaria)") !== false) echo "You have traveled to the city of Astaria. <i>A glistening city, carved into the very mountains.</i><br>\n";
if (strpos($flaginfo,"(shire)") !== false) echo "You have traveled to the Hobbit Shire. <i>You sure you won't stay for another pot of tea?</i><br>\n";
if (strpos($flaginfo,"(abyss)") !== false) echo "You have traveled to the Abyss. <i>Surely there's nothing to fear in the dark..</i><br>\n";
if (strpos($flaginfo,"(rosfjorn)") !== false) echo "You have traveled to Rosfjorn Island. <i>I don't think my hands will ever defrost.</i><br>\n";

/*Begin Skill Flags*/
echo "<br><u>Skills</u><br>\n";
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



/*Begin Language Flags*/

echo "<br><u>Languages</u><br>\n";
if (strpos($flaginfo,"(alltongues)") !== false) echo "You are fluent in every language.<br>\n";
if (strpos($flaginfo,"(Avian)") !== false) echo "You speak the Avian language.<br>\n";
if (strpos($flaginfo,"(Delanian)") !== false) echo "You speak the Delanian language of the Deep Elves.<br>\n";
if (strpos($flaginfo,"(Draken)") !== false) echo "You speak the Draken language of the dragonkin.<br>\n";
if (strpos($flaginfo,"(Drow)") !== false) echo "You speak the Drow language.<br>\n";
if (strpos($flaginfo,"(Dwarvish)") !== false) echo "You speak the Dwarvish language.<br>\n";
if (strpos($flaginfo,"(Elvish)") !== false) echo "You speak the Elvish language.<br>\n";
if (strpos($flaginfo,"(Faelen)") !== false) echo "You speak the fae language, Fae'len.<br>\n";
if (strpos($flaginfo,"(Lohi)") !== false) echo "You speak the Sehraka language, Lo'Hi.<br>\n";
if (strpos($flaginfo,"(Undercommon)") !== false) echo "You speak the Undercommon language.<br>\n";
if (strpos($flaginfo,"(Common-sign)") !== false) echo "You speak the Common Sign language.<br>\n";
if (strpos($flaginfo,"(Drow-sign)") !== false) echo "You speak the Drow Sign language.<br>\n";
if (strpos($flaginfo,"(Jangala)") !== false) echo "You speak the Jangal language, Jangal'a.<br>\n";


/*Begin Special Flags*/

echo "<br><u>Special</u><br>\n";
if (strpos($flaginfo,"(Chronfav)") !== false) echo "Chron likes you!  Awesome!<br>\n";
if (strpos($flaginfo,"(Parsmate)") !== false) echo "You are the mate of Parsithius, bet you feel sore in the mornings.<br>\n";
echo "<hr width=50%><br><u>Roleplaying Info</u><br>\n".nl2br(getfile("rpinfo"))."<br>\n<hr width=50%><br><u>Login Message</u><br>\n".nl2br(stripslashes(getfile("login")));
?>