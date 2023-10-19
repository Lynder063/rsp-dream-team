<!DOCTYPE HTML>
<html lang="cs">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: grey;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            margin-left: 200px;
            bottom: 0;
            width: 1480px;
        }

        button:hover{
            background-color: cyan;}

        .main {
            background: grey;
            text-align: center;
            margin-top: 5px;
            margin-left: 0px;
        }

        .left-panel, .right-panel {
            position: fixed;
            top: 0;
            height: 100%;
            width: 200px; /* Adjust the width of the side panels as needed */
        }

        .left-panel {
            left: 0;
            background: linear-gradient(to right, #4d4d4d 0%, #333333 35%);
        }

        .right-panel {
            right: 0;
            background: linear-gradient(to right, #333333 65%,  #4d4d4d 100%);
        }

        .uvod{
            width: auto;
            height: 400px;
            padding: 0px;
            margin: 0px;
            text-align: center;
            margin-top: 5px;
        }

        button{
            width: 200px;
            height: 55px;
            background: white;
            position: absolute;
            left: 870px;
            top: 430px;
            border-radius: 50px;
            text-align: center;
            border: 0px;
        }

        img{
            position: absolute;
            width: 100px;
            top: 0px;
            left: 200px;}
    </style>

</head>
<body>

<header>
    <img src="vut.png">
    <h1>[Insert karty]</h1>
</header>
<div class="left-panel">
    <!-- Left Panel Content Goes Here -->
</div>
<a href=""><button type="button">Zajímá mě!</button></a>
<div class="main">[Insert Mapu]
    <div class="uvod"><br><br><br><br><br><br><br><h1>[Insert Uvod]</h1></div>
    <!-- Main Content Goes Here -->
</div>
<div class="right-panel">
    <!-- Right Panel Content Goes Here -->
</div>
<footer>
    <p>[Footer]</p>
</footer>
</body>
</html>