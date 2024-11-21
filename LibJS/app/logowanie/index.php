<?php include '../con1.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    <script src="./page.js"></script>
    <link rel="stylesheet" href="./global.css">
    <title>Logowanie</title>
</head>
<body>

    <?php 
        $powiadomienie="";$display="none";$a=$b="";
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            header("Location: ../stronaGlowna");
        }
        if (!$polaczenie) {
            die();
        }else{
            if(!empty('zaloguj')){
                //to-do walidacja formularza
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    echo '<script type="module" src="../ekranladowania.js"></script>';
                    $NAZWA = trim($_POST['nazwa']);
                    $a=$NAZWA;
                    $HASLO = $_POST['haslo']; 
                    $b=$HASLO;
                                    
                    if(!empty($NAZWA)&&!empty($HASLO)){
                        $stmt = $polaczenie->prepare("SELECT id, Haslo FROM users WHERE NazwaUzytkownika = ? OR Email = ?");
                        $stmt->bind_param("ss", $NAZWA, $NAZWA);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $hashedPassword = password_hash($row['Haslo'], PASSWORD_DEFAULT);
                            if (password_verify($HASLO, $hashedPassword)) {
                                $_SESSION['user_id'] = $NAZWA;
                                $_SESSION['logged_in'] = true;
                                mysqli_query($polaczenie,"UPDATE users SET aktywny = 1 WHERE NazwaUzytkownika = '$NAZWA' OR Email = '$NAZWA'");
                                $stmt->close();
                                mysqli_close($polaczenie);
                                header("Location: ../stronaGlowna");
                                exit;
                            }else{
                                $display="";
                                $powiadomienie="Niepoprawny e-mail lub hasło.";
                            }
                        }else{
                            $display="";
                            $powiadomienie="Niepoprawny e-mail lub hasło.";
                        }
                    }else{
                        $display="";
                        $powiadomienie="Uzupełnij wszystkie pola.";
                    }
                    
                }
            }
        }   
    ?>

    <nav>
        <ul>
            <li>
                <img src="../../res/img/logo2.png" class="logo">
            </li>
        </ul>
    </nav>

    <form method="post" class="f1">
        <h4>Logowanie:</h4>
        <div class="kontener">
            <div class="input-wrapper">
                <input class="input-box" type="text" value="<?php echo $a;?>" placeholder="Nazwa Użytkownika, E-mail:" name="nazwa">
                <span class="underline"></span>
            </div>   
            <div class="input-wrapper">
                <input class="input-box" type="password" value="<?php echo $b;?>" placeholder="Hasło:" name="haslo">
                <span class="underline"></span>
            </div>     
        </div>
        <button class="button type1">
            <span class="btn-txt">Zaloguj Się</span>
        </button>
        <div class="lub">Lub:</div>
        <a href="https://wikipedia.org"><img src="../../res/img/google.png" class="google"></a>
        <a href="https://wikipedia.org"><img src="../../res/img/facebook.png" class="facebook"></a><br>
        
        <div class="maszKonto">Nie masz jeszcze konta? <a href="../rejestracja">Zarejestruj Się</a></div>
    </form>
    
    <form method="post" class="f2">
        <h3>Zarejestruj się</h3>
    </form>
    <div class="blad" style="display: <?php echo $display;?>;"><img src="../../res/img/wykrzyknik.png"><div class="txt"><?php echo $powiadomienie;?></div></div>
    
   

</body>
</html>