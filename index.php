<?php
// ======= NAČÍTÁNÍ A DEKODOVÁNÍ DAT Z JSON ====== 
$main = file_get_contents("data/main.json");
$data = json_decode($main ?: "", true);

$a_url = $_GET["a"] ?? "";
if($a_url == ""){
    $a_url = "lucinka_chrochet";

}elseif (!array_key_exists($a_url, $data))
{
    http_response_code(404);
    echo file_get_contents("templates/404.html");
    exit;
}

// ======== NAČÍTÁNÍ HTML ŠABLON - MAIN ========

$mainTemplate = file_get_contents("templates/main.html");
$priceTamplate = file_get_contents("templates/price.html");

$template = [$mainTemplate, $priceTamplate];