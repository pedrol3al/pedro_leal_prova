
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel principal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>

    <?php include("menu.php"); ?>  

<br>

    <div>
        <h2>Bem vindo, <?php echo $_SESSION["usuario"]; ?>!<br>
        Perfil: <?php echo $nome_perfil; ?> </h2>
    </div>

    <div class="logout">
        <form action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    
        
    <address>Trabalho desenvolvido pelo aluno Pedro Gabriel | Técnico Dev Sistemas</address>
    </div>
</body>
</html>
