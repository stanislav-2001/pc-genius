<?php 
//setup:

include "db.php";

$dataname = dbname;

$sql = "CREATE TABLE clanky ( `clanok_id` INT NOT NULL AUTO_INCREMENT , `nazov` VARCHAR(255) NOT NULL , `html_obsah` TEXT NOT NULL , `url` VARCHAR(255) NOT NULL , `obr_semiurl` VARCHAR(255) NOT NULL , `kategoria` INT NOT NULL ,  `cas` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`clanok_id`)) ENGINE = MyISAM COMMENT = 'Tagy su v druhej tabulke'";
mysqli_query($conn, $sql);
$sql = "CREATE TABLE tagy ( `clanok_id` INT NOT NULL , `tag` VARCHAR(255) NOT NULL ) ENGINE = MyISAM;";
mysqli_query($conn, $sql);
$sql = "CREATE TABLE related ( `povodny_clanok_id` INT NOT NULL , `sug_clanok_id` INT NOT NULL , `zhody` INT NOT NULL ) ENGINE = MyISAM;";
mysqli_query($conn, $sql);
$sql = "CREATE TABLE kategorie ( `id` INT NOT NULL AUTO_INCREMENT , `kategoria` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
mysqli_query($conn, $sql);
$sql = "ALTER DATABASE $dataname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
mysqli_query($conn, $sql);

echo "OKEJ, ZMAŽTE SÚBOR! install.php z FTPčka.";
