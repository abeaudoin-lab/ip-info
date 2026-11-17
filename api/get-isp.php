<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
const IPINFO_TOKEN = 'YOUR_IPINFO_TOKEN_HERE'; // Remplacez par votre jeton ipinfo.io.
$ip = filter_var($_GET['ip'] ?? '', FILTER_VALIDATE_IP);
if (!$ip) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Adresse IP invalide']); exit; }
$headers = ['User-Agent: Signal Network Info/1.0'];
if (IPINFO_TOKEN !== 'YOUR_IPINFO_TOKEN_HERE') $headers[] = 'Authorization: Bearer ' . IPINFO_TOKEN;
$ctx = stream_context_create(['http'=>['timeout'=>5,'header'=>implode("\r\n", $headers)]]);
$raw = @file_get_contents('https://ipinfo.io/' . rawurlencode($ip) . '/json', false, $ctx); $data = $raw ? json_decode($raw, true) : null;
if (!is_array($data)) { http_response_code(502); echo json_encode(['ok'=>false,'error'=>'ipinfo.io indisponible']); exit; }
echo json_encode(['ok'=>true,'ip'=>$data['ip']??$ip,'org'=>$data['org']??'Non communiqué','hostname'=>$data['hostname']??null,'city'=>$data['city']??null], JSON_UNESCAPED_UNICODE);
