<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
// Démo non destructive : ce endpoint ne consomme pas de bande passante réelle.
usleep(350000);
$seed = (int)(microtime(true) * 1000) % 1000;
$download = 45 + ($seed % 86); $upload = 12 + ($seed % 34); $ping = 18 + ($seed % 28);
echo json_encode(['ok'=>true,'simulated'=>true,'download'=>$download,'upload'=>$upload,'ping'=>$ping,'unit'=>'Mbps']);
