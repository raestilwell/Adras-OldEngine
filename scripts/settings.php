<?php
$command = 1;

$unafk = isset($unafk) ? $unafk : '';
$bold = isset($bold) ? $bold : '';
$scroll = isset($scroll) ? $scroll : '';

if (strpos(get("flags"), "(ooc)") === false) $ooc = " checked=checked";
if (strpos(get("flags"), "(chat)") === false) $chat = " checked=checked";
if (strpos(get("flags"), "(map)") === false) $map = " checked=checked";
if (strpos(get("flags"), "(bold)") !== false) $bold = " checked=checked";
if (strpos(get("flags"), "(scroll)") !== false) $scroll = " checked=checked";
if (get("unafk") === "y") $unafk = " checked=checked";
$chatpref = get("chatpref");
?>
<script type="text/javascript" src="../js/jscolor/jscolor.js"></script>

<form action=settings.php method=post>
  To choose a color, simply click on the text field and move the slider to your desired color.
  <table width=100%>
    <tr>
      <td width=100%>
        <table border=0>
          <tr><td>Background Color:</td><td><input name=background value="<?=get("bgcolor")?>" class="color"></td></tr>
          <tr><td>Text Color:</td><td><input name=color value="<?=get("tcolor")?>" class="color"></td></tr>
          <tr><td>Chat Color:</td><td><input name=ccolor value="<?=get("ccolor")?>" class="color"></td></tr>
          <tr><td>Own Color:</td><td><input name=ocolor value="<?=get("scolor")?>" class="color"></td></tr>
          <tr><td>Bold Chat Color:</td><td><input name=bcolor value="<?=get("bcolor")?>" class="color"></td></tr>
          <tr><td>Friend Color:</td><td><input name=fcolor value="<?=get("fcolor")?>" class="color"></td></tr>
          <tr><td>Link Color:</td><td><input name=link value="<?=get("lcolor")?>" class="color"></td></tr>
<?
  if(!is_numeric(get("admin"))) 
    echo "<tr><td>AChat Color:</td><td><input name=acolor value=\"".get("acolor")."\" class=\"color\"></td></tr>";
?>
         <tr>
             <td>Font Face:</td>
             <td>
                 <select name="font">
                     <option value="Sans Serif" <?= (get("font") === "Sans Serif") ? 'selected' : '' ?>>Sans Serif</option>
                     <option value="Serif" <?= (get("font") === "Serif") ? 'selected' : '' ?>>Serif</option>
                     <option value="Fixed Width" <?= (get("font") === "Fixed Width") ? 'selected' : '' ?>>Fixed Width</option>
                     <option value="Wide" <?= (get("font") === "Wide") ? 'selected' : '' ?>>Wide</option>
                     <option value="Narrow" <?= (get("font") === "Narrow") ? 'selected' : '' ?>>Narrow</option>
                     <option value="Comic Sans Ms" <?= (get("font") === "Comic Sans Ms") ? 'selected' : '' ?>>Comic Sans Ms</option>
                     <option value="Garamond" <?= (get("font") === "Garamond") ? 'selected' : '' ?>>Garamond</option>
                     <option value="Georgia" <?= (get("font") === "Georgia") ? 'selected' : '' ?>>Georgia</option>
                     <option value="Merriweather" <?= (get("font") === "Merriweather") ? 'selected' : '' ?>>Merriweather</option>
                     <option value="Montserrat" <?= (get("font") === "Montserrat") ? 'selected' : '' ?>>Montserrat</option>
                     <option value="Open Sans" <?= (get("font") === "Open Sans") ? 'selected' : '' ?>>Open Sans</option>
                     <option value="Oswald" <?= (get("font") === "Oswald") ? 'selected' : '' ?>>Oswald</option>
                     <option value="Quattrocento" <?= (get("font") === "Quattrocento") ? 'selected' : '' ?>>Quattrocento</option>
                     <option value="Raleway" <?= (get("font") === "Raleway") ? 'selected' : '' ?>>Raleway</option>
                     <option value="Tahoma" <?= (get("font") === "Tahoma") ? 'selected' : '' ?>>Tahoma</option>
                     <option value="Trebuchet MS" <?= (get("font") === "Trebuchet MS") ? 'selected' : '' ?>>Trebuchet MS</option>
                     <option value="Verdana" <?= (get("font") === "Verdana") ? 'selected' : '' ?>>Verdana</option>
                 </select>
             </td>
         </tr>

          <tr>
            <td>Font Size:</td>
            <td>
              <select name=fontsize>
<?
  for ($i = 8; $i <= 16; $i+=2)
  {
    echo "                <option value=$i";
    if (get("size") == $i)
      echo " selected";
    echo ">$i</option>\n";
  }
?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Top Frame Size:</td>
            <td>
              <select name=topframesize>
<?
  for ($i = 50; $i < 95; $i+=5)
  {
    echo "                <option value=$i";
    if (get("frame") == $i)
      echo " selected";
    echo ">$i%</option>\n";
  }
?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Chat/Mail Checker:</td>
            <td>
              <select name=refresh>
                <option value=no<?if(get("refresh") == "no")echo " selected";?>>Off</option>
<?
  for ($i = 10; $i <= 60; $i+=10)
  {
    echo "                <option value=$i";
    if (get("refresh") == $i)
      echo " selected";
    echo ">$i</option>\n";
  }
?>
              </select> second intervals (Note: After turning this function off, you will need to change the setting back to a numeric value then log back in to turn it back on.)
            </td>
          </tr>
          <tr>
            <td>Auto-map Cell Size:</td>
            <td>
              <input size=2 name=mapcell value="<?=get("mapcell")?>">
            </td>
          </tr>
          <tr>
            <td>Notify On:</td>
            <td>
              <table>
                <tr>
                  <td>
                    <input name=p0 type=checkbox<?if($chatpref[0] == "1") echo " checked=checked";?>> tell
                  </td>
                  <td>
                    <input name=p1 type=checkbox<?if(!empty($chatpref[1])) echo " checked=checked";?>> say to you
                  </td>
                  <td>
                    <input name=p2 type=checkbox<?if(!empty($chatpref[2])) echo " checked=checked";?>> say to other
                  </td>
                  <td>
                    <input name=p3 type=checkbox<?if(!empty($chatpref[3])) echo " checked=checked";?>> say
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name=p4 type=checkbox<?if(!empty($chatpref[4])) echo " checked=checked";?>> RP action
                  </td>
                  <td>
                    <input name=p5 type=checkbox<?if(!empty($chatpref[5])) echo " checked=checked";?>> shout to you
                  </td>
                  <td>
                    <input name=p6 type=checkbox<?if(!empty($chatpref[6])) echo " checked=checked";?>> shout to other
                  </td>
                  <td>
                    <input name=p7 type=checkbox<?if(!empty($chatpref[7])) echo " checked=checked";?>> shout
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name=p8 type=checkbox<?if(!empty($chatpref[8])) echo " checked=checked";?>> ooc
                  </td>
                  <td>
                    <input name=p9 type=checkbox<?if(!empty($chatpref[9])) echo " checked=checked";?>> chat
                  </td>
                  <td>
                    <input name=p10 type=checkbox<?if(!empty($chatpref[10])) echo " checked=checked";?>> look at you
                  </td>
                  <td>
                    <input name=p11 type=checkbox<?if(!empty($chatpref[11])) echo " checked=checked";?>> look at other
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name=p12 type=checkbox<?if(!empty($chatpref[12])) echo " checked=checked";?>> group chat
                  </td>
                  <td>
                    <input name=p13 type=checkbox<?if(!empty($chatpref[13])) echo " checked=checked";?>> clan chat
                  </td>
                  <td>
                    <input name=p14 type=checkbox<?if(!empty($chatpref[14])) echo " checked=checked";?>> guild chat
                  </td>
                  <td>
                    <input name=p15 type=checkbox<?if(!empty($chatpref[15])) echo " checked=checked";?>> militia chat
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name=p16 type=checkbox<?if(!empty($chatpref[16])) echo " checked=checked";?>> bot chat
                  </td>
                  <td>
                    <input name=p17 type=checkbox<?if(!empty($chatpref[17])) echo " checked=checked";?>> enter room
                  </td>
                  <td>
                    <input name=p18 type=checkbox<?if(!empty($chatpref[18])) echo " checked=checked";?>> leave room
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>Login Message:</td>
            <td><?=get("name")?><input name=login value="<?=get("login")?>" size=75></td>
          </tr>
          <tr>
            <td>Logout Message:</td>
            <td><?=get("name")?><input name=logout value="<?=get("logout")?>" size=75></td>
          </tr>
          <tr>
            <td>AFK Message:</td>
            <td><input name=afk value="<?=get("afk")?>" size=75></td>
          </tr>
          <tr>
            <td>Automatically remove AFK on action:</td>
            <td><input name=unafk type=checkbox<?=$unafk?>></td>
          </tr>
          <tr>
            <td>See <i>OOC</i> channel:</td>
            <td><input name=ooc type=checkbox<?=$ooc?>></td>
          </tr>
          <tr>
            <td>See <i>chat</i> channel:</td>
            <td><input name=chat type=checkbox<?=$chat?>></td>
          </tr>
          <tr>
            <td>See <i>auto-map</i>:</td>
            <td><input name=map type=checkbox<?=$map?>></td>
          </tr>
          <tr>
            <td>Enable <i>all-bold</i>:</td>
            <td><input name=bold type=checkbox<?=$bold?>></td>
          </tr>
          <tr>
            <td><i>Auto-scrolldown</i>:</td>
            <td><input name=scroll type=checkbox<?=$scroll?>></td>
          </tr>
        </table>
      </td>
      <td style=text-align:right; valign=top width=610>
      </td>
    </tr>
  </table>

<input type=hidden name=username value=<?=$username?>>
    <input type=hidden name=password value=<?=$password?>>
    <input type=submit value="Change Settings"> <input type=reset>
  </form>