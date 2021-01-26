<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Two Numbers</title>
        <link rel="stylesheet" href="./bootstrap.min.css">
    </head>
    <body>
        <div class="container">
        <h1>Add Two Numbers</h1>
        <form action="sum.php" method="POST">
            <div class="form-group">
                <label>First Number</label>
                <input type="number" step="any" name="firstNumber" class="form-control">
            </div>
            <div class="form-group">
                <label>Second Number</label>
                <input type="number" step="any" name="secondNumber" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    </body>
</html>