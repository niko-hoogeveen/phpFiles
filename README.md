Install Documentation:
- Note: I used mysqli for interacting with the database, so ensure that it is installed.

Linux installation commands:
$ sudo apt-get update
$ sudo apt-get install php mysql-server php-mysql

* The mysqli extension is often available by default with PHP. However, the following command will ensure it gets downloaded explicity *

$ sudo apt-get install php-mysqli

Please ensure the line "extension=mysqli" is uncommeneted in your php.ini file. If you had to uncomment it, ensure you restart your webserver before running the script again.
