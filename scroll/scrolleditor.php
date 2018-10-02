 <!doctype html>
<html>
<head>
    <title>Scroll Editor</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" type="text/javascript" charset="utf-8"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.0/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
   <script>
	MathJax.Hub.Config({
		tex2jax: {
		inlineMath: [['$','$'], ['\\(','\\)']],
		processEscapes: true,
		processClass: "mathjax",
        ignoreClass: "no-mathjax"
		}
	});//			MathJax.Hub.Typeset();//tell Mathjax to update the math
</script>
</head>
<body class="no-mathjax">
<div id = "notexdatadiv" style = "display:none" class = "no-mathjax">
<?php    
echo file_get_contents("html/scroll.txt");    
?>
</div>
<div id = "scrolldisplay"  class = "mathjax">
<?php    
echo file_get_contents("html/scroll.txt");    
?>
</div>

<div id = "linkscroll">
    <a href = "index.php">index.php</a>
    <a href = "../../">../../</a>
</div>

<div id="maineditor" contenteditable="true" spellcheck="true"></div>

<textarea id = "captioneditor"></textarea>
<script>

figureindex = 0;

figures = document.getElementById("notexdatadiv").getElementsByTagName("figure");

for(var index = 0;index < figures.length;index++){
    figures[index].id = "f" + index.toString();
}

document.getElementById("captioneditor").value = figures[figureindex].getElementsByTagName("figcaption")[0].innerHTML;

document.getElementById("captioneditor").onkeyup = function(){
    figures[figureindex].getElementsByTagName("figcaption")[0].innerHTML = this.value;
    document.getElementById("scrolldisplay").innerHTML = document.getElementById("notexdatadiv").innerHTML;
    editor.setValue(document.getElementById("notexdatadiv").innerHTML);
    MathJax.Hub.Typeset();//tell Mathjax to update the math
    data = encodeURIComponent(editor.getSession().getValue());
    var httpc = new XMLHttpRequest();
    var url = "filesaver.php";        
    httpc.open("POST", url, true);
    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
    httpc.send("data="+data+"&filename="+currentFile);//send text to filesaver.php

}

currentFile = "html/scroll.txt";
    
var httpc = new XMLHttpRequest();
httpc.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        filedata = this.responseText;
        editor.setValue(filedata);
        document.getElementById("scrolldisplay").innerHTML = filedata;
        MathJax.Hub.Typeset();//tell Mathjax to update the math
    }
};
httpc.open("GET", "fileloader.php?filename=" + currentFile, true);
httpc.send();



editor = ace.edit("maineditor");
editor.setTheme("ace/theme/cobalt");
editor.getSession().setMode("ace/mode/html");
editor.getSession().setUseWrapMode(true);
editor.$blockScrolling = Infinity;

document.getElementById("maineditor").onkeyup = function(){
    data = encodeURIComponent(editor.getSession().getValue());
    var httpc = new XMLHttpRequest();
    var url = "filesaver.php";        
    httpc.open("POST", url, true);
    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
    httpc.send("data="+data+"&filename="+currentFile);//send text to filesaver.php

    document.getElementById("scrolldisplay").innerHTML = editor.getSession().getValue();
    document.getElementById("notexdatadiv").innerHTML = editor.getSession().getValue();
    MathJax.Hub.Typeset();//tell Mathjax to update the math

}


</script>
<style>
a{
    color:white;
    display:block;
    margin-bottom:0.5em;
    margin-left:0.5em;
}
body{
    background-color:#404040;
}


#linkscroll{
    position:absolute;
    overflow:scroll;
    top:0%;
    bottom:50%;
    right:0%;
    left:77%;
    border:solid;
    border-radius:5px;
    border-width:3px;
    background-color:#101010;
    font-family:courier;
    font-size:18px;
    
}

#maineditor{
    position:absolute;
    left:41%;
    top:5em;
    bottom:10px;
    right:25%;
}
#scrolldisplay{
    position:absolute;
    background-color:white;
    overflow:scroll;
    color:black;
    left:10px;
    bottom:40%;
    right:60%;
    top:5em;
    border:solid;
    border-width:3px;
    border-radius:0.5em;
    padding:1.5em 1.5em 1.5em 1.5em;
    font-family: Book Antiqua, Palatino, Palatino Linotype, Palatino LT STD, Georgia, serif;
}
#captioneditor{
    position:absolute;
    bottom:10px;
    left:0px;
    width:40%;
    height:35%;
}
#scrolldisplay p,li,pre{
    width:80%;
    display:block;
    margin:auto;
    text-align:justify;    
    margin-bottom:1em;
    font-family: Book Antiqua, Palatino, Palatino Linotype, Palatino LT STD, Georgia, serif;

}
#scrolldisplay h1,h2,h3{
    text-align:center;
}
#scrolldisplay a{
    color:blue;
    display:inline;

}
#scrolldisplay table{
    border-collapse:collapse;
    margin:auto;
    width:auto;
}
#scrolldisplay td{
    border:solid;
}
figure img{
    width:100%;
}
figure{
    width:80%;
}
figure figcaption{
    width:100%;
}


</style>

</body>
</html>