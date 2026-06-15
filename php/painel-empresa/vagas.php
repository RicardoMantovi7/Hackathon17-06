<?php
require_once __DIR__ . '/../classes/ApiClient.php';
require_once __DIR__ . '/../classes/Vaga.php';

$api = new ApiClient();

// Exige login de empresa
if (!$api->isLoggedIn() || $api->getTipoLogado() !== 'empresa') {
    header('Location: ../login-empresa.php');
    exit;
}

$resp  = $api->get('/vagas/empresa/minhas');
$vagas = array_map(fn($v) => Vaga::fromArray($v), $resp['data'] ?? []);

$msgSucesso = $_GET['msg'] ?? '';
$usuario    = $api->getUsuarioLogado();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vagas — Painel Empresa</title>
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
    <a href="dashboard.php">Dashboard</a>
    <a href="vagas.php" class="ativo">Minhas Vagas</a>
    <a href="criar-vaga.php">Nova Vaga</a>
</nav>

<div class="container">

    <?php if ($msgSucesso === 'criada'): ?>
        <div class="alerta alerta-sucesso">Vaga publicada com sucesso!</div>
    <?php elseif ($msgSucesso === 'editada'): ?>
        <div class="alerta alerta-sucesso">Vaga atualizada com sucesso!</div>
    <?php endif; ?>

    <div class="secao-titulo">
        <h2>Minhas Vagas</h2>
        <a href="criar-vaga.php" class="btn btn-dourado">+ Nova Vaga</a>
    </div>

    <?php if (empty($vagas)): ?>
        <div class="card" style="text-align:center;padding:40px">
            <p style="margin-bottom:16px">Você ainda não publicou nenhuma vaga.</p>
            <a href="criar-vaga.php" class="btn">Publicar primeira vaga</a>
        </div>
    <?php else: ?>
        <div class="card" style="padding:0;overflow:hidden">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Bolsa</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($vagas as $vaga): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($vaga->getTitulo()) ?></strong></td>
                        <td><?= $vaga->getBolsaFormatada() ?></td>
                        <td>
                            <?php if ($vaga->isAberta()): ?>
                                <span class="badge badge-sucesso">Aberta</span>
                            <?php else: ?>
                                <span class="badge badge-erro">Fechada</span>
                            <?php endif; ?>
                        </td>
                        <td style="display:flex;gap:8px;flex-wrap:wrap">
                            <a href="candidatos.php?vaga_id=<?= $vaga->getId() ?>" class="btn btn-sm btn-outline">Candidatos</a>
                            <a href="editar-vaga.php?id=<?= $vaga->getId() ?>"     class="btn btn-sm">Editar</a>
                        </td>
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