<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Países Mundial 2026</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom, #001a3d, #003d99);
        color: #fff;
        margin: 0; padding: 0;
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
        background: linear-gradient(90deg, #D4AF37, #ded2aeff);
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
        width: 90%; max-width: 1100px;
        margin: 30px auto;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2em;
        letter-spacing: 2px;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    .pais {
        background: rgba(255,255,255,0.1);
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: .3s;
    }
    .pais:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-5px);
    }
    .img-box {
        width: 100%;
        height: 120px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        margin-bottom: 10px;
    }
</style>
</head>
<body>

<header>
        <!-- Logo -->
    <div class="header-left">
        <img src="mundial_mascotas.png" alt="Mundial 2026" class="logo-mascota">
    </div>

    <h1>El Sueño del Mundial rumbo a 2026</h1>

        <div class="header-right">
        <a href="usuario.php" id="search-btn">
            <img src="home3.png" alt="Regresar">
        </a>
    </div>
</header>

<div class="container">

    <div class="grid">

        <?php
        $paises = [
            "Argentina", "Brasil", "México", "Estados Unidos", "Canadá", "Francia",
            "Alemania", "España", "Inglaterra", "Japón", "Corea del Sur", "Holanda",
            "Portugal", "Italia", "Croacia", "Uruguay", "Colombia", "Chile",
            "Ecuador", "Perú", "Australia", "Nigeria", "Marruecos", "Egipto",
            "Camerún", "Ghana", "Senegal", "Arabia Saudita", "Qatar", "China",
            "Irán", "Serbia", "Suiza", "Suecia", "Polonia", "Ucrania",
            "Bélgica", "Turquía", "Escocia", "Gales", "Costa Rica", "Panamá",
            "Honduras", "Jamaica", "Paraguay", "Bolivia", "Noruega", "República Checa"
        ];

        foreach ($paises as $pais) {

            // Convertir espacios a "_" para el nombre del archivo
            $archivo = str_replace(" ", "_", $pais) . ".jpg";

            echo "
            <a href='pais.php?pais=".urlencode($pais)."' style='text-decoration:none; color:#D4AF37;'>
                <div class='pais'>
                    <img src='paises/$archivo' class='img-box' alt='$pais'>
                    <h3>$pais</h3>
                </div>
            </a>";
        }

        ?>

    </div>
</div>

</body>
</html>
