<?php
session_start();
include "conexion.php";

// Verificar usuario
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'usuario') {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$nombreUsuario = $_SESSION['nombre'] ?? "Invitado";

// echo "Bienvenido " . htmlspecialchars($nombreUsuario); //

// Publicaciones aprobadas
$sql = "SELECT * FROM vw_publicaciones_aprobadas 
        ORDER BY fecha_creacion DESC 
        LIMIT 3";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mundial 2026</title>
<style>
:root {
    --blanco: #ffffff;
    --gris: #f5f5f7;
    --negro: #111111;
    --azul: #0071e3;
    --rojo: #e63946;
    --verde: #2a9d8f;
    --amarillo: #FFD400;
    --naranja: #FF6B00;
    --fondo-partidos: #0b3d91;
    --fondo-paises: #e5f3e0;
}

/* Reset y tipografía */
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: "Poppins", sans-serif;
    background: var(--blanco);
    color: var(--negro);
}

/* Header */
header {
    background: rgba(255, 255, 255, 0.2); /* Transparencia blanca suave */
    backdrop-filter: blur(12px);
    position: sticky;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3); /* Línea suave */
    z-index: 1000;
    height: 60px;
    transition: background 0.3s ease, backdrop-filter 0.3s ease;
}

/* Cuando el usuario hace scroll, aumentar contraste */
header.scrolled {
    background: rgba(0, 0, 0, 0.1); /* Oscurece ligeramente al hacer scroll */
    backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
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
.nav-links {
    display: flex;
    gap: 35px;
    align-items: center;
}
.nav-links a {
    text-decoration: none;
    color: #222;
    font-weight: bold;
    transition: color 0.3s;
}
.nav-links a:hover {
    color: #007BFF;
}
.header-right {
    display: flex;
    align-items: center;
    gap: 90px;
    font-weight: 600;
    color: blue;
}
.header-right a {
    text-decoration: none;
    color: var(--rojo);
    font-weight: bold;
}
.bienvenida {
    color: red;
    font-weight: bold;
}
.header-right img {
    width: 50px; 
    height: 50px;
    border-radius: 10%;
    transition: transform 0.2s ease-in-out;
}
.header-right img:hover {
    transform: scale(1.2);
    cursor: pointer;
}
header a {
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    background: linear-gradient(90deg, #2A398D);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
header a:hover {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
}

/* Hero */
#hero{
    width:100%;
    height:104vh;
    background:
    url('uploads/mundial_hero.jpg') no-repeat center / cover;

}

#hero .container{
    width: 100%;
    height: 60%;
    max-width: 1400px;
    margin: 0; /* quita el centrado automático */
    display: flex;
    align-items: flex-start; /* arriba */
    justify-content: flex-start; /* izquierda */
}

#hero .info h1{
    font-size: 4rem;
    font-family: 'tittle2';
    text-transform: uppercase;
    margin-bottom: 2rem;
    color: black;
}

#hero .container .info p{
    font-size: 1.2rem;
    margin-bottom: 60%;
    color: black;
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


/* Secciones */
section {
    min-height: 90vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 80px 20px;
    text-align: center;
}
section h2 {
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
section p {
    max-width: 700px;
    font-family: 'text';
    font-weight:normal;
    font-size: 18px;
    color: #555;
    margin-bottom: 30px;
}

/* Secciones con colores */
#paises { background: linear-gradient(to bottom, var(--fondo-paises), #ffffff, #f2f2f2); }
#nuevo { background: linear-gradient(to bottom, #ffffff, #e0eaf3); }
#partidos { background: linear-gradient(to bottom, var(--fondo-partidos), var(--verde), #1f776d); }
#infografia { height: 300px; background: linear-gradient(to bottom right, #ffffff, #e5f3e0); }

/* Footer */
footer {
    padding: 40px;
    background: linear-gradient(to bottom, #383838, #222222);
    color: #fff;
    text-align: center;
}






/* Carrusel novedades */
#carousel-novedades {
    position: relative;
    max-width: 100%;
    height: 600px;
    overflow: hidden;
    border-radius: 15px;
    margin: 15px auto;
    border: 2px solid #ddd;
    display: flex;
    justify-content: left;
    align-items: center;
    background: #000;
}
#carousel-novedades img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
    border-radius: 15px;
}
#carousel-novedades img.active { display: block; }

#novedades{
    background-image: url('Novedades_fondo.png'); /* Ruta de tu imagen */
    background-size: cover; /* Hace que la imagen cubra toda la sección */
    background-position: center; /* Centra la imagen */
    background-repeat: no-repeat; /* Evita que se repita */
    padding: 50px 20px; /* Ajusta el espacio interno de la sección */
    color: white; /* Por si quieres que el texto sea visible sobre la imagen */
}





/* Grid de países */
.paises-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
    margin-top: 30px;
    width: 100%;
    max-width: 1200px;
}
.pais-card {
    background: linear-gradient(to bottom right, #ffffff, #e5f3e0);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    position: relative;
}
.pais-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
}
.pais-card::after {
    content: "⚽";
    position: absolute;
    font-size: 50px;
    opacity: 0.05;
    top: 10px;
    right: 10px;
}
.pais-card img { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; }
.pais-card h3 {
    font-size: 18px;
    margin-bottom: 6px;
    background: linear-gradient(90deg, #2A398D, #E61D25, #3CAC3B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.pais-card p { font-size: 14px; color: #444; }

/* Infografía mejorada */
#infografia {
    background: linear-gradient(to bottom right, #f9f9f9, #ffffff);
    padding: 60px 20px;
}

#infografia .grid-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

#infografia .card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    width: 300px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

#infografia .card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
}

#infografia h2 {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 40px;
    text-align: center;
    background: linear-gradient(90deg, #2A398D, #E61D25, #3CAC3B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

#infografia h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #2A398D;
}

#infografia p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}


/* Botones */
.btn {
    display: inline-block;
    padding: 12px 26px;
    background: var(--azul);
    color: var(--blanco);
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}
.btn:hover {
    background: linear-gradient(90deg, var(--amarillo), var(--naranja));
    transform: scale(1.05);
}

/* Publicaciones */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 25px;
    width: 100%;
    max-width: 1200px;
    margin-top: 30px;
}
.post {
    background: linear-gradient(to top, #ffffff, #dfe9f3ff);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    text-align: left;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.post .carousel {
  position: relative;
  width: 100%;
  max-height: 350px;
  overflow: hidden;
  border-radius: 10px;
  margin-top: 15px;
  background: #000;
}

.post .carousel img,
.post .carousel video {
  width: 100%;
  height: 350px;
  object-fit: cover;
  display: none;
  border-radius: 10px;
}

.post .carousel img.active,
.post .carousel video.active {
  display: block;
}

/* Dots */
.post .carousel-dots {
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
}
.post .carousel-dots span {
  width: 10px;
  height: 10px;
  background: #007bffff;
  opacity: 0.5;
  border-radius: 50%;
  cursor: pointer;
  transition: opacity 0.3s ease;
}
.post .carousel-dots span.active {
  opacity: 1;
  background: #007bffff;
}





/* Likes y comentarios */
.like-btn {
    background: var(--rojo);
    color: var(--blanco);
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 15px;
    transition: all 0.3s ease;
}
.like-btn:hover {
    background: #b22234;
    transform: scale(1.05);
}
h4 {
    margin-top: 20px;
    color: var(--azul);
    border-bottom: 2px solid var(--azul);
    padding-bottom: 5px;
}
textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    margin-top: 10px;
    resize: none;
    font-family: inherit;
}
.comment-btn {
    background: var(--verde);
    color: var(--blanco);
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: all 0.3s ease;
}
.comment-btn:hover {
    background: #1f776d;
    transform: scale(1.05);
}





/* Animaciones */
.fade-up {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-out;
}
.fade-up.show {
    opacity: 1;
    transform: translateY(0);
}
.pais-card.fade-up {
    opacity: 0;
    transform: translateY(40px) scale(0.95);
}
.pais-card.fade-up.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    transition: all 0.8s ease-out;
}
</style>


</head>
<body>

<!-- Header -->
<header>
    <!-- Logo -->
    <div class="header-left">
        <img src="mundial_mascotas.png" alt="Mundial 2026" class="logo-mascota">
    </div>

    <!-- Opciones -->
    <nav class="nav-links">
        <a href="index.php">Inicio</a>
        <a href="registro.php">Crea tu Cuenta</a>
        <a href="login.php">Subir Post</a>
    </nav>

    <!-- Bienvenida -->
    <div class="header-right">
        <a href="login.php">
            <img src="Person_icon.png" alt="Cerrar sesion">
        </a>
    </div>
</header>

<!-- Hero -->
<section id="hero">
    <div class="container">
        <div class= "info">
            <h1>Rumbo al<br>Mundial</h1>
            <p> Tres naciones, miles de sueños y 
                millones de corazones latiendo al mismo ritmo: el fútbol. 
                Vive la experiencia única del Mundial 2026</p>
        </div>
    </div>
</section>

<!-- Sección Novedades -->
<section id="novedades">
    <h2 class="fade-up" background= img>¡Novedades!</h2>


    <!-- Carrusel (funcional con autoplay cada 5s) -->
    <div class="carousel fade-up" id="carousel-novedades">
        <img src="Novedades1.webp" alt="Estadio Mundial" class="active">
        <img src="Novedades2.jpg" alt="">
        <img src="Novedades1.webp" alt="">
    </div>
    
</section>




<section id="infografia">
    <h2 class="fade-up">¿Qué es el Mundial?</h2>

    <div class="grid-container fade-up">
        <div class="card">
            <h3>¿Dónde comenzó?</h3>
            <p>
                La Copa del Mundo de la FIFA comenzó en 1930 en Uruguay, que también fue el país anfitrión 
                y campeón del torneo. La idea de un campeonato mundial surgió gracias a Jules Rimet, presidente 
                de la FIFA, quien impulsó la competencia internacional de selecciones, ya que hasta entonces el 
                fútbol solo se disputaba a nivel olímpico.
            </p>
        </div>

        <div class="card">
            <h3>¿Cuántos mundiales se han hecho?</h3>
            <p>
                Desde su creación en 1930, la Copa Mundial de la FIFA ha sido el torneo de fútbol más importante a nivel global.  
                Hasta la fecha, en 2025, se han disputado un total de 22 mundiales. Aunque el torneo se celebra cada 4 años,  
                hubo dos ocasiones en las que no se llevó a cabo: en 1942 y 1946, debido a la Segunda Guerra Mundial.
            </p>
        </div>

        <div class="card">
            <h3>¿Dónde se jugará el próximo Mundial?</h3>
            <p>
                El próximo Mundial se jugará en México, Estados Unidos y Canadá.  
                Será la primera vez que tres países compartan la sede de un torneo mundial,  
                y también marcará el debut del nuevo formato de 48 selecciones,  
                en lugar de las 32 habituales.
            </p>
        </div>
    </div>
</section>




<!-- Sección Paises -->
<section id="paises">
    <h2 class="fade-up">Países Participantes</h2>
    <p class="fade-up">Conoce todos los países clasificados al Mundial 2026, que se celebrará en Estados Unidos, México y Canadá.</p>

    <div class="paises-grid">
        <?php
        // Consulta de países (ajusta nombres de columnas según tu BD)
        $sqlPaises = "SELECT nombre, bandera, mundiales, mejor_resultado, dato_curioso 
                      FROM paises ORDER BY nombre ASC";
        $resPaises = $conn->query($sqlPaises);

        while ($pais = $resPaises->fetch_assoc()): ?>
            <div class="pais-card fade-up">
                <!-- Bandera más grande -->
                <img src="<?php echo htmlspecialchars($pais['bandera']); ?>" 
                     alt="Bandera <?php echo htmlspecialchars($pais['nombre']); ?>" 
                     style="width: 140px; height: 90px; object-fit: cover;">

                <h3><?php echo htmlspecialchars($pais['nombre']); ?></h3>
                <p><b>Participaciones en Mundiales:</b> <?php echo intval($pais['mundiales']); ?></p>

                <?php if (!empty($pais['mejor_resultado'])): ?>
                    <p><b>Mejor resultado:</b> <?php echo htmlspecialchars($pais['mejor_resultado']); ?></p>
                <?php endif; ?>

                <?php if (!empty($pais['dato_curioso'])): ?>
                    <p><i>Dato curioso:</i> <?php echo htmlspecialchars($pais['dato_curioso']); ?></p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <a href="login.php" class="btn fade-up">Ver más</a>
</section>



<!-- Sección Publicaciones -->
<section id="nuevo">
    <h2 class="fade-up">POST</h2>
    <p class="fade-up">Aquí encontrarás las publicaciones más recientes de los aficionados del Mundial 2026.</p>
    <div class="posts-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post fade-up">

            <h3 class="fade-up"><?php echo htmlspecialchars($row['titulo']); ?></h3>
            <p class="fade-up"><?php echo nl2br(htmlspecialchars($row['contenido'])); ?></p>

            <?php
            // ============================
            //  OBTENER IMÁGENES NUEVAS (BLOB)
            // ============================
            $idPublicacion = intval($row['id_publicacion']);

            $stmtImg = $conn->prepare("SELECT imagen, tipo FROM publicacion_imagen WHERE id_publicacion = ?");
            $stmtImg->bind_param("i", $idPublicacion);
            $stmtImg->execute();
            $resImg = $stmtImg->get_result();

            $imagenesBlob = [];

            while ($img = $resImg->fetch_assoc()) {
                $base64 = base64_encode($img["imagen"]);
                $imagenesBlob[] = "data:image/" . $img["tipo"] . ";base64," . $base64;
            }

            // ============================
            //  IMÁGENES VIEJAS (uploads/)
            // ============================
            $imagenesUploads = [];

            if (!empty($row['imagen'])) {
                $imagenesUploads = explode(",", $row['imagen']);
            }

            // Unir ambas fuentes
            $todasImagenes = array_merge($imagenesBlob, $imagenesUploads);
            ?>

            <!-- Mostrar imágenes -->
            <?php if (!empty($todasImagenes)): ?>
                <div class="carousel" id="carousel-<?php echo $idPublicacion; ?>">
                    <?php
                    $first = true;
                    $tiposVideo = ['mp4','avi','mov','webm'];

                    foreach ($todasImagenes as $archivo):
                        $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

                        // Video
                        if (in_array($ext, $tiposVideo)): ?>
                            <video class="<?php echo $first ? 'active' : ''; ?>" controls>
                                <source src="<?php echo $archivo; ?>" type="video/<?php echo $ext; ?>">
                            </video>
                        <?php
                        // Imagen BLOB o normal
                        else: ?>
                            <img src="<?php echo $archivo; ?>" class="<?php echo $first ? 'active' : ''; ?>">
                        <?php endif;

                        $first = false;
                    endforeach; ?>
                </div>

                <!-- Dots -->
                <div class="carousel-dots" id="dots-<?php echo $idPublicacion; ?>">
                    <?php foreach ($todasImagenes as $i => $a): ?>
                        <span class="<?php echo $i === 0 ? 'active' : ''; ?>"
                              onclick="irASlide(<?php echo $idPublicacion; ?>, <?php echo $i; ?>)"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php
            // Likes
            $sqlLikes = "SELECT COUNT(*) as total FROM likes WHERE id_publicacion=$idPublicacion";
            $likesRes = $conn->query($sqlLikes);
            $likesCount = $likesRes->fetch_assoc()['total'];
            ?>



            <h4 class="fade-up">Comentarios:</h4>
            <?php
            $sqlCom = "SELECT c.comentario, u.Nombre 
                       FROM comentarios c 
                       JOIN usuario u ON c.id_usuario = u.id_usuario 
                       WHERE c.id_publicacion = $idPublicacion 
                       ORDER BY c.fecha DESC";
            $comentarios = $conn->query($sqlCom);
            while ($com = $comentarios->fetch_assoc()): ?>
                <p class="fade-up"><b><?php echo htmlspecialchars($com['Nombre']); ?>:</b> 
                    <?php echo htmlspecialchars($com['comentario']); ?></p>
            <?php endwhile; ?>



        </div>
        <?php endwhile; ?>
    </div>

    <a href="login.php" class="btn fade-up">Ver más</a>

</section>



<footer>
    <div class="footer-container" style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:space-between; gap:30px;">
        
        <!-- Sección Acerca de -->
        <div class="footer-about" style="flex:1; min-width:250px;">
            <h3 style="color:#FFD400;">Mundial 2026</h3>
            <p>Bienvenidos al sitio oficial de noticias, novedades y estadísticas del Mundial 2026. Toda la información actualizada de selecciones, partidos y jugadores.</p>
        </div>
        
        <!-- Sección Enlaces útiles -->
        <div class="footer-links" style="flex:1; min-width:200px;">
            <h3 style="color:#FFD400;">Secciones</h3>
            <ul style="list-style:none; padding:0;">
                <li><a href="#paises" style="color:#fff; text-decoration:none;">Países participantes</a></li>
                <li><a href="#nuevo" style="color:#fff; text-decoration:none;">Novedades</a></li>
                <li><a href="#carousel-novedades" style="color:#fff; text-decoration:none;">Galería</a></li>
            </ul>
        </div>
        
        <!-- Sección Contacto -->
        <div class="footer-contact" style="flex:1; min-width:250px;">
            <h3 style="color:#FFD400;">Contacto</h3>
            <p>Email: <a href="mailto:info@mundial2026.com" style="color:#fff;">info@mundial2026.com</a></p>
            <p>Teléfono: <a href="tel:+5215551234567" style="color:#fff;">+52 1 55 5123 4567</a></p>
            <p>Dirección: Av. del Fútbol 2026, Ciudad Deportiva, México</p>
        </div>
        
       
        
    </div>

    <div style="text-align:center; margin-top:30px; border-top:1px solid #444; padding-top:20px; font-size:14px; color:#aaa;">
        &copy; 2026 Mundial 2026. Todos los derechos reservados
    </div>
</footer>


<script>
// Animación de elementos dentro de secciones (excluye carrusel)
const contenidoAnim = document.querySelectorAll("section .fade-up, .post .fade-up, section h2, section p, section img, section a, .post h3, .post p, .post form, .like-btn, .comment-btn");
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add("show");
    });
}, { threshold: 0.2 });
contenidoAnim.forEach(el => observer.observe(el));

// Hero
window.addEventListener("load", () => { document.getElementById("hero").classList.add("show"); });

// Likes AJAX
function darLike(idPublicacion) {
    let formData = new FormData();
    formData.append("id_publicacion", idPublicacion);
    fetch("like.php", { method: "POST", body: formData })
    .then(response => response.text())
    .then(data => {
        document.getElementById("like-btn-" + idPublicacion).innerText = "❤️ Me gusta (" + data + ")";
    })
    .catch(error => console.error("Error:", error));
}


function enableSwipe(id) {
    let carousel = document.getElementById("carousel-" + id);
    let startX = 0;
    carousel.addEventListener("touchstart", e => { startX = e.touches[0].clientX; });
    carousel.addEventListener("touchend", e => { let endX = e.changedTouches[0].clientX; handleSwipe(id, startX, endX); });
    carousel.addEventListener("mousedown", e => { startX = e.clientX; });
    carousel.addEventListener("mouseup", e => { let endX = e.clientX; handleSwipe(id, startX, endX); });
}
function handleSwipe(id, startX, endX) {
    let carousel = document.getElementById("carousel-" + id);
    let items = carousel.querySelectorAll("img, video");
    let currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
    if (startX - endX > 50) { irASlide(id, (currentIndex + 1) % items.length); }
    else if (endX - startX > 50) { irASlide(id, (currentIndex - 1 + items.length) % items.length); }
}
document.querySelectorAll(".carousel").forEach(c => { let id = c.id.replace("carousel-", ""); c.dataset.currentIndex = 0; enableSwipe(id); });

// Hero fade scroll
const hero = document.getElementById("hero");
window.addEventListener("scroll", () => {
    if (window.scrollY > 50) hero.classList.add("fade-out");
    else hero.classList.remove("fade-out");
});

//Carrusel de Post
function irASlide(id, index) {
    const carousel = document.getElementById("carousel-" + id);
    const items = carousel.querySelectorAll("img, video");
    const dots = document.getElementById("dots-" + id).querySelectorAll("span");

    // Quitar clase active de todos
    items.forEach(item => item.classList.remove("active"));
    dots.forEach(dot => dot.classList.remove("active"));

    // Activar la imagen/video seleccionado y el dot correspondiente
    items[index].classList.add("active");
    dots[index].classList.add("active");

    // Guardar índice actual
    carousel.dataset.currentIndex = index;
}



// --- Carrusel Novedades con autoplay ---
let indexNovedades = 0;
const slidesNovedades = document.querySelectorAll("#carousel-novedades img");
const dotsNovedades = document.querySelectorAll("#dots-novedades .dot");

function irASlideNovedades(index) {
    slidesNovedades.forEach(slide => slide.classList.remove("active"));
    dotsNovedades.forEach(dot => dot.classList.remove("active"));
    slidesNovedades[index].classList.add("active");
    dotsNovedades[index].classList.add("active");
    indexNovedades = index;
}

// Cambio automático cada 5s
setInterval(() => {
    indexNovedades = (indexNovedades + 1) % slidesNovedades.length;
    irASlideNovedades(indexNovedades);
}, 5000);

window.addEventListener("scroll", function () {
    const header = document.querySelector("header");
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});


</script>

</body>
</html>
