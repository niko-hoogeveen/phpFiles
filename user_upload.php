<?php


// first, lets think about what we are going to need to do


// 1. parse command line arguments - ensure for proper usage & check CSV file is valid
// 2. create our DB connection - ensure to add error handling (try & catch on connection attempt)
// 3. check for what command line directive was inputted by the user - execution decided by what directive(s) used
// Directives: 
// create_table: create users table in MySQL - table needs to contain name, surname and email address (unique index)
// dry_run: run the script but don't INSERT into the db - all other functions executed
// u: configure MySQL username
// p: configure MySQL password
// h: configure MySQL host
// help: list of directives with details

