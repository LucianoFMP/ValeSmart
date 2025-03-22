<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login_admin.php');
    exit();
}

$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

if ($pesquisa) {
    $query = $conn->prepare("SELECT cadastro_aluno.*, endereco.rua, endereco.numero, endereco.complemento, endereco.bairro, endereco.cep 
                             FROM cadastro_aluno 
                             JOIN endereco ON cadastro_aluno.endereco_id = endereco.ID 
                             WHERE cadastro_aluno.nome LIKE ?");
    $likePesquisa = "%" . $pesquisa . "%";
    $query->bind_param("s", $likePesquisa);
} else {
    $query = $conn->prepare("SELECT cadastro_aluno.*, endereco.rua, endereco.numero, endereco.complemento, endereco.bairro, endereco.cep 
                             FROM cadastro_aluno 
                             JOIN endereco ON cadastro_aluno.endereco_id = endereco.ID");
}

$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Alunos Cadastrados - ValeSmart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #203557;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #203557;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .botao-container {
            margin-top: 10px;
            text-align: right;
        }

        input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        button {
            padding: 10px 15px;
            background-color: #203557;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a60a05;
        }

        .auth-buttons {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Controle de Alunos</h1>
        <div class="auth-buttons">
            <button onclick="location.href='logout.php'">Sair</button>
        </div>
    </header>

    <main>
        <h2>Lista de Alunos</h2>

        <form method="POST" action="">
            <input type="text" name="pesquisa" placeholder="Pesquisar por nome" value="<?php echo htmlspecialchars($pesquisa); ?>">
            <button type="submit">Buscar</button>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($aluno = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['matricula']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                            <td>
                                <?php 
                                echo htmlspecialchars($aluno['rua']) . ", " . 
                                    htmlspecialchars($aluno['numero']) . " - " . 
                                    htmlspecialchars($aluno['bairro']) . ", " . 
                                    htmlspecialchars($aluno['cep']);
                                ?>
                            </td>
                            <td>
                                <div class="botao-container">
                                    <button onclick="location.href='editar_aluno.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>'">Editar</button>
                                    <button onclick="if(confirm('Tem certeza de que deseja deletar este aluno?')) { location.href='deletar_aluno.php?matricula=<?php echo htmlspecialchars($aluno['matricula']); ?>'; }">Deletar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="botao-container">
            <button onclick="location.href='cad_alunos.php'">Cadastrar Novo Aluno</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 ValeSmart. Todos os direitos reservados.</p>
    </footer>
</body>
</html>