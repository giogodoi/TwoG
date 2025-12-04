-- -----------------------------------------------------
-- 1. Criação do Banco de Dados
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `mydb`;
CREATE DATABASE IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8mb3;
USE `mydb`;

-- -----------------------------------------------------
-- 2. Tabela Estudio (Base para Desenvolvedor e Produto)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Estudio` (
  `Id_Estudio` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(100) NOT NULL,
  `Pais` VARCHAR(100) NULL,
  PRIMARY KEY (`Id_Estudio`),
  UNIQUE INDEX `Nome_UNIQUE` (`Nome` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- 3. Tabela Usuario (Base para Cliente e Desenvolvedor)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Usuario` (
  `Id_Usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(32) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id_Usuario`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- 4. Tabela Cliente (Herança de Usuario)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Cliente` (
  `Pais_Origem` VARCHAR(32) NOT NULL,
  `Usuario_Id_Usuario` INT NOT NULL,
  PRIMARY KEY (`Usuario_Id_Usuario`),
  CONSTRAINT `fk_Cliente_Usuario1`
    FOREIGN KEY (`Usuario_Id_Usuario`)
    REFERENCES `mydb`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- 5. Tabela Desenvolvedor (Herança de Usuario + Link Estúdio)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Desenvolvedor` (
  `Usuario_Id_Usuario` INT NOT NULL,
  `Area` VARCHAR(40) NOT NULL,
  `Cargo` VARCHAR(50) NULL,
  `Estudio_Id_Estudio` INT NULL,
  PRIMARY KEY (`Usuario_Id_Usuario`),
  INDEX `fk_Desenvolvedor_Estudio1_idx` (`Estudio_Id_Estudio` ASC),
  CONSTRAINT `fk_Desenvolvedor_Usuario1`
    FOREIGN KEY (`Usuario_Id_Usuario`)
    REFERENCES `mydb`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Desenvolvedor_Estudio1`
    FOREIGN KEY (`Estudio_Id_Estudio`)
    REFERENCES `mydb`.`Estudio` (`Id_Estudio`)
    ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- 6. Demais Tabelas do Sistema (Produto, Jogo, etc.)
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `mydb`.`Produto` (
  `Cod_Ident` INT NOT NULL AUTO_INCREMENT,
  `Titulo` VARCHAR(150) NOT NULL,
  `Descricao` VARCHAR(500) NULL DEFAULT NULL,
  `Preco` DECIMAL(6,2) NULL,
  `Data_Lanc` DATE NOT NULL,
  `Tamanho` VARCHAR(50) NOT NULL,
  `Id_Estudio` INT NOT NULL,
  PRIMARY KEY (`Cod_Ident`),
  INDEX `fk_produto_estudio_idx` (`Id_Estudio` ASC),
  CONSTRAINT `fk_produto_estudio`
    FOREIGN KEY (`Id_Estudio`)
    REFERENCES `mydb`.`Estudio` (`Id_Estudio`)
    ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Avaliacao` (
  `Id_Usuario` INT NOT NULL,
  `Cod_Ident_Produto` INT NOT NULL,
  `Nota` CHAR(2) NOT NULL,
  `Comentario` VARCHAR(300) NULL DEFAULT NULL,
  `Data_Avaliacao` DATE NOT NULL,
  PRIMARY KEY (`Id_Usuario`, `Cod_Ident_Produto`),
  INDEX `fk_avaliacao_produto_idx` (`Cod_Ident_Produto` ASC),
  CONSTRAINT `fk_avaliacao_produto`
    FOREIGN KEY (`Cod_Ident_Produto`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_avaliacao_usuario`
    FOREIGN KEY (`Id_Usuario`)
    REFERENCES `mydb`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Conquista` (
  `Id_Conquista` INT NOT NULL AUTO_INCREMENT,
  `Cod_Ident_Produto` INT NOT NULL,
  `Nome` VARCHAR(100) NOT NULL,
  `Descricao` VARCHAR(300) NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Conquista`),
  UNIQUE INDEX `uq_produto_nome_conquista` (`Cod_Ident_Produto` ASC, `Nome` ASC),
  INDEX `fk_conquista_produto_idx` (`Cod_Ident_Produto` ASC),
  CONSTRAINT `fk_conquista_produto`
    FOREIGN KEY (`Cod_Ident_Produto`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Jogo` (
  `Cod_Ident_Prod_Jogo` INT NOT NULL,
  `Classific_Ind` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`Cod_Ident_Prod_Jogo`),
  INDEX `fk_Jogo_Produto1_idx` (`Cod_Ident_Prod_Jogo` ASC),
  CONSTRAINT `fk_Jogo_Produto1`
    FOREIGN KEY (`Cod_Ident_Prod_Jogo`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`DLC` (
  `Cod_Ident_Prod_DLC` INT NOT NULL,
  `Cod_Ident_Prod_Jogo` INT NOT NULL,
  PRIMARY KEY (`Cod_Ident_Prod_DLC`),
  INDEX `fk_DLC_Produto1_idx` (`Cod_Ident_Prod_DLC` ASC),
  INDEX `fk_DLC_Jogo1_idx` (`Cod_Ident_Prod_Jogo` ASC),
  CONSTRAINT `fk_DLC_Produto1`
    FOREIGN KEY (`Cod_Ident_Prod_DLC`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_DLC_Jogo1`
    FOREIGN KEY (`Cod_Ident_Prod_Jogo`)
    REFERENCES `mydb`.`Jogo` (`Cod_Ident_Prod_Jogo`)
    ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Pedido` (
  `Id_Pedido` INT NOT NULL AUTO_INCREMENT,
  `data` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `Id_Usuario` INT NOT NULL,
  PRIMARY KEY (`Id_Pedido`),
  INDEX `fk_pedido_usuario_idx` (`Id_Usuario` ASC),
  CONSTRAINT `fk_pedido_usuario`
    FOREIGN KEY (`Id_Usuario`)
    REFERENCES `mydb`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Itens_Pedido` (
  `Id_Pedido` INT NOT NULL,
  `Cod_Ident_Produto` INT NOT NULL,
  PRIMARY KEY (`Id_Pedido`, `Cod_Ident_Produto`),
  INDEX `fk_itens_pedido_produto_idx` (`Cod_Ident_Produto` ASC),
  CONSTRAINT `fk_itens_pedido_pedido`
    FOREIGN KEY (`Id_Pedido`)
    REFERENCES `mydb`.`Pedido` (`Id_Pedido`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_itens_pedido_produto`
    FOREIGN KEY (`Cod_Ident_Produto`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Produto_Genero` (
  `Cod_Ident_Produto` INT NOT NULL,
  `Genero` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`Cod_Ident_Produto`, `Genero`),
  CONSTRAINT `fk_genero_produto`
    FOREIGN KEY (`Cod_Ident_Produto`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Produto_Plataforma` (
  `Cod_Ident_Produto` INT NOT NULL,
  `Plataforma` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`Cod_Ident_Produto`, `Plataforma`),
  CONSTRAINT `fk_plataforma_produto`
    FOREIGN KEY (`Cod_Ident_Produto`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Tipo_DLC` (
  `Tipo` VARCHAR(32) NOT NULL,
  `Cod_Ident_Prod_DLC` INT NOT NULL,
  PRIMARY KEY (`Tipo`, `Cod_Ident_Prod_DLC`),
  INDEX `fk_Tipo_DLC_DLC1_idx` (`Cod_Ident_Prod_DLC` ASC),
  CONSTRAINT `fk_Tipo_DLC_DLC1`
    FOREIGN KEY (`Cod_Ident_Prod_DLC`)
    REFERENCES `mydb`.`DLC` (`Cod_Ident_Prod_DLC`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Usuario_Conquista` (
  `Id_Usuario` INT NOT NULL,
  `Id_Conquista` INT NOT NULL,
  `Data_Alcancada` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_Usuario`, `Id_Conquista`),
  INDEX `fk_ua_conquista_idx` (`Id_Conquista` ASC),
  CONSTRAINT `fk_ua_conquista`
    FOREIGN KEY (`Id_Conquista`)
    REFERENCES `mydb`.`Conquista` (`Id_Conquista`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_ua_usuario`
    FOREIGN KEY (`Id_Usuario`)
    REFERENCES `mydb`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

CREATE TABLE IF NOT EXISTS `mydb`.`Biblioteca` (
  `Cod_Ident` INT NOT NULL,
  `Id_Usuario` INT NOT NULL,
  PRIMARY KEY (`Cod_Ident`, `Id_Usuario`),
  INDEX `fk_Possui- Biblioteca_Usuario1_idx` (`Id_Usuario` ASC),
  CONSTRAINT `fk_Possui- Biblioteca_Produto`
    FOREIGN KEY (`Cod_Ident`)
    REFERENCES `mydb`.`Produto` (`Cod_Ident`)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_Possui- Biblioteca_Usuario`
    FOREIGN KEY (`Id_Usuario`)
    REFERENCES `mydb`.`Usuario` (`Id_Usuario`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- 7. POVOANDO AS TABELAS (INSERTS)
-- -----------------------------------------------------

-- A. Inserir Estúdios (Necessário para criar Desenvolvedores)
INSERT INTO `Estudio` (`Id_Estudio`, `Nome`, `Pais`) VALUES
(1, 'Nintendo', 'Japão'),
(2, 'Ubisoft', 'França'),
(3, 'Rockstar Games', 'EUA');

-- B. Inserir Usuários (Tabela Pai)
INSERT INTO `Usuario` (`Id_Usuario`, `nome`, `email`, `senha`) VALUES
(1, 'João da Silva', 'joao@email.com', '12345'),
(2, 'Maria Dev', 'maria@dev.com', 'admin123');

-- C. Inserir Cliente (Relacionado ao Usuário 1)
INSERT INTO `Cliente` (`Usuario_Id_Usuario`, `Pais_Origem`) VALUES
(1, 'Brasil');

-- D. Inserir Desenvolvedor (Relacionado ao Usuário 2 e ao Estúdio 1-Nintendo)
INSERT INTO `Desenvolvedor` (`Usuario_Id_Usuario`, `Area`, `Cargo`, `Estudio_Id_Estudio`) VALUES
(2, 'Back-End', 'Sênior', 1);

-- E. (Opcional) Inserir um Produto de teste vinculado à Nintendo
INSERT INTO `Produto` (`Titulo`, `Data_Lanc`, `Tamanho`, `Id_Estudio`) VALUES
('Super Mario Odyssey', '2017-10-27', '5GB', 1);
