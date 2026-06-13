<?php
$vagas = [
    [
        "titulo" => "Estágio em Desenvolvimento Web",
        "empresa" => "Tech Solutions",
        "local" => "Umuarama - PR",
        "bolsa" => "R$ 1.200,00"
    ],
    [
        "titulo" => "Estágio em Suporte TI",
        "empresa" => "InfoTech",
        "local" => "Umuarama - PR",
        "bolsa" => "R$ 1.000,00"
    ],
    [
        "titulo" => "Estágio em Banco de Dados",
        "empresa" => "Data Systems",
        "local" => "Umuarama - PR",
        "bolsa" => "R$ 1.400,00"
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Estágios UniALFA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>Portal de Estágios UniALFA</h1>
</header>
<nav class="navbar">
    <a href="vagas.php">Vagas</a>
    <a href="minhas-candidaturas.php">Minhas Candidaturas</a>
</nav>
<main class="container">
    <h2>Vagas Disponíveis</h2>

  <?php foreach ($vagas as $vaga): ?>
    <div class="card">
        <h3><?= $vaga['titulo']; ?></h3>

        <p><strong>Empresa:</strong> <?= $vaga['empresa']; ?></p>
        <p><strong>Local:</strong> <?= $vaga['local']; ?></p>
        <p><strong>Bolsa:</strong> <?= $vaga['bolsa']; ?></p>

        <a class="btn" href="vaga.php">
            Ver Detalhes
        </a>
    </div>
<?php endforeach; ?>


</main>

</body>
</html>