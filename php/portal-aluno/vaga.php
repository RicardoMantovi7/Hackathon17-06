<?php
$vaga = [
    "titulo" => "Estágio em Desenvolvimento Web",
    "empresa" => "Tech Solutions",
    "local" => "Umuarama - PR",
    "bolsa" => "R$ 1.200,00",
    "descricao" => "Auxiliar no desenvolvimento e manutenção de sistemas web utilizando tecnologias modernas."
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

<main class="container">

    <div class="card">
        <h2><?= $vaga['titulo']; ?></h2>

        <p><strong>Empresa:</strong> <?= $vaga['empresa']; ?></p>
        <p><strong>Local:</strong> <?= $vaga['local']; ?></p>
        <p><strong>Bolsa:</strong> <?= $vaga['bolsa']; ?></p>

        <h3>Descrição</h3>
        <p><?= $vaga['descricao']; ?></p>

        <br>

        <a href="candidatura.php">
            <button>Candidatar-se</button>
        </a>
    </div>

</