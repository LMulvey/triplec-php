<?php

// include the configs / constants for the database connection
require_once("config/db.php");

$uploadErrors = array();
$uploadMessages = array();

$fix_cat = false;

$category_id = $_GET['category_id'];
if(!isset($_GET['category_name'])) { $category_name = $_GET['category_name']; }
if(!isset($_GET['category_desc'])) { $category_desc = $_GET['category_desc']; }

$image_title = $_GET['image_title'];
$image_desc = $_GET['image_desc'];
$image_tags = $_GET['image_tags'];



// create a database connection, using the constants
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db->set_charset("utf8")) {
    $uploadErrors[] = $db->error;
}

//if new category, insert category first
if($category_id == 'new') {
  $sql = "INSERT INTO categories (title, desc)
          VALUES('" . $category_name . "', '" . $category_desc . "');";
  $query_new_category = $db->query($sql);
  $category_id = $db->insert_id;
  $sql = "";
  $fix_cat = true;
  if (!$query_new_category) {
      $uploadErrors[] = "Sorry, your upload failed. Please go back and try again. [Category Failed To Create]";
  }

}

$file = basename($_GET["image"]);
$cropped = "cropped_" . $file;
$imageUrl = UPLOAD_DIR . $file;
$croppedUrl = UPLOAD_DIR . $cropped;
$image = new Imagick($imageUrl);
$image->cropImage($_GET["width"], $_GET["height"], $_GET["x"], $_GET["y"]);
$image->writeImage($croppedUrl);
echo basename(UPLOAD_DIR) . $cropped;

// write new images data into database
$sql = "INSERT INTO images (category_id, url, thumb_url, title, desc, tags)
        VALUES('" . $category_id . "', '" . $imageUrl . "', '" . $croppedUrl . "', '" . $image_title . "', '" . $image_desc . "', '" . $image_tags . "');";
$query_new_image = $db->query($sql);
$image_id = $db->insert_id;

if ($query_new_image) {
    $uploadMessages[] = "Image successfully uploaded!";
} else {
    $uploadErrors[] = "Sorry, your upload failed. Please go back and try again.";
}

if($fix_cat) {
  $sql = "UPDATE categories SET cover_image_id='" . $image_id . "' WHERE id='" . $category_id . "'";
  $db->query($sql);
}

echo $image_title . " / " . $image_desc . " / " . $image_tags . " / " . $category_name . " / " . $category_desc;


 ?>
