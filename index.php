<?php
	// Version: 5.1
	// Updated on: 2023-01-28 by Lakshan Rukantha
?>
<?php session_start(); ?>
<?php
	if (!isset($_SESSION['history'])) { $_SESSION['history'] = []; }
	$login_form = '<div class="login">
		<form action="index.php" method="post">
			<h1>Log into localhost</h1>
			<input type="text" name="username" placeholder="User" value="root" autofocus>
			<input type="password" name="password" placeholder="Password">
			<input type="text" name="db" placeholder="Database Name" value="sql_tutorial" readonly>
			<button type="submit" name="login">Log In</button>
		</form>
		</div>';
	if (isset($_POST['login'])) {
		// login process
		$_SESSION['host']   = 'localhost';
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['db_name']  = $_POST['db'];		
	}

	if (isset($_GET['logout'])) {
		$_SESSION = array();
	// 	die('here');
	}

	if (isset($_SESSION['db_name'])) {
		$host 	  =	$_SESSION['host'];
		$username =	$_SESSION['username'];
		$password =	$_SESSION['password'];
		$db_name  =	$_SESSION['db_name'];
		$connection = mysqli_connect($host, $username, $password, $db_name);
		if ($connection) {
			$login_form = '';
		} else {
			$login_form = '<div class="login">
			<form action="index.php" method="post">
				<h1>Log into localhost</h1>
				<h5 class="error">Incorrect Username / Password / Database Name</h5>
				<input type="text" name="username" placeholder="User" value="root" autofocus>
				<input type="password" name="password" placeholder="Password">
				<input type="text" name="db" placeholder="Database Name" value="sql_tutorial">
				<button type="submit" name="login">Log In</button>
			</form>
			</div>';
		}
	}

	$query = '';
	$message = 'Result:';
	$html = '';
	$is_numeric = array();

	$db_data = 
	"CREATE TABLE IF NOT EXISTS `categories` (
	  `category_id` int(11) NOT NULL AUTO_INCREMENT,
	  `category_name` varchar(30) NOT NULL,
	  `description` varchar(100) NOT NULL,
	  PRIMARY KEY (`category_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
	TRUNCATE TABLE `categories`;
	INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
	(1, 'Beverages', 'Soft drinks, coffees, teas, beers, and ales'),
	(2, 'Condiments', 'Sweet and savory sauces, relishes, spreads, and seasonings'),
	(3, 'Confections', 'Desserts, candies, and sweet breads'),
	(4, 'Dairy Products', 'Cheeses'),
	(5, 'Grains/Cereals', 'Breads, crackers, pasta, and cereal'),
	(6, 'Meat/Poultry', 'Prepared meats'),
	(7, 'Produce', 'Dried fruit and bean curd'),
	(8, 'Seafood', 'Seaweed and fish');
	CREATE TABLE IF NOT EXISTS `customers` (
	  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
	  `customer_name` varchar(50) NOT NULL,
	  `contact_name` varchar(50) NOT NULL,
	  `address` varchar(100) NOT NULL,
	  `city` varchar(30) NOT NULL,
	  `postal_code` varchar(15) NULL,
	  `country` varchar(30) NOT NULL,
	  PRIMARY KEY (`customer_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;
	TRUNCATE TABLE `customers`;
	INSERT INTO `customers` (`customer_id`, `customer_name`, `contact_name`, `address`, `city`, `postal_code`, `country`) VALUES
	(1, 'Alfreds Futterkiste', 'Maria Anders', 'Obere Str. 57', 'Berlin', '12209', 'Germany'),
	(2, 'Ana Trujillo Emparedados y helados', 'Ana Trujillo', 'Avda. de la Constitucion 2222', 'Mexico D.F.', '5021', 'Mexico'),
	(3, 'Antonio Moreno Taqueria', 'Antonio Moreno', 'Mataderos 2312', 'Mexico D.F.', '5023', 'Mexico'),
	(4, 'Around the Horn', 'Thomas Hardy', '120 Hanover Sq.', 'London', 'WA1 1DP', 'UK'),
	(5, 'Berglunds snabbkop', 'Christina Berglund', 'Berguvsvagen 8', 'Lulea', 'S-958 22', 'Sweden'),
	(6, 'Blauer See Delikatessen', 'Hanna Moos', 'Forsterstr. 57', 'Mannheim', '68306', 'Germany'),
	(7, 'Blondel pere et fils', 'Frederique Citeaux', '24, place Kleber', 'Strasbourg', '67000', 'France'),
	(8, 'Bolido Comidas preparadas', 'Martin Sommer', 'C/ Araquil, 67', 'Madrid', '28023', 'Spain'),
	(9, 'Bon app''', 'Laurence Lebihans', '12, rue des Bouchers', 'Marseille', '13008', 'France'),
	(10, 'Bottom-Dollar Marketse', 'Elizabeth Lincoln', '23 Tsawassen Blvd.', 'Tsawassen', 'T2F 8M4', 'Canada'),
	(11, 'B''s Beverages', 'Victoria Ashworth', 'Fauntleroy Circus', 'London', 'EC2 5NT', 'UK'),
	(12, 'Cactus Comidas para llevar', 'Patricio Simpson', 'Cerrito 333', 'Buenos Aires', '1010', 'Argentina'),
	(13, 'Centro comercial Moctezuma', 'Francisco Chang', 'Sierras de Granada 9993', 'Mexico D.F.', '5022', 'Mexico'),
	(14, 'Chop-suey Chinese', 'Yang Wang', 'Hauptstr. 29', 'Bern', '3012', 'Switzerland'),
	(15, 'Comercio Mineiro', 'Pedro Afonso', 'Av. dos Lusiadas, 23', 'Sao Paulo', '05432-043', 'Brazil'),
	(16, 'Consolidated Holdings', 'Elizabeth Brown', 'Berkeley Gardens 12 Brewery', 'London', 'WX1 6LT', 'UK'),
	(17, 'Drachenblut Delikatessend', 'Sven Ottlieb', 'Walserweg 21', 'Aachen', '52066', 'Germany'),
	(18, 'Du monde entier', 'Janine Labrune', '67, rue des Cinquante Otages', 'Nantes', '44000', 'France'),
	(19, 'Eastern Connection', 'Ann Devon', '35 King George', 'London', 'WX3 6FW', 'UK'),
	(20, 'Ernst Handel', 'Roland Mendel', 'Kirchgasse 6', 'Graz', '8010', 'Austria'),
	(21, 'Familia Arquibaldo', 'Aria Cruz', 'Rua Oros, 92', 'Sao Paulo', '05442-030', 'Brazil'),
	(22, 'FISSA Fabrica Inter. Salchichas S.A.', 'Diego Roel', 'C/ Moralzarzal, 86', 'Madrid', '28034', 'Spain'),
	(23, 'Folies gourmandes', 'Martine Rance', '184, chaussee de Tournai', 'Lille', '59000', 'France'),
	(24, 'Folk och fa HB', 'Maria Larsson', 'Akergatan 24', 'Bracke', 'S-844 67', 'Sweden'),
	(25, 'Frankenversand', 'Peter Franken', 'Berliner Platz 43', 'Munchen', '80805', 'Germany'),
	(26, 'France restauration', 'Carine Schmitt', '54, rue Royale', 'Nantes', '44000', 'France'),
	(27, 'Franchi S.p.A.', 'Paolo Accorti', 'Via Monte Bianco 34', 'Torino', '10100', 'Italy'),
	(28, 'Furia Bacalhau e Frutos do Mar', 'Lino Rodriguez', 'Jardim das rosas n. 32', 'Lisboa', '1675', 'Portugal'),
	(29, 'Galeria del gastronomo', 'Eduardo Saavedra', 'Rambla de Cataluna, 23', 'Barcelona', '8022', 'Spain'),
	(30, 'Godos Cocina Tipica', 'Jose Pedro Freyre', 'C/ Romero, 33', 'Sevilla', '41101', 'Spain'),
	(31, 'Gourmet Lanchonetes', 'Andre Fonseca', 'Av. Brasil, 442', 'Campinas', '04876-786', 'Brazil'),
	(32, 'Great Lakes Food Market', 'Howard Snyder', '2732 Baker Blvd.', 'Eugene', '97403', 'USA'),
	(33, 'GROSELLA-Restaurante', 'Manuel Pereira', '5th Ave. Los Palos Grandes', 'Caracas', NULL, 'Venezuela'),
	(34, 'Hanari Carnes', 'Mario Pontes', 'Rua do Paco, 67', 'Rio de Janeiro', '05454-876', 'Brazil'),
	(35, 'HILARION-Abastos', 'Carlos Hernandez', 'Carrera 22 con Ave. Carlos Soublette #8-35', 'San Cristobal', NULL, 'Venezuela'),
	(36, 'Hungry Coyote Import Store', 'Yoshi Latimer', 'City Center Plaza 516 Main St.', 'Elgin', '97827', 'USA'),
	(37, 'Hungry Owl All-Night Grocers', 'Patricia McKenna', '8 Johnstown Road', 'Cork', '', 'Ireland'),
	(38, 'Island Trading', 'Helen Bennett', 'Garden House Crowther Way', 'Cowes', 'PO31 7PJ', 'UK'),
	(39, 'Koniglich Essen', 'Philip Cramer', 'Maubelstr. 90', 'Brandenburg', '14776', 'Germany'),
	(40, 'La corne d''abondance', 'Daniel Tonini', '67, avenue de l''Europe', 'Versailles', '78000', 'France'),
	(41, 'La maison d''Asie', 'Annette Roulet', '1 rue Alsace-Lorraine', 'Toulouse', '31000', 'France'),
	(42, 'Laughing Bacchus Wine Cellars', 'Yoshi Tannamuri', '1900 Oak St.', 'Vancouver', 'V3F 2K1', 'Canada'),
	(43, 'Lazy K Kountry Store', 'John Steel', '12 Orchestra Terrace', 'Walla Walla', '99362', 'USA'),
	(44, 'Lehmanns Marktstand', 'Renate Messner', 'Magazinweg 7', 'Frankfurt a.M.', '60528', 'Germany'),
	(45, 'Let''s Stop N Shop', 'Jaime Yorres', '87 Polk St. Suite 5', 'San Francisco', '94117', 'USA'),
	(46, 'LILA-Supermercado', 'Carlos Gonzalez', 'Carrera 52 con Ave. Bolivar #65-98 Llano Largo', 'Barquisimeto', NULL, 'Venezuela'),
	(47, 'LINO-Delicateses', 'Felipe Izquierdo', 'Ave. 5 de Mayo Porlamar', 'I. de Margarita', NULL, 'Venezuela'),
	(48, 'Lonesome Pine Restaurant', 'Fran Wilson', '89 Chiaroscuro Rd.', 'Portland', '97219', 'USA'),
	(49, 'Magazzini Alimentari Riuniti', 'Giovanni Rovelli', 'Via Ludovico il Moro 22', 'Bergamo', '24100', 'Italy'),
	(50, 'Maison Dewey', 'Catherine Dewey', 'Rue Joseph-Bens 532', 'Bruxelles', 'B-1180', 'Belgium'),
	(51, 'Mere Paillarde', 'Jean Fresniere', '43 rue St. Laurent', 'Montreal', 'H1J 1C3', 'Canada'),
	(52, 'Morgenstern Gesundkost', 'Alexander Feuer', 'Heerstr. 22', 'Leipzig', '4179', 'Germany'),
	(53, 'North/South', 'Simon Crowther', 'South House 300 Queensbridge', 'London', 'SW7 1RZ', 'UK'),
	(54, 'Oceano Atlantico Ltda.', 'Yvonne Moncada', 'Ing. Gustavo Moncada 8585 Piso 20-A', 'Buenos Aires', '1010', 'Argentina'),
	(55, 'Old World Delicatessen', 'Rene Phillips', '2743 Bering St.', 'Anchorage', '99508', 'USA'),
	(56, 'Ottilies Kaseladen', 'Henriette Pfalzheim', 'Mehrheimerstr. 369', 'Koln', '50739', 'Germany'),
	(57, 'Paris specialites', 'Marie Bertrand', '265, boulevard Charonne', 'Paris', '75012', 'France'),
	(58, 'Pericles Comidas clasicas', 'Guillermo Fernandez', 'Calle Dr. Jorge Cash 321', 'Mexico D.F.', '5033', 'Mexico'),
	(59, 'Piccolo und mehr', 'Georg Pipps', 'Geislweg 14', 'Salzburg', '5020', 'Austria'),
	(60, 'Princesa Isabel Vinhoss', 'Isabel de Castro', 'Estrada da saude n. 58', 'Lisboa', '1756', 'Portugal'),
	(61, 'Que Delicia', 'Bernardo Batista', 'Rua da Panificadora, 12', 'Rio de Janeiro', '02389-673', 'Brazil'),
	(62, 'Queen Cozinha', 'Lucia Carvalho', 'Alameda dos Canarios, 891', 'Sao Paulo', '05487-020', 'Brazil'),
	(63, 'QUICK-Stop', 'Horst Kloss', 'Taucherstrabe 10', 'Cunewalde', '1307', 'Germany'),
	(64, 'Rancho grande', 'Sergio Gutierrez', 'Av. del Libertador 900', 'Buenos Aires', '1010', 'Argentina'),
	(65, 'Rattlesnake Canyon Grocery', 'Paula Wilson', '2817 Milton Dr.', 'Albuquerque', '87110', 'USA'),
	(66, 'Reggiani Caseifici', 'Maurizio Moroni', 'Strada Provinciale 124', 'Reggio Emilia', '42100', 'Italy'),
	(67, 'Ricardo Adocicados', 'Janete Limeira', 'Av. Copacabana, 267', 'Rio de Janeiro', '02389-890', 'Brazil'),
	(68, 'Richter Supermarkt', 'Michael Holz', 'Grenzacherweg 237', 'Geneve', '1203', 'Switzerland'),
	(69, 'Romero y tomillo', 'Alejandra Camino', 'Gran Via, 1', 'Madrid', '28001', 'Spain'),
	(70, 'Sante Gourmet', 'Jonas Bergulfsen', 'Erling Skakkes gate 78', 'Stavern', '4110', 'Norway'),
	(71, 'Save-a-lot Markets', 'Jose Pavarotti', '187 Suffolk Ln.', 'Boise', '83720', 'USA'),
	(72, 'Seven Seas Imports', 'Hari Kumar', '90 Wadhurst Rd.', 'London', 'OX15 4NB', 'UK'),
	(73, 'Simons bistro', 'Jytte Petersen', 'Vinbaeltet 34', 'Kobenhavn', '1734', 'Denmark'),
	(74, 'Specialites du monde', 'Dominique Perrier', '25, rue Lauriston', 'Paris', '75016', 'France'),
	(75, 'Split Rail Beer & Ale', 'Art Braunschweiger', 'P.O. Box 555', 'Lander', '82520', 'USA'),
	(76, 'Supremes delices', 'Pascale Cartrain', 'Boulevard Tirou, 255', 'Charleroi', 'B-6000', 'Belgium'),
	(77, 'The Big Cheese', 'Liz Nixon', '89 Jefferson Way Suite 2', 'Portland', '97201', 'USA'),
	(78, 'The Cracker Box', 'Liu Wong', '55 Grizzly Peak Rd.', 'Butte', '59801', 'USA'),
	(79, 'Toms Spezialitaten', 'Karin Josephs', 'Luisenstr. 48', 'Munster', '44087', 'Germany'),
	(80, 'Tortuga Restaurante', 'Miguel Angel Paolino', 'Avda. Azteca 123', 'Mexico D.F.', '5033', 'Mexico'),
	(81, 'Tradicao Hipermercados', 'Anabela Domingues', 'Av. Ines de Castro, 414', 'Sao Paulo', '05634-030', 'Brazil'),
	(82, 'Trail''s Head Gourmet Provisioners', 'Helvetius Nagy', '722 DaVinci Blvd.', 'Kirkland', '98034', 'USA'),
	(83, 'Vaffeljernet', 'Palle Ibsen', 'Smagsloget 45', 'arhus', '8200', 'Denmark'),
	(84, 'Victuailles en stock', 'Mary Saveley', '2, rue du Commerce', 'Lyon', '69004', 'France'),
	(85, 'Vins et alcools Chevalier', 'Paul Henriot', '59 rue de l''Abbaye', 'Reims', '51100', 'France'),
	(86, 'Die Wandernde Kuh', 'Rita Muller', 'Adenauerallee 900', 'Stuttgart', '70563', 'Germany'),
	(87, 'Wartian Herkku', 'Pirkko Koskitalo', 'Torikatu 38', 'Oulu', '90110', 'Finland'),
	(88, 'Wellington Importadora', 'Paula Parente', 'Rua do Mercado, 12', 'Resende', '08737-363', 'Brazil'),
	(89, 'White Clover Markets', 'Karl Jablonski', '305 - 14th Ave. S. Suite 3B', 'Seattle', '98128', 'USA'),
	(90, 'Wilman Kala', 'Matti Karttunen', 'Keskuskatu 45', 'Helsinki', '21240', 'Finland'),
	(91, 'Wolski', 'Zbyszek', 'ul. Filtrowa 68', 'Walla', '01-012', 'Poland');
	CREATE TABLE IF NOT EXISTS `employees` (
	  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
	  `last_name` varchar(50) NOT NULL,
	  `first_name` varchar(30) NOT NULL,
	  `date_of_birth` date NOT NULL,
	  `gender` varchar(1) NOT NULL,
	  `notes` text NOT NULL,
	  PRIMARY KEY (`employee_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
	TRUNCATE TABLE `employees`;
	INSERT INTO `employees` (`employee_id`, `last_name`, `first_name`, `date_of_birth`, `gender`, `notes`) VALUES
	(1, 'Davolio', 'Nancy', '1968-12-08', 'F', 'Education includes a BA in psychology from Colorado State University. She also completed (The Art of the Cold Call). Nancy is a member of ''Toastmasters International''.'),
	(2, 'Fuller', 'Andrew', '1952-02-19', 'M', 'Andrew received his BTS commercial and a Ph.D. in international marketing from the University of Dallas. He is fluent in French and Italian and reads German. He joined the company as a sales representative, was promoted to sales manager and was then named vice president of sales. Andrew is a member of the Sales Management Roundtable, the Seattle Chamber of Commerce, and the Pacific Rim Importers Association.'),
	(3, 'Leverling', 'Janet', '1963-08-30', 'F', 'Janet has a BS degree in chemistry from Boston College). She has also completed a certificate program in food retailing management. Janet was hired as a sales associate and was promoted to sales representative.'),
	(4, 'Peacock', 'Margaret', '1958-09-19', 'F', 'Margaret holds a BA in English literature from Concordia College and an MA from the American Institute of Culinary Arts. She was temporarily assigned to the London office before returning to her permanent post in Seattle.'),
	(5, 'Buchanan', 'Steven', '1955-03-04', 'M', 'Steven Buchanan graduated from St. Andrews University, Scotland, with a BSC degree. Upon joining the company as a sales representative, he spent 6 months in an orientation program at the Seattle office and then returned to his permanent post in London, where he was promoted to sales manager. Mr. Buchanan has completed the courses ''Successful Telemarketing'' and ''International Sales Management''. He is fluent in French.'),
	(6, 'Suyama', 'Michael', '1963-07-02', 'M', 'Michael is a graduate of Sussex University (MA, economics) and the University of California at Los Angeles (MBA, marketing). He has also taken the courses ''Multi-Cultural Selling'' and ''Time Management for the Sales Professional''. He is fluent in Japanese and can read and write French, Portuguese, and Spanish.'),
	(7, 'King', 'Robert', '1960-05-29', 'M', 'Robert King served in the Peace Corps and traveled extensively before completing his degree in English at the University of Michigan and then joining the company. After completing a course entitled ''Selling in Europe'', he was transferred to the London office.'),
	(8, 'Callahan', 'Laura', '1958-01-09', 'F', 'Laura received a BA in psychology from the University of Washington. She has also completed a course in business French. She reads and writes French.'),
	(9, 'Dodsworth', 'Anne', '1969-07-02', 'F', 'Anne has a BA degree in English from St. Lawrence College. She is fluent in French and German.'),
	(10, 'West', 'Adam', '1928-09-19', 'M', 'An old chum.');
	CREATE TABLE IF NOT EXISTS `orders` (
	  `order_id` int(11) NOT NULL AUTO_INCREMENT,
	  `customer_id` int(11) NOT NULL,
	  `employee_id` int(11) NOT NULL,
	  `order_date` date NOT NULL,
	  `shipper_id` int(11) NOT NULL,
	  PRIMARY KEY (`order_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10444 ;
	TRUNCATE TABLE `orders`;
	INSERT INTO `orders` (`order_id`, `customer_id`, `employee_id`, `order_date`, `shipper_id`) VALUES
	(10248, 90, 5, '1996-07-04', 3),
	(10249, 81, 6, '1996-07-05', 1),
	(10250, 34, 4, '1996-07-08', 2),
	(10251, 84, 3, '1996-07-08', 1),
	(10252, 76, 4, '1996-07-09', 2),
	(10253, 34, 3, '1996-07-10', 2),
	(10254, 14, 5, '1996-07-11', 2),
	(10255, 68, 9, '1996-07-12', 3),
	(10256, 88, 3, '1996-07-15', 2),
	(10257, 35, 4, '1996-07-16', 3),
	(10258, 20, 1, '1996-07-17', 1),
	(10259, 13, 4, '1996-07-18', 3),
	(10260, 55, 4, '1996-07-19', 1),
	(10261, 61, 4, '1996-07-19', 2),
	(10262, 65, 8, '1996-07-22', 3),
	(10263, 20, 9, '1996-07-23', 3),
	(10264, 24, 6, '1996-07-24', 3),
	(10265, 7, 2, '1996-07-25', 1),
	(10266, 87, 3, '1996-07-26', 3),
	(10267, 25, 4, '1996-07-29', 1),
	(10268, 33, 8, '1996-07-30', 3),
	(10269, 89, 5, '1996-07-31', 1),
	(10270, 87, 1, '1996-08-01', 1),
	(10271, 75, 6, '1996-08-01', 2),
	(10272, 65, 6, '1996-08-02', 2),
	(10273, 63, 3, '1996-08-05', 3),
	(10274, 85, 6, '1996-08-06', 1),
	(10275, 49, 1, '1996-08-07', 1),
	(10276, 80, 8, '1996-08-08', 3),
	(10277, 52, 2, '1996-08-09', 3),
	(10278, 5, 8, '1996-08-12', 2),
	(10279, 44, 8, '1996-08-13', 2),
	(10280, 5, 2, '1996-08-14', 1),
	(10281, 69, 4, '1996-08-14', 1),
	(10282, 69, 4, '1996-08-15', 1),
	(10283, 46, 3, '1996-08-16', 3),
	(10284, 44, 4, '1996-08-19', 1),
	(10285, 63, 1, '1996-08-20', 2),
	(10286, 63, 8, '1996-08-21', 3),
	(10287, 67, 8, '1996-08-22', 3),
	(10288, 66, 4, '1996-08-23', 1),
	(10289, 11, 7, '1996-08-26', 3),
	(10290, 15, 8, '1996-08-27', 1),
	(10291, 61, 6, '1996-08-27', 2),
	(10292, 81, 1, '1996-08-28', 2),
	(10293, 80, 1, '1996-08-29', 3),
	(10294, 65, 4, '1996-08-30', 2),
	(10295, 85, 2, '1996-09-02', 2),
	(10296, 46, 6, '1996-09-03', 1),
	(10297, 7, 5, '1996-09-04', 2),
	(10298, 37, 6, '1996-09-05', 2),
	(10299, 67, 4, '1996-09-06', 2),
	(10300, 49, 2, '1996-09-09', 2),
	(10301, 86, 8, '1996-09-09', 2),
	(10302, 76, 4, '1996-09-10', 2),
	(10303, 30, 7, '1996-09-11', 2),
	(10304, 80, 1, '1996-09-12', 2),
	(10305, 55, 8, '1996-09-13', 3),
	(10306, 69, 1, '1996-09-16', 3),
	(10307, 48, 2, '1996-09-17', 2),
	(10308, 2, 7, '1996-09-18', 3),
	(10309, 37, 3, '1996-09-19', 1),
	(10310, 77, 8, '1996-09-20', 2),
	(10311, 18, 1, '1996-09-20', 3),
	(10312, 86, 2, '1996-09-23', 2),
	(10313, 63, 2, '1996-09-24', 2),
	(10314, 65, 1, '1996-09-25', 2),
	(10315, 38, 4, '1996-09-26', 2),
	(10316, 65, 1, '1996-09-27', 3),
	(10317, 48, 6, '1996-09-30', 1),
	(10318, 38, 8, '1996-10-01', 2),
	(10319, 80, 7, '1996-10-02', 3),
	(10320, 87, 5, '1996-10-03', 3),
	(10321, 38, 3, '1996-10-03', 2),
	(10322, 58, 7, '1996-10-04', 3),
	(10323, 39, 4, '1996-10-07', 1),
	(10324, 71, 9, '1996-10-08', 1),
	(10325, 39, 1, '1996-10-09', 3),
	(10326, 8, 4, '1996-10-10', 2),
	(10327, 24, 2, '1996-10-11', 1),
	(10328, 28, 4, '1996-10-14', 3),
	(10329, 75, 4, '1996-10-15', 2),
	(10330, 46, 3, '1996-10-16', 1),
	(10331, 9, 9, '1996-10-16', 1),
	(10332, 51, 3, '1996-10-17', 2),
	(10333, 87, 5, '1996-10-18', 3),
	(10334, 84, 8, '1996-10-21', 2),
	(10335, 37, 7, '1996-10-22', 2),
	(10336, 60, 7, '1996-10-23', 2),
	(10337, 25, 4, '1996-10-24', 3),
	(10338, 55, 4, '1996-10-25', 3),
	(10339, 51, 2, '1996-10-28', 2),
	(10340, 9, 1, '1996-10-29', 3),
	(10341, 73, 7, '1996-10-29', 3),
	(10342, 25, 4, '1996-10-30', 2),
	(10343, 44, 4, '1996-10-31', 1),
	(10344, 89, 4, '1996-11-01', 2),
	(10345, 63, 2, '1996-11-04', 2),
	(10346, 65, 3, '1996-11-05', 3),
	(10347, 21, 4, '1996-11-06', 3),
	(10348, 86, 4, '1996-11-07', 2),
	(10349, 75, 7, '1996-11-08', 1),
	(10350, 41, 6, '1996-11-11', 2),
	(10351, 20, 1, '1996-11-11', 1),
	(10352, 28, 3, '1996-11-12', 3),
	(10353, 59, 7, '1996-11-13', 3),
	(10354, 58, 8, '1996-11-14', 3),
	(10355, 4, 6, '1996-11-15', 1),
	(10356, 86, 6, '1996-11-18', 2),
	(10357, 46, 1, '1996-11-19', 3),
	(10358, 41, 5, '1996-11-20', 1),
	(10359, 72, 5, '1996-11-21', 3),
	(10360, 7, 4, '1996-11-22', 3),
	(10361, 63, 1, '1996-11-22', 2),
	(10362, 9, 3, '1996-11-25', 1),
	(10363, 17, 4, '1996-11-26', 3),
	(10364, 19, 1, '1996-11-26', 1),
	(10365, 3, 3, '1996-11-27', 2),
	(10366, 29, 8, '1996-11-28', 2),
	(10367, 83, 7, '1996-11-28', 3),
	(10368, 20, 2, '1996-11-29', 2),
	(10369, 75, 8, '1996-12-02', 2),
	(10370, 14, 6, '1996-12-03', 2),
	(10371, 41, 1, '1996-12-03', 1),
	(10372, 62, 5, '1996-12-04', 2),
	(10373, 37, 4, '1996-12-05', 3),
	(10374, 91, 1, '1996-12-05', 3),
	(10375, 36, 3, '1996-12-06', 2),
	(10376, 51, 1, '1996-12-09', 2),
	(10377, 72, 1, '1996-12-09', 3),
	(10378, 24, 5, '1996-12-10', 3),
	(10379, 61, 2, '1996-12-11', 1),
	(10380, 37, 8, '1996-12-12', 3),
	(10381, 46, 3, '1996-12-12', 3),
	(10382, 20, 4, '1996-12-13', 1),
	(10383, 4, 8, '1996-12-16', 3),
	(10384, 5, 3, '1996-12-16', 3),
	(10385, 75, 1, '1996-12-17', 2),
	(10386, 21, 9, '1996-12-18', 3),
	(10387, 70, 1, '1996-12-18', 2),
	(10388, 72, 2, '1996-12-19', 1),
	(10389, 10, 4, '1996-12-20', 2),
	(10390, 20, 6, '1996-12-23', 1),
	(10391, 17, 3, '1996-12-23', 3),
	(10392, 59, 2, '1996-12-24', 3),
	(10393, 71, 1, '1996-12-25', 3),
	(10394, 36, 1, '1996-12-25', 3),
	(10395, 35, 6, '1996-12-26', 1),
	(10396, 25, 1, '1996-12-27', 3),
	(10397, 60, 5, '1996-12-27', 1),
	(10398, 71, 2, '1996-12-30', 3),
	(10399, 83, 8, '1996-12-31', 3),
	(10400, 19, 1, '1997-01-01', 3),
	(10401, 65, 1, '1997-01-01', 1),
	(10402, 20, 8, '1997-01-02', 2),
	(10403, 20, 4, '1997-01-03', 3),
	(10404, 49, 2, '1997-01-03', 1),
	(10405, 47, 1, '1997-01-06', 1),
	(10406, 62, 7, '1997-01-07', 1),
	(10407, 56, 2, '1997-01-07', 2),
	(10408, 23, 8, '1997-01-08', 1),
	(10409, 54, 3, '1997-01-09', 1),
	(10410, 10, 3, '1997-01-10', 3),
	(10411, 10, 9, '1997-01-10', 3),
	(10412, 87, 8, '1997-01-13', 2),
	(10413, 41, 3, '1997-01-14', 2),
	(10414, 21, 2, '1997-01-14', 3),
	(10415, 36, 3, '1997-01-15', 1),
	(10416, 87, 8, '1997-01-16', 3),
	(10417, 73, 4, '1997-01-16', 3),
	(10418, 63, 4, '1997-01-17', 1),
	(10419, 68, 4, '1997-01-20', 2),
	(10420, 88, 3, '1997-01-21', 1),
	(10421, 61, 8, '1997-01-21', 1),
	(10422, 27, 2, '1997-01-22', 1),
	(10423, 31, 6, '1997-01-23', 3),
	(10424, 51, 7, '1997-01-23', 2),
	(10425, 41, 6, '1997-01-24', 2),
	(10426, 29, 4, '1997-01-27', 1),
	(10427, 59, 4, '1997-01-27', 2),
	(10428, 66, 7, '1997-01-28', 1),
	(10429, 37, 3, '1997-01-29', 2),
	(10430, 20, 4, '1997-01-30', 1),
	(10431, 10, 4, '1997-01-30', 2),
	(10432, 75, 3, '1997-01-31', 2),
	(10433, 60, 3, '1997-02-03', 3),
	(10434, 24, 3, '1997-02-03', 2),
	(10435, 16, 8, '1997-02-04', 2),
	(10436, 7, 3, '1997-02-05', 2),
	(10437, 87, 8, '1997-02-05', 1),
	(10438, 79, 3, '1997-02-06', 2),
	(10439, 51, 6, '1997-02-07', 3),
	(10440, 71, 4, '1997-02-10', 2),
	(10441, 55, 3, '1997-02-10', 2),
	(10442, 20, 3, '1997-02-11', 2),
	(10443, 66, 8, '1997-02-12', 1);
	CREATE TABLE IF NOT EXISTS `order_details` (
	  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
	  `order_id` int(11) NOT NULL,
	  `product_id` int(11) NOT NULL,
	  `quantity` decimal(11,2) NOT NULL,
	  PRIMARY KEY (`order_detail_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=519 ;
	TRUNCATE TABLE `order_details`;
	INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`) VALUES
	(1, 10248, 11, 12.00),
	(2, 10248, 42, 10.00),
	(3, 10248, 72, 5.00),
	(4, 10249, 14, 9.00),
	(5, 10249, 51, 40.00),
	(6, 10250, 41, 10.00),
	(7, 10250, 51, 35.00),
	(8, 10250, 65, 15.00),
	(9, 10251, 22, 6.00),
	(10, 10251, 57, 15.00),
	(11, 10251, 65, 20.00),
	(12, 10252, 20, 40.00),
	(13, 10252, 33, 25.00),
	(14, 10252, 60, 40.00),
	(15, 10253, 31, 20.00),
	(16, 10253, 39, 42.00),
	(17, 10253, 49, 40.00),
	(18, 10254, 24, 15.00),
	(19, 10254, 55, 21.00),
	(20, 10254, 74, 21.00),
	(21, 10255, 2, 20.00),
	(22, 10255, 16, 35.00),
	(23, 10255, 36, 25.00),
	(24, 10255, 59, 30.00),
	(25, 10256, 53, 15.00),
	(26, 10256, 77, 12.00),
	(27, 10257, 27, 25.00),
	(28, 10257, 39, 6.00),
	(29, 10257, 77, 15.00),
	(30, 10258, 2, 50.00),
	(31, 10258, 5, 65.00),
	(32, 10258, 32, 6.00),
	(33, 10259, 21, 10.00),
	(34, 10259, 37, 1.00),
	(35, 10260, 41, 16.00),
	(36, 10260, 57, 50.00),
	(37, 10260, 62, 15.00),
	(38, 10260, 70, 21.00),
	(39, 10261, 21, 20.00),
	(40, 10261, 35, 20.00),
	(41, 10262, 5, 12.00),
	(42, 10262, 7, 15.00),
	(43, 10262, 56, 2.00),
	(44, 10263, 16, 60.00),
	(45, 10263, 24, 28.00),
	(46, 10263, 30, 60.00),
	(47, 10263, 74, 36.00),
	(48, 10264, 2, 35.00),
	(49, 10264, 41, 25.00),
	(50, 10265, 17, 30.00),
	(51, 10265, 70, 20.00),
	(52, 10266, 12, 12.00),
	(53, 10267, 40, 50.00),
	(54, 10267, 59, 70.00),
	(55, 10267, 76, 15.00),
	(56, 10268, 29, 10.00),
	(57, 10268, 72, 4.00),
	(58, 10269, 33, 60.00),
	(59, 10269, 72, 20.00),
	(60, 10270, 36, 30.00),
	(61, 10270, 43, 25.00),
	(62, 10271, 33, 24.00),
	(63, 10272, 20, 6.00),
	(64, 10272, 31, 40.00),
	(65, 10272, 72, 24.00),
	(66, 10273, 10, 24.00),
	(67, 10273, 31, 15.00),
	(68, 10273, 33, 20.00),
	(69, 10273, 40, 60.00),
	(70, 10273, 76, 33.00),
	(71, 10274, 71, 20.00),
	(72, 10274, 72, 7.00),
	(73, 10275, 24, 12.00),
	(74, 10275, 59, 6.00),
	(75, 10276, 10, 15.00),
	(76, 10276, 13, 10.00),
	(77, 10277, 28, 20.00),
	(78, 10277, 62, 12.00),
	(79, 10278, 44, 16.00),
	(80, 10278, 59, 15.00),
	(81, 10278, 63, 8.00),
	(82, 10278, 73, 25.00),
	(83, 10279, 17, 15.00),
	(84, 10280, 24, 12.00),
	(85, 10280, 55, 20.00),
	(86, 10280, 75, 30.00),
	(87, 10281, 19, 1.00),
	(88, 10281, 24, 6.00),
	(89, 10281, 35, 4.00),
	(90, 10282, 30, 6.00),
	(91, 10282, 57, 2.00),
	(92, 10283, 15, 20.00),
	(93, 10283, 19, 18.00),
	(94, 10283, 60, 35.00),
	(95, 10283, 72, 3.00),
	(96, 10284, 27, 15.00),
	(97, 10284, 44, 21.00),
	(98, 10284, 60, 20.00),
	(99, 10284, 67, 5.00),
	(100, 10285, 1, 45.00),
	(101, 10285, 40, 40.00),
	(102, 10285, 53, 36.00),
	(103, 10286, 35, 100.00),
	(104, 10286, 62, 40.00),
	(105, 10287, 16, 40.00),
	(106, 10287, 34, 20.00),
	(107, 10287, 46, 15.00),
	(108, 10288, 54, 10.00),
	(109, 10288, 68, 3.00),
	(110, 10289, 3, 30.00),
	(111, 10289, 64, 9.00),
	(112, 10290, 5, 20.00),
	(113, 10290, 29, 15.00),
	(114, 10290, 49, 15.00),
	(115, 10290, 77, 10.00),
	(116, 10291, 13, 20.00),
	(117, 10291, 44, 24.00),
	(118, 10291, 51, 2.00),
	(119, 10292, 20, 20.00),
	(120, 10293, 18, 12.00),
	(121, 10293, 24, 10.00),
	(122, 10293, 63, 5.00),
	(123, 10293, 75, 6.00),
	(124, 10294, 1, 18.00),
	(125, 10294, 17, 15.00),
	(126, 10294, 43, 15.00),
	(127, 10294, 60, 21.00),
	(128, 10294, 75, 6.00),
	(129, 10295, 56, 4.00),
	(130, 10296, 11, 12.00),
	(131, 10296, 16, 30.00),
	(132, 10296, 69, 15.00),
	(133, 10297, 39, 60.00),
	(134, 10297, 72, 20.00),
	(135, 10298, 2, 40.00),
	(136, 10298, 36, 40.00),
	(137, 10298, 59, 30.00),
	(138, 10298, 62, 15.00),
	(139, 10299, 19, 15.00),
	(140, 10299, 70, 20.00),
	(141, 10300, 66, 30.00),
	(142, 10300, 68, 20.00),
	(143, 10301, 40, 10.00),
	(144, 10301, 56, 20.00),
	(145, 10302, 17, 40.00),
	(146, 10302, 28, 28.00),
	(147, 10302, 43, 12.00),
	(148, 10303, 40, 40.00),
	(149, 10303, 65, 30.00),
	(150, 10303, 68, 15.00),
	(151, 10304, 49, 30.00),
	(152, 10304, 59, 10.00),
	(153, 10304, 71, 2.00),
	(154, 10305, 18, 25.00),
	(155, 10305, 29, 25.00),
	(156, 10305, 39, 30.00),
	(157, 10306, 30, 10.00),
	(158, 10306, 53, 10.00),
	(159, 10306, 54, 5.00),
	(160, 10307, 62, 10.00),
	(161, 10307, 68, 3.00),
	(162, 10308, 69, 1.00),
	(163, 10308, 70, 5.00),
	(164, 10309, 4, 20.00),
	(165, 10309, 6, 30.00),
	(166, 10309, 42, 2.00),
	(167, 10309, 43, 20.00),
	(168, 10309, 71, 3.00),
	(169, 10310, 16, 10.00),
	(170, 10310, 62, 5.00),
	(171, 10311, 42, 6.00),
	(172, 10311, 69, 7.00),
	(173, 10312, 28, 4.00),
	(174, 10312, 43, 24.00),
	(175, 10312, 53, 20.00),
	(176, 10312, 75, 10.00),
	(177, 10313, 36, 12.00),
	(178, 10314, 32, 40.00),
	(179, 10314, 58, 30.00),
	(180, 10314, 62, 25.00),
	(181, 10315, 34, 14.00),
	(182, 10315, 70, 30.00),
	(183, 10316, 41, 10.00),
	(184, 10316, 62, 70.00),
	(185, 10317, 1, 20.00),
	(186, 10318, 41, 20.00),
	(187, 10318, 76, 6.00),
	(188, 10319, 17, 8.00),
	(189, 10319, 28, 14.00),
	(190, 10319, 76, 30.00),
	(191, 10320, 71, 30.00),
	(192, 10321, 35, 10.00),
	(193, 10322, 52, 20.00),
	(194, 10323, 15, 5.00),
	(195, 10323, 25, 4.00),
	(196, 10323, 39, 4.00),
	(197, 10324, 16, 21.00),
	(198, 10324, 35, 70.00),
	(199, 10324, 46, 30.00),
	(200, 10324, 59, 40.00),
	(201, 10324, 63, 80.00),
	(202, 10325, 6, 6.00),
	(203, 10325, 13, 12.00),
	(204, 10325, 14, 9.00),
	(205, 10325, 31, 4.00),
	(206, 10325, 72, 40.00),
	(207, 10326, 4, 24.00),
	(208, 10326, 57, 16.00),
	(209, 10326, 75, 50.00),
	(210, 10327, 2, 25.00),
	(211, 10327, 11, 50.00),
	(212, 10327, 30, 35.00),
	(213, 10327, 58, 30.00),
	(214, 10328, 59, 9.00),
	(215, 10328, 65, 40.00),
	(216, 10328, 68, 10.00),
	(217, 10329, 19, 10.00),
	(218, 10329, 30, 8.00),
	(219, 10329, 38, 20.00),
	(220, 10329, 56, 12.00),
	(221, 10330, 26, 50.00),
	(222, 10330, 72, 25.00),
	(223, 10331, 54, 15.00),
	(224, 10332, 18, 40.00),
	(225, 10332, 42, 10.00),
	(226, 10332, 47, 16.00),
	(227, 10333, 14, 10.00),
	(228, 10333, 21, 10.00),
	(229, 10333, 71, 40.00),
	(230, 10334, 52, 8.00),
	(231, 10334, 68, 10.00),
	(232, 10335, 2, 7.00),
	(233, 10335, 31, 25.00),
	(234, 10335, 32, 6.00),
	(235, 10335, 51, 48.00),
	(236, 10336, 4, 18.00),
	(237, 10337, 23, 40.00),
	(238, 10337, 26, 24.00),
	(239, 10337, 36, 20.00),
	(240, 10337, 37, 28.00),
	(241, 10337, 72, 25.00),
	(242, 10338, 17, 20.00),
	(243, 10338, 30, 15.00),
	(244, 10339, 4, 10.00),
	(245, 10339, 17, 70.00),
	(246, 10339, 62, 28.00),
	(247, 10340, 18, 20.00),
	(248, 10340, 41, 12.00),
	(249, 10340, 43, 40.00),
	(250, 10341, 33, 8.00),
	(251, 10341, 59, 9.00),
	(252, 10342, 2, 24.00),
	(253, 10342, 31, 56.00),
	(254, 10342, 36, 40.00),
	(255, 10342, 55, 40.00),
	(256, 10343, 64, 50.00),
	(257, 10343, 68, 4.00),
	(258, 10343, 76, 15.00),
	(259, 10344, 4, 35.00),
	(260, 10344, 8, 70.00),
	(261, 10345, 8, 70.00),
	(262, 10345, 19, 80.00),
	(263, 10345, 42, 9.00),
	(264, 10346, 17, 36.00),
	(265, 10346, 56, 20.00),
	(266, 10347, 25, 10.00),
	(267, 10347, 39, 50.00),
	(268, 10347, 40, 4.00),
	(269, 10347, 75, 6.00),
	(270, 10348, 1, 15.00),
	(271, 10348, 23, 25.00),
	(272, 10349, 54, 24.00),
	(273, 10350, 50, 15.00),
	(274, 10350, 69, 18.00),
	(275, 10351, 38, 20.00),
	(276, 10351, 41, 13.00),
	(277, 10351, 44, 77.00),
	(278, 10351, 65, 10.00),
	(279, 10352, 24, 10.00),
	(280, 10352, 54, 20.00),
	(281, 10353, 11, 12.00),
	(282, 10353, 38, 50.00),
	(283, 10354, 1, 12.00),
	(284, 10354, 29, 4.00),
	(285, 10355, 24, 25.00),
	(286, 10355, 57, 25.00),
	(287, 10356, 31, 30.00),
	(288, 10356, 55, 12.00),
	(289, 10356, 69, 20.00),
	(290, 10357, 10, 30.00),
	(291, 10357, 26, 16.00),
	(292, 10357, 60, 8.00),
	(293, 10358, 24, 10.00),
	(294, 10358, 34, 10.00),
	(295, 10358, 36, 20.00),
	(296, 10359, 16, 56.00),
	(297, 10359, 31, 70.00),
	(298, 10359, 60, 80.00),
	(299, 10360, 28, 30.00),
	(300, 10360, 29, 35.00),
	(301, 10360, 38, 10.00),
	(302, 10360, 49, 35.00),
	(303, 10360, 54, 28.00),
	(304, 10361, 39, 54.00),
	(305, 10361, 60, 55.00),
	(306, 10362, 25, 50.00),
	(307, 10362, 51, 20.00),
	(308, 10362, 54, 24.00),
	(309, 10363, 31, 20.00),
	(310, 10363, 75, 12.00),
	(311, 10363, 76, 12.00),
	(312, 10364, 69, 30.00),
	(313, 10364, 71, 5.00),
	(314, 10365, 11, 24.00),
	(315, 10366, 65, 5.00),
	(316, 10366, 77, 5.00),
	(317, 10367, 34, 36.00),
	(318, 10367, 54, 18.00),
	(319, 10367, 65, 15.00),
	(320, 10367, 77, 7.00),
	(321, 10368, 21, 5.00),
	(322, 10368, 28, 13.00),
	(323, 10368, 57, 25.00),
	(324, 10368, 64, 35.00),
	(325, 10369, 29, 20.00),
	(326, 10369, 56, 18.00),
	(327, 10370, 1, 15.00),
	(328, 10370, 64, 30.00),
	(329, 10370, 74, 20.00),
	(330, 10371, 36, 6.00),
	(331, 10372, 20, 12.00),
	(332, 10372, 38, 40.00),
	(333, 10372, 60, 70.00),
	(334, 10372, 72, 42.00),
	(335, 10373, 58, 80.00),
	(336, 10373, 71, 50.00),
	(337, 10374, 31, 30.00),
	(338, 10374, 58, 15.00),
	(339, 10375, 14, 15.00),
	(340, 10375, 54, 10.00),
	(341, 10376, 31, 42.00),
	(342, 10377, 28, 20.00),
	(343, 10377, 39, 20.00),
	(344, 10378, 71, 6.00),
	(345, 10379, 41, 8.00),
	(346, 10379, 63, 16.00),
	(347, 10379, 65, 20.00),
	(348, 10380, 30, 18.00),
	(349, 10380, 53, 20.00),
	(350, 10380, 60, 6.00),
	(351, 10380, 70, 30.00),
	(352, 10381, 74, 14.00),
	(353, 10382, 5, 32.00),
	(354, 10382, 18, 9.00),
	(355, 10382, 29, 14.00),
	(356, 10382, 33, 60.00),
	(357, 10382, 74, 50.00),
	(358, 10383, 13, 20.00),
	(359, 10383, 50, 15.00),
	(360, 10383, 56, 20.00),
	(361, 10384, 20, 28.00),
	(362, 10384, 60, 15.00),
	(363, 10385, 7, 10.00),
	(364, 10385, 60, 20.00),
	(365, 10385, 68, 8.00),
	(366, 10386, 24, 15.00),
	(367, 10386, 34, 10.00),
	(368, 10387, 24, 15.00),
	(369, 10387, 28, 6.00),
	(370, 10387, 59, 12.00),
	(371, 10387, 71, 15.00),
	(372, 10388, 45, 15.00),
	(373, 10388, 52, 20.00),
	(374, 10388, 53, 40.00),
	(375, 10389, 10, 16.00),
	(376, 10389, 55, 15.00),
	(377, 10389, 62, 20.00),
	(378, 10389, 70, 30.00),
	(379, 10390, 31, 60.00),
	(380, 10390, 35, 40.00),
	(381, 10390, 46, 45.00),
	(382, 10390, 72, 24.00),
	(383, 10391, 13, 18.00),
	(384, 10392, 69, 50.00),
	(385, 10393, 2, 25.00),
	(386, 10393, 14, 42.00),
	(387, 10393, 25, 7.00),
	(388, 10393, 26, 70.00),
	(389, 10393, 31, 32.00),
	(390, 10394, 13, 10.00),
	(391, 10394, 62, 10.00),
	(392, 10395, 46, 28.00),
	(393, 10395, 53, 70.00),
	(394, 10395, 69, 8.00),
	(395, 10396, 23, 40.00),
	(396, 10396, 71, 60.00),
	(397, 10396, 72, 21.00),
	(398, 10397, 21, 10.00),
	(399, 10397, 51, 18.00),
	(400, 10398, 35, 30.00),
	(401, 10398, 55, 120.00),
	(402, 10399, 68, 60.00),
	(403, 10399, 71, 30.00),
	(404, 10399, 76, 35.00),
	(405, 10399, 77, 14.00),
	(406, 10400, 29, 21.00),
	(407, 10400, 35, 35.00),
	(408, 10400, 49, 30.00),
	(409, 10401, 30, 18.00),
	(410, 10401, 56, 70.00),
	(411, 10401, 65, 20.00),
	(412, 10401, 71, 60.00),
	(413, 10402, 23, 60.00),
	(414, 10402, 63, 65.00),
	(415, 10403, 16, 21.00),
	(416, 10403, 48, 70.00),
	(417, 10404, 26, 30.00),
	(418, 10404, 42, 40.00),
	(419, 10404, 49, 30.00),
	(420, 10405, 3, 50.00),
	(421, 10406, 1, 10.00),
	(422, 10406, 21, 30.00),
	(423, 10406, 28, 42.00),
	(424, 10406, 36, 5.00),
	(425, 10406, 40, 2.00),
	(426, 10407, 11, 30.00),
	(427, 10407, 69, 15.00),
	(428, 10407, 71, 15.00),
	(429, 10408, 37, 10.00),
	(430, 10408, 54, 6.00),
	(431, 10408, 62, 35.00),
	(432, 10409, 14, 12.00),
	(433, 10409, 21, 12.00),
	(434, 10410, 33, 49.00),
	(435, 10410, 59, 16.00),
	(436, 10411, 41, 25.00),
	(437, 10411, 44, 40.00),
	(438, 10411, 59, 9.00),
	(439, 10412, 14, 20.00),
	(440, 10413, 1, 24.00),
	(441, 10413, 62, 40.00),
	(442, 10413, 76, 14.00),
	(443, 10414, 19, 18.00),
	(444, 10414, 33, 50.00),
	(445, 10415, 17, 2.00),
	(446, 10415, 33, 20.00),
	(447, 10416, 19, 20.00),
	(448, 10416, 53, 10.00),
	(449, 10416, 57, 20.00),
	(450, 10417, 38, 50.00),
	(451, 10417, 46, 2.00),
	(452, 10417, 68, 36.00),
	(453, 10417, 77, 35.00),
	(454, 10418, 2, 60.00),
	(455, 10418, 47, 55.00),
	(456, 10418, 61, 16.00),
	(457, 10418, 74, 15.00),
	(458, 10419, 60, 60.00),
	(459, 10419, 69, 20.00),
	(460, 10420, 9, 20.00),
	(461, 10420, 13, 2.00),
	(462, 10420, 70, 8.00),
	(463, 10420, 73, 20.00),
	(464, 10421, 19, 4.00),
	(465, 10421, 26, 30.00),
	(466, 10421, 53, 15.00),
	(467, 10421, 77, 10.00),
	(468, 10422, 26, 2.00),
	(469, 10423, 31, 14.00),
	(470, 10423, 59, 20.00),
	(471, 10424, 35, 60.00),
	(472, 10424, 38, 49.00),
	(473, 10424, 68, 30.00),
	(474, 10425, 55, 10.00),
	(475, 10425, 76, 20.00),
	(476, 10426, 56, 5.00),
	(477, 10426, 64, 7.00),
	(478, 10427, 14, 35.00),
	(479, 10428, 46, 20.00),
	(480, 10429, 50, 40.00),
	(481, 10429, 63, 35.00),
	(482, 10430, 17, 45.00),
	(483, 10430, 21, 50.00),
	(484, 10430, 56, 30.00),
	(485, 10430, 59, 70.00),
	(486, 10431, 17, 50.00),
	(487, 10431, 40, 50.00),
	(488, 10431, 47, 30.00),
	(489, 10432, 26, 10.00),
	(490, 10432, 54, 40.00),
	(491, 10433, 56, 28.00),
	(492, 10434, 11, 6.00),
	(493, 10434, 76, 18.00),
	(494, 10435, 2, 10.00),
	(495, 10435, 22, 12.00),
	(496, 10435, 72, 10.00),
	(497, 10436, 46, 5.00),
	(498, 10436, 56, 40.00),
	(499, 10436, 64, 30.00),
	(500, 10436, 75, 24.00),
	(501, 10437, 53, 15.00),
	(502, 10438, 19, 15.00),
	(503, 10438, 34, 20.00),
	(504, 10438, 57, 15.00),
	(505, 10439, 12, 15.00),
	(506, 10439, 16, 16.00),
	(507, 10439, 64, 6.00),
	(508, 10439, 74, 30.00),
	(509, 10440, 2, 45.00),
	(510, 10440, 16, 49.00),
	(511, 10440, 29, 24.00),
	(512, 10440, 61, 90.00),
	(513, 10441, 27, 50.00),
	(514, 10442, 11, 30.00),
	(515, 10442, 54, 80.00),
	(516, 10442, 66, 60.00),
	(517, 10443, 11, 6.00),
	(518, 10443, 28, 12.00);
	CREATE TABLE IF NOT EXISTS `products` (
	  `product_id` int(11) NOT NULL AUTO_INCREMENT,
	  `product_name` varchar(50) NOT NULL,
	  `supplier_id` int(11) NOT NULL,
	  `category_id` int(11) NOT NULL,
	  `unit` varchar(30) NOT NULL,
	  `price` decimal(11,2) NOT NULL,
	  PRIMARY KEY (`product_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;
	TRUNCATE TABLE `products`;
	INSERT INTO `products` (`product_id`, `product_name`, `supplier_id`, `category_id`, `unit`, `price`) VALUES
	(1, 'Chais', 1, 1, '10 boxes x 20 bags', 18.00),
	(2, 'Chang', 1, 1, '24 - 12 oz bottles', 19.00),
	(3, 'Aniseed Syrup', 1, 2, '12 - 550 ml bottles', 10.00),
	(4, 'Chef Anton''s Cajun Seasoning', 2, 2, '48 - 6 oz jars', 22.00),
	(5, 'Chef Anton''s Gumbo Mix', 2, 2, '36 boxes', 21.35),
	(6, 'Grandma''s Boysenberry Spread', 3, 2, '12 - 8 oz jars', 25.00),
	(7, 'Uncle Bob''s Organic Dried Pears', 3, 7, '12 - 1 lb pkgs.', 30.00),
	(8, 'Northwoods Cranberry Sauce', 3, 2, '12 - 12 oz jars', 40.00),
	(9, 'Mishi Kobe Niku', 4, 6, '18 - 500 g pkgs.', 97.00),
	(10, 'Ikura', 4, 8, '12 - 200 ml jars', 31.00),
	(11, 'Queso Cabrales', 5, 4, '1 kg pkg.', 21.00),
	(12, 'Queso Manchego La Pastora', 5, 4, '10 - 500 g pkgs.', 38.00),
	(13, 'Konbu', 6, 8, '2 kg box', 6.00),
	(14, 'Tofu', 6, 7, '40 - 100 g pkgs.', 23.25),
	(15, 'Genen Shouyu', 6, 2, '24 - 250 ml bottles', 15.50),
	(16, 'Pavlova', 7, 3, '32 - 500 g boxes', 17.45),
	(17, 'Alice Mutton', 7, 6, '20 - 1 kg tins', 39.00),
	(18, 'Carnarvon Tigers', 7, 8, '16 kg pkg.', 62.50),
	(19, 'Teatime Chocolate Biscuits', 8, 3, '10 boxes x 12 pieces', 9.20),
	(20, 'Sir Rodney''s Marmalade', 8, 3, '30 gift boxes', 81.00),
	(21, 'Sir Rodney''s Scones', 8, 3, '24 pkgs. x 4 pieces', 10.00),
	(22, 'Gustaf''s Knackebrod', 9, 5, '24 - 500 g pkgs.', 21.00),
	(23, 'Tunnbrod', 9, 5, '12 - 250 g pkgs.', 9.00),
	(24, 'Guarana Fantastica', 10, 1, '12 - 355 ml cans', 4.50),
	(25, 'NuNuCa Nub-Nougat-Creme', 11, 3, '20 - 450 g glasses', 14.00),
	(26, 'Gumbar Gummibarchen', 11, 3, '100 - 250 g bags', 31.23),
	(27, 'Schoggi Schokolade', 11, 3, '100 - 100 g pieces', 43.90),
	(28, 'Rossle Sauerkraut', 12, 7, '25 - 825 g cans', 45.60),
	(29, 'Thuringer Rostbratwurst', 12, 6, '50 bags x 30 sausgs.', 123.79),
	(30, 'Nord-Ost Matjeshering', 13, 8, '10 - 200 g glasses', 25.89),
	(31, 'Gorgonzola Telino', 14, 4, '12 - 100 g pkgs', 12.50),
	(32, 'Mascarpone Fabioli', 14, 4, '24 - 200 g pkgs.', 32.00),
	(33, 'Geitost', 15, 4, '500 g', 2.50),
	(34, 'Sasquatch Ale', 16, 1, '24 - 12 oz bottles', 14.00),
	(35, 'Steeleye Stout', 16, 1, '24 - 12 oz bottles', 18.00),
	(36, 'Inlagd Sill', 17, 8, '24 - 250 g jars', 19.00),
	(37, 'Gravad lax', 17, 8, '12 - 500 g pkgs.', 26.00),
	(38, 'Cote de Blaye', 18, 1, '12 - 75 cl bottles', 263.50),
	(39, 'Chartreuse verte', 18, 1, '750 cc per bottle', 18.00),
	(40, 'Boston Crab Meat', 19, 8, '24 - 4 oz tins', 18.40),
	(41, 'Jack''s New England Clam Chowder', 19, 8, '12 - 12 oz cans', 9.65),
	(42, 'Singaporean Hokkien Fried Mee', 20, 5, '32 - 1 kg pkgs.', 14.00),
	(43, 'Ipoh Coffee', 20, 1, '16 - 500 g tins', 46.00),
	(44, 'Gula Malacca', 20, 2, '20 - 2 kg bags', 19.45),
	(45, 'Rogede sild', 21, 8, '1k pkg.', 9.50),
	(46, 'Spegesild', 21, 8, '4 - 450 g glasses', 12.00),
	(47, 'Zaanse koeken', 22, 3, '10 - 4 oz boxes', 9.50),
	(48, 'Chocolade', 22, 3, '10 pkgs.', 12.75),
	(49, 'Maxilaku', 23, 3, '24 - 50 g pkgs.', 20.00),
	(50, 'Valkoinen suklaa', 23, 3, '12 - 100 g bars', 16.25),
	(51, 'Manjimup Dried Apples', 24, 7, '50 - 300 g pkgs.', 53.00),
	(52, 'Filo Mix', 24, 5, '16 - 2 kg boxes', 7.00),
	(53, 'Perth Pasties', 24, 6, '48 pieces', 32.80),
	(54, 'Tourtiere', 25, 6, '16 pies', 7.45),
	(55, 'Pate chinois', 25, 6, '24 boxes x 2 pies', 24.00),
	(56, 'Gnocchi di nonna Alice', 26, 5, '24 - 250 g pkgs.', 38.00),
	(57, 'Ravioli Angelo', 26, 5, '24 - 250 g pkgs.', 19.50),
	(58, 'Escargots de Bourgogne', 27, 8, '24 pieces', 13.25),
	(59, 'Raclette Courdavault', 28, 4, '5 kg pkg.', 55.00),
	(60, 'Camembert Pierrot', 28, 4, '15 - 300 g rounds', 34.00),
	(61, 'Sirop d''erable', 29, 2, '24 - 500 ml bottles', 28.50),
	(62, 'Tarte au sucre', 29, 3, '48 pies', 49.30),
	(63, 'Vegie-spread', 7, 2, '15 - 625 g jars', 43.90),
	(64, 'Wimmers gute Semmelknodel', 12, 5, '20 bags x 4 pieces', 33.25),
	(65, 'Louisiana Fiery Hot Pepper Sauce', 2, 2, '32 - 8 oz bottles', 21.05),
	(66, 'Louisiana Hot Spiced Okra', 2, 2, '24 - 8 oz jars', 17.00),
	(67, 'Laughing Lumberjack Lager', 16, 1, '24 - 12 oz bottles', 14.00),
	(68, 'Scottish Longbreads', 8, 3, '10 boxes x 8 pieces', 12.50),
	(69, 'Gudbrandsdalsost', 15, 4, '10 kg pkg.', 36.00),
	(70, 'Outback Lager', 7, 1, '24 - 355 ml bottles', 15.00),
	(71, 'Flotemysost', 15, 4, '10 - 500 g pkgs.', 21.50),
	(72, 'Mozzarella di Giovanni', 14, 4, '24 - 200 g pkgs.', 34.80),
	(73, 'Rod Kaviar', 17, 8, '24 - 150 g jars', 15.00),
	(74, 'Longlife Tofu', 4, 7, '5 kg pkg.', 10.00),
	(75, 'Rhonbrau Klosterbier', 12, 1, '24 - 0.5 l bottles', 7.75),
	(76, 'Lakkalikoori', 23, 1, '500 ml', 18.00),
	(77, 'Original Frankfurter grune Sobe', 12, 2, '12 boxes', 13.00);
	CREATE TABLE IF NOT EXISTS `shippers` (
	  `shipper_id` int(11) NOT NULL AUTO_INCREMENT,
	  `shipper_name` varchar(50) NOT NULL,
	  `phone` varchar(30) NOT NULL,
	  PRIMARY KEY (`shipper_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
	TRUNCATE TABLE `shippers`;
	INSERT INTO `shippers` (`shipper_id`, `shipper_name`, `phone`) VALUES
	(1, 'Speedy Express', '(503) 555-9831'),
	(2, 'United Package', '(503) 555-3199'),
	(3, 'Federal Shipping', '(503) 555-9931');
	CREATE TABLE IF NOT EXISTS `suppliers` (
	  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
	  `supplier_name` varchar(50) NOT NULL,
	  `contact_name` varchar(50) NOT NULL,
	  `address` varchar(100) NOT NULL,
	  `city` varchar(30) NOT NULL,
	  `postal_code` varchar(15) NULL,
	  `country` varchar(30) NOT NULL,
	  `phone` varchar(30) NOT NULL,
	  PRIMARY KEY (`supplier_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;
	TRUNCATE TABLE `suppliers`;
	INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `contact_name`, `address`, `city`, `postal_code`, `country`, `phone`) VALUES
	(1, 'Exotic Liquid', 'Charlotte Cooper', '49 Gilbert St.', 'Londona', 'EC1 4SD', 'UK', '(171) 555-2222'),
	(2, 'New Orleans Cajun Delights', 'Shelley Burke', 'P.O. Box 78934', 'New Orleans', '70117', 'USA', '(100) 555-4822'),
	(3, 'Grandma Kelly''s Homestead', 'Regina Murphy', '707 Oxford Rd.', 'Ann Arbor', '48104', 'USA', '(313) 555-5735'),
	(4, 'Tokyo Traders', 'Yoshi Nagase', '9-8 Sekimai Musashino-shi', 'Tokyo', '100', 'Japan', '(03) 3555-5011'),
	(5, 'Cooperativa de Quesos ''Las Cabras''', 'Antonio del Valle Saavedra', 'Calle del Rosal 4', 'Oviedo', '33007', 'Spain', '(98) 598 76 54'),
	(6, 'Mayumi''s', 'Mayumi Ohno', '92 Setsuko Chuo-ku', 'Osaka', '545', 'Japan', '(06) 431-7877'),
	(7, 'Pavlova, Ltd.', 'Ian Devling', '74 Rose St. Moonie Ponds', 'Melbourne', '3058', 'Australia', '(03) 444-2343'),
	(8, 'Specialty Biscuits, Ltd.', 'Peter Wilson', '29 King''s Way', 'Manchester', 'M14 GSD', 'UK', '(161) 555-4448'),
	(9, 'PB Knackebrod AB', 'Lars Peterson', 'Kaloadagatan 13', 'Goteborg', 'S-345 67', 'Sweden', '031-987 65 43'),
	(10, 'Refrescos Americanas LTDA', 'Carlos Diaz', 'Av. das Americanas 12.890', 'Sao Paulo', '5442', 'Brazil', '(11) 555 4640'),
	(11, 'Heli Subwaren GmbH & Co. KG', 'Petra Winkler', 'Tiergartenstrabe 5', 'Berlin', '10785', 'Germany', '(010) 9984510'),
	(12, 'Plutzer Lebensmittelgrobmarkte AG', 'Martin Bein', 'Bogenallee 51', 'Frankfurt', '60439', 'Germany', '(069) 992755'),
	(13, 'Nord-Ost-Fisch Handelsgesellschaft mbH', 'Sven Petersen', 'Frahmredder 112a', 'Cuxhaven', '27478', 'Germany', '(04721) 8713'),
	(14, 'Formaggi Fortini s.r.l.', 'Elio Rossi', 'Viale Dante, 75', 'Ravenna', '48100', 'Italy', '(0544) 60323'),
	(15, 'Norske Meierier', 'Beate Vileid', 'Hatlevegen 5', 'Sandvika', '1320', 'Norway', '(0)2-953010'),
	(16, 'Bigfoot Breweries', 'Cheryl Saylor', '3400 - 8th Avenue Suite 210', 'Bend', '97101', 'USA', '(503) 555-9931'),
	(17, 'Svensk Sjofoda AB', 'Michael Bjorn', 'Brovallavagen 231', 'Stockholm', 'S-123 45', 'Sweden', '08-123 45 67'),
	(18, 'Aux joyeux ecclesiastiques', 'Guylene Nodier', '203, Rue des Francs-Bourgeois', 'Paris', '75004', 'France', '(1) 03.83.00.68'),
	(19, 'New England Seafood Cannery', 'Robb Merchant', 'Order Processing Dept. 2100 Paul Revere Blvd.', 'Boston', '2134', 'USA', '(617) 555-3267'),
	(20, 'Leka Trading', 'Chandra Leka', '471 Serangoon Loop, Suite #402', 'Singapore', '512', 'Singapore', '555-8787'),
	(21, 'Lyngbysild', 'Niels Petersen', 'Lyngbysild Fiskebakken 10', 'Lyngby', '2800', 'Denmark', '43844108'),
	(22, 'Zaanse Snoepfabriek', 'Dirk Luchte', 'Verkoop Rijnweg 22', 'Zaandam', '9999 ZZ', 'Netherlands', '(12345) 1212'),
	(23, 'Karkki Oy', 'Anne Heikkonen', 'Valtakatu 12', 'Lappeenranta', '53120', 'Finland', '(953) 10956'),
	(24, 'G''day, Mate', 'Wendy Mackenzie', '170 Prince Edward Parade Hunter''s Hill', 'Sydney', '2042', 'Australia', '(02) 555-5914'),
	(25, 'Ma Maison', 'Jean-Guy Lauzon', '2960 Rue St. Laurent', 'Montreal', 'H1J 1C3', 'Canada', '(514) 555-9022'),
	(26, 'Pasta Buttini s.r.l.', 'Giovanni Giudici', 'Via dei Gelsomini, 153', 'Salerno', '84100', 'Italy', '(089) 6547665'),
	(27, 'Escargots Nouveaux', 'Marie Delamare', '22, rue H. Voiron', 'Montceau', '71300', 'France', '85.57.00.07'),
	(28, 'Gai paturage', 'Eliane Noz', 'Bat. B 3, rue des Alpes', 'Annecy', '74000', 'France', '38.76.98.06'),
	(29, 'Forets d''erables', 'Chantal Goulet', '148 rue Chasseur', 'Ste-Hyacinthe', 'J2S 7S8', 'Canada', '(514) 555-2955');
	";
	if (isset($_POST['restore']) && $_POST['restore_pass'] == 'RESTORE') {
		// checking if the database name is sql_tutorial
		$result_set = mysqli_query($connection, "SELECT DATABASE() current_db");
		$result = mysqli_fetch_assoc($result_set);
		if ($result['current_db'] == 'sql_tutorial') {
			// restore database
			mysqli_multi_query($connection, $db_data);
			$message = 'Database Restored!';
			$query = "SHOW TABLES";
		} else {
			$message = 'Incorrect Database! Please select the Database: sql_tutorial from Login Window.';
		}
	}
	if (isset($_POST['submit'])) {
		if ( strlen($_POST['query']) > 0 ) {
			$query = $_POST['query'];
			$_SESSION['history'][] = $query;
			$result_set = mysqli_query($connection, $query);
			// checking if the result_set has records or boolean value if the query is DML
			if (gettype($result_set) == 'object') {
				$count = mysqli_num_rows($result_set);
				$message = "{$count} record(s)";
				// getting the list of column headings
				$fields = mysqli_fetch_fields($result_set);
				// printing the field names
				$html = '<table>';
				$html .= '<thead>';
				$html .= '<tr>';
				foreach($fields as $field) {
					$html .= '<th>' . $field->name . '</th>';
					$is_numeric[] = true;
				}
				$html .= '</tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				// printing the values of the records
				while ($result = mysqli_fetch_row($result_set)) {
					$html .= '<tr>';
					$index  = 0;
					foreach($result as $val) {
						if (is_null($val)) {
							// check if it is a DESCRIBE TABLE query
							if ( strtoupper(substr($query, 0,7)) == 'DESCRIB' || strtoupper(substr($query, 0,7)) == 'EXPLAIN' ) {
								$html .= '<td class="null">None</td>';
							} else {
								$html .= '<td class="null">NULL</td>';
							}
						} else {
							$html .= '<td>' . $val . '</td>';
						}
						if (!is_numeric($val)) { $is_numeric[$index] = false; }
						$index++;
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				 $html .= '</table>';
				// prepare the css for numeric columns
				$css = '';
				foreach($is_numeric as $i => $column) {
					if ( $column == true ) {
						$css .= "table td:nth-child(" . ($i + 1) . "), th:nth-child(" . ($i + 1) . ")  { text-align: right } "; 
					}
				}
				
			} elseif ($result_set == true) {
				$count = mysqli_affected_rows($connection);
				$message = "{$count} record(s) affected.";
			} else {
				$message = mysqli_error($connection);
			}
	
		} else {
			$message = "Please input your query";
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
	<title>SQL Query WebApp by Lakshan Rukantha</title>
	<style>
		* { margin: 0; padding: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}
		body { font-family: Verdana, Arial, "Helvetica Neue", Helvetica, sans-serif; }		
		h1 { font: 24px Arial, "Helvetica Neue", Helvetica, sans-serif; margin-bottom: 10px; }
		h3 { background: #3a7f94; color: white; font: 20px Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight: normal; padding: 10px; box-shadow: 1px 0 1px 1px #aaa; }
		h4 { background: #FFF162; margin: 0 5px 5px; color: black; font: 18px Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight: normal; padding: 6px 10px; border-radius: 5px }
		h5 { margin: 10px 0; color: red; font: 18px Arial, "Helvetica Neue", Helvetica, sans-serif; font-weight: normal; }
		form.query { width: 100%; padding: 5px; }
		textarea { font-size: 20px; padding: 10px; width: 100%; height: 140px; }
		table { border-collapse: collapse; background: white;  }
		tr:nth-child(even) { background: #eee }
		tr:hover { background: lightgreen }
		th { border: 1px solid #bbb; padding: 10px; background: #ddd; font-size: 18px; position: sticky; top: 0; box-shadow: 1px 1px 1px #aaa; text-align: left}
		td { border-right: 1px solid #ddd; padding: 8px 5px; }
		td.null { font-style: italic; text-align: center; color: #777 }
		p { font-weight: bold; }
		button { padding: 2px 5px 0px; font-weight: bold; text-transform: uppercase; font-size: 16px; }
		.result-container { height: 440px; background: #aaa; border: 2px solid #aaa; margin: 0 5px; }
		.result { height: 100%; overflow: auto; }
		::-webkit-scrollbar { width: 10px; }
		::-webkit-scrollbar-track { background: #f1f1f1; }
		::-webkit-scrollbar-thumb { background: #888; }
		::-webkit-scrollbar-thumb:hover { background: #555; }
		/* login */
		.login { height: 100%; width: 100%; background: #fff; position: fixed; top: 0; left: 0; }
		.login form { margin: 100px auto; width: 600px; }
		.login form input { padding: 5px; font-size: 16px; width: 150px;}
		.login form button { padding: 5px;}
		form.restore { margin: 5px; background: #fff; padding: 4px; box-shadow: 0 1px 1px 1px #aaa; }
		form.restore input { padding: 2px; font-size: 16px; width: 100px; }
		label { font-weight: normal; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;}
		.login h3.error { color: red }
		a.logout { font-size: 14px; padding: 5px 10px; background: #eee; border: 1px solid #aaa; border-radius: 5px; text-transform: uppercase; text-decoration: none;}
		a:hover { color: red; text-decoration: none;}
		button.run:focus::before { content: "\025B6"; padding-right: 5px; color: red; }
		h3 .appname { float: right;}
		h3 .appname small { font-weight: normal; }
/* 		select { display: none } */
		select { padding: 3px; }
		option { padding: 3px;}
	</style>
</head>
<body>
	<?php echo $login_form; ?>
	<h3><b>Database</b>: <?php echo $host; ?> > <?php echo $db_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?logout" class="logout">Log Out</a></a> <span class="appname"><b>SQL Query WebApp</b><small> by Lakshan Rukantha</small> | <small> Version 5</small></span></h3>
	<form action="index.php" method="post" class="query">
		<textarea name="query" id="query" spellcheck="false" autofocus placeholder="Type your SQL Query here..."><?php echo $query; ?></textarea>
		<br>
		<button type="submit" name="submit" class="run">RUN QUERY</button>
		<button name="prev_query" id="prevQry">
			&laquo;
		</button>
		<button name="prev_query" id="nextQry" disabled>
			&raquo;
		</button>
		<select name="query_history" id="queryHistory">
			<option value="">Query History</option>
			<?php
				// preparing query history
				echo "var queryHistory = new Array();\r\n";
// 				$_SESSION['history'] = array_unique($_SESSION['history']);
				foreach($_SESSION['history'] as $entry) {
					echo "<option value=\"\">{$entry}</option>";
				}
			?>
		</select>
	</form>
	<h4><?php echo $message; ?></h4>
	<div class="result-container">
		<div class="result">
			<?php echo $html; ?>
		</div>
	</div>
	<form action="index.php" method="post" class="restore">
		<label for="">Type RESTORE and click Restore Database button to Restore the Database:</label>
		<input type="password" name="restore_pass" placeholder="Password">
		<button type="submit" name="restore">RESTORE DATABASE</button>
		<a href="#" target="_blank">DB Structure</a> 
		&copy; <?php echo '2021'; ?> - <a href="https://lakshanrukantha.github.io" target="_blank">Lakshan Rukantha</a> | 
		<a href="#" target="_blank">Download Latest Version</a>
	</form>
<style>
	<?php echo $css; ?>
</style>
<script>
	var qryHistory = document.querySelector("#queryHistory");
	var query = document.querySelector("#query");
	qryHistory.addEventListener("change", function(e){
		query.value = this.children[this.selectedIndex].outerText;
	});
	
	// checking the item count in the history
	var prevButton = document.querySelector("#prevQry");
	var nextButton = document.querySelector("#nextQry");
	if (qryHistory.length <= 1) {
 		prevButton.disabled = true;
	} else {
		var currentItem;
		if (query.value == "") {
			currentItem = (qryHistory.length);
		} else {
			currentItem = qryHistory.length - 1;
		}
		prevButton.addEventListener("click", function(e){
			e.preventDefault();
			currentItem--;
			query.value = qryHistory.children[currentItem].outerText;
			if (currentItem == 0) {
				this.disabled = true;
			}
			if (currentItem < (queryHistory.length - 1)) {
				nextButton.disabled = false;
			}
// 			console.log("Current item: ", currentItem);
		});
		
		nextButton.addEventListener("click", function(e){
			e.preventDefault();
			currentItem++;
			query.value = qryHistory.children[currentItem].outerText;
			if (currentItem == (qryHistory.length - 1)) {
				this.disabled = true;
				prevButton.disabled = false;
			} else {
				
			}
// 			console.log("Current item: ", currentItem);
		});
	}
	
	
</script>
</body>
</html>