<?php
require_once __DIR__ . '/classes/ApiClient.php';

$api  = new ApiClient();
$erro = '';

if ($api->isLoggedIn() && $api->getTipoLogado() === 'empresa') {
    header('Location: painel-empresa/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $result = $api->login('empresa', $email, $senha);
        if ($result['success'] ?? false) {
            header('Location: painel-empresa/dashboard.php');
            exit;
        }
        $erro = $result['message'] ?? 'E-mail ou senha incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login da Empresa — Portal UniALFA</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
</header>

<div class="container" style="max-width:440px">

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2 style="margin-bottom:20px;text-align:center">Login da Empresa</h2>

        <form method="POST">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="campo" required
                       placeholder="empresa@email.com"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" class="campo" required
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-dourado" style="width:100%;padding:14px">Entrar</button>
        </form>

        <p style="text-align:center;margin-top:16px;font-size:14px">
            Não tem conta? <a href="cadastro-empresa.php" style="color:var(--azul-medio)">Cadastre sua empresa</a>
        </p>
        <p style="text-align:center;margin-top:8px;font-size:13px">
            <a href="login-aluno.php" style="color:var(--texto-suave)">Sou aluno →</a>
        </p>
    </div>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama
</footer>

</body>
</html>