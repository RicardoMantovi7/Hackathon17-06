<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Vaga</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>Painel da Empresa - UniALFA</h1>
</header>
<nav class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="vagas.php">Minhas Vagas</a>
    <a href="criar-vaga.php">Nova Vaga</a>
</nav>
<div class="container">

    <div class="card">

        <h2>Cadastrar Nova Vaga</h2>

        <form>

            <label>Título da Vaga</label>
            <input type="text" class="campo">

            <label>Local</label>
            <input type="text" class="campo">

            <label>Bolsa Auxílio</label>
            <input type="text" class="campo">

            <label>Descrição</label>
            <textarea class="campo" rows="5"></textarea>

            <label>Requisitos</label>
            <textarea class="campo" rows="5"></textarea>

            <br><br>

            <button class="btn">
                Publicar Vaga
            </button>

        </form>

    </div>

</div>

</body>
</html>