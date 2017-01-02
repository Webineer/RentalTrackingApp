<style type="text/css">

#dropmenudiv{
position:absolute;
border:1px solid black;
border-bottom-width: 0;
font:normal 10px Verdana;
line-height:16px;
z-index:100;
}

#dropmenudiv a{
width: 100%;
display: block;
text-indent: 3px;
border-bottom: 1px solid black;
padding: 1px 0;
text-decoration: none;
font-weight: bold;
}

#dropmenudiv a:hover{ /*hover background color*/
background-color: ffcc33;
}

</style>

<script type="text/javascript">

/***********************************************
* AnyLink Drop Down Menu- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

//Contents for menu 1
var menu1=new Array()
menu1[0]='<a href="http://209.251.75.93/skibradford2/info/report.php">-Snow Report</a>'
menu1[1]='<a href="http://209.251.75.93/skibradford2/info/events.php">-Events</a>'
menu1[2]='<a href="http://209.251.75.93/skibradford2/info/map.php">-Trail Map</a>'
menu1[3]='<a href="http://209.251.75.93/skibradford2/info/hours.php">-Hours of Operation</a>'
menu1[4]='<a href="http://209.251.75.93/skibradford2/info/directions.php">-Directions</a>'
menu1[5]='<a href="http://209.251.75.93/skibradford2/info/contactus.php">-Contact Us</a>'

//Contents for menu 2, and so on
var menu2=new Array()
menu2[0]='<a href="http://209.251.75.93/skibradford2/rates/lift.php">-Lift Tickets</a>'
menu2[1]='<a href="http://209.251.75.93/skibradford2/rates/seasonpasses.php">-Season Passes</a>'
menu2[2]='<a href="http://209.251.75.93/skibradford2/rates/sixpacks.php">-Six Packs</a>'
menu2[3]='<a href="http://209.251.75.93/skibradford2/rates/rentals.php">-Rentals</a>'

//Contents for menu 3
var menu3=new Array()
menu3[0]='<a href="http://209.251.75.93/skibradford2/lessons/privatelessons.php">-Private</a>'
menu3[1]='<a href="http://209.251.75.93/skibradford2/lessons/grouplessons.php">-Group</a>'
menu3[2]='<a href="http://209.251.75.93/skibradford2/lessons/lessonpackages.php">-Packages</a>'

//Contents for menu 4
var menu4=new Array()
menu4[0]='<a href="http://209.251.75.93/skibradford2/programs/littleb.php">-Little B Ski</a>'
menu4[1]='<a href="http://209.251.75.93/skibradford2/programs/littlerider.php">-Little Rider Snowboard</a>'
menu4[2]='<a href="http://209.251.75.93/skibradford2/programs/junior.php">-Junior Ski &amp; Snowboard</a>'
menu4[3]='<a href="http://209.251.75.93/skibradford2/programs/adult.php">-Adult Ski &amp; Snowboard</a>'

//Content for menu 5
var menu5=new Array()
menu5[0]='<a href="http://209.251.75.93/skibradford2/clinics/decclinics.php">-December Ski &amp; Snowboard</a>'
menu5[1]='<a href="http://209.251.75.93/skibradford2/clinics/febclinics.php">-February Ski &amp; Snowboard</a>'

//Contents for menu 6
var menu6=new Array()
menu6[0]='<a href="http://209.251.75.93/skibradford2/racing.php">Racing</a>'
menu6[1]='<a href="http://209.251.75.93/skibradford/terrain.php" target="_blank">Terrain Park</a>'
menu6[2]='<a href="http://209.251.75.93/skibradford2/grouptrips.php">Group Trips</a>'
menu6[3]='<a href="http://209.251.75.93/skibradford2/photos.php">Photo Gallery</a>'
menu6[4]='<a href="http://209.251.75.93/skibradford2/etix.php">Buy Online</a>'
/*
//Contents for menu 7
var menu7=new Array()
menu7[0]='<a href="#">Terrain Park</a>'

//Contents for menu 8
var menu8=new Array()
menu8[0]='<a href="#">Group Trips</a>'

//Contents for menu 9
var menu9=new Array()
menu9[0]='<a href="#">Photo Gallery</a>'

//Contents for menu 10
var menu10=new Array()
menu10[0]='<a href="#">Buy Online</a>'
*/		
var menuwidth='165px' //default menu width
//var menuwidth='1000px' //default menu width
//var menubgcolor='lightyellow'  //menu bgcolor
var menubgcolor='000000'  //menu bgcolor
var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var hidemenu_onclick="yes" //hide menu when user clicks within menu?

/////No further editting needed

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
document.write('<div id="dropmenudiv" style="visibility:hidden;width:'+menuwidth+';background-color:'+menubgcolor+'" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}


function showhide(obj, e, visible, hidden, menuwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top="-500px"
if (menuwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=menuwidth
}
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
obj.visibility=visible
else if (e.type=="click")
obj.visibility=hidden
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
//var edgeoffset=15
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
}
}
return edgeoffset
}

function populatemenu(what){
if (ie4||ns6)
dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth){
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
clearhidemenu()
dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
populatemenu(menucontents)

if (ie4||ns6){
showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
}

return clickreturnvalue()
}

function clickreturnvalue(){
if (ie4||ns6) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function dynamichide(e){
if (ie4&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
}

function hidemenu(e){
if (typeof dropmenuobj!="undefined"){
if (ie4||ns6)
dropmenuobj.style.visibility="hidden"
}
}

function delayhidemenu(){
if (ie4||ns6)
delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

if (hidemenu_onclick=="yes")
document.onclick=hidemenu

</script>