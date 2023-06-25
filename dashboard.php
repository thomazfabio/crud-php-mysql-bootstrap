<?php
include 'db_config.php';
session_start();

// Verifica se o ID do cliente foi fornecido na URL
if (isset($_GET['id'])) {
    $editar = true;
    $cliente_id = $_GET['id'];

    // Consulta SQL para obter os dados do cliente pelo ID
    $sql = "SELECT * FROM clientes WHERE cliente_id = $cliente_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $email = $row['email'];
        $endereco = $row['endereco'];
    }
}

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
        <a href="dashboard.php" class="btn btn-success">Home</a>
        <a href="logout.php" class="btn btn-primary">Sair</a>
        <hr>
    </div>

    <div class="container">
        <h2>Cadastro de Cliente</h2>

        <?php if (isset($editar) && $editar) { ?>
            <form method="POST" action="editar_cliente.php">
                <input type="hidden" name="cliente_id" value="<?php echo isset($cliente_id) ? $cliente_id : ''; ?>">
            <?php } else { ?>
                <form method="POST" action="salvar_cliente.php">
                <?php } ?>


                <input type="hidden" name="cliente_id" value="<?php echo isset($cliente_id) ? $cliente_id : ''; ?>">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required value="<?php echo isset($nome) ? $nome : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($email) ? $email : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required value="<?php echo isset($endereco) ? $endereco : ''; ?>">
                </div>
                <?php if (isset($editar) && $editar) { ?>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="dashboard.php" class="btn btn-warning">Cancelar</a>
                <?php } else { ?>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                <?php } ?>
                </form>

                <h2>Lista de Clientes</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        // Consulta SQL para obter os clientes
                        $sql = "SELECT * FROM clientes";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['cliente_id'] . "</td>";
                                echo "<td>" . $row['nome'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['endereco'] . "</td>";
                                echo "<td>";
                                echo "<a href='dashboard.php?editar=true&id=" . $row['cliente_id'] . "' class='btn btn-primary'>Editar</a> ";
                                echo "<a href='excluir_cliente.php?id=" . $row['cliente_id'] . "' class='btn btn-danger'>Excluir</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum cliente encontrado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
    </div>
</body>

</html>