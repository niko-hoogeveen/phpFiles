<?php


// first, lets think about what we are going to need to do


// 1. parse command line arguments - ensure for proper usage & check CSV file is valid
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

// lets do 


// Directives: 
// create_table: create users table in MySQL - table needs to contain name, surname and email address (unique index)
// dry_run: run the script but don't INSERT into the db - all other functions executed
// u: configure MySQL username
// p: configure MySQL password
// h: configure MySQL host
// help: list of directives with details


