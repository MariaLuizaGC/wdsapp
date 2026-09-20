DROP DATABASE IF EXISTS devsec_wdsapp_db;
CREATE DATABASE IF NOT EXISTS devsec_wdsapp_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE devsec_wdsapp_db;


CREATE TABLE clients
(
    id        int(11) NOT NULL,
    nome      varchar(50)  DEFAULT NULL,
    sobrenome varchar(50)  DEFAULT NULL,
    documento varchar(20)  DEFAULT NULL,
    endereco  varchar(255) DEFAULT NULL,
    cidade    varchar(50)  DEFAULT NULL,
    estado    varchar(2)   DEFAULT NULL,
    cep       varchar(15)  DEFAULT NULL,
    pais      varchar(20)  DEFAULT NULL,
    telefone  varchar(20)  DEFAULT NULL,
    email     varchar(50)  DEFAULT NULL,
    password  varchar(255) DEFAULT NULL,
    cctype    varchar(20)  DEFAULT NULL,
    ccnumber  varchar(20)  DEFAULT NULL,
    ccexpires varchar(10)  DEFAULT NULL,
    cvv       varchar(3)   DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO clients (id, nome, sobrenome, documento, endereco, cidade, estado, cep, pais, telefone, email, `password`,
                     cctype, ccnumber, ccexpires, cvv)
VALUES (1, 'Cliente', 'Teste', '589.479.094-83', 'Rua Caviúna 445', 'Contagem', 'MG', '32140-270', 'Brazil',
        '(31)2867-6907', 'cliente@alexrosa.dev', '123456', 'MasterCard', '5167681029620734', '4/2028', '668'),
       (2, 'Paulo', 'Barros', '359.373.430-34', 'Rua Santa Adélia 78', 'Catanduva', 'SP', '15801-050', 'Brazil',
        '(17) 3885-6928', 'PauloCastroBarros@armyspy.com', 'quohV7vai', 'Visa', '4485217067622148', '10/2027', '971'),
       (3, 'Rafaela', 'Silva', '696.729.264-13', 'Rua Coronel Soares Dutra 700', 'Belford Roxo', 'RJ', '26116-440',
        'Brazil', '(21) 7815-8002', 'RafaelaRochaSilva@fleckens.hu', 'ho5Lo2se2', 'Visa', '4532447662895475', '1/2027',
        '297'),
       (4, 'Luis', 'Barros', '777.381.844-42', 'Rua Manoel Quaresma 799', 'Salvador', 'BA', '41710-450', 'Brazil',
        '(71) 2085-5339', 'LuisRibeiroBarros@jourrapide.com', 'aimeishoW6', 'Visa', '4485516906177515', '7/2026',
        '090'),
       (5, 'Victor', 'Martins', '209.447.612-08', 'Rua Coronel José Vicente 1230', 'Campina Grande', 'PB', '58108-645',
        'Brazil', '(83) 9624-5438', 'VictorSantosMartins@superrito.com', 'tedei1ahX', 'MasterCard', '5235529247371754',
        '5/2025', '701'),
       (6, 'Rodrigo', 'Pereira', '779.704.005-23', 'Rua Engenheiros Rebouças 1812', 'Curitiba', 'PR', '80215-100',
        'Brazil', '(41) 9677-2083', 'RodrigoFernandesPereira@teleworm.us', 'phaiQu7aich', 'Visa', '4556958925130840',
        '11/2026', '353'),
       (7, 'Gabrielly', 'Pereira', '712.160.965-70', 'Rua Cidnei Grein Corrêa 1299', 'São José dos Pinhais', 'PR',
        '83060-545', 'Brazil', '(41) 4091-6419', 'GabriellyGomesPereira@dayrep.com', 'Ieph5Iphi', 'Visa',
        '4916993165820912', '9/2025', '917'),
       (8, 'Beatrice', 'Santos', '700.195.186-25', 'Rua Francisco Todt 1874', 'Jaraguá do Sul', 'SC', '89255-170',
        'Brazil', '(47) 7253-6658', 'BeatriceAzevedoSantos@dayrep.com', 'eiPhae0qu', 'Visa', '4716545510668784',
        '7/2028', '213'),
       (9, 'Julian', 'Goncalves', '926.897.399-50', 'Rua Coração de Jesus 142', 'Teófilo Otoni', 'MG', '39803-083',
        'Brazil', '(33) 6045-7814', 'JulianPereiraGoncalves@fleckens.hu', 'quiedee2feF', 'MasterCard',
        '5554939225494218', '11/2028', '660'),
       (10, 'José', 'Souza', '677.753.003-70', 'Beco São Vicente 44', 'Manaus', 'AM', '69093-774', 'Brazil',
        '(92) 6052-5012', 'JoseBarbosaSouza@rhyta.com', 'thiGhae1', 'Visa', '4539478197503014', '12/2028', '475');
CREATE TABLE config
(
    id         int(11) NOT NULL,
    mailfrom   varchar(255) DEFAULT NULL,
    mailuser   varchar(255) DEFAULT NULL,
    mailpass   varchar(255) DEFAULT NULL,
    smtphost   varchar(255) DEFAULT NULL,
    smtpsecure varchar(20)  DEFAULT NULL,
    smtpport   int(11)      DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


INSERT INTO `config` (`id`, `mailfrom`, `mailuser`, `mailpass`, `smtphost`, `smtpsecure`, `smtpport`)
VALUES (1, 'WDS App', 'email@dominio.com.br', 'senha_do_email', 'smtp.dominio.com.br', 'tls', 587);


CREATE TABLE orders
(
    id          int(11) NOT NULL,
    data        date           DEFAULT NULL,
    client_id   int(11)        DEFAULT NULL,
    seller_id   int(11)        DEFAULT NULL,
    valor       decimal(11, 2) DEFAULT NULL,
    status      varchar(20)    DEFAULT NULL,
    observacoes longtext
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO orders (id, `data`, client_id, seller_id, valor, `status`, observacoes)
VALUES (1, '2023-09-01', 1, 1, '3986.20', 'Faturado', NULL),
       (2, '2023-09-05', 2, 2, '1324.40', 'Aberto', NULL),
       (3, '2023-09-05', 3, 2, '3519.72', 'Aberto', 'Testando'),
       (4, '2023-09-05', 4, 2, '931.31', 'Faturado', NULL),
       (5, '2023-09-12', 5, 1, '2769.31', 'Aberto', 'teste 2'),
       (6, '2023-09-13', 6, 1, '2769.31', 'Aberto', 'Pedido de teste');


CREATE TABLE order_products
(
    id         int(11) NOT NULL,
    order_id   int(11)        DEFAULT NULL,
    product_id int(11)        DEFAULT NULL,
    quantidade int(11)        DEFAULT NULL,
    valor_unit decimal(11, 2) DEFAULT NULL,
    file       varchar(255)   DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO order_products (id, order_id, product_id, quantidade, valor_unit, `file`)
VALUES (1, 1, 1, 1, '3986.20', NULL),
       (2, 1, 3, 1, '1324.40', NULL),
       (3, 2, 29, 1, '1117.14', NULL),
       (4, 2, 47, 1, '1669.51', NULL),
       (5, 3, 27, 1, '1048.99', NULL),
       (6, 3, 1, 1, '788.49', NULL),
       (7, 3, 2, 1, '834.34', NULL),
       (8, 3, 3, 1, '847.90', NULL),
       (9, 4, 14, 1, '931.31', NULL),
       (10, 5, 5, 2, '879.00', 'files/order_import.xml'),
       (11, 5, 20, 3, '959.00', 'files/order_import.xml'),
       (12, 5, 14, 4, '931.31', 'files/order_import.xml'),
       (13, 6, 5, 2, '879.00', 'files/order_import.xml'),
       (14, 6, 20, 3, '959.00', 'files/order_import.xml'),
       (15, 6, 14, 4, '931.31', 'files/order_import.xml');


CREATE TABLE products
(
    id      int(11) NOT NULL,
    produto varchar(255)   DEFAULT NULL,
    valor   decimal(11, 2) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO products (id, produto, valor)
VALUES (1, 'GTX 1650 - Placa de Vídeo Gigabyte NVIDIA GeForce GTX 1650 D6 OC 4G, 4GB GDDR6, Rev 2.0 - GV-N1656OC-4GD',
        '788.49'),
       (2, 'GTX 1650 - Placa de Vídeo Galax NVIDIA GeForce GTX 1650 EX Plus (1-Click OC), 4GB, GDDR6 - 65SQL8DS93E1',
        '834.34'),
       (3,
        'GTX 1650 - Placa de Vídeo MSI, NVIDIA GeForce GTX 1650 D6 Ventus XS OCV1, 4GB, GDDR6, 128 Bits - 912-V809-4057',
        '847.90'),
       (4, 'GTX 1650 - MSI NVIDIA GeForce GTX 1650 Ventus XS OCV1 Edition, 4GB GDDR6, 128Bit (912-V809-4264)',
        '859.14'),
       (5, 'GTX 1650 - Placa de Video Galax GeForce GTX 1650 EX Plus 4GB GDDR6 1-Click OC 128-bit, 65SQL8DS93E1',
        '879.00'),
       (6, 'GTX 1650 - Placa de Video Galax GeForce GTX 1650 EX 1-Click OC 4GB GDDR6 128Bit 65SQL8DS66E6', '889.90'),
       (7, 'Arc A380 - Placa de Video ASRock Intel ARC A380 Challenger ITX, 6GB, GDDR6, 96-bit, A380 CLI 6GO',
        '899.00'),
       (8, 'GTX 1650 - Placa de Vídeo Galax GeForce GTX 1650 Ex Plus 4GB GDDR6 - 65SQL8DS93E1', '899.30'),
       (9,
        'GTX 1650 - Placa de Video INNO3D Geforce GTX 1650 Twin X2 OC V2, 4GB, GDDR6, 128-bit, N16502-04D6X-1720VA30',
        '909.99'),
       (10, 'GTX 1650 - Placa De Video Evolut Gpu, GTX 1650, 4GB, GDDR6, 128 Bit, Dual Fan', '919.00'),
       (11, 'GTX 1650 - Placa De Vídeo MSI NVIDIA GeForce Ventus XS GTX 1650, 4GB, 128 Bits - 912-v809-3060', '919.70'),
       (12,
        'GTX 1650 - Placa de Vídeo Galax NVIDIA GeForce GTX 1650, 4GB GDDR6, EX Plus, 1-Click OC, 128 Bits - 65SQL8DS93E1',
        '920.00'),
       (13, 'GTX 1650 - Placa de Video Asus GeForce GTX 1650 Phoenix EVO, 4GB, GDDR6, 128-bit, PH-GTX1650-4GD6-P-EVO',
        '929.00'),
       (14, 'GTX 1650 - Placa de Vídeo Galax GeForce GTX 1650 EX (1-Click OC), 4GB GDDR6, 128Bit, 65SQL8DS66E6',
        '931.31'),
       (15, 'GTX 1650 - Placa de Vídeo GTX 1650 PNY NVIDIA GeForce Single Fan, 4 GB GDDR6 - VCG16504D6SFMPB', '940.49'),
       (16, 'GTX 1650 - Placa de Vídeo MSI GeForce GTX 1650 4GB Ventus XS GDDR6 OCV1 - 912-V809-4057', '949.45'),
       (17, 'GTX 1650 - Placa de Video Gigabyte GeForce GTX 1650 D6 OC 4GB 128-bit, GV-N1656OC-4GD-REV1.0', '949.99'),
       (18,
        'RX 6500XT - Placa de Vídeo Power Color Fighter AMD Radeon RX 6500 XT, 4 GB GDDR6, Ray Tracing - AXRX 6500XT 4GBD6-DH/OC',
        '949.99'),
       (19, 'GTX 1650 - Placa de Vídeo Palit NIVIDIA GeForce GTX 1650 GP, 4GB GDDR6, 128 Bits - NE6165001BG1-1175A',
        '958.00'),
       (20,
        'GTX 1650 - Placa de Video Gigabyte GeForce GTX 1650 D6 OC, 4GB, GDDR6, 128-bit, GV-N1656OC-4GD REV 2.0-IMP',
        '959.00'),
       (21,
        'GTX 1650 - Placa de Video Gigabyte GeForce GTX 1650 D6 OC, 4GB, GDDR6, 128-bit, GV-N1656OC-4GD REV 2.0-NAC',
        '959.00'),
       (22, 'GTX 1650 - Placa de Vídeo Zotac Gaming NVIDIA GeForce GTX 1650 OC, 4GB, GDDR6 - ZT-T16520F-10L', '969.99'),
       (23, 'GTX 1650 - Placa de Video GTX 1650 PNY NVIDIA GeForce, 4GB GDDR6, Dual Fan - VCG16504D6DFXPB1', '969.99'),
       (24, 'GTX 1650 - PVD GAMER GTX1650 128B 4GB DDR5 ASUS', '999.00'),
       (25,
        'RX 6500XT - Placa de Vídeo Power Color Fighter AMD Radeon RX 6500 XT, 4 GB GDDR6, Ray Tracing - AXRX 6500XT 4GBD6-DH/OC',
        '999.99'),
       (26,
        'RX 6500XT - Placa de Vídeo RX 6500 XT ITX Power Color AMD Radeon, 4GB GDDR6, Ray Tracing - AXRX 6500 XT 4GBD6-DH',
        '1044.99'),
       (27, 'GTX 1650 - Placa de Vídeo Galax GeForce GTX 1650 EX Plus (1-Click OC) 4GB GDDR6 128 Bit - 65SQL8DS66E6',
        '1048.99'),
       (28,
        'RX 6500XT - Placa de Vídeo RX 6500 XT Gaming D OC ASRock Radeon Phantom, 4GB, GDDR6, 64 Bit, Dual Fan - 90-GA3DZZ-00UANF',
        '1115.50'),
       (29,
        'GTX 1650 Super - PCYes GeForce GTX 1650 Super Graffiti Series 4GB GDDR6 128-Bits DX 12 PCI Express 3.0 x16 (PAK1650S4GBDF)',
        '1117.14'),
       (30,
        'RX 6500XT - Placa de Vídeo RX 6500 XT Gaming D OC ASRock Radeon Phantom, 4GB, GDDR6, 64 Bit, Dual Fan - 90-GA3DZZ-00UANF',
        '1149.99'),
       (31, 'GTX 1660 Super - Colorful NVIDIA GeForce GTX 1660 Super NB 6G V2-V GDDR6 192Bit', '1203.14'),
       (32, 'GTX 1660 Super - Galax NVIDIA GeForce GTX 1660 Super (1-Click OC) 6GB GDDR6 192Bit (60SRL7DSY91S)',
        '1203.14'),
       (33,
        'GTX 1660 Super - Placa De Video Pcyes Nvidia Geforce Gtx 1660 Super 6GB GDDR6 192bits Dual-fan Graffiti Series - Pa1660s6gr6df',
        '1258.00'),
       (34, 'RX 6500XT - Placa de Video Sapphire Radeon RX 6500 XT Pulse OC, 4GB, GDDR6, 64-Bit, 11314-01-20G',
        '1259.99'),
       (35, 'RX 6500XT - Placa de Vídeo RX 6500 XT Gaming OC Sapphire Pulse, 4GB, GDDR6, AMD - 11314-01-20G',
        '1290.09'),
       (36, 'RX 6600 - Placa de Vídeo RX 6600 CLD 8G ASRock AMD Radeon, 8GB, GDDR6 - 90-GA2RZZ-00UANF', '1290.09'),
       (37,
        'GTX 1660 Super - Placa de Vídeo PCYes NVIDIA GeForce GTX 1660 Super GDDR6 6GB 192 Bits Dual-Fan Graffiti Series - PA1660S6GR6DF',
        '1299.00'),
       (38, 'GTX 1660 - Placa De Vídeo GTX 1660 Golden Memory NVIDIA GeForce Super, 6GB, GDDR6, 192Bits, Directx 12',
        '1299.00'),
       (39,
        'RX 6600 - Placa de Vídeo PowerColor Fighter Radeon RX 6600, 8GB, GDDR6, FSR, Ray Tracing, AXRX 6600 8GBD6-3DH',
        '1299.57'),
       (40, 'GTX 1660 - Placa de Vídeo GTX 1660 SC Ultra Gaming EVGA NVIDIA GeForce, 6GB GDDR5 - 06G-P4-1067-KR',
        '1301.49'),
       (41, 'GTX 1660 Super - Placa de Vídeo Golden Memory NVIDIA Geforce GTX 1660 Super 6GB 192BITS GDDR6 DirectX 12',
        '1319.12'),
       (42, 'GTX 1660 Super - Placa de Vídeo GTX 1660 Super Ventus XS OC MSI NVIDIA GeForce, 6GB, GDDR6', '1320.49'),
       (43, 'RX 6600 - Placa de Vídeo RX 6600 CLD 8G ASRock AMD Radeon, 8GB, GDDR6 - 90-GA2RZZ-00UANF', '1329.99'),
       (44,
        'RX 6500XT - Placa De Vídeo Powercolor Radeon RX 6500 XT, 4GB, GDDR6 Fighter 64bits - Axrx 6500xt 4gbd6-dh/oc',
        '1332.00'),
       (45, 'GTX 1660 - Placa de Video Geforce GTX1660 6GB 1CLICK OC G5 192B GALAX', '1352.42'),
       (46,
        'RTX 3050 - Placa de Vídeo RTX 3050 EX Galax NVIDIA GeForce, RGB, 8GB GDDR6, LHR, DLSS, Ray Tracing - 35NSL8MD6YEX - Galaxy',
        '1367.91'),
       (47, 'RTX 3050 - Placa de Vídeo MSI GeForce RTX 3050 VENTUS 2X OC V1 8GB GDDR6 DLSS Ray Tracing 912-V500-008',
        '1389.90'),
       (48, 'RX 6500XT - Placa de Vídeo Gigabyte Eagle Radeon RX 6500 XT 4GB GDDR6 - GV-R65XTEAGLE-4GD', '1399.95'),
       (49, 'RX 6500XT - GPU AMD RX6500XT 4GB GDDR6 POWER COLOR 1A1-G00367100G', '1402.00'),
       (50, 'RX 6600 - Placa de Vídeo PowerColor AMD Radeon AXRX 6600, 8GB GDDR6 - 8GBD6-3DHL', '1414.68');


CREATE TABLE sellers_fee
(
    id        int(11) NOT NULL,
    seller_id int(11)        DEFAULT NULL,
    client_id int(11)        DEFAULT NULL,
    order_id  int(11)        DEFAULT NULL,
    data      date           DEFAULT NULL,
    valor     decimal(11, 2) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO sellers_fee (id, seller_id, client_id, order_id, `data`, valor)
VALUES (1, 1, 1, 1, '2023-09-08', '398.62'),
       (2, 2, 4, 4, '2023-09-12', '46.56');


CREATE TABLE uf
(
    uf_id    int(11) NOT NULL,
    uf_nome  varchar(45) DEFAULT NULL,
    uf_sigla varchar(45) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO uf (uf_id, uf_nome, uf_sigla)
VALUES (1, 'ACRE', 'AC'),
       (2, 'ALAGOAS', 'AL'),
       (4, 'AMAZONAS', 'AM'),
       (3, 'AMAPÁ', 'AP'),
       (5, 'BAHIA', 'BA'),
       (6, 'CEARÁ', 'CE'),
       (7, 'DISTRITO FEDERAL', 'DF'),
       (8, 'ESPÍRITO SANTO', 'ES'),
       (9, 'GOIÁS', 'GO'),
       (10, 'MARANHÃO', 'MA'),
       (13, 'MINAS GERAIS', 'MG'),
       (12, 'MATO GROSSO DO SUL', 'MS'),
       (11, 'MATO GROSSO', 'MT'),
       (14, 'PARÁ', 'PA'),
       (15, 'PARAÍBA', 'PB'),
       (17, 'PERNAMBUCO', 'PE'),
       (18, 'PIAUÍ', 'PI'),
       (16, 'PARANÁ', 'PR'),
       (19, 'RIO DE JANEIRO', 'RJ'),
       (20, 'RIO GRANDE DO NORTE', 'RN'),
       (22, 'RONDÔNIA', 'RO'),
       (23, 'RORAIMA', 'RR'),
       (21, 'RIO GRANDE DO SUL', 'RS'),
       (24, 'SANTA CATARINA', 'SC'),
       (26, 'SERGIPE', 'SE'),
       (25, 'SÃO PAULO', 'SP'),
       (27, 'TOCANTINS', 'TO');


CREATE TABLE users
(
    id          int(11) NOT NULL,
    email       varchar(255)   DEFAULT NULL,
    senha       varchar(255)   DEFAULT NULL,
    level       int(11)        DEFAULT NULL,
    user        varchar(255)   DEFAULT NULL,
    email_token tinyint(4)     DEFAULT NULL,
    fee_percent decimal(11, 2) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO users (id, email, senha, `level`, `user`, email_token, fee_percent)
VALUES (1, 'admin@alexrosa.dev', '648715e7c8c0b10e11b468b0e9d7d3f8ed42506fc784bf1e8b183acbf51d84ae', 1, 'Admin', 1,
        '10.00'),
       (2, 'usuario@alexrosa.dev', 'abaef60d1c33d55e89233e1d5314bfb4df35ea73d59e63fbb77b96e3b5dd71c5', 2, 'Usuário', 1,
        '5.00');

CREATE TABLE users_level
(
    id    int(11)      NOT NULL,
    level varchar(255) NOT NULL,
    users tinyint(4) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO users_level (id, `level`, users)
VALUES (1, 'Administrador', 1),
       (2, 'Colaborador', 0);


CREATE TABLE api
(
    token varchar(255) NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
INSERT INTO api (token)
VALUES ('3c469e9d6c5875d37a43f353d4f88e61fcf812c66eee3457465a40b0da4153e0');

ALTER TABLE clients
    ADD PRIMARY KEY (id) USING BTREE;

ALTER TABLE config
    ADD PRIMARY KEY (id) USING BTREE;

ALTER TABLE orders
    ADD PRIMARY KEY (id);

ALTER TABLE order_products
    ADD PRIMARY KEY (id);

ALTER TABLE products
    ADD PRIMARY KEY (id);

ALTER TABLE sellers_fee
    ADD PRIMARY KEY (id);

ALTER TABLE uf
    ADD PRIMARY KEY (uf_id) USING BTREE;

ALTER TABLE users
    ADD PRIMARY KEY (id) USING BTREE,
    ADD KEY level (level) USING BTREE;

ALTER TABLE users_level
    ADD PRIMARY KEY (id) USING BTREE;


ALTER TABLE clients
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 11;

ALTER TABLE config
    MODIFY id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE orders
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 7;

ALTER TABLE order_products
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 16;

ALTER TABLE products
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 51;

ALTER TABLE sellers_fee
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

ALTER TABLE uf
    MODIFY uf_id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 29;

ALTER TABLE users
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

ALTER TABLE users_level
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;
