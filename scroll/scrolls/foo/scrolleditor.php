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
<table id = "linktable">
    <tr>
        <td><a href = "index.php">SCROLL READER</a></td>
        <td><a href = "../../">../../</a></td>
    </tr>
</table>


<div id="maineditor" contenteditable="true" spellcheck="true"></div>

<textarea id = "captioneditor"></textarea>
<script>

figureindex = 0;

figures = document.getElementById("notexdatadiv").getElementsByTagName("figure");
visiblefigures = document.getElementById("scrolldisplay").getElementsByTagName("figure");

currentFile = "html/scroll.txt";

for(var index = 0;index < visiblefigures.length;index++){
    figures[index].className = "f" + index.toString();
    visiblefigures[index].className = "f" + index.toString();
    visiblefigures[index].onclick = function(){
        visiblefigures[figureindex].style.border = "none";
        visiblefigures[figureindex].style.backgroundColor = "white";
        figureindex = parseInt(this.className.substr(1));
        document.getElementById("captioneditor").value = this.getElementsByTagName("figcaption")[0].innerHTML;
        visiblefigures[figureindex].style.border = "solid";
        visiblefigures[figureindex].style.backgroundColor = "#d0ffd0";
    }
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

    for(var index = 0;index < visiblefigures.length;index++){
        figures[index].className = "f" + index.toString();
        visiblefigures[index].className = "f" + index.toString();
        visiblefigures[index].onclick = function(){
            visiblefigures[figureindex].style.border = "none";
            visiblefigures[figureindex].style.backgroundColor = "white";
            figureindex = parseInt(this.className.substr(1));
            document.getElementById("captioneditor").value = this.getElementsByTagName("figcaption")[0].innerHTML;
            visiblefigures[figureindex].style.border = "solid";
            visiblefigures[figureindex].style.backgroundColor = "#d0ffd0";

        }
    }

}





editor = ace.edit("maineditor");
editor.setTheme("ace/theme/cobalt");
editor.getSession().setMode("ace/mode/html");
editor.getSession().setUseWrapMode(true);
editor.$blockScrolling = Infinity;

editor.setValue(document.getElementById("notexdatadiv").innerHTML);

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
    for(var index = 0;index < visiblefigures.length;index++){
        figures[index].className = "f" + index.toString();
        visiblefigures[index].className = "f" + index.toString();
        visiblefigures[index].onclick = function(){
            visiblefigures[figureindex].style.border = "none";
            visiblefigures[figureindex].style.backgroundColor = "white";
            figureindex = parseInt(this.className.substr(1));
            document.getElementById("captioneditor").value = this.getElementsByTagName("figcaption")[0].innerHTML;
            visiblefigures[figureindex].style.border = "solid";
            visiblefigures[figureindex].style.backgroundColor = "#d0ffd0";
        }
    }

}


</script>
<style>

#linktable{
    position:absolute;
    right:0px;
    top:0px;
}

#maineditor{
    position:absolute;
    top:5em;
    bottom:10px;
    right:10px;
    width:35%;
}
#scrolldisplay{
    position:absolute;
    background-color:white;
    overflow:scroll;
    color:black;
    left:10px;
    bottom:40%;
    width:50%;
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
    width:50%;
    height:35%;
    background-color:#d0ffd0;

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
    cursor:pointer;
}
figure figcaption{
    width:100%;
}


</style>

</body>
</html>