<?php
// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();
$uploadErrors = array();
$uploadMessages = array();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
  //load data for the upload script
  // create a database connection, using the constants from config/db.php (which we loaded in index.php)
  $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // change character set to utf8 and check it
  if (!$db->set_charset("utf8")) {
      $uploadErrors[] = $db->error;
  }

  // if no connection errors (= working database connection)
  if (!$db->connect_errno) {
      // database query, getting all the info of the selected user (allows login via email address in the
      // username field)
      $sql = "SELECT category_id, title, desc
              FROM categories";
      $categories = $db->query($sql);

    }

    //LOAD THE view
    include("views/view_upload.php");


  } else {
      // the user is not logged in. you can do whatever you want here.
      // for demonstration purposes, we simply show the "you are not logged in" view.
      include("views/login.php");
  }

 ?>
