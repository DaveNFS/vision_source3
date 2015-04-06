CREATE TABLE `conditions` (
  `id` int(20) NOT NULL auto_increment,
  `code_and_name` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

INSERT INTO `conditions` (`id`, `code_and_name`) VALUES
(1, 'H52.01 - Hypermetropia, right eye'),
(2, 'H52.223 - Regular astigmatism, bilateral'),
(3, 'H52.12 - Myopia, left eye'),
(4, 'H52.4 - Presbyopia'),
(5, 'H53.021 - Refractive amblyopia, right eye'); 


CREATE TABLE `login` (
	`id` int(20) NOT NULL auto_increment,
	`email` varchar(200) NOT NULL,
	`password` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
);

INSERT INTO `login` (`email`, `password`) VALUES
('abc@abc.com', '123'),
('def@def.com', '123');