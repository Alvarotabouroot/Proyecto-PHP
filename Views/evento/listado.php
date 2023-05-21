<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Listado de participantes del evento</h2>
    <?php if(isset($listado)): ?>
        <?php foreach ($listado as $hermano): ?>
            <ul>
                <li><?= $hermano->nombre ?> <?= $hermano->apellidos ?></li>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="<?= $_ENV['BASE_URL']?>users/home">Volver al inicio</a>
</body>
</html>