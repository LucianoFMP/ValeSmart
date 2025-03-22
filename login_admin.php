<?php
session_start();
include 'conexao.php';

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = $_POST['senha'] ?? '';
    $usuario = $_POST['usuario'] ?? '';

    $query = $conn->prepare("SELECT * FROM admin WHERE usuario = ?");
    if ($query) {
        $query->bind_param("s", $usuario);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if ($senha === $admin['senha']) {
                $_SESSION['usuario'] = $usuario;
                header('Location: controle_alunos.php');
                exit();
            } else {
                $mensagemErro = "Usuário ou senha do administrador inválidos.";
            }
        } else {
            $mensagemErro = "Usuário ou senha do administrador inválidos.";
        }
    } else {
        $mensagemErro = "Erro na consulta ao banco de dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - ValeSmart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #203557;
            position: relative;
        }
        #login {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #203557;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #a60a05;
        }
        .mensagem-erro {
            color: red;
            margin-top: 10px;
        }
        .logo {
            position: absolute;
            top: -50px;
            left: -20px;
            width: 200px;
        }
        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo" class="logo">
    
    <div class="auth-buttons">
        <button onclick="location.href='index.html'">Voltar</button>
    </div>

    <main>
        <section id="login">
        <h2 style="color:#030c27; font-size:140%;">Administrador - ValeSmart</h2>
            <form id="login-form" action="" method="POST">
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <button type="submit">Entrar</button>
            </form>

            <?php if (!empty($mensagemErro)): ?>
                <div class="mensagem-erro">
                    <?php echo htmlspecialchars($mensagemErro); ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>