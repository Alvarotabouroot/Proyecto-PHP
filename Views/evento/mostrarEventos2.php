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
        <table>
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
                                <td><a href="<?= $_ENV['BASE_URL']?>users/listado/<?= $evento->id?>">Sacar listado participantes</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    <?php endif; ?>
</body>
</html>