<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login_admin.php');
    exit();
}

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $stmt = $conn->prepare("DELETE FROM cadastro_aluno WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);

    if ($stmt->execute()) {
        header('Location: controle_alunos.php');
        exit();
    } else {
        echo "Erro ao deletar aluno: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Matrícula do aluno não fornecida.";
    exit();
}

$conn->close();
?>