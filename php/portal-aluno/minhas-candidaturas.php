<?php
require_once __DIR__ . '/../classes/ApiClient.php';
require_once __DIR__ . '/../classes/Candidatura.php';

$api = new ApiClient();

// Exige login de aluno
if (!$api->isLoggedIn() || $api->getTipoLogado() !== 'aluno') {
    header('Location: ../login-aluno.php');
    exit;
}

$resp    = $api->get('/candidaturas/aluno/minhas');
$lista   = array_map(fn($c) => Candidatura::fromArray($c), $resp['data'] ?? []);
$usuario = $api->getUsuarioLogado();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas — Portal UniALFA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <a href="../index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
    <nav class="header-nav">
        <span style="color:#bfdbfe;font-size:14px">Olá, <?= htmlspecialchars($usuario['nome'] ?? 'Aluno') ?></span>
        <a href="../logout.php">Sair</a>
    </nav>
</header>

<nav class="navbar">
    <a href="vagas.php">Vagas</a>
    <a href="minhas-candidaturas.php" class="ativo">Minhas Candidaturas</a>
</nav>

<div class="container">

    <div class="secao-titulo">
        <h2>Minhas Candidaturas</h2>
        <a href="vagas.php" class="btn btn-sm">+ Nova Candidatura</a>
    </div>

    <?php if (empty($lista)): ?>
        <div class="card" style="text-align:center;padding:40px">
            <p style="font-size:16px;margin-bottom:16px">Você ainda não se candidatou a nenhuma vaga.</p>
            <a href="vagas.php" class="btn">Ver Vagas Disponíveis</a>
        </div>
    <?php else: ?>
        <div class="card" style="padding:0;overflow:hidden">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Vaga</th>
                        <th>Empresa</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista as $c): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($c->getVagaTitulo()) ?></strong></td>
                        <td><?= htmlspecialchars($c->getEmpresaNome()) ?></td>
                        <td><?= htmlspecialchars($c->getDataFormatada()) ?></td>
                        <td><?= $c->getStatusBadge() ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama<br>
    Av. Paraná, 7327 — Zona III — Umuarama/PR
</footer>

</body>
</html>