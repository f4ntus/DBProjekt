<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Rating</title>


    <style>

    .rating{
        width:200px;
        height:26px;
        margin: 0 0 20px 0;
        padding:0;
        list-style:none;
        clear:both;
        position:relative;
    }

    ul.rating li{
        float:left;
    }
    ul.rating a{
        display:block;
        width:24px;
        height:24px;
        border:1px solid #d6d6d6;
        margin:5px;
        color:white;
        text-align:center;
        text-decoration:none;
    }
    ul.rating a:hover{
        color:white; 
            background-color:#469DFA;
    }




    </style>
</head>

<body>

<!-- in Fragen.php schieben -> Formular / Radiobuttons 
    Submitbutton Formular -> 
-->
<div style= "width:500px; margin:auto;">
    <ul class="rating">
        <li class="one"><a href="?rating=1" title="1 Star">1</a></li>
        <li class="two"><a href="?rating=2" title="2 Star">2</a></li>
        <li class="three"><a href="?rating=3" title="3 Star">3</a></li>
        <li class="four"><a href="?rating=4" title="4 Star">4</a></li>
        <li class="five"><a href="?rating=5" title="5 Star">5</a></li>
    </ul>

</body>


</html>

