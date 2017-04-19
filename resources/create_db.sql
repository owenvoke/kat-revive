# Create Database
CREATE DATABASE IF NOT EXISTS `kat_db`;

# Create table structure
CREATE TABLE `kat_db`.`t_collection` (
  `torrent_info_hash`    VARCHAR(40)    NOT NULL UNIQUE,
  `torrent_name`         VARCHAR(1000)  NOT NULL,
  `torrent_category`     VARCHAR(500)   NOT NULL DEFAULT 'Unsorted',
  `torrent_info_url`     VARCHAR(1000)  NOT NULL DEFAULT '',
  `torrent_download_url` VARCHAR(1000)  NOT NULL DEFAULT '',
  `size`                 BIGINT(100)    NOT NULL DEFAULT 0,
  `category_id`          INT            NOT NULL DEFAULT 55,
  `files_count`          INT            NOT NULL DEFAULT 1,
  `upload_date`          VARCHAR(100)   NOT NULL DEFAULT '',
  `verified`             BOOLEAN        NOT NULL DEFAULT 0,
  `description`          VARCHAR(10000) NOT NULL DEFAULT ''
)
  ENGINE = InnoDB
  COMMENT = 'KatRevive Database';
