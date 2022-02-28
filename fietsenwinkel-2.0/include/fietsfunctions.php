<?php
function getFietsen()
{
    $conn = dBConnect();
    $query = "SELECT * FROM fietsen";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $fietsen = $stmt->fetchAll();
    return $fietsen;
}

function showFietsen()
{
    $fietsen = getFietsen();
    $overzichtFietsen = "";
?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Merk</th>
                <th scope="col">Type</th>
                <th scope="col">Prijs</th>
            </tr>
        </thead>
        <tbody>

        <?php
        foreach ($fietsen as $fiets) {

            $overzichtFietsen .= "<tr>" . "<td>" . $fiets['merk'] . "</td>" . "<td>" .  $fiets['type'] . "</td>" . "<td>" . $fiets['prijs'] . "</td>" . "</tr>";
        }
        return $overzichtFietsen;
    }
        ?>

        </tbody>
    </table>


    <ul class="list-group list-group-flush" style="width: 18rem;">
        <?php
        function showFiets($id)
        {
            $fiets = getFiets($id);
            $overzichtfiets = "<li class='list-group-item'>" . "Id: " . $fiets['id'] . "</li>";
            $overzichtfiets .= "<li class='list-group-item'>" . "Merk: " . $fiets['merk'] . "</li>";
            $overzichtfiets .= "<li class='list-group-item'>" . "Type: " . $fiets['type'] . "</li>";
            $overzichtfiets .= "<li class='list-group-item'>" . "Prijs: " . $fiets['prijs'] . "</li>";
            $overzichtfiets .= "<li class='list-group-item'>" . "Info: " . $fiets['info'] . "</li>";

            $overzichtfiets .= "<a href=index.php?page=adminfietsen><button type='button' class='btn btn-info mt-5'>terug naar admin menu</button></a>";
            return $overzichtfiets;
        }
        ?>
    </ul>

    <?php




    function getFiets($id)
    {
        $conn = dBConnect();
        $query = "SELECT * FROM fietsen WHERE id=$id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $fietsen = $stmt->fetchAll();
        foreach ($fietsen as $fiets) {
            return $fiets;
        }
    }



   



    function adminFietsen()
    {
        if (!checkRole(8)) {
            header('Refresh:2; url=index.php');
            return "<p class='text-center'>U heeft hier geen rechten voor!</p>";
        }
        if (checkRole(8)) {
            $fietsen = getFietsen();
            $overzichtFietsen = "";

    ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Merk</th>
                        <th scope="col">Type</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Wijzigen</th>
                    </tr>
                </thead>
                <tbody>

            <?php
            foreach ($fietsen as $fiets) {
                $id = $fiets['id'];
                $merk = $fiets['merk'];
                $type = $fiets['type'];
                $prijs = $fiets['prijs'];
                $overzichtFietsen .= "<tr>" . "<td>" . $merk . "</td>" . "<td>" . $type . "</td>" . "<td>" . $prijs . "</td>";
                $overzichtFietsen .= "<td>" . "<a class='text-decoration-none' href='index.php?page=showFiets&id=$id'>Show</a>" . " ";
                $overzichtFietsen .= "<a class='text-decoration-none' href='index.php?page=editFiets&id=$id'>Edit</a>" . " ";
                $overzichtFietsen .= "<a class='text-decoration-none' href='index.php?page=delFiets&id=$id'>Del</a>" . "</td>";
                $overzichtFietsen .= "</tr>";
            }
            $overzichtFietsen .= "<a href='index.php?page=addFiets'><button type='button' class='btn btn-info'>Fiets toevoegen</button></a>";
            return $overzichtFietsen;
        }
    }

            ?>

                </tbody>
            </table>
            <?php



            function addFiets()
            {
                if (!checkRole(8)) {
                    header('Refresh:2; url=index.php');
                    return "<p class='text-center'>U heeft hier geen rechten voor!</p>";
                }
                if (isset($_POST['toevoegen'])) {
                    $merk = check_input($_POST['merk']);
                    $type = check_input($_POST['type']);
                    $prijs = check_input($_POST['prijs']);
                    $info = check_input($_POST['info']);


                    $conn = dBConnect();
                    $stmt = $conn->prepare("INSERT INTO fietsen (merk, type, prijs, info) VALUES (:merk , :type, :prijs, :info)");
                    $stmt->bindParam(':merk', $merk);
                    $stmt->bindParam(':type', $type);
                    $stmt->bindParam(':prijs', $prijs);
                    $stmt->bindParam(':info', $info);

                    $stmt->execute();
                    echo "<p class='text-center'>Fiets toegevoegd</p>";
                    header('Refresh:2; url=index.php?page=adminfietsen');
                    $conn = NULL;
                } else {
                    if (isset($_POST['annuleren'])) {
                        echo "Geannuleerd";
                        header('Refresh:2; url=index.php?page=adminfietsen');
                    } else {
                        include("include/html/fiets/add.html");
                    }
                }
            }



            function editFiets($id)
            {
                if (!isset($_POST['wijzigen'])) {
                    $fiets = getFiets($id);
                    $id = $fiets['id'];
                    $merk = $fiets['merk'];
                    $type = $fiets['type'];
                    $prijs = $fiets['prijs'];
                    $info = $fiets['info'];
                    include("include/html/fiets/edit.html");
                } elseif (isset($_POST['annuleren'])) {
                    header('Refresh:2; url=index.php?page=adminfietsen');
                } else {
                    $merk = $_POST['merk'];
                    $type = $_POST['type'];
                    $prijs = $_POST['prijs'];
                    $info = $_POST['info'];
                    $conn = dBConnect();
                    $stmt = $conn->prepare("UPDATE fietsen SET merk='$merk', type='$type', prijs='$prijs', info='$info' WHERE id=$id");
                    $stmt->execute();
                    $conn = NULL;
                    echo "<p class='text-center'>Wijziging doorgevoerd</p>";
                    header('Refresh:2; url=index.php?page=adminfietsen');
                }
            }


            function delFiets($id)
            {
                if (!checkRole(8)) {
                    header('Refresh:2; url=index.php');
                    return "<p class='text-center'>U heeft hier geen rechten voor!</p>";
                }
                $conn = dBConnect();
                $sql = "DELETE FROM fietsen WHERE id=$id";
                $conn->exec($sql);

                echo "<p class='text-center'>Fiets vewijderd</p>";
                header('Refresh:2; url=index.php?page=adminfietsen');
            }
            ?>