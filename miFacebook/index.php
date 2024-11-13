<?php
session_start();
include_once('./connect.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Inicializar variables con valores predeterminados
$foto_perfil = './img/foto_perfil.jpg'; // Ruta por defecto
$estado_sentimental = '';
$telefono = '';

// Cargar los datos del perfil del usuario
if (isset($pdo)) { // Verifica que $pdo esté definido
    try {
        $stmt = $pdo->prepare("SELECT foto_perfil, estado_sentimental, telefono FROM usuarios WHERE id_usuario = :usuario_id");
        $stmt->execute(['usuario_id' => $_SESSION['usuario_id']]);
        $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($perfil) {
            // Asegúrate de que la ruta de la foto sea relativa desde la raíz del servidor web
            $foto_perfil = $perfil['foto_perfil'] ?? './img/foto_perfil.jpg'; // Usar ruta predeterminada si no existe
            $estado_sentimental = $perfil['estado_sentimental'] ?? 'No especificado';
            $telefono = $perfil['telefono'] ?? 'No especificado';
        }
    } catch (PDOException $e) {
        echo "Error al cargar el perfil: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión a la base de datos.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Simulado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="img/facebook-logo.png" alt="Facebook Logo" width="45">
        </div>
        <h1>Facebook</h1>
        <div>
            <a href="logout.php" class="text-white">Cerrar Sesión</a>
        </div>
    </header>

    <main class="container mt-5">
    <div class="row">
        <!-- Columna izquierda: Perfil y lista de amigos -->
        <div class="col-md-4">
            <div class="profile-container mb-4">
                <div class="profile-header" onclick="toggleProfileInfo()">
                    <img src="<?php echo $foto_perfil; ?>" alt="Foto de perfil de <?php echo htmlspecialchars($_SESSION['nombre']); ?>" class="profile-image">
                    <span class="profile-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                </div>

                <div id="profile-info" class="profile-info mt-3" style="display: none;">
                    <!-- Título para la información del perfil -->
                    <h4>Información del perfil</h4>
                    <p><strong>Estado sentimental:</strong> <?php echo htmlspecialchars($estado_sentimental); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#perfilModal">Editar Información</button>
                </div>
            </div>
            <!-- Modal para editar la información del perfil -->
            <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="perfilModalLabel">Editar Perfil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="guardar_perfil.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                                    <input type="file" name="foto_perfil" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="estado_sentimental" class="form-label">Estado Sentimental</label>
                                    <select name="estado_sentimental" class="form-select">
                                        <option value="Soltero/a" <?php echo ($estado_sentimental == 'Soltero/a') ? 'selected' : ''; ?>>Soltero/a</option>
                                        <option value="En una relación" <?php echo ($estado_sentimental == 'En una relación') ? 'selected' : ''; ?>>En una relación</option>
                                        <option value="Comprometido/a" <?php echo ($estado_sentimental == 'Comprometido/a') ? 'selected' : ''; ?>>Comprometido/a</option>
                                        <option value="Casado/a" <?php echo ($estado_sentimental == 'Casado/a') ? 'selected' : ''; ?>>Casado/a</option>
                                        <option value="Es complicado" <?php echo ($estado_sentimental == 'Es complicado') ? 'selected' : ''; ?>>Es complicado</option>
                                        <option value="Separado/a" <?php echo ($estado_sentimental == 'Separado/a') ? 'selected' : ''; ?>>Separado/a</option>
                                        <option value="Divorciado/a" <?php echo ($estado_sentimental == 'Divorciado/a') ? 'selected' : ''; ?>>Divorciado/a</option>
                                        <option value="Viudo/a" <?php echo ($estado_sentimental == 'Viudo/a') ? 'selected' : ''; ?>>Viudo/a</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="form-control" 
                                           value="<?php echo htmlspecialchars($telefono); ?>" 
                                           pattern="[0-9]{1,15}" 
                                           title="Ingrese un número de teléfono válido (8 a 15 dígitos)">
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Amigos -->
            <div class="friends-list mt-4">
                <h3>Amigos</h3>
                <?php
                try {
                    $stmt = $pdo->prepare("SELECT id_usuario, nombre, foto_perfil FROM usuarios WHERE id_usuario != :usuario_id");
                    $stmt->execute(['usuario_id' => $_SESSION['usuario_id']]);
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                    $usuarios = [];
                }
            
                if (!empty($usuarios)):
                    foreach ($usuarios as $usuario):
                ?>
                        <div class="friends-item">
                            <img src="<?php echo !empty($usuario['foto_perfil']) ? htmlspecialchars($usuario['foto_perfil']) : 'img/foto_perfil.jpg'; ?>" 
                                 alt="Foto de Perfil de <?php echo htmlspecialchars($usuario['nombre']); ?>" width="50">
                            <span><?php echo htmlspecialchars($usuario['nombre']); ?></span>
                        </div>
                <?php 
                    endforeach;
                else: 
                ?>
                    <p>No tienes amigos disponibles.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Columna derecha: Publicaciones -->
        <div class="col-md-8">
            <div class="post-input mb-3" onclick="togglePostForm()">
                <img src="<?php echo $foto_perfil; ?>" alt="Foto de Perfil">
                <span>¿Qué estás pensando, <?php echo htmlspecialchars($_SESSION['nombre']); ?>?</span>
            </div>
                        
            <div class="post-form" id="postForm" style="display: none;">
                <form action="agregar_publicacion.php" method="POST">
                    <div class="form-group">
                        <textarea name="contenido" rows="3" placeholder="Escribe algo aquí..." class="post-textarea" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="color" class="color-label">Color de fondo:</label>
                        <input type="color" name="color" value="#808080" class="color-picker"> <!-- Gris por defecto -->
                    </div>
                    <button type="submit" class="btn-post">Publicar</button>
                </form>
            </div>

            <?php
            try {
                $stmt = $pdo->query("SELECT p.*, u.nombre FROM publicaciones p JOIN usuarios u ON p.id_usuario = u.id_usuario ORDER BY p.fecha_publicacion DESC LIMIT 10");
                $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                $publicaciones = [];
            }?>
            
            <?php foreach ($publicaciones as $publicacion): ?>
                <div class="post-outer">
                    <div class="post-header">
                        <small class="post-date"><?php echo htmlspecialchars($publicacion['fecha_publicacion']); ?></small>
                        <p><strong><?php echo htmlspecialchars($publicacion['nombre']); ?>:</strong></p>
                    </div>

                    <div class="post-content" style="background-color: <?php echo htmlspecialchars($publicacion['color'] ?? '#808080'); ?>;">
                        <?php if (isset($publicacion['contenido'])): ?>
                            <p><?php echo htmlspecialchars($publicacion['contenido']); ?></p>
                        <?php else: ?>
                            <p>Contenido no disponible</p>
                        <?php endif; ?>
                    </div>
                        
                    <!-- Botones de Reacciones -->
                    <div class="reactions">
                        <button class="reaction-btn" data-publicacion-id="<?php echo $publicacion['id_publicacion']; ?>" data-reaccion="me gusta">
                            <img src="img/like.png" alt="Me gusta" width="20" height="20">
                        </button>
                        <button class="reaction-btn" data-publicacion-id="<?php echo $publicacion['id_publicacion']; ?>" data-reaccion="me encanta">
                            <img src="img/me_encanta.png" alt="Me encanta" width="20" height="20">
                        </button>
                        <button class="reaction-btn" data-publicacion-id="<?php echo $publicacion['id_publicacion']; ?>" data-reaccion="me enoja">
                            <img src="img/me_enoja.png" alt="Me enoja" width="20" height="20">
                        </button>
                        <button class="reaction-btn" data-publicacion-id="<?php echo $publicacion['id_publicacion']; ?>" data-reaccion="me sorprende">
                            <img src="img/me_asombra.png" alt="Me sorprende" width="20" height="20">
                        </button>
                    </div>
                        
                    <!-- Mostrar cantidad de reacciones -->
                    <div class="reaction-count">
                        <?php
                        // Obtener las reacciones para la publicación
                        $stmt_reacciones = $pdo->prepare("SELECT tipo_reaccion, COUNT(*) as cantidad FROM reacciones WHERE id_publicacion = :id_publicacion GROUP BY tipo_reaccion");
                        $stmt_reacciones->execute(['id_publicacion' => $publicacion['id_publicacion']]);
                        $reacciones = $stmt_reacciones->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($reacciones as $reaccion): ?>
                            <span><?php echo $reaccion['cantidad']; ?> <?php echo htmlspecialchars($reaccion['tipo_reaccion']); ?></span>
                        <?php endforeach; ?>
                    </div>
                        
                    <!-- Comentar publicación -->
                    <div class="comments">
                        <form action="comentar.php" method="POST">
                            <textarea name="comentario" placeholder="Escribe un comentario..." class="comment-textarea" required></textarea>
                            <input type="hidden" name="id_publicacion" value="<?php echo $publicacion['id_publicacion']; ?>">
                            <button type="submit" class="btn-comment">
                                <img src="./img/icono-comentar.png" alt="Comentar" width="20" height="20"> <!-- Tu icono de comentario -->
                            </button>
                        </form>
                        <!-- Mostrar los comentarios debajo de la publicación -->
                        <div class="comments-list">
                            <?php
                            // Obtener los comentarios para esta publicación
                            $stmt_comentarios = $pdo->prepare("SELECT c.*, u.nombre FROM comentarios c JOIN usuarios u ON c.id_usuario = u.id_usuario WHERE c.id_publicacion = :id_publicacion ORDER BY c.fecha_comentario DESC");
                            $stmt_comentarios->execute(['id_publicacion' => $publicacion['id_publicacion']]);
                            $comentarios = $stmt_comentarios->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <?php foreach ($comentarios as $comentario): ?>
                                <div class="comment-item">
                                    <strong><?php echo htmlspecialchars($comentario['nombre']); ?>:</strong>
                                    <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
                                    <small class="comment-date"><?php echo htmlspecialchars($comentario['fecha_comentario']); ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                            
                    <!-- Botón de Compartir -->
                    <div class="share">
                        <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://tusitio.com/publicacion.php?id=' . $publicacion['id_publicacion']); ?>" target="_blank">
                            <img src="img/icono-compartir.png" alt="Compartir" width="20" height="20">
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
                            
        </div>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.reaction-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const publicacionId = this.getAttribute('data-publicacion-id');
                    const reaccion = this.getAttribute('data-reaccion');
                
                    fetch('reaccionar.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            'publicacion_id': publicacionId,
                            'tipo_reaccion': reaccion
                        })
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);  // Verifica si todo fue bien
                        location.reload();  // Recarga la página para mostrar las reacciones actualizadas
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });

    </script>
    <script>
        function toggleProfileInfo() {
            var profileInfo = document.getElementById('profile-info');
                
            // Alternar visibilidad
            if (profileInfo.style.display === 'none' || profileInfo.style.display === '') {
                profileInfo.style.display = 'block'; // Muestra el perfil
            } else {
                profileInfo.style.display = 'none'; // Oculta el perfil
            }
        }
        
    </script>
</body>
</html>
