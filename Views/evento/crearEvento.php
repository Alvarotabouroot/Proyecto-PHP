<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?= $_ENV['BASE_URL']?>users/crearEvento" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]">
        <label for="fecha">Fecha</label>
        <input type="text" name="data[fecha]" placeholder="00/00/0000">
        <input type="submit" value="Registrar evento">
    </form>
</body>
</html>