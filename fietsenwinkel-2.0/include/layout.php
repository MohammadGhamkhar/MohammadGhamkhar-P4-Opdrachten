<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Fietswinkel</title>

    <!-- <link rel="stylesheet" href="style/style.css"> -->

    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
    <header><?= getHeader(); ?></header>


    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?= getNav(); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="">
        <!-- <aside class="asideLeft"><?= getAside('left'); ?></aside> -->

        <section><?= getSection(); ?></section>

        <!-- <aside class="asideRight"><?= getAside('Right'); ?></aside> -->
    </div>

    <footer><?= getFooter(); ?></footer>

</body>

</html>