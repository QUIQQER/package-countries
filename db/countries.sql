
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Tabellenstruktur für Tabelle `{$TABLE}`
--

DROP TABLE IF EXISTS `{$TABLE}`;
CREATE TABLE IF NOT EXISTS `{$TABLE}` (
  `countries_id` int(11) NOT NULL AUTO_INCREMENT,
  `countries_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `countries_iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `countries_iso_code_3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `address_format_id` int(11) NOT NULL,
  `de` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `en` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Daten für Tabelle `{$TABLE}`
--

INSERT INTO `{$TABLE}` (`countries_id`, `countries_name`, `countries_iso_code_2`, `countries_iso_code_3`, `address_format_id`, `de`, `en`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1, 'Afghanistan', 'Afghanistan'),
(2, 'Albanien', 'AL', 'ALB', 1, 'Albanien', 'Albania'),
(3, 'Algerien', 'DZ', 'DZA', 1, 'Algerien', 'Algeria'),
(4, 'Amerikanisch-Samoa', 'AS', 'ASM', 1, 'Amerikanisch-Samoa', 'American Samoa'),
(5, 'Andorra', 'AD', 'AND', 1, 'Andorra', 'Andorra'),
(6, 'Angola', 'AO', 'AGO', 1, 'Angola', 'Angola'),
(7, 'Anguilla', 'AI', 'AIA', 1, 'Anguilla', 'Anguilla'),
(8, 'Antarktis', 'AQ', 'ATA', 1, 'Antarktis', 'Antarctica'),
(9, 'Antigua und Barbuda', 'AG', 'ATG', 1, 'Antigua und Barbuda', 'Antigua and Barbuda'),
(10, 'Argentinien', 'AR', 'ARG', 1, 'Argentinien', 'Argentina'),
(11, 'Armenien', 'AM', 'ARM', 1, 'Armenien', 'Armenia'),
(12, 'Aruba', 'AW', 'ABW', 1, 'Aruba', 'Aruba'),
(13, 'Australien', 'AU', 'AUS', 1, 'Australien', 'Australia'),
(14, 'Oesterreich', 'AT', 'AUT', 5, 'Oesterreich', 'Austria'),
(15, 'Aserbaidschan', 'AZ', 'AZE', 1, 'Aserbaidschan', 'Azerbaijan'),
(16, 'Bahamas', 'BS', 'BHS', 1, 'Bahamas', 'Bahamas'),
(17, 'Bahrain', 'BH', 'BHR', 1, 'Bahrain', 'Bahrain'),
(18, 'Bangladesh', 'BD', 'BGD', 1, 'Bangladesh', 'Bangladesh'),
(19, 'Barbados', 'BB', 'BRB', 1, 'Barbados', 'Barbados'),
(20, 'Belarus', 'BY', 'BLR', 1, 'Belarus', 'Belarus'),
(21, 'Belgien', 'BE', 'BEL', 1, 'Belgien', 'Belgium'),
(22, 'Belize', 'BZ', 'BLZ', 1, 'Belize', 'Belize'),
(23, 'Benin', 'BJ', 'BEN', 1, 'Benin', 'Benin'),
(24, 'Bermuda', 'BM', 'BMU', 1, 'Bermuda', 'Bermuda'),
(25, 'Bhutan', 'BT', 'BTN', 1, 'Bhutan', 'Bhutan'),
(26, 'Bolivien', 'BO', 'BOL', 1, 'Bolivien', 'Bolivia'),
(27, 'Bosnien und Herzegowina', 'BA', 'BIH', 1, 'Bosnien und Herzegowina', 'Bosnia and Herzegowina'),
(28, 'Botswana', 'BW', 'BWA', 1, 'Botswana', 'Botswana'),
(29, 'Bouvet Island', 'BV', 'BVT', 1, 'Bouvet Island', 'Bouvet Island'),
(30, 'Brasilien', 'BR', 'BRA', 1, 'Brasilien', 'Brazil'),
(31, 'Britische Territorien im Indischen Ozean', 'IO', 'IOT', 1, 'Britische Territorien im Indischen Ozean', 'British Indian Ocean Territory'),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1, 'Brunei Darussalam', 'Brunei Darussalam'),
(33, 'Bulgarien', 'BG', 'BGR', 1, 'Bulgarien', 'Bulgaria'),
(34, 'Burkina Faso', 'BF', 'BFA', 1, 'Burkina Faso', 'Burkina Faso'),
(35, 'Burundi', 'BI', 'BDI', 1, 'Burundi', 'Burundi'),
(36, 'Kambodscha', 'KH', 'KHM', 1, 'Kambodscha', 'Cambodia'),
(37, 'Kamerun', 'CM', 'CMR', 1, 'Kamerun', 'Cameroon'),
(38, 'Kanada', 'CA', 'CAN', 1, 'Kanada', 'Canada'),
(39, 'Kapverden', 'CV', 'CPV', 1, 'Kapverden', 'Cape Verde'),
(40, 'Cayman-Inseln', 'KY', 'CYM', 1, 'Cayman-Inseln', 'Cayman Islands'),
(41, 'Zentralafrika', 'CF', 'CAF', 1, 'Zentralafrika', 'Central African Republic'),
(42, 'Tschad', 'TD', 'TCD', 1, 'Tschad', 'Chad'),
(43, 'Chile', 'CL', 'CHL', 1, 'Chile', 'Chile'),
(44, 'China', 'CN', 'CHN', 1, 'China', 'China'),
(45, 'Weihnachtsinseln', 'CX', 'CXR', 1, 'Weihnachtsinseln', 'Christmas Island'),
(46, 'Kokosinseln', 'CC', 'CCK', 1, 'Kokosinseln', 'Cocos (Keeling) Islands'),
(47, 'Kolumbien', 'CO', 'COL', 1, 'Kolumbien', 'Colombia'),
(48, 'Komoren', 'KM', 'COM', 1, 'Komoren', 'Comoros'),
(49, 'Kongo', 'CG', 'COG', 1, 'Kongo', 'Congo'),
(50, 'Cook-Inseln', 'CK', 'COK', 1, 'Cook-Inseln', 'Cook Islands'),
(51, 'Kostarika', 'CR', 'CRI', 1, 'Kostarika', 'Costa Rica'),
(52, 'Elfenbeinkueste', 'CI', 'CIV', 1, 'Elfenbeinkueste', 'Cote D''Ivoire'),
(53, 'Kroatien', 'HR', 'HRV', 1, 'Kroatien', 'Croatia'),
(54, 'Kuba', 'CU', 'CUB', 1, 'Kuba', 'Cuba'),
(55, 'Zypern', 'CY', 'CYP', 1, 'Zypern', 'Cyprus'),
(56, 'Tschechische Republik', 'CZ', 'CZE', 1, 'Tschechische Republik', 'Czech Republic'),
(57, 'Daenemark', 'DK', 'DNK', 1, 'Daenemark', 'Denmark'),
(58, 'Djibouti', 'DJ', 'DJI', 1, 'Djibouti', 'Djibouti'),
(59, 'Dominica', 'DM', 'DMA', 1, 'Dominica', 'Dominica'),
(60, 'Dominikanische Republik', 'DO', 'DOM', 1, 'Dominikanische Republik', 'Dominican Republic'),
(61, 'Ost-Timor', 'TP', 'TMP', 1, 'Ost-Timor', 'East Timor'),
(62, 'Ecuador', 'EC', 'ECU', 1, 'Ecuador', 'Ecuador'),
(63, 'Aegypten', 'EG', 'EGY', 1, 'Aegypten', 'Egypt'),
(64, 'El Salvador', 'SV', 'SLV', 1, 'El Salvador', 'El Salvador'),
(65, 'Aequatorial-Guinea', 'GQ', 'GNQ', 1, 'Aequatorial-Guinea', 'Equatorial Guinea'),
(66, 'Eritrea', 'ER', 'ERI', 1, 'Eritrea', 'Eritrea'),
(67, 'Estland', 'EE', 'EST', 1, 'Estland', 'Estonia'),
(68, 'Aethiopien', 'ET', 'ETH', 1, 'Aethiopien', 'Ethiopia'),
(69, 'Falkland-Inseln (Malvinen)', 'FK', 'FLK', 1, 'Falkland-Inseln (Malvinen)', 'Falkland Islands (Malvinas)'),
(70, 'Faeroeer', 'FO', 'FRO', 1, 'Faeroeer', 'Faroe Islands'),
(71, 'Fidschi', 'FJ', 'FJI', 1, 'Fidschi', 'Fiji'),
(72, 'Finnland', 'FI', 'FIN', 1, 'Finnland', 'Finland'),
(73, 'Frankreich', 'FR', 'FRA', 1, 'Frankreich', 'France'),
(74, 'Frankreich, Metropolitan', 'FX', 'FXX', 1, 'Frankreich, Metropolitan', 'France, Metropolitan'),
(75, 'Franzoesisch-Guyana', 'GF', 'GUF', 1, 'Franzoesisch-Guyana', 'French Guiana'),
(76, 'Franzoesisch-Polynesien', 'PF', 'PYF', 1, 'Franzoesisch-Polynesien', 'French Polynesia'),
(77, 'Franzoesische Suedterritorien', 'TF', 'ATF', 1, 'Franzoesische Suedterritorien', 'French Southern Territories'),
(78, 'Gabon', 'GA', 'GAB', 1, 'Gabon', 'Gabon'),
(79, 'Gambia', 'GM', 'GMB', 1, 'Gambia', 'Gambia'),
(80, 'Georgien', 'GE', 'GEO', 1, 'Georgien', 'Georgia'),
(81, 'Deutschland', 'DE', 'DEU', 5, 'Deutschland', 'Germany'),
(82, 'Ghana', 'GH', 'GHA', 1, 'Ghana', 'Ghana'),
(83, 'Gibraltar', 'GI', 'GIB', 1, 'Gibraltar', 'Gibraltar'),
(84, 'Griechenland', 'GR', 'GRC', 1, 'Griechenland', 'Greece'),
(85, 'Groenland', 'GL', 'GRL', 1, 'Groenland', 'Greenland'),
(86, 'Grenada', 'GD', 'GRD', 1, 'Grenada', 'Grenada'),
(87, 'Guadeloupe', 'GP', 'GLP', 1, 'Guadeloupe', 'Guadeloupe'),
(88, 'Guam', 'GU', 'GUM', 1, 'Guam', 'Guam'),
(89, 'Guatemala', 'GT', 'GTM', 1, 'Guatemala', 'Guatemala'),
(90, 'Guinea', 'GN', 'GIN', 1, 'Guinea', 'Guinea'),
(91, 'Guinea-Bissau', 'GW', 'GNB', 1, 'Guinea-Bissau', 'Guinea-bissau'),
(92, 'Guyana', 'GY', 'GUY', 1, 'Guyana', 'Guyana'),
(93, 'Haiti', 'HT', 'HTI', 1, 'Haiti', 'Haiti'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1, 'Heard and Mc Donald Islands', 'Heard and Mc Donald Islands'),
(95, 'Honduras', 'HN', 'HND', 1, 'Honduras', 'Honduras'),
(96, 'Hong Kong', 'HK', 'HKG', 1, 'Hong Kong', 'Hong Kong'),
(97, 'Ungarn', 'HU', 'HUN', 1, 'Ungarn', 'Hungary'),
(98, 'Island', 'IS', 'ISL', 1, 'Island', 'Iceland'),
(99, 'Indien', 'IN', 'IND', 1, 'Indien', 'India'),
(100, 'Indonesien', 'ID', 'IDN', 1, 'Indonesien', 'Indonesia'),
(101, 'Iran (Islamische Republik)', 'IR', 'IRN', 1, 'Iran (Islamische Republik)', 'Iran (Islamic Republic of)'),
(102, 'Irak', 'IQ', 'IRQ', 1, 'Irak', 'Iraq'),
(103, 'Irland', 'IE', 'IRL', 1, 'Irland', 'Ireland'),
(104, 'Israel', 'IL', 'ISR', 1, 'Israel', 'Israel'),
(105, 'Italien', 'IT', 'ITA', 1, 'Italien', 'Italy'),
(106, 'Jamaika', 'JM', 'JAM', 1, 'Jamaika', 'Jamaica'),
(107, 'Japan', 'JP', 'JPN', 1, 'Japan', 'Japan'),
(108, 'Jordanien', 'JO', 'JOR', 1, 'Jordanien', 'Jordan'),
(109, 'Kasachstan', 'KZ', 'KAZ', 1, 'Kasachstan', 'Kazakhstan'),
(110, 'Kenia', 'KE', 'KEN', 1, 'Kenia', 'Kenya'),
(111, 'Kiribati', 'KI', 'KIR', 1, 'Kiribati', 'Kiribati'),
(112, 'Korea, Demokratische Volksrepublik', 'KP', 'PRK', 1, 'Korea, Demokratische Volksrepublik', 'Korea, Democratic People''s Republic of'),
(113, 'Korea, Republik', 'KR', 'KOR', 1, 'Korea, Republik', 'Korea, Republic of'),
(114, 'Kuwait', 'KW', 'KWT', 1, 'Kuwait', 'Kuwait'),
(115, 'Kirgisien', 'KG', 'KGZ', 1, 'Kirgisien', 'Kyrgyzstan'),
(116, 'Laotische Demokratische Volksrepublik', 'LA', 'LAO', 1, 'Laotische Demokratische Volksrepublik', 'Lao People''s Democratic Republic'),
(117, 'Lettland', 'LV', 'LVA', 1, 'Lettland', 'Latvia'),
(118, 'Libanon', 'LB', 'LBN', 1, 'Libanon', 'Lebanon'),
(119, 'Lesotho', 'LS', 'LSO', 1, 'Lesotho', 'Lesotho'),
(120, 'Liberia', 'LR', 'LBR', 1, 'Liberia', 'Liberia'),
(121, 'Libyen', 'LY', 'LBY', 1, 'Libyen', 'Libyan Arab Jamahiriya'),
(122, 'Liechtenstein', 'LI', 'LIE', 1, 'Liechtenstein', 'Liechtenstein'),
(123, 'Litauen', 'LT', 'LTU', 1, 'Litauen', 'Lithuania'),
(124, 'Luxemburg', 'LU', 'LUX', 1, 'Luxemburg', 'Luxembourg'),
(125, 'Macau', 'MO', 'MAC', 1, 'Macau', 'Macau'),
(126, 'Mazedonien', 'MK', 'MKD', 1, 'Mazedonien', 'Macedonia, The Former Yugoslav Republic of'),
(127, 'Madagaskar', 'MG', 'MDG', 1, 'Madagaskar', 'Madagascar'),
(128, 'Malawi', 'MW', 'MWI', 1, 'Malawi', 'Malawi'),
(129, 'Malaysia', 'MY', 'MYS', 1, 'Malaysia', 'Malaysia'),
(130, 'Malediven', 'MV', 'MDV', 1, 'Malediven', 'Maldives'),
(131, 'Mali', 'ML', 'MLI', 1, 'Mali', 'Mali'),
(132, 'Malta', 'MT', 'MLT', 1, 'Malta', 'Malta'),
(133, 'Marshall-Inseln', 'MH', 'MHL', 1, 'Marshall-Inseln', 'Marshall Islands'),
(134, 'Martinique', 'MQ', 'MTQ', 1, 'Martinique', 'Martinique'),
(135, 'Mauritanien', 'MR', 'MRT', 1, 'Mauritanien', 'Mauritania'),
(136, 'Mauritius', 'MU', 'MUS', 1, 'Mauritius', 'Mauritius'),
(137, 'Mayotte', 'YT', 'MYT', 1, 'Mayotte', 'Mayotte'),
(138, 'Mexiko', 'MX', 'MEX', 1, 'Mexiko', 'Mexico'),
(139, 'Mikronesien', 'FM', 'FSM', 1, 'Mikronesien', 'Micronesia, Federated States of'),
(140, 'Moldawien', 'MD', 'MDA', 1, 'Moldawien', 'Moldova, Republic of'),
(141, 'Monaco', 'MC', 'MCO', 1, 'Monaco', 'Monaco'),
(142, 'Mongolei', 'MN', 'MNG', 1, 'Mongolei', 'Mongolia'),
(143, 'Montserrat', 'MS', 'MSR', 1, 'Montserrat', 'Montserrat'),
(144, 'Marokko', 'MA', 'MAR', 1, 'Marokko', 'Morocco'),
(145, 'Mosambik', 'MZ', 'MOZ', 1, 'Mosambik', 'Mozambique'),
(146, 'Myanmar', 'MM', 'MMR', 1, 'Myanmar', 'Myanmar'),
(147, 'Namibia', 'NA', 'NAM', 1, 'Namibia', 'Namibia'),
(148, 'Nauru', 'NR', 'NRU', 1, 'Nauru', 'Nauru'),
(149, 'Nepal', 'NP', 'NPL', 1, 'Nepal', 'Nepal'),
(150, 'Niederlande', 'NL', 'NLD', 1, 'Niederlande', 'Netherlands'),
(151, 'Niederlaendische Antillen', 'AN', 'ANT', 1, 'Niederlaendische Antillen', 'Netherlands Antilles'),
(152, 'Neu-Kaledonien', 'NC', 'NCL', 1, 'Neu-Kaledonien', 'New Caledonia'),
(153, 'Neuseeland', 'NZ', 'NZL', 1, 'Neuseeland', 'New Zealand'),
(154, 'Nikaragua', 'NI', 'NIC', 1, 'Nikaragua', 'Nicaragua'),
(155, 'Niger', 'NE', 'NER', 1, 'Niger', 'Niger'),
(156, 'Nigeria', 'NG', 'NGA', 1, 'Nigeria', 'Nigeria'),
(157, 'Niue', 'NU', 'NIU', 1, 'Niue', 'Niue'),
(158, 'Norfolk-Inseln', 'NF', 'NFK', 1, 'Norfolk-Inseln', 'Norfolk Island'),
(159, 'Noerdliche Marianen', 'MP', 'MNP', 1, 'Noerdliche Marianen', 'Northern Mariana Islands'),
(160, 'Norwegen', 'NO', 'NOR', 1, 'Norwegen', 'Norway'),
(161, 'Oman', 'OM', 'OMN', 1, 'Oman', 'Oman'),
(162, 'Pakistan', 'PK', 'PAK', 1, 'Pakistan', 'Pakistan'),
(163, 'Palau', 'PW', 'PLW', 1, 'Palau', 'Palau'),
(164, 'Panama', 'PA', 'PAN', 1, 'Panama', 'Panama'),
(165, 'Papua-Neuguinea', 'PG', 'PNG', 1, 'Papua-Neuguinea', 'Papua New Guinea'),
(166, 'Paraguay', 'PY', 'PRY', 1, 'Paraguay', 'Paraguay'),
(167, 'Peru', 'PE', 'PER', 1, 'Peru', 'Peru'),
(168, 'Philippinen', 'PH', 'PHL', 1, 'Philippinen', 'Philippines'),
(169, 'Pitcairn', 'PN', 'PCN', 1, 'Pitcairn', 'Pitcairn'),
(170, 'Polen', 'PL', 'POL', 1, 'Polen', 'Poland'),
(171, 'Portugal', 'PT', 'PRT', 1, 'Portugal', 'Portugal'),
(172, 'Puerto Rico', 'PR', 'PRI', 1, 'Puerto Rico', 'Puerto Rico'),
(173, 'Qatar', 'QA', 'QAT', 1, 'Qatar', 'Qatar'),
(174, 'Reunion', 'RE', 'REU', 1, 'Reunion', 'Reunion'),
(175, 'Rumaenien', 'RO', 'ROM', 1, 'Rumaenien', 'Romania'),
(176, 'Russische Foederation', 'RU', 'RUS', 1, 'Russische Foederation', 'Russian Federation'),
(177, 'Rwanda', 'RW', 'RWA', 1, 'Rwanda', 'Rwanda'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1, 'Saint Kitts and Nevis', 'Saint Kitts and Nevis'),
(179, 'Saint Lucia', 'LC', 'LCA', 1, 'Saint Lucia', 'Saint Lucia'),
(180, 'Saint Vincent und die Grenadinen', 'VC', 'VCT', 1, 'Saint Vincent und die Grenadinen', 'Saint Vincent and the Grenadines'),
(181, 'Samoa', 'WS', 'WSM', 1, 'Samoa', 'Samoa'),
(182, 'San Marino', 'SM', 'SMR', 1, 'San Marino', 'San Marino'),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1, 'Sao Tome and Principe', 'Sao Tome and Principe'),
(184, 'Saudi-Arabien', 'SA', 'SAU', 1, 'Saudi-Arabien', 'Saudi Arabia'),
(185, 'Senegal', 'SN', 'SEN', 1, 'Senegal', 'Senegal'),
(186, 'Seychellen', 'SC', 'SYC', 1, 'Seychellen', 'Seychelles'),
(187, 'Sierra Leone', 'SL', 'SLE', 1, 'Sierra Leone', 'Sierra Leone'),
(188, 'Singapur', 'SG', 'SGP', 4, 'Singapur', 'Singapore'),
(189, 'Slowakei', 'SK', 'SVK', 1, 'Slowakei', 'Slovakia (Slovak Republic)'),
(190, 'Slowenien', 'SI', 'SVN', 1, 'Slowenien', 'Slovenia'),
(191, 'Solomon-Inseln', 'SB', 'SLB', 1, 'Solomon-Inseln', 'Solomon Islands'),
(192, 'Somalia', 'SO', 'SOM', 1, 'Somalia', 'Somalia'),
(193, 'Suedafrika', 'ZA', 'ZAF', 1, 'Suedafrika', 'South Africa'),
(194, 'South Georgia und die Suedlichen Sandwich-Inseln', 'GS', 'SGS', 1, 'South Georgia und die Suedlichen Sandwich-Inseln', 'South Georgia and the South Sandwich Islands'),
(195, 'Spanien', 'ES', 'ESP', 3, 'Spanien', 'Spain'),
(196, 'Sri Lanka', 'LK', 'LKA', 1, 'Sri Lanka', 'Sri Lanka'),
(197, 'St. Helena', 'SH', 'SHN', 1, 'St. Helena', 'St. Helena'),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1, 'St. Pierre and Miquelon', 'St. Pierre and Miquelon'),
(199, 'Sudan', 'SD', 'SDN', 1, 'Sudan', 'Sudan'),
(200, 'Surinam', 'SR', 'SUR', 1, 'Surinam', 'Suriname'),
(201, 'Svalbard und Jan Mayen Inseln', 'SJ', 'SJM', 1, 'Svalbard und Jan Mayen Inseln', 'Svalbard and Jan Mayen Islands'),
(202, 'Swaziland', 'SZ', 'SWZ', 1, 'Swaziland', 'Swaziland'),
(203, 'Schweden', 'SE', 'SWE', 1, 'Schweden', 'Sweden'),
(204, 'Schweiz', 'CH', 'CHE', 1, 'Schweiz', 'Switzerland'),
(205, 'Syrische Arabische Republik', 'SY', 'SYR', 1, 'Syrische Arabische Republik', 'Syrian Arab Republic'),
(206, 'Taiwan', 'TW', 'TWN', 1, 'Taiwan', 'Taiwan'),
(207, 'Tadschikistan', 'TJ', 'TJK', 1, 'Tadschikistan', 'Tajikistan'),
(208, 'Tansania', 'TZ', 'TZA', 1, 'Tansania', 'Tanzania, United Republic of'),
(209, 'Thailand', 'TH', 'THA', 1, 'Thailand', 'Thailand'),
(210, 'Togo', 'TG', 'TGO', 1, 'Togo', 'Togo'),
(211, 'Tokelau', 'TK', 'TKL', 1, 'Tokelau', 'Tokelau'),
(212, 'Tonga', 'TO', 'TON', 1, 'Tonga', 'Tonga'),
(213, 'Trinidad und Tobago', 'TT', 'TTO', 1, 'Trinidad und Tobago', 'Trinidad and Tobago'),
(214, 'Tunesien', 'TN', 'TUN', 1, 'Tunesien', 'Tunisia'),
(215, 'Tuerkei', 'TR', 'TUR', 1, 'Tuerkei', 'Turkey'),
(216, 'Turkmenistan', 'TM', 'TKM', 1, 'Turkmenistan', 'Turkmenistan'),
(217, 'Turks und Caicos Inseln', 'TC', 'TCA', 1, 'Turks und Caicos Inseln', 'Turks and Caicos Islands'),
(218, 'Tuvalu', 'TV', 'TUV', 1, 'Tuvalu', 'Tuvalu'),
(219, 'Uganda', 'UG', 'UGA', 1, 'Uganda', 'Uganda'),
(220, 'Ukraine', 'UA', 'UKR', 1, 'Ukraine', 'Ukraine'),
(221, 'Vereinigte Arabische Emirate', 'AE', 'ARE', 1, 'Vereinigte Arabische Emirate', 'United Arab Emirates'),
(222, 'Grossbritannien (Vereinigtes Koenigreich)', 'GB', 'GBR', 1, 'Grossbritannien (Vereinigtes Koenigreich)', 'United Kingdom'),
(223, 'Vereinigte Staaten (USA)', 'US', 'USA', 2, 'Vereinigte Staaten (USA)', 'United States'),
(224, 'Ueberseeinseln der USA', 'UM', 'UMI', 1, 'Ueberseeinseln der USA', 'United States Minor Outlying Islands'),
(225, 'Uruguay', 'UY', 'URY', 1, 'Uruguay', 'Uruguay'),
(226, 'Usbekistan', 'UZ', 'UZB', 1, 'Usbekistan', 'Uzbekistan'),
(227, 'Vanuatu', 'VU', 'VUT', 1, 'Vanuatu', 'Vanuatu'),
(228, 'Vatikan', 'VA', 'VAT', 1, 'Vatikan', 'Vatican City State (Holy See)'),
(229, 'Venezuela', 'VE', 'VEN', 1, 'Venezuela', 'Venezuela'),
(230, 'Vietnam', 'VN', 'VNM', 1, 'Vietnam', 'Viet Nam'),
(231, 'Jungferninseln (Britisch)', 'VG', 'VGB', 1, 'Jungferninseln (Britisch)', 'Virgin Islands (British)'),
(232, 'Jungferninseln (USA)', 'VI', 'VIR', 1, 'Jungferninseln (USA)', 'Virgin Islands (U.S.)'),
(233, 'Wallis und Futuna', 'WF', 'WLF', 1, 'Wallis und Futuna', 'Wallis and Futuna Islands'),
(234, 'Westsahara', 'EH', 'ESH', 1, 'Westsahara', 'Western Sahara'),
(235, 'Jemen', 'YE', 'YEM', 1, 'Jemen', 'Yemen'),
(236, 'Jugoslawien', 'YU', 'YUG', 1, 'Jugoslawien', 'Yugoslavia'),
(237, 'Zaire', 'ZR', 'ZAR', 1, 'Zaire', 'Zaire'),
(238, 'Sambia', 'ZM', 'ZMB', 1, 'Sambia', 'Zambia'),
(239, 'Simbabwe', 'ZW', 'ZWE', 1, 'Simbabwe', 'Zimbabwe');
