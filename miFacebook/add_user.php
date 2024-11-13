<?php
include_once('./connect.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Hash de la contraseña
    
    // Ruta de la foto de perfil predeterminada
    $foto_perfil = './img/foto_perfil.jpg';

    // Verificar si el usuario tiene al menos 14 años
    $fecha_actual = new DateTime();
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    $edad = $fecha_actual->diff($fecha_nacimiento_dt)->y;

    if ($edad < 14) {
        header('Location: login.php?error=Debes tener al menos 14 años para registrarte.');
        exit();
    }

    try {
        $db = $pdo;
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, apellido, fecha_nacimiento, genero, email, contraseña, foto_perfil) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $fecha_nacimiento, $genero, $email, $contraseña, $foto_perfil]);

        header('Location: login.php?success=Usuario creado exitosamente.');
        exit();
    } catch (PDOException $e) {
        header('Location: login.php?error=Error al crear el usuario.');
        exit();
    }
}
?>
