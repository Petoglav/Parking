-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema iwa_2018_sk_projekt
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema iwa_2018_sk_projekt
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `iwa_2018_sk_projekt` DEFAULT CHARACTER SET utf8 ;
USE `iwa_2018_sk_projekt` ;

-- -----------------------------------------------------
-- Table `iwa_2018_sk_projekt`.`tip_korisnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2018_sk_projekt`.`tip_korisnika` (
  `tip_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`tip_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2018_sk_projekt`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2018_sk_projekt`.`korisnik` (
  `korisnik_id` INT(10) NOT NULL AUTO_INCREMENT,
  `tip_id` INT(10) NOT NULL,
  `korisnicko_ime` VARCHAR(50) NOT NULL,
  `lozinka` VARCHAR(50) NOT NULL,
  `ime` VARCHAR(50) NOT NULL,
  `prezime` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NULL,
  `slika` TEXT NULL,
  PRIMARY KEY (`korisnik_id`),
  INDEX `fk_korisnik_tip_korisnika_idx` (`tip_id` ASC),
  CONSTRAINT `fk_korisnik_tip_korisnika`
    FOREIGN KEY (`tip_id`)
    REFERENCES `iwa_2018_sk_projekt`.`tip_korisnika` (`tip_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2018_sk_projekt`.`parkiraliste`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2018_sk_projekt`.`parkiraliste` (
  `parkiraliste_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(50) NOT NULL,
  `adresa` TEXT NOT NULL,
  `slika` TEXT NOT NULL,
  `video` TEXT NULL,
  PRIMARY KEY (`parkiraliste_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2018_sk_projekt`.`tvrtka`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2018_sk_projekt`.`tvrtka` (
  `tvrtka_id` INT(10) NOT NULL AUTO_INCREMENT,
  `moderator_id` INT(10) NOT NULL,
  `parkiraliste_id` INT(10) NOT NULL,
  `naziv` VARCHAR(50) NOT NULL,
  `opis` TEXT NULL,
  PRIMARY KEY (`tvrtka_id`, `moderator_id`),
  INDEX `fk_kateogrija_predmeta_korisnik1_idx` (`moderator_id` ASC),
  INDEX `fk_tvrtka_parkiraliste1_idx` (`parkiraliste_id` ASC),
  CONSTRAINT `fk_kateogrija_predmeta_korisnik1`
    FOREIGN KEY (`moderator_id`)
    REFERENCES `iwa_2018_sk_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tvrtka_parkiraliste1`
    FOREIGN KEY (`parkiraliste_id`)
    REFERENCES `iwa_2018_sk_projekt`.`parkiraliste` (`parkiraliste_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2018_sk_projekt`.`partner`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2018_sk_projekt`.`partner` (
  `partner_id` INT(10) NOT NULL,
  `korisnik_id` INT(10) NOT NULL,
  `tvrtka_id` INT(10) NOT NULL,
  INDEX `fk_vozilo_korisnik1_idx` (`korisnik_id` ASC),
  PRIMARY KEY (`partner_id`),
  CONSTRAINT `fk_vozilo_korisnik1`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `iwa_2018_sk_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vozilo_tvrtka1`
    FOREIGN KEY (`tvrtka_id`)
    REFERENCES `iwa_2018_sk_projekt`.`tvrtka` (`tvrtka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2018_sk_projekt`.`automobil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2018_sk_projekt`.`automobil` (
  `automobil_id` INT(10) NOT NULL AUTO_INCREMENT,
  `partner_id` INT(10) NOT NULL,
  `registracija` VARCHAR(50) NOT NULL,
  `datum_vrijeme_dolaska` DATETIME NOT NULL,
  `datum_vrijeme_odlaska` DATETIME NULL,
  INDEX `fk_vozilo_zaposlenik1_idx` (`partner_id` ASC),
  PRIMARY KEY (`automobil_id`),
  CONSTRAINT `fk_vozilo_zaposlenik1`
    FOREIGN KEY (`partner_id`)
    REFERENCES `iwa_2018_sk_projekt`.`partner` (`partner_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE USER 'iwa_2018'@'localhost' IDENTIFIED BY 'foi2018';

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `iwa_2018_sk_projekt`.* TO 'iwa_2018'@'localhost';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
