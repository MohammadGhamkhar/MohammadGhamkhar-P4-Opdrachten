<?php 

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function checkUserPassword($username, $password){
    if (($username <> "") && ($password <> "")) {
        $conn=dBConnect();
        $sql = "SELECT * from gebruikers WHERE username='$username'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $users = $stmt->fetchAll();
        foreach($users as $user) {
            $passwordHash=$user['password'];
            if (password_verify($password, $passwordHash)) {
                $_SESSION['login']=true;
                $_SESSION['username']=$user['username'];
                $_SESSION['role']=$user['role'];
                return true;
            } else {
                return false;
            }
        }
        $conn=NULL;
    } else {
        return false;
    }
}


function register() {
    if(isset($_POST['register'])) {
        $username = check_input($_POST['username']);
        if (checkUser($username)){
            echo "Gebruikers bestaat al";
            header('Refresh:5; url=index.php?page=registreren');
        }else {
            $conn=dBConnect();
            $stmt = $conn->prepare("INSERT INTO gebruikers (username, password, role) VALUES (:username, :password, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':role', $role);

            $username = check_input($_POST['username']);
            $password = check_input($_POST['password']);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $role = 1;

            $stmt->execute();
            echo "Gebruikers aangemaakt";
            header('Refresh:2; url=index.php?page=inloggen');
            $conn=NULL;
        }
    }else {
        include("include/html/user/register.html");
    }
}



function checkUser($username)
{
    if ($username <> "") {
        $conn = dBConnect();
        $sql = "SELECT * FROM gebruikers WHERE username='$username'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $users = $stmt->fetchAll();
        foreach ($users as $user) {
            if ($username == $user['username']) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

function checkRole($role) {


    if ($_SESSION['role'] >= $role){
        return true;
    } else {
        return false;
    }
}



?>
