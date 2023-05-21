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
    <?php if(isset($eventos)): ?>
        <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre del acto</th>
                        <th>Fecha</th>
                        <th>Acciones disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($eventos as $evento): ?>
                        <tr>
                                <td><?= $evento->nombre ?></td>
                                <td><?= $evento->fecha ?></td>
                                <td><form action="<?= $_ENV['BASE_URL']?>hermano/apuntarseEvento" method="POST">
                                        <input type="text" name="data[idevento]" value="<?= $evento->id ?>">
                                        <input type="text" name="data[idhermano]" value="<?= $_SESSION['identity']->id ?>">
                                        <input type="submit" value="Apuntarse">
                                    </form>
                                </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    <?php endif; ?>

    <?php if(isset($_SESSION['registrado'])): ?>
        <p class="sesionRegistrado"><?php echo $_SESSION['registrado'] ?></p>
    <?php endif; ?>
</body>
</html>