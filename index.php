<?php
// Point d'entrée de l'interface réseau locale.
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Tableau de bord privé pour inspecter votre connexion réseau.">
  <title>Signal / Network dossier</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/script.js"></script>
</head>
<body>
  <div class="grain" aria-hidden="true"></div>
  <main class="shell">
    <header class="masthead">
      <a class="brand" href="./" aria-label="Signal accueil"><span class="brand-mark"><i></i><i></i><i></i></span><span>SIGNAL<span class="brand-slash">/</span></span></a>
      <div class="status-chip"><span class="pulse"></span><span>SESSION LOCALE</span><span class="mono" id="updated-at">--:--:--</span></div>
    </header>

    <section class="hero">
      <div class="eyebrow"><span class="eyebrow-line"></span> DOSSIER RÉSEAU <span class="eyebrow-line short"></span></div>
      <h1>Votre connexion,<br><em>sans filtre.</em></h1>
      <p class="hero-copy">Une lecture claire de votre empreinte réseau. Les données restent dans votre navigateur, le temps de cette session.</p>
      <button class="refresh-button" id="refresh-all" type="button"><span class="refresh-icon">↻</span> Actualiser les mesures <kbd>R</kbd></button>
    </section>

    <section class="dashboard" aria-live="polite">
      <article class="card card-ip accent-coral" data-panel="ip">
        <div class="card-head"><span class="index">01</span><span class="card-label">ADRESSE PUBLIQUE</span><span class="card-dot"></span></div>
        <div class="metric metric-ip" id="public-ip">Chargement<span class="blink">_</span></div>
        <p class="muted" id="ip-meta">Détection en cours…</p>
        <div class="card-foot"><span>IPv4 / IPv6</span><span class="live-label">● LIVE</span></div>
      </article>

      <article class="card card-location accent-sun" data-panel="location">
        <div class="card-head"><span class="index">02</span><span class="card-label">GÉOLOCALISATION</span><span class="card-dot"></span></div>
        <div class="metric" id="location-name">—</div>
        <div class="location-grid"><div><span class="field-label">PAYS</span><strong id="location-country">—</strong></div><div><span class="field-label">COORDONNÉES</span><strong class="mono" id="location-coords">—</strong></div></div>
        <div class="card-foot"><span>Source : ip-api.com</span><span class="arrow">↗</span></div>
      </article>

      <article class="card card-isp accent-mint" data-panel="isp">
        <div class="card-head"><span class="index">03</span><span class="card-label">FOURNISSEUR D’ACCÈS</span><span class="card-dot"></span></div>
        <div class="metric" id="isp-name">—</div>
        <p class="muted" id="isp-org">Organisation en attente</p>
        <div class="card-foot"><span id="isp-asn">ASN —</span><span class="arrow">↗</span></div>
      </article>

      <article class="card card-speed accent-lilac" data-panel="speed">
        <div class="card-head"><span class="index">04</span><span class="card-label">VITESSE SIMULÉE</span><span class="card-dot"></span></div>
        <div class="speed-metrics"><div><div class="metric metric-speed" id="download-speed">—</div><span class="field-label">DOWNLOAD <b>↓</b></span></div><div><div class="metric metric-speed" id="upload-speed">—</div><span class="field-label">UPLOAD <b>↑</b></span></div><div><div class="metric metric-speed" id="ping-speed">—</div><span class="field-label">PING <b>◌</b></span></div></div>
        <div class="meter"><span id="speed-meter"></span></div><div class="card-foot"><span id="speed-status">Prêt à mesurer</span><span class="mono">Mbps / ms</span></div>
      </article>

      <article class="card card-webrtc accent-blue" data-panel="webrtc">
        <div class="card-head"><span class="index">05</span><span class="card-label">CONFIDENTIALITÉ WEBRTC</span><span class="card-dot"></span></div>
        <div class="webrtc-row"><div class="shield">✦</div><div><div class="metric metric-webrtc" id="webrtc-status">Vérification…</div><p class="muted" id="webrtc-detail">Analyse des candidats ICE du navigateur</p></div></div>
        <div class="card-foot"><span>IP locales détectées</span><span class="mono" id="webrtc-count">—</span></div>
      </article>
    </section>

    <footer class="footer"><span>© SIGNAL / OUTIL D’OBSERVATION LOCALE</span><span class="footer-note">Aucune donnée n’est stockée. <span class="footer-dot"></span></span></footer>
  </main>
</body>
</html>
