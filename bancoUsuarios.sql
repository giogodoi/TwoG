DROP DATABASE IF EXISTS sistema_usuarios;
CREATE DATABASE sistema_usuarios;
USE sistema_usuarios;

-- 1. Tabela Estudio (Independente)
CREATE TABLE IF NOT EXISTS `Estudio` (
  `Id_Estudio` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(100) NOT NULL,
  `Pais` VARCHAR(100) NULL,
  PRIMARY KEY (`Id_Estudio`),
  UNIQUE INDEX `Nome_UNIQUE` (`Nome` ASC)
);


INSERT INTO Estudio (Nome, Pais) VALUES ('Nintendo', 'Japão'), ('Rockstar Games', 'EUA'), ('CD Projekt Red', 'Polônia'), ('Ubisoft', 'França'), ('Godoi Minigames', 'Brasil');

CREATE TABLE IF NOT EXISTS `Usuario` (
  `Id_Usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`Id_Usuario`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
);

-- 3. Tabela Cliente (Filha)
CREATE TABLE IF NOT EXISTS `Cliente` (
  `Usuario_Id_Usuario` INT NOT NULL,
  `Pais_Origem` VARCHAR(100) NULL DEFAULT 'Desconhecido',
  PRIMARY KEY (`Usuario_Id_Usuario`),
  CONSTRAINT `fk_Cliente_Usuario`
    FOREIGN KEY (`Usuario_Id_Usuario`) REFERENCES `Usuario` (`Id_Usuario`)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- 4. Tabela Desenvolvedor (Filha + Ligação com Estúdio)
CREATE TABLE IF NOT EXISTS `Desenvolvedor` (
  `Usuario_Id_Usuario` INT NOT NULL,
  `Area` VARCHAR(100) NULL,
  `Cargo` VARCHAR(100) NULL,
  `Id_Estudio` INT NULL,
  PRIMARY KEY (`Usuario_Id_Usuario`),
  CONSTRAINT `fk_Desenvolvedor_Usuario`
    FOREIGN KEY (`Usuario_Id_Usuario`) REFERENCES `Usuario` (`Id_Usuario`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Desenvolvedor_Estudio`
    FOREIGN KEY (`Id_Estudio`) REFERENCES `Estudio` (`Id_Estudio`)
    ON DELETE SET NULL ON UPDATE CASCADE
);