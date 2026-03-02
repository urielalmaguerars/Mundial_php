<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mundial 1986 - México</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<style>
/* === ESTILOS GENERALES === */
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(to bottom, #001f54, #0052cc);
  color: #ffffff;
  margin: 0;
  padding: 0;
}

/* === ENCABEZADO === */
.header {
  background: rgba(255,255,255,0.1);
  color: #f5f5f5;
  padding: 30px 0;
  text-align: center;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
}

.header h1 {
  font-size: 2em;
  letter-spacing: 2px;
  text-shadow: 2px 2px 8px rgba(0,0,0,0.4);
  font-family: 'tittle';
  font-weight:normal;
  text-transform: uppercase;
}

/* === CONTENEDORES === */
.container {
  width: 90%;
  max-width: 900px;
  margin: 30px auto;
  padding: 20px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 15px;
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

/* === TEXTOS === */
h2, h3 {
  color: #f9a825;
  margin-bottom: 10px;
}

p, li {
  line-height: 1.6;
  font-size: 1.05em;
}

/* === LISTA DATOS === */
.detalles ul {
  list-style: none;
  padding: 0;
}

.detalles li {
  background: rgba(255, 255, 255, 0.15);
  margin: 8px 0;
  padding: 10px;
  border-radius: 8px;
}

/* === TARJETAS ADICIONALES === */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

.card {
  background: rgba(255, 255, 255, 0.1);
  padding: 15px;
  border-radius: 10px;
  transition: transform 0.3s ease, background 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  background: rgba(255, 255, 255, 0.2);
}

/* === FOOTER === */
.footer {
  background: #001f3f;
  text-align: center;
  padding: 15px;
  color: #ddd;
  margin-top: 50px;
  font-size: 0.9em;
}

    /* Tipos de letras */
@font-face{
    font-family:'tittle';
    src: url(fonts/Tourney/Tourney-VariableFont_wdth,wght.ttf);
    font-weight:normal;
    font-style:normal;
}

@font-face{
    font-family:'tittle2';
    src: url(fonts/Bebas_Neue/BebasNeue-Regular.ttf);
    font-weight:normal;
    font-style:normal;
}

@font-face{
    font-family:'text';
    src: url(fonts/Work_Sans/WorkSans-Italic-VariableFont_wght.ttf);
    font-weight:normal;
    font-style:normal;
}

</style>
<body>

  <header class="header">
    <h1>Mundial 1986 - México</h1>
  </header>

  <section class="intro">
    <div class="container">
      <h2>Resumen del torneo</h2>
      <p>
        El Mundial de 1986, celebrado en México, fue uno de los más memorables en la historia del fútbol.
        Argentina, liderada por Diego Maradona, se consagró campeona del mundo en una final histórica contra Alemania Federal.
      </p>
    </div>
  </section>

  <section class="detalles">
    <div class="container card">
      <h2>Datos principales</h2>
      <ul>
        <li><strong>País anfitrión:</strong> México 🇲🇽</li>
        <li><strong>Campeón:</strong> Argentina 🇦🇷</li>
        <li><strong>Subcampeón:</strong> Alemania Federal 🇩🇪</li>
        <li><strong>Mejor jugador:</strong> Diego Maradona</li>
      </ul>
    </div>
  </section>

  <section class="extra-info">
    <div class="container grid">
      <div class="card">
        <h3>🏟️ Estadios Principales</h3>
        <p>Estadio Azteca, Estadio Jalisco, Estadio Tecnológico...</p>
      </div>
      <div class="card">
        <h3>⚽ Goleadores Destacados</h3>
        <p>Gary Lineker (Inglaterra) - 6 goles<br>Careca (Brasil) - 5 goles</p>
      </div>
      <div class="card">
        <h3>🇫🇷 Equipos Destacados</h3>
        <p>Argentina, Alemania Federal, Francia, Brasil</p>
      </div>
      <div class="card">
        <h3>📊 Datos Curiosos</h3>
        <p>El famoso “Gol del Siglo” y “La Mano de Dios” de Maradona ocurrieron en este torneo.</p>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>© Historia de los Mundiales | FIFA 1986</p>
  </footer>

</body>
</html>

