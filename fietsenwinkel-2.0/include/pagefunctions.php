<?php

function getHeader()
{
    return "Fietsenwinkel 2.0";
}


    function getNav()
    {
        $menu = "<li class='nav-item'><a class='nav-link' href='index.php'>Home</a></li>";
        if (checkRole(1)) {
            $menu .= "<li class='-item'><a class='nav-link' href='index.php?page=fietsen'>Fietsen</a></li>";
        }
        if (checkRole(2)) {
            $menu .= "<li class='nav-item'><a class='nav-link' href='index.php?page=bestellen'>Bestellen</a></li>";
        }
        if (checkRole(8)) {
            $menu .= "<li class='nav-item'><a class='nav-link' href='index.php?page=adminfietsen'>Admin fietsen</a></li>";
        }
        if (checkRole(9)) {
            $menu .= "<li class='nav-item'><a class='nav-link' href='index.php?page=adminusers'>Admin gebruikers</a></li>";
        }
        if (!$_SESSION['login']) {
            $menu .= "<li class='nav-item'><a class='nav-link' href='index.php?page=inloggen'>Inloggen</a></li>";
        } else {
            $menu .= "<li class='nav-item'><a class='nav-link' href='index.php?page=uitloggen'>Uitloggen</a></li>";
        }
        return $menu;
    }
    



function getAside()
{
    return "Aside tekst";
}







function getPage()
{
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "home";
    }
    return $page;
}





function getSection()
{
    $page = getPage();
    $section = "";
    switch ($page) {
        case "home":
            $section = "<h2 class='text-center'>Dit is de inhoud van de home pagina</h2>
        <br><h4 class='text-center'>Welkom</h4>";
            break;
        case "fietsen":
            $section = showFietsen();
            break;
        case "adminfietsen":
            $section = adminFietsen();
            break;
        case "adminusers":
            $section = adminuser();
            break;
        case "showFiets":
            $id = $_GET['id'];
            $section = showFiets($id);
            break;
        case "edituser":
            $id = $_GET['id'];
            $section = edituser($id);
            break;
        case "edituser":
            $id = $_GET['id'];
            $section = edituser($id);
            break;
        case "editFiets":
            $id = $_GET['id'];
            $section = editFiets($id);
            break;
        case "delFiets":
            $id = $_GET['id'];
            $section = delFiets($id);
            break;
        case "addFiets":
            $section = addFiets();
            break;
        case "inloggen":
            $section = login();
            break;
        case "registreren":
            $section = register();
            break;
        case "uitloggen":
            $section = logout();
            break;
        case "bestellen":
            include("include/html/bestellen.html");
            break;
        case "test":
            include("include/html/test.html");
            break;
        default:
            $section = "<p class='text-center'>Deze pagina bestaat (nog) niet</p>";
    }
    return $section;
}

function getFooter()
{
    return "<h6 class='text-center mt-5'>Copyright 2022 - Mohammad</h6>";
}
?>