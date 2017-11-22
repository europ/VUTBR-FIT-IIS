-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: iis
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ceny_dodavatelu`
--

DROP TABLE IF EXISTS `ceny_dodavatelu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceny_dodavatelu` (
  `cena` int(11) NOT NULL,
  `id_dodavatele` int(10) unsigned DEFAULT NULL,
  `id_leku` int(10) unsigned DEFAULT NULL,
  KEY `ceny_dodavatelu_id_leku_foreign` (`id_leku`),
  KEY `ceny_dodavatelu_id_dodavatele_foreign` (`id_dodavatele`),
  CONSTRAINT `ceny_dodavatelu_id_dodavatele_foreign` FOREIGN KEY (`id_dodavatele`) REFERENCES `dodavatele` (`id_dodavatele`),
  CONSTRAINT `ceny_dodavatelu_id_leku_foreign` FOREIGN KEY (`id_leku`) REFERENCES `leky` (`id_leku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceny_dodavatelu`
--

LOCK TABLES `ceny_dodavatelu` WRITE;
/*!40000 ALTER TABLE `ceny_dodavatelu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ceny_dodavatelu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dodavatele`
--

DROP TABLE IF EXISTS `dodavatele`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dodavatele` (
  `id_dodavatele` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typ` int(11) NOT NULL,
  `datum_dodani` date NOT NULL,
  `platnost_smlouvy_od` date NOT NULL,
  `platnost_smlouvy_do` date NOT NULL,
  PRIMARY KEY (`id_dodavatele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dodavatele`
--

LOCK TABLES `dodavatele` WRITE;
/*!40000 ALTER TABLE `dodavatele` DISABLE KEYS */;
/*!40000 ALTER TABLE `dodavatele` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doplatky_pojistoven`
--

DROP TABLE IF EXISTS `doplatky_pojistoven`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doplatky_pojistoven` (
  `hrazena_cast` int(11) NOT NULL,
  `id_pojistovny` int(10) unsigned DEFAULT NULL,
  `id_leku` int(10) unsigned DEFAULT NULL,
  KEY `doplatky_pojistoven_id_leku_foreign` (`id_leku`),
  KEY `doplatky_pojistoven_id_pojistovny_foreign` (`id_pojistovny`),
  CONSTRAINT `doplatky_pojistoven_id_leku_foreign` FOREIGN KEY (`id_leku`) REFERENCES `leky` (`id_leku`),
  CONSTRAINT `doplatky_pojistoven_id_pojistovny_foreign` FOREIGN KEY (`id_pojistovny`) REFERENCES `pojistovny` (`id_pojistovny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doplatky_pojistoven`
--

LOCK TABLES `doplatky_pojistoven` WRITE;
/*!40000 ALTER TABLE `doplatky_pojistoven` DISABLE KEYS */;
/*!40000 ALTER TABLE `doplatky_pojistoven` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leky`
--

DROP TABLE IF EXISTS `leky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leky` (
  `id_leku` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cena` double(8,2) NOT NULL,
  PRIMARY KEY (`id_leku`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leky`
--

LOCK TABLES `leky` WRITE;
/*!40000 ALTER TABLE `leky` DISABLE KEYS */;
INSERT INTO `leky` VALUES (1,'Addaven',1084.00),(2,'Akineton',453.00),(3,'Alvesco',967.00),(4,'Anaya',464.00),(5,'Apo-Losartan',477.00),(6,'Arlevert',132.00),(7,'Aterogan',545.00),(8,'Baktevir',903.00),(9,'Betaserc',1044.00),(10,'Blessin Plus H',805.00),(11,'Buprenorphine Alkaloid',1416.00),(12,'Cardiket Retard',1044.00),(13,'Cholagol',361.00),(14,'Clobex',890.00),(15,'Copaxone',1022.00),(16,'Dafiro HCT',988.00),(17,'Dexoket',1160.00),(18,'Diprosone',1437.00),(19,'Duloxetin',472.00),(20,'Egiramlon',1360.00),(21,'Enoki',1349.00),(22,'Esomeprazol',1164.00),(23,'Famosan',1285.00),(24,'Flamexin',814.00),(25,'Forsteo',129.00),(26,'Gallax',204.00),(27,'Gleperil',958.00),(28,'Gyno-Pevaryl',447.00),(29,'Hyalgel',1098.00),(30,'Imprida',608.00),(31,'Isame',1471.00),(32,'Kanavit',681.00),(33,'Kreon',982.00),(34,'Lectazib',937.00),(35,'Levothyroxine',1066.00),(36,'Lomir',1380.00),(37,'Magrilan',990.00),(38,'Melovis',110.00),(39,'Milgamma N',782.00),(40,'Monopril',533.00),(41,'Myolastan',835.00),(42,'Nepla',698.00),(43,'Noradrenalin',1497.00),(44,'Olfen',1116.00),(45,'Osagrand',87.00),(46,'Panogastin',1019.00),(47,'Phaenya 21',604.00),(48,'Praxbind',1168.00),(49,'ProstaXin',956.00),(50,'Ramizek',997.00),(51,'Rennie',1027.00),(52,'Ristfor',805.00),(53,'Sagilia',661.00),(54,'Setinin',812.00),(55,'Solampti',119.00),(56,'Stadapress',711.00),(57,'Sustiva',937.00),(58,'Tasmar',998.00),(59,'Tezeo HCT',1079.00),(60,'Torri',534.00),(61,'Tropivent',105.00),(62,'Ursofalk',1049.00),(63,'Velavel',1136.00),(64,'Vidonorm',1008.00),(65,'Xadago',486.00),(66,'Zaracet',701.00),(67,'Zolafren',887.00);
/*!40000 ALTER TABLE `leky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leky_na_pobockach`
--

DROP TABLE IF EXISTS `leky_na_pobockach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leky_na_pobockach` (
  `mnozstvi` int(11) NOT NULL,
  `id_pobocky` int(10) unsigned DEFAULT NULL,
  `id_leku` int(10) unsigned DEFAULT NULL,
  KEY `leky_na_pobockach_id_leku_foreign` (`id_leku`),
  KEY `leky_na_pobockach_id_pobocky_foreign` (`id_pobocky`),
  CONSTRAINT `leky_na_pobockach_id_leku_foreign` FOREIGN KEY (`id_leku`) REFERENCES `leky` (`id_leku`),
  CONSTRAINT `leky_na_pobockach_id_pobocky_foreign` FOREIGN KEY (`id_pobocky`) REFERENCES `pobocky` (`id_pobocky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leky_na_pobockach`
--

LOCK TABLES `leky_na_pobockach` WRITE;
/*!40000 ALTER TABLE `leky_na_pobockach` DISABLE KEYS */;
INSERT INTO `leky_na_pobockach` VALUES (48,1,1),(8,1,2),(196,1,3),(67,1,4),(200,1,5),(72,1,6),(14,1,7),(10,1,8),(177,1,9),(18,1,10),(152,1,11),(25,1,12),(154,1,13),(194,1,14),(76,1,15),(197,1,16),(123,1,17),(148,1,18),(104,1,19),(31,1,20),(26,1,21),(24,1,22),(87,1,23),(9,1,24),(36,1,25),(72,1,26),(85,1,27),(150,1,28),(129,1,29),(189,1,30),(153,1,31),(178,1,32),(197,1,33),(149,1,34),(44,1,35),(196,1,36),(20,1,37),(59,1,38),(5,1,39),(198,1,40),(77,1,41),(158,1,42),(22,1,43),(31,1,44),(151,1,45),(98,1,46),(28,1,47),(74,1,48),(46,1,49),(132,1,50),(105,1,51),(73,1,52),(157,1,53),(193,1,54),(82,1,55),(193,1,56),(65,1,57),(168,1,58),(143,1,59),(194,1,60),(156,1,61),(96,1,62),(171,1,63),(152,1,64),(44,1,65),(15,1,66),(148,2,1),(65,2,2),(74,2,3),(154,2,4),(62,2,5),(152,2,6),(111,2,7),(85,2,8),(183,2,9),(62,2,10),(184,2,11),(11,2,12),(136,2,13),(29,2,14),(143,2,15),(41,2,16),(102,2,17),(99,2,18),(33,2,19),(184,2,20),(92,2,21),(98,2,22),(151,2,23),(34,2,24),(92,2,25),(107,2,26),(130,2,27),(63,2,28),(58,2,29),(175,2,30),(79,2,31),(6,2,32),(40,2,33),(153,2,34),(160,2,35),(102,2,36),(105,2,37),(71,2,38),(188,2,39),(88,2,40),(133,2,41),(171,2,42),(99,2,43),(68,2,44),(200,2,45),(42,2,46),(110,2,47),(102,2,48),(141,2,49),(144,2,50),(86,2,51),(33,2,52),(42,2,53),(37,2,54),(67,2,55),(134,2,56),(144,2,57),(198,2,58),(197,2,59),(2,2,60),(172,2,61),(75,2,62),(8,2,63),(11,2,64),(28,2,65),(168,2,66),(114,3,1),(134,3,2),(39,3,3),(101,3,4),(21,3,5),(172,3,6),(72,3,7),(121,3,8),(40,3,9),(72,3,10),(163,3,11),(150,3,12),(174,3,13),(104,3,14),(93,3,15),(60,3,16),(137,3,17),(135,3,18),(97,3,19),(3,3,20),(69,3,21),(40,3,22),(0,3,23),(66,3,24),(42,3,25),(173,3,26),(142,3,27),(51,3,28),(185,3,29),(170,3,30),(19,3,31),(98,3,32),(104,3,33),(58,3,34),(200,3,35),(126,3,36),(29,3,37),(72,3,38),(46,3,39),(70,3,40),(144,3,41),(8,3,42),(19,3,43),(118,3,44),(112,3,45),(113,3,46),(178,3,47),(49,3,48),(48,3,49),(75,3,50),(52,3,51),(118,3,52),(116,3,53),(53,3,54),(184,3,55),(158,3,56),(26,3,57),(125,3,58),(8,3,59),(10,3,60),(95,3,61),(27,3,62),(108,3,63),(199,3,64),(86,3,65),(108,3,66),(124,4,1),(115,4,2),(180,4,3),(171,4,4),(185,4,5),(124,4,6),(179,4,7),(4,4,8),(41,4,9),(91,4,10),(118,4,11),(19,4,12),(140,4,13),(167,4,14),(94,4,15),(193,4,16),(84,4,17),(9,4,18),(46,4,19),(67,4,20),(168,4,21),(72,4,22),(193,4,23),(177,4,24),(82,4,25),(87,4,26),(4,4,27),(191,4,28),(86,4,29),(90,4,30),(98,4,31),(10,4,32),(5,4,33),(78,4,34),(181,4,35),(190,4,36),(1,4,37),(159,4,38),(195,4,39),(42,4,40),(50,4,41),(112,4,42),(62,4,43),(190,4,44),(78,4,45),(156,4,46),(183,4,47),(163,4,48),(166,4,49),(28,4,50),(29,4,51),(133,4,52),(100,4,53),(21,4,54),(110,4,55),(182,4,56),(109,4,57),(114,4,58),(172,4,59),(195,4,60),(4,4,61),(70,4,62),(4,4,63),(9,4,64),(148,4,65),(185,4,66),(193,6,1),(27,6,2),(109,6,3),(50,6,4),(40,6,5),(139,6,6),(117,6,7),(20,6,8),(117,6,9),(159,6,10),(195,6,11),(71,6,12),(107,6,13),(62,6,14),(24,6,15),(73,6,16),(6,6,17),(85,6,18),(172,6,19),(199,6,20),(48,6,21),(5,6,22),(108,6,23),(118,6,24),(185,6,25),(82,6,26),(79,6,27),(109,6,28),(70,6,29),(76,6,30),(173,6,31),(62,6,32),(103,6,33),(81,6,34),(113,6,35),(144,6,36),(20,6,37),(30,6,38),(164,6,39),(137,6,40),(189,6,41),(158,6,42),(8,6,43),(96,6,44),(20,6,45),(33,6,46),(169,6,47),(27,6,48),(118,6,49),(141,6,50),(25,6,51),(167,6,52),(146,6,53),(133,6,54),(84,6,55),(131,6,56),(15,6,57),(164,6,58),(40,6,59),(85,6,60),(40,6,61),(13,6,62),(148,6,63),(144,6,64),(94,6,65),(60,6,66),(87,7,1),(115,7,2),(91,7,3),(51,7,4),(51,7,5),(79,7,6),(9,7,7),(59,7,8),(175,7,9),(29,7,10),(93,7,11),(144,7,12),(57,7,13),(10,7,14),(85,7,15),(82,7,16),(178,7,17),(30,7,18),(15,7,19),(61,7,20),(162,7,21),(30,7,22),(25,7,23),(2,7,24),(116,7,25),(65,7,26),(15,7,27),(63,7,28),(8,7,29),(110,7,30),(124,7,31),(96,7,32),(24,7,33),(14,7,34),(147,7,35),(75,7,36),(93,7,37),(156,7,38),(135,7,39),(68,7,40),(186,7,41),(27,7,42),(12,7,43),(42,7,44),(38,7,45),(97,7,46),(125,7,47),(15,7,48),(128,7,49),(141,7,50),(77,7,51),(89,7,52),(172,7,53),(103,7,54),(92,7,55),(87,7,56),(168,7,57),(107,7,58),(150,7,59),(177,7,60),(16,7,61),(73,7,62),(72,7,63),(40,7,64),(87,7,65),(18,7,66),(116,8,1),(181,8,2),(175,8,3),(50,8,4),(48,8,5),(161,8,6),(78,8,7),(61,8,8),(3,8,9),(117,8,10),(158,8,11),(128,8,12),(133,8,13),(85,8,14),(68,8,15),(9,8,16),(174,8,17),(39,8,18),(113,8,19),(65,8,20),(127,8,21),(80,8,22),(173,8,23),(76,8,24),(56,8,25),(189,8,26),(150,8,27),(129,8,28),(29,8,29),(37,8,30),(147,8,31),(145,8,32),(17,8,33),(122,8,34),(196,8,35),(66,8,36),(82,8,37),(73,8,38),(127,8,39),(85,8,40),(190,8,41),(84,8,42),(13,8,43),(122,8,44),(169,8,45),(82,8,46),(132,8,47),(143,8,48),(122,8,49),(44,8,50),(8,8,51),(48,8,52),(125,8,53),(182,8,54),(125,8,55),(182,8,56),(170,8,57),(74,8,58),(110,8,59),(200,8,60),(111,8,61),(57,8,62),(144,8,63),(129,8,64),(179,8,65),(139,8,66);
/*!40000 ALTER TABLE `leky_na_pobockach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(4,'2017_10_18_185308_extending_users_table',2),(17,'2017_10_19_135208_leky',3),(18,'2017_10_20_124843_pobocky',3),(19,'2017_10_20_124857_rezervace',3),(20,'2017_10_20_125012_rezervace_leky',3),(21,'2017_10_20_125023_pojistovny',3),(22,'2017_10_20_125040_predpisy',3),(23,'2017_10_20_125052_predpisy_leky',3),(24,'2017_10_20_125057_dodavatele',3),(25,'2017_10_20_125106_leky_na_pobockach',3),(26,'2017_10_20_125114_prodane_leky',3),(27,'2017_10_20_125127_doplatky_pojistoven',3),(28,'2017_10_20_125141_ceny_dodavatelu',3),(29,'2017_10_27_132338_add_timestamps_to_rezervace_table',3),(30,'2017_11_19_093125_AddPobockaColToUser',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pobocky`
--

DROP TABLE IF EXISTS `pobocky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pobocky` (
  `id_pobocky` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev_pobocky` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresa_ulice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresa_cislo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresa_mesto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresa_psc` int(11) NOT NULL,
  PRIMARY KEY (`id_pobocky`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pobocky`
--

LOCK TABLES `pobocky` WRITE;
/*!40000 ALTER TABLE `pobocky` DISABLE KEYS */;
INSERT INTO `pobocky` VALUES (1,'Afrodite','Porici','5','Brno',63900),(2,'Nemesis','Technicka','3058/10','Brno',61600),(3,'Markus','Brezová, 723/20','723/20','Dunajská Lužná',90042),(4,'Pothos','Bozetechova','2','Brno',61266),(5,'Themis','Kolejni','2906/4','Brno',61200),(6,'Tyche','Veveru','331/95','Brno',60200),(7,'Asklepios','Technicka','2896/2','Brno',61669),(8,'Dionysos','Udolni','244/53','Brno',60200);
/*!40000 ALTER TABLE `pobocky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pojistovny`
--

DROP TABLE IF EXISTS `pojistovny`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pojistovny` (
  `id_pojistovny` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev_pojistovny` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pojistovny`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pojistovny`
--

LOCK TABLES `pojistovny` WRITE;
/*!40000 ALTER TABLE `pojistovny` DISABLE KEYS */;
INSERT INTO `pojistovny` VALUES (1,'Addaven');
/*!40000 ALTER TABLE `pojistovny` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `predpisy`
--

DROP TABLE IF EXISTS `predpisy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predpisy` (
  `id_predpisu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rodne_cislo` int(11) NOT NULL,
  `id_pojistovny` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_predpisu`),
  KEY `predpisy_id_pojistovny_foreign` (`id_pojistovny`),
  CONSTRAINT `predpisy_id_pojistovny_foreign` FOREIGN KEY (`id_pojistovny`) REFERENCES `pojistovny` (`id_pojistovny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `predpisy`
--

LOCK TABLES `predpisy` WRITE;
/*!40000 ALTER TABLE `predpisy` DISABLE KEYS */;
/*!40000 ALTER TABLE `predpisy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `predpisy_leky`
--

DROP TABLE IF EXISTS `predpisy_leky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predpisy_leky` (
  `id_leku` int(10) unsigned DEFAULT NULL,
  `id_predpisu` int(10) unsigned DEFAULT NULL,
  KEY `predpisy_leky_id_leku_foreign` (`id_leku`),
  KEY `predpisy_leky_id_predpisu_foreign` (`id_predpisu`),
  CONSTRAINT `predpisy_leky_id_leku_foreign` FOREIGN KEY (`id_leku`) REFERENCES `leky` (`id_leku`),
  CONSTRAINT `predpisy_leky_id_predpisu_foreign` FOREIGN KEY (`id_predpisu`) REFERENCES `predpisy` (`id_predpisu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `predpisy_leky`
--

LOCK TABLES `predpisy_leky` WRITE;
/*!40000 ALTER TABLE `predpisy_leky` DISABLE KEYS */;
/*!40000 ALTER TABLE `predpisy_leky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodane_leky`
--

DROP TABLE IF EXISTS `prodane_leky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodane_leky` (
  `id_prodej` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mnozstvi` int(11) NOT NULL,
  `datum` date NOT NULL,
  `id_pobocky` int(10) unsigned DEFAULT NULL,
  `id_leku` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_prodej`),
  KEY `prodane_leky_id_leku_foreign` (`id_leku`),
  KEY `prodane_leky_id_pobocky_foreign` (`id_pobocky`),
  CONSTRAINT `prodane_leky_id_leku_foreign` FOREIGN KEY (`id_leku`) REFERENCES `leky` (`id_leku`),
  CONSTRAINT `prodane_leky_id_pobocky_foreign` FOREIGN KEY (`id_pobocky`) REFERENCES `pobocky` (`id_pobocky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodane_leky`
--

LOCK TABLES `prodane_leky` WRITE;
/*!40000 ALTER TABLE `prodane_leky` DISABLE KEYS */;
/*!40000 ALTER TABLE `prodane_leky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rezervace`
--

DROP TABLE IF EXISTS `rezervace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rezervace` (
  `id_rezervace` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jmeno_zakaznika` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rezervace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rezervace`
--

LOCK TABLES `rezervace` WRITE;
/*!40000 ALTER TABLE `rezervace` DISABLE KEYS */;
/*!40000 ALTER TABLE `rezervace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rezervace_leky`
--

DROP TABLE IF EXISTS `rezervace_leky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rezervace_leky` (
  `id_leku` int(10) unsigned DEFAULT NULL,
  `id_rezervace` int(10) unsigned DEFAULT NULL,
  KEY `rezervace_leky_id_leku_foreign` (`id_leku`),
  KEY `rezervace_leky_id_rezervace_foreign` (`id_rezervace`),
  CONSTRAINT `rezervace_leky_id_leku_foreign` FOREIGN KEY (`id_leku`) REFERENCES `leky` (`id_leku`),
  CONSTRAINT `rezervace_leky_id_rezervace_foreign` FOREIGN KEY (`id_rezervace`) REFERENCES `rezervace` (`id_rezervace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rezervace_leky`
--

LOCK TABLES `rezervace_leky` WRITE;
/*!40000 ALTER TABLE `rezervace_leky` DISABLE KEYS */;
/*!40000 ALTER TABLE `rezervace_leky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `id_pobocky` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_id_pobocky_foreign` (`id_pobocky`),
  CONSTRAINT `users_id_pobocky_foreign` FOREIGN KEY (`id_pobocky`) REFERENCES `pobocky` (`id_pobocky`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'Sokoliar Tomáš','sokoliar@tomas.sk','$2y$10$TwzUx4GwzdsZkxJfY1AlW.FfjqYk8k/lGRX/iXQ1zccCGYu7n6LOS','N2xEE23IS2k9Koz6qMpgL4okwo4qxyKrFMBkZRpKhm8EqQ0vnx0fQuiIyW0d','2017-10-18 21:01:37','2017-11-21 21:02:54',1,4),(11,'John Test','john@test.com','$2y$10$j6Tn4GHp3rVZyZCy.dEZIuCOyQkkriCBQSTCgR1937SJQO.HePQ1m','Qs8GW7dD6028VQhqfrry75gW17m7YdYEyoYzeKyMhPfJh2M73t50Oo8xw6go','2017-11-18 22:45:02','2017-11-19 10:21:07',0,5),(12,'Marek Schauer','marek.schauer@psoit.sk','$2y$10$FiEzzIgl4sbfdX.04SuhPu5eo/PqJSGrFw0Gu2ksaElrZfl6yTxgW','ZYtjSfE7Z9LfR6kwGH5keUGsaGN077VqfDhLT4ebAPTG1za1z6z4f2oZusIc','2017-11-19 10:03:31','2017-11-19 10:03:31',0,4),(13,'Adrian Toth','adrian@toth.sk','$2y$10$B0IELffnA1ExajJFzU.7Z.zdHcqpcBHYTeUv/tOpmbPRpT0KFG2jm',NULL,'2017-11-19 10:03:52','2017-11-19 10:03:52',0,7),(14,'Peter Suhaj','peter@suhaj.sk','$2y$10$NqdeICOHIaHIqLLnHyfs0ujVw2XR4shKkUk9R9vhbIJnaQIlp.QuO',NULL,'2017-11-19 10:04:10','2017-11-19 10:04:10',0,7);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-22 15:00:23
