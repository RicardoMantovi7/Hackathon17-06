<?php
require_once __DIR__ . '/../classes/ApiClient.php';
require_once __DIR__ . '/../classes/Vaga.php';
require_once __DIR__ . '/../classes/Candidatura.php';

$api = new ApiClient();

// Exige login de empresa
if (!$api->isLoggedIn() || $api->getTipoLogado() !== 'empresa') {
    header('Location: ../login-empresa.php');
    exit;
}

$usuario = $api->getUsuarioLogado();

// Vagas da empresa
$respVagas = $api->get('/vagas/empresa/minhas');
$vagas     = array_map(fn($v) => Vaga::fromArray($v), $respVagas['data'] ?? []);
$totalVagas = count($vagas);

// Candidaturas de todas as vagas da empresa
$totalCand   = 0;
$totalAprov  = 0;
foreach ($vagas as $vaga) {
    $respCand = $api->get('/candidaturas/vaga/' . $vaga->getId());
    $cands    = array_map(fn($c) => Candidatura::fromArray($c), $respCand['data'] ?? []);
    $totalCand += count($cands);
    foreach ($cands as $c) {
        if ($c->getStatus() === 'aprovado') $totalAprov++;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Empresa — Portal UniALFA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <a href="../index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
    <nav class="header-nav">
        <span style="color:#bfdbfe;font-size:14px">Olá, <?= htmlspecialchars($usuario['nome'] ?? 'Empresa') ?></span>
        <a href="../logout.php">Sair</a>
    </nav>
</header>

<nav class="navbar">
    <a href="dashboard.php" class="ativo">Dashboard</a>
    <a href="vagas.php">Minhas Vagas</a>
    <a href="criar-vaga.php">Nova Vaga</a>
</nav>

<div class="container">

    <div class="secao-titulo">
        <h2>Bem-vindo, <?= htmlspecialchars($usuario['nome'] ?? 'Empresa') ?></h2>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-numero"><?= $totalVagas ?></div>
            <div class="stat-label">Vagas Publicadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-numero"><?= $totalCand ?></div>
            <div class="stat-label">Candidaturas Recebidas</div>
        </div>
        <div class="stat-card">
            <div class="stat-numero"><?= $totalAprov ?></div>
            <div class="stat-label">Aprovados</div>
        </div>
    </div>

    <div class="grid-cards">
        <div class="card">
            <h3>Gerenciar Vagas</h3>
            <p>Visualize, edite e encerre suas vagas de estágio publicadas no portal.</p>
            <br>
            <a href="vagas.php" class="btn">Ver Minhas Vagas</a>
        </div>
        <div class="card">
            <h3>Publicar Nova Vaga</h3>
            <p>Cadastre uma nova oportunidade de estágio e alcance alunos da UniALFA.</p>
            <br>
            <a href="criar-vaga.php" class="btn btn-dourado">Criar Nova Vaga</a>
        </div>
        <div class="card">
            <h3>Candidatos</h3>
            <p>Veja os alunos que se candidataram às suas vagas e atualize os status.</p>
            <br>
            <a href="vagas.php" class="btn btn-outline">Ver Minhas Vagas</a>
        </div>
    </div>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama<br>
    Av. Paraná, 7327 — Zona III — Umuarama/PR
</footer>

</body>
</html>