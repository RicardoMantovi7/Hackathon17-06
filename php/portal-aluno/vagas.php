<?php
require_once __DIR__ . '/../classes/ApiClient.php';
$api = new ApiClient();
$result = $api->get('/vagas');
$vagas = $result['data'] ?? [];
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
    <a href="../index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
    <nav class="header-nav">
        <a href="vagas.php">Vagas</a>
        <a href="minhas-candidaturas.php">Minhas Candidaturas</a>
    </nav>
</header>

<main class="container">
    <h2>Vagas Disponíveis</h2>

  <?php foreach ($vagas as $vaga): ?>
    <div class="card">
        <h3><?= htmlspecialchars($vaga['titulo'] ?? ''); ?></h3>
        <p><strong>Empresa:</strong> <?= htmlspecialchars($vaga['empresa']['nome'] ?? ''); ?></p>
        <p><strong>Descrição:</strong> <?= htmlspecialchars($vaga['descricao'] ?? ''); ?></p>
        <p><strong>Requisitos:</strong> <?= htmlspecialchars($vaga['requisitos'] ?? ''); ?></p>
        <p><strong>Bolsa:</strong> R$ <?= number_format($vaga['valorBolsa'] ?? 0, 2, ',', '.'); ?></p>

        <a class="btn" href="vaga.php?id=<?= $vaga['id'] ?? 0; ?>">
            Ver Detalhes
        </a>
    </div>
<?php endforeach; ?>


</main>

</body>
</html>
