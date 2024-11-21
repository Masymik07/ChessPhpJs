<?php
//to-do .env i .gitignore
$polaczenie = mysqli_connect('sql7.freesqldatabase.com','sql7745084','aFwSc3fNu1','sql7745084');

function wyczyscInput($data, $polaczenie = null) {
    if (is_array($data)) {
        // Recursively sanitize each element in the array
        return array_map(function($item) use ($polaczenie) {
            return sanitizeAllData($item, $polaczenie);
        }, $data);
    } elseif (is_object($data)) {
        // Recursively sanitize each property of the object
        foreach ($data as $key => $value) {
            $data->$key = sanitizeAllData($value, $polaczenie);
        }
        return $data;
    } elseif (is_string($data)) {
        // Sanitize strings for multiple contexts
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // HTML
        $data = filter_var($data, FILTER_SANITIZE_STRING);   // General safety
        if ($polaczenie !== null) {
            $data = mysqli_real_escape_string($polaczenie, $data); // SQL
        }
        return $data;
    } else {
        // For other data types (int, float, null, etc.), return as-is
        return $data;
    }
}
?>