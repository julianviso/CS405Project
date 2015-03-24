CREATE TABLE Staff(sid INTEGER NOT NULL AUTO_INCREMENT,
					name VARCHAR(30) NOT NULL,
					password VARCHAR(30) NOT NULL,
					manager BOOLEAN NOT NULL DEFAULT 0,
					PRIMARY KEY (sid));

CREATE TABLE Customers(email VARCHAR(30) NOT NULL,
					fname VARCHAR(30) NOT NULL,
					lname VARCHAR(30) NOT NULL,
					password VARCHAR(30) NOT NULL,
					PRIMARY KEY (email));

CREATE TABLE Products(prod_id INTEGER NOT NULL AUTO_INCREMENT,
					name VARCHAR(30) NOT NULL,
					price FLOAT NOT NULL,
					PRIMARY KEY (prod_id),
					CHECK (price > 0));
/*
CREATE TABLE Purchase(prod_id INTEGER NOT NULL AUTO_INCREMENT,
					email VARCHAR(30) NOT NULL,
					PRIMARY KEY (prod_id, email),
					FOREIGN KEY (email) REFERENCES Customers(email));

CREATE TABLE Cart(cart_id INTEGER NOT NULL AUTO_INCREMENT,
			   		prod_id INTEGER NOT NULL,
          			email VARCHAR(30) NOT NULL,
					PRIMARY KEY (cart_id),
					FOREIGN KEY (email) REFERENCES Customers(email),
					FOREIGN KEY (prod_id) REFERENCES Products(prod_id));
*/
CREATE TABLE Orders(order_id INTEGER NOT NULL AUTO_INCREMENT,
					status INTEGER,
					shippingDate DATE,
					orderDate DATE NOT NULL,
					PRIMARY KEY (order_id),
					CHECK(EXISTS(SELECT * 
								FROM Staff 
								WHERE Orders.status = Staff.sid)));
					
					
CREATE TABLE Promotions(promo_id INTEGER NOT NULL AUTO_INCREMENT,
						discount FLOAT NOT NULL,
						startDate DATE,
						endDate DATE,
						managerOrdered INTEGER NOT NULL,
						prod_id INTEGER NOT NULL,
						PRIMARY KEY (promo_id),
						FOREIGN KEY (managerOrdered) REFERENCES Staff(sid),
						FOREIGN KEY (prod_id) REFERENCES Products(prod_id),
						CHECK (discount < 1));
