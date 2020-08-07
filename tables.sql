CREATE TABLE contact
(
  created_at TIMESTAMP NOT NULL,
  deleted_at TIMESTAMP,
  address VARCHAR(30) NOT NULL,
  contact_id INT NOT NULL AUTO_INCREMENT,
  money FLOAT NOT NULL,
  name VARCHAR(30) NOT NULL,
  role CHAR(1) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  updated_at TIMESTAMP NOT NULL,
  PRIMARY KEY (contact_id)
);

CREATE TABLE orders
(
  created_at TIMESTAMP NOT NULL,
  order_id INT NOT NULL AUTO_INCREMENT,
  completed INT NOT NULL,
  type CHAR(1) NOT NULL,
  updated_at TIMESTAMP NOT NULL,
  deleted_at TIMESTAMP,
  contact_id INT NOT NULL,
  PRIMARY KEY (order_id),
  FOREIGN KEY (contact_id) REFERENCES contact(contact_id)
);

CREATE TABLE expenses
(
  description VARCHAR(30),
  sum FLOAT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  expense_id INT NOT NULL AUTO_INCREMENT,
  category_id INT NOT NULL,
  updated_at TIMESTAMP NOT NULL,
  deleted_at TIMESTAMP,
  PRIMARY KEY (expense_id)
  FOREIGN KEY (category_id) REFERENCES expense_categories(category_id)
);

CREATE TABLE product_categories
(
  name VARCHAR(30) NOT NULL,
  category_id INT NOT NULL,
  PRIMARY KEY (category_id)
);

CREATE TABLE transactions
(
  created_at TIMESTAMP NOT NULL,
  sum FLOAT NOT NULL,
  transaction_id INT NOT NULL AUTO_INCREMENT,
  updated_at TIMESTAMP NOT NULL,
  contact_id INT NOT NULL,
  order_id INT NOT NULL,
  PRIMARY KEY (transaction_id),
  FOREIGN KEY (contact_id) REFERENCES contact(contact_id),
  FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

CREATE TABLE product_history
(
  created_at TIMESTAMP NOT NULL,
  name VARCHAR(30) NOT NULL,
  sell_price FLOAT NOT NULL,
  buy_price FLOAT NOT NULL,
  product_history_id INT NOT NULL AUTO_INCREMENT,
  updated_at TIMESTAMP NOT NULL,
  PRIMARY KEY (product_history_id)
);

CREATE TABLE expense_categories
(
  name VARCHAR(30) NOT NULL,
  category_id INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (category_id)
);

CREATE TABLE users
(
  user_id INT NOT NULL AUTO_INCREMENT,
  password VARCHAR(60) NOT NULL,
  email VARCHAR(60) NOT NULL,
  name CHAR(60) NOT NULL,
  PRIMARY KEY (user_id),
  UNIQUE (email)
);

CREATE TABLE products
(
  stock INT NOT NULL,
  deleted_at TIMESTAMP,
  product_id INT NOT NULL AUTO_INCREMENT,
  product_history_id INT NOT NULL,
  category_id INT NOT NULL,
  PRIMARY KEY (product_id, product_history_id),
  FOREIGN KEY (product_history_id) REFERENCES product_history(product_history_id),
  FOREIGN KEY (category_id) REFERENCES product_categories(category_id)
);

CREATE TABLE order_products
(
  ammount INT NOT NULL,
  delivered INT NOT NULL,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  producto_history_id INT NOT NULL,
  PRIMARY KEY (order_id, product_id, producto_history_id),
  FOREIGN KEY (order_id) REFERENCES orders(order_id),
  FOREIGN KEY (product_id, producto_history_id) REFERENCES products(product_id, product_history_id)
);
