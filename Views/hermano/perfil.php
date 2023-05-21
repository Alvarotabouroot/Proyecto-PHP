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
    <section class="menu">
        <ul>
            <li><a href="<?= $_ENV['BASE_URL']?>hermano/mostrarEventos">Eventos</a></li>
            <li><a href="<?= $_ENV['BASE_URL']?>hermano/logout">Salir</a></li>
        </ul>
    </section>

    <p class="info">En este apartado podrás ver todos tus datos. Además podrás cambiar tu contraseña y editar tus datos (Si la contraseña es la proporcionada por la hermandad te recomendamos cambiarla para mayor seguridad)</p>
    <section class="botones">
        <button><a href="<?= $_ENV['BASE_URL']?>hermano/cambiarPassword/<?= $hermano->id?>">Cambiar mi contraseña</a></button>   
        <button><a href="<?= $_ENV['BASE_URL']?>hermano/editarDatos/<?= $hermano->id?>">Editar mis datos</a></button>
        <button><a href="<?= $_ENV['BASE_URL']?>hermano/misEventos/<?= $hermano->id?>">Ver mis eventos</a></button>
    </section>

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
</body>
</html>