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
    <?php if(isset($hermanos)): ?>
            <?php foreach($hermanos as $hermano): ?>
                <section class="datosHermano">
                    <h3>DATOS PERSONALES</h3>
                    <section class="datos">
                        <?php if(isset($hermano)):?>
                            <p><b>Nombre:</b> <?= $hermano->nombre ?></p>
                            <p><b>Apellidos:</b> <?= $hermano->apellidos ?></p>
                            <p><b>Email:</b> <?= $hermano->email ?></p>
                        <?php endif; ?>
                    </section>
                </section>
            <?php endforeach; ?>
    <?php endif; ?>

    <button class="volverAtras"><a href="<?= $_ENV['BASE_URL'] ?>users/home">Pincha para volver a la pagina de inicio</a></button>
</body>
</html>