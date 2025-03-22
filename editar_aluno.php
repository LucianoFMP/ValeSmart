<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login_admin.php');
    exit();
}

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $sql = "SELECT a.nome, a.matricula, a.telefone, a.email, a.endereco_id, a.status, 
                   e.cep, e.rua, e.numero, e.complemento, e.bairro 
            FROM cadastro_aluno a
            JOIN endereco e ON a.endereco_id = e.ID
            WHERE a.matricula = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
    } else {
        echo "Aluno não encontrado.";
        exit();
    }
} else {
    echo "Matrícula não especificada.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $status = $_POST['status'];
    $endereco_id = $aluno['endereco_id'];

    $stmt = $conn->prepare("UPDATE endereco SET cep=?, rua=?, numero=?, complemento=?, bairro=? WHERE ID=?");
    $stmt->bind_param("sssssi", $cep, $rua, $numero, $complemento, $bairro, $endereco_id);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE cadastro_aluno SET nome=?, telefone=?, email=?, status=? WHERE matricula=?");
    $stmt->bind_param("sssss", $nome, $telefone, $email, $status, $matricula);
    $stmt->execute();

    echo "<script>alert('Dados atualizados com sucesso!');</script>";
    header("Location: controle_alunos.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmarAtualizacao(event) {
            event.preventDefault();
            const confirmacao = confirm("Você tem certeza de que deseja atualizar o cadastro?");
            if (confirmacao) {
                document.getElementById("formEditarAluno").submit();
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Editar Aluno - ValeSmart</h1>
        <div class="auth-buttons">
            <button onclick="location.href='controle_alunos.php'">Voltar</button>
        </div>
    </header>

    <main>
        <form id="formEditarAluno" action="editar_aluno.php?matricula=<?php echo $matricula; ?>" method="POST">
            <h2>Dados do Aluno</h2>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required value="<?php echo $aluno['nome']; ?>">

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required value="<?php echo $aluno['telefone']; ?>">

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required value="<?php echo $aluno['email']; ?>">

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Aprovado" <?php echo ($aluno['status'] == 'Aprovado') ? 'selected' : ''; ?>>Aprovado</option>
                <option value="Reprovado" <?php echo ($aluno['status'] == 'Reprovado') ? 'selected' : ''; ?>>Reprovado</option>
            </select>

            <h2>Endereço</h2>

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required value="<?php echo $aluno['cep']; ?>">

            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua" required value="<?php echo $aluno['rua']; ?>">

            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" required value="<?php echo $aluno['numero']; ?>">

            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento" value="<?php echo $aluno['complemento']; ?>">

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" required value="<?php echo $aluno['bairro']; ?>">

            <button type="submit" onclick="confirmarAtualizacao(event)">Atualizar</button>
            <button type="button" onclick="location.href='processar_status.php'">Verificar Status</button>
            <button type="button" onclick="location.href='cadastra_senha.php'">Cadastrar senha</button>
            
        </form>
    </main>

    <footer>
        <p>&copy; 2024 ValeSmart. Todos os direitos reservados.</p>
    </footer>
</body>
</html>