<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$ip = filter_var($_SERVER['REMOTE_ADDR'] ?? '', FILTER_VALIDATE_IP);
echo json_encode(['ok'=>true,'server_ip'=>$ip,'note'=>'Le contrôle WebRTC complet est effectué côté navigateur.']);
