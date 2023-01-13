<?php
include '../Functions/main_functions.php';
include '../Assets/layout.php';

session_start();
$user = new User($mysqli);
$groepen = $user->read("gebruikers");
$zoekresultaat['Groep'] = '';

if (empty($_SESSION["Ingelogd"]) || $_SESSION['Rechten'] != 0) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter</title>
</head>

<body>
    <form action="filter.php" method="post" name="ReadTest">
        <input type="text" name="Read">
        <button type="submit" name="Search">Search</button>
        <?php
        if (isset($_POST['Search']) && !empty($_POST['Read'])) {
            $zoekresultaat = $user->filtersearch("gebruikers", "Groep", $_POST['Read']);
            if (count($zoekresultaat) === 0) {
                echo '<br /> Geen zoekresultaten <br />';
            } else {
                foreach ($zoekresultaat as $search) {
                    echo '<option value="' . $search['ID'] . '">' . $search['Voornaam'] . " " . $search['Achternaam'] . " " . $search['Groep'] .  '</option>';
                }
            }
        } else {
            foreach ($groepen as $users) {
                echo '<option value="' . $users['ID'] . '">' . $users['Voornaam'] . " " . $users['Achternaam'] . " " . $users['Groep'] .  '</option>';
            }
        }
        echo $_SESSION['Voornaam'];
        echo $_SESSION['ID'];
        var_dump($_SESSION['Voornaam']);
        // session_destroy();
        ?>
    </form>
</body>

</html>