<?php
error_reporting (E_ALL ^ E_NOTICE);
/**
 * Configuration for: Database Connection
 *
 * For more information about constants please  http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 * DB_PASS: the password of the above user
 */

define("DB_HOST", "localhost");
define("DB_NAME", "lmulvey_triplec");
define("DB_USER", "lmulvey_triplec");
define("DB_PASS", "HbU4auI5W");


// *** CONFIG ***//
define("UPLOAD_DIR", "/home/lmulvey/domains/leemulvey.com/public_html/triplec/img/upload/");
