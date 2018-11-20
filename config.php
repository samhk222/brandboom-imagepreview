<?PHP
include("vendor/autoload.php");
include("src/DB.php");
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$sql = [
'createtable' => "CREATE TABLE IF NOT EXISTS `images` (
  `image_id` INT NOT NULL AUTO_INCREMENT,
  `filepath` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`image_id`));"
];

foreach ($sql as $key => $value) {
    DB::query($value);
}

header("Location: index.php");
die("All data was saved. You can close this tab now");