CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `brands` (`id`, `name`, `description`) VALUES
(1, 'Adidas', 'More stripes, more adidas!'),
(2, 'Nike', 'Just do it!'),
(3, 'BUSHMAN', 'Tested on humans.'),
(4, 'Calvin Klein', 'Sexy since 1968.'),
(5, 'Converse', 'All star classic.'),
(6, 'Kappa', 'Everyone wants socks with letter K.'),
(7, 'ALPINE PRO', 'Czech outdoor clothes and accessories market leader.');