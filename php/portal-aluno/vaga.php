<?php
$vaga = [
    "titulo" => "Estágio em Desenvolvimento Web",
    "empresa" => "Tech Solutions",
    "local" => "Umuarama - PR",
    "bolsa" => "R$ 1.200,00",
    "descricao" => "Auxiliar no desenvolvimento e manutenção de sistemas web, participando da criação de novas funcionalidades e correção de bugs.",
    "requisitos" => [
        "Conhecimento básico em HTML",
        "Conhecimento básico em CSS",
        "Conhecimento básico em JavaScript",
        "Boa comunicação",
        "Vontade de aprender"
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Vaga</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>Portal de Estágios UniALFA</h1>
</header>

<div class="container">

    <div class="card">

        <span class="badge">Vaga Disponível</span>

        <h2><?= $vaga['titulo']; ?></h2>

        <p><strong>Empresa:</strong> <?= $vaga['empresa']; ?></p>
        <p><strong>Local:</strong> <?= $vaga['local']; ?></p>
        <p><strong>Bolsa:</strong> <?= $vaga['bolsa']; ?></p>

        <br>

        <h3>Descrição da Vaga</h3>

        <p>
            <?= $vaga['descricao']; ?>
        </p>

        <br>

        <h3>Requisitos</h3>

        <ul>
            <?php foreach($vaga['requisitos'] as $requisito): ?>
                <li><?= $requisito ?></li>
            <?php endforeach; ?>
        </ul>

        <a href="candidatura.php" class="btn">
            Candidatar-se
        </a>

    </div>

</div>

</body>
</html>