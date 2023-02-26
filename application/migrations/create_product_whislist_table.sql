<?php

-- this table will create from laravel project

CREATE TABLE `aws_hdt_app_zoho_3`.`product_whislist`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` int NOT NULL,
  `room_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NULL,
  `unit_price` decimal(10, 2) NULL,
  `total_price` decimal(10, 2) NULL,
  `status` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);