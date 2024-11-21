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
    <title>Rejestracja</title>
    <?php
        $powiadomienie=$imieErr=$mailErr=$passErr=$nazwaErr=$a=$b=$c="";
        $display="none";
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            header("Location: ../stronaGlowna");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //to-do .env i .gitignore
            $host = 'sql7.freesqldatabase.com';
            $db_username = 'sql7745084';
            $db_password = 'aFwSc3fNu1';
            $db_name = 'sql7745084';
            $polaczenie = mysqli_connect($host, $db_username, $db_password, $db_name);
            $a = $_POST['imie'];
            $b = $_POST['nazwa'];
            $c = $_POST['mail'];
            if ($polaczenie->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if($_POST['haslo']==$_POST['hasloPowtorz']){
                $imie = $_POST['imie'];
                $nazwa=$_POST['nazwa'];
                $pass = $_POST['haslo'];
                $email = $_POST['mail'];
                if(!empty($nazwa)&&!empty($email)&&!empty($imie)&&!empty($pass)){
                    if (!empty($nazwa)&&preg_match("/^[a-zA-Z0-9_]*$/", $nazwa)) {
                        if (!empty($email)&&filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            if (!empty($pass)&&strlen($pass) > 6) {
                                if (!empty($imie)&&preg_match("/^[a-zA-Z-' ]*$/", $imie)) {
                                    $sprawdzenie = mysqli_query($polaczenie,"SELECT NazwaUzytkownika FROM users WHERE NazwaUzytkownika = '$nazwa'");
                                    $sprawdzenie1=mysqli_query($polaczenie,"SELECT EMail FROM users WHERE EMail = '$email'");
                                    $row=mysqli_fetch_array($sprawdzenie);
                                    $row1=mysqli_fetch_array($sprawdzenie1);
                                    if(empty($row)&&empty($row1)){
                                        $stmt = $polaczenie->prepare("INSERT INTO users (imie, NazwaUzytkownika, Haslo, EMail) VALUES (?, ?, ?, ?)");
                                        $stmt->bind_param("ssss", $imie, $nazwa, $pass, $email);
                                        $stmt->execute();
                                        $stmt->close();
                                        $_SESSION['logged_in'] = true;
                                        $_SESSION['user_id'] = $nazwa;
                                        mysqli_query($polaczenie,"UPDATE users SET aktywny = 1 WHERE NazwaUzytkownika = '$nazwa' OR Email = '$email'");
                                        $polaczenie->close();
                                        header("Location: ../stronaGlowna");
                                    }else{
                                        $powiadomienie="Nazwa użytkownika lub e-mail są już zajęte.";
                                        $display="";
                                    }
                                }else{
                                    $imieErr="Tylko litery i spacje są dozwolone.";
                                    $display="";
                                }
                            }else{
                                $passErr="Hasło powninno mieć co najmniej 6 znaków.";
                                $display="";
                            }
                        }else{
                            $mailErr="Źle zformułowany e-mail.";
                            $display="";
                        }
                    }else{
                        $nazwaErr="Tylko Litery, Cyfry i 'Podłogi' są dozwolone.";
                        $display="";
                    }
                }else{
                    $nazwaErr="Uzupełnij wszystkie pola.";
                    $display="";
                }
            }else{
                $passErr="Hasła się nie zgadzają.";
                $display="";
            }
        }
    ?>
</head>
<body>
    <nav>
        <ul>
            <li>
                <img src="../../res/img/logo2.png" class="logo">
            </li>
        </ul>
    </nav>

    <form method="post" class="f1">
        <h4>Rejestracja:</h4>
        <div class="kontener">
            <div class="input-wrapper">
                <input class="input-box" type="text" value="<?php echo $a;?>" placeholder="Imię" name="imie">
                <span class="underline"></span>
            </div>  
            <div class="input-wrapper">
                <input class="input-box" type="text" value="<?php echo $b;?>" placeholder="Nazwa Użytkownika" name="nazwa">
                <span class="underline"></span>
            </div>  
            <div class="input-wrapper">
                <input class="input-box" type="text" value="<?php echo $c;?>" placeholder="E-mail" name="mail">
                <span class="underline"></span>
            </div> 
            <div class="input-wrapper">
                <input class="input-box" type="text" placeholder="Hasło" name="haslo">
                <span class="underline"></span>
            </div>    
            <div class="input-wrapper">
                <input class="input-box" type="text" placeholder="Powtórz Hasło" name="hasloPowtorz">
                <span class="underline"></span>
            </div> 
        </div>
        <button class="button type1" name="submitBtn">
            <span class="btn-txt">Zarejestruj Się</span>
        </button>
        
        
        <div class="maszKonto">Masz już konto? <a href="../logowanie/">Zaloguj Się</a></div>
    </form>
    <div class="blad" style="display: <?php echo $display;?>;"><img src="../../res/img/wykrzyknik.png"><div class="txt"><?php echo $powiadomienie.$imieErr.$nazwaErr.$passErr.$mailErr?></div></div>

</body>
</html>