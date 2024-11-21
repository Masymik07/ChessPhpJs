<?php
    include '../con1.php';
    session_start();
    $nazwa=$_SESSION['user_id'];
    $stmt = $polaczenie->prepare("SELECT * FROM zaproszenia WHERE NazwaZaproszony = ? and odczytane = 1 limit 1");
    $stmt->bind_param("s", $nazwa);
    $stmt->execute();
    $result = $stmt->get_result();
    if( $result->num_rows > 0 ){
        while($row = $result->fetch_assoc()){
            if($row['odczytane']==1){
                echo '<link rel="stylesheet" href="./css.css">';
                echo '<form method="post"><div class="border"><div class="nazwaUz">';
                echo '<img src="ikona1.png" class="ikonaPow">';
                echo '<b>';
                    $i=0;
                    $dlugosc=strlen($row['NazwaZapraszajacy']);
                    while($i<$dlugosc&&$i<20){
                        echo $row['NazwaZapraszajacy'][$i];
                        $i++;
                    }
                    if($i<$dlugosc){
                        echo "...";
                    }
                echo '</b><br></div><div class="wiadomosc"> Zaprasza cię do rozgrywki ( '.$row['czas'].' min ) </div>';
                echo '<div class="przyciski"> <button name="tak" class="buttonPwd tak">Zagraj</buton> <button name="nie" class="buttonPwd nie">Odrzuć</buton></div></form>';
                //$id=$row['id'];
                //$stmt1 = $polaczenie->prepare("DELETE zaproszenia SET odczytane=1 WHERE id=?");
                //$stmt1->bind_param("s", $id);
                //$stmt1->execute();
            }
        }
    }
?>