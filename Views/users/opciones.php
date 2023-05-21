<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL']?>styles/opciones.css">
</head>
<body>
    <h1>Bienvenido al sistema</h1>

    <section class="formularios">
        <article class="formulariohermano">
            <h2>Registro nuevo hermano</h2>
            <form action="<?=$_ENV['BASE_URL']?>users/registrarHermano" method="POST" class="registroHermano">
                <label for="nombre">Nombre</label>
                <input type="text" name="data[nombre]">

                <label for="apellidos">Apellidos</label>
                <input type="text" name="data[apellidos]">

                <label for="email">Email</label>
                <input type="email" name="data[email]">
                <br>
                <input type="submit" value="Registrar hermano">
            </form>
        </article>
        <article class="formularioAdmi">
            <h2>Registro nuevo administrador</h2>
            <form action="<?=$_ENV['BASE_URL']?>users/registrar" method="POST" class="registroAdmi">
                <label for="nombre">Nombre</label>
                <input type="text" name="data[nombre]">
                
                <label for="email">Email</label>
                <input type="email" name="data[email]">
                
                <label for="password">Contraseña</label>
                <input type="password" name="data[password]">
                <br>
                <input type="submit" value="Registrar Usuario">
            </form>
        </article>
    </section>
    <br><br>
    <section class="opciones">
        <li><a href="<?= $_ENV['BASE_URL']?>users/mostrarTodosHermanos">Mostrar listado hermanos</a></li>
        <form action="<?=$_ENV['BASE_URL']?>users/mostrarHermano" method="POST">
            <input type="text" name="apellidos" placeholder="Apellidos">
            <input type="submit" value="Buscar">
        </form>
        <li><a href="<?= $_ENV['BASE_URL']?>users/crearEvento">Crear un evento</a></li>
        <li><a href="<?= $_ENV['BASE_URL']?>users/mostrarEventos">Mostrar listado de eventos</a></li>
    </section>
    <?php if(isset($_SESSION['admin'])): ?>
        <a href="<?= $_ENV['BASE_URL'] ?>users/logout" class="logout"><img src="<?= $_ENV['BASE_URL'] ?>salida.png" alt="emoticono"></a>
    <?php endif; ?>
</body>
</html>