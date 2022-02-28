<?php

function logout()
{
    unset($_SESSION['username']);
    // unset($_SESSION['role']);
    echo "<p class='text-center'>U bent uitgelogd</p>";
    session_destroy();
    header('Refresh:1; url=index.php?page=inloggen');
}




if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
    $_SESSION['username'] = "";
    $_SESSION['role'] = 0;
}

function login()
{
    if (isset($_POST['inloggen'])) {
        $username = check_input($_POST['username']);
        $password = check_input($_POST['password']);
        if (checkUserPassword($username, $password)) {
            echo "<p class='text-center'>U bent ingelogd</p>";
            header('Refresh:2; url=index.php');
        } else {
            echo "<p class='text-center'>Er is iets fout gegaan tijdens het inloggen</p>";
            header('Refresh:2; url=index.php?page=inloggen');
        }
    } else {
        include("include/html/user/login.html");
    }
}


function getuser()
{
    $conn = dBConnect();
    $query = "SELECT * FROM gebruikers";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $users = $stmt->fetchAll();
    return $users;
}



function getusers($id)
{
    $conn = dBConnect();
    $query = "SELECT * FROM gebruikers WHERE id=$id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $users = $stmt->fetchAll();
    foreach ($users as $user) {
        return $user;
    }
}

function adminuser()
{
    if (!checkRole(9)) {
        header('Refresh:2; url=index.php');
        return "<p class='text-center'>U heeft hier geen rechten voor!</p>";
    }
    if (checkRole(9)) {
        $users = getuser();
        $overzichtUser = "";

?>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>

        <?php
        foreach ($users as $user) {
            $id = $user['id'];
            $username = $user['username'];
            $password = $user['password'];
            $role = $user['role'];
            $overzichtUser .= "<tr>" . "<td>" . $username . "</td>" . "<td>" . $password . "</td>" . "<td>" . $role . "</td>";
            $overzichtUser .= "<td><a class='text-decoration-none' href='index.php?page=edituser&id=$id'>Edit</a>" . " ";
            $overzichtUser .= "<a class='text-decoration-none' href='index.php?page=deluser&id=$id'>Del</a>" . "</td>";
            $overzichtUser .= "</tr>";
        }

        return $overzichtUser;
    }
}


function edituser($id)
{
    if (!isset($_POST['wijzigen'])) {
        $users = getusers($id);
        $id = $users['id'];
        $username = $users['username'];
        $password = $users['password'];
        $role = $users['role'];
        include("include/html/user/edituser.html");
    } elseif (isset($_POST['annuleren'])) {
        header('Refresh:2; url=index.php?page=adminusers');
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $conn = dBConnect();
        $stmt = $conn->prepare("UPDATE gebruikers SET username='$username', password='$password', role='$role' WHERE id=$id");
        $stmt->execute();
        $conn = NULL;
        echo "<p class='text-center'>Wijziging doorgevoerd</p>";
        header('Refresh:2; url=index.php?page=adminusers');
    }
}


function deluser($id)
{
    if (!checkRole(8)) {
        header('Refresh:2; url=index.php');
        return "<p class='text-center'>U heeft hier geen rechten voor!</p>";
    }
    $conn = dBConnect();
    $sql = "DELETE FROM gebruikers WHERE id=$id";
    $conn->exec($sql);

    echo "<p class='text-center'>User vewijderd</p>";
    header('Refresh:2; url=index.php?page=adminusers');
}
        ?>