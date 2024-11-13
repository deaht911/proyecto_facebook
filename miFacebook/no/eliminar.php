<?php

include_once('./connect.php');

if (isset($_GET['pk'])) {
    $db = $pdo;
    $id = $_GET['pk'];

    try {
        // Preparar una declaración SQL para eliminar el registro con el ID proporcionado
        $stmt = $db->prepare("DELETE FROM estudiante WHERE id_estudiante = ?");
        
        // Ejecutar la declaración preparada con el ID del contacto
        if ($stmt->execute([$id])) {
            $_SESSION['message'] = 'Usuario eliminado correctamente';
        } else {
            $_SESSION['message'] = 'Algo salió mal. No se puede eliminar el usuario';
        }
        
    } catch (PDOException $e) {
        // Capturar y almacenar cualquier error de PDO en la sesión
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
    // Cerrar la conexión      
    $db = null;

// Redirigir después de eliminar
header('Location: index.php');
exit();
?>