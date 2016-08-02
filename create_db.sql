CREATE DATABASE IF NOT EXISTS `kat_db`;

CREATE TABLE `kat_db`.`t_collection` (
  `torrent_info_hash` VARCHAR(40) NOT NULL UNIQUE ,
  `torrent_name` VARCHAR(1000) NOT NULL ,
  `torrent_category` VARCHAR(500) NOT NULL ,
  `torrent_info_url` VARCHAR(1000) NOT NULL ,
  `torrent_download_url` VARCHAR(1000) NOT NULL ,
  `size` VARCHAR(500) NOT NULL ,
  `category_id` INT NOT NULL ,
  `files_count` INT NOT NULL ,
  `upload_date` VARCHAR(100) NOT NULL ,
  `verified` BOOLEAN NOT NULL ,
  `description` VARCHAR(10000) NOT NULL
)
ENGINE = InnoDB
COMMENT = 'Torrent Database';
