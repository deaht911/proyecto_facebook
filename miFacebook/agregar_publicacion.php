<!-- agregar_publicacion -->
<?php
// agregar_publicacion.php
include_once('./connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contenido = $_POST['contenido'];
    $id_usuario = $_SESSION['usuario_id'];
    $color = $_POST['color'] ?? '#808080'; // Color por defecto si no se selecciona uno

    try {
        $db = $pdo;
        $stmt = $db->prepare("INSERT INTO publicaciones (contenido, id_usuario, color) VALUES (?, ?, ?)");
        $stmt->execute([$contenido, $id_usuario, $color]);
        header('Location: index.php'); // Redirige a la página principal
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
