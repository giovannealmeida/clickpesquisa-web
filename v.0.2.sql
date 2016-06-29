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
