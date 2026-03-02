<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "prueba_1";
    $port = "3307";
    $conn = new mysqli($host, $user, $pass, $bd, $port);

    if($conn->connect_errno){
        echo "Failed to connect DB" . $conexion->connect_errno;
        
    }else echo "Conexion exitosa DB";

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Escáner AR de Escudos — Mundial 2026</title>
  <style>
    :root {
      --bg: #0b0f14;
      --card: #111823;
      --text: #e8f0ff;
      --accent: #00e0a4;
    }
    html, body {
      margin: 0;
      height: 100%;
      background: var(--bg);
      color: var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji";
    }
    /* Logo fijo a la izquierda */
    .brand {
      position: fixed;
      top: 12px;
      left: 12px; /* logo a la izquierda */
      z-index: 50;
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(0,0,0,0.35);
      border: 1px solid rgba(255,255,255,0.08);
      padding: 10px 12px;
      border-radius: 16px;
      backdrop-filter: blur(6px);
    }
    .brand img { height: 36px; width: auto; display: block; }
    .brand .title { font-weight: 700; letter-spacing: .2px; font-size: 14px; }

    /* Controles flotantes */
    .controls {
      position: fixed;
      right: 12px;
      top: 12px;
      z-index: 50;
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(0,0,0,0.35);
      border: 1px solid rgba(255,255,255,0.08);
      padding: 10px 12px;
      border-radius: 16px;
      backdrop-filter: blur(6px);
    }
    .controls select, .controls button {
      background: var(--card);
      color: var(--text);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 12px;
      padding: 8px 10px;
      font-size: 14px;
    }
    .controls button {
      cursor: pointer;
    }

    /* Contenedor AR de MindAR */
    #ar-container {
      position: fixed;
      inset: 0;
      overflow: hidden;
    }

    /* Indicadores y overlays */
    .hud {
      position: fixed;
      left: 50%;
      transform: translateX(-50%);
      bottom: 18px;
      z-index: 40;
      background: rgba(0,0,0,0.45);
      border: 1px solid rgba(255,255,255,0.1);
      padding: 10px 14px;
      border-radius: 14px;
      font-size: 14px;
    }
    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,0.15);
      background: rgba(0, 224, 164, 0.15);
      color: var(--text);
      font-size: 12px;
    }

    .hidden { display: none; }
    a.link { color: var(--accent); text-decoration: none; }
  </style>
  <!-- THREE.js y MindAR (vía CDN). Si cambian las versiones, actualiza las URLs. -->
  <script src="https://cdn.jsdelivr.net/npm/three@0.152.2/build/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.152.2/examples/js/loaders/FontLoader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.152.2/examples/js/geometries/TextGeometry.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/mind-ar@1.2.2/dist/mindar-image-three.prod.js"></script>
</head>
<body>
  <!-- Logo IZQUIERDA -->
  <div class="brand" title="Tu Logo">
    <!-- Reemplaza src por tu logo -->
    <img src="logo.png" alt="Logo" />
    <div class="title">Escáner AR — Mundial 2026</div>
  </div>

  <!-- Controles -->
  <div class="controls">
    <select id="cameraSelect" title="Seleccionar cámara"></select>
    <button id="startBtn">Iniciar</button>
    <button id="stopBtn" disabled>Detener</button>
  </div>

  <div id="ar-container"></div>

  <div class="hud" id="status">Da click en <b>Iniciar</b> y apunta a un escudo oficial. <span class="badge">AR</span></div>

  <script>
    // === Configura aquí tus objetivos (targets) y el detalle a mostrar ===
    // Debes generar un archivo .mind con los escudos (MindAR Image Targets).
    // El índice (0,1,2,...) corresponde al orden en que agregues los escudos al crear el .mind.
    const TEAM_DETAILS = [
      // Ejemplos. Ajusta al orden real de tus escudos.
      { team: "México", group: "D", fifa: "MEX", color: 0x0db26b, info: "Sedes: CDMX/Guadalajara/Monterrey" },
      { team: "Estados Unidos", group: "A", fifa: "USA", color: 0x2b6cb0, info: "Sedes: Varias ciudades" },
      { team: "Canadá", group: "B", fifa: "CAN", color: 0xe53e3e, info: "Sedes: Toronto/Vancouver" },
      // ...agrega más
    ];

    // Ruta del archivo .mind generado con tus escudos.
    const MIND_FILE = "./targets/escudos-2026.mind"; // coloca el archivo en /targets

    // ===== Utilidades UI =====
    const $ = (q) => document.querySelector(q);
    const cameraSelect = $('#cameraSelect');
    const startBtn = $('#startBtn');
    const stopBtn = $('#stopBtn');
    const statusHud = $('#status');

    // ===== AR con MindAR + THREE =====
    let mindarThree = null;
    let renderer, scene, camera;
    let running = false;

    async function populateCameras() {
      try {
        // Necesita permiso para enumerar dispositivos en algunos navegadores
        await navigator.mediaDevices.getUserMedia({ video: true });
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videos = devices.filter(d => d.kind === 'videoinput');
        cameraSelect.innerHTML = '';
        videos.forEach((d, i) => {
          const opt = document.createElement('option');
          opt.value = d.deviceId;
          opt.textContent = d.label || `Cámara ${i+1}`;
          cameraSelect.appendChild(opt);
        });
      } catch (e) {
        console.warn('No se pudieron listar cámaras:', e);
      }
    }

    function setStatus(msg) {
      statusHud.innerHTML = msg + ' <span class="badge">AR</span>';
    }

    async function startAR() {
      if (running) return;
      setStatus('Iniciando cámara…');

      // Preferir cámara trasera si existe
      const constraints = { video: { facingMode: 'environment' } };
      const selectedId = cameraSelect.value;
      if (selectedId) constraints.video.deviceId = { exact: selectedId };

      try {
        mindarThree = new window.MINDAR.IMAGE.MindARThree({
          container: document.querySelector('#ar-container'),
          imageTargetSrc: MIND_FILE,
          filterMinCF: 0.00001,
          filterBeta: 1e-6,
          maxTrack: 1,
          uiScanning: true,
          uiLoading: true,
          // Nota: MindAR gestiona el stream de video internamente
        });

        const obj = mindarThree;
        renderer = obj.renderer;
        scene = obj.scene;
        camera = obj.camera;

        // Luz básica
        const hemi = new THREE.HemisphereLight(0xffffff, 0x222222, 1.0);
        scene.add(hemi);

        // Crear un anchor por target disponible (según TEAM_DETAILS)
        TEAM_DETAILS.forEach((meta, idx) => {
          const anchor = mindarThree.addAnchor(idx);

          // Tarjeta flotante con info del equipo (plano)
          const planeGeo = new THREE.PlaneGeometry(1.2, 0.7, 1, 1);
          const cardTex = makeInfoTexture(meta);
          const planeMat = new THREE.MeshBasicMaterial({ map: cardTex, transparent: true });
          const card = new THREE.Mesh(planeGeo, planeMat);
          card.position.set(0, 0, 0);

          // Aro/halo debajo del escudo
          const ringGeo = new THREE.RingGeometry(0.55, 0.65, 64);
          const ringMat = new THREE.MeshBasicMaterial({ color: meta.color, opacity: 0.85, transparent: true });
          const ring = new THREE.Mesh(ringGeo, ringMat);
          ring.rotation.x = -Math.PI / 2;
          ring.position.set(0, -0.45, 0);

          // Animación sutil
          const group = new THREE.Group();
          group.add(card);
          group.add(ring);
          anchor.group.add(group);

          anchor.onTargetFound = () => {
            setStatus(`Escudo detectado: <b>${meta.team}</b> — Grupo ${meta.group} (${meta.fifa})`);
          };
          anchor.onTargetLost = () => {
            setStatus('Apunta a otro escudo oficial para ver su detalle.');
          };
        });

        await mindarThree.start();
        running = true;
        startBtn.disabled = true;
        stopBtn.disabled = false;
        setStatus('Apunta la cámara a un escudo oficial del Mundial 2026.');

        renderer.setAnimationLoop(() => {
          renderer.render(scene, camera);
        });

      } catch (err) {
        console.error(err);
        setStatus('Error iniciando AR. ¿Estás en HTTPS o localhost? Revisa la consola.');
      }
    }

    async function stopAR() {
      if (!running) return;
      await mindarThree.stop();
      mindarThree = null;
      running = false;
      startBtn.disabled = false;
      stopBtn.disabled = true;
      setStatus('AR detenido.');
    }

    // Dibuja una tarjeta de información en un canvas y la convierte en textura
    function makeInfoTexture(meta) {
      const pad = 18;
      const w = 800, h = 480;
      const cvs = document.createElement('canvas');
      cvs.width = w; cvs.height = h;
      const ctx = cvs.getContext('2d');

      // Fondo con esquina redondeada
      ctx.fillStyle = 'rgba(11, 15, 20, 0.85)';
      roundRect(ctx, 0, 0, w, h, 28);
      ctx.fill();

      // Borde/acento
      ctx.strokeStyle = '#0ae7b5';
      ctx.lineWidth = 4;
      roundRect(ctx, 2, 2, w-4, h-4, 24);
      ctx.stroke();

      // Título (equipo)
      ctx.fillStyle = '#e8f0ff';
      ctx.font = '700 46px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillText(meta.team, pad, 90);

      // Subtítulo
      ctx.font = '500 28px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillStyle = '#9bb3d6';
      ctx.fillText(`FIFA: ${meta.fifa}  ·  Grupo ${meta.group}`, pad, 140);

      // Info extra
      ctx.font = '400 26px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillStyle = '#c6d6f5';
      wrapText(ctx, meta.info, pad, 200, w - pad*2, 34);

      // Indicador AR
      ctx.fillStyle = '#0ae7b5';
      ctx.font = '600 22px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillText('Realidad Aumentada', pad, h - 24);

      const tex = new THREE.CanvasTexture(cvs);
      tex.needsUpdate = true;
      tex.encoding = THREE.sRGBEncoding;
      return tex;
    }

    function roundRect(ctx, x, y, w, h, r) {
      ctx.beginPath();
      ctx.moveTo(x+r, y);
      ctx.arcTo(x+w, y, x+w, y+h, r);
      ctx.arcTo(x+w, y+h, x, y+h, r);
      ctx.arcTo(x, y+h, x, y, r);
      ctx.arcTo(x, y, x+w, y, r);
      ctx.closePath();
    }

    function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
      const words = text.split(' ');
      let line = '';
      for (let n = 0; n < words.length; n++) {
        const testLine = line + words[n] + ' ';
        const metrics = ctx.measureText(testLine);
        if (metrics.width > maxWidth && n > 0) {
          ctx.fillText(line, x, y);
          line = words[n] + ' ';
          y += lineHeight;
        } else {
          line = testLine;
        }
      }
      ctx.fillText(line, x, y);
    }

    // Eventos UI
    startBtn.addEventListener('click', startAR);
    stopBtn.addEventListener('click', stopAR);

    // Poblar lista de cámaras al cargar
    window.addEventListener('load', () => {
      if (!navigator.mediaDevices) {
        setStatus('Tu navegador no soporta cámara (getUserMedia).');
        return;
      }
      populateCameras();
    });

    // Nota importante: Para que la cámara funcione, sirve HTTPS o http://localhost en desarrollo.
  </script>

  <!-- Instrucciones rápidas (no visibles en producción si lo quitas) -->
  <noscript>Necesitas habilitar JavaScript para usar AR.</noscript>
</body>
</html>