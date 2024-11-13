<?php
session_start();
include_once('./connect.php');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Procesar la foto de perfil si se ha subido
        $foto_perfil = '';
        if (!empty($_FILES['foto_perfil']['name'])) {
            $foto_nombre = basename($_FILES['foto_perfil']['name']);
            $foto_ruta = "./img/" . $foto_nombre;

            // Mover el archivo subido a la carpeta de imágenes
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_ruta)) {
                $foto_perfil = $foto_ruta;
            } else {
                $_SESSION['message'] = "Error al subir la foto de perfil.";
                header('Location: index.php');
                exit();
            }
        }

        // Actualizar los datos en la base de datos
        $stmt = $pdo->prepare("UPDATE usuarios SET estado_sentimental = :estado, telefono = :telefono" . 
                              ($foto_perfil ? ", foto_perfil = :foto" : "") . 
                              " WHERE id_usuario = :id");

        $params = [
            'estado' => $_POST['estado_sentimental'],
            'telefono' => $_POST['telefono'],
            'id' => $_SESSION['usuario_id']
        ];

        if ($foto_perfil) {
            $params['foto'] = $foto_perfil;
        }

        $stmt->execute($params);

        $_SESSION['message'] = "Perfil actualizado correctamente.";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error al actualizar el perfil: " . $e->getMessage();
    }
}

header('Location: index.php');
exit();
?>
