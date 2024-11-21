<?php include '../con1.php';?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>

    <meta charset="UTF-8">
    <title>Szachy</title>
    <link rel="stylesheet" href="cssStrona.css">
    <link rel="stylesheet" href="cssPlansza.css"> 
    <script src="https://kit.fontawesome.com/43d90713db.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            /*function loadCzas() {
                $("#minuty1").load("load-minuty1.php");
                $("#minuty2").load("load-minuty2.php");
                $("#sekundy1").load("load-sekundy1.php");
                $("#sekundy2").load("load-sekundy2.php");
            }
            setInterval(loadCzas, 1000);*/
            start()
        });
    </script>
</head>
<body>

    <div class="k1">
       <p1 class="koniec">Koniec czasu <br> <a href="index.html"> <i class="fa-solid fa-arrows-rotate" style="color: #c9b999;"></i> </a> </p1>
    </div>
    <div class="k2">
        <div class="plansza" id="plansza1"></div>
            <div class="k3">
                <div class="c1"><div id="minuty1">0</div><div id="minuty2">0</div>:<div id="sekundy1">0</div><div id="sekundy2">0</div></div>
                <div class="k4">
                    <select id="select1" class="select1">
                        <option id="o1" class="o01" value="5">5 minut</option>
                        <option id="o2" class="o01" value="10">10 minut</option>      
                        <option id="o3" class="o01" value="15">15 minut</option>
                    </select>
                </div> 

                <div class="ostatnieRuchy">
                    <div class="t2">Ostatnie ruchy</div>
                </div>
                <div class="FEN">
                    
                </div>

                <div class="start">
                    <form id="form1">
                        <div class="fen"><div class="fen1">FEN</div><div class="fen2"> |</div><div class="fen4"><a onclick="skopiujFen()"><i class="fa-solid fa-copy"></i></a></div><div class="skopiowano"><i class="fa-solid fa-check"></i></div></div>
                    </form>
                </div>                            
            </div>     
    </div>
    
    <script src="../../lib/HTMLElements/Szachownica/fen.js"></script>
    <script src="../../lib/HTMLElements/Szachownica/figury.js"></script>
    <script src="../../lib/HTMLElements/Szachownica/appPlansza.js"></script>
    <script src="../../lib/HTMLElements/Szachownica/app.js"></script>
    <script src="../../lib/HTMLElements/Szachownica/czas.js"></script>
    <script src="../../lib/HTMLElements/Szachownica/walidacja.js"></script>
</body>
</html>
