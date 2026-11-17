<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$ip = filter_var($_GET['ip'] ?? '', FILTER_VALIDATE_IP);
if (!$ip) { http_response_code(400); echo json_encode(['ok'=>false, 'error'=>'Adresse IP invalide']); exit; }
$url = 'http://ip-api.com/json/' . rawurlencode($ip) . '?fields=status,message,country,countryCode,city,regionName,lat,lon,timezone,query';
$ctx = stream_context_create(['http'=>['timeout'=>5, 'user_agent'=>'Signal Network Info/1.0']]);
$raw = @file_get_contents($url, false, $ctx); $data = $raw ? json_decode($raw, true) : null;
if (!is_array($data) || ($data['status'] ?? '') !== 'success') { http_response_code(502); echo json_encode(['ok'=>false,'error'=>$data['message'] ?? 'Service indisponible']); exit; }
$data['ok'] = true; echo json_encode($data, JSON_UNESCAPED_UNICODE);
