<?php
// ======= NAČÍTÁNÍ A DEKODOVÁNÍ DAT Z JSON ====== 
$main = file_get_contents(__DIR__ . "/data/main.json");
$data = json_decode($main ?: "", true) ?? [];

$site = $data["_site"] ?? [];

$a_url = $_GET["a"] ?? "lucinka_crochet";

if($a_url == "" || $a_url[0] === "_" || !isset($data[$a_url])){
    http_response_code(404);
    echo file_get_contents(__DIR__ . "/templates/404.html");
    exit;

}

// ======== NAČÍTÁNÍ HTML ŠABLON ========

$page = $data[$a_url];

function render(string $html, array $vars) : string {
    $search = $replace = [];
    foreach ($vars as $key => $value) {
        if(is_array($value)) continue;
        $search[] = "{{$key}}";
        $replace[] = htmlspecialchars((string)$value, ENT_QUOTES);
    }
    return str_replace($search, $replace, $html);
}

$tplName = basename($page["template"] ?? "home");
$tplFile = __DIR__ . "/templates/$tplName.html";
if (!is_file($tplFile)) { http_response_code(500); exit("Template not found"); }

$active = [
    "active_lucinka_crochet" => "",
    "active_cenik"           => "",
    "active_kontakt"         => "",
];
$active["active_$a_url"] = "active";
$vars = array_merge($site, $page, $active);

$content = render(file_get_contents($tplFile), $vars);

$layout = render(file_get_contents(__DIR__ . "/templates/main.html"), $vars);
echo str_replace("{content}", $content, $layout);