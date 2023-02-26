<?php

-- this table will create from laravel project

CREATE TABLE `aws_hdt_app_zoho_3`.`products`  (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_id` int NOT NULL,
    `name` varchar(200) NOT NULL,
    `sku` varchar(100) NOT NULL,
    `description` text NULL,
    `price` decimal(10, 2) NULL,
    `status` tinyint NOT NULL DEFAULT 0,
    `image_path` varchar(255) NULL,
    `created_at` integer NULL,
    `update_at` integer NULL,
    PRIMARY KEY (`id`),
    INDEX `category_id`(`category_id` ASC) USING BTREE,
    INDEX `sku`(`sku` ASC) USING BTREE
);