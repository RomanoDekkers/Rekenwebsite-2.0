<?php
include '../Functions/main_functions.php';
include '../Assets/layout.php';

session_start();
$gebruiker =  new user($mysqli);

if (isset($_POST['Login'])) {
    $voornaam = $_POST['Voornaam'];
    $wachtwoord = $_POST['Wachtwoord'];

    if ($gebruiker->login($voornaam, $wachtwoord)) {
        $_SESSION['Voornaam'] = $_POST['Voornaam'];
        echo "<script type='text/javascript'> window.location.href='filter.php'</script>";
    } else {
        echo "Er ging iets fout!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <form name="Registreren" style="margin: auto; width: 400px;" method="POST" action="login.php" autocomplete="off">
            <div class="mb-3">
                <label for="VoorbeeldVoornaam1" class="form-label">Voornaam</label>
                <input type="Text" name="Voornaam" class="form-control" aria-describedby="VoornaamHelp" required>
            </div>
            <div class="mb-3">
                <label for="VoorbeelWachtwoord1" class="form-label">Wachtwoord</label>
                <input type="Text" name="Wachtwoord" class="form-control" aria-describedby="WachtwoordHelp" required>
            </div>
            <button type="submit" name="Login" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>