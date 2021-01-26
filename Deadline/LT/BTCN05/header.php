<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">BTCN05</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php echo $title == 'Home' ? 'active' : ''; ?>">
                        <a class="nav-link"
                            href="index.php">Home<?php echo $title == 'Home' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <?php if ($currentUser): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item <?php echo $title == 'Login' ? 'active' : ''; ?>">
                        <a class="nav-link"
                            href="login.php">Login<?php echo $title == 'Login' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <li class="nav-item <?php echo $title == 'Registrer' ? 'active' : ''; ?>">
                        <a class="nav-link"
                            href="registrer.php">Registrer<?php echo $title == 'Registrer' ? '<span class="sr-only">(current)</span>' : ''; ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <h1><?php echo $title?></h1>