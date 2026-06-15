<?php
require_once __DIR__ . '/classes/ApiClient.php';

$api  = new ApiClient();
$erro = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'ra'    => trim($_POST['ra']    ?? ''),
        'nome'  => trim($_POST['nome']  ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'senha' => trim($_POST['senha'] ?? ''),
        'curso' => trim($_POST['curso'] ?? ''),
    ];

    if (empty($dados['ra']) || empty($dados['nome']) || empty($dados['email']) || strlen($dados['senha']) < 6) {
        $erro = 'Preencha todos os campos. A senha deve ter no mínimo 6 caracteres.';
    } else {
        $result = $api->register('aluno', $dados);
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
    <title>Cadastro de Aluno — Portal UniALFA</title>
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
            Cadastro realizado com sucesso! <a href="login-aluno.php">Clique aqui para entrar</a>.
        </div>
    <?php endif; ?>

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (!$sucesso): ?>
    <div class="card">
        <h2 style="margin-bottom:20px;text-align:center">Cadastro de Aluno</h2>

        <form method="POST">
            <div class="form-group">
                <label>RA (Registro Acadêmico)</label>
                <input type="text" name="ra" class="campo" required
                       placeholder="Ex: 260266"
                       value="<?= htmlspecialchars($_POST['ra'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="nome" class="campo" required
                       value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Curso</label>
                <input type="text" name="curso" class="campo"
                       placeholder="Ex: Sistemas de Informação"
                       value="<?= htmlspecialchars($_POST['curso'] ?? '') ?>">
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

            <button type="submit" class="btn btn-dourado" style="width:100%;padding:14px">Cadastrar</button>
        </form>

        <p style="text-align:center;margin-top:16px;font-size:14px">
            Já tem conta? <a href="login-aluno.php" style="color:var(--azul-medio)">Faça login</a>
        </p>
    </div>
    <?php endif; ?>

</div>

<footer>
    <strong>Portal de Estágios UniALFA</strong> — Faculdade Alfa Umuarama
</footer>

</body>
</html>