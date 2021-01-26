<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Two Numbers</title>
        <link rel="stylesheet" href="./bootstrap.min.css">
    </head>
    <body>
        <div class="container-fluid">
        <h1>Result: 
            <?php
                function sum($x, $y) {
                    $z = $x + $y;
                    return $z;
                }
                $firstNumber = $_POST['firstNumber'];
                $secondNumber = $_POST['secondNumber'];
                echo sum($firstNumber, $secondNumber);
            ?>
        </h1>
    </body>
</html>
