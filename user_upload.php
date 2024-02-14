<?php

/* Install Documentation 

- Script relies on mysqli to interact with the MySQL database

*/

// 1. parse command line arguments - ensure for proper usage & check CSV file is valid
// Directives: 
// create_table: create users table in MySQL - table needs to contain name, surname and email address (unique index)
// dry_run: run the script but don't INSERT into the db - all other functions executed
// u: configure MySQL username
// p: configure MySQL password
// h: configure MySQL host
// help: list of directives with details

$options = getopt("f:u:p:h:", ["file:", "create_table", "dry_run", "help"]);

// now must check if help option was supplied
if (isset($options['help']) || empty($options)) {
    echo "Usage: php user_upload.php [options]\n";
    echo "Options: \n";
    echo "--file [csv file name] : Name of CSV to be parsed\n";
    echo "--create table : build MySQL users table and exit\n";
    echo "--dry_run : Run script without executing users into the database\n";
    echo "-u : configure MySQL username\n";
    echo "-p : configure MySQL password\n";
    echo "-h : configure MySQL host\n";
    exit(0);
}

// now we must check if the MySQL username, password and host were given 
if (!isset($options['u']) || !isset($options['p']) || !isset($options['h'])) {
    echo "Error: MySQL username (-u), password (-p), and host (-h) must be provided.\n";
    exit(1);
}

// 2. create our DB connection - ensure to add error handling (try & catch on connection attempt)

// Get database connection details
$servername = $options['h'];
$username = $options['u'];
$password = $options['p'];
$dbname = "database";       // assume database name is static and called 'database'

// Create a database connection - ensure error handling
$conn = new mysqli($servername, $username, $password) or die("Error: ". mysqli_error($conn));

if ($conn->connect_error) {
    die("Connection failed: ". mysqli_connect_error());
}


// 3. check for what command line directive was inputted by the user - execution decided by what directive(s) used

// lets do create_table first
if (isset($options["create_table"])) {
    // create the database with name "database"
    $sql = "CREATE DATABASE IF NOT EXISTS  $dbname";
    if ($conn->query($sql)) {
        echo "DB created successfully";
    } else {
        echo "Error creating database: ". mysqli_error($conn);
        exit(1);
    }

    // use the database we just created (or it already exists, use it)
    $sql = "USE $dbname";
    if ($conn->query($sql)) {
        echo "Database changed successfully";
    } else {
        echo "Error changing database: ". mysqli_error($conn);
        exit(1);
    }

    // create the table with four columns, id, name, surname, and email (which is unique)
    $sql = "CREATE TABLE IF NOT EXISTS users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(30) NOT NULL,
            surname VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL UNIQUE)";
    if ($conn->query($sql)) {
        echo "Table 'users' created successfully\n";
    } else {
        echo "Error creating 'users' table: ". mysqli_error($conn);
        exit(1);
    }

    // exit the program, nothing else needed for create_table version of the script
    exit(0);
}

// Check if --file directive was provided
if (!(isset($options['file'])) || !(file_exists($options['file']))) {
    echo "Error: please provide a valid CSV file using --file [filename.csv] \n";
    exit(1);
}

// Open the CSV file for reading
$file = fopen($options['file'], 'r');
if (!$file) {
    echo "Error: Unable to open file. \n";
    exit(1);
}

// now we can prepare to insert our CSV into the database
$insertStmt = $conn->prepare("INSERT INTO users (name, surname, email) VALUES (?, ?, ?)");

// Iterate through the file, parsing each name, surname, and email - ensuring each is correctly formatted
while(($data = fgetcsv($file)) !== false) {
    // validate CSV row format
    if (count($data) != 3) {
        echo "Error: Invalid CSV row format\n";
        exit(1);
    }

    $name = ucfirst(strtolower(trim($data[0])));    // trim whitespace, convert whole string to lower case, convert first character to uppercase
    $surname = ucfirst(strtolower(trim($data[1]))); // same as name
    $email = strtolower(trim($data[2]));            // set email address to lower case before filtering

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format\n";
        exit(1);
    }

    // Here, we just need to check if it's a dry_run execution, then insert our CSV information into the DB
    if (!isset($options['dry_run'])) {
        $insertStmt->bind_param('sss', $name, $surname, $email);
        if($insertStmt->execute()) {
            echo "Record successfully inserted: $name, $surname, $email\n";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Dry run: Record would be inserted: $name, $surname, $email";
    }
}

// close file and database connection 
fclose($file);
$conn->close();




