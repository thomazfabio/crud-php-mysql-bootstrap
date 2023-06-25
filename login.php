<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica as credenciais no banco de dados
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Login bem-sucedido, inicia a sessão
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        // Credenciais inválidas, redireciona para a página de login
        header('Location: index.php');
        exit();
    }
}