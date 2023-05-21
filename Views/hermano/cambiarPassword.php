<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL']?>styles/perfil.css">
</head>
<body>
    <section class="cabecera">
        <img src="<?= $_ENV['BASE_URL']?>rotulo.png" alt="imagen cabecera">
    </section>
    
    <p class="info">En este apartado podrás cambiar tu clave de acceso en el siguiente campo</p>
        <form action="<?= $_ENV['BASE_URL']?>hermano/cambiarPassword/<?=$id?>" method="POST" class="formContraseña">
            <label for="contraseña">Nueva contraseña</label>
            <input type="password" name="contraseña" required>
            <input type="submit" value="Enviar">
        </form>
</body>
</html>