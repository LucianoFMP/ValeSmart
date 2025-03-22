<?php
include 'conexao.php';
$query = "SELECT ID, rua, CEP FROM endereco ORDER BY ID DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['ID'] . "'>" . $row['rua'] . ", " . $row['CEP'] . "</option>";
    }
} else {
    echo "<option value=''>Nenhum endereço encontrado</option>";
}

$conn->close();
?>