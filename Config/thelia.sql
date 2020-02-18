
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product_ean
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_ean`;

CREATE TABLE `product_ean`
(
    `product_sale_id` INTEGER NOT NULL,
    `ean_code` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`product_sale_id`),
    CONSTRAINT `fk_barcode_scanner_product_id`
        FOREIGN KEY (`product_sale_id`)
        REFERENCES `product_sale_elements` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
