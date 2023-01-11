<?php
require '../Connection/conn.php';

class User
{
    private $mysqli;
    public $query;

    // Constructor
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function create($Voornaam, $Achternaam, $Groep, $Wachtwoord, $Rechten)
    {
        // Insert the new item into the database
        $stmt = $this->mysqli->prepare("INSERT INTO gebruikers (Voornaam, Achternaam, Groep, Wachtwoord, Rechten) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $Voornaam, $Achternaam, $Groep, $Wachtwoord, $Rechten);
        $stmt->execute();
        $stmt->close();
    }

    public function read($datatable)
    {
        // Select all data from the users table
        $stmt = $this->mysqli->prepare("SELECT * FROM " . $datatable);
        $stmt->execute();
        $result = $stmt->get_result(); // Bind the result to a new variable
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an associative array
        $stmt->close(); // Close the statement
        return $data; // Return the data
    }

    public function filtersearch($datatable, $datarow, $search)
    {
        // Select all data from the users table
        $stmt = $this->mysqli->prepare("SELECT * FROM " . $datatable . " where " . $datarow . " = ?");
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result(); // Bind the result to a new variable
        $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an associative array
        $stmt->close(); // Close the statement
        return $data; // Return the data
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function login($Voornaam, $Wachtwoord)
    {
        // Check the database to see if there is a user with the given username and password
        $stmt = $this->mysqli->prepare("SELECT COUNT(*) as user_count FROM gebruikers WHERE Voornaam = ? AND Wachtwoord = ?");
        $stmt->bind_param("si", $Voornaam, $Wachtwoord);
        $stmt->execute();
        $result = $stmt->get_result(); // Bind the result to a new variable
        $user = $result->fetch_assoc(); // Fetch the first row as an associative array
        $stmt->close(); // Close the statement

        // If the user was found, return true
        if ($user['user_count'] > 0) {
            return true;
        }

        // If the user was not found, return false
        return false;
    }
}
