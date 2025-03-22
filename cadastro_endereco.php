<?php
include 'conexao.php';

$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$arquivo = $_FILES['comprovante'];
$nomeArquivo = $arquivo['name'];
$fileTmpName = $arquivo['tmp_name'];
$destino = 'uploads/' . uniqid() . '_' . basename($nomeArquivo);

if (move_uploaded_file($fileTmpName, $destino)) {
    $sql = "INSERT INTO endereco (cep, rua, numero, complemento, bairro, comprovante) 
            VALUES ('$cep', '$rua', '$numero', '$complemento', '$bairro', '$destino')";

    if ($conn->query($sql) === TRUE) {
        echo "<h3 style='color: white;'>Cadastro realizado com sucesso!</h3>";
        echo "<script>
                parent.atualizarEnderecos();
                setTimeout(function() {
                    parent.document.getElementById('iframeEndereco').style.display = 'none';
                }, 3000);
              </script>";
        exit();
    }
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>