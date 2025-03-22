<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    header('Location: login_aluno.php');
    exit();
}

$id_aluno = $_SESSION['id'];
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['senha_antiga'], $_POST['nova_senha'])) {
    $senha_antiga = md5($_POST['senha_antiga']);
    $nova_senha = md5($_POST['nova_senha']);

    $stmt = $conn->prepare("SELECT senha FROM login_aluno WHERE matricula = ?");
    $stmt->bind_param("s", $id_aluno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        
        if ($senha_antiga === $row['senha']) {
            
            $stmt_update = $conn->prepare("UPDATE login_aluno SET senha = ? WHERE matricula = ?");
            $stmt_update->bind_param("ss", $nova_senha, $id_aluno);

            if ($stmt_update->execute()) {
                $mensagem = "<span style='color: green; font-weight: bold;'>Senha redefinida com sucesso!</span>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'perfil.php'; // Redireciona para o perfil do aluno
                        }, 3000);
                      </script>";
            } else {
                $mensagem = "<span style='color: red; font-weight: bold;'>Erro ao atualizar a senha. Tente novamente.</span>";
            }

            $stmt_update->close();
        } else {
            $mensagem = "<span style='color: red; font-weight: bold;'>A senha antiga fornecida está incorreta.</span>";
        }
    } else {
        $mensagem = "<span style='color: red; font-weight: bold;'>Aluno não encontrado.</span>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Redefinir Senha - ValeSmart</h1>
        <div class="auth-buttons">
            <button onclick="location.href='perfil.php'">Voltar</button>
        </div>
    </header>

    <main>
        <form action="redefinir_senha.php" method="POST">

            <label for="senha_antiga">Senha Antiga:</label>
            <input type="password" id="senha_antiga" name="senha_antiga" required>

            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>

            
            <?php 
            if ($mensagem): ?>
                <div><?php echo $mensagem; ?></div>
            <?php 
            endif; ?>

            <button type="submit">Redefinir Senha</button>
        </form>
    </main>
</body>
</html>
