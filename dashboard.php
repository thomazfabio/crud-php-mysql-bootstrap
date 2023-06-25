<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['username']; ?></h1>
        <a href="logout.php" class="btn btn-primary">Sair</a>
        <hr>
        <h2>CRUD</h2>
        <!-- Conteúdo do CRUD -->
    </div>
</body>
</html>
