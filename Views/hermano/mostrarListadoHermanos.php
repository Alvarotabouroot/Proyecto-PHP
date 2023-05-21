<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL']?>styles/tabla.css">
</head>
<body>
    <section class="content">
        <?php if(isset($hermanos)): ?>
            
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($hermanos as $hermano): ?>
                        
                        <tr>
                                <td><?= $hermano->nombre ?></td>
                                <td><?= $hermano->apellidos ?></td>
                                <td><?= $hermano->email ?></td>
                                <td><a href="<?= $_ENV['BASE_URL']?>users/editarDatosHermano/<?= $hermano->id?>">Editar</a> <a href="<?= $_ENV['BASE_URL']?>users/borrarHermano/<?= $hermano->id?>">Dar de baja</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <button><a href="<?= $_ENV['BASE_URL'] ?>users/home">Pincha para volver a la pagina de inicio</a></button>
    </section>
    
</body>
</html>