<?php
require_once __DIR__ . '/../classes/ApiClient.php';
require_once __DIR__ . '/../classes/Vaga.php';

$api = new ApiClient();

// Exige login de empresa
if (!$api->isLoggedIn() || $api->getTipoLogado() !== 'empresa') {
    header('Location: ../login-empresa.php');
    exit;
}

// Pega o ID da vaga do parâmetro GET
$vagaId = isset($_GET['vaga_id']) ? (int)$_GET['vaga_id'] : 0;

if (!$vagaId) {
    header('Location: vagas.php');
    exit;
}

// Lida com a alteração de status (POST)
$msgSucesso = '';
$msgErro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidaturaId = isset($_POST['candidatura_id']) ? (int)$_POST['candidatura_id'] : 0;
    $status = $_POST['status'] ?? '';

    if ($candidaturaId && in_array($status, ['pendente', 'em_analise', 'aprovado', 'reprovado'])) {
        $resp = $api->put("/candidaturas/{$candidaturaId}/status", ['status' => $status]);

        if ($resp['success'] ?? false) {
            $msgSucesso = 'Status da candidatura atualizado com sucesso!';
        } else {
            $msgErro = $resp['message'] ?? 'Erro ao atualizar o status da candidatura.';
        }
    }
}

// Busca a vaga para exibir o título
$respVaga = $api->get("/vagas/{$vagaId}");
if (!($respVaga['success'] ?? false) || empty($respVaga['data'])) {
    header('Location: vagas.php');
    exit;
}
$vaga = Vaga::fromArray($respVaga['data']);

// Busca os candidatos da vaga na API
$respCandidaturas = $api->get("/candidaturas/vaga/{$vagaId}");
$candidaturas = $respCandidaturas['data'] ?? [];

$usuario = $api->getUsuarioLogado();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos — Painel Empresa</title>
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

    <div style="margin-bottom:16px">
        <a href="vagas.php" style="color:var(--azul-medio);font-size:14px;text-decoration:none">← Voltar para as vagas</a>
    </div>

    <h2 style="margin-bottom:20px;">
        Candidatos da Vaga: <strong><?= htmlspecialchars($vaga->getTitulo()) ?></strong>
    </h2>

    <?php if ($msgSucesso): ?>
        <div class="alerta alerta-sucesso"><?= htmlspecialchars($msgSucesso) ?></div>
    <?php endif; ?>

    <?php if ($msgErro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($msgErro) ?></div>
    <?php endif; ?>

    <?php if (empty($candidaturas)): ?>
        <div class="card" style="text-align:center;padding:40px">
            <p style="margin-bottom:16px">Nenhum candidato se candidatou a esta vaga ainda.</p>
        </div>
    <?php else: ?>

        <?php foreach($candidaturas as $candidatura): ?>
            <div class="card" style="margin-bottom:16px">

                <h3><?= htmlspecialchars($candidatura['aluno']['nome'] ?? ''); ?></h3>

                <p>
                    <strong>Email:</strong>
                    <?= htmlspecialchars($candidatura['aluno']['email'] ?? ''); ?>
                </p>

                <?php if (!empty($candidatura['aluno']['curso'])): ?>
                    <p>
                        <strong>Curso:</strong>
                        <?= htmlspecialchars($candidatura['aluno']['curso'] ?? ''); ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($candidatura['aluno']['ra'])): ?>
                    <p>
                        <strong>RA:</strong>
                        <?= htmlspecialchars($candidatura['aluno']['ra'] ?? ''); ?>
                    </p>
                <?php endif; ?>

                <p>
                    <strong>Status da Candidatura:</strong>
                    <?php
                    $status = $candidatura['status'] ?? 'pendente';
                    $statusFormatado = [
                        'pendente' => 'Pendente',
                        'em_analise' => 'Em Análise',
                        'aprovado' => 'Aprovado',
                        'reprovado' => 'Reprovado'
                    ][$status] ?? 'Pendente';

                    $classeBadge = [
                        'pendente' => '',
                        'em_analise' => 'badge-alerta',
                        'aprovado' => 'badge-sucesso',
                        'reprovado' => 'badge-erro'
                    ][$status] ?? '';
                    ?>
                    <span class="badge <?= $classeBadge ?>"><?= $statusFormatado ?></span>
                </p>

                <p style="font-size:12px;color:#64748b;margin-top:8px">
                    Candidatura enviada em: <?= date('d/m/Y H:i', strtotime($candidatura['dataCandidatura'] ?? date('Y-m-d H:i:s'))) ?>
                </p>

                <div style="margin-top:16px;display:flex;gap:8px;flex-wrap:wrap">
                    <form method="POST" style="margin:0">
                        <input type="hidden" name="candidatura_id" value="<?= $candidatura['id'] ?>">
                        <input type="hidden" name="status" value="em_analise">
                        <button type="submit" class="btn btn-outline btn-sm">Marcar como Em Análise</button>
                    </form>
                    <form method="POST" style="margin:0">
                        <input type="hidden" name="candidatura_id" value="<?= $candidatura['id'] ?>">
                        <input type="hidden" name="status" value="aprovado">
                        <button type="submit" class="btn btn-sm" style="background-color:var(--verde);border-color:var(--verde)">Aprovar Candidato</button>
                    </form>
                    <form method="POST" style="margin:0">
                        <input type="hidden" name="candidatura_id" value="<?= $candidatura['id'] ?>">
                        <input type="hidden" name="status" value="reprovado">
                        <button type="submit" class="btn btn-sm" style="background-color:var(--vermelho);border-color:var(--vermelho)">Reprovar Candidato</button>
                    </form>
                    <form method="POST" style="margin:0">
                        <input type="hidden" name="candidatura_id" value="<?= $candidatura['id'] ?>">
                        <input type="hidden" name="status" value="pendente">
                        <button type="submit" class="btn btn-sm" style="opacity:0.7">Voltar para Pendente</button>
                    </form>
                </div>

            </div>
        <?php endforeach; ?>

    <?php endif; ?>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama<br>
    Av. Paraná, 7327 — Zona III — Umuarama/PR
</footer>

</body>
</html>
