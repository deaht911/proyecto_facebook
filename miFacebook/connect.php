<!-- connect.php -->
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=facebook_simulado', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
<!-- ├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── script.js
├── img/
│   └── facebook-logo.png
├── connect.php
├── add_user.php
├── autenticar.php
├── guardar_perfil.php
├── index.php
├── login.php
├── logout.php
└── agregar_publicacion.php -->
