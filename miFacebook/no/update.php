<?php

include_once('./connect.php');

// Verificar si el formulario ha sido enviado
if (isset($_POST['update'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $pais = $_POST['pais'];

    try {
        $db = $pdo;
        $stmt = $db->prepare("UPDATE estudiante SET nombre = ?, email = ?, telefono = ?, genero = ?, pais = ? WHERE id_estudiante = ?");
        $stmt->execute([$nombre, $email, $telefono, $genero, $pais, $id_estudiante]);

        $_SESSION['message'] = 'Usuario actualizado correctamente';
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
        header('Location: index.php');
        exit();
    }
}
?>
