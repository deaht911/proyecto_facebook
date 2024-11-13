<!-- autenticar.php -->
<?php
session_start();
include_once('./connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    try {
        $db = $pdo;
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            header('Location: index.php');
        } else {
            header('Location: login.php?error=Credenciales incorrectas.');
        }
    } catch (PDOException $e) {
        header('Location: login.php?error=Error al autenticar.');
    }
}
?>
