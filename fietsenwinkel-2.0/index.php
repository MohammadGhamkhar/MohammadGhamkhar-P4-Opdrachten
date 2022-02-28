<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body style="background-color: #d0d0d0;">
    <div class="container-sm shadow-sm p-3 mb-5 bg-body rounded ">


        <?php
        session_start();


        require_once("include/dbfunctions.php");
        require_once("include/formfunctions.php");
        require_once("include/pagefunctions.php");
        require_once("include/userfunctions.php");
        require_once("include/fietsfunctions.php");


        require("include/layout.php");
        ?>
    </div>
</body>

</html>