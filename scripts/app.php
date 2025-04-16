<?$u=ucwords(strtolower($action3[1]));$d=getapp($u);?>
<b>Administrator application for <?=$u?>.</b><br>
<table align=center>
<tr><td style=text-align:right;>Name:</td><td><input name=name value="<?=$d['name']?>"></td><td style=text-align:right;>Location:</td><td><input name=location value="<?=$d['location']?>"></td></tr>
<tr><td style=text-align:right;>Age:</td><td><input name=age value="<?=$d['age']?>"></td><td style=text-align:right;>Other Characters:</td><td><input name=alts value="<?=$d['alts']?>"></td></tr>
<tr><td style=text-align:right;>Email:</td><td><input name=email value="<?=$d['email']?>"></td><td style=text-align:right;>AIM:</td><td><input name=aim value="<?=$d['aim']?>"></td></tr>
<tr><td style=text-align:right;>MSN:</td><td><input name=msn value="<?=$d['msn']?>"></td><td style=text-align:right;>Yahoo:</td><td><input name=yahoo value="<?=$d['yahoo']?>"></td></tr>
<tr><td colspan=4>What do you like best about Isles of Adrasteia?<br><textarea name=best cols=100% rows=5><?=$d['best']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>What do you like least?<br><textarea name=least cols=100% rows=5><?=$d['least']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>Describe your roleplaying experiences.<br><textarea name=rpexp cols=100% rows=5><?=$d['rpexp']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>How much time would you be able to dedicate to Isles of Adrasteia weekly?<br><textarea name=time cols=100% rows=5><?=$d['time']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>Have you ever adminned on Isles of Adrasteia, or any other online RPG? If so, list where, and the details of your duties.<br><textarea name=exp cols=100% rows=5><?=$d['exp']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>What do you feel you can offer Isles of Adrasteia?<br><textarea name=offer cols=100% rows=5><?=$d['offer']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>How would you deal with conflict between yourself and another admin?<br><textarea name=conflict cols=100% rows=5><?=$d['conflict']?></textarea></td></tr>
<tr><td colspan=4><hr width=100%></td></tr>
<tr><td colspan=4><input type=checkbox name=m<?if($d['m'])echo " checked";?>> I would like to apply for a moderator position. (level M)</td></tr>
<tr></tr>
<tr><td colspan=4>Why would you like to be a moderator?<br><textarea name=my cols=100% rows=5><?=$d['my']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>How do you see yourself reacting to a player you find to be breaking the rules? If it helps, choose a rule from the rules page and outline how you would handle the situation.<br><textarea name=mq1 cols=100% rows=5><?=$d['mq1']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>How would you deal with a player who does not agree with a punishment you handed to them after a rule had been broken?<br><textarea name=mq2 cols=100% rows=5><?=$d['mq2']?></textarea></td></tr>
<tr><td colspan=4><hr width=100%></td></tr>
<tr><td colspan=4><input type=checkbox name=p<?if($d['p'])echo " checked";?>> I would like to apply for a player admin position. (level P)</td></tr>
<tr></tr>
<tr><td colspan=4>Why would you like to be a player admin?<br><textarea name=py cols=100% rows=5><?=$d['py']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>A player logs on to Isles of Adrasteia for the very first time, and is lost beyond all belief as far as how to proceed. What do you do?<br><textarea name=pq cols=100% rows=5><?=$d['pq']?></textarea></td></tr>
<tr><td colspan=4><hr width=100%></td></tr>
<tr><td colspan=4><input type=checkbox name=w<?if($d['w'])echo " checked";?>> I would like to apply for a world admin position. (level W)</td></tr>
<tr></tr>
<tr><td colspan=4>Why would you like to be a world admin?<br><textarea name=wy cols=100% rows=5><?=$d['wy']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>Please write a title and room description for: a random roadway.<br><textarea name=wq1 cols=100% rows=5><?=$d['wq1']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>Please write a title and room description for: a weapons shop.<br><textarea name=wq2 cols=100% rows=5><?=$d['wq2']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>Please write a title and room description for: a room type of your choice.<br><textarea name=wq3 cols=100% rows=5><?=$d['wq3']?></textarea></td></tr>
<tr><td colspan=4><hr width=100%></td></tr>
<tr><td colspan=4><input type=checkbox name=r<?if($d['r'])echo " checked";?>> I would like to apply for a roleplay admin position. (level R)</td></tr>
<tr></tr>
<tr><td colspan=4>Why would you like to be a roleplay admin?<br><textarea name=ry cols=100% rows=5><?=$d['ry']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>You find three players RPing together in a tavern, a pair of players RPing elsewhere, and a single player standing alone outside The Park in Genet. What do you do?<br><textarea name=rq cols=100% rows=5><?=$d['rq']?></textarea></td></tr>
<tr><td colspan=4><hr width=100%></td></tr>
<tr><td colspan=4><input type=checkbox name=a<?if($d['a'])echo " checked";?>> I would like to apply for an activity coordinator position. (level A)</td></tr>
<tr></tr>
<tr><td colspan=4>Why would you like to be an activity coordinator?<br><textarea name=ay cols=100% rows=5><?=$d['ay']?></textarea></td></tr>
<tr></tr>
<tr><td colspan=4>Pitch an RP proposal.<br><textarea name=aq cols=100% rows=5><?=$d['aq']?></textarea></td></tr>
</table>