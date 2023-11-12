CREATE TABLE `service_type` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `time_saved` TIME NOT NULL
    );

CREATE TABLE `service_provided` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, `service_type_id` BIGINT NOT NULL,
    `selling_date` DATE NOT NULL,
    `quantity` BIGINT NOT NULL,
     INDEX `service_type_id` (`service_type_id_index`), FOREIGN KEY (`service_type_id`) REFERENCES `service_type`(`id`) ON DELETE CASCADE);