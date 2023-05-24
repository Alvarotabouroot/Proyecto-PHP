<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=$_ENV['BASE_URL']?>styles/style.css">
</head>
<body>
    <section class="main">
        <article class="formulario">
            <img src="<?= $_ENV['BASE_URL']?>rotulo.png" alt="Imagen pagina principal" class="rotulo">
            <form action="<?= $_ENV['BASE_URL'] ?>hermano/login" method="POST">
                <fieldset>
                    <legend>ACCESO AL SERVICIO</legend>
                    <input type="text" name="data[email]" placeholder="Email">
                    <br>
                    <input type="password" name="data[password]" placeholder="Contraseña">
                    <br>
                    <input type="submit" value="Loguearse">
                    <button><a href="<?= $_ENV['BASE_URL']?>users/login">Acceso admin</a></button>
                </fieldset>
            </form>
            <?php if(isset($errores['email'])): ?>
                <span class="errores"><?= $errores['email'] ?></span>
            <?php endif; ?>
            <?php if(isset($errores['password'])): ?>
                <span class="errores"><?= $errores['password'] ?></span>
            <?php endif; ?>

            <a href="<?= $_ENV['BASE_URL']?>users/registrar" class="primerRegistro">[Primer registro administrador]</a>
        </article>
        <article class="imagen">
            <img src="<?= $_ENV['BASE_URL']?>niño.jpg" alt="Imagen pagina principal" class="fotogrande">
        </article>
    </section>
    
</body>
</html>





