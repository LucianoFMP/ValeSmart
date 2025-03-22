<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login_admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricula'])) {
    $matricula_informada = trim($_POST['matricula']);

    if (empty($matricula_informada)) {
        echo "A matrícula não pode estar vazia.";
        exit();
    }

    $query = $conn->prepare("SELECT cadastro_aluno.nome, endereco.rua, endereco.numero, endereco.CEP, endereco.bairro 
                             FROM cadastro_aluno
                             INNER JOIN endereco ON cadastro_aluno.endereco_id = endereco.ID
                             WHERE cadastro_aluno.matricula = ?");
    $query->bind_param("s", $matricula_informada);
    $query->execute();
    $result = $query->get_result();
    $aluno = $result->fetch_assoc();

    if ($aluno) {
        
        $endereco_aluno = $aluno['rua'] . ', ' . $aluno['numero'] . ', ' . $aluno['bairro'] . ', ' . 'Palhoça - SC' . ', ' . $aluno['CEP'] . ', ' . 'Brasil';
        $endereco_escola = "R. João Pereira dos Santos, 99 - Pte. do Imaruim, Palhoça - SC, 88130-475, Brasil";
        $situacao_vale = "Calculando...";
        $distanciaLimite = 3;

    } else {
        echo "Matrícula inválida. Aluno não encontrado.";
        exit();
    }
} else {
    echo "Nenhuma matrícula foi informada.";
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situação do Vale-Transporte</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyNTgZjPeLMiuVRbW5ldRkzvrcfGBLtnM&libraries=geometry&callback=initMap" async defer></script>
</head>
<body>
    <header>
        <h1>Consulta - ValeSmart</h1>
        <div class="auth-buttons">
            <button onclick="location.href='logout.php'">Sair</button>
            <button onclick="location.href='controle_alunos.php'">Voltar</button>
        </div>
    </header>

    <main>
        <section id="situacao">
            <h3>Olá, <?php echo htmlspecialchars($aluno['nome']); ?>!</h3>
            <?php echo $endereco_aluno; ?></strong></p>
            <p>Situação do seu vale-transporte: <strong><?php echo htmlspecialchars($situacao_vale); ?></strong></p>
            <p>Distância: <strong id="distancia"></strong></p>
            <div id="map" style="height: 600px; width: 100%;"></div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ValeSmart. Todos os direitos reservados.</p>
    </footer>

    <script>
        let alunoLocation, escolaLocation;

        function initMap() {
            const enderecoAluno = "<?php echo htmlspecialchars($endereco_aluno); ?>";
            const enderecoEscola = "<?php echo htmlspecialchars($endereco_escola); ?>";
            const geocoder = new google.maps.Geocoder();

            
            geocoder.geocode({ 'address': enderecoAluno }, (results, status) => {
                if (status === 'OK' && results.length > 0) {
                    alunoLocation = results[0].geometry.location;

                    
                    geocoder.geocode({ 'address': enderecoEscola }, (results, status) => {
                        if (status === 'OK' && results.length > 0) {
                            escolaLocation = results[0].geometry.location;

                            const map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 14,
                                center: alunoLocation,
                            });

                            new google.maps.Marker({
                                position: alunoLocation,
                                map: map,
                                title: 'Sua Localização',
                            });

                            new google.maps.Marker({
                                position: escolaLocation,
                                map: map,
                                title: 'Escola',
                            });

                            calcularDistancia(alunoLocation, escolaLocation, map);
                        } else {
                            console.error('Erro ao geocodificar o endereço da escola: ' + status);
                        }
                    });
                } else {
                    console.error('Erro ao geocodificar o endereço do aluno: ' + status);
                }
            });
        }

        function calcularDistancia(alunoLocation, escolaLocation, map) {
            const distancia = google.maps.geometry.spherical.computeDistanceBetween(alunoLocation, escolaLocation) / 1000;
            document.getElementById('distancia').textContent = distancia.toFixed(2) + ' km';
            definirSituacaoVale(distancia);

            
            const radius = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '',
                fillOpacity: 0,
                map: map,
                center: escolaLocation,
                radius: <?php echo $distanciaLimite; ?> * 1000
            });
        }

        function definirSituacaoVale(distancia) {
            const distanciaLimite = <?php echo $distanciaLimite; ?>;
            const situacao = distancia > distanciaLimite ? 'Aprovada' : 'Reprovada';
            document.querySelector('#situacao p strong').textContent = situacao;
        }
    
    </script>

    <?php
    
    $situacao_vale = ($distancia <= $distanciaLimite) ? "Aprovado" : "Reprovado";

    $query = $conn->prepare("UPDATE cadastro_aluno SET status = ? WHERE matricula = ?");
    $query->bind_param("ss", $situacao_vale, $matricula_informada);
    $query->execute();
    
    ?>    

</body>
</html>