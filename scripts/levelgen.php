<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>

body {
  font: 12px/18px Arial;
  padding: 0 8%;
  max-width: 1300px;
  margin: 0 auto;
}


a {
  text-decoration: none;
  color: teal;
}

a:hover {
  color: black;
}

.phpite-title {
  font-weight: bold;
  font-size: 20px;
  margin: 0 0 8px;
}

.phpite-description {
  font-weight: bold;
  font-size: 14px;
  margin: 0 0 5px;
}

.title {
  margin-top: 25px;
  font-size: 15px;
  font-weight: bold;
}

strong {
  font-weight: bold;
}

p {
  margin: 0 0 10px;
}

.tab-area p {
  font-size: 11px;
  color: #666;
}

h3 {
  font-weight: bold;
  font-size: 16px;
  margin: 0 0 10px;
}

.intro {
  max-width: 550px;
  margin: 50px 2%;
}

.tab-area {
  width: 31%;
  margin: 2%;
  float: left;
}

.tab-area input { 
  display: none;
}

.tab-link {
  text-transform: uppercase;
  font-size: 10px;
  cursor: pointer;
  color: #555;
  font-weight: bold;
  text-decoration: none;
  display: block;
  float: left;
  width: 55px;
  padding: 5px 0;
  text-align: center;
  background: #ccc;
  border: 1px solid #bbb;
  border-left: 0;
  border-bottom: 0;
}

.tab-link:hover {
  background: #eee;
}

.tab-link:nth-of-type(1) {
  border-left: 1px solid #bbb;
}

.tab-link:hover {
  color: #666;
}

.tab {
  clear: both;
  background: #ddd;
  padding: 25px;
  display: none;
  height: 180px;
  border: 1px solid #bbb;
}

.target-fix {
  display: block;
  top: 0;
  left: 0;
  position: fixed;
}


@media only screen and (max-width: 1150px) {

  .tab-area {
    width: 46%;
    margin: 2% 2% 5%;
    float: left;
  }

}

@media only screen and (max-width: 560px) {

  .tab-area {
    width: 100%;
    margin: 0 0 5%;
    float: left;
  }

  .intro {
    margin: 50px 0;
  }

}



#tab-C:checked ~ label:nth-of-type(3),
#tab-B:checked ~ label:nth-of-type(2),
#tab-F:checked ~ label:nth-of-type(3),
#tab-E:checked ~ label:nth-of-type(2),
#tab-B:not(:checked) ~ #tab-C:not(:checked) ~ #tab-E:not(:checked) ~ #tab-F:not(:checked) ~ label:nth-of-type(1) {
  background: #ddd;
}


#tab-C:checked ~ label:nth-of-type(3):after,
#tab-B:checked ~ label:nth-of-type(2):after,
#tab-F:checked ~ label:nth-of-type(3):after,
#tab-E:checked ~ label:nth-of-type(2):after,
#tab-B:not(:checked) ~ #tab-C:not(:checked) ~ #tab-E:not(:checked) ~ #tab-F:not(:checked)~ label:nth-of-type(1):after {
  position: absolute;
  content: "";
  margin: 5px 0 0 0;
  width: 55px;
  height: 1px;
  display: block;
  background: #ddd;
}

/* Checked Tabs */

.tabs-checked input:nth-of-type(2):not(:checked) ~ input:nth-of-type(3):not(:checked) ~ .tab:nth-of-type(1),
.tabs-checked input:nth-of-type(2):checked ~ .tab:nth-of-type(2),
.tabs-checked input:nth-of-type(3):checked ~ .tab:nth-of-type(3) 
{
  display: block;
}


/* Containers */

.directions {
  padding: 0px;
  float: left;
  height: 290px;
  width: 250px;
  margin-left: 30px;
}
.dtoprow {
  height: 80px;
  width: 230px;
  margin: 0px;
}
.dtoprown {
  margin: 0px;
  padding: 0px;
  height: 60px;
  float: right;
  width: 70px;
}
.dtoprowu {
  padding: 0px;
  height: 60px;
  float: right;
  width: 70px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  margin-left: 10px;
}
.dmidrow {
  height: 80px;
  padding: 0px;
  width: 230px;
  margin: 0px;
}
.dmidroww {
  height: 60px;
  padding: 0px;
  margin: 0px;
  width: 70px;
  float: left;
}
.dmidrowe {
  height: 60px;
  padding: 0px;
  margin: 0px;
  width: 70px;
  float: right;
}
.dbotrow {
  height: 90px;
  width: 230px;
  margin: 0px;
}
.dbotrowd {
  padding: 0px;
  height: 60px;
  float: left;
  width: 70px;
  margin-top: 0px;
  margin-right: 10px;
  margin-bottom: 0px;
  margin-left: 0px;
}
.dbotrows {
  margin: 0px;
  padding: 0px;
  height: 60px;
  float: left;
  width: 70px;
}


</style>
</head>
<body>
  <form action="../commands/editlevel.php" method="post">
    <section class="intro">
      <hgroup>
        <h1 class="site-title">You are editing <?=$c?>.</h1>
      </hgroup>
      <h2 class="site-description">Title</h2>
      <input type="text" name="title" value="<?=$title?>">
    </section>

<section class="tab-area tabs-checked">

    <input checked type="radio" name="tab" id="tab-A" />
    <input type="radio" name="tab" id="tab-B" />
    <input type="radio" name="tab" id="tab-C" />

    <label class="tab-link" for="tab-A">Current</label>
    <label class="tab-link" for="tab-B">Alt</label>
    

    <article class="tab">
      <textarea name=descript rows=12 cols=41><?=$descript?></textarea>
    </article>
    <article class="tab">
      <textarea name=alt rows=12 cols=41><?=$alt?></textarea>
    </article>
    
  </section>
  
  <div class="directions">
      
      <div class="dtoprow">
        
        <div class="dtoprowu">Up:<br />
          <select name=u>
            <option value=0>No</option>
            <option value=1 <?if ($u == 1) echo "selected" ?>>Yes</option>
            </select><br />Was <?=$u?>
          </div>
        
        <div class="dtoprown">North:<br />
          <select name=n>
            <option value=0>No</option>
            <option value=1 <?if ($n == 1) echo "selected" ?>>Yes</option>
            </select><br />Was <?=$n?>
          </div>
        
      </div>
      
      <div class="dmidrow">
        
        <div class="dmidroww">West:<br />
          <select name=w>
            <option value=0>No</option>
            <option value=1 <?if ($w == 1) echo "selected" ?>>Yes</option>
            </select><br />Was <?=$w?>
          </div>
        
        <div class="dmidrowe">East:<br />
          <select name=e>
            <option value=0>No</option>
            <option value=1 <?if ($e == 1) echo "selected" ?>>Yes</option>
            </select><br />Was <?=$e?>
          </div>
      </div>
      
      <div class="dbotrow">
        
        <div class="dbotrowd">Down:<br />
          <select name=d>
            <option value=0>No</option>
            <option value=1 <?if ($d == 1) echo "selected" ?>>Yes</option>
            </select><br />Was <?=$d?>
          </div>
        
        <div class="dbotrows">South:<br />
          <select name=s>
            <option value=0>No</option>
            <option value=1 <?if ($s == 1) echo "selected" ?>>Yes</option>
            </select><br />
            Was <?=$s?>
          </div>
      </div>
      </div>
  
  <section class="tab-area tabs-checked">

    <input checked type="radio" name="tab" id="tab-D" />
    <input type="radio" name="tab" id="tab-E" />
    <input type="radio" name="tab" id="tab-F" />

    <label class="tab-link" for="tab-D">NPCs</label>
    <label class="tab-link" for="tab-E">Scripts</label>
    <label class="tab-link" for="tab-F">Flags</label>

    <article class="tab">
      <textarea name=editnpc rows=12 cols=41><?=$npcdata?></textarea>
    </article>
    <article class="tab">
      <textarea name=script rows=12 cols=41><?=$script?></textarea>
    </article>
    <article class="tab">
      <textarea name=flags rows=12 cols=41><?=$flagdata?></textarea>
    </article>


  </section>
  <p>
        <input type="hidden" name="p" value="<?=$p?>">
        <input type="hidden" name="co" value="<?=$c?>">
        <input type="hidden" name="username" value="<?=$username?>">
        <input type="hidden" name="password" value="<?=$password?>">
        <input type="hidden" name="no" value="<?=$no?>">
        <input type="submit" value="Edit Level">
        <input type="reset" value="Reset">
      </p>
    </form>
  </body>
  </html>

