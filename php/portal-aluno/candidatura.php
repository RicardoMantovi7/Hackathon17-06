<?php
require_once __DIR__ . '/../classes/ApiClient.php';
require_once __DIR__ . '/../classes/Vaga.php';

$api = new ApiClient();

// Exige login de aluno
if (!$api->isLoggedIn() || $api->getTipoLogado() !== 'aluno') {
    header('Location: ../login-aluno.php');
    exit;
}

$vagaId = intval($_GET['vaga_id'] ?? 0);
$resp   = $api->get('/vagas/' . $vagaId);
$data   = $resp['data'] ?? null;

if (!$data) { header('Location: vagas.php'); exit; }
$vaga = Vaga::fromArray($data);

$sucesso = false;
$erro    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $api->post('/candidaturas', ['vagaId' => $vagaId]);

    if ($result['success'] ?? false) {
        $sucesso = true;
    } else {
        $erro = $result['message'] ?? 'Erro ao enviar candidatura. Tente novamente.';
    }
}

$usuario = $api->getUsuarioLogado();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatura — Portal UniALFA</title>
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
    </nav>
</header>

<nav class="navbar">
    <a href="vagas.php">Vagas</a>
    <a href="minhas-candidaturas.php">Minhas Candidaturas</a>
</nav>

<div class="container" style="max-width:640px">

    <div style="margin-bottom:16px">
        <a href="vaga.php?id=<?= $vagaId ?>" style="color:var(--azul-medio);font-size:14px;text-decoration:none">← Voltar para a vaga</a>
    </div>

    <?php if ($sucesso): ?>
        <div class="alerta alerta-sucesso">
            Candidatura enviada com sucesso! Acompanhe o status em <a href="minhas-candidaturas.php">Minhas Candidaturas</a>.
        </div>
    <?php endif; ?>

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <!-- Resumo da vaga -->
    <div class="card" style="background:var(--azul-claro);border-color:var(--azul-medio)">
        <p style="font-size:12px;color:var(--azul);font-weight:700;margin-bottom:4px">CANDIDATANDO-SE PARA</p>
        <h3 style="color:var(--azul)"><?= htmlspecialchars($vaga->getTitulo()) ?></h3>
        <p><?= htmlspecialchars($vaga->getEmpresaNome()) ?> — Bolsa: <?= $vaga->getBolsaFormatada() ?></p>
    </div>

    <?php if (!$sucesso): ?>
    <!-- Confirmação -->
    <div class="card">
        <h2 style="margin-bottom:12px">Confirmar Candidatura</h2>
        <p style="margin-bottom:20px">
            Você está logado como <strong><?= htmlspecialchars($usuario['nome'] ?? '') ?></strong>
            (<?= htmlspecialchars($usuario['email'] ?? '') ?>).
            Ao confirmar, sua candidatura será enviada para a empresa.
        </p>

        <form method="POST">
            <button type="submit" class="btn btn-dourado" style="width:100%;padding:14px">
                Confirmar Candidatura
            </button>
        </form>
    </div>
    <?php endif; ?>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama<br>
    Av. Paraná, 7327 — Zona III — Umuarama/PR
</footer>

</body>
</html>