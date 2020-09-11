CREATE TABLE `contacts` (
  `created_at` date NOT NULL,
  `deleted_at` date DEFAULT NULL,
  `address` varchar(30) NOT NULL,
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `money` float NOT NULL,
  `name` varchar(30) NOT NULL,
  `role` char(1) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4
CREATE TABLE `expense_categories` (
  `name` varchar(30) NOT NULL,
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4
CREATE TABLE `expenses` (
  `description` varchar(30) DEFAULT NULL,
  `sum` float NOT NULL,
  `created_at` date NOT NULL,
  `expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`expense_id`),
  KEY `expense_category` (`category_id`),
  CONSTRAINT `expense_category` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4
CREATE TABLE `order_products` (
  `ammount` int(11) NOT NULL,
  `delivered` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_history_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`,`product_history_id`),
  KEY `order_product_history` (`product_history_id`),
  KEY `order_product` (`product_id`),
  CONSTRAINT `order_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_product_history` FOREIGN KEY (`product_history_id`) REFERENCES `product_history` (`product_history_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
CREATE TABLE `orders` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `delivered` tinyint(1) NOT NULL DEFAULT 0,
  `type` char(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `orders_contacts` (`contact_id`),
  CONSTRAINT `orders_contacts` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4
CREATE TABLE `product_categories` (
  `name` varchar(30) NOT NULL,
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4
CREATE TABLE `product_history` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(30) NOT NULL,
  `sell_price` float NOT NULL,
  `buy_price` float NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_history_id`),
  KEY `history_product` (`product_id`),
  CONSTRAINT `history_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4
CREATE TABLE `products` (
  `stock` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_history_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`product_history_id`),
  UNIQUE KEY `product_history_id` (`product_history_id`) USING BTREE,
  KEY `products_categories` (`category_id`),
  CONSTRAINT `products_categories` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_history` FOREIGN KEY (`product_history_id`) REFERENCES `product_history` (`product_history_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4
CREATE TABLE `transactions` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sum` float NOT NULL,
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `contact_id` (`contact_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`),
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `name` char(60) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4
