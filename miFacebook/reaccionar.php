<?php
session_start();
include_once('./connect.php'); // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "No has iniciado sesión.";
    exit();
}

// Obtener los datos enviados desde la petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $publicacion_id = $_POST['publicacion_id'];
    $tipo_reaccion = $_POST['tipo_reaccion'];
    $usuario_id = $_SESSION['usuario_id']; // Suponiendo que el ID del usuario está en la sesión

    // Insertar la reacción en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO reacciones (id_publicacion, id_usuario, tipo_reaccion) VALUES (:id_publicacion, :id_usuario, :tipo_reaccion)");
        $stmt->execute([
            'id_publicacion' => $publicacion_id,
            'id_usuario' => $usuario_id,
            'tipo_reaccion' => $tipo_reaccion
        ]);
        echo "Reacción registrada correctamente.";
    } catch (PDOException $e) {
        echo "Error al registrar la reacción: " . $e->getMessage();
    }
}
?>
