<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("You must be running PHP version > 5.37 to run the dashboard. Contact the admin for more information!");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

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
    // the user is logged in. you can do whatever you want here.

  //upload script
  if(isset($_FILES["file"])) {
    $tmp = $_FILES["file"]["tmp_name"];
    $category_id = $_POST["category"];
    $image_title = $_POST["img_title"];
    $image_desc = $_POST["img_desc"];
    $imgae_tags = $_POST["img_tags"];

    if($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
      $uploadErrors[] = "There was an error uploading your image. Please try again or contact the administrator!";
    }

    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $fileName = preg_replace("/\\.[^.\\s]{3,4}$/", "", $_FILES["file"]["name"]) . "_" . $category_id . "." . $ext;

    // verify the file is a GIF, JPEG, or PNG
    $fileType = exif_imagetype($_FILES["file"]["tmp_name"]);
    $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    if (!in_array($fileType, $allowed)) {
        // file type is not permitted
        $uploadErrors[] = "You did not upload a valid image (JPG / JPEG, GIF, PNG). Select a valid image file and try again.";
      }

    //don't overwrite
    $i = 0;
    $parts = pathinfo($fileName);
      while (file_exists(UPLOAD_DIR . $fileName)) {
          $i++;
          $fileName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
      }

    //resize it
    if($width >= 400 && $height >=400) {
      $image = new Imagick($tmp);
      $image->thumbnailImage(400, 400);
      $image->writeImage($fileName);
    }
    else {
      move_uploaded_file($tmp, UPLOAD_DIR . $fileName);

      // set proper permissions on the new file
      chmod(UPLOAD_DIR . $fileName, 0644);
    }
  }


  //include the crop view
  include("views/view_crop.php");


} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    include("views/login.php");
}
 ?>
