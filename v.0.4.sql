-- 04/07/2016 - Giovanne
-- A tabela 'survey_history' tava sem chave primária
ALTER TABLE `survey_history` ADD PRIMARY KEY(`id`);
ALTER TABLE `survey_history`
CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 04/07/2016 - Giovanne
-- É mlehor guardar o id do item e consultar quando for preciso.
ALTER TABLE `survey_history`
DROP `chosen_item_order`,
DROP `chosen_item_text`;

ALTER TABLE `survey_history`
ADD `item_id` INT(10) UNSIGNED NULL AFTER `question_id`,
ADD INDEX (`item_id`);

ALTER TABLE `survey_history`
ADD CONSTRAINT `FK_QUESTION_ITEM_HISTORY_SURVEY`
FOREIGN KEY (`item_id`)
REFERENCES `click_pesquisa_db`.`question_item`(`id`)
ON DELETE CASCADE ON UPDATE CASCADE;

-- 02/07/2016 - Giovanne
-- É preciso saber se algum fomulário foi alterado após a última atualização
-- do cliente. Quando um formulário é atualizado a data de criação não muda e o
-- cliente não sabe que tem um novo formulário para baixar

ALTER TABLE `form`
ADD `last_updated_at` DATETIME NULL AFTER `created_at`;

-- 29/06/2016 - Giovanne
-- Removendo UNIQUE INDEX. Esta coluna é chave estrangeira e pode receber
-- valores duplicados com ids de usuários que criaram o form.
ALTER TABLE form
DROP INDEX user_id_creator,
ADD INDEX user_id_creator (user_id_creator)

-- 28/06/2016 - Caíque
-- Adicionando coluna de CPF
ALTER TABLE `user`
ADD COLUMN `cpf`  varchar(11) NOT NULL AFTER `last_name`;
