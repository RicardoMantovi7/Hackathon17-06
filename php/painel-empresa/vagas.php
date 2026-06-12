<?php

$vagas = [
    [
        "titulo" => "Estágio em Desenvolvimento Web",
        "candidatos" => 12
    ],
    [
        "titulo" => "Estágio em Suporte TI",
        "candidatos" => 8
    ]
];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vagas</title>
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

    <h2 style="margin-bottom:20px;">Minhas Vagas</h2>

    <?php foreach($vagas as $vaga): ?>

        <div class="card">

            <h3><?= $vaga['titulo'] ?></h3>

            <p>
                <strong>Candidatos:</strong>
                <?= $vaga['candidatos'] ?>
            </p>

            <a href="editar-vaga.php" class="btn">
                Editar
            </a>

        </div>

    <?php endforeach; ?>

    <a href="criar-vaga.php" class="btn">
        Nova Vaga
    </a>

</div>

</body>
</html>