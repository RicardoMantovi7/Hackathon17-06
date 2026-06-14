<?php
require_once __DIR__ . '/classes/ApiClient.php';

$api  = new ApiClient();
$erro = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome'   => trim($_POST['nome']   ?? ''),
        'cnpj'   => trim($_POST['cnpj']   ?? ''),
        'email'  => trim($_POST['email']  ?? ''),
        'senha'  => trim($_POST['senha']  ?? ''),
        'cidade' => trim($_POST['cidade'] ?? ''),
    ];

    if (empty($dados['nome']) || strlen($dados['cnpj']) < 14 || empty($dados['email']) || strlen($dados['senha']) < 6) {
        $erro = 'Preencha todos os campos. CNPJ deve ter 14 dígitos e senha mínimo 6 caracteres.';
    } else {
        $result = $api->register('empresa', $dados);
        if ($result['success'] ?? false) {
            $sucesso = true;
        } else {
            $erro = $result['message'] ?? 'Erro ao cadastrar. Verifique os dados.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa — Portal UniALFA</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="header-logo">
        <div class="logo-badge">α</div>
        <span>Portal de Estágios<small>UniALFA — Umuarama</small></span>
    </a>
</header>

<div class="container" style="max-width:480px">

    <?php if ($sucesso): ?>
        <div class="alerta alerta-sucesso">
            Cadastro realizado com sucesso! <a href="login-empresa.php">Clique aqui para entrar</a>.
        </div>
    <?php endif; ?>

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (!$sucesso): ?>
    <div class="card">
        <h2 style="margin-bottom:20px;text-align:center">Cadastro de Empresa</h2>

        <form method="POST">
            <div class="form-group">
                <label>Nome da Empresa</label>
                <input type="text" name="nome" class="campo" required
                       value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>CNPJ (somente números)</label>
                <input type="text" name="cnpj" class="campo" required
                       placeholder="14 dígitos" maxlength="14"
                       value="<?= htmlspecialchars($_POST['cnpj'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Cidade</label>
                <input type="text" name="cidade" class="campo"
                       placeholder="Ex: Umuarama"
                       value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="campo" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Senha (mínimo 6 caracteres)</label>
                <input type="password" name="senha" class="campo" required minlength="6">
            </div>

            <button type="submit" class="btn btn-dourado" style="width:100%;padding:14px">Cadastrar Empresa</button>
        </form>

        <p style="text-align:center;margin-top:16px;font-size:14px">
            Já tem conta? <a href="login-empresa.php" style="color:var(--azul-medio)">Faça login</a>
        </p>
    </div>
    <?php endif; ?>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama
</footer>

</body>
</html>