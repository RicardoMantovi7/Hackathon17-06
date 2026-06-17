<?php
require_once __DIR__ . '/classes/ApiClient.php';
$api = new ApiClient();

// Busca as estatísticas da API
$respEstatisticas = $api->get('/estatisticas', false);
$estatisticas = $respEstatisticas['data'] ?? [
    'totalVagas' => 0,
    'totalEmpresas' => 0,
    'totalCandidaturas' => 0,
    'totalContratacoes' => 0
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Estágios — UniALFA</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
    <nav class="header-nav">
        <a href="portal-aluno/vagas.php">Sou Aluno</a>
        <a href="painel-empresa/dashboard.php">Sou Empresa</a>
    </nav>
</header>

<!-- Hero -->
<div class="hero">
    <h1>Conectando Talentos às Oportunidades Locais</h1>
    <p>O portal oficial de estágios da UniALFA — Faculdade Alfa Umuarama.<br>
       Encontre sua vaga ou cadastre sua empresa.</p>
    <div class="hero-botoes">
        <a href="portal-aluno/vagas.php"       class="btn btn-dourado">Ver Vagas Disponíveis</a>
        <a href="painel-empresa/dashboard.php" class="btn btn-outline" style="color:#fff;border-color:#fff">Painel da Empresa</a>
    </div>
</div>

<!-- Stats -->
<div class="container">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-numero"><?= htmlspecialchars($estatisticas['totalVagas']) ?></div>
            <div class="stat-label">Vagas Abertas</div>
        </div>
        <div class="stat-card">
            <div class="stat-numero"><?= htmlspecialchars($estatisticas['totalEmpresas']) ?></div>
            <div class="stat-label">Empresas Parceiras</div>
        </div>
        <div class="stat-card">
            <div class="stat-numero"><?= htmlspecialchars($estatisticas['totalCandidaturas']) ?></div>
            <div class="stat-label">Candidaturas</div>
        </div>
        <div class="stat-card">
            <div class="stat-numero"><?= htmlspecialchars($estatisticas['totalContratacoes']) ?></div>
            <div class="stat-label">Contratações</div>
        </div>
    </div>
</div>

</body>
</html>
