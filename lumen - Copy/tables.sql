CREATE TABLE Clientes
(
  Fecha_de_carga DATE NOT NULL,
  Eliminado? INT NOT NULL,
  Dirección VARCHAR(255) NOT NULL,
  cliente_id INT NOT NULL,
  PRIMARY KEY (cliente_id)
);

CREATE TABLE Pedidos
(
  Descripción VARCHAR(255) NOT NULL,
  Suma_total INT NOT NULL,
  Fecha_de_carga DATE NOT NULL,
  Entregado? INT NOT NULL,
  pedido_id INT NOT NULL,
  cliente_id INT,
  PRIMARY KEY (pedido_id),
  FOREIGN KEY (cliente_id) REFERENCES Clientes(cliente_id)
);

CREATE TABLE Gastos
(
  Descripcion VARCHAR(255) NOT NULL,
  Suma_total INT NOT NULL,
  Fecha_de_carga DATE NOT NULL,
  gasto_id INT NOT NULL,
  PRIMARY KEY (gasto_id)
);

CREATE TABLE Categorías
(
  Nombre VARCHAR(255) NOT NULL,
  categoria_id INT NOT NULL,
  PRIMARY KEY (categoria_id)
);

CREATE TABLE Pagos
(
  Fecha_de_carga DATE NOT NULL,
  Suma INT NOT NULL,
  pago_id INT NOT NULL,
  cliente_id INT,
  pedido_id INT NOT NULL,
  PRIMARY KEY (pago_id),
  FOREIGN KEY (cliente_id) REFERENCES Clientes(cliente_id),
  FOREIGN KEY (pedido_id) REFERENCES Pedidos(pedido_id)
);

CREATE TABLE Historial_de_productos
(
  Fecha_de_carga DATE NOT NULL,
  Nombre VARCHAR(255) NOT NULL,
  Precio INT NOT NULL,
  producto_historico_id INT NOT NULL,
  PRIMARY KEY (producto_historico_id)
);

CREATE TABLE Productos
(
  Stock INT NOT NULL,
  Eliminado? INT NOT NULL,
  producto_id INT NOT NULL,
  producto_historico_id INT NOT NULL,
  categoria_id INT NOT NULL,
  PRIMARY KEY (producto_id, producto_historico_id),
  FOREIGN KEY (producto_historico_id) REFERENCES Historial_de_productos(producto_historico_id),
  FOREIGN KEY (categoria_id) REFERENCES Categorías(categoria_id)
);

CREATE TABLE Pedidos_Productos
(
  Cantidad INT NOT NULL,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  producto_historico_id INT NOT NULL,
  PRIMARY KEY (pedido_id, producto_id, producto_historico_id),
  FOREIGN KEY (pedido_id) REFERENCES Pedidos(pedido_id),
  FOREIGN KEY (producto_id, producto_historico_id) REFERENCES Productos(producto_id, producto_historico_id)
);
