-- 28/06/2016

ALTER TABLE `user`
ADD COLUMN `cpf`  varchar(11) NOT NULL AFTER `last_name`;

