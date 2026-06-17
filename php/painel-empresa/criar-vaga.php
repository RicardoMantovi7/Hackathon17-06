<?php
require_once __DIR__ . '/../classes/ApiClient.php';
require_once __DIR__ . '/../classes/Vaga.php';

$api = new ApiClient();

// Exige login de empresa
if (!$api->isLoggedIn() || $api->getTipoLogado() !== 'empresa') {
    header('Location: ../login-empresa.php');
    exit;
}

$msgErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => $_POST['titulo'] ?? '',
        'descricao' => $_POST['descricao'] ?? '',
        'requisitos' => $_POST['requisitos'] ?? '',
    ];

    if (!empty($_POST['valorBolsa'])) {
        $dados['valorBolsa'] = (float) str_replace(',', '.', $_POST['valorBolsa']);
    }

    $resp = $api->post('/vagas', $dados);

    if ($resp['success'] ?? false) {
        header('Location: vagas.php?msg=criada');
        exit;
    } else {
        $msgErro = $resp['message'] ?? 'Erro ao criar vaga';
    }
}

$usuario = $api->getUsuarioLogado();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Vaga — Painel Empresa</title>
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
    <a href="vagas.php">Minhas Vagas</a>
    <a href="criar-vaga.php" class="ativo">Nova Vaga</a>
</nav>

<div class="container">

    <div class="card">

        <h2>Cadastrar Nova Vaga</h2>

        <?php if ($msgErro): ?>
            <div class="alerta alerta-erro"><?= htmlspecialchars($msgErro) ?></div>
        <?php endif; ?>

        <form method="POST">

            <label>Título da Vaga *</label>
            <input type="text" name="titulo" class="campo" required>

            <label>Valor da Bolsa (opcional)</label>
            <input type="text" name="valorBolsa" class="campo" placeholder="Ex: 800,00">

            <label>Descrição *</label>
            <textarea name="descricao" class="campo" rows="5" required></textarea>

            <label>Requisitos (opcional)</label>
            <textarea name="requisitos" class="campo" rows="5"></textarea>

            <br>

            <button class="btn">
                Publicar Vaga
            </button>

        </form>

    </div>

</div>

</body>
</html>
