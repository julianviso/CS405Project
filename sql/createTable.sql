CREATE TABLE Customers(
    email VARCHAR(30) NOT NULL,
	fname VARCHAR(30) NOT NULL,
	lname VARCHAR(30) NOT NULL,
	password VARCHAR(30) NOT NULL,
	PRIMARY KEY (email));

CREATE TABLE Managers(
    mid INTEGER NOT NULL AUTO_INCREMENT,
    email VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    PRIMARY KEY (mid, email)
);

CREATE TABLE Staff(
    sid INTEGER NOT NULL AUTO_INCREMENT,
	name VARCHAR(30) NOT NULL,
	password VARCHAR(30) NOT NULL,
	manager BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (sid)
);

CREATE TABLE Orders(
    order_id INTEGER NOT NULL AUTO_INCREMENT,
	email VARCHAR(30),
	FOREIGN KEY (email) REFERENCES Customers (email),
	status INTEGER,
	shippingDate DATE,
	orderDate DATE NOT NULL,
	PRIMARY KEY (order_id),
	CHECK(EXISTS(SELECT * 
		FROM Staff 
		WHERE Orders.status = Staff.sid))
);

CREATE TABLE Products(
    prod_id INTEGER NOT NULL AUTO_INCREMENT,
	name VARCHAR(30) NOT NULL,
	price FLOAT NOT NULL,
	PRIMARY KEY (prod_id),
	CHECK (price > 0)
);

CREATE TABLE Orderlines(
    order_id INTEGER NOT NULL,
    prod_id INTEGER NOT NULL,
    quantity INTEGER,
    PRIMARY KEY(order_id, prod_id),
    FOREIGN KEY (prod_id) REFERENCES Products (prod_id),
    FOREIGN KEY (order_id) REFERENCES Orders (order_id)
);

CREATE TABLE Promotions(
    promo_id INTEGER NOT NULL AUTO_INCREMENT,
	discount FLOAT NOT NULL,
	startDate DATE,
	endDate DATE,
	managerOrdered INTEGER NOT NULL,
	prod_id INTEGER NOT NULL,
	PRIMARY KEY (promo_id),
	FOREIGN KEY (managerOrdered) REFERENCES Staff(sid),
	FOREIGN KEY (prod_id) REFERENCES Products(prod_id),
	CHECK (discount < 1)
);

