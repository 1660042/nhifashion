-- Coppy tất cả rồi chạy để bổ sung thêm cột 

ALTER TABLE the_loai
ADD COLUMN  `ten_anh` VARCHAR(60) NOT NULL COLLATE 'utf8_general_ci',
ADD COLUMN `is_show` TINYINT(1) NOT NULL DEFAULT '0';

ALTER TABLE `san_pham_chi_tiet` CHANGE COLUMN `size` `size` VARCHAR(10) NOT NULL DEFAULT '' AFTER `id_mau_sac`;

ALTER TABLE `hoa_don_san_pham` CHANGE COLUMN `size` `size` VARCHAR(10) NOT NULL DEFAULT '' AFTER `id_mau_sac`;
