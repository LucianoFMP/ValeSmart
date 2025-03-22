<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco_id = $_POST['endereco_id'];

    
    $stmt = $conn->prepare("INSERT INTO cadastro_aluno (nome, matricula, telefone, email, endereco_id) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
    
        $stmt->bind_param("ssssi", $nome, $matricula, $telefone, $email, $endereco_id);

        if ($stmt->execute()) {
            echo "<h3>Aluno cadastrado com sucesso!</h3>";
            echo "<script>
                    setTimeout(function() {
                    window.location.href = 'controle_alunos.php';
                    }, 3000);
                </script>";
            exit();
        } else {
            echo "Erro ao cadastrar aluno: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Cadastro de Alunos - ValeSmart</h1>
        <div class="auth-buttons">
            <button onclick="location.href='controle_alunos.php'">Voltar</button>
        </div>
    </header>

    <main>
        <form action="cad_alunos.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required value="<?php echo isset($_COOKIE['nome']) ? $_COOKIE['nome'] : ''; ?>">

            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" required value="<?php echo isset($_COOKIE['matricula']) ? $_COOKIE['matricula'] : ''; ?>">

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required value="<?php echo isset($_COOKIE['telefone']) ? $_COOKIE['telefone'] : ''; ?>">

            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" required value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">

            <label for="endereco_id">Endereço:</label>
            <select id="endereco_id" name="endereco_id" required>
                <?php include 'atualizar_enderecos.php'; ?>
            </select>

            <button type="submit">Cadastrar aluno</button>
            <button type="button" onclick="abrirFormularioEndereco()">Incluir endereço</button>
            
        </form>

        <iframe id="iframeEndereco" src="" style="display:none; width:100%; height:400px;"></iframe>
    </main>

    <footer>
        <p>&copy; 2024 ValeSmart. Todos os direitos reservados.</p>
    </footer>

    <script>
        function abrirFormularioEndereco() {
            
            document.getElementById('iframeEndereco').src = 'cadastro_endereco.html';
            document.getElementById('iframeEndereco').style.display = 'block';
        }

        function atualizarEnderecos() {
            
            $.ajax({
                url: 'atualizar_enderecos.php',
                success: function(data) {
                    $('#endereco_id').html(data);
                }
            });
        }
    </script>
</body>
</html>
