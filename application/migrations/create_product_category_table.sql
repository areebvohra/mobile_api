<?php

-- this table will create from laravel project

CREATE TABLE `aws_hdt_app_zoho_3`.`product_category`  (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(200) NOT NULL,
    `description` text NULL,
    `status` tinyint NOT NULL DEFAULT 0,
    `created_at` integer NULL,
    `update_at` integer NULL,
    PRIMARY KEY (`id`)
);