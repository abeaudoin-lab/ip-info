(() => {
  const $ = id => document.getElementById(id);
  const set = (id, value) => { const el = $(id); if (el) el.textContent = value ?? '—'; };
  const json = url => fetch(url, {headers:{Accept:'application/json'}}).then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); });
  const now = () => set('updated-at', new Date().toLocaleTimeString('fr-FR', {hour12:false}));
  async function load() {
    now(); set('public-ip','Chargement'); set('ip-meta','Détection en cours…');
    try {
      const ipData = await json('api/get-ip.php');
      if (!ipData.ok) throw new Error('IP indisponible');
      set('public-ip', ipData.ip); set('ip-meta', `Source : ${ipData.source === 'ipify' ? 'ipify.org' : 'serveur local'}`);
      const [location, isp] = await Promise.allSettled([json(`api/get-location.php?ip=${encodeURIComponent(ipData.ip)}`), json(`api/get-isp.php?ip=${encodeURIComponent(ipData.ip)}`)]);
      if (location.status === 'fulfilled' && location.value.ok) { const d=location.value; set('location-name', d.city || d.regionName || 'Localisation inconnue'); set('location-country', `${d.country || '—'} (${d.countryCode || '—'})`); set('location-coords', (d.lat != null && d.lon != null) ? `${Number(d.lat).toFixed(2)}° / ${Number(d.lon).toFixed(2)}°` : '—'); } else set('location-name','Indisponible');
      if (isp.status === 'fulfilled' && isp.value.ok) { const d=isp.value; set('isp-name', (d.org || '—').replace(/^AS\d+\s*/,'') || 'Non communiqué'); set('isp-org', d.hostname || 'Données ipinfo.io'); set('isp-asn', d.org?.match(/^AS\d+/)?.[0] || 'ASN —'); } else { set('isp-name','Indisponible'); set('isp-org','Vérifiez le token ipinfo.io'); }
    } catch (e) { set('public-ip','Indisponible'); set('ip-meta','API inaccessible — vérifiez le serveur'); }
    try { const d=await json('api/speed-test.php'); set('download-speed', d.download); set('upload-speed', d.upload); set('ping-speed', d.ping); set('speed-status', d.simulated ? 'Simulation indicative' : 'Mesure terminée'); const meter=Math.min(100, Number(d.download)/1.5); $('speed-meter').style.width=`${meter}%`; } catch(e) { set('speed-status','Test indisponible'); }
    await checkWebRTC(); now();
  }
  async function checkWebRTC() {
    try {
      const pc = new RTCPeerConnection({iceServers:[]}); const found = new Set();
      pc.createDataChannel('signal'); pc.onicecandidate = e => { if (!e.candidate) return; const matches=e.candidate.candidate.match(/(?:\d{1,3}\.){3}\d{1,3}|[a-f0-9:]{2,}/ig)||[]; matches.forEach(x=>found.add(x)); };
      const offer=await pc.createOffer(); await pc.setLocalDescription(offer); await new Promise(r=>setTimeout(r,650)); pc.close();
      set('webrtc-count', found.size); set('webrtc-status', found.size ? 'Adresses exposées' : 'Aucune fuite détectée'); set('webrtc-detail', found.size ? 'Des candidats ICE sont visibles localement' : 'Aucun candidat IP local détecté');
    } catch(e) { set('webrtc-status','Non supporté'); set('webrtc-detail','Votre navigateur ne permet pas cette vérification'); set('webrtc-count','—'); }
  }
  $('refresh-all').addEventListener('click', load); document.addEventListener('keydown', e => { if (e.key.toLowerCase()==='r' && !['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) load(); }); load();
})();
