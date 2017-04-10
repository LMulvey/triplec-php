<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("You must be running PHP version > 5.37 to run the dashboard. Contact the admin for more information!");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

$gallery = false;

if (isset($_GET["kitchens"]) || isset($_GET["bathrooms"]) || isset($_GET["others"])) {
  $gallery = true;
}
// include the configs / constants for the database connection
require_once("config/db.php");

//include header for index
include("views/partial_site_header.php");

if (isset($_GET["kitchens"])) {
  //include the crop view
  include("views/view_static_gallery_kitchens.php");
}

else if (isset($_GET["bathrooms"])) {
  //include the crop view
  include("views/view_static_gallery_bathrooms.php");
}
else if (isset($_GET["others"])) {
  //include the crop view
  include("views/view_static_gallery_others.php");
}
else {
  //include the crop view
  include("views/view_index.php");
}

//include header for index
include("views/partial_dashboard_footer.php");
