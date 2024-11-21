<?php
include '../con1.php';
$dane=mysqli_query($polaczenie,'SELECT id,imie,NazwaUzytkownika,Haslo,EMail,aktywny from users') or die("polaczenie przerwane");
    echo '<table style="text-align:center;">
    <tr>
        <td><b>ID</td>
        <td><b>IMIE</td>
        <td><b>NAZWA UŻYTKOWNIKA</td>
        <td><b>HASŁO</td>
        <td><b>E-MAIL</td>
        <td><b>CZY AKTYWNY</td>
    </tr>';
    while($row=mysqli_fetch_array($dane)){
        if($row['aktywny']==0){
            $czy_aktywny="NIE";
        }else{
            $czy_aktywny="TAK";
        }
    echo 
    "<tr>
    <td>".$row['id']."</td>
    <td>".$row['imie']."</td>
    <td>".$row['NazwaUzytkownika']."</td>
    <td>".$row['Haslo']."</td>
    <td>".$row['EMail']."</td> 
    <td>".$czy_aktywny."</td> 
    </tr>";
    }