<?php
try {
    // Obtener las publicaciones con el nombre del usuario
    $stmt = $pdo->query("SELECT p.*, u.nombre FROM publicaciones p JOIN usuarios u ON p.id_usuario = u.id_usuario ORDER BY p.fecha_publicacion DESC LIMIT 10");
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $publicaciones = [];
}

// Verificar si hay publicaciones
if (!empty($publicaciones)) {
    // Recorrer las publicaciones
    foreach ($publicaciones as $publicacion):
        // Si no hay color definido, asignar un valor predeterminado (gris)
        $color = isset($publicacion['color']) ? $publicacion['color'] : '#808080'; // Gris por defecto
        ?>
        <!-- Mostrar cada publicación dentro del recuadro con el color correspondiente -->
        <div class="publication-box" style="background-color: <?php echo htmlspecialchars($color); ?>;">
            <small class="post-date"><?php echo htmlspecialchars($publicacion['fecha_publicacion']); ?></small>
            <p><strong><?php echo htmlspecialchars($publicacion['nombre']); ?>:</strong></p>
            <p><?php echo htmlspecialchars($publicacion['contenido']); ?></p>
        </div>
        <?php
    endforeach;
    echo '<pre>';
var_dump($publicaciones); // Esto te permitirá ver la estructura de la variable $publicaciones
echo '</pre>';

} else {
    echo "No hay publicaciones para mostrar.";
}
?>
