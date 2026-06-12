<?php

$candidatos = [
    [
        "nome" => "João Silva",
        "curso" => "Sistemas de Informação",
        "periodo" => "3º Período"
    ],
    [
        "nome" => "Maria Souza",
        "curso" => "Análise e Desenvolvimento de Sistemas",
        "periodo" => "2º Período"
    ]
];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>Painel da Empresa - UniALFA</h1>
</header>
<nav class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="vagas.php">Minhas Vagas</a>
    <a href="criar-vaga.php">Nova Vaga</a>
</nav>

<div class="container">

    <h2 style="margin-bottom:20px;">
        Candidatos da Vaga
    </h2>

    <?php foreach($candidatos as $candidato): ?>

        <div class="card">

            <h3><?= $candidato['nome']; ?></h3>

            <p>
                <strong>Curso:</strong>
                <?= $candidato['curso']; ?>
            </p>

            <p>
                <strong>Período:</strong>
                <?= $candidato['periodo']; ?>
            </p>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>