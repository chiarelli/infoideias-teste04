ALTER TABLE `phalcont_teste04`.`noticia`
    ADD data_publicacao DATETIME;

CREATE TABLE `phalcont_teste04`.`category` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`name`)
);

CREATE TABLE `phalcont_teste04`.`noticia_category` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `noticia_id` INT(10) NOT NULL,
  `category_id` INT(10) NOT NULL,
    PRIMARY KEY (id),
    KEY noticia_id (noticia_id),
    KEY category_id (category_id),
     FOREIGN KEY (`noticia_id`) REFERENCES `phalcont_teste04`.`noticia` (`id`),
     FOREIGN KEY (`category_id`) REFERENCES `phalcont_teste04`.`category` (`id`)	
);

INSERT INTO `phalcont_teste04`.`category`(`name`) 
VALUES ("substância"), ("quantidade"), ("qualidade"), ("relação"), ("lugar"), ("tempo"), ("estado"), ("hábito"), ("ação"), ("paixão");