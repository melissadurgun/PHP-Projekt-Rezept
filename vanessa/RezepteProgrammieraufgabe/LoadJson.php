<?php
//lade Json Datei
function load_json() { 
    $filename = 'rezepte.json';
    if (!file_exists($filename)) {   
        file_put_contents($filename, json_encode([])); 
    }
    $json = file_get_contents($filename);
    return json_decode($json, true);
}
//speichere Json Datei
function save_json($data) {
    $filename = 'rezepte.json';
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT)); //schreibt in Json Datei
}
?>
