<?php
require_once __DIR__ . '/../classes/ApiClient.php';
$api = new ApiClient();

// Pega o ID da vaga do parâmetro GET
$vagaId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$vagaId) {
    header('Location: vagas.php');
    exit;
}

// Busca a vaga na API
$result = $api->get("/vagas/{$vagaId}");
$vaga = $result['data'] ?? null;

if (!$vaga) {
    header('Location: vagas.php');
    exit;
}

// Processa os requisitos (se for uma string, divide em linhas)
$requisitos = [];
if (!empty($vaga['requisitos'])) {
    $requisitos = array_filter(array_map('trim', explode("\n", $vaga['requisitos'])));
}
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
    <a href="../index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
    <nav class="header-nav">
        <a href="vagas.php">Vagas</a>
        <a href="minhas-candidaturas.php">Minhas Candidaturas</a>
    </nav>
</header>

<div class="container">

    <div class="card">

        <span class="badge">Vaga <?= $vaga['status'] === 'aberta' ? 'Disponível' : 'Fechada' ?></span>

        <h2><?= htmlspecialchars($vaga['titulo'] ?? ''); ?></h2>

        <p><strong>Empresa:</strong> <?= htmlspecialchars($vaga['empresa']['nome'] ?? ''); ?></p>
        <?php if (!empty($vaga['empresa']['cidade'])): ?>
            <p><strong>Local:</strong> <?= htmlspecialchars($vaga['empresa']['cidade'] ?? ''); ?></p>
        <?php endif; ?>
        <?php if (!empty($vaga['valorBolsa'])): ?>
            <p><strong>Bolsa:</strong> R$ <?= number_format($vaga['valorBolsa'] ?? 0, 2, ',', '.'); ?></p>
        <?php endif; ?>

        <br>

        <h3>Descrição da Vaga</h3>

        <p>
            <?= nl2br(htmlspecialchars($vaga['descricao'] ?? '')); ?>
        </p>

        <?php if (!empty($requisitos)): ?>
            <br>
            <h3>Requisitos</h3>

            <ul>
                <?php foreach($requisitos as $requisito): ?>
                    <li><?= htmlspecialchars($requisito) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="candidatura.php?vaga_id=<?= $vaga['id'] ?? 0; ?>" class="btn">
            Candidatar-se
        </a>

    </div>

</div>

</body>
</html>
