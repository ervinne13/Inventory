-- MySQL dump 10.16  Distrib 10.1.25-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: inventory
-- ------------------------------------------------------
-- Server version	10.1.25-MariaDB

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
-- Table structure for table `access_control`
--

DROP TABLE IF EXISTS `access_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_control` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_control`
--

LOCK TABLES `access_control` WRITE;
/*!40000 ALTER TABLE `access_control` DISABLE KEYS */;
INSERT INTO `access_control` VALUES ('AUTHOR','Author',NULL,NULL),('MANAGER','Manager',NULL,NULL),('VIEWER','Viewer',NULL,NULL);
/*!40000 ALTER TABLE `access_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `access_control_list`
--

DROP TABLE IF EXISTS `access_control_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_control_list` (
  `role_code` varchar(32) NOT NULL,
  `module_code` varchar(32) NOT NULL,
  `access_control_code` varchar(32) NOT NULL,
  PRIMARY KEY (`role_code`,`module_code`)
) ENGINE=InnoDB DEFAULT CHARSET=cp850;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_control_list`
--

LOCK TABLES `access_control_list` WRITE;
/*!40000 ALTER TABLE `access_control_list` DISABLE KEYS */;
INSERT INTO `access_control_list` VALUES ('ACCT','ER','MANAGER'),('ACCT','I','VIEWER'),('ACCT','IM','VIEWER'),('ACCT','IR','VIEWER'),('ACCT','PRO','VIEWER'),('ACCT','TO','VIEWER'),('ACCT','UOM','VIEWER'),('AUDIT','ER','VIEWER'),('AUDIT','I','VIEWER'),('AUDIT','IM','VIEWER'),('AUDIT','IR','VIEWER'),('AUDIT','PRO','VIEWER'),('AUDIT','TO','VIEWER'),('AUDIT','UOM','VIEWER'),('PLDMAN','I','AUTHOR'),('PLDMAN','IM','MANAGER'),('PLDMAN','IR','MANAGER'),('PLDMAN','TO','MANAGER'),('PLDMAN','UOM','MANAGER'),('PLDSTF','I','VIEWER'),('PLDSTF','IM','AUTHOR'),('PLDSTF','IR','AUTHOR'),('PLDSTF','TO','AUTHOR'),('PLDSTF','UOM','AUTHOR'),('PRODMAN','BOM','MANAGER'),('PRODMAN','I','AUTHOR'),('PRODMAN','IM','VIEWER'),('PRODMAN','PRO','MANAGER'),('PRODSTF','BOM','AUTHOR'),('PRODSTF','I','VIEWER'),('PRODSTF','IM','VIEWER'),('PRODSTF','PRO','AUTHOR'),('RCVNG','I','VIEWER'),('RCVNG','IM','AUTHOR');
/*!40000 ALTER TABLE `access_control_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_of_materials`
--

DROP TABLE IF EXISTS `bill_of_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_of_materials` (
  `code` varchar(32) NOT NULL,
  `produced_item_type` varchar(32) DEFAULT NULL,
  `produced_item_code` varchar(32) NOT NULL,
  `produced_item_name` varchar(64) NOT NULL,
  `produced_item_uom_code` varchar(32) NOT NULL,
  `produced_qty` float NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_bill_of_materials_item1_idx` (`produced_item_code`),
  CONSTRAINT `fk_bill_of_materials_item1` FOREIGN KEY (`produced_item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_of_materials`
--

LOCK TABLES `bill_of_materials` WRITE;
/*!40000 ALTER TABLE `bill_of_materials` DISABLE KEYS */;
INSERT INTO `bill_of_materials` VALUES ('BOM-2017-00001','PROD','PROD_BLTSHLD','HYTORC BoltShield Protection Cap','UNIT',1,'2017-09-01 02:18:14',NULL,'2017-09-01 02:18:14',NULL);
/*!40000 ALTER TABLE `bill_of_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text,
  `mode_of_costing` varchar(32) DEFAULT NULL COMMENT '''AVG/FIFO/LIFO''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES ('HYTORC','HYTORC',NULL,'FIFO',NULL,NULL);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES ('JPY','Japanese Yen',1),('KRW','Korean Won',1),('PHP','Philippine Peso',1),('USD','US Dollar',1);
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange_rate`
--

DROP TABLE IF EXISTS `exchange_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_rate` (
  `date` date NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange_rate`
--

LOCK TABLES `exchange_rate` WRITE;
/*!40000 ALTER TABLE `exchange_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange_rate_detail`
--

DROP TABLE IF EXISTS `exchange_rate_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_rate_detail` (
  `line_no` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `exchange_rate_date` date NOT NULL,
  `base_currency_code` varchar(32) NOT NULL,
  `conv_currency_code` varchar(32) NOT NULL,
  `rate` decimal(12,10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`line_no`),
  KEY `fk_exchange_rate_details_exchange_rate1_idx` (`exchange_rate_date`),
  KEY `fk_exchange_rate_details_currency1_idx` (`base_currency_code`),
  KEY `fk_exchange_rate_details_currency2_idx` (`conv_currency_code`),
  CONSTRAINT `fk_exchange_rate_details_currency1` FOREIGN KEY (`base_currency_code`) REFERENCES `currency` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_exchange_rate_details_currency2` FOREIGN KEY (`conv_currency_code`) REFERENCES `currency` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_exchange_rate_details_exchange_rate1` FOREIGN KEY (`exchange_rate_date`) REFERENCES `exchange_rate` (`date`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange_rate_detail`
--

LOCK TABLES `exchange_rate_detail` WRITE;
/*!40000 ALTER TABLE `exchange_rate_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_rate_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_stock_stack`
--

DROP TABLE IF EXISTS `inventory_stock_stack`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_stock_stack` (
  `entry_date_time` datetime NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_uom_code` varchar(32) NOT NULL,
  `company_code` varchar(32) NOT NULL,
  `location_code` varchar(32) NOT NULL,
  `unit_cost` decimal(7,2) NOT NULL,
  `item_type_code` varchar(32) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`entry_date_time`,`item_code`,`item_uom_code`,`company_code`,`location_code`,`unit_cost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_stock_stack`
--

LOCK TABLES `inventory_stock_stack` WRITE;
/*!40000 ALTER TABLE `inventory_stock_stack` DISABLE KEYS */;
INSERT INTO `inventory_stock_stack` VALUES ('2017-09-01 10:19:25','BRM_00000','pc','HYTORC','W_QC1',0.50,'BRM',50),('2017-09-10 11:41:23','PROD_ARMITELED','unit','HYTORC','B_HSQC',150.00,'PROD',185),('2017-09-10 12:35:53','PROD_BLTSHLD','unit','HYTORC','B_HSQC',20.00,'PROD',480),('2017-09-10 14:36:29','BRM_00001','pc','HYTORC','B_HSQC',0.50,'BRM',120);
/*!40000 ALTER TABLE `inventory_stock_stack` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `code` varchar(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `item_type_code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `default_currency_code` varchar(32) NOT NULL DEFAULT 'PHP',
  `default_unit_cost` decimal(7,2) DEFAULT '0.00',
  `created_by` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `threshold_low` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`),
  KEY `fk_item_item_type1_idx` (`item_type_code`),
  CONSTRAINT `fk_item_item_type1` FOREIGN KEY (`item_type_code`) REFERENCES `item_type` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES ('BRM_00000',1,'BRM','Sample Raw Material - BRM 00000','PHP',0.00,'admin',NULL,'admin','2017-09-01 02:18:17',0),('BRM_00001',1,'BRM','Sample Raw Material - BRM 00001','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00002',1,'BRM','Sample Raw Material - BRM 00002','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00003',1,'BRM','Sample Raw Material - BRM 00003','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00004',1,'BRM','Sample Raw Material - BRM 00004','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00005',1,'BRM','Sample Raw Material - BRM 00005','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00006',1,'BRM','Sample Raw Material - BRM 00006','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00007',1,'BRM','Sample Raw Material - BRM 00007','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00008',1,'BRM','Sample Raw Material - BRM 00008','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00009',1,'BRM','Sample Raw Material - BRM 00009','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00010',1,'BRM','Sample Raw Material - BRM 00010','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00011',1,'BRM','Sample Raw Material - BRM 00011','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00012',1,'BRM','Sample Raw Material - BRM 00012','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00013',1,'BRM','Sample Raw Material - BRM 00013','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00014',1,'BRM','Sample Raw Material - BRM 00014','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00015',1,'BRM','Sample Raw Material - BRM 00015','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00016',1,'BRM','Sample Raw Material - BRM 00016','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00017',1,'BRM','Sample Raw Material - BRM 00017','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00018',1,'BRM','Sample Raw Material - BRM 00018','PHP',0.00,NULL,NULL,NULL,NULL,0),('BRM_00019',1,'BRM','Sample Raw Material - BRM 00019','PHP',0.00,NULL,NULL,NULL,NULL,0),('FA_PRESS_001',1,'FA','Example Machine Press 01','PHP',0.00,NULL,NULL,NULL,NULL,0),('FA_PRESS_002',1,'FA','Example Machine Press 02','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00000',1,'GRM','Sample Raw Material - GRM 00000','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00001',1,'GRM','Sample Raw Material - GRM 00001','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00002',1,'GRM','Sample Raw Material - GRM 00002','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00003',1,'GRM','Sample Raw Material - GRM 00003','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00004',1,'GRM','Sample Raw Material - GRM 00004','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00005',1,'GRM','Sample Raw Material - GRM 00005','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00006',1,'GRM','Sample Raw Material - GRM 00006','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00007',1,'GRM','Sample Raw Material - GRM 00007','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00008',1,'GRM','Sample Raw Material - GRM 00008','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00009',1,'GRM','Sample Raw Material - GRM 00009','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00010',1,'GRM','Sample Raw Material - GRM 00010','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00011',1,'GRM','Sample Raw Material - GRM 00011','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00012',1,'GRM','Sample Raw Material - GRM 00012','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00013',1,'GRM','Sample Raw Material - GRM 00013','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00014',1,'GRM','Sample Raw Material - GRM 00014','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00015',1,'GRM','Sample Raw Material - GRM 00015','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00016',1,'GRM','Sample Raw Material - GRM 00016','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00017',1,'GRM','Sample Raw Material - GRM 00017','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00018',1,'GRM','Sample Raw Material - GRM 00018','PHP',0.00,NULL,NULL,NULL,NULL,0),('GRM_00019',1,'GRM','Sample Raw Material - GRM 00019','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00000',1,'MRM','Sample Raw Material - MRM 00000','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00001',1,'MRM','Sample Raw Material - MRM 00001','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00002',1,'MRM','Sample Raw Material - MRM 00002','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00003',1,'MRM','Sample Raw Material - MRM 00003','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00004',1,'MRM','Sample Raw Material - MRM 00004','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00005',1,'MRM','Sample Raw Material - MRM 00005','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00006',1,'MRM','Sample Raw Material - MRM 00006','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00007',1,'MRM','Sample Raw Material - MRM 00007','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00008',1,'MRM','Sample Raw Material - MRM 00008','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00009',1,'MRM','Sample Raw Material - MRM 00009','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00010',1,'MRM','Sample Raw Material - MRM 00010','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00011',1,'MRM','Sample Raw Material - MRM 00011','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00012',1,'MRM','Sample Raw Material - MRM 00012','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00013',1,'MRM','Sample Raw Material - MRM 00013','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00014',1,'MRM','Sample Raw Material - MRM 00014','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00015',1,'MRM','Sample Raw Material - MRM 00015','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00016',1,'MRM','Sample Raw Material - MRM 00016','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00017',1,'MRM','Sample Raw Material - MRM 00017','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00018',1,'MRM','Sample Raw Material - MRM 00018','PHP',0.00,NULL,NULL,NULL,NULL,0),('MRM_00019',1,'MRM','Sample Raw Material - MRM 00019','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00000',1,'PRM','Sample Raw Material - PRM 00000','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00001',1,'PRM','Sample Raw Material - PRM 00001','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00002',1,'PRM','Sample Raw Material - PRM 00002','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00003',1,'PRM','Sample Raw Material - PRM 00003','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00004',1,'PRM','Sample Raw Material - PRM 00004','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00005',1,'PRM','Sample Raw Material - PRM 00005','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00006',1,'PRM','Sample Raw Material - PRM 00006','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00007',1,'PRM','Sample Raw Material - PRM 00007','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00008',1,'PRM','Sample Raw Material - PRM 00008','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00009',1,'PRM','Sample Raw Material - PRM 00009','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00010',1,'PRM','Sample Raw Material - PRM 00010','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00011',1,'PRM','Sample Raw Material - PRM 00011','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00012',1,'PRM','Sample Raw Material - PRM 00012','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00013',1,'PRM','Sample Raw Material - PRM 00013','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00014',1,'PRM','Sample Raw Material - PRM 00014','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00015',1,'PRM','Sample Raw Material - PRM 00015','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00016',1,'PRM','Sample Raw Material - PRM 00016','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00017',1,'PRM','Sample Raw Material - PRM 00017','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00018',1,'PRM','Sample Raw Material - PRM 00018','PHP',0.00,NULL,NULL,NULL,NULL,0),('PRM_00019',1,'PRM','Sample Raw Material - PRM 00019','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_ARMITELED',1,'PROD','HYTORC Armite LED Plate','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_BLTSHLD',1,'PROD','HYTORC BoltShield Protection Cap','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_HYDRAPUMP',1,'PROD','HYTORC Hydraulic Pump','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_JGUND',1,'PROD','HYTORC J-Gun Dual Speed','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_JGUNS',1,'PROD','HYTORC J-Gun Single Speed','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_PNEUMAPUMP',1,'PROD','HYTORC Pneumatic Pump','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_WSHR_2015',1,'PROD','HYTORC Washer (2015 Model)','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_WSHR_2016',1,'PROD','HYTORC Washer (2016 Model)','PHP',0.00,NULL,NULL,NULL,NULL,0),('PROD_ZGUN',1,'PROD','HYTORC Z-Gun','PHP',0.00,NULL,NULL,NULL,NULL,0),('SRVC_HR_AGNT_Cost',1,'SRVC','Manpower Agency HR Cost','PHP',0.00,NULL,NULL,NULL,NULL,0),('SRVC_HR_Cost',1,'SRVC','Human Resource Cost','PHP',0.00,NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_image`
--

DROP TABLE IF EXISTS `item_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_code` varchar(32) NOT NULL,
  `image_url` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_image_item1_idx` (`item_code`),
  CONSTRAINT `fk_item_image_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_image`
--

LOCK TABLES `item_image` WRITE;
/*!40000 ALTER TABLE `item_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_movement`
--

DROP TABLE IF EXISTS `item_movement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_movement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ref_doc_type` varchar(32) NOT NULL,
  `ref_doc_no` varchar(32) NOT NULL,
  `movement_date` datetime NOT NULL,
  `company_code` varchar(32) NOT NULL,
  `location_code` varchar(32) NOT NULL,
  `item_type_code` varchar(32) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_uom_code` varchar(32) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `unit_cost` decimal(12,2) NOT NULL DEFAULT '1.00',
  `remarks` text,
  `status` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  `item_source` varchar(32) DEFAULT NULL,
  `item_source_type` varchar(32) DEFAULT NULL COMMENT 'Others / Supplier',
  PRIMARY KEY (`id`),
  KEY `fk_item_movement_item_movement_source1_idx` (`ref_doc_type`),
  KEY `fk_item_movement_location1_idx` (`company_code`,`location_code`),
  CONSTRAINT `fk_item_movement_item_movement_source1` FOREIGN KEY (`ref_doc_type`) REFERENCES `item_movement_source` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_movement_location1` FOREIGN KEY (`company_code`, `location_code`) REFERENCES `location` (`company_code`, `code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_movement`
--

LOCK TABLES `item_movement` WRITE;
/*!40000 ALTER TABLE `item_movement` DISABLE KEYS */;
INSERT INTO `item_movement` VALUES (1,'IAAG','123456','2017-09-01 10:19:00','HYTORC','W_QC1','BRM','BRM_00000','Sample Raw Material - BRM 00000','pc',50,0.50,'Test for overstock','Posted','2017-09-01 02:19:25','admin','2017-09-01 02:19:25','admin',NULL,NULL),(3,'PROO','PROD-0001','2017-09-10 11:40:00','HYTORC','B_HSQC','PROD','PROD_ARMITELED','HYTORC Armite LED Plate','unit',200,150.00,'12345678','Posted','2017-09-10 03:41:23','admin','2017-09-10 03:41:23','admin',NULL,NULL),(5,'SI','SI-00001','2017-09-10 11:40:00','HYTORC','B_HSQC','PROD','PROD_ARMITELED','HYTORC Armite LED Plate','unit',10,200.00,'test','Posted','2017-09-10 03:41:48','admin','2017-09-10 03:41:49','admin',NULL,NULL),(6,'SI','SI-00002','2017-09-10 12:34:00','HYTORC','B_HSQC','PROD','PROD_ARMITELED','HYTORC Armite LED Plate','unit',5,200.00,'123456','Posted','2017-09-10 04:35:14','admin','2017-09-10 04:35:15','admin',NULL,NULL),(7,'PROO','PROD-00012','2017-09-10 12:35:00','HYTORC','B_HSQC','PROD','PROD_BLTSHLD','HYTORC BoltShield Protection Cap','unit',500,20.00,'123456u','Posted','2017-09-10 04:35:53','admin','2017-09-10 04:35:53','admin',NULL,NULL),(8,'SI','SI-000003','2017-09-10 12:36:00','HYTORC','B_HSQC','PROD','PROD_BLTSHLD','HYTORC BoltShield Protection Cap','unit',20,20.00,'1234567','Posted','2017-09-10 04:36:40','admin','2017-09-10 04:36:40','admin',NULL,NULL),(9,'IAAG','SI-00004','2017-09-11 02:09:00','HYTORC','B_HSQC','BRM','BRM_00002','Sample Raw Material - BRM 00002','pc',3,20.00,'test edit 3','Open','2017-09-10 06:10:53','admin','2017-09-10 06:15:00','admin',NULL,NULL),(10,'IAAG','ADJ-00001','2017-09-11 02:26:00','HYTORC','B_HSQC','BRM','BRM_00001','Sample Raw Material - BRM 00001','pc',100,0.50,'123456ui','Open','2017-09-10 06:28:54','admin','2017-09-10 06:28:54',NULL,NULL,NULL),(11,'IAAG','ADJ-00001','2017-09-11 02:26:00','HYTORC','B_HSQC','BRM','BRM_00001','Sample Raw Material - BRM 00001','pc',100,0.50,'123456ui','Open','2017-09-10 06:29:02','admin','2017-09-10 06:29:02',NULL,NULL,NULL),(12,'IAAG','ADJ-00001','2017-09-11 02:26:00','HYTORC','B_HSQC','BRM','BRM_00001','Sample Raw Material - BRM 00001','pc',100,0.50,'123456ui','Open','2017-09-10 06:29:17','admin','2017-09-10 06:29:17',NULL,NULL,NULL),(13,'IAAG','ADJ-00001','2017-09-11 02:26:00','HYTORC','B_HSQC','BRM','BRM_00001','Sample Raw Material - BRM 00001','pc',120,0.50,'test remarks','Posted','2017-09-10 06:29:27','admin','2017-09-10 06:36:30','admin',NULL,NULL),(14,'IAAG','123456u','2017-09-11 02:37:00','HYTORC','B_HSQC','BRM','BRM_00001','Sample Raw Material - BRM 00001','pc',12,12.00,'test movement','Open','2017-09-10 06:37:11','admin','2017-09-10 06:37:11',NULL,NULL,NULL);
/*!40000 ALTER TABLE `item_movement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_movement_source`
--

DROP TABLE IF EXISTS `item_movement_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_movement_source` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `nature` varchar(32) NOT NULL COMMENT '''Gain/Loss''\n',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_movement_source`
--

LOCK TABLES `item_movement_source` WRITE;
/*!40000 ALTER TABLE `item_movement_source` DISABLE KEYS */;
INSERT INTO `item_movement_source` VALUES ('IAAG','Item Accounting Adjustment (Gain)','Gain'),('IAAL','Item Accounting Adjustment (Loss)','Loss'),('IRO','Item Reclass Output','Gain'),('IRU','Item Reclass Usage','Loss'),('PCO','Physical Count Overage','Gain'),('PCS','Physical Count Shortage','Loss'),('PO','Purchase Order','Gain'),('PROO','Production Output','Gain'),('PROU','Production Usage','Loss'),('SI','Sales Invoice','Loss'),('TOI','Transfer Order In','Gain'),('TOO','Transfer Order Out','Loss');
/*!40000 ALTER TABLE `item_movement_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_reclass`
--

DROP TABLE IF EXISTS `item_reclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_reclass` (
  `doc_no` varchar(32) NOT NULL,
  `doc_date` date NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`doc_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_reclass`
--

LOCK TABLES `item_reclass` WRITE;
/*!40000 ALTER TABLE `item_reclass` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_reclass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_reclass_detail`
--

DROP TABLE IF EXISTS `item_reclass_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_reclass_detail` (
  `line_no` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(32) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `original_uom_code` varchar(32) NOT NULL,
  `new_uom_code` varchar(32) NOT NULL,
  `item_cost` decimal(7,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`line_no`),
  KEY `fk_item_reclass_detail_item_reclass1_idx` (`doc_no`),
  KEY `fk_item_reclass_detail_item1_idx` (`item_code`),
  KEY `fk_item_reclass_detail_item_uom1_idx` (`original_uom_code`),
  KEY `fk_item_reclass_detail_item_uom2_idx` (`new_uom_code`),
  CONSTRAINT `fk_item_reclass_detail_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_reclass_detail_item_reclass1` FOREIGN KEY (`doc_no`) REFERENCES `item_reclass` (`doc_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_reclass_detail_item_uom1` FOREIGN KEY (`original_uom_code`) REFERENCES `item_uom` (`uom_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_item_reclass_detail_item_uom2` FOREIGN KEY (`new_uom_code`) REFERENCES `item_uom` (`uom_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_reclass_detail`
--

LOCK TABLES `item_reclass_detail` WRITE;
/*!40000 ALTER TABLE `item_reclass_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_reclass_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_type`
--

DROP TABLE IF EXISTS `item_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_type` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `inventoriable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_type`
--

LOCK TABLES `item_type` WRITE;
/*!40000 ALTER TABLE `item_type` DISABLE KEYS */;
INSERT INTO `item_type` VALUES ('BRM','Bolts Raw Materials',1),('FA','Fixed Asset',0),('GRM','General Raw Materials',1),('MRM','Metal Raw Materials',1),('PRM','Plastic Raw Materials',1),('PROD','Products',1),('SRVC','Services',0);
/*!40000 ALTER TABLE `item_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_uom`
--

DROP TABLE IF EXISTS `item_uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_uom` (
  `item_code` varchar(32) NOT NULL,
  `uom_code` varchar(32) NOT NULL,
  `is_base_uom` tinyint(1) NOT NULL DEFAULT '0',
  `base_uom_code` varchar(32) DEFAULT NULL,
  `base_uom_conv_multiplier` decimal(12,10) DEFAULT '1.0000000000',
  `base_uom_conv_divider` decimal(12,10) DEFAULT '1.0000000000',
  PRIMARY KEY (`item_code`,`uom_code`),
  KEY `fk_unit_of_measurement_has_item_item1_idx` (`item_code`),
  KEY `fk_unit_of_measurement_has_item_unit_of_measurement1_idx` (`uom_code`),
  KEY `fk_item_uom_item_uom1_idx` (`base_uom_code`),
  CONSTRAINT `fk_item_uom_item_uom1` FOREIGN KEY (`base_uom_code`) REFERENCES `item_uom` (`uom_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_unit_of_measurement_has_item_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_unit_of_measurement_has_item_unit_of_measurement1` FOREIGN KEY (`uom_code`) REFERENCES `unit_of_measurement` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_uom`
--

LOCK TABLES `item_uom` WRITE;
/*!40000 ALTER TABLE `item_uom` DISABLE KEYS */;
INSERT INTO `item_uom` VALUES ('BRM_00001','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00002','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00003','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00004','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00005','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00006','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00007','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00008','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00009','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00010','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00011','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00012','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00013','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00014','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00015','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00016','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00017','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00018','pc',1,NULL,1.0000000000,1.0000000000),('BRM_00019','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00000','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00001','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00002','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00003','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00004','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00005','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00006','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00007','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00008','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00009','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00010','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00011','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00012','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00013','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00014','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00015','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00016','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00017','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00018','pc',1,NULL,1.0000000000,1.0000000000),('GRM_00019','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00000','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00001','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00002','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00003','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00004','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00005','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00006','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00007','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00008','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00009','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00010','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00011','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00012','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00013','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00014','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00015','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00016','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00017','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00018','pc',1,NULL,1.0000000000,1.0000000000),('MRM_00019','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00000','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00001','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00002','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00003','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00004','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00005','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00006','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00007','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00008','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00009','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00010','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00011','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00012','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00013','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00014','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00015','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00016','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00017','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00018','pc',1,NULL,1.0000000000,1.0000000000),('PRM_00019','pc',1,NULL,1.0000000000,1.0000000000),('PROD_ARMITELED','unit',1,NULL,1.0000000000,1.0000000000),('PROD_BLTSHLD','unit',1,NULL,1.0000000000,1.0000000000),('PROD_HYDRAPUMP','unit',1,NULL,1.0000000000,1.0000000000),('PROD_JGUND','unit',1,NULL,1.0000000000,1.0000000000),('PROD_JGUNS','unit',1,NULL,1.0000000000,1.0000000000),('PROD_PNEUMAPUMP','unit',1,NULL,1.0000000000,1.0000000000),('PROD_WSHR_2015','unit',1,NULL,1.0000000000,1.0000000000),('PROD_WSHR_2016','unit',1,NULL,1.0000000000,1.0000000000),('PROD_ZGUN','unit',1,NULL,1.0000000000,1.0000000000);
/*!40000 ALTER TABLE `item_uom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `company_code` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`company_code`,`code`),
  KEY `fk_location_company1_idx` (`company_code`),
  CONSTRAINT `fk_location_company1` FOREIGN KEY (`company_code`) REFERENCES `company` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES ('HYTORC','B_HSQC','Holy Spirit Quezon City Branch',NULL,NULL),('HYTORC','P_QC1','Quezon City Production Plant',NULL,NULL),('HYTORC','W_QC1','Quezon City Warehouse 1',NULL,NULL),('HYTORC','W_QC2','Quezon City Warehouse 2',NULL,NULL),('HYTORC','W_QC3','Quezon City Warehouse 3',NULL,NULL),('HYTORC','W_QC4','Quezon City Warehouse 4',NULL,NULL);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_item_stock_summary`
--

DROP TABLE IF EXISTS `location_item_stock_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_item_stock_summary` (
  `company_code` varchar(32) NOT NULL,
  `location_code` varchar(32) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_uom_code` varchar(32) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_code`,`location_code`,`item_code`,`item_uom_code`),
  KEY `fk_location_has_item_item1_idx` (`item_code`),
  KEY `fk_location_has_item_location1_idx` (`company_code`,`location_code`),
  CONSTRAINT `fk_location_has_item_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_has_item_location1` FOREIGN KEY (`company_code`, `location_code`) REFERENCES `location` (`company_code`, `code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_item_stock_summary`
--

LOCK TABLES `location_item_stock_summary` WRITE;
/*!40000 ALTER TABLE `location_item_stock_summary` DISABLE KEYS */;
INSERT INTO `location_item_stock_summary` VALUES ('HYTORC','B_HSQC','BRM_00001','pc',120),('HYTORC','B_HSQC','PROD_ARMITELED','unit',185),('HYTORC','B_HSQC','PROD_BLTSHLD','unit',480),('HYTORC','W_QC1','BRM_00000','pc',50);
/*!40000 ALTER TABLE `location_item_stock_summary` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (21,'2017_03_27_053038_add_source_supplier_column_in_item_movement',1),(22,'2017_08_25_010705_add_item_source_type_column',1),(23,'2017_08_25_064218_create_supplier_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES ('BOM','Bill of Materials'),('COM','Company'),('ER','Exchange Rate'),('I','Item'),('IM','Item Movement'),('IR','Item Reclass'),('LOC','Location'),('PRO','Production Order'),('S','Supplier'),('TO','Transfer Order'),('UOM','Unit of Measurement');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `number_series`
--

DROP TABLE IF EXISTS `number_series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `number_series` (
  `code` varchar(8) NOT NULL,
  `module_code` varchar(32) NOT NULL,
  `effective_date` date NOT NULL,
  `starting_number` int(11) NOT NULL,
  `ending_number` int(11) NOT NULL,
  `last_number_used` varchar(32) DEFAULT NULL,
  `last_date_used` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_number_series_module1` (`module_code`),
  CONSTRAINT `fk_number_series_module1` FOREIGN KEY (`module_code`) REFERENCES `module` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `number_series`
--

LOCK TABLES `number_series` WRITE;
/*!40000 ALTER TABLE `number_series` DISABLE KEYS */;
INSERT INTO `number_series` VALUES ('BOM-2017','BOM','2017-01-01',0,99999,'00001',NULL,NULL,'2017-09-01 02:18:14'),('IM-2017','IM','2017-01-01',0,99999,NULL,NULL,NULL,NULL),('IR-2017','IR','2017-01-01',0,99999,NULL,NULL,NULL,NULL),('PRO-2017','PRO','2017-01-01',0,99999,NULL,NULL,NULL,NULL),('S-2017','S','2017-01-01',0,99999,NULL,NULL,NULL,NULL),('TO-2017','TO','2017-01-01',0,99999,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `number_series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_order`
--

DROP TABLE IF EXISTS `production_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `production_order` (
  `doc_no` varchar(32) NOT NULL,
  `doc_date` date NOT NULL,
  `company_code` varchar(32) NOT NULL,
  `location_code` varchar(32) NOT NULL,
  `bom_code` varchar(32) NOT NULL,
  `qty_to_produce` int(11) NOT NULL DEFAULT '1',
  `status` varchar(32) NOT NULL DEFAULT 'Open',
  `remarks` text,
  `total_computed_cost` decimal(7,2) NOT NULL,
  `total_actual_cost` decimal(7,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `fk_manufacture_item_location1_idx` (`company_code`,`location_code`),
  KEY `fk_production_order_bill_of_materials1_idx` (`bom_code`),
  CONSTRAINT `fk_manufacture_item_location1` FOREIGN KEY (`company_code`, `location_code`) REFERENCES `location` (`company_code`, `code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_production_order_bill_of_materials1` FOREIGN KEY (`bom_code`) REFERENCES `bill_of_materials` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_order`
--

LOCK TABLES `production_order` WRITE;
/*!40000 ALTER TABLE `production_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `production_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_order_detail`
--

DROP TABLE IF EXISTS `production_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `production_order_detail` (
  `line_no` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(32) NOT NULL,
  `item_type_code` varchar(32) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_uom_code` varchar(32) NOT NULL,
  `item_unit_cost` decimal(7,2) NOT NULL,
  `qty_consumed` float NOT NULL DEFAULT '1',
  `computed_incurred_cost` decimal(7,2) NOT NULL,
  `actual_incurred_cost` decimal(7,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`line_no`),
  KEY `fk_manufacture_item_details_manufacture_item1_idx` (`doc_no`),
  KEY `fk_production_order_details_item1_idx` (`item_code`),
  CONSTRAINT `fk_manufacture_item_details_manufacture_item1` FOREIGN KEY (`doc_no`) REFERENCES `production_order` (`doc_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_production_order_details_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_order_detail`
--

LOCK TABLES `production_order_detail` WRITE;
/*!40000 ALTER TABLE `production_order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `production_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raw_material`
--

DROP TABLE IF EXISTS `raw_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `raw_material` (
  `bom_code` varchar(32) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_type_code` varchar(32) NOT NULL,
  `item_uom_code` varchar(32) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `qty` float NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bom_code`,`item_code`),
  KEY `fk_raw_material_item1_idx` (`item_code`),
  CONSTRAINT `fk_raw_material_bill_of_materials1` FOREIGN KEY (`bom_code`) REFERENCES `bill_of_materials` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_raw_material_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raw_material`
--

LOCK TABLES `raw_material` WRITE;
/*!40000 ALTER TABLE `raw_material` DISABLE KEYS */;
INSERT INTO `raw_material` VALUES ('BOM-2017-00001','MRM_00004','MRM','pc','Sample Raw Material - MRM-00004',1,NULL,NULL),('BOM-2017-00001','MRM_00005','MRM','pc','Sample Raw Material - MRM-00005',3,NULL,NULL),('BOM-2017-00001','PRM_00001','PRM','pc','Sample Raw Material - PRM-00001',2,NULL,NULL),('BOM-2017-00001','PRM_00002','PRM','pc','Sample Raw Material - PRM-00002',1,NULL,NULL);
/*!40000 ALTER TABLE `raw_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=cp850;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES ('ACCT','Accountant',NULL,NULL),('ADMIN','Administrator',NULL,NULL),('AUDIT','Auditor',NULL,NULL),('PLDMAN','PLD Manager',NULL,NULL),('PLDSTF','PLD Staff',NULL,NULL),('PRODMAN','Production Manager',NULL,NULL),('PRODSTF','Production Staff',NULL,NULL),('RCVNG','Receiving Staff',NULL,NULL);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `supplier_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_item_price`
--

DROP TABLE IF EXISTS `supplier_item_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_item_price` (
  `supplier_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_unit_cost` decimal(7,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_number`,`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_item_price`
--

LOCK TABLES `supplier_item_price` WRITE;
/*!40000 ALTER TABLE `supplier_item_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_item_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer_order`
--

DROP TABLE IF EXISTS `transfer_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfer_order` (
  `doc_no` varchar(32) NOT NULL,
  `doc_date` date NOT NULL,
  `origin_company_code` varchar(32) NOT NULL,
  `origin_location_code` varchar(32) NOT NULL,
  `destination_company_code` varchar(32) NOT NULL,
  `destination_location_code` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Open',
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `fk_transfer_order_location1_idx` (`origin_company_code`,`origin_location_code`),
  KEY `fk_transfer_order_location2_idx` (`destination_company_code`,`destination_location_code`),
  CONSTRAINT `fk_transfer_order_location1` FOREIGN KEY (`origin_company_code`, `origin_location_code`) REFERENCES `location` (`company_code`, `code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transfer_order_location2` FOREIGN KEY (`destination_company_code`, `destination_location_code`) REFERENCES `location` (`company_code`, `code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer_order`
--

LOCK TABLES `transfer_order` WRITE;
/*!40000 ALTER TABLE `transfer_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfer_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer_order_detail`
--

DROP TABLE IF EXISTS `transfer_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfer_order_detail` (
  `line_no` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(32) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_type_code` varchar(32) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_uom_code` varchar(32) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`line_no`),
  KEY `fk_transfer_order_detail_transfer_order1_idx` (`doc_no`),
  KEY `fk_transfer_order_detail_item1_idx` (`item_code`),
  CONSTRAINT `fk_transfer_order_detail_item1` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transfer_order_detail_transfer_order1` FOREIGN KEY (`doc_no`) REFERENCES `transfer_order` (`doc_no`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer_order_detail`
--

LOCK TABLES `transfer_order_detail` WRITE;
/*!40000 ALTER TABLE `transfer_order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfer_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_of_measurement`
--

DROP TABLE IF EXISTS `unit_of_measurement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_of_measurement` (
  `code` varchar(32) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_of_measurement`
--

LOCK TABLES `unit_of_measurement` WRITE;
/*!40000 ALTER TABLE `unit_of_measurement` DISABLE KEYS */;
INSERT INTO `unit_of_measurement` VALUES ('box12','Box of 12',NULL,NULL,NULL,NULL),('box5','Box of 5',NULL,NULL,NULL,NULL),('cm','Centimeter',NULL,NULL,NULL,NULL),('day','Day',NULL,NULL,NULL,NULL),('g','Gram',NULL,NULL,NULL,NULL),('hr','Hour',NULL,NULL,NULL,NULL),('kg','Kilogram',NULL,NULL,NULL,NULL),('m','Meter',NULL,NULL,NULL,NULL),('min','Minute',NULL,NULL,NULL,NULL),('pc','Piece',NULL,NULL,NULL,NULL),('unit','Unit',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `unit_of_measurement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `location_full_access` tinyint(1) NOT NULL DEFAULT '0',
  `display_name` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `remember_token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('admin',1,1,'Administrator','$2y$10$JQadh1ozyiall8t0FD/DEei2i7tGgD55gtcMx5p5Nudli32VL6fza','gf2G6PIfoeRU6tT39gvTRoOhTnOhzFxmtCeDSGCkpxHlhMImk4ZGRk4R9oZf'),('atampus',1,0,'April Tampus','$2y$10$fgfdaxNlbA6YmhoUTIwjv.tSdNnAheQT5Wp3hvUkj7MWanh5TmO3C',NULL),('dtumulak',1,0,'Doris Tumulak','$2y$10$/fqfbP/wkdzopmR4Kb6AT.QVuaY47jNIOkm8e0QpsWzxQv3XPriT.',NULL),('evillalon',1,0,'Ehmar Villalon','$2y$10$iA.lfBJbGxxtufpMQnrbo.hMQ4uK0lIAEPfJbU0CpPf3SOW2H99di',NULL),('gflores',1,1,'Gabrielle Flores','$2y$10$UFMIcdab6wLS4E8FgJ867ulBQCkrm7iIS3GbU3nukCDHcCDVfhq8O',NULL),('ggarcia',1,0,'Gretchen Garcia','$2y$10$v8os21S8t20cQiUelCLwQOXOAdKtyU.fmhqPh/qoTkNr1vZb8AEmC',NULL),('lbatarao',1,0,'Lizeth Batarao','$2y$10$nTSArWhEJvBSFADerdXhQun66TK4J/o.cdmIBCjFrAB0aTHmCrp6y',NULL),('psampani',1,1,'Prosa Mae Sampani','$2y$10$nNpM3PpIPW0tf.1pJf9Y1.Eq23EoOiUEpAro/su7.jDj1lXsDsYLK',NULL),('yyao',1,0,'Yvonne Yao','$2y$10$qz9hQjvr6eTTUvI3KyDfRO2TqjDdeFP4rjZleUf5Q13eTmuVn3imm',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_location`
--

DROP TABLE IF EXISTS `user_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_location` (
  `user_username` varchar(32) NOT NULL,
  `company_code` varchar(32) NOT NULL,
  `location_code` varchar(32) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_username`,`company_code`,`location_code`),
  KEY `fk_user_has_location_location1_idx` (`company_code`,`location_code`),
  KEY `fk_user_has_location_user1_idx` (`user_username`),
  CONSTRAINT `fk_user_has_location_location1` FOREIGN KEY (`company_code`, `location_code`) REFERENCES `location` (`company_code`, `code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_location_user1` FOREIGN KEY (`user_username`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_location`
--

LOCK TABLES `user_location` WRITE;
/*!40000 ALTER TABLE `user_location` DISABLE KEYS */;
INSERT INTO `user_location` VALUES ('atampus','HYTORC','W_QC3',1),('dtumulak','HYTORC','W_QC1',1),('evillalon','HYTORC','P_QC1',1),('ggarcia','HYTORC','P_QC1',1),('ggarcia','HYTORC','W_QC1',1),('ggarcia','HYTORC','W_QC2',1),('ggarcia','HYTORC','W_QC3',1),('ggarcia','HYTORC','W_QC4',1),('lbatarao','HYTORC','W_QC1',1),('lbatarao','HYTORC','W_QC2',1),('lbatarao','HYTORC','W_QC3',1),('lbatarao','HYTORC','W_QC4',1),('yyao','HYTORC','W_QC2',1);
/*!40000 ALTER TABLE `user_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_username` varchar(32) NOT NULL,
  `role_code` varchar(32) NOT NULL,
  PRIMARY KEY (`user_username`,`role_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES ('admin','ADMIN'),('atampus','RCVNG'),('dtumulak','RCVNG'),('evillalon','PRODMAN'),('gflores','AUDIT'),('ggarcia','PLDSTF'),('ggarcia','PRODSTF'),('lbatarao','PLDMAN'),('psampani','ACCT'),('yyao','RCVNG');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-19 12:38:19
