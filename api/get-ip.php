<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function client_ip(): ?string {
    $candidates = [$_SERVER['HTTP_CF_CONNECTING_IP'] ?? '', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '', $_SERVER['REMOTE_ADDR'] ?? ''];
    foreach ($candidates as $value) {
        foreach (preg_split('/\s*,\s*/', $value) as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP)) return $ip;
        }
    }
    return null;
}
$ip = client_ip();
// En production, configure une URL de confiance derrière un proxy si l'IP publique doit être résolue.
$context = stream_context_create(['http' => ['timeout' => 4, 'user_agent' => 'Signal Network Info/1.0']]);
$public = @file_get_contents('https://api.ipify.org?format=json', false, $context);
$data = $public ? json_decode($public, true) : null;
$ip = is_array($data) && filter_var($data['ip'] ?? '', FILTER_VALIDATE_IP) ? $data['ip'] : $ip;
echo json_encode(['ok' => (bool)$ip, 'ip' => $ip, 'source' => $public ? 'ipify' : 'server'], JSON_UNESCAPED_UNICODE);
