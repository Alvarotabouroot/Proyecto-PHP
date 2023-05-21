<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(isset($eventos)): ?>
        <?php foreach($eventos as $evento): ?>
            
            <ul><?= $evento[0]->nombre ?> <?= $evento[0]->fecha ?></ul>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="<?= $_ENV['BASE_URL']?>hermano/misEventos/<?= $_SESSION['identity']->id?>" method="POST">
            <input type="submit" value="Volver atras">
    </form>
</body>
</html>