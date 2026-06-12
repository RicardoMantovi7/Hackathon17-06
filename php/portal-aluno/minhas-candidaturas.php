<?php

$candidaturas = [
    [
        "vaga" => "Estágio em Desenvolvimento Web",
        "empresa" => "Tech Solutions",
        "status" => "Em análise"
    ],
    [
        "vaga" => "Estágio em Suporte TI",
        "empresa" => "InfoTech",
        "status" => "Aprovado para entrevista"
    ]
];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>Portal de Estágios UniALFA</h1>
</header>

<div class="container">

    <h2 style="margin-bottom:20px;">
        Minhas Candidaturas
    </h2>

    <?php foreach($candidaturas as $c): ?>

        <div class="card">

            <h3><?= $c['vaga']; ?></h3>

            <p>
                <strong>Empresa:</strong>
                <?= $c['empresa']; ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?= $c['status']; ?>
            </p>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>