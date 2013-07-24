# Dump File
#
# Database is ported from MS Access
#--------------------------------------------------------
# Program Version 5.1.232

DROP DATABASE IF EXISTS `master`;
CREATE DATABASE IF NOT EXISTS `master`;
USE `master`;

#
# Table structure for table 'xxxaccessitems'
#

DROP TABLE IF EXISTS `xxxaccessitems`;

CREATE TABLE `xxxaccessitems` (
  `itemid` INTEGER, 
  `title` VARCHAR(255), 
  `parentid` INTEGER, 
  `type` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'accessitems'
#

INSERT INTO `xxxaccessitems` (`itemid`, `title`, `parentid`, `type`) VALUES (1, 'IME Small Saving Tracking', NULL, 1);
INSERT INTO `xxxaccessitems` (`itemid`, `title`, `parentid`, `type`) VALUES (2, 'Admin Page', NULL, 0);
INSERT INTO `xxxaccessitems` (`itemid`, `title`, `parentid`, `type`) VALUES (3, 'Accounts', 2, 0);
INSERT INTO `xxxaccessitems` (`itemid`, `title`, `parentid`, `type`) VALUES (4, 'User Groups', 2, 0);
# 4 records

#
# Table structure for table 'xxxaccesssettings'
#

DROP TABLE IF EXISTS `xxxaccesssettings`;

CREATE TABLE `xxxaccesssettings` (
  `accessid` INTEGER, 
  `groupid` INTEGER, 
  `itemid` INTEGER, 
  `view` INTEGER, 
  `edit` INTEGER, 
  `add` INTEGER, 
  `delete` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'accesssettings'
#

INSERT INTO `xxxaccesssettings` (`accessid`, `groupid`, `itemid`, `view`, `edit`, `add`, `delete`) VALUES (1, 1, 1, 1, 1, 0, 1);
INSERT INTO `xxxaccesssettings` (`accessid`, `groupid`, `itemid`, `view`, `edit`, `add`, `delete`) VALUES (2, 1, 2, 0, 0, 0, 0);
INSERT INTO `xxxaccesssettings` (`accessid`, `groupid`, `itemid`, `view`, `edit`, `add`, `delete`) VALUES (3, 1, 3, 0, 0, 0, 0);
INSERT INTO `xxxaccesssettings` (`accessid`, `groupid`, `itemid`, `view`, `edit`, `add`, `delete`) VALUES (4, 1, 4, 0, 0, 0, 0);
# 4 records

#
# Table structure for table 'xxxclasses'
#

DROP TABLE IF EXISTS `xxxclasses`;

CREATE TABLE `xxxclasses` (
  `classid` INTEGER NOT NULL AUTO_INCREMENT, 
  `day` VARCHAR(255), 
  `starttime` TIME, 
  `endtime` TIME, 
  `capacity` INTEGER, 
  `courseid` VARCHAR(255), 
  `bath` VARCHAR(255), 
  `dateupdated` DATETIME, 
  `updatedby` INTEGER, 
  `datecreated` DATETIME, 
  `createdby` INTEGER, 
  INDEX (`courseid`), 
  PRIMARY KEY (`classid`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'classes'
#

# 0 records

#
# Table structure for table 'xxxclasses_trainors'
#

DROP TABLE IF EXISTS `xxxclasses_trainors`;

CREATE TABLE `xxxclasses_trainors` (
  `classid` INTEGER, 
  `personid` INTEGER, 
  INDEX (`classid`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'classes_trainors'
#

# 0 records

#
# Table structure for table 'xxxcountries'
#

DROP TABLE IF EXISTS `xxxcountries`;

CREATE TABLE `xxxcountries` (
  `country_id` INTEGER, 
  `name` LONGTEXT
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'countries'
#

INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (1, 'Afghanistan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (2, 'Albania');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (3, 'Algeria');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (4, 'American Samoa');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (5, 'Andorra');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (6, 'Angola');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (7, 'Anguilla');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (8, 'Antarctica');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (9, 'Antigua and Barbuda');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (10, 'Argentina');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (11, 'Armenia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (12, 'Armenia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (13, 'Aruba');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (14, 'Australia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (15, 'Austria');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (16, 'Azerbaijan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (17, 'Azerbaijan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (18, 'Bahamas');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (19, 'Bahrain');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (20, 'Bangladesh');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (21, 'Barbados');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (22, 'Belarus');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (23, 'Belgium');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (24, 'Belize');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (25, 'Benin');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (26, 'Bermuda');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (27, 'Bhutan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (28, 'Bolivia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (29, 'Bosnia and Herzegovina');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (30, 'Botswana');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (31, 'Bouvet Island');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (32, 'Brazil');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (33, 'British Indian Ocean Territory');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (34, 'Brunei Darussalam');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (35, 'Bulgaria');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (36, 'Burkina Faso');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (37, 'Burundi');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (38, 'Cambodia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (39, 'Cameroon');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (40, 'Canada');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (41, 'Cape Verde');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (42, 'Cayman Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (43, 'Central African Republic');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (44, 'Chad');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (45, 'Chile');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (46, 'China');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (47, 'Christmas Island');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (48, 'Cocos (Keeling) Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (49, 'Colombia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (50, 'Comoros');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (51, 'Congo');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (52, 'Congo, The Democratic Republic of The');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (53, 'Cook Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (54, 'Costa Rica');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (55, 'Cote D\'ivoire');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (56, 'Croatia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (57, 'Cuba');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (58, 'Cyprus');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (60, 'Czech Republic');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (61, 'Denmark');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (62, 'Djibouti');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (63, 'Dominica');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (64, 'Dominican Republic');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (65, 'Easter Island');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (66, 'Ecuador');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (67, 'Egypt');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (68, 'El Salvador');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (69, 'Equatorial Guinea');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (70, 'Eritrea');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (71, 'Estonia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (72, 'Ethiopia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (73, 'Falkland Islands (Malvinas)');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (74, 'Faroe Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (75, 'Fiji');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (76, 'Finland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (77, 'France');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (78, 'French Guiana');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (79, 'French Polynesia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (80, 'French Southern Territories');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (81, 'Gabon');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (82, 'Gambia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (83, 'Georgia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (85, 'Germany');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (86, 'Ghana');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (87, 'Gibraltar');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (88, 'Greece');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (89, 'Greenland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (91, 'Grenada');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (92, 'Guadeloupe');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (93, 'Guam');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (94, 'Guatemala');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (95, 'Guinea');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (96, 'Guinea-bissau');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (97, 'Guyana');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (98, 'Haiti');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (99, 'Heard Island and Mcdonald Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (100, 'Honduras');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (101, 'Hong Kong');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (102, 'Hungary');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (103, 'Iceland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (104, 'India');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (105, 'Indonesia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (106, 'Indonesia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (107, 'Iran');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (108, 'Iraq');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (109, 'Ireland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (110, 'Israel');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (111, 'Italy');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (112, 'Jamaica');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (113, 'Japan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (114, 'Jordan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (115, 'Kazakhstan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (116, 'Kazakhstan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (117, 'Kenya');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (118, 'Kiribati');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (119, 'Korea, North');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (120, 'Korea, South');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (121, 'Kosovo');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (122, 'Kuwait');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (123, 'Kyrgyzstan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (124, 'Laos');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (125, 'Latvia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (126, 'Lebanon');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (127, 'Lesotho');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (128, 'Liberia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (129, 'Libyan Arab Jamahiriya');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (130, 'Liechtenstein');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (131, 'Lithuania');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (132, 'Luxembourg');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (133, 'Macau');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (134, 'Macedonia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (135, 'Madagascar');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (136, 'Malawi');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (137, 'Malaysia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (138, 'Maldives');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (139, 'Mali');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (140, 'Malta');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (141, 'Marshall Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (142, 'Martinique');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (143, 'Mauritania');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (144, 'Mauritius');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (145, 'Mayotte');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (146, 'Mexico');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (147, 'Micronesia, Federated States of');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (148, 'Moldova, Republic of');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (149, 'Monaco');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (150, 'Mongolia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (151, 'Montenegro');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (152, 'Montserrat');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (153, 'Morocco');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (154, 'Mozambique');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (155, 'Myanmar');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (156, 'Namibia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (157, 'Nauru');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (158, 'Nepal');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (159, 'Netherlands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (160, 'Netherlands Antilles');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (161, 'New Caledonia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (162, 'New Zealand');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (163, 'Nicaragua');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (164, 'Niger');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (165, 'Nigeria');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (166, 'Niue');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (167, 'Norfolk Island');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (168, 'Northern Mariana Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (169, 'Norway');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (170, 'Oman');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (171, 'Pakistan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (172, 'Palau');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (173, 'Palestinian Territory');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (174, 'Panama');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (175, 'Papua New Guinea');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (176, 'Paraguay');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (177, 'Peru');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (178, 'Philippines');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (179, 'Pitcairn');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (180, 'Poland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (181, 'Portugal');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (182, 'Puerto Rico');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (183, 'Qatar');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (184, 'Reunion');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (185, 'Romania');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (186, 'Russia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (187, 'Russia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (188, 'Rwanda');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (189, 'Saint Helena');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (190, 'Saint Kitts and Nevis');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (191, 'Saint Lucia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (192, 'Saint Pierre and Miquelon');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (193, 'Saint Vincent and The Grenadines');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (194, 'Samoa');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (195, 'San Marino');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (196, 'Sao Tome and Principe');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (197, 'Saudi Arabia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (198, 'Senegal');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (199, 'Serbia and Montenegro');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (200, 'Seychelles');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (201, 'Sierra Leone');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (202, 'Singapore');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (203, 'Slovakia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (204, 'Slovenia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (205, 'Solomon Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (206, 'Somalia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (207, 'South Africa');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (208, 'South Georgia and The South Sandwich Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (209, 'Spain');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (210, 'Sri Lanka');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (211, 'Sudan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (212, 'Suriname');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (213, 'Svalbard and Jan Mayen');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (214, 'Swaziland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (215, 'Sweden');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (216, 'Switzerland');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (217, 'Syria');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (218, 'Taiwan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (219, 'Tajikistan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (220, 'Tanzania, United Republic of');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (221, 'Thailand');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (222, 'Timor-leste');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (223, 'Togo');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (224, 'Tokelau');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (225, 'Tonga');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (226, 'Trinidad and Tobago');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (227, 'Tunisia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (228, 'Turkey');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (229, 'Turkey');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (230, 'Turkmenistan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (231, 'Turks and Caicos Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (232, 'Tuvalu');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (233, 'Uganda');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (234, 'Ukraine');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (235, 'United Arab Emirates');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (236, 'United Kingdom');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (237, 'United States');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (238, 'United States Minor Outlying Islands');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (239, 'Uruguay');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (240, 'Uzbekistan');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (241, 'Vanuatu');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (242, 'Vatican City');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (243, 'Venezuela');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (244, 'Vietnam');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (245, 'Virgin Islands, British');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (246, 'Virgin Islands, U.S.');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (247, 'Wallis and Futuna');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (248, 'Western Sahara');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (249, 'Yemen');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (250, 'Yemen');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (251, 'Zambia');
INSERT INTO `xxxcountries` (`country_id`, `name`) VALUES (252, 'Zimbabwe');
# 249 records

#
# Table structure for table 'xxxcourses'
#

DROP TABLE IF EXISTS `xxxcourses`;

CREATE TABLE `xxxcourses` (
  `courseid` INTEGER NOT NULL AUTO_INCREMENT, 
  `coursecode` VARCHAR(255), 
  `title` VARCHAR(255), 
  `description` VARCHAR(255), 
  `fee` DECIMAL(18,0) DEFAULT 0, 
  `dateupdated` DATETIME, 
  `updatedby` INTEGER, 
  `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `createdby` INTEGER, 
  INDEX (`coursecode`), 
  PRIMARY KEY (`courseid`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'courses'
#

# 0 records

#
# Table structure for table 'xxxdashboard'
#

DROP TABLE IF EXISTS `xxxdashboard`;

CREATE TABLE `xxxdashboard` (
  `userid` INTEGER, 
  `jdashStorage` LONGTEXT, 
  `freestyle` VARCHAR(255), 
  `widgets` VARCHAR(255)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'dashboard'
#

# 0 records

#
# Table structure for table 'xxxemailaccounts'
#

DROP TABLE IF EXISTS `xxxemailaccounts`;

CREATE TABLE `xxxemailaccounts` (
  `emailid` INTEGER, 
  `personid` INTEGER, 
  `emailadd` VARCHAR(255), 
  `password` VARCHAR(255), 
  `defaultemail` INTEGER, 
  `verified` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'emailaccounts'
#

# 0 records

#
# Table structure for table 'xxxfilterfields'
#

DROP TABLE IF EXISTS `xxxfilterfields`;

CREATE TABLE `xxxfilterfields` (
  `fieldid` INTEGER, 
  `name` VARCHAR(50), 
  `type` INTEGER, 
  `description` LONGTEXT, 
  `displayname` VARCHAR(50), 
  `sourcetable` VARCHAR(100), 
  `value` VARCHAR(250), 
  `valueid` VARCHAR(250), 
  `operators` VARCHAR(250)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'filterfields'
#

INSERT INTO `xxxfilterfields` (`fieldid`, `name`, `type`, `description`, `displayname`, `sourcetable`, `value`, `valueid`, `operators`) VALUES (1, 'gmid', 1, 'Allows to grant special access to another user.', 'Surrogate', 'tblpersons00', 'Concat(FirstName,\' \',LastName)', 'gmid', '=,<>');
INSERT INTO `xxxfilterfields` (`fieldid`, `name`, `type`, `description`, `displayname`, `sourcetable`, `value`, `valueid`, `operators`) VALUES (2, 'workstreamid', 1, 'Workstream', 'Workstream', 'tblworkstreams01', 'workstream', 'workstreamid', '=,<>');
# 2 records

#
# Table structure for table 'xxxfiltermodules'
#

DROP TABLE IF EXISTS `xxxfiltermodules`;

CREATE TABLE `xxxfiltermodules` (
  `fieldid` INTEGER, 
  `itemid` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'filtermodules'
#

INSERT INTO `xxxfiltermodules` (`fieldid`, `itemid`) VALUES (1, 1);
INSERT INTO `xxxfiltermodules` (`fieldid`, `itemid`) VALUES (2, 1);
# 2 records

#
# Table structure for table 'xxxfilters'
#

DROP TABLE IF EXISTS `xxxfilters`;

CREATE TABLE `xxxfilters` (
  `filterid` INTEGER, 
  `userid` INTEGER, 
  `value` LONGTEXT
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'filters'
#

INSERT INTO `xxxfilters` (`filterid`, `userid`, `value`) VALUES (1, 1, '[{\"field\":\"Workstream\",\"id\":2,\"applyto\":\"IME Small Saving Tracking\",\"itemid\":\"1\",\"dataStorage\":[\"Workstream\",\"2\",\"tblworkstreams01\",\"workstream\",\"workstreamid\",\"1\",\"workstreamid\",\"=,<>\",\"Workstream\"],\"groupid\":3,\"filter\":\"OR\",\"operator\":\"=\",\"value\":\"Engineering Services\",\"values\":[\"Engineering Services\",\"4\"]}]');
# 1 records

#
# Table structure for table 'xxxgroups'
#

DROP TABLE IF EXISTS `xxxgroups`;

CREATE TABLE `xxxgroups` (
  `groupid` INTEGER, 
  `title` VARCHAR(255)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'groups'
#

INSERT INTO `xxxgroups` (`groupid`, `title`) VALUES (1, 'Admin');
# 1 records

#
# Table structure for table 'xxxloginsessions'
#

DROP TABLE IF EXISTS `xxxloginsessions`;

CREATE TABLE `xxxloginsessions` (
  `sessionid` INTEGER AUTO_INCREMENT, 
  `userid` VARCHAR(255), 
  `userip` VARCHAR(255), 
  `sessiondate` DATETIME, 
  `description` VARCHAR(255), 
  INDEX (`sessionid`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'loginsessions'
#

# 0 records

#
# Table structure for table 'xxxorgstructure'
#

DROP TABLE IF EXISTS `xxxorgstructure`;

CREATE TABLE `xxxorgstructure` (
  `orgstructureid` INTEGER, 
  `title` VARCHAR(255), 
  `parent` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'orgstructure'
#

# 0 records

#
# Table structure for table 'xxxorgtype'
#

DROP TABLE IF EXISTS `xxxorgtype`;

CREATE TABLE `xxxorgtype` (
  `orgtypeid` INTEGER, 
  `title` VARCHAR(255), 
  `description` VARCHAR(255)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'orgtype'
#

# 0 records

#
# Table structure for table 'xxxpersons'
#

DROP TABLE IF EXISTS `xxxpersons`;

CREATE TABLE `xxxpersons` (
  `PersonID` INTEGER AUTO_INCREMENT, 
  `firstname` VARCHAR(255), 
  `lastname` VARCHAR(255), 
  `dateofbirth` DATETIME, 
  `nationalitycountry` INTEGER, 
  `contactnumber` VARCHAR(255), 
  `gender` INTEGER, 
  `language` VARCHAR(250), 
  `address` VARCHAR(250), 
  `city` VARCHAR(250), 
  INDEX (`PersonID`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'persons'
#

# 0 records

#
# Table structure for table 'xxxpositions'
#

DROP TABLE IF EXISTS `xxxpositions`;

CREATE TABLE `xxxpositions` (
  `positionid` INTEGER, 
  `orgstructureid` INTEGER, 
  `title` VARCHAR(255), 
  `description` VARCHAR(255), 
  `createdby` INTEGER, 
  `filledby` INTEGER, 
  `parent` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'positions'
#

# 0 records

#
# Table structure for table 'xxxroles'
#

DROP TABLE IF EXISTS `xxxroles`;

CREATE TABLE `xxxroles` (
  `personid` INTEGER, 
  `groupid` INTEGER
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'roles'
#

# 0 records

#
# Table structure for table 'xxxstaffs'
#

DROP TABLE IF EXISTS `xxxstaffs`;

CREATE TABLE `xxxstaffs` (
  `staffid` INTEGER AUTO_INCREMENT, 
  `personid` INTEGER, 
  `dateemployed` DATETIME, 
  INDEX (`staffid`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'staffs'
#

# 0 records

#
# Table structure for table 'xxxusers'
#

DROP TABLE IF EXISTS `xxxusers`;

CREATE TABLE `xxxusers` (
  `userid` INTEGER AUTO_INCREMENT, 
  `groupid` INTEGER, 
  `personid` INTEGER, 
  `username` VARCHAR(255), 
  `password` VARCHAR(255), 
  `last_known_ip` VARCHAR(255), 
  `last_login` DATETIME, 
  `securityquestion` VARCHAR(255), 
  `securityanswer` VARCHAR(255), 
  `verificationcode` VARCHAR(255), 
  `rsakey` LONGTEXT, 
  INDEX (`userid`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'users'
#

# 0 records

#
# Table structure for table 'xxxwidgets'
#

DROP TABLE IF EXISTS `xxxwidgets`;

CREATE TABLE `xxxwidgets` (
  `id` INTEGER, 
  `title` VARCHAR(255), 
  `url` VARCHAR(255), 
  `parameters` LONGTEXT
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

#
# Dumping data for table 'widgets'
#

# 0 records

