<?php include '../con1.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/43d90713db.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="./styles/global.css">
    <title>Strona Główna</title>

    <script type="module" src="file.js"></script>

    <script>
        $(document).ready(function () {
            function loadPowiadomienia() {
                $("#powiadomienie").load("load-powiadomienia.php");
            }
            setInterval(loadPowiadomienia, 2000);
        });
    </script>


    <?php 
    session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false) {
            header("Location: ../logowanie");
        }else{
            if($polaczenie){
                $NAZWA=$_SESSION['user_id'];
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wyloguj'])) {
                    session_destroy();
                    mysqli_query($polaczenie,"UPDATE users SET aktywny = 0 WHERE EMail='$NAZWA' OR NazwaUzytkownika = '$NAZWA'");
                    header("Location: ../logowanie");
                }
                $rezultat = $polaczenie->query("SELECT NazwaUzytkownika FROM users WHERE EMail='$NAZWA' OR NazwaUzytkownika = '$NAZWA'");
                $wiersz = $rezultat->fetch_assoc();
                $NazwaUzytkownika = $wiersz['NazwaUzytkownika'];
            }
        }
    ?>
</head>
<body>
    <div id="LoadingScreen"></div>
    <div class="body1">
        <div class="kontenerMenu">
            <img src="../../res/img/logo2.png">
            <ul>
                <li class="opcjaMenu ikona" id="a">
                    <form method="post">
                        <button name="wyloguj"><i class="fa-solid fa-user"></i>
                        <?php 
                            echo "&nbsp;";
                            $i=0;
                            $dlugosc=strlen($NazwaUzytkownika);
                            while($i<$dlugosc&&$i<20){
                                echo $NazwaUzytkownika[$i];
                                $i++;
                            }
                            if($i<$dlugosc){
                                echo "...";
                            }
                        ?></button>
                    </form>
                </li>
                <li class="opcjaMenu">
                    <i class="fa-solid fa-square-poll-vertical"></i>&nbsp;Statystyki
                </li>
                <li class="opcjaMenu">
                </li>
            </ul>
        </div>	      

        <div class="wyslijZapr">
            <form method="post">
            <?php 
                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zapros'])){
                        echo '<script type="module" src="./ekranladowania.js"></script>';
                        $nazwa=wyczyscInput($_POST['zaproszenie']);
                        $stmt = $polaczenie->prepare("SELECT * FROM users WHERE nazwaUzytkownika = ?");
                        $stmt->bind_param("s", $nazwa);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows != 0){
                            $stmt1 = $polaczenie->prepare("INSERT INTO zaproszenia (NazwaZaproszony,NazwaZapraszajacy,czas,odczytane) values (?,?,?,?)");
                            $es="10";
                            $es1=1;
                            $nazwa1=$_SESSION['user_id'];
                            $stmt1->bind_param("sssi", $nazwa, $nazwa1, $es,$es1);
                            $stmt1->execute();
                        }
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tak'])){
                        header("Location: ../gra");
                    }
                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nie'])){
                        $nazwa=wyczyscInput($_SESSION['user_id']);
                        $stmt1 = $polaczenie->prepare("DELETE FROM zaproszenia WHERE NazwaZaproszony=?");
                        $stmt1->bind_param("s", $nazwa);
                        $stmt1->execute();
                    }
                ?>
                <input type="text" placeholder="Nazwa użytkownika lub e-mail." name="zaproszenie"><button name="zapros">Zaproś</button>
            </form>
        </div>

        <div class="powKontener"><div id="powiadomienie"></div></div>
    </div>
</body>
</html>