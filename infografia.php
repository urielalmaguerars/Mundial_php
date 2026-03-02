<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historia de los Mundiales | FIFA 2026</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom, #e6f2ff, #ffffff);
        margin: 0;
        padding: 0;
        color: #222;
    }

    header {
    background: rgba(255, 255, 255, 0.2); /* Transparencia blanca suave */
    backdrop-filter: blur(12px);
    position: sticky;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3); /* Línea suave */
    z-index: 1000;
    height: 60px;
    transition: background 0.3s ease, backdrop-filter 0.3s ease;
    }

    header h1 {
    font-size: 40px;
    font-family: 'tittle';
    font-weight:normal;
    text-transform: uppercase;
    background: linear-gradient(90deg, #2A398D, #E61D25, #3CAC3B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    margin-bottom: 20px;
    }

    .header-left {
    position: absolute;
    left: 20px; /* mantiene el logo a la izquierda */
}
    .header-left img {
    position: relative;
    z-index: 10; /* Para que sobresalga */
    width: 80px;
    height: auto;
    border-radius: 10px;
    transform: translateY(15px); /* Lo levanta un poco */
    box-shadow: 0px 4px 15px rgba(0,0,0,0.3); /* Da efecto de relieve */
}

    .header-right {
    position: absolute;
    right: 20px; /* mantiene el logo a la izquierda */
}

    .header-right img {
    width: 50px; 
    height: 40px;
    border-radius: 10%;
    transition: transform 0.2s ease-in-out;
}
    .header-right img:hover {
    transform: scale(1.2);
    cursor: pointer;
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

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 40px auto;
    }

    .world-cup {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 25px;
        margin-bottom: 25px;
        transition: transform 0.2s;
    }

    .world-cup:hover {
        transform: scale(1.02);
    }

    .world-cup h2 {
    font-size: 40px;
    font-family: 'tittle';
    font-weight:normal;
    text-transform: uppercase;
    background: linear-gradient(90deg, #2A398D, #3CAC3B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    margin-bottom: 20px;
    }

    .info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
    }

    .info img {
        width: 280px;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
        background: #ddd;
    }

    .text {
        flex: 1;
        min-width: 280px;
    }

    .highlight {
        background: linear-gradient(90deg, #007A33, #002868, #BF0A30);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-top: 40px;
    }

    .highlight h2 {
        margin-top: 0;
        font-size: 2em;
        font-family: 'tittle';
        font-weight:normal;
        text-transform: uppercase;
    }

    footer {
        text-align: center;
        padding: 20px;
        background: #002868;
        color: white;
        margin-top: 40px;
    }

    @media (max-width: 700px) {
        .info {
            flex-direction: column;
            align-items: flex-start;
        }

        .info img {
            width: 100%;
            height: auto;
        }
    }
</style>
</head>
<body>

<header>
        <!-- Logo -->
    <div class="header-left">
        <img src="mundial_mascotas.png" alt="Mundial 2026" class="logo-mascota">
    </div>

    <h1>Historia de los Mundiales - Rumbo al 2026</h1>

        <div class="header-right">
        <a href="usuario.php" id="search-btn">
            <img src="home3.png" alt="Regresar">
        </a>
    </div>
</header>

<div class="container">
    <!-- Sección 2026 -->
    <section class="highlight">
        <h2>Copa Mundial de la FIFA 2026</h2>
        <p><strong>Sedes:</strong> México 🇲🇽, Estados Unidos 🇺🇸 y Canadá 🇨🇦</p>
        <p><strong>Fechas:</strong> Junio - Julio 2026</p>
        <p><strong>Formato:</strong> 48 equipos (por primera vez en la historia)</p>
        <p><strong>Estadios Destacados:</strong> Estadio Azteca (México), MetLife Stadium (EE.UU.), BC Place (Canadá)</p>
        <p><strong>Curiosidad:</strong> México será el primer país en albergar tres Copas del Mundo (1970, 1986 y 2026).</p>
        <div class="info">
            <img src="paises/Mex-2026.jpg" alt="Imagen del Mundial 2026 (agregar)">
            <div class="text">
                <p>El Mundial 2026 será la primera Copa del Mundo organizada por tres países: México, Estados Unidos y Canadá. 
                    Se jugará del 11 de junio al 19 de julio de 2026 y contará con 48 selecciones, el mayor número 
                    en la historia del torneo. Se espera un campeonato histórico por su magnitud, diversidad y alcance global, 
                    con 104 partidos disputados en 16 ciudades de Norteamérica. Además, México hará historia al convertirse en 
                    el primer país en albergar tres Mundiales (1970, 1986 y 2026). El torneo promete una celebración futbolística 
                    sin precedentes, con nuevas oportunidades para los aficionados y un impacto deportivo, cultural y económico 
                    a nivel continental.</p>
            </div>
        </div>
    </section>

    <!-- Ejemplos de otros Mundiales -->
    <div class="world-cup">
        <h2>Mundial 2022 - Catar 🇶🇦</h2>
        <div class="info">
            <img src="paises/QATAR-2022.jpg" alt="Catar 2022 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Argentina 🇦🇷</p>
                <p><strong>Subcampeón:</strong> Francia 🇫🇷</p>
                <p><strong>Sede:</strong> Catar</p>
                <p><strong>Jugador destacado:</strong> Lionel Messi</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 2018 - Rusia 🇷🇺</h2>
        <div class="info">
            <img src="paises/RUSSIA-2018.jpg" alt="Rusia 2018 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Francia 🇫🇷</p>
                <p><strong>Subcampeón:</strong> Croacia 🇭🇷</p>
                <p><strong>Sede:</strong> Rusia</p>
                <p><strong>Jugador destacado:</strong> Kylian Mbappé</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 2014 - Brasil 🇧🇷</h2>
        <div class="info">
            <img src="paises/BRASIL-2014.jpeg" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Alemania 🇩🇪</p>
                <p><strong>Subcampeón:</strong> Argentina 🇦🇷</p>
                <p><strong>Sede:</strong> Brasil</p>
                <p><strong>Jugador destacado:</strong> James Rodríguez</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 2010 - Sudáfrica 🇿🇦</h2>
        <div class="info">
            <img src="paises/SUDAFRICA-2010.webp" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> España 🇪🇸</p>
                <p><strong>Subcampeón:</strong> Países Bajos 🇳🇱</p>
                <p><strong>Sede:</strong> Sudáfrica</p>
                <p><strong>Jugador destacado:</strong> Andrés Iniesta</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 2006 - Alemania 🇩🇪</h2>
        <div class="info">
            <img src="paises/ALEMANIA-2006.png" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Italia 🇮🇹</p>
                <p><strong>Subcampeón:</strong> Francia 🇫🇷</p>
                <p><strong>Sede:</strong> Alemania</p>
                <p><strong>Jugador destacado:</strong> Zinedine Zidane</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 2002 - Corea del Sur & Japón 🇰🇷🇯🇵</h2>
        <div class="info">
            <img src="paises/COREA-2002.png" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Brasil 🇧🇷</p>
                <p><strong>Subcampeón:</strong> Alemania 🇩🇪</p>
                <p><strong>Sede:</strong> Corea del Sur & Japón</p>
                <p><strong>Jugador destacado:</strong> Ronaldo Nazário</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 1998- Francia 🇫🇷</h2>
        <div class="info">
            <img src="paises/FRANCIA-1998.png" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Francia 🇫🇷</p>
                <p><strong>Subcampeón:</strong> Brasil 🇧🇷</p>
                <p><strong>Sede:</strong> Francia</p>
                <p><strong>Jugador destacado:</strong> Zinedine Zidane</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 1994 - Estados Unidos 🇺🇸</h2>
        <div class="info">
            <img src="paises/EUA-1994.jpg" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Brasil 🇧🇷</p>
                <p><strong>Subcampeón:</strong> Italia 🇮🇹</p>
                <p><strong>Sede:</strong> Estados Unidos</p>
                <p><strong>Jugador destacado:</strong> Romário</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 1990 - Italia 🇮🇹</h2>
        <div class="info">
            <img src="paises/ITALIA-1990.png" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Alemania Federal 🇩🇪</p>
                <p><strong>Subcampeón:</strong> Argentina 🇦🇷</p>
                <p><strong>Sede:</strong> Italia</p>
                <p><strong>Jugador destacado:</strong> Lothar Matthäus</p>
            </div>
        </div>
    </div>

    <div class="world-cup">
        <h2>Mundial 1986 - México 🇲🇽</h2>
        <div class="info">
            <img src="paises/MEXICO-1986.png" alt="Brasil 2014 (agregar)">
            <div class="text">
                <p><strong>Campeón:</strong> Argentina 🇦🇷</p>
                <p><strong>Subcampeón:</strong> Alemania Federal 🇩🇪</p>
                <p><strong>Sede:</strong> Mexico</p>
                <p><strong>Jugador destacado:</strong> Diego Maradona</p>
            </div>
        </div>
    </div>

    <!-- Puedes seguir agregando más mundiales aquí -->
</div>

<footer>
    <p>© 2025 Camino al Mundial 2026 | Creado por Uriel Almaguer ⚽</p>
</footer>

</body>
</html>
