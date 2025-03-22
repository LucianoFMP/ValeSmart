<?php
session_start();
include 'conexao.php';

// Verifica se o aluno está logado
if (!isset($_SESSION['id'])) {
    header('Location: login_aluno.php');
    exit();
}

// Obtém o ID do aluno da sessão
$id_aluno = $_SESSION['id'];

// Consulta SQL para pegar os dados do aluno e endereço
$query = $conn->prepare("SELECT cadastro_aluno.nome, login_aluno.matricula, endereco.rua, endereco.numero, endereco.CEP, endereco.bairro 
                         FROM login_aluno 
                         INNER JOIN cadastro_aluno ON login_aluno.matricula = cadastro_aluno.matricula
                         INNER JOIN endereco ON cadastro_aluno.endereco_id = endereco.ID
                         WHERE login_aluno.matricula = ?");
$query->bind_param("s", $id_aluno);
$query->execute();
$result = $query->get_result();
$aluno = $result->fetch_assoc();

if ($aluno) {
    // Concatena o endereço do aluno
    $endereco_aluno = $aluno['rua'] . ', ' . $aluno['numero'] . ', ' . $aluno['bairro'] . ', ' . 'Palhoça - SC' . ', ' . $aluno['CEP'] . ', ' . 'Brasil';
} else {
    echo "Aluno não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Aluno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("fundo5.png");
            background-repeat: no-repeat;
            background-size: cover;
        }

        header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #ffffff;
        }

        .auth-buttons {
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .auth-buttons button {
            margin-left: 10px;
        }

        h1, h2 {
            font-family: 'Roboto', sans-serif;
        }

        main {
            padding: 20px;
        }

        h2 {
            color: #030c27;
            text-align: center;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #030c27;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            margin-top: 10px;
            display: inline-block;
        }

        button:hover {
            background-color: #a60a05;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        footer {
            text-align: center;
            padding: 10px;
            background: #030c27;
            color: white;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .btn-redefinir-senha {
            background-color: #030c27;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-redefinir-senha:hover {
            background-color: #a60a05;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>
    <header>
        <h1>Meu Perfil</h1>
        <div class="auth-buttons">
            <button onclick="location.href='situacao_aluno.php'">Voltar</button>
        </div>
    </header>

    <main>
        <form method="POST" action="redefinir_senha.php">
            <section id="situacao">
                <h2>Olá, <?php echo htmlspecialchars($aluno['nome']); ?>!</h2>
                <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($aluno['matricula']); ?></p>
                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($endereco_aluno); ?></p>
            </section>

            <button type="submit" name="redefinirSenha" class="btn-redefinir-senha">Redefinir Senha</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 ValeSmart. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
