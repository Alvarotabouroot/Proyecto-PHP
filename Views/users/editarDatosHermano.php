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
    
    <p class="info">En este apartado podrás cambiar los datos en los siguientes campos</p>
    <form action="<?= $_ENV['BASE_URL']?>users/editarDatosHermano/<?= $hermano->id ?>" method="POST" class="formEditar">
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]" value="<?= $hermano->nombre?>">
        <label for="apellidos">Apellidos</label>
        <input type="text" name="data[apellidos]" value="<?= $hermano->apellidos?>">
        <label for="email">Email</label>
        <input type="text" name="data[email]" value="<?= $hermano->email?>">
        <input type="submit" value="Actualizar datos">
    </form>
</body>
</html>