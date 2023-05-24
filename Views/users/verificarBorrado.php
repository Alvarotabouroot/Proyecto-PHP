<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>¿Está usted seguro de que desea dar de baja al hermano <?= $hermano->nombre.' '.$hermano->apellidos ?>?</h2>
    <form action="<?= $_ENV['BASE_URL']?>users/borrarHermano/<?= $hermano->id ?>">
        <input type="submit" value="Estoy seguro">
    </form>
    <form action="<?= $_ENV['BASE_URL']?>users/home">
        <input type="submit" value="Quiero volver atras">
    </form>
</body>
</html>