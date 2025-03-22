<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login_admin.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $senha = md5($_POST['senha']);

    $stmt = $conn->prepare("INSERT INTO login_aluno (matricula, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $matricula, $senha);

    if ($stmt->execute()) {
        echo "<h3 style='color: white;'>Senha cadastrada com sucesso!</h3>";
        echo "<script>
                    setTimeout(function() {
                    window.location.href = 'controle_alunos.php';
                    }, 3000);
                </script>";
    } else {
        echo "Erro ao cadastrar aluno: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Cadastro de Senha - ValeSmart</h1>
        <div class="auth-buttons">
            <button onclick="location.href='controle_alunos.php'">Voltar</button>
        </div>
    </header>

    <main>
        <form action="cadastra_senha.php" method="POST">
            <label for="matricula">Matricula:</label>
            <input type="text" id="matricula" name="matricula" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Cadastrar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 ValeSmart. Todos os direitos reservados.</p>
    </footer>

</body>
</html>