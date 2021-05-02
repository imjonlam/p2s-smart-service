<?php
class init_conn {
	
	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $conn;
	
	function __construct($sn="localhost", $u="root", $p="", $db) {
		$this->servername = $sn;
		$this->username = $u;
		$this->password = $p;
		$this->dbname = $db;
	}
	
	function createConn() {
		$this->conn = @ new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		// Check connection
		if ($this->conn->connect_error) {
			$this->conn = @ new mysqli($this->servername, $this->username, $this->password);

			if ($this->conn->connect_error) {
				die("Connection failed: " . $this->conn->connect_error);
			}
			else {
				$e = $this->createDB();
				if($e === 0 or $e === 1) {
					$this->conn->close();
					$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

					$e = $this->createTables();
					if($e !== true) {
						die("Error creating tables: " . $e);
					}
				}
				else {
					die("Error creating database: " . $e);
				}
			}
		}
		return $this->conn;
	}
	
	private function createDB() {
		$check_db_sql = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA where SCHEMA_NAME = '" . $this->dbname . "'";

		$result = $this->conn->query($check_db_sql);

		if($result->num_rows == 0) {
			$result->close();
			$create_db_sql = "CREATE DATABASE " . $this->dbname;

			if($this->conn->query($create_db_sql) === TRUE) {
				return 1;
			} else {
				return $this->conn->error;
			}
		}
		elseif($result->num_rows == 1) {
			$result->close();
			return 0;
		}
		else {
			$result->close();
			return $this->conn->error;
		}
	}

	private function createTables() {
		$create_orders_tb_sql = "CREATE TABLE Orders (
			`order_number` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`issued_date` DATE,
			`done_date` DATE,
			`description` VARCHAR(100),
			`total_price` FLOAT(10,2),
			`payment_code` VARCHAR(20),
			`user_id` INT UNSIGNED,
			`trip_id` INT UNSIGNED,
			`flower_id` INT UNSIGNED,
			`coffee_id` INT UNSIGNED,
			`car_id` INT UNSIGNED,
			`reviewed` VARCHAR(3) DEFAULT 'NO',
			FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
			FOREIGN KEY (`trip_id`) REFERENCES Trips(`id`),
			FOREIGN KEY (`flower_id`) REFERENCES Flowers(`id`),
			FOREIGN KEY (`coffee_id`) REFERENCES Coffees(`id`),
			FOREIGN KEY (`car_id`) REFERENCES Cars(`id`)
			)";

		$create_review_tb_sql = "CREATE TABLE Reviews (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`order_number` INT UNSIGNED,
			`rating` INT UNSIGNED,
			`description` VARCHAR(100),
			FOREIGN KEY (`order_number`) REFERENCES Orders(`order_number`)
			)";

		$create_suggestion_tb_sql = "CREATE TABLE Suggestions (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`business` VARCHAR(25),
			`address` VARCHAR(100)
			)";

		$create_user_tb_sql = "CREATE TABLE Users (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`name` VARCHAR(50),
			`telephone` VARCHAR(12),
			`email` VARCHAR(40),
			`city` VARCHAR(20),
			`login_id` VARCHAR(16),
			`password` VARCHAR(40),
            `salt` VARCHAR(8),
			`balance` VARCHAR(20) DEFAULT TO_BASE64(0.00),
			`role` ENUM('admin', 'user') DEFAULT 'user'
			)";

		$create_trip_tb_sql = "CREATE TABLE Trips (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`origin` VARCHAR(100),
			`destination` VARCHAR(100),
			`distance` FLOAT,
			`city` VARCHAR(30),
			`car_id` INT UNSIGNED,
			`price` FLOAT(10,2),
			FOREIGN KEY (`car_id`) REFERENCES Cars(`id`)
			)";

		$create_car_tb_sql = "CREATE TABLE Cars (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`model` VARCHAR(20),
			`car_code` VARCHAR(50),
			`description` VARCHAR(255),
			`price` INT,
			`image` VARCHAR(255),
			`available` INT DEFAULT '1'
			)";

		$create_shops_tb_sql = "CREATE TABLE Shops (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`name` VARCHAR(50),
			`category` VARCHAR(10),
			`address` VARCHAR(255),
			`image` VARCHAR(255)
			)";

		$create_flower_tb_sql = "CREATE TABLE Flowers (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`name` VARCHAR(50),
			`store_code` INT UNSIGNED,
			`price` FLOAT(5,2),
			`image` VARCHAR(255),
			FOREIGN KEY (`store_code`) REFERENCES Shops(`id`)
			)";

		$create_coffee_tb_sql = "CREATE TABLE Coffees (
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`name` VARCHAR(50),
			`store_code` INT UNSIGNED,
			`price` FLOAT(5,2),
			`image` VARCHAR(255),
			FOREIGN KEY (`store_code`) REFERENCES Shops(`id`)
			)";

		$insert_shops_tb_sql = "INSERT INTO Shops (`name`, `category`, `address`, `image`)
			VALUES 
			('Starbucks', 'coffeeshop', '2963 Argentia Rd Building C, Mississauga, ON L5N 0A2', '../assets/img/coffeeshop/starbucks.jpg'),
			('Old Mill Flower Shop', 'flowershop', '21 Old Mill Rd, Etobicoke, ON M8X 1G5', '../assets/img/florist/florist.jpg')
			";

		$insert_cars_tb_sql = "INSERT INTO Cars (`model`, `car_code`, `description`, `price`, `image`)
			VALUES 
			('Sienna', '2GCEK133681286853', '2004 Toyota Sienna', '50', '../assets/img/cars/minivan.jpg'),
			('Ram', '1LNHL9FT3DG686611', '2017 Dodge Ram', '70', '../assets/img/cars/pickup.jpg'),
			('Sentra', '1HSHXAHR87J088444', '2020 Nissan Sentra', '40', '../assets/img/cars/sedan.jpg'),
			('Fiat500', '1YVHZ8BHXC5M97182', '2018 Fiat 500', '40', '../assets/img/cars/smart.jpg')
			";

		$insert_coffees_tb_sql = "INSERT INTO Coffees (`name`, `store_code`, `price`, `image`)
			VALUES 
			('Black Cold Brew', '1' , '2.60', '../assets/img/coffee/coldbrew.png'),
			('Matcha Green Tea Latte', '1' , '5', '../assets/img/coffee/matcha_latte.jpg')
			";

		$insert_flowers_tb_sql = "INSERT INTO Flowers (`name`, `store_code`, `price`, `image`)
			VALUES 
			('Bouquet #1', '2' , '260', '../assets/img/flower/bouquet_1.jpg'),
			('Bouquet #2', '2' , '99', '../assets/img/flower/bouquet_2.jpg')
			";

		$queries = [$create_user_tb_sql, $create_car_tb_sql, $create_shops_tb_sql, $create_flower_tb_sql, $create_coffee_tb_sql, $create_trip_tb_sql, $create_orders_tb_sql, $create_review_tb_sql, $create_suggestion_tb_sql, $insert_shops_tb_sql, $insert_cars_tb_sql, $insert_coffees_tb_sql, $insert_flowers_tb_sql];

		foreach($queries as $query) {
			if ($this->conn->query($query) !== true) {
				return $this->conn->error;
			}
		}
		return true;
	}
 }
?>