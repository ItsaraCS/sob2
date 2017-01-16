CREATE DATABASE IF NOT EXISTS sob2;

USE sob2;

--
-- Table structure for table menu
--

CREATE TABLE IF NOT EXISTS menu(
	menu_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	menu_name VARCHAR(30) NOT NULL COMMENT 'ชื่อเมนู',
	PRIMARY KEY (menu_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO menu(menu_name) VALUES
('เพิ่มกิจกรรม'),
('ลบกิจกรรม'),
('แก้ไขกิจกรรม'),
('ตั้งค่าสิทธิ์การใช้งาน');

--
-- Table structure for table permission_status
--

CREATE TABLE IF NOT EXISTS permission_status(
	perm_status_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	perm_status VARCHAR(20) NOT NULL COMMENT 'สถานะสิทธิ์การใช้งาน',
	perm_status_name VARCHAR(50) NOT NULL COMMENT 'ชื่อสิทธิ์การใช้งาน',
	PRIMARY KEY (perm_status_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO permission_status(perm_status, perm_status_name) VALUES
('R/W', 'อ่าน/เขียน'),
('R', 'อ่านอย่างเดียว'),
('DN', 'ไม่ให้สิทธิ์');

--
-- Table structure for table users
--

CREATE TABLE IF NOT EXISTS users(
	user_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	username VARCHAR(30) NOT NULL COMMENT 'ชื่อผู้ใช้',
	password VARCHAR(200) NOT NULL COMMENT 'รหัสผ่าน',
	name VARCHAR(30) NOT NULL COMMENT 'ชื่อ',
	email VARCHAR(30) NOT NULL COMMENT 'อีเมล์',
	phone VARCHAR(30) NOT NULL COMMENT 'เบอร์โทรศัพท์',
	position VARCHAR(50) NOT NULL COMMENT 'ตำแหน่ง',
	created TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วัน เวลาที่สมัคร',
	updated TIMESTAMP NULL COMMENT 'วัน เวลาที่แก้ไข',
	user_id_updated int(5) NULL COMMENT 'คีย์ของผู้ที่แก้ไข',
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_id_updated) REFERENCES users(user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users(user_id, username, password, name, email, phone, position) VALUES
('1', 'Admin', '1234', 'Admin', 'itsara.ra.cs@hotmail.com', '0970125090', 'ผู้ดูแลระบบ');

--
-- Table structure for table permission
--

CREATE TABLE IF NOT EXISTS permission(
	perm_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	user_id INT(5) NOT NULL COMMENT 'คีย์ของผู้ใช้งาน',
	menu_id INT(5) NOT NULL COMMENT 'คีย์ของเมนู',
	perm_status_id INT(5) NOT NULL COMMENT 'คีย์สิทธิ์การใช้งาน',
	created TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วัน เวลาที่ตั้งค่าสิทธิ์การใช้งาน',
	updated TIMESTAMP NULL COMMENT 'วัน เวลาที่แก้ไขสิทธิ์การใช้งาน',
	user_id_updated int(5) NULL COMMENT 'คีย์ของผู้ที่แก้ไข',
	PRIMARY KEY (perm_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	FOREIGN KEY (menu_id) REFERENCES menu(menu_id),
	FOREIGN KEY (perm_status_id) REFERENCES permission_status(perm_status_id),
	FOREIGN KEY (user_id_updated) REFERENCES users(user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO permission(user_id, menu_id, perm_status_id) VALUES
('1', '1', '1'),
('1', '2', '1'),
('1', '3', '1'),
('1', '4', '1');

--
-- Table structure for table categories
--

CREATE TABLE IF NOT EXISTS categories(
	category_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	category_name VARCHAR(50) NOT NULL COMMENT 'หมวดหมู่ของกิจกรรม',
	PRIMARY KEY (category_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Categories(category_name) VALUES
('ร้อย ๑ พัน ๒'),
('ร้อย ๒, ร้อย ๓ พัน ๒'),
('ทหารใหม่');

--
-- Table structure for table activities
--

CREATE TABLE IF NOT EXISTS activities(
	activity_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	activity_name VARCHAR(300) NOT NULL COMMENT 'ชื่อกิจกรรม',
	activity_description LONGTEXT NOT NULL COMMENT 'รายละเอียดกิจกรรม',
	activity_date DATE NOT NULL COMMENT 'วัน เวลาที่จัดกิจกรรม',
	created TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วัน เวลาที่บันทึกกิจกรรม',
	updated TIMESTAMP NULL COMMENT 'วัน เวลาที่แก้ไขกิจกรรม',
	category_id INT(5) NOT NULL COMMENT 'คีย์ของหมวดหมู่กิจกรรม',
	user_id INT(5) NOT NULL COMMENT 'คีย์ของผู้ที่แก้ไขกิจกรรม',
	PRIMARY KEY (activity_id),
	FOREIGN KEY (category_id) REFERENCES categories(category_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table activities_images
--

CREATE TABLE IF NOT EXISTS activities_images(
	activity_image_id INT(5) NOT NULL AUTO_INCREMENT COMMENT 'คีย์',
	activity_image_url VARCHAR(50) NOT NULL COMMENT 'ที่อยู่รูปภาพของกิจกรรม',
	activity_id INT(5) NOT NULL COMMENT 'คีย์ของกิจกรรม',
	PRIMARY KEY (activity_image_id),
	FOREIGN KEY (activity_id) REFERENCES activities(activity_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO activities(activity_id, activity_name, activity_description, activity_date, created, updated, category_id, user_id) VALUES
(1, 'Water sar', 'กิจกรรม Water sar', '2015-03-06', '2016-10-01 14:07:59', '2016-10-01 14:07:59', 1, 1),
(2, 'ดำน้ำ แสมสาร', 'ฝึกและทดสอบ ดำน้ำ แสมสาร', '2015-03-06', '2016-10-01 14:10:05', '2016-10-01 14:10:05', 1, 1),
(3, 'ฝึกค้นหาและช่วยชีวิต', 'เป็นการฝึกค้นหาและช่วยชีวิตของหน่วย PJ หรือ Pararescue Jumper', '2015-03-06', '2016-10-01 14:11:16', '2016-10-01 14:11:16', 1, 1),
(4, 'ฝึกยิงปืนประจำปี ๕๘ ครั้งที่ ๑', 'เป็นการฝึกยิงปืนของข้าราชการประจำปี ๕๘ ครั้งที่ ๑', '2015-03-19', '2016-10-01 14:13:04', '2016-10-01 14:13:04', 2, 1),
(5, 'ฝึกชุดปฏิบัติการ บน.๒', 'เป็นการทดสอบของชุดปฏิบัติการ บน.๒', '2015-03-19', '2016-10-01 14:14:51', '2016-10-01 14:14:51', 2, 1),
(6, 'เปิดหอพระธรรมะเมตตา', 'เป็นวันเปิดหอพระธรรมะเมตตา เมื่อวันที่ ๒๖ ธันวาคม พุทธศักราช ๒๕๕๗ โดยมีพลอากาศโท ชาญฤทธิ์ พลิกานนท์ ผู้บัญชาการหน่วยบัญชาการอากาศโยธิน มาเป็นประธาน', '2015-03-09', '2016-10-01 14:16:25', '2016-10-01 14:16:25', 2, 1),
(7, 'รับทหารใหม่  รุ่น ๕๗/๒', 'เปิดรับทหารใหม่หรือทหารกองประจำการ รุ่น ๕๗/๒ เมื่อวันที่ ๑ พฤศจิกายน ๒๕๕๗ ที่ผ่านมา', '2014-11-01', '2016-10-01 14:18:20', '2016-10-01 14:18:20', 3, 1),
(8, 'เยี่ยมญาติ ทหารใหม่ รุ่น ๕๗/๒', 'เป็นการปล่อยให้ญาติทหารกองประจำการ รุ่น ๕๗/๒ เยี่ยมครั้งแรก เมื่อวันที่ 22-23 พฤศจิกายน ๒๕๕๗ ที่ผ่านมา', '2014-11-22', '2016-10-01 14:19:56', '2016-10-01 14:19:56', 3, 1),
(9, 'พิธีรับหมวกเบเล่ย์ทรงอ่อนสีแดง รุ่น ๕๗/๒', 'พิธีมอบหมวกเบเล่ย์ทรงอ่อนสีแดงให้แก่ทหารกองประจำการ รุ่น ๕๗/๒', '2015-03-06', '2016-10-01 14:21:04', '2016-10-01 14:21:04', 3, 1),
(10, 'โดดหอสูง ๓๔ ฟุต ของทหารใหม่ รุ่น ๕๗/๒', 'กิจกรรมโดดหอสูง ๓๔ ฟุต ทดสอบกำลังใจของทหารกองประจำการ รุ่น ๕๗/๒', '2015-03-06', '2016-10-01 14:22:25', '2016-10-01 14:22:25', 3, 1);

INSERT INTO activities_images(activity_image_id, activity_image_url, activity_id) VALUES
(1, 'activity-1-1.jpg', 1),
(2, 'activity-1-2.jpg', 1),
(3, 'activity-1-3.jpg', 1),
(4, 'activity-1-4.jpg', 1),
(5, 'activity-1-5.jpg', 1),
(6, 'activity-1-6.jpg', 1),
(7, 'activity-1-7.jpg', 1),
(8, 'activity-1-8.jpg', 1),
(9, 'activity-1-9.jpg', 1),
(10, 'activity-1-10.jpg', 1),
(11, 'activity-2-1.jpg', 2),
(12, 'activity-2-2.jpg', 2),
(13, 'activity-2-3.jpg', 2),
(14, 'activity-2-4.jpg', 2),
(15, 'activity-2-5.jpg', 2),
(16, 'activity-2-6.jpg', 2),
(17, 'activity-2-7.jpg', 2),
(18, 'activity-2-8.jpg', 2),
(19, 'activity-2-9.jpg', 2),
(20, 'activity-2-10.jpg', 2),
(21, 'activity-2-11.jpg', 2),
(22, 'activity-3-1.jpg', 3),
(23, 'activity-3-2.jpg', 3),
(24, 'activity-3-3.jpg', 3),
(25, 'activity-3-4.jpg', 3),
(26, 'activity-3-5.jpg', 3),
(27, 'activity-3-6.jpg', 3),
(28, 'activity-3-7.jpg', 3),
(29, 'activity-3-8.jpg', 3),
(30, 'activity-3-9.jpg', 3),
(31, 'activity-3-10.jpg', 3),
(32, 'activity-3-11.jpg', 3),
(33, 'activity-4-1.jpg', 4),
(34, 'activity-4-2.jpg', 4),
(35, 'activity-4-3.jpg', 4),
(36, 'activity-4-4.jpg', 4),
(37, 'activity-4-5.jpg', 4),
(38, 'activity-4-6.jpg', 4),
(39, 'activity-4-7.jpg', 4),
(40, 'activity-4-8.jpg', 4),
(41, 'activity-4-9.jpg', 4),
(42, 'activity-4-10.jpg', 4),
(43, 'activity-5-1.jpg', 5),
(44, 'activity-5-2.jpg', 5),
(45, 'activity-5-3.jpg', 5),
(46, 'activity-5-4.jpg', 5),
(47, 'activity-5-5.jpg', 5),
(48, 'activity-5-6.jpg', 5),
(49, 'activity-5-7.jpg', 5),
(50, 'activity-5-8.jpg', 5),
(51, 'activity-5-9.jpg', 5),
(52, 'activity-5-10.jpg', 5),
(53, 'activity-6-1.jpg', 6),
(54, 'activity-6-2.jpg', 6),
(55, 'activity-6-3.jpg', 6),
(56, 'activity-6-4.jpg', 6),
(57, 'activity-6-5.jpg', 6),
(58, 'activity-6-6.jpg', 6),
(59, 'activity-6-7.jpg', 6),
(60, 'activity-6-8.jpg', 6),
(61, 'activity-6-9.jpg', 6),
(62, 'activity-6-10.jpg', 6),
(63, 'activity-6-11.jpg', 6),
(64, 'activity-7-1.jpg', 7),
(65, 'activity-7-2.jpg', 7),
(66, 'activity-7-3.jpg', 7),
(67, 'activity-7-4.jpg', 7),
(68, 'activity-7-5.jpg', 7),
(69, 'activity-7-6.jpg', 7),
(70, 'activity-7-7.jpg', 7),
(71, 'activity-7-8.jpg', 7),
(72, 'activity-7-9.jpg', 7),
(73, 'activity-7-10.jpg', 7),
(74, 'activity-8-1.jpg', 8),
(75, 'activity-8-2.jpg', 8),
(76, 'activity-8-3.jpg', 8),
(77, 'activity-8-4.jpg', 8),
(78, 'activity-8-5.jpg', 8),
(79, 'activity-8-6.jpg', 8),
(80, 'activity-8-7.jpg', 8),
(81, 'activity-8-8.jpg', 8),
(82, 'activity-8-9.jpg', 8),
(83, 'activity-9-1.jpg', 9),
(84, 'activity-9-2.jpg', 9),
(85, 'activity-9-3.jpg', 9),
(86, 'activity-9-4.jpg', 9),
(87, 'activity-9-5.jpg', 9),
(88, 'activity-9-6.jpg', 9),
(89, 'activity-9-7.jpg', 9),
(90, 'activity-9-8.jpg', 9),
(91, 'activity-9-9.jpg', 9),
(92, 'activity-9-10.jpg', 9),
(93, 'activity-10-1.jpg', 10),
(94, 'activity-10-2.jpg', 10),
(95, 'activity-10-3.jpg', 10),
(96, 'activity-10-4.jpg', 10),
(97, 'activity-10-5.jpg', 10),
(98, 'activity-10-6.jpg', 10),
(99, 'activity-10-7.jpg', 10),
(100, 'activity-10-8.jpg', 10),
(101, 'activity-10-9.jpg', 10);