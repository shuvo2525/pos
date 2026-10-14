-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pos_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ac_accounts`
--

DROP TABLE IF EXISTS `ac_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ac_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `account_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `account_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `balance` double(20,4) DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `delete_bit` int(11) DEFAULT 0,
  `account_selection_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `paymenttypes_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `expense_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `paymenttypes_id` (`paymenttypes_id`),
  KEY `customer_id` (`customer_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `expense_id` (`expense_id`),
  CONSTRAINT `ac_accounts_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_accounts_ibfk_2` FOREIGN KEY (`paymenttypes_id`) REFERENCES `db_paymenttypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_accounts_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_accounts_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_accounts_ibfk_5` FOREIGN KEY (`expense_id`) REFERENCES `db_expense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ac_accounts`
--

LOCK TABLES `ac_accounts` WRITE;
/*!40000 ALTER TABLE `ac_accounts` DISABLE KEYS */;
INSERT INTO `ac_accounts` VALUES (1,1,2,0,'1','Cash Box','Cash',26168685.0000,'','user_67930','2024-07-09','12:53:17 am','::1','DESKTOP-GMFRN98',1,0,NULL,NULL,NULL,NULL,NULL),(2,2,2,0,'2','EBL Bank','108059345444',-15100.0000,'','user_67930','2024-07-09','12:53:36 am','::1','DESKTOP-GMFRN98',1,0,NULL,NULL,NULL,NULL,NULL),(3,3,2,0,'3','DBL Bank','45887111555',108.0000,'','user_67930','2024-07-09','12:53:57 am','::1','DESKTOP-GMFRN98',1,0,NULL,NULL,NULL,NULL,NULL),(4,4,2,0,'4','Baksh Merchant','01775457008',22200.0000,'','user_67930','2024-07-09','12:54:12 am','::1','DESKTOP-GMFRN98',1,0,NULL,NULL,NULL,NULL,NULL),(5,5,2,0,'5','Nagod Personal','01954578089',0.0000,'','user_67930','2024-07-09','12:54:30 am','::1','DESKTOP-GMFRN98',1,0,NULL,NULL,NULL,NULL,NULL),(6,6,2,0,'6','Rocket Personal','019545780891',500.0000,'','user_67930','2024-07-09','12:54:49 am','::1','DESKTOP-GMFRN98',1,0,NULL,NULL,NULL,NULL,NULL),(7,7,2,0,'7','Islami Bank','852112254',51000.0000,'','admin','2024-07-10','12:37:29 pm','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',1,0,NULL,NULL,NULL,NULL,NULL),(8,1,1,0,'1','Cash in Hand','CASH-1',0.0000,'Default Cash Account Head','system','2026-09-30','10:30:57 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(9,2,1,0,'2','Bank Accounts','BANK-1',0.0000,'Default Bank Accounts Head','system','2026-09-30','10:30:57 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(10,3,1,0,'3','Mobile Banking','MBANK-1',0.0000,'Default Mobile Banking Head (bKash/Nagad/Rocket)','system','2026-09-30','10:30:57 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(11,4,1,0,'4','Card / POS Terminal','CARD-1',0.0000,'Default Card / POS Terminal Head','system','2026-09-30','10:30:57 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(12,1,3,0,'1','Cash in Hand','CASH-3',0.0000,'Default Cash Account Head','system','2026-09-30','10:31:26 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(13,2,3,0,'2','Bank Accounts','BANK-3',0.0000,'Default Bank Accounts Head','system','2026-09-30','10:31:26 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(14,3,3,0,'3','Mobile Banking','MBANK-3',0.0000,'Default Mobile Banking Head (bKash/Nagad/Rocket)','system','2026-09-30','10:31:26 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL),(15,4,3,0,'4','Card / POS Terminal','CARD-3',0.0000,'Default Card / POS Terminal Head','system','2026-09-30','10:31:26 pm','::1','system',1,0,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ac_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ac_moneydeposits`
--

DROP TABLE IF EXISTS `ac_moneydeposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ac_moneydeposits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `deposit_date` date DEFAULT NULL,
  `reference_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_account_id` (`debit_account_id`),
  KEY `to_account_id` (`credit_account_id`),
  KEY `db_moneydeposits_ibfk_3` (`store_id`),
  CONSTRAINT `ac_moneydeposits_ibfk_1` FOREIGN KEY (`debit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_moneydeposits_ibfk_2` FOREIGN KEY (`credit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_moneydeposits_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ac_moneydeposits`
--

LOCK TABLES `ac_moneydeposits` WRITE;
/*!40000 ALTER TABLE `ac_moneydeposits` DISABLE KEYS */;
INSERT INTO `ac_moneydeposits` VALUES (1,2,'2024-07-10','1545422',7,1,20000.0000,'','admin','2024-07-10','12:38:36 pm','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',1),(2,2,'2024-08-19','',NULL,1,50000.0000,'','admin','2024-08-19','01:25:34 am','103.59.179.21','103.59.179.21',1);
/*!40000 ALTER TABLE `ac_moneydeposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ac_moneytransfer`
--

DROP TABLE IF EXISTS `ac_moneytransfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ac_moneytransfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `transfer_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `reference_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_account_id` (`debit_account_id`),
  KEY `to_account_id` (`credit_account_id`),
  KEY `db_moneytransfer_ibfk_3` (`store_id`),
  CONSTRAINT `ac_moneytransfer_ibfk_1` FOREIGN KEY (`debit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_moneytransfer_ibfk_2` FOREIGN KEY (`credit_account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_moneytransfer_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ac_moneytransfer`
--

LOCK TABLES `ac_moneytransfer` WRITE;
/*!40000 ALTER TABLE `ac_moneytransfer` DISABLE KEYS */;
INSERT INTO `ac_moneytransfer` VALUES (1,2,1,'MT0001','2024-08-19','',1,7,20000.0000,'','admin','2024-08-19','01:25:01 am','103.59.179.21','103.59.179.21',1);
/*!40000 ALTER TABLE `ac_moneytransfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ac_transactions`
--

DROP TABLE IF EXISTS `ac_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ac_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `debit_amt` double(20,4) DEFAULT NULL,
  `credit_amt` double(20,4) DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `ref_accounts_id` int(11) DEFAULT NULL COMMENT 'reference table',
  `ref_moneytransfer_id` int(11) DEFAULT NULL COMMENT 'reference table',
  `ref_moneydeposits_id` int(11) DEFAULT NULL COMMENT 'reference table',
  `ref_salespayments_id` int(11) DEFAULT NULL,
  `ref_salespaymentsreturn_id` int(11) DEFAULT NULL,
  `ref_purchasepayments_id` int(11) DEFAULT NULL,
  `ref_purchasepaymentsreturn_id` int(11) DEFAULT NULL,
  `ref_expense_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_id` (`transaction_type`),
  KEY `account_id` (`debit_account_id`),
  KEY `store_id` (`store_id`),
  KEY `ac_accounts_id` (`ref_accounts_id`),
  KEY `ac_moneytransfer_id` (`ref_moneytransfer_id`),
  KEY `ac_moneydeposits_id` (`ref_moneydeposits_id`),
  KEY `customer_id` (`customer_id`),
  KEY `ref_salespayments_id` (`ref_salespayments_id`),
  KEY `ref_purchasepayments_id` (`ref_purchasepayments_id`),
  KEY `ref_purchasepaymentsreturn_id` (`ref_purchasepaymentsreturn_id`),
  KEY `ac_transactions_ibfk_9` (`ref_salespaymentsreturn_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `ref_expense_id` (`ref_expense_id`),
  CONSTRAINT `ac_transactions_ibfk_10` FOREIGN KEY (`ref_purchasepayments_id`) REFERENCES `db_purchasepayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_11` FOREIGN KEY (`ref_purchasepaymentsreturn_id`) REFERENCES `db_purchasepaymentsreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_12` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_13` FOREIGN KEY (`ref_expense_id`) REFERENCES `db_expense` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_4` FOREIGN KEY (`ref_accounts_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_5` FOREIGN KEY (`ref_moneytransfer_id`) REFERENCES `ac_moneytransfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_6` FOREIGN KEY (`ref_moneydeposits_id`) REFERENCES `ac_moneydeposits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_7` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_8` FOREIGN KEY (`ref_salespayments_id`) REFERENCES `db_salespayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ac_transactions_ibfk_9` FOREIGN KEY (`ref_salespaymentsreturn_id`) REFERENCES `db_salespaymentsreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=914 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ac_transactions`
--

LOCK TABLES `ac_transactions` WRITE;
/*!40000 ALTER TABLE `ac_transactions` DISABLE KEYS */;
INSERT INTO `ac_transactions` VALUES (830,2,'','2024-07-09','OPENING BALANCE',NULL,1,NULL,5000.0000,'','user_67930','2024-07-09',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(831,2,'','2024-07-09','OPENING BALANCE',NULL,2,NULL,500.0000,'','user_67930','2024-07-09',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(832,2,'','2024-07-09','OPENING BALANCE',NULL,3,NULL,108.0000,'','user_67930','2024-07-09',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(833,2,'','2024-07-09','OPENING BALANCE',NULL,4,NULL,0.0000,'','user_67930','2024-07-09',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(834,2,'','2024-07-09','OPENING BALANCE',NULL,5,NULL,0.0000,'','user_67930','2024-07-09',5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(835,2,'','2024-07-09','OPENING BALANCE',NULL,6,NULL,0.0000,'','user_67930','2024-07-09',6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(837,2,'SP0001','2024-07-09','SALES PAYMENT',NULL,1,NULL,500.0000,'','admin','2024-07-09',NULL,NULL,NULL,351,NULL,NULL,NULL,NULL,7,NULL,NULL),(838,2,'SP0002','2024-07-09','SALES PAYMENT',NULL,1,NULL,800.0000,'','admin','2024-07-09',NULL,NULL,NULL,352,NULL,NULL,NULL,NULL,8,NULL,NULL),(839,2,'SP0003','2024-07-09','SALES PAYMENT',NULL,1,NULL,300.0000,'','admin','2024-07-09',NULL,NULL,NULL,353,NULL,NULL,NULL,NULL,9,NULL,NULL),(840,2,'XP0002','2024-07-09','EXPENSE PAYMENT',1,NULL,100.0000,NULL,'???????? ???? ?? ??? ???????','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,34,NULL,NULL,NULL),(841,2,'XP0003','2024-07-09','EXPENSE PAYMENT',1,NULL,500.0000,NULL,'????? ??? ??????','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,35,NULL,NULL,NULL),(842,2,'XP0004','2024-07-09','EXPENSE PAYMENT',1,NULL,200.0000,NULL,'???? ???? ??????','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,36,NULL,NULL,NULL),(843,2,'XP0005','2024-07-09','EXPENSE PAYMENT',1,NULL,1200.0000,NULL,'???????? ??????? ????','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,37,NULL,NULL,NULL),(844,2,'PP0001','2024-07-09','PURCHASE PAYMENT',2,NULL,10000.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,110,NULL,NULL,NULL,2,NULL),(845,2,'PP0002','2024-07-09','PURCHASE PAYMENT',1,NULL,200.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,111,NULL,NULL,NULL,3,NULL),(846,2,'PP0003','2024-07-09','PURCHASE PAYMENT',1,NULL,100.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,112,NULL,NULL,NULL,6,NULL),(847,2,'PP0004','2024-07-09','PURCHASE PAYMENT',2,NULL,100.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,113,NULL,NULL,NULL,4,NULL),(848,2,'PP0005','2024-07-09','PURCHASE PAYMENT',2,NULL,1000.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,114,NULL,NULL,NULL,5,NULL),(849,2,'PP0006','2024-07-09','PURCHASE PAYMENT',1,NULL,500.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,115,NULL,NULL,NULL,1,NULL),(850,2,'PP0007','2024-07-09','PURCHASE PAYMENT',1,NULL,500.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,116,NULL,NULL,NULL,2,NULL),(851,2,'PP0008','2024-07-09','PURCHASE PAYMENT',2,NULL,100.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,117,NULL,NULL,NULL,2,NULL),(852,2,'SP0004','2024-07-09','SALES PAYMENT',NULL,1,NULL,2265250.0000,'','admin','2024-07-09',NULL,NULL,NULL,354,NULL,NULL,NULL,NULL,3,NULL,NULL),(855,2,'SP0005','2024-07-09','SALES PAYMENT',NULL,1,NULL,23997000.0000,'','admin','2024-07-09',NULL,NULL,NULL,357,NULL,NULL,NULL,NULL,3,NULL,NULL),(856,2,'SP0006','2024-07-09','SALES PAYMENT',NULL,1,NULL,200.0000,'','admin','2024-07-09',NULL,NULL,NULL,358,NULL,NULL,NULL,NULL,7,NULL,NULL),(857,2,'SP0007','2024-07-09','SALES PAYMENT',NULL,1,NULL,300.0000,'','admin','2024-07-09',NULL,NULL,NULL,359,NULL,NULL,NULL,NULL,8,NULL,NULL),(858,2,'SP0008','2024-07-09','SALES PAYMENT',NULL,1,NULL,75.0000,'','admin','2024-07-09',NULL,NULL,NULL,360,NULL,NULL,NULL,NULL,9,NULL,NULL),(859,2,'SP0009','2024-07-09','SALES PAYMENT',NULL,1,NULL,215.0000,'','admin','2024-07-09',NULL,NULL,NULL,361,NULL,NULL,NULL,NULL,8,NULL,NULL),(860,2,'SP0010','2024-07-09','SALES PAYMENT',NULL,1,NULL,500.0000,'','admin','2024-07-09',NULL,NULL,NULL,362,NULL,NULL,NULL,NULL,7,NULL,NULL),(861,2,'SP0011','2024-07-09','SALES PAYMENT',NULL,1,NULL,21700.0000,'','admin','2024-07-09',NULL,NULL,NULL,363,NULL,NULL,NULL,NULL,9,NULL,NULL),(862,2,'SP0012','2024-07-09','SALES PAYMENT',NULL,1,NULL,999.0000,'','admin','2024-07-09',NULL,NULL,NULL,364,NULL,NULL,NULL,NULL,7,NULL,NULL),(863,2,'SP0013','2024-07-09','SALES PAYMENT',NULL,1,NULL,100.0000,'','admin','2024-07-09',NULL,NULL,NULL,365,NULL,NULL,NULL,NULL,7,NULL,NULL),(864,2,'SP0014','2024-07-09','SALES PAYMENT',NULL,1,NULL,3000.0000,'','admin','2024-07-09',NULL,NULL,NULL,366,NULL,NULL,NULL,NULL,7,NULL,NULL),(865,2,'SRP0001','2024-07-09','SALES PAYMENT RETURN',1,NULL,22000.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,46,NULL,NULL,NULL,3,NULL,NULL),(866,2,'PP0011','2024-07-09','PURCHASE PAYMENT',1,NULL,90000.0000,NULL,'','admin','2024-07-09',NULL,NULL,NULL,NULL,NULL,120,NULL,NULL,NULL,5,NULL),(867,2,'SP0015','2024-07-09','SALES PAYMENT',NULL,1,NULL,100.0000,'','admin','2024-07-09',NULL,NULL,NULL,367,NULL,NULL,NULL,NULL,10,NULL,NULL),(868,2,'SP0016','2024-07-09','SALES PAYMENT',NULL,1,NULL,22000.0000,'','admin','2024-07-09',NULL,NULL,NULL,368,NULL,NULL,NULL,NULL,2,NULL,NULL),(869,2,'SP0017','2024-07-10','SALES PAYMENT',NULL,4,NULL,22000.0000,'018708293434','admin','2024-07-10',NULL,NULL,NULL,369,NULL,NULL,NULL,NULL,2,NULL,NULL),(870,2,'SP0018','2024-07-10','SALES PAYMENT',NULL,1,NULL,22970.0000,'','admin','2024-07-10',NULL,NULL,NULL,370,NULL,NULL,NULL,NULL,2,NULL,NULL),(871,2,'SP0019','2024-07-10','SALES PAYMENT',NULL,4,NULL,200.0000,'01870829343 ei number theke se pay koreche','admin','2024-07-10',NULL,NULL,NULL,371,NULL,NULL,NULL,NULL,12,NULL,NULL),(872,2,'SP0020','2024-07-10','SALES PAYMENT',NULL,1,NULL,800.0000,'','admin','2024-07-10',NULL,NULL,NULL,372,NULL,NULL,NULL,NULL,12,NULL,NULL),(873,2,'SP0021','2024-07-10','SALES PAYMENT',NULL,1,NULL,260.0000,'','admin','2024-07-10',NULL,NULL,NULL,373,NULL,NULL,NULL,NULL,12,NULL,NULL),(874,2,'PP0014','2024-07-10','PURCHASE PAYMENT',2,NULL,10000.0000,NULL,'','admin','2024-07-10',NULL,NULL,NULL,NULL,NULL,123,NULL,NULL,NULL,2,NULL),(875,2,'PP0015','2024-07-10','PURCHASE PAYMENT',1,NULL,20000.0000,NULL,'','admin','2024-07-10',NULL,NULL,NULL,NULL,NULL,124,NULL,NULL,NULL,2,NULL),(876,2,'PP0016','2024-07-10','PURCHASE PAYMENT',1,NULL,290000.0000,NULL,'','admin','2024-07-10',NULL,NULL,NULL,NULL,NULL,125,NULL,NULL,NULL,2,NULL),(877,2,'','2024-07-10','OPENING BALANCE',NULL,7,NULL,50000.0000,'','admin','2024-07-10',7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(878,2,'','2024-07-10','DEPOSIT',7,1,20000.0000,20000.0000,'','admin','2024-07-10',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(879,2,'XP0006','2024-07-10','EXPENSE PAYMENT',1,NULL,200.0000,NULL,'','admin','2024-07-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,38,NULL,NULL,NULL),(880,2,'SP0022','2024-07-11','SALES PAYMENT',NULL,1,NULL,20000.0000,'','admin','2024-07-11',NULL,NULL,NULL,374,NULL,NULL,NULL,NULL,13,NULL,NULL),(881,2,'SP0024','2024-07-13','SALES PAYMENT',NULL,1,NULL,200.0000,'','admin','2024-07-13',NULL,NULL,NULL,376,NULL,NULL,NULL,NULL,2,NULL,NULL),(882,2,'SP0025','2024-07-14','SALES PAYMENT',NULL,1,NULL,22400.0000,'','admin','2024-07-14',NULL,NULL,NULL,377,NULL,NULL,NULL,NULL,14,NULL,NULL),(883,2,'SP0026','2024-07-14','OPENING BALANCE PAID',NULL,1,NULL,5.0000,'','admin','2024-07-14',NULL,NULL,NULL,378,NULL,NULL,NULL,NULL,14,NULL,NULL),(886,2,'SP0029','2024-08-02','SALES PAYMENT',NULL,1,NULL,22000.0000,'','admin','2024-08-02',NULL,NULL,NULL,383,NULL,NULL,NULL,NULL,2,NULL,NULL),(887,2,'SP0031','2024-08-18','SALES PAYMENT',NULL,1,NULL,8800.0000,'','admin','2024-08-18',NULL,NULL,NULL,385,NULL,NULL,NULL,NULL,3,NULL,NULL),(888,2,'SP0032','2024-08-19','SALES PAYMENT',NULL,7,NULL,1000.0000,'','admin','2024-08-19',NULL,NULL,NULL,386,NULL,NULL,NULL,NULL,2,NULL,NULL),(889,2,'SP0033','2024-08-19','SALES PAYMENT',NULL,1,NULL,200.0000,'','admin','2024-08-19',NULL,NULL,NULL,387,NULL,NULL,NULL,NULL,2,NULL,NULL),(890,2,'SP0034','2024-08-19','SALES PAYMENT',NULL,2,NULL,300.0000,'','admin','2024-08-19',NULL,NULL,NULL,388,NULL,NULL,NULL,NULL,2,NULL,NULL),(891,2,'SP0035','2024-08-19','SALES PAYMENT',NULL,1,NULL,21200.0000,'','admin','2024-08-19',NULL,NULL,NULL,389,NULL,NULL,NULL,NULL,8,NULL,NULL),(892,2,'SP0036','2024-08-19','SALES PAYMENT',NULL,1,NULL,20401.0000,'','admin','2024-08-19',NULL,NULL,NULL,390,NULL,NULL,NULL,NULL,7,NULL,NULL),(893,2,'SP0036','2024-08-19','SALES PAYMENT',NULL,1,NULL,18300.0000,'','admin','2024-08-19',NULL,NULL,NULL,391,NULL,NULL,NULL,NULL,7,NULL,NULL),(894,2,'SP0037','2024-08-19','SALES PAYMENT',NULL,1,NULL,2000.0000,'','admin','2024-08-19',NULL,NULL,NULL,392,NULL,NULL,NULL,NULL,13,NULL,NULL),(895,2,'PP0017','2024-08-19','PURCHASE PAYMENT',1,NULL,2000.0000,NULL,'','admin','2024-08-19',NULL,NULL,NULL,NULL,NULL,126,NULL,NULL,NULL,2,NULL),(896,2,'','2024-08-19','TRANSFER',1,7,20000.0000,20000.0000,'','admin','2024-08-19',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(897,2,'','2024-08-19','DEPOSIT',NULL,1,50000.0000,50000.0000,'','admin','2024-08-19',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(898,2,'SP0038','2024-08-01','SALES PAYMENT',NULL,2,NULL,100.0000,'','admin','2024-08-19',NULL,NULL,NULL,382,NULL,NULL,NULL,NULL,2,NULL,NULL),(899,2,'SP0038','2024-07-16','SALES PAYMENT',NULL,2,NULL,5200.0000,'','admin','2024-08-19',NULL,NULL,NULL,381,NULL,NULL,NULL,NULL,2,NULL,NULL),(900,2,'XP0007','2024-08-19','EXPENSE PAYMENT',1,NULL,20000.0000,NULL,'Salary of August 24','admin','2024-08-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,39,NULL,NULL,NULL),(901,2,'SP0038','2024-08-19','SALES PAYMENT',NULL,1,NULL,500.0000,'','admin','2024-08-19',NULL,NULL,NULL,394,NULL,NULL,NULL,NULL,13,NULL,NULL),(902,2,'SP0039','2024-08-19','SALES PAYMENT',NULL,6,NULL,500.0000,'','admin','2024-08-19',NULL,NULL,NULL,395,NULL,NULL,NULL,NULL,13,NULL,NULL),(903,2,'SP0043','2024-08-31','SALES PAYMENT',NULL,1,NULL,22000.0000,'Ss','admin','2024-08-31',NULL,NULL,NULL,399,NULL,NULL,NULL,NULL,2,NULL,NULL),(904,2,'SP0049','2024-09-19','SALES PAYMENT',NULL,1,NULL,22520.0000,'','admin','2024-09-19',NULL,NULL,NULL,405,NULL,NULL,NULL,NULL,2,NULL,NULL),(905,2,'SP0050','2024-09-22','SALES PAYMENT',NULL,1,NULL,43590.0000,'','admin','2024-09-22',NULL,NULL,NULL,406,NULL,NULL,NULL,NULL,2,NULL,NULL),(906,1,NULL,'2026-09-30','OPENING BALANCE',NULL,8,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(907,1,NULL,'2026-09-30','OPENING BALANCE',NULL,9,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(908,1,NULL,'2026-09-30','OPENING BALANCE',NULL,10,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(909,1,NULL,'2026-09-30','OPENING BALANCE',NULL,11,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(910,3,NULL,'2026-09-30','OPENING BALANCE',NULL,12,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(911,3,NULL,'2026-09-30','OPENING BALANCE',NULL,13,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(912,3,NULL,'2026-09-30','OPENING BALANCE',NULL,14,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(913,3,NULL,'2026-09-30','OPENING BALANCE',NULL,15,0.0000,0.0000,'Initial Zero Opening Balance','system','2026-09-30',15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ac_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('thb3s4gj22olncqbklp7icba8c5gi6as','::1',1790852998,'__ci_last_regenerate|i:1790852998;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:37:\"Success!! Sales Created Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('q99dfkl6dmlmh75ht3310ll93u6kiv3t','::1',1790854081,'__ci_last_regenerate|i:1790854081;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:38:\"Success!! New Item Added Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('s886mo37koae47nrh8ren8ov2bqc77rq','::1',1790854529,'__ci_last_regenerate|i:1790854529;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:38:\"Success!! New Item Added Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('574esf3okusv81mtoei9uhjbp55o5825','::1',1790855420,'__ci_last_regenerate|i:1790855420;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:38:\"Success!! New Item Added Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('d90j7ba5e9lajan449tis8cchleov7ri','::1',1790857209,'__ci_last_regenerate|i:1790857209;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:38:\"Success!! New Item Added Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('e5pktrdo2082vgdncmlkl2ab614keccn','::1',1790857563,'__ci_last_regenerate|i:1790857563;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:38:\"Success!! New Item Added Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('us60nde0qlk45rd86h5it32uutp2obrd','::1',1790858794,'__ci_last_regenerate|i:1790858794;currency|s:2:\"TK\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:16:\"Nahid Super Shop\";inv_username|s:9:\"shuvo2525\";full_name|s:12:\"Jubayer khan\";first_name|s:7:\"Jubayer\";user_lname|s:4:\"khan\";inv_userid|s:3:\"105\";logged_in|b:1;role_id|s:1:\"2\";role_name|s:11:\"Store Admin\";store_id|s:1:\"3\";email|s:14:\"skjd@gmail.com\";success|s:38:\"Success!! New Item Added Successfully!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}language|s:7:\"English\";language_id|s:1:\"1\";'),('0vf7epu02mpg2i848al540h1a0ms6ls0','::1',1790858794,'__ci_last_regenerate|i:1790858794;language|s:7:\"English\";currency|s:2:\"Tk\";currency_placement|s:5:\"Right\";currency_code|s:3:\"BDT\";view_date|s:10:\"dd-mm-yyyy\";view_time|s:2:\"12\";decimals|s:1:\"2\";qty_decimals|s:1:\"2\";store_name|s:10:\"SAAS ADMIN\";');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_bankdetails`
--

DROP TABLE IF EXISTS `db_bankdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_bankdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `holder_name` varchar(250) DEFAULT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `code` varchar(250) DEFAULT NULL COMMENT 'IFSC or Bank Code',
  `account_type` varchar(250) DEFAULT NULL,
  `account_number` varchar(250) DEFAULT NULL,
  `other_details` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_bankdetails_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_bankdetails`
--

LOCK TABLES `db_bankdetails` WRITE;
/*!40000 ALTER TABLE `db_bankdetails` DISABLE KEYS */;
INSERT INTO `db_bankdetails` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `db_bankdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_brands`
--

DROP TABLE IF EXISTS `db_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `brand_code` varchar(50) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_brands_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_brands_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_brands`
--

LOCK TABLES `db_brands` WRITE;
/*!40000 ALTER TABLE `db_brands` DISABLE KEYS */;
INSERT INTO `db_brands` VALUES (327,2,NULL,'Adidas','',1),(328,2,NULL,'Vivo','',1),(329,2,NULL,'Zara','',1),(330,2,NULL,'Tomy Hilfigure','',1),(331,2,NULL,'Old Neavy','',1),(332,2,NULL,'Denimco','',1),(333,2,NULL,'Pran','',1),(334,3,NULL,'hghg','',1);
/*!40000 ALTER TABLE `db_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_category`
--

DROP TABLE IF EXISTS `db_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create category Code',
  `category_code` varchar(50) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_category_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_category`
--

LOCK TABLES `db_category` WRITE;
/*!40000 ALTER TABLE `db_category` DISABLE KEYS */;
INSERT INTO `db_category` VALUES (82,2,1,'CT/02/0001','Electronics','',NULL,1),(83,2,2,'CT0002','Grocery','',NULL,1),(84,2,3,'CT0003','Cloth','',NULL,1),(85,2,4,'CT0004','Pharma','',NULL,1),(86,3,1,'CT/03/0001','Baverage','',NULL,1);
/*!40000 ALTER TABLE `db_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_cobpayments`
--

DROP TABLE IF EXISTS `db_cobpayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_cobpayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` mediumtext DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_cobpayments`
--

LOCK TABLES `db_cobpayments` WRITE;
/*!40000 ALTER TABLE `db_cobpayments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_cobpayments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_company`
--

DROP TABLE IF EXISTS `db_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_company` (
  `id` double DEFAULT NULL,
  `company_code` varchar(150) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `company_website` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `company_logo` text DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL,
  `upi_id` varchar(50) DEFAULT NULL,
  `upi_code` text DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `vat_no` varchar(50) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `bank_details` mediumtext DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `category_init` varchar(5) DEFAULT NULL,
  `item_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `supplier_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_return_init` varchar(5) DEFAULT NULL,
  `customer_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_init` varchar(5) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_return_init` varchar(5) DEFAULT NULL,
  `expense_init` varchar(5) DEFAULT NULL,
  `invoice_view` int(11) DEFAULT NULL COMMENT '1=Standard,2=Indian GST',
  `status` int(11) DEFAULT NULL,
  `sms_status` int(11) DEFAULT NULL COMMENT '1=Enable 0=Disable',
  `sales_terms_and_conditions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_company`
--

LOCK TABLES `db_company` WRITE;
/*!40000 ALTER TABLE `db_company` DISABLE KEYS */;
INSERT INTO `db_company` VALUES (1,'','Company Name',NULL,'9999999999','','admin@example.com','','company_logo.png','logo-0.png',NULL,NULL,'India','Karnataka','Belgaum','Address Details','','','','','',1,'CT','IT','SP','PU','PR','CU','SL','PR','EX',1,1,0,NULL);
/*!40000 ALTER TABLE `db_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_country`
--

DROP TABLE IF EXISTS `db_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(4050) DEFAULT NULL,
  `added_on` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_country`
--

LOCK TABLES `db_country` WRITE;
/*!40000 ALTER TABLE `db_country` DISABLE KEYS */;
INSERT INTO `db_country` VALUES (210,'Bangladesh',NULL,1);
/*!40000 ALTER TABLE `db_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_coupons`
--

DROP TABLE IF EXISTS `db_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(100) DEFAULT NULL,
  `system_name` varchar(250) DEFAULT NULL,
  `system_ip` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_coupons_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_coupons_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_coupons`
--

LOCK TABLES `db_coupons` WRITE;
/*!40000 ALTER TABLE `db_coupons` DISABLE KEYS */;
INSERT INTO `db_coupons` VALUES (343,2,NULL,'পহেলা বৈশাখ','পহেলা বৈশাখ কুপন কোড',120.00,'Fixed','2026-07-09',1,'admin','2024-07-09','11:26:25 am','DESKTOP-GMFRN98','::1'),(344,2,NULL,'ঈদ অফার','',200.00,'Fixed','2026-07-09',1,'admin','2024-07-09','11:26:58 am','DESKTOP-GMFRN98','::1'),(345,2,NULL,'পুজা অফার','',500.00,'Fixed','2026-07-09',1,'admin','2024-07-09','11:27:47 am','DESKTOP-GMFRN98','::1'),(346,2,NULL,'ধামাকা অফার','ধামাকা অফার',10.00,'Percentage','2026-07-09',1,'admin','2024-07-09','11:31:48 am','DESKTOP-GMFRN98','::1'),(347,2,NULL,'eid','',100.00,'Fixed','2024-07-31',1,'admin','2024-07-14','12:04:20 pm','103.161.66.23','103.161.66.23'),(348,2,NULL,'শীতের অফার','',200.00,'Fixed','2024-09-20',1,'admin','2024-08-19','01:12:16 am','103.59.179.21','103.59.179.21'),(349,2,NULL,'লাকী কুপন','',2.00,'Percentage','2024-08-20',1,'admin','2024-08-19','01:13:13 am','103.59.179.21','103.59.179.21');
/*!40000 ALTER TABLE `db_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_currency`
--

DROP TABLE IF EXISTS `db_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(50) DEFAULT NULL,
  `currency_code` varchar(20) DEFAULT NULL,
  `currency` blob DEFAULT NULL,
  `symbol` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_currency`
--

LOCK TABLES `db_currency` WRITE;
/*!40000 ALTER TABLE `db_currency` DISABLE KEYS */;
INSERT INTO `db_currency` VALUES (60,'TAKA','BDT','TK',NULL,1);
/*!40000 ALTER TABLE `db_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_custadvance`
--

DROP TABLE IF EXISTS `db_custadvance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_custadvance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `payment_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_ip` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_custadvance_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_custadvance_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_custadvance`
--

LOCK TABLES `db_custadvance` WRITE;
/*!40000 ALTER TABLE `db_custadvance` DISABLE KEYS */;
INSERT INTO `db_custadvance` VALUES (1,2,1,'ADV0001','2024-07-09',3,3000.0000,'CASH','Iphone 15 pro max kenar jonno advanch (31/03/2027) e delivery deowa hobe','admin','2024-07-09','11:33:39 am','::1','DESKTOP-GMFRN98',1),(2,2,2,'ADV0002','2024-07-09',6,1200.0000,'CASH','সেলাই মেশিন কেনার জন্য এডভাঞ্ছ নেওয়া হয়েছে','admin','2024-07-09','11:35:13 am','::1','DESKTOP-GMFRN98',1),(3,2,3,'ADV0003','2024-07-09',7,5000.0000,'Rocket','HP ল্যাপটপ এনে দিতে হবে ','admin','2024-07-09','11:36:22 am','::1','DESKTOP-GMFRN98',1),(4,2,4,'ADV0004','2024-07-09',7,500.0000,'CASH','আইফোন ১৩ প্র মেক্স আনার জন্য এডভাঞ্ছ দেওয়া হয়েছে','admin','2024-07-09','11:37:31 am','::1','DESKTOP-GMFRN98',1),(5,2,5,'ADV0005','2024-07-10',5,5000.0000,'CASH','For Oder Iphone 15 Pro max','admin','2024-07-10','12:26:49 pm','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',1),(6,2,6,'ADV0006','2024-08-13',13,20000.0000,'CASH','Monthly Cost babat','admin','2024-08-19','01:09:11 am','103.59.179.21','103.59.179.21',1),(7,2,7,'ADV0007','2024-09-22',2,900.0000,'Bkash','','admin','2024-09-22','10:47:05 pm','103.109.96.196','client-103-109-96-196.digijadoo.net',1);
/*!40000 ALTER TABLE `db_custadvance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_customer_coupons`
--

DROP TABLE IF EXISTS `db_customer_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_customer_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(100) DEFAULT NULL,
  `system_name` varchar(250) DEFAULT NULL,
  `system_ip` varchar(250) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `coupon_id` (`coupon_id`),
  CONSTRAINT `db_customer_coupons_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_customer_coupons_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_customer_coupons_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_customer_coupons_ibfk_4` FOREIGN KEY (`coupon_id`) REFERENCES `db_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_customer_coupons`
--

LOCK TABLES `db_customer_coupons` WRITE;
/*!40000 ALTER TABLE `db_customer_coupons` DISABLE KEYS */;
INSERT INTO `db_customer_coupons` VALUES (2,2,'84853658313498',NULL,'পহেলা বৈশাখ',120.00,'Fixed','2026-07-09',1,'admin','2024-07-09','11:28:46 am','DESKTOP-GMFRN98','::1',3,343),(3,2,'04122426478792',NULL,'ঈদ অফার',200.00,'Fixed','2026-07-09',1,'admin','2024-07-09','11:29:53 am','DESKTOP-GMFRN98','::1',2,344),(4,2,'72892605148336',NULL,'পূজা অফার',500.00,'Fixed','2026-07-09',1,'admin','2024-07-09','11:30:26 am','DESKTOP-GMFRN98','::1',2,345);
/*!40000 ALTER TABLE `db_customer_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_customer_payments`
--

DROP TABLE IF EXISTS `db_customer_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_customer_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salespayment_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `salespayment_id` (`salespayment_id`),
  CONSTRAINT `db_customer_payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_customer_payments_ibfk_2` FOREIGN KEY (`salespayment_id`) REFERENCES `db_salespayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_customer_payments`
--

LOCK TABLES `db_customer_payments` WRITE;
/*!40000 ALTER TABLE `db_customer_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_customer_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_customers`
--

DROP TABLE IF EXISTS `db_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Customer Code',
  `customer_code` varchar(20) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `tax_number` varchar(50) DEFAULT NULL,
  `vatin` varchar(100) DEFAULT NULL,
  `opening_balance` double(20,4) DEFAULT NULL,
  `sales_due` double(20,4) DEFAULT NULL,
  `sales_return_due` double(20,4) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `ship_country_id` int(11) DEFAULT NULL,
  `ship_state_id` int(11) DEFAULT NULL,
  `ship_city` varchar(100) DEFAULT NULL,
  `ship_postcode` varchar(10) DEFAULT NULL,
  `ship_address` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `location_link` text DEFAULT NULL,
  `attachment_1` text DEFAULT NULL,
  `price_level_type` varchar(50) DEFAULT 'Increase',
  `price_level` double(20,4) DEFAULT 0.0000,
  `delete_bit` int(11) DEFAULT 0,
  `tot_advance` double(20,4) DEFAULT NULL,
  `credit_limit` double(20,4) DEFAULT -1.0000,
  `shippingaddress_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_customers_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_customers`
--

LOCK TABLES `db_customers` WRITE;
/*!40000 ALTER TABLE `db_customers` DISABLE KEYS */;
INSERT INTO `db_customers` VALUES (1,1,NULL,'CU0001','Walk-in customer',NULL,'','','','',NULL,0.0000,0.0000,0.0000,1,NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-01-01','10:55:54 pm','admin',NULL,1,NULL,NULL,'Increase',0.0000,1,NULL,-1.0000,1),(2,2,1,'CU/02/0001','Walk-in customer',NULL,NULL,NULL,NULL,NULL,NULL,NULL,27249.0000,0.0000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-02-12','05:53:37 pm','',NULL,1,NULL,NULL,'Increase',0.0000,1,900.0000,-1.0000,2),(3,2,2,'CU0002','Md Abdul Rashid','01858989394','','','','',NULL,0.0000,520.0000,0.0000,210,NULL,'Dhaka','','35/3/1,B,Section-13',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:11:31 am','admin',NULL,1,'',NULL,'Increase',0.0000,0,3000.0000,-1.0000,4),(4,2,3,'CU0003','Md Abdul Rashid','+8801870829343','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'35/3/1-B,Section-13,Dhaka',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:13:37 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,NULL,NULL,NULL),(5,2,4,'CU0004','Md kader','+8801870829344',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'35/3,Dhaka',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:15:54 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,5000.0000,NULL,NULL),(6,2,5,'CU0005','Md Jashim','01775457003',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:20:13 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,1200.0000,NULL,NULL),(7,2,6,'CU0006','Md Khaledur Rahman','01875952626',NULL,'',NULL,NULL,NULL,0.0000,0.0000,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:24:02 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,5500.0000,-1.0000,NULL),(8,2,7,'CU0007','Ami Tomar','8801870829399',NULL,'',NULL,NULL,NULL,0.0000,0.0000,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:25:20 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,0.0000,-1.0000,NULL),(9,2,8,'CU0008','Md Khalil','01775457889',NULL,'',NULL,NULL,NULL,0.0000,0.0000,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-GMFRN98','2024-07-09','02:26:45 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,0.0000,-1.0000,NULL),(10,2,9,'CU0009','Md Khalekur','01858989397',NULL,'',NULL,NULL,NULL,0.0000,120.0000,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','2024-07-09','01:56:20 pm','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,0.0000,-1.0000,NULL),(11,2,10,'CU0010','Md Khaled','8801870829345',NULL,'',NULL,NULL,NULL,0.0000,NULL,NULL,NULL,NULL,NULL,NULL,'35/3/1,B,Section-13',NULL,NULL,NULL,NULL,NULL,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','2024-07-10','11:58:13 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,NULL,-1.0000,NULL),(12,2,11,'CU0011','Md Nayan','01870829340',NULL,'nayam@gmial.com',NULL,NULL,NULL,0.0000,0.0000,NULL,NULL,NULL,NULL,NULL,'35/3/1,B,Section-13',NULL,NULL,NULL,NULL,NULL,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','2024-07-10','12:18:48 pm','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,0.0000,-1.0000,NULL),(13,2,12,'CU0012','MD. FARID AHMED','01658789639','','heaventechit247@gmail.com','','',NULL,0.0000,0.0000,NULL,210,67,'Dahak','1200','sutrapur\r\njatrabary',NULL,NULL,NULL,NULL,NULL,'103.88.140.78','103.88.140.78','2024-07-11','10:00:56 pm','admin',NULL,1,'',NULL,'Increase',0.0000,0,20000.0000,5000.0000,7),(14,2,13,'CU0013','Siam Ahmed','0133483004',NULL,'sksiamboss121@gmail.com',NULL,NULL,NULL,10.0000,0.0000,NULL,NULL,NULL,NULL,NULL,'Chapai Nawbabganj club super market\r\nChapai Nawbabganj club super market dokan No: 119120',NULL,NULL,NULL,NULL,NULL,'182.48.82.20','182.48.82.20','2024-07-14','02:06:56 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,0.0000,-1.0000,NULL),(15,2,14,'CU0014','siam','01333483004',NULL,'fahimchowdhury2580@gmail.com',NULL,NULL,NULL,0.0000,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'114.130.189.19','114.130.189.19','2024-07-14','10:41:49 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,NULL,-1.0000,NULL),(16,2,15,'CU0015','siam','01744594344',NULL,'fahimchowdhury2580@gmail.com',NULL,NULL,NULL,0.0000,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'114.130.189.19','114.130.189.19','2024-07-14','10:50:34 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,NULL,-1.0000,NULL),(17,2,16,'CU0016','siam','+8801886507498',NULL,'fahimchowdhury2580@gmail.com',NULL,NULL,NULL,0.0000,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'114.130.189.19','114.130.189.19','2024-07-14','10:54:07 am','admin',NULL,1,NULL,NULL,'Increase',0.0000,0,NULL,-1.0000,NULL),(18,2,17,'CU0017','Rashed','01750781781','','','','',NULL,0.0000,NULL,NULL,0,NULL,'','','Balabari ',NULL,NULL,NULL,NULL,NULL,'37.111.225.121','37.111.225.121','2024-07-16','04:04:12 pm','admin',NULL,1,'',NULL,'Increase',0.0000,0,NULL,-1.0000,5),(19,2,18,'CU0018','Md Farhan Tanvir','01965982698','01965982698','afarid126@gmail.com','','',NULL,0.0000,NULL,NULL,210,66,'Dhaka','1202','sutrapur\r\njatrabary',NULL,NULL,NULL,NULL,NULL,'103.59.179.21','103.59.179.21','2024-08-19','12:53:54 am','admin',NULL,1,'',NULL,'Increase',0.0000,0,NULL,-1.0000,6),(20,2,19,'CU0019','Mazharul Islam','+8801706452007','','mazharuli325@gmail.com','','',NULL,0.0000,0.0000,NULL,210,NULL,'Sirajganj','1215','Bolorampur, Kamarkhand, Sirajganj',NULL,NULL,NULL,NULL,NULL,'182.163.115.234','IP-115-234.bol-online.com','2024-08-31','05:23:02 pm','admin',NULL,1,'',NULL,'Increase',0.0000,0,0.0000,0.0000,8),(21,2,20,'CU0020','Jony','01862648892','01714478780','','','',NULL,0.0000,NULL,NULL,210,67,'Jashore ','7400','Hospital get',NULL,NULL,NULL,NULL,NULL,'37.111.247.37','37.111.247.37','2024-09-22','07:47:53 pm','admin',NULL,1,'',NULL,'Increase',0.0000,0,NULL,0.0000,9),(22,3,1,'CU/03/0001','Walk-in customer',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.0000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-V3TH0KV','2026-09-30','10:31:26 pm','superadmin',NULL,1,NULL,NULL,'Increase',0.0000,1,0.0000,-1.0000,NULL),(23,3,2,'CU/03/0002','Jubayer Mehedi Khan','01818430308','','shuvo2525@gmail.com','','',NULL,0.0000,0.0000,NULL,210,66,'Tangail','1940','Dewhata Mirzapur.',NULL,NULL,NULL,NULL,NULL,'::1','DESKTOP-V3TH0KV','2026-09-30','06:05:57 pm','shuvo2525',NULL,1,'',NULL,'Increase',0.0000,0,0.0000,0.0000,10);
/*!40000 ALTER TABLE `db_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_emailtemplates`
--

DROP TABLE IF EXISTS `db_emailtemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_emailtemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `key` varchar(150) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `variables` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `undelete_bit` int(11) DEFAULT NULL,
  `admin_only` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_emailtemplates_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_emailtemplates`
--

LOCK TABLES `db_emailtemplates` WRITE;
/*!40000 ALTER TABLE `db_emailtemplates` DISABLE KEYS */;
INSERT INTO `db_emailtemplates` VALUES (1,1,'SAAS_FORGOT_PASSWORD_EMAIL','Site forgot password email template','Hi {{user_name}},\r\n\r\nyour OTP is {{email_otp}}\r\n\r\nThank you\r\n{{saas_name}}','{{user_name}}<br>\r\n{{saas_name}}<br>\r\n{{email_otp}}<br>',1,1,1),(2,1,'SAAS_WELCOME_EMAIL','Site welcome email','Hi {{user_name}},\r\nYour email id {{email_id}},\r\nwelcome to our {{saas_name}},\r\n\r\nThank you','{{user_name}}<br>\r\n{{email_id}}<br>\r\n{{saas_name}}<br>',1,1,1);
/*!40000 ALTER TABLE `db_emailtemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_emi`
--

DROP TABLE IF EXISTS `db_emi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_emi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT 1,
  `emi_code` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_id` int(11) DEFAULT 0,
  `item_details` text NOT NULL,
  `total_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `down_payment` double(20,4) NOT NULL DEFAULT 0.0000,
  `financed_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `interest_rate` double(10,2) NOT NULL DEFAULT 0.00,
  `interest_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `total_payable` double(20,4) NOT NULL DEFAULT 0.0000,
  `emi_frequency` varchar(20) NOT NULL DEFAULT 'Monthly',
  `total_installments` int(11) NOT NULL DEFAULT 0,
  `installment_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `paid_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `due_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Active',
  `notes` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `emi_code` (`emi_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_emi`
--

LOCK TABLES `db_emi` WRITE;
/*!40000 ALTER TABLE `db_emi` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_emi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_emi_installments`
--

DROP TABLE IF EXISTS `db_emi_installments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_emi_installments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emi_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT 1,
  `installment_no` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `paid_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `emi_id` (`emi_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_emi_installments`
--

LOCK TABLES `db_emi_installments` WRITE;
/*!40000 ALTER TABLE `db_emi_installments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_emi_installments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_emi_payments`
--

DROP TABLE IF EXISTS `db_emi_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_emi_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emi_id` int(11) NOT NULL,
  `installment_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 1,
  `receipt_no` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_amount` double(20,4) NOT NULL DEFAULT 0.0000,
  `payment_type` varchar(50) NOT NULL DEFAULT 'Cash',
  `account_id` int(11) DEFAULT 0,
  `payment_note` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emi_id` (`emi_id`),
  KEY `store_id` (`store_id`),
  KEY `receipt_no` (`receipt_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_emi_payments`
--

LOCK TABLES `db_emi_payments` WRITE;
/*!40000 ALTER TABLE `db_emi_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_emi_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_employees`
--

DROP TABLE IF EXISTS `db_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT 1,
  `employee_code` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `marital_status` varchar(30) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `monthly_salary` decimal(15,2) DEFAULT 0.00,
  `photo` text DEFAULT NULL,
  `nid_number` varchar(50) DEFAULT NULL,
  `nid_photo` text DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_relation` varchar(50) DEFAULT NULL,
  `emergency_contact_mobile` varchar(30) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_holder` varchar(100) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `bank_branch` varchar(100) DEFAULT NULL,
  `bank_routing_code` varchar(50) DEFAULT NULL,
  `cv_file` text DEFAULT NULL,
  `education_details` text DEFAULT NULL,
  `experience_details` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_store_id` (`store_id`),
  KEY `idx_employee_code` (`employee_code`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_employees`
--

LOCK TABLES `db_employees` WRITE;
/*!40000 ALTER TABLE `db_employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_expense`
--

DROP TABLE IF EXISTS `db_expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Expense Code',
  `expense_code` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `expense_for` varchar(100) DEFAULT NULL,
  `expense_amt` double(20,4) DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `db_expense_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_expense_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `ac_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_expense`
--

LOCK TABLES `db_expense` WRITE;
/*!40000 ALTER TABLE `db_expense` DISABLE KEYS */;
INSERT INTO `db_expense` VALUES (34,2,1,'EX0001',60,'2024-07-09','','For Guest',100.0000,'CASH',1,'অতিথিদের জন্য চা আনা হয়েছিল।','admin','2024-07-09','11:18:48 am','::1','DESKTOP-GMFRN98',1),(35,2,2,'EX0002',59,'2024-07-09','4777','Lunch',500.0000,'CASH',1,'লাঞ্ছ করা হয়েছিল','admin','2024-07-09','11:20:01 am','::1','DESKTOP-GMFRN98',1),(36,2,3,'EX0003',58,'2024-07-09','655','ঝাড়ু কেনা হয়েছে',200.0000,'CASH',1,'ঝাড়ু কেনা হয়েছিল','admin','2024-07-09','11:21:13 am','::1','DESKTOP-GMFRN98',1),(37,2,4,'EX0004',61,'2024-07-09','','যাতায়াত ভাড়া',1200.0000,'CASH',1,'স্টাফদের যাতায়াত ভাড়া','admin','2024-07-09','11:22:21 am','::1','DESKTOP-GMFRN98',1),(38,2,5,'EX0005',58,'2024-07-10','','Flor Clean Koriyechi',200.0000,'CASH',1,'','admin','2024-07-10','12:43:10 pm','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',1),(39,2,6,'EX0006',62,'2024-08-19','Salary of August 24','Karim Salary',20000.0000,'CASH',1,'Salary of August 24','admin','2024-08-19','01:31:57 am','103.59.179.21','103.59.179.21',1);
/*!40000 ALTER TABLE `db_expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_expense_category`
--

DROP TABLE IF EXISTS `db_expense_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_expense_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `category_code` varchar(50) DEFAULT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_expense_category_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_expense_category`
--

LOCK TABLES `db_expense_category` WRITE;
/*!40000 ALTER TABLE `db_expense_category` DISABLE KEYS */;
INSERT INTO `db_expense_category` VALUES (58,2,'EC0001','Cleaning','','user_67930',1),(59,2,'EC0059','Lunch','','user_67930',1),(60,2,'EC0060','Tea Bill','','user_67930',1),(61,2,'EC0061','Traveling','','user_67930',1),(62,2,'EC0062','Staff Salary','Monthly Salary','admin',1);
/*!40000 ALTER TABLE `db_expense_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_fivemojo`
--

DROP TABLE IF EXISTS `db_fivemojo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_fivemojo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instance_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_fivemojo_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_fivemojo`
--

LOCK TABLES `db_fivemojo` WRITE;
/*!40000 ALTER TABLE `db_fivemojo` DISABLE KEYS */;
INSERT INTO `db_fivemojo` VALUES (4,2,'https://app.fivemojo.com/api/send.php','','',0);
/*!40000 ALTER TABLE `db_fivemojo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_hold`
--

DROP TABLE IF EXISTS `db_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_hold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL COMMENT 'Temprary',
  `reference_no` varchar(50) DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,2) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,2) DEFAULT NULL,
  `discount_to_all_input` double(20,2) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,2) DEFAULT NULL,
  `subtotal` double(20,2) DEFAULT NULL,
  `round_off` double(20,2) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `sales_note` text DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `warehouse_id` (`warehouse_id`),
  CONSTRAINT `db_hold_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_hold_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_hold_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_hold`
--

LOCK TABLES `db_hold` WRITE;
/*!40000 ALTER TABLE `db_hold` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_hold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_holditems`
--

DROP TABLE IF EXISTS `db_holditems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_holditems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `hold_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sales_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `sales_id` (`hold_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `db_holditems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_holditems_ibfk_2` FOREIGN KEY (`hold_id`) REFERENCES `db_hold` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_holditems_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=394 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_holditems`
--

LOCK TABLES `db_holditems` WRITE;
/*!40000 ALTER TABLE `db_holditems` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_holditems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_instamojo`
--

DROP TABLE IF EXISTS `db_instamojo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_instamojo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `sandbox` int(11) DEFAULT NULL,
  `api_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `api_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_instamojo_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_instamojo`
--

LOCK TABLES `db_instamojo` WRITE;
/*!40000 ALTER TABLE `db_instamojo` DISABLE KEYS */;
INSERT INTO `db_instamojo` VALUES (1,1,1,'','','2021-02-22','Admin',1);
/*!40000 ALTER TABLE `db_instamojo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_instamojopayments`
--

DROP TABLE IF EXISTS `db_instamojopayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_instamojopayments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `buyer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `amount` decimal(16,2) NOT NULL,
  `purpose` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `expires_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `send_sms` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `send_email` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `sms_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `shorturl` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `longurl` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `redirect_url` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `webhook` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `allow_repeated_payments` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `customer_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_instamojopayments`
--

LOCK TABLES `db_instamojopayments` WRITE;
/*!40000 ALTER TABLE `db_instamojopayments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_instamojopayments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_items`
--

DROP TABLE IF EXISTS `db_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create ITEM Code',
  `item_code` varchar(50) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `hsn` varchar(50) DEFAULT NULL,
  `sac` varchar(50) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `alert_qty` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `lot_number` varchar(50) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `price` double(20,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `purchase_price` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `profit_margin` double(20,2) DEFAULT NULL,
  `sales_price` double(20,4) DEFAULT NULL,
  `stock` double(20,2) DEFAULT NULL,
  `item_image` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `discount_type` varchar(100) DEFAULT 'Percentage',
  `discount` double(20,2) DEFAULT 0.00,
  `service_bit` int(11) DEFAULT 0,
  `seller_points` double(20,2) DEFAULT 0.00,
  `custom_barcode` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `item_group` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `child_bit` int(11) DEFAULT 0,
  `mrp` double(20,4) DEFAULT NULL,
  `warranty_days` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_items_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_items`
--

LOCK TABLES `db_items` WRITE;
/*!40000 ALTER TABLE `db_items` DISABLE KEYS */;
INSERT INTO `db_items` VALUES (1,2,1,'IT020001','Iphone 15 Pro Max',82,'','',NULL,61,10,330,NULL,NULL,15000.0000,150,15000.0000,'Inclusive',46.67,22000.0000,99998924.00,'uploads/items/1720468353.jpg','::1','DESKTOP-GMFRN98','2024-07-09','01:52:33 am','admin',NULL,1,'Percentage',0.00,0,0.00,'44577754432555','','Single',NULL,NULL,0,0.0000,0),(2,2,2,'IT020002','Denim Pant for men&#039;s',84,'','',NULL,61,10,331,NULL,NULL,300.0000,150,300.0000,'Inclusive',73.00,520.0000,10098937.00,'uploads/items/1720504218.jpg','::1','DESKTOP-GMFRN98','2024-07-09','11:50:18 am','admin',NULL,1,'Percentage',0.00,0,0.00,'','','Single',NULL,NULL,0,0.0000,0),(3,2,3,'IT020003','Men&#039;s Shirt',84,'','',NULL,61,0,329,NULL,NULL,300.0000,150,300.0000,'Inclusive',50.00,450.0000,1098991.00,'uploads/items/1720504518.jpg','::1','DESKTOP-GMFRN98','2024-07-09','11:55:18 am','admin',NULL,1,'Percentage',0.00,0,0.00,'4578222','','Single',NULL,NULL,0,0.0000,0),(4,2,4,'IT020004','Chiken',83,'','',NULL,62,10,0,NULL,NULL,180.0000,150,180.0000,'Inclusive',22.22,220.0000,99999797.00,'uploads/items/1720504803.png','::1','DESKTOP-GMFRN98','2024-07-09','12:00:03 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'5555555533','','Single',NULL,NULL,0,0.0000,0),(5,2,5,'IT020005','Egg',83,'','',NULL,61,0,0,NULL,NULL,10.0000,150,10.0000,'Inclusive',20.00,12.0000,9999999984.00,'uploads/items/1720504912.png','::1','DESKTOP-GMFRN98','2024-07-09','12:01:52 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'4332222','','Single',NULL,NULL,0,0.0000,0),(6,2,6,'IT020006','Rice',83,'','',NULL,62,10,328,NULL,NULL,35.0000,150,35.0000,'Inclusive',28.57,45.0000,999988.00,'uploads/items/1720505022.png','::1','DESKTOP-GMFRN98','2024-07-09','12:03:42 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'3221555','','Single',NULL,NULL,0,0.0000,0),(7,2,7,'IT020007','Moricer Gura',83,'','',NULL,61,64,329,NULL,NULL,8.0000,150,8.0000,'Inclusive',50.00,12.0000,99999008.00,'uploads/items/1720505141.jpg','::1','DESKTOP-GMFRN98','2024-07-09','12:05:41 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'321155677','','Single',NULL,NULL,0,0.0000,0),(8,2,8,'IT020008','Holuder Gura',83,'','',NULL,61,10,328,NULL,NULL,12.0000,150,12.0000,'Inclusive',25.00,15.0000,9998993.00,'uploads/items/1720505302.jpg','::1','DESKTOP-GMFRN98','2024-07-09','12:08:22 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'66422111','','Single',NULL,NULL,0,0.0000,0),(9,2,9,'IT020009','Women&#039;s Sharee',84,'','',NULL,61,10,0,NULL,NULL,400.0000,150,400.0000,'Inclusive',25.00,500.0000,98996.00,'uploads/items/1720505656.png','::1','DESKTOP-GMFRN98','2024-07-09','12:14:16 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'12345','','Single',NULL,NULL,0,0.0000,0),(10,2,10,'IT020010','Tshirt',84,'','',NULL,61,5,328,NULL,NULL,400.0000,150,400.0000,'Inclusive',25.00,500.0000,9998998.00,'uploads/items/1720505772.jpg','::1','DESKTOP-GMFRN98','2024-07-09','12:16:12 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'456777','','Single',NULL,NULL,0,0.0000,0),(11,2,11,'IT020011','Mashroom',83,'','',NULL,61,5,328,NULL,NULL,10.0000,150,10.0000,'Inclusive',20.00,12.0000,0.00,'uploads/items/1720507325.png','::1','DESKTOP-GMFRN98','2024-07-09','12:42:05 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'44577754432555','','Single',NULL,NULL,0,0.0000,0),(12,2,12,'IT020012','Kalolite Capsulle',85,'','',NULL,61,5,333,NULL,NULL,20.0000,150,20.0000,'Inclusive',50.00,30.0000,18.00,'uploads/items/1720594148.png','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','2024-07-10','12:49:08 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'44577754432555','vcbbcvbvbvc','Single',NULL,NULL,0,50.0000,0),(13,2,13,'IT020013','tplink',82,'','',NULL,64,0,0,NULL,NULL,2250.0000,150,2250.0000,'Inclusive',0.00,2250.0000,NULL,NULL,'114.130.189.19','114.130.189.19','2024-07-14','10:47:20 am','admin',NULL,1,'Percentage',0.00,0,0.00,'','','Single',NULL,NULL,0,0.0000,0),(14,2,14,'IT020014','tplink c54',82,'','',NULL,64,0,331,NULL,NULL,2250.0000,150,2250.0000,'Inclusive',0.00,0.0000,10.00,NULL,'114.130.189.19','114.130.189.19','2024-07-14','10:52:51 am','admin',NULL,1,'Percentage',0.00,0,2250.00,'','','Single',NULL,NULL,0,0.0000,0),(15,2,15,'IT020015','kk',82,'','',NULL,64,0,0,NULL,NULL,1200.0000,150,1200.0000,'Exclusive',0.00,1200.0000,NULL,NULL,'37.111.211.73','37.111.211.73','2024-07-15','04:45:19 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'','','Single',NULL,NULL,0,1100.0000,0),(16,2,16,'IT020016','As123',82,NULL,'12 am ','',NULL,NULL,NULL,NULL,NULL,1000.0000,150,1000.0000,'Inclusive',NULL,1000.0000,NULL,'uploads/items/1722495974.jpg','115.164.210.7','UE7.210.digi.net.my','2024-08-01','01:06:14 pm','admin',NULL,1,'Fixed',0.00,1,0.00,'','133\r\nEkk\r\nEkk\r\nJgv',NULL,NULL,NULL,0,NULL,0),(17,2,17,'IT020017','Kiau',82,'Snsjhdh','Ndsnihshsj',NULL,61,110100,328,NULL,NULL,182737.0000,150,182737.0000,'Exclusive',10.00,201010.7000,NULL,NULL,'182.48.69.235','182.48.69.235','2024-08-03','01:17:12 am','admin',NULL,1,'Percentage',20.00,0,0.00,'17363683','Test','Single',NULL,NULL,0,1727.0000,0),(18,2,18,'IT020018','cctv',82,'','',NULL,61,0,328,NULL,NULL,2000.0000,150,2000.0000,'Inclusive',10.00,2200.0000,34.00,NULL,'103.197.248.45','103.197.248-45.eurotelbd.net','2024-08-11','07:09:49 pm','admin',NULL,1,'Percentage',0.00,0,0.00,'','','Single',NULL,NULL,0,0.0000,0),(19,2,19,'IT020019','Ball Pen',83,'','',NULL,61,20,331,NULL,NULL,100.0000,150,100.0000,'Inclusive',0.00,100.0000,0.00,NULL,'103.59.179.21','103.59.179.21','2024-08-19','12:28:11 am','admin',NULL,1,'Percentage',3.00,0,2.00,'FAR125ID','','Single',NULL,NULL,0,100.0000,0),(20,3,1,'IT030001','Techno Spark 20 Plus Pro',86,'','',NULL,66,0,334,NULL,NULL,1000.0000,NULL,1000.0000,'Inclusive',100.00,2000.0000,2.00,NULL,'::1','DESKTOP-V3TH0KV','2026-09-30','05:07:19 pm','shuvo2525',NULL,1,'Percentage',0.00,0,0.00,'3759986948','','Single',NULL,NULL,0,2000.0000,0),(21,3,2,'IT030002','cocacola',86,'1234567','',NULL,66,0,334,NULL,NULL,1000.0000,NULL,1000.0000,'Inclusive',100.00,2000.0000,10.00,NULL,'::1','DESKTOP-V3TH0KV','2026-10-01','11:11:59 am','shuvo2525',NULL,1,'Percentage',0.00,0,0.00,'12345678912345678912','','Single',NULL,NULL,0,2000.0000,0);
/*!40000 ALTER TABLE `db_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_languages`
--

DROP TABLE IF EXISTS `db_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_languages`
--

LOCK TABLES `db_languages` WRITE;
/*!40000 ALTER TABLE `db_languages` DISABLE KEYS */;
INSERT INTO `db_languages` VALUES (1,'English',1),(5,'Bangla',1);
/*!40000 ALTER TABLE `db_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_package`
--

DROP TABLE IF EXISTS `db_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `package_type` varchar(50) DEFAULT NULL,
  `package_code` varchar(20) DEFAULT NULL,
  `package_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `monthly_price` double(20,2) DEFAULT NULL,
  `annual_price` double(20,2) DEFAULT NULL,
  `trial_days` int(11) DEFAULT NULL,
  `max_users` int(11) DEFAULT NULL,
  `max_items` int(11) DEFAULT NULL,
  `max_invoices` int(11) DEFAULT NULL,
  `max_warehouses` int(11) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `plan_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_package_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_package`
--

LOCK TABLES `db_package` WRITE;
/*!40000 ALTER TABLE `db_package` DISABLE KEYS */;
INSERT INTO `db_package` VALUES (1,1,'Free',NULL,'Free Plan','Free plan for new businesses',0.00,0.00,30,1,50,50,1,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-13','06:37:21 pm','admin',1,'Both'),(2,1,'Trial',NULL,'Trial 14 Days','14-Day Full Access Free Trial',0.00,0.00,14,3,200,200,2,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-13','06:39:23 pm','admin',1,'Both'),(3,1,'Paid',NULL,'Starter 100','Monthly 100 Tk, Annual 1200 Tk (12x)',100.00,1200.00,0,2,100,100,1,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(4,1,'Paid',NULL,'Basic 200','Monthly 200 Tk, Annual 2400 Tk (12x)',200.00,2400.00,0,3,300,300,2,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(5,1,'Paid',NULL,'Standard 300','Monthly 300 Tk, Annual 3600 Tk (12x)',300.00,3600.00,0,5,500,500,3,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(6,1,'Paid',NULL,'Business 500','Monthly 500 Tk, Annual 6000 Tk (12x)',500.00,6000.00,0,10,1000,1000,5,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(7,1,'Paid',NULL,'Professional 1000','Monthly 1000 Tk, Annual 12000 Tk (12x)',1000.00,12000.00,0,20,5000,5000,10,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(8,1,'Paid',NULL,'Advanced 1500','Monthly 1500 Tk, Annual 18000 Tk (12x)',1500.00,18000.00,0,30,10000,10000,20,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(9,1,'Paid',NULL,'Premium 2000','Monthly 2000 Tk, Annual 24000 Tk (12x)',2000.00,24000.00,0,50,25000,25000,50,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both'),(10,1,'Paid',NULL,'Enterprise 5000','Monthly 5000 Tk, Annual 60000 Tk (12x) - Unlimited',5000.00,60000.00,0,-1,-1,-1,-1,NULL,'127.0.0.1','LAPTOP-I5OUIM4R','2021-01-24','12:35:30 pm','admin',1,'Both');
/*!40000 ALTER TABLE `db_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_paymenttypes`
--

DROP TABLE IF EXISTS `db_paymenttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_paymenttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_paymenttypes_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_paymenttypes`
--

LOCK TABLES `db_paymenttypes` WRITE;
/*!40000 ALTER TABLE `db_paymenttypes` DISABLE KEYS */;
INSERT INTO `db_paymenttypes` VALUES (36,2,'CASH',1),(37,2,'Bkash',1),(38,2,'Rocket',1),(39,2,'Nagod',1),(40,2,'Bank',1);
/*!40000 ALTER TABLE `db_paymenttypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_paypal`
--

DROP TABLE IF EXISTS `db_paypal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `sandbox` int(11) DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_paypal_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_paypal`
--

LOCK TABLES `db_paypal` WRITE;
/*!40000 ALTER TABLE `db_paypal` DISABLE KEYS */;
INSERT INTO `db_paypal` VALUES (1,1,1,'','2021-02-22','Admin',1);
/*!40000 ALTER TABLE `db_paypal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_paypalpaylog`
--

DROP TABLE IF EXISTS `db_paypalpaylog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_paypalpaylog` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_gross` float(10,2) NOT NULL,
  `currency_code` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payer_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_paypalpaylog`
--

LOCK TABLES `db_paypalpaylog` WRITE;
/*!40000 ALTER TABLE `db_paypalpaylog` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_paypalpaylog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_permissions`
--

DROP TABLE IF EXISTS `db_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `permissions` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_permissions_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6449 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_permissions`
--

LOCK TABLES `db_permissions` WRITE;
/*!40000 ALTER TABLE `db_permissions` DISABLE KEYS */;
INSERT INTO `db_permissions` VALUES (4414,1,17,'items_add'),(4415,1,17,'items_edit'),(4416,1,17,'items_delete'),(4417,1,17,'items_view'),(4418,1,17,'import_items'),(4419,1,17,'brand_add'),(4420,1,17,'brand_edit'),(4421,1,17,'brand_delete'),(4422,1,17,'brand_view'),(4423,1,17,'customers_add'),(4424,1,17,'customers_edit'),(4425,1,17,'customers_delete'),(4426,1,17,'customers_view'),(4427,1,17,'sales_add'),(4428,1,17,'sales_edit'),(4429,1,17,'sales_delete'),(4430,1,17,'sales_view'),(4431,1,17,'sales_payment_view'),(4432,1,17,'sales_payment_add'),(4433,1,17,'sales_payment_delete'),(4434,1,17,'sales_report'),(4435,1,17,'sales_payments_report'),(4436,1,17,'items_category_add'),(4437,1,17,'items_category_edit'),(4438,1,17,'items_category_delete'),(4439,1,17,'items_category_view'),(4440,1,17,'print_labels'),(4441,1,17,'dashboard_view'),(4442,1,17,'dashboard_info_box_1'),(4443,1,17,'dashboard_info_box_2'),(4444,1,17,'dashboard_pur_sal_chart'),(4445,1,17,'dashboard_recent_items'),(4446,1,17,'dashboard_stock_alert'),(4447,1,17,'dashboard_trending_items_chart'),(4448,1,17,'sales_return_add'),(4449,1,17,'sales_return_edit'),(4450,1,17,'sales_return_delete'),(4451,1,17,'sales_return_view'),(4452,1,17,'sales_return_report'),(4453,1,17,'sales_return_payment_view'),(4454,1,17,'sales_return_payment_add'),(4455,1,17,'sales_return_payment_delete'),(4456,1,17,'payment_types_add'),(4457,1,17,'payment_types_edit'),(4458,1,17,'payment_types_delete'),(4459,1,17,'payment_types_view'),(4460,1,17,'import_customers'),(4461,1,17,'stock_transfer_add'),(4462,1,17,'stock_transfer_edit'),(4463,1,17,'stock_transfer_delete'),(4464,1,17,'stock_transfer_view'),(4465,1,17,'seller_points_report'),(4466,1,17,'services_add'),(4467,1,17,'services_edit'),(4468,1,17,'services_delete'),(4469,1,17,'services_view'),(4470,1,17,'import_services'),(4471,1,17,'stock_adjustment_add'),(4472,1,17,'stock_adjustment_edit'),(4473,1,17,'stock_adjustment_delete'),(4474,1,17,'stock_adjustment_view'),(4475,1,17,'variant_add'),(4476,1,17,'variant_edit'),(4477,1,17,'variant_delete'),(4478,1,17,'variant_view'),(4479,1,17,'accounts_add'),(4480,1,17,'accounts_edit'),(4481,1,17,'accounts_delete'),(4482,1,17,'accounts_view'),(4483,1,17,'money_transfer_add'),(4484,1,17,'money_transfer_edit'),(4485,1,17,'money_transfer_delete'),(4486,1,17,'money_transfer_view'),(4487,1,17,'money_deposit_add'),(4488,1,17,'money_deposit_edit'),(4489,1,17,'money_deposit_delete'),(4490,1,17,'money_deposit_view'),(4491,1,17,'sales_tax_report'),(4492,1,18,'tax_add'),(4493,1,18,'tax_edit'),(4494,1,18,'tax_delete'),(4495,1,18,'tax_view'),(4496,1,18,'units_add'),(4497,1,18,'units_edit'),(4498,1,18,'units_delete'),(4499,1,18,'units_view'),(4500,1,18,'items_add'),(4501,1,18,'items_edit'),(4502,1,18,'items_delete'),(4503,1,18,'items_view'),(4504,1,18,'import_items'),(4505,1,18,'brand_add'),(4506,1,18,'brand_edit'),(4507,1,18,'brand_delete'),(4508,1,18,'brand_view'),(4509,1,18,'suppliers_add'),(4510,1,18,'suppliers_edit'),(4511,1,18,'suppliers_delete'),(4512,1,18,'suppliers_view'),(4513,1,18,'purchase_add'),(4514,1,18,'purchase_edit'),(4515,1,18,'purchase_delete'),(4516,1,18,'purchase_view'),(4517,1,18,'purchase_report'),(4518,1,18,'purchase_payments_report'),(4519,1,18,'items_category_add'),(4520,1,18,'items_category_edit'),(4521,1,18,'items_category_delete'),(4522,1,18,'items_category_view'),(4523,1,18,'print_labels'),(4524,1,18,'dashboard_view'),(4525,1,18,'dashboard_info_box_1'),(4526,1,18,'dashboard_info_box_2'),(4527,1,18,'dashboard_pur_sal_chart'),(4528,1,18,'dashboard_recent_items'),(4529,1,18,'dashboard_stock_alert'),(4530,1,18,'dashboard_trending_items_chart'),(4531,1,18,'purchase_return_add'),(4532,1,18,'purchase_return_edit'),(4533,1,18,'purchase_return_delete'),(4534,1,18,'purchase_return_view'),(4535,1,18,'purchase_return_report'),(4536,1,18,'purchase_return_payment_view'),(4537,1,18,'purchase_return_payment_add'),(4538,1,18,'purchase_return_payment_delete'),(4539,1,18,'purchase_payment_view'),(4540,1,18,'purchase_payment_add'),(4541,1,18,'purchase_payment_delete'),(4542,1,18,'payment_types_add'),(4543,1,18,'payment_types_edit'),(4544,1,18,'payment_types_delete'),(4545,1,18,'payment_types_view'),(4546,1,18,'import_suppliers'),(4547,1,18,'stock_transfer_add'),(4548,1,18,'stock_transfer_edit'),(4549,1,18,'stock_transfer_delete'),(4550,1,18,'stock_transfer_view'),(4551,1,18,'warehouse_add'),(4552,1,18,'warehouse_edit'),(4553,1,18,'warehouse_delete'),(4554,1,18,'warehouse_view'),(4555,1,18,'services_add'),(4556,1,18,'services_edit'),(4557,1,18,'services_delete'),(4558,1,18,'services_view'),(4559,1,18,'import_services'),(4560,1,18,'stock_adjustment_add'),(4561,1,18,'stock_adjustment_edit'),(4562,1,18,'stock_adjustment_delete'),(4563,1,18,'stock_adjustment_view'),(4564,1,18,'variant_add'),(4565,1,18,'variant_edit'),(4566,1,18,'variant_delete'),(4567,1,18,'variant_view'),(4568,1,18,'accounts_add'),(4569,1,18,'accounts_edit'),(4570,1,18,'accounts_delete'),(4571,1,18,'accounts_view'),(4572,1,18,'money_transfer_add'),(4573,1,18,'money_transfer_edit'),(4574,1,18,'money_transfer_delete'),(4575,1,18,'money_transfer_view'),(4576,1,18,'money_deposit_add'),(4577,1,18,'money_deposit_edit'),(4578,1,18,'money_deposit_delete'),(4579,1,18,'money_deposit_view'),(4580,1,18,'purchase_tax_report'),(5818,1,2,'users_add'),(5819,1,2,'users_edit'),(5820,1,2,'users_delete'),(5821,1,2,'users_view'),(5822,1,2,'tax_add'),(5823,1,2,'tax_edit'),(5824,1,2,'tax_delete'),(5825,1,2,'tax_view'),(5826,1,2,'store_edit'),(5827,1,2,'units_add'),(5828,1,2,'units_edit'),(5829,1,2,'units_delete'),(5830,1,2,'units_view'),(5831,1,2,'roles_add'),(5832,1,2,'roles_edit'),(5833,1,2,'roles_delete'),(5834,1,2,'roles_view'),(5835,1,2,'expense_add'),(5836,1,2,'expense_edit'),(5837,1,2,'expense_delete'),(5838,1,2,'expense_view'),(5839,1,2,'items_add'),(5840,1,2,'items_edit'),(5841,1,2,'items_delete'),(5842,1,2,'items_view'),(5843,1,2,'import_items'),(5844,1,2,'brand_add'),(5845,1,2,'brand_edit'),(5846,1,2,'brand_delete'),(5847,1,2,'brand_view'),(5848,1,2,'suppliers_add'),(5849,1,2,'suppliers_edit'),(5850,1,2,'suppliers_delete'),(5851,1,2,'suppliers_view'),(5852,1,2,'customers_add'),(5853,1,2,'customers_edit'),(5854,1,2,'customers_delete'),(5855,1,2,'customers_view'),(5856,1,2,'purchase_add'),(5857,1,2,'purchase_edit'),(5858,1,2,'purchase_delete'),(5859,1,2,'purchase_view'),(5860,1,2,'sales_add'),(5861,1,2,'sales_edit'),(5862,1,2,'sales_delete'),(5863,1,2,'sales_view'),(5864,1,2,'sales_payment_view'),(5865,1,2,'sales_payment_add'),(5866,1,2,'sales_payment_delete'),(5867,1,2,'sales_report'),(5868,1,2,'purchase_report'),(5869,1,2,'expense_report'),(5870,1,2,'profit_report'),(5871,1,2,'stock_report'),(5872,1,2,'item_sales_report'),(5873,1,2,'purchase_payments_report'),(5874,1,2,'sales_payments_report'),(5875,1,2,'items_category_add'),(5876,1,2,'items_category_edit'),(5877,1,2,'items_category_delete'),(5878,1,2,'items_category_view'),(5879,1,2,'print_labels'),(5880,1,2,'expense_category_add'),(5881,1,2,'expense_category_edit'),(5882,1,2,'expense_category_delete'),(5883,1,2,'expense_category_view'),(5884,1,2,'dashboard_view'),(5885,1,2,'dashboard_info_box_1'),(5886,1,2,'dashboard_info_box_2'),(5887,1,2,'dashboard_pur_sal_chart'),(5888,1,2,'dashboard_recent_items'),(5889,1,2,'dashboard_stock_alert'),(5890,1,2,'dashboard_trending_items_chart'),(5891,1,2,'send_sms'),(5892,1,2,'sms_template_edit'),(5893,1,2,'sms_template_view'),(5894,1,2,'sms_api_view'),(5895,1,2,'sms_api_edit'),(5896,1,2,'purchase_return_add'),(5897,1,2,'purchase_return_edit'),(5898,1,2,'purchase_return_delete'),(5899,1,2,'purchase_return_view'),(5900,1,2,'purchase_return_report'),(5901,1,2,'sales_return_add'),(5902,1,2,'sales_return_edit'),(5903,1,2,'sales_return_delete'),(5904,1,2,'sales_return_view'),(5905,1,2,'sales_return_report'),(5906,1,2,'sales_return_payment_view'),(5907,1,2,'sales_return_payment_add'),(5908,1,2,'sales_return_payment_delete'),(5909,1,2,'purchase_return_payment_view'),(5910,1,2,'purchase_return_payment_add'),(5911,1,2,'purchase_return_payment_delete'),(5912,1,2,'purchase_payment_view'),(5913,1,2,'purchase_payment_add'),(5914,1,2,'purchase_payment_delete'),(5915,1,2,'payment_types_add'),(5916,1,2,'payment_types_edit'),(5917,1,2,'payment_types_delete'),(5918,1,2,'payment_types_view'),(5919,1,2,'import_customers'),(5920,1,2,'import_suppliers'),(5921,1,2,'stock_transfer_add'),(5922,1,2,'stock_transfer_edit'),(5923,1,2,'stock_transfer_delete'),(5924,1,2,'stock_transfer_view'),(5925,1,2,'warehouse_add'),(5926,1,2,'warehouse_edit'),(5927,1,2,'warehouse_delete'),(5928,1,2,'warehouse_view'),(5929,1,2,'supplier_items_report'),(5930,1,2,'seller_points_report'),(5931,1,2,'services_add'),(5932,1,2,'services_edit'),(5933,1,2,'services_delete'),(5934,1,2,'services_view'),(5935,1,2,'quotation_add'),(5936,1,2,'quotation_edit'),(5937,1,2,'quotation_delete'),(5938,1,2,'quotation_view'),(5939,1,2,'import_services'),(5940,1,2,'stock_adjustment_add'),(5941,1,2,'stock_adjustment_edit'),(5942,1,2,'stock_adjustment_delete'),(5943,1,2,'stock_adjustment_view'),(5944,1,2,'variant_add'),(5945,1,2,'variant_edit'),(5946,1,2,'variant_delete'),(5947,1,2,'variant_view'),(5948,1,2,'accounts_add'),(5949,1,2,'accounts_edit'),(5950,1,2,'accounts_delete'),(5951,1,2,'accounts_view'),(5952,1,2,'money_transfer_add'),(5953,1,2,'money_transfer_edit'),(5954,1,2,'money_transfer_delete'),(5955,1,2,'money_transfer_view'),(5956,1,2,'money_deposit_add'),(5957,1,2,'money_deposit_edit'),(5958,1,2,'money_deposit_delete'),(5959,1,2,'money_deposit_view'),(5960,1,2,'sales_tax_report'),(5961,1,2,'purchase_tax_report'),(5962,1,2,'cash_transactions'),(5963,1,2,'show_all_users_sales_invoices'),(5964,1,2,'show_all_users_sales_return_invoices'),(5965,1,2,'show_all_users_purchase_invoices'),(5966,1,2,'show_all_users_purchase_return_invoices'),(5967,1,2,'show_all_users_expenses'),(5968,1,2,'show_all_users_quotations'),(5969,1,2,'subscription'),(5970,1,2,'smtp_settings'),(5971,1,2,'send_email'),(5972,1,2,'sms_settings'),(5973,1,2,'email_template_edit'),(5974,1,2,'email_template_view'),(5975,1,2,'cust_adv_payments_add'),(5976,1,2,'cust_adv_payments_edit'),(5977,1,2,'cust_adv_payments_delete'),(5978,1,2,'cust_adv_payments_view'),(5999,2,28,'cust_adv_payments_add'),(6000,2,28,'cust_adv_payments_edit'),(6001,2,28,'cust_adv_payments_delete'),(6002,2,28,'cust_adv_payments_view'),(6011,2,29,'users_add'),(6012,2,29,'users_edit'),(6013,2,29,'users_delete'),(6014,2,29,'users_view'),(6015,2,29,'tax_add'),(6016,2,29,'tax_edit'),(6017,2,29,'tax_delete'),(6018,2,29,'tax_view'),(6019,2,29,'store_edit'),(6020,2,29,'units_add'),(6021,2,29,'units_edit'),(6022,2,29,'units_delete'),(6023,2,29,'units_view'),(6024,2,29,'roles_add'),(6025,2,29,'roles_edit'),(6026,2,29,'roles_delete'),(6027,2,29,'roles_view'),(6028,2,29,'expense_add'),(6029,2,29,'expense_edit'),(6030,2,29,'expense_delete'),(6031,2,29,'expense_view'),(6032,2,29,'items_add'),(6033,2,29,'items_edit'),(6034,2,29,'items_delete'),(6035,2,29,'items_view'),(6036,2,29,'import_items'),(6037,2,29,'brand_add'),(6038,2,29,'brand_edit'),(6039,2,29,'brand_delete'),(6040,2,29,'brand_view'),(6041,2,29,'suppliers_add'),(6042,2,29,'suppliers_edit'),(6043,2,29,'suppliers_delete'),(6044,2,29,'suppliers_view'),(6045,2,29,'customers_add'),(6046,2,29,'customers_edit'),(6047,2,29,'customers_delete'),(6048,2,29,'customers_view'),(6049,2,29,'purchase_add'),(6050,2,29,'purchase_edit'),(6051,2,29,'purchase_delete'),(6052,2,29,'purchase_view'),(6053,2,29,'sales_add'),(6054,2,29,'sales_edit'),(6055,2,29,'sales_delete'),(6056,2,29,'sales_view'),(6057,2,29,'sales_payment_view'),(6058,2,29,'sales_payment_add'),(6059,2,29,'sales_payment_delete'),(6060,2,29,'sales_report'),(6061,2,29,'purchase_report'),(6062,2,29,'expense_report'),(6063,2,29,'profit_report'),(6064,2,29,'stock_report'),(6065,2,29,'item_sales_report'),(6066,2,29,'purchase_payments_report'),(6067,2,29,'sales_payments_report'),(6068,2,29,'items_category_add'),(6069,2,29,'items_category_edit'),(6070,2,29,'items_category_delete'),(6071,2,29,'items_category_view'),(6072,2,29,'print_labels'),(6073,2,29,'expense_category_add'),(6074,2,29,'expense_category_edit'),(6075,2,29,'expense_category_delete'),(6076,2,29,'expense_category_view'),(6077,2,29,'dashboard_view'),(6078,2,29,'dashboard_info_box_1'),(6079,2,29,'dashboard_info_box_2'),(6080,2,29,'dashboard_pur_sal_chart'),(6081,2,29,'dashboard_recent_items'),(6082,2,29,'dashboard_stock_alert'),(6083,2,29,'dashboard_trending_items_chart'),(6084,2,29,'send_sms'),(6085,2,29,'sms_template_edit'),(6086,2,29,'sms_template_view'),(6087,2,29,'sms_api_view'),(6088,2,29,'sms_api_edit'),(6089,2,29,'purchase_return_add'),(6090,2,29,'purchase_return_edit'),(6091,2,29,'purchase_return_delete'),(6092,2,29,'purchase_return_view'),(6093,2,29,'purchase_return_report'),(6094,2,29,'sales_return_add'),(6095,2,29,'sales_return_edit'),(6096,2,29,'sales_return_delete'),(6097,2,29,'sales_return_view'),(6098,2,29,'sales_return_report'),(6099,2,29,'sales_return_payment_view'),(6100,2,29,'sales_return_payment_add'),(6101,2,29,'sales_return_payment_delete'),(6102,2,29,'purchase_return_payment_view'),(6103,2,29,'purchase_return_payment_add'),(6104,2,29,'purchase_return_payment_delete'),(6105,2,29,'purchase_payment_view'),(6106,2,29,'purchase_payment_add'),(6107,2,29,'purchase_payment_delete'),(6108,2,29,'payment_types_add'),(6109,2,29,'payment_types_edit'),(6110,2,29,'payment_types_delete'),(6111,2,29,'payment_types_view'),(6112,2,29,'import_customers'),(6113,2,29,'import_suppliers'),(6114,2,29,'stock_transfer_add'),(6115,2,29,'stock_transfer_edit'),(6116,2,29,'stock_transfer_delete'),(6117,2,29,'stock_transfer_view'),(6118,2,29,'warehouse_add'),(6119,2,29,'warehouse_edit'),(6120,2,29,'warehouse_delete'),(6121,2,29,'warehouse_view'),(6122,2,29,'supplier_items_report'),(6123,2,29,'seller_points_report'),(6124,2,29,'services_add'),(6125,2,29,'services_edit'),(6126,2,29,'services_delete'),(6127,2,29,'services_view'),(6128,2,29,'quotation_add'),(6129,2,29,'quotation_edit'),(6130,2,29,'quotation_delete'),(6131,2,29,'quotation_view'),(6132,2,29,'import_services'),(6133,2,29,'stock_adjustment_add'),(6134,2,29,'stock_adjustment_edit'),(6135,2,29,'stock_adjustment_delete'),(6136,2,29,'stock_adjustment_view'),(6137,2,29,'variant_add'),(6138,2,29,'variant_edit'),(6139,2,29,'variant_delete'),(6140,2,29,'variant_view'),(6141,2,29,'accounts_add'),(6142,2,29,'accounts_edit'),(6143,2,29,'accounts_delete'),(6144,2,29,'accounts_view'),(6145,2,29,'money_transfer_add'),(6146,2,29,'money_transfer_edit'),(6147,2,29,'money_transfer_delete'),(6148,2,29,'money_transfer_view'),(6149,2,29,'money_deposit_add'),(6150,2,29,'money_deposit_edit'),(6151,2,29,'money_deposit_delete'),(6152,2,29,'money_deposit_view'),(6153,2,29,'sales_tax_report'),(6154,2,29,'purchase_tax_report'),(6155,2,29,'cash_transactions'),(6156,2,29,'show_all_users_sales_invoices'),(6157,2,29,'show_all_users_sales_return_invoices'),(6158,2,29,'show_all_users_purchase_invoices'),(6159,2,29,'show_all_users_purchase_return_invoices'),(6160,2,29,'show_all_users_expenses'),(6161,2,29,'show_all_users_quotations'),(6162,2,29,'smtp_settings'),(6163,2,29,'send_email'),(6164,2,29,'sms_settings'),(6165,2,29,'email_template_edit'),(6166,2,29,'email_template_view'),(6167,2,29,'cust_adv_payments_add'),(6168,2,29,'cust_adv_payments_edit'),(6169,2,29,'cust_adv_payments_delete'),(6170,2,29,'cust_adv_payments_view'),(6179,1,2,'gstr_1_report'),(6180,1,2,'gstr_2_report'),(6181,1,2,'delivery_sheet_report'),(6182,1,2,'load_sheet_report'),(6183,1,2,'show_purchase_price'),(6184,1,2,'customer_orders_report'),(6185,1,2,'discountCouponAdd'),(6186,1,2,'discountCouponEdit'),(6187,1,2,'discountCouponDelete'),(6188,1,2,'discountCouponView'),(6189,2,2,'sales_gst_report'),(6190,2,2,'purchase_gst_report'),(6191,2,2,'subscription'),(6192,1,2,'customerCouponAdd'),(6193,1,2,'customerCouponEdit'),(6194,1,2,'customerCouponDelete'),(6195,1,2,'customerCouponView'),(6196,1,2,'return_items_report'),(6197,1,2,'help_link'),(6198,2,31,'sales_add'),(6199,2,31,'sales_edit'),(6200,2,31,'sales_delete'),(6201,2,31,'sales_view'),(6202,2,31,'sales_payment_view'),(6203,2,31,'sales_payment_add'),(6204,2,31,'sales_payment_delete'),(6205,2,31,'sales_return_add'),(6206,2,31,'sales_return_edit'),(6207,2,31,'sales_return_delete'),(6208,2,31,'sales_return_view'),(6209,2,31,'sales_return_payment_view'),(6210,2,31,'sales_return_payment_add'),(6211,2,31,'sales_return_payment_delete'),(6212,2,31,'show_all_users_sales_invoices'),(6213,2,31,'show_all_users_sales_return_invoices'),(6214,2,31,'show_purchase_price'),(6215,2,2,'recent_sales_invoice_list'),(6216,1,2,'stock_transfer_report'),(6217,1,2,'pos'),(6218,1,2,'sales_summary_report'),(6219,1,2,'sales_return_payments'),(6220,2,32,'store_edit'),(6221,2,32,'units_add'),(6222,2,32,'units_edit'),(6223,2,32,'units_delete'),(6224,2,32,'units_view'),(6225,2,32,'expense_add'),(6226,2,32,'expense_edit'),(6227,2,32,'expense_delete'),(6228,2,32,'expense_view'),(6229,2,32,'items_add'),(6230,2,32,'items_edit'),(6231,2,32,'items_delete'),(6232,2,32,'items_view'),(6233,2,32,'import_items'),(6234,2,32,'brand_add'),(6235,2,32,'brand_edit'),(6236,2,32,'brand_delete'),(6237,2,32,'brand_view'),(6238,2,32,'suppliers_add'),(6239,2,32,'suppliers_edit'),(6240,2,32,'suppliers_delete'),(6241,2,32,'suppliers_view'),(6242,2,32,'customers_add'),(6243,2,32,'customers_edit'),(6244,2,32,'customers_delete'),(6245,2,32,'customers_view'),(6246,2,32,'purchase_add'),(6247,2,32,'purchase_edit'),(6248,2,32,'purchase_delete'),(6249,2,32,'purchase_view'),(6250,2,32,'sales_add'),(6251,2,32,'sales_edit'),(6252,2,32,'sales_delete'),(6253,2,32,'sales_view'),(6254,2,32,'sales_payment_view'),(6255,2,32,'sales_payment_add'),(6256,2,32,'sales_payment_delete'),(6257,2,32,'sales_report'),(6258,2,32,'purchase_report'),(6259,2,32,'expense_report'),(6260,2,32,'profit_report'),(6261,2,32,'stock_report'),(6262,2,32,'item_sales_report'),(6263,2,32,'purchase_payments_report'),(6264,2,32,'sales_payments_report'),(6265,2,32,'items_category_add'),(6266,2,32,'items_category_edit'),(6267,2,32,'items_category_delete'),(6268,2,32,'items_category_view'),(6269,2,32,'print_labels'),(6270,2,32,'expense_category_add'),(6271,2,32,'expense_category_edit'),(6272,2,32,'expense_category_delete'),(6273,2,32,'expense_category_view'),(6274,2,32,'dashboard_view'),(6275,2,32,'dashboard_info_box_1'),(6276,2,32,'dashboard_info_box_2'),(6277,2,32,'dashboard_pur_sal_chart'),(6278,2,32,'dashboard_recent_items'),(6279,2,32,'dashboard_stock_alert'),(6280,2,32,'dashboard_trending_items_chart'),(6281,2,32,'send_sms'),(6282,2,32,'sms_template_edit'),(6283,2,32,'sms_template_view'),(6284,2,32,'sms_api_view'),(6285,2,32,'sms_api_edit'),(6286,2,32,'purchase_return_add'),(6287,2,32,'purchase_return_edit'),(6288,2,32,'purchase_return_delete'),(6289,2,32,'purchase_return_view'),(6290,2,32,'purchase_return_report'),(6291,2,32,'sales_return_report'),(6292,2,32,'purchase_return_payment_view'),(6293,2,32,'purchase_return_payment_add'),(6294,2,32,'purchase_return_payment_delete'),(6295,2,32,'purchase_payment_view'),(6296,2,32,'purchase_payment_add'),(6297,2,32,'purchase_payment_delete'),(6298,2,32,'import_customers'),(6299,2,32,'import_suppliers'),(6300,2,32,'stock_transfer_add'),(6301,2,32,'stock_transfer_edit'),(6302,2,32,'stock_transfer_delete'),(6303,2,32,'stock_transfer_view'),(6304,2,32,'supplier_items_report'),(6305,2,32,'seller_points_report'),(6306,2,32,'quotation_add'),(6307,2,32,'quotation_edit'),(6308,2,32,'quotation_delete'),(6309,2,32,'quotation_view'),(6310,2,32,'import_services'),(6311,2,32,'stock_adjustment_add'),(6312,2,32,'stock_adjustment_edit'),(6313,2,32,'stock_adjustment_delete'),(6314,2,32,'stock_adjustment_view'),(6315,2,32,'accounts_add'),(6316,2,32,'accounts_edit'),(6317,2,32,'accounts_delete'),(6318,2,32,'accounts_view'),(6319,2,32,'money_transfer_add'),(6320,2,32,'money_transfer_edit'),(6321,2,32,'money_transfer_delete'),(6322,2,32,'money_transfer_view'),(6323,2,32,'money_deposit_add'),(6324,2,32,'money_deposit_edit'),(6325,2,32,'money_deposit_delete'),(6326,2,32,'money_deposit_view'),(6327,2,32,'sales_tax_report'),(6328,2,32,'purchase_tax_report'),(6329,2,32,'cash_transactions'),(6330,2,32,'show_all_users_sales_invoices'),(6331,2,32,'show_all_users_purchase_invoices'),(6332,2,32,'show_all_users_purchase_return_invoices'),(6333,2,32,'show_all_users_expenses'),(6334,2,32,'show_all_users_quotations'),(6335,2,32,'sms_settings'),(6336,2,32,'cust_adv_payments_add'),(6337,2,32,'cust_adv_payments_edit'),(6338,2,32,'cust_adv_payments_delete'),(6339,2,32,'cust_adv_payments_view'),(6340,2,32,'gstr_1_report'),(6341,2,32,'gstr_2_report'),(6342,2,32,'customer_orders_report'),(6343,2,32,'load_sheet_report'),(6344,2,32,'delivery_sheet_report'),(6345,2,32,'show_purchase_price'),(6346,2,32,'discountCouponAdd'),(6347,2,32,'discountCouponEdit'),(6348,2,32,'discountCouponDelete'),(6349,2,32,'discountCouponView'),(6350,2,32,'sales_gst_report'),(6351,2,32,'purchase_gst_report'),(6352,2,32,'customerCouponAdd'),(6353,2,32,'customerCouponEdit'),(6354,2,32,'customerCouponDelete'),(6355,2,32,'customerCouponView'),(6356,2,32,'return_items_report'),(6357,2,32,'help_link'),(6358,2,32,'recent_sales_invoice_list'),(6359,2,32,'stock_transfer_report'),(6360,2,32,'pos'),(6361,2,32,'sales_summary_report'),(6362,2,32,'sales_return_payments'),(6363,1,1,'warranty_view'),(6364,1,1,'warranty_add'),(6365,1,1,'warranty_edit'),(6366,1,1,'warranty_delete'),(6367,1,1,'emi_view'),(6368,1,1,'emi_add'),(6369,1,1,'emi_payment'),(6370,1,1,'emi_delete'),(6371,1,2,'warranty_view'),(6372,1,2,'warranty_add'),(6373,1,2,'warranty_edit'),(6374,1,2,'warranty_delete'),(6375,1,2,'emi_view'),(6376,1,2,'emi_add'),(6377,1,2,'emi_payment'),(6378,1,2,'emi_delete'),(6379,2,32,'warranty_view'),(6380,2,32,'warranty_add'),(6381,2,32,'warranty_edit'),(6382,2,32,'warranty_delete'),(6383,2,32,'emi_view'),(6384,2,32,'emi_add'),(6385,2,32,'emi_payment'),(6386,2,32,'emi_delete'),(6387,1,1,'employee_add'),(6388,1,1,'employee_edit'),(6389,1,1,'employee_delete'),(6390,1,1,'employee_view'),(6391,1,1,'emi_edit'),(6392,1,2,'employee_add'),(6393,1,2,'employee_edit'),(6394,1,2,'employee_delete'),(6395,1,2,'employee_view'),(6396,1,2,'emi_edit'),(6397,2,1,'employee_add'),(6398,2,1,'employee_edit'),(6399,2,1,'employee_delete'),(6400,2,1,'employee_view'),(6401,2,1,'emi_add'),(6402,2,1,'emi_edit'),(6403,2,1,'emi_delete'),(6404,2,1,'emi_view'),(6405,2,1,'emi_payment'),(6406,2,1,'warranty_add'),(6407,2,1,'warranty_edit'),(6408,2,1,'warranty_delete'),(6409,2,1,'warranty_view'),(6410,2,2,'employee_add'),(6411,2,2,'employee_edit'),(6412,2,2,'employee_delete'),(6413,2,2,'employee_view'),(6414,2,2,'emi_add'),(6415,2,2,'emi_edit'),(6416,2,2,'emi_delete'),(6417,2,2,'emi_view'),(6418,2,2,'emi_payment'),(6419,2,2,'warranty_add'),(6420,2,2,'warranty_edit'),(6421,2,2,'warranty_delete'),(6422,2,2,'warranty_view'),(6423,3,1,'employee_add'),(6424,3,1,'employee_edit'),(6425,3,1,'employee_delete'),(6426,3,1,'employee_view'),(6427,3,1,'emi_add'),(6428,3,1,'emi_edit'),(6429,3,1,'emi_delete'),(6430,3,1,'emi_view'),(6431,3,1,'emi_payment'),(6432,3,1,'warranty_add'),(6433,3,1,'warranty_edit'),(6434,3,1,'warranty_delete'),(6435,3,1,'warranty_view'),(6436,3,2,'employee_add'),(6437,3,2,'employee_edit'),(6438,3,2,'employee_delete'),(6439,3,2,'employee_view'),(6440,3,2,'emi_add'),(6441,3,2,'emi_edit'),(6442,3,2,'emi_delete'),(6443,3,2,'emi_view'),(6444,3,2,'emi_payment'),(6445,3,2,'warranty_add'),(6446,3,2,'warranty_edit'),(6447,3,2,'warranty_delete'),(6448,3,2,'warranty_view');
/*!40000 ALTER TABLE `db_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_purchase`
--

DROP TABLE IF EXISTS `db_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Purchase Code',
  `purchase_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_status` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL COMMENT 'Purchased qty',
  `round_off` double(20,4) DEFAULT NULL COMMENT 'Pending Qty',
  `grand_total` double(20,4) DEFAULT NULL,
  `purchase_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'Purchase return raised',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `db_purchase_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchase_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_purchase`
--

LOCK TABLES `db_purchase` WRITE;
/*!40000 ALTER TABLE `db_purchase` DISABLE KEYS */;
INSERT INTO `db_purchase` VALUES (1,2,2,1,'PU0001','12147','2024-07-09','Received',2,NULL,150,NULL,NULL,'in_percentage',NULL,3000000000.0000,NULL,3000000000.0000,'','Partial',10000.0000,'2024-07-09','11:52:49 am','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(2,2,2,2,'PU0002','154','2024-07-09','Received',2,NULL,NULL,NULL,NULL,'in_percentage',NULL,300000000.0000,NULL,300000000.0000,'','Unpaid',0.0000,'2024-07-09','11:55:53 am','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(3,2,2,3,'PU0003','312222','2024-07-09','Received',3,NULL,150,NULL,NULL,'in_percentage',NULL,60000000.0000,NULL,60000000.0000,'','Partial',200.0000,'2024-07-09','12:17:27 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(4,2,2,4,'PU0004','456666','2024-07-09','Received',6,NULL,NULL,NULL,NULL,'in_percentage',NULL,18000000000.0000,NULL,18000000000.0000,'','Partial',100.0000,'2024-07-09','12:18:17 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(5,2,2,5,'PU0005','','2024-07-09','Received',4,NULL,NULL,NULL,NULL,'in_percentage',NULL,100000000000.0000,NULL,100000000000.0000,'','Paid',100000000000.0000,'2024-07-09','12:18:53 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(6,2,2,6,'PU0006','45555i','2024-07-09','Received',5,NULL,NULL,NULL,NULL,'in_percentage',NULL,1500000000000.0000,NULL,1500000000000.0000,'','Partial',91000.0000,'2024-07-09','12:19:44 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(7,2,2,7,'PU0007','76655','2024-07-09','Received',1,NULL,NULL,NULL,NULL,'in_percentage',NULL,955000000.0000,NULL,955000000.0000,'','Partial',500.0000,'2024-07-09','12:21:15 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(8,2,2,8,'PU0008','6543322','2024-07-09','Received',2,NULL,NULL,NULL,NULL,'in_percentage',NULL,40000000.0000,NULL,40000000.0000,'','Partial',500.0000,'2024-07-09','12:21:58 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(9,2,2,9,'PU0009','54332','2024-07-09','Received',2,NULL,NULL,NULL,NULL,'in_percentage',NULL,4000000000.0000,NULL,4000000000.0000,'','Partial',60500.0000,'2024-07-09','12:22:47 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,NULL),(10,2,2,10,'PU0010','1545422','2024-07-09','Received',2,NULL,NULL,NULL,NULL,'in_percentage',NULL,320000.0000,NULL,320000.0000,'','Paid',320000.0000,'2024-07-10','12:34:25 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,NULL),(11,2,2,11,'PU0011','Regular','2024-08-19','Received',2,50.0000,150,50.0000,NULL,'in_percentage',NULL,120080.0000,NULL,120130.0000,'','Partial',2000.0000,'2024-08-19','01:19:42 am','admin','103.59.179.21','103.59.179.21',NULL,1,NULL);
/*!40000 ALTER TABLE `db_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_purchaseitems`
--

DROP TABLE IF EXISTS `db_purchaseitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_purchaseitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `purchase_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `purchase_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `profit_margin_per` double(20,4) DEFAULT NULL,
  `unit_sales_price` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `purchase_id` (`purchase_id`),
  CONSTRAINT `db_purchaseitems_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `db_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_purchaseitems`
--

LOCK TABLES `db_purchaseitems` WRITE;
/*!40000 ALTER TABLE `db_purchaseitems` DISABLE KEYS */;
INSERT INTO `db_purchaseitems` VALUES (203,2,1,'Received',2,10000000.00,300.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,300.0000,3000000000.0000,NULL,NULL,1,''),(204,2,2,'Received',3,1000000.00,300.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,300.0000,300000000.0000,NULL,NULL,1,''),(205,2,3,'Received',3,100000.00,300.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,300.0000,30000000.0000,NULL,NULL,1,''),(206,2,3,'Received',2,100000.00,300.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,300.0000,30000000.0000,NULL,NULL,1,''),(207,2,4,'Received',4,100000000.00,180.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,180.0000,18000000000.0000,NULL,NULL,1,''),(208,2,5,'Received',5,10000000000.00,10.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,10.0000,100000000000.0000,NULL,NULL,1,''),(209,2,6,'Received',1,100000000.00,15000.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,15000.0000,1500000000000.0000,NULL,NULL,1,''),(210,2,7,'Received',7,100000000.00,8.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,8.0000,800000000.0000,NULL,NULL,1,''),(211,2,7,'Received',6,1000000.00,35.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,35.0000,35000000.0000,NULL,NULL,1,''),(212,2,7,'Received',8,10000000.00,12.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,12.0000,120000000.0000,NULL,NULL,1,''),(213,2,8,'Received',9,100000.00,400.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,400.0000,40000000.0000,NULL,NULL,1,''),(214,2,9,'Received',10,10000000.00,400.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,400.0000,4000000000.0000,NULL,NULL,1,''),(215,2,10,'Received',1,20.00,16000.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,16000.0000,320000.0000,NULL,NULL,1,''),(216,2,11,'Received',7,10.00,8.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,8.0000,80.0000,NULL,NULL,1,''),(217,2,11,'Received',1,8.00,15000.0000,'Inclusive',150,0.0000,'Percentage',0.0000,0.0000,15000.0000,120000.0000,NULL,NULL,1,'');
/*!40000 ALTER TABLE `db_purchaseitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_purchaseitemsreturn`
--

DROP TABLE IF EXISTS `db_purchaseitemsreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_purchaseitemsreturn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `return_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `profit_margin_per` double(20,4) DEFAULT NULL,
  `unit_sales_price` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `return_id` (`return_id`),
  KEY `purchase_id` (`purchase_id`),
  CONSTRAINT `db_purchaseitemsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchaseitemsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_purchasereturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_purchaseitemsreturn`
--

LOCK TABLES `db_purchaseitemsreturn` WRITE;
/*!40000 ALTER TABLE `db_purchaseitemsreturn` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_purchaseitemsreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_purchasepayments`
--

DROP TABLE IF EXISTS `db_purchasepayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_purchasepayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `db_purchasepayments_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchasepayments_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `db_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchasepayments_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_purchasepayments`
--

LOCK TABLES `db_purchasepayments` WRITE;
/*!40000 ALTER TABLE `db_purchasepayments` DISABLE KEYS */;
INSERT INTO `db_purchasepayments` VALUES (110,1,'PP0001',2,1,'2024-07-09','CASH',10000.0000,'','::1','DESKTOP-GMFRN98','11:52:49','2024-07-09','admin',1,2,2,NULL),(111,2,'PP0002',2,3,'2024-07-09','CASH',200.0000,'','::1','DESKTOP-GMFRN98','12:17:27','2024-07-09','admin',1,1,3,NULL),(112,3,'PP0003',2,4,'2024-07-09','Bkash',100.0000,'','::1','DESKTOP-GMFRN98','12:18:17','2024-07-09','admin',1,1,6,NULL),(113,4,'PP0004',2,5,'2024-07-09','CASH',100.0000,'','::1','DESKTOP-GMFRN98','12:18:53','2024-07-09','admin',1,2,4,NULL),(114,5,'PP0005',2,6,'2024-07-09','CASH',1000.0000,'','::1','DESKTOP-GMFRN98','12:19:44','2024-07-09','admin',1,2,5,NULL),(115,6,'PP0006',2,7,'2024-07-09','CASH',500.0000,'','::1','DESKTOP-GMFRN98','12:21:15','2024-07-09','admin',1,1,1,NULL),(116,7,'PP0007',2,8,'2024-07-09','Bkash',500.0000,'','::1','DESKTOP-GMFRN98','12:21:58','2024-07-09','admin',1,1,2,NULL),(117,8,'PP0008',2,9,'2024-07-09','CASH',100.0000,'','::1','DESKTOP-GMFRN98','12:22:47','2024-07-09','admin',1,2,2,NULL),(118,9,'PP0009',2,9,'2024-07-09','CASH',50000.0000,'','::1','DESKTOP-GMFRN98','12:36:34','2024-07-09','admin',1,NULL,2,NULL),(119,10,'PP0010',2,5,'2024-07-09','CASH',99999999900.0000,'','::1','DESKTOP-GMFRN98','12:36:45','2024-07-09','admin',1,NULL,4,NULL),(120,11,'PP0011',2,6,'2024-07-09','CASH',90000.0000,'','::1','DESKTOP-GMFRN98','12:37:44','2024-07-09','admin',1,1,5,NULL),(121,12,'PP0012',2,9,'2024-07-09','CASH',400.0000,'','::1','DESKTOP-GMFRN98','12:37:56','2024-07-09','admin',1,NULL,2,NULL),(122,13,'PP0013',2,9,'2024-07-09','CASH',10000.0000,'','::1','DESKTOP-GMFRN98','12:38:07','2024-07-09','admin',1,NULL,2,NULL),(123,14,'PP0014',2,10,'2024-07-09','CASH',10000.0000,'','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:34:25','2024-07-10','admin',1,2,2,NULL),(124,15,'PP0015',2,10,'2024-07-10','CASH',20000.0000,'','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:35:34','2024-07-10','admin',1,1,2,NULL),(125,16,'PP0016',2,10,'2024-07-10','CASH',290000.0000,'','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:35:53','2024-07-10','admin',1,1,2,NULL),(126,17,'PP0017',2,11,'2024-08-19','CASH',2000.0000,'','103.59.179.21','103.59.179.21','01:19:42','2024-08-19','admin',1,1,2,NULL);
/*!40000 ALTER TABLE `db_purchasepayments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_purchasepaymentsreturn`
--

DROP TABLE IF EXISTS `db_purchasepaymentsreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_purchasepaymentsreturn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `return_id` (`return_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `db_purchasepaymentsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchasepaymentsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_purchasereturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchasepaymentsreturn_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_purchasepaymentsreturn`
--

LOCK TABLES `db_purchasepaymentsreturn` WRITE;
/*!40000 ALTER TABLE `db_purchasepaymentsreturn` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_purchasepaymentsreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_purchasereturn`
--

DROP TABLE IF EXISTS `db_purchasereturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_purchasereturn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Purchase Return Code',
  `warehouse_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL COMMENT 'Purchased qty',
  `round_off` double(20,4) DEFAULT NULL COMMENT 'Pending Qty',
  `grand_total` double(20,4) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `purchase_id` (`purchase_id`),
  CONSTRAINT `db_purchasereturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_purchasereturn_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `db_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_purchasereturn`
--

LOCK TABLES `db_purchasereturn` WRITE;
/*!40000 ALTER TABLE `db_purchasereturn` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_purchasereturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_quotation`
--

DROP TABLE IF EXISTS `db_quotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create quotation Code',
  `quotation_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `quotation_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `quotation_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `round_off` double(20,4) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `quotation_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'quotation return raised',
  `customer_previous_due` double(20,4) DEFAULT NULL,
  `customer_total_due` double(20,4) DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `warehouse_id` (`warehouse_id`),
  CONSTRAINT `db_quotation_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_quotation_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_quotation_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_quotation`
--

LOCK TABLES `db_quotation` WRITE;
/*!40000 ALTER TABLE `db_quotation` DISABLE KEYS */;
INSERT INTO `db_quotation` VALUES (1,2,2,1,'QT0001','12554','2024-07-09','2024-07-09','Quotation',3,NULL,NULL,NULL,NULL,'in_percentage',NULL,22000.0000,NULL,22000.0000,'',NULL,NULL,'2024-07-09','12:38:49 pm','admin','::1','DESKTOP-GMFRN98',NULL,NULL,1,NULL,NULL,NULL,NULL),(2,2,2,2,'QT0002','','2024-07-10','2024-07-11','Quotation',4,NULL,NULL,NULL,NULL,'in_percentage',NULL,20000.0000,NULL,20000.0000,'',NULL,NULL,'2024-07-10','12:30:02 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,NULL,1,NULL,NULL,NULL,NULL),(3,2,2,3,'QT0003','','2024-08-19','2024-08-21','Quotation',3,50.0000,150,50.0000,1.0000,'in_percentage',228.2100,22771.0000,0.2100,22593.0000,'',NULL,NULL,'2024-08-19','01:17:05 am','admin','103.59.179.21','103.59.179.21',NULL,NULL,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `db_quotation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_quotationitems`
--

DROP TABLE IF EXISTS `db_quotationitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_quotationitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `quotation_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quotation_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `seller_points` double(20,4) DEFAULT 0.0000,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `quotation_id` (`quotation_id`),
  CONSTRAINT `db_quotationitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_quotationitems_ibfk_2` FOREIGN KEY (`quotation_id`) REFERENCES `db_quotation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=295 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_quotationitems`
--

LOCK TABLES `db_quotationitems` WRITE;
/*!40000 ALTER TABLE `db_quotationitems` DISABLE KEYS */;
INSERT INTO `db_quotationitems` VALUES (288,2,1,'Quotation',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,22000.0000,22000.0000,1,0.0000),(289,2,2,'Quotation',1,'',1.00,20000.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,20000.0000,20000.0000,1,0.0000),(290,2,3,'Quotation',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,22000.0000,22000.0000,1,0.0000),(291,2,3,'Quotation',5,'',3.00,12.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,12.0000,36.0000,1,0.0000),(292,2,3,'Quotation',19,'',2.00,100.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,100.0000,200.0000,1,4.0000),(293,2,3,'Quotation',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,520.0000,520.0000,1,0.0000),(294,2,3,'Quotation',8,'',1.00,15.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,15.0000,15.0000,1,0.0000);
/*!40000 ALTER TABLE `db_quotationitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_roles`
--

DROP TABLE IF EXISTS `db_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_roles_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_roles`
--

LOCK TABLES `db_roles` WRITE;
/*!40000 ALTER TABLE `db_roles` DISABLE KEYS */;
INSERT INTO `db_roles` VALUES (1,1,'Admin','All Rights Permitted.',1),(2,1,'Store Admin','Note: Apply this role for New Store Admin. ',1),(31,2,'Cashier','',1),(32,2,'Manager','listed &amp; Manage All products',1);
/*!40000 ALTER TABLE `db_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_sales`
--

DROP TABLE IF EXISTS `db_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `init_code` varchar(100) DEFAULT NULL,
  `count_id` decimal(20,0) DEFAULT NULL COMMENT 'Use to create Sales Code',
  `sales_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,2) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,2) DEFAULT NULL,
  `discount_to_all_input` double(20,2) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,2) DEFAULT NULL,
  `subtotal` double(20,2) DEFAULT NULL,
  `round_off` double(20,2) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `sales_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'sales return raised',
  `customer_previous_due` double(20,2) DEFAULT NULL,
  `customer_total_due` double(20,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_amt` double(20,2) DEFAULT 0.00,
  `invoice_terms` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `warehouse_id` (`warehouse_id`),
  KEY `coupon_id` (`coupon_id`),
  CONSTRAINT `db_sales_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_sales_ibfk_3` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_sales_ibfk_4` FOREIGN KEY (`coupon_id`) REFERENCES `db_customer_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_sales`
--

LOCK TABLES `db_sales` WRITE;
/*!40000 ALTER TABLE `db_sales` DISABLE KEYS */;
INSERT INTO `db_sales` VALUES (1,2,2,'SL',1,'SL1',NULL,'2024-07-09',NULL,'Final',7,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-09','02:24:11 am','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(2,2,2,'SL',2,'SL2',NULL,'2024-07-09',NULL,'Final',8,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-09','02:25:34 am','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(3,2,2,'SL',3,'SL3',NULL,'2024-07-09',NULL,'Final',9,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-09','02:26:53 am','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(4,2,2,'SL',4,'SL4',NULL,'2024-07-09',NULL,'Final',3,NULL,NULL,NULL,0.00,'in_percentage',0.00,2265250.00,0.00,2265250.0000,'','Paid',2265250.0000,'2024-07-09','12:27:43 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(5,2,2,'SL',5,'SL5',NULL,'2024-07-09',NULL,'Final',3,NULL,NULL,NULL,0.00,'in_percentage',0.00,23997000.00,0.00,23997000.0000,'','Paid',23997000.0000,'2024-07-09','12:30:45 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(6,2,2,'SL',6,'SL6',NULL,'2024-07-09',NULL,'Final',7,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-09','12:31:34 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(7,2,2,'SL',7,'SL7',NULL,'2024-07-09',NULL,'Final',8,NULL,NULL,NULL,0.00,'in_percentage',0.00,515.00,0.00,515.0000,'','Paid',515.0000,'2024-07-09','12:32:23 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(8,2,2,'SL',8,'SL8',NULL,'2024-07-09',NULL,'Final',9,NULL,NULL,NULL,0.00,'in_percentage',0.00,75.00,0.00,75.0000,'','Paid',75.0000,'2024-07-09','12:32:46 pm','admin','::1','DESKTOP-GMFRN98',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(9,2,2,'SL',9,'SL9',NULL,'2024-07-09',NULL,'Final',10,NULL,NULL,NULL,0.00,'in_percentage',0.00,220.00,0.00,220.0000,'','Partial',100.0000,'2024-07-09','01:56:41 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(10,2,2,'SL',10,'SL10',NULL,'2024-07-09',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-09','05:08:32 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(11,2,2,'SL',11,'SL11',NULL,'2024-07-10',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-10','12:02:23 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(12,2,2,'SL',12,'SL12',NULL,'2024-07-10',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22970.00,0.00,22970.0000,'','Paid',22970.0000,'2024-07-10','12:07:41 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(13,2,2,'SL',13,'SL13',NULL,'2024-07-10',NULL,'Final',12,NULL,NULL,NULL,0.00,'in_percentage',0.00,1260.00,0.00,1260.0000,'','Paid',1260.0000,'2024-07-10','12:20:25 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(14,2,2,'SL',14,'SL14',NULL,'2024-07-11',NULL,'Final',13,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-11','10:01:40 pm','admin','103.88.140.78','103.88.140.78',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(15,2,2,'SL',15,'SL15',NULL,'2024-07-12',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-07-12','01:45:16 pm','admin','103.85.156.81','103.85.156.81.race.net.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(16,2,2,'SL',16,'SL16',NULL,'2024-07-13',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22057.00,0.00,22057.0000,'','Partial',200.0000,'2024-07-13','12:36:01 am','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(17,2,2,'SL',17,'SL17','','2024-07-14',NULL,'Final',14,400.00,150,400.00,NULL,'in_percentage',NULL,22000.00,NULL,22400.0000,'','Paid',22400.0000,'2024-07-14','02:09:06 am','admin','182.48.82.20','182.48.82.20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(18,2,2,'SL',18,'SL18',NULL,'2024-07-16',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,5200.00,0.00,5200.0000,'','Paid',5200.0000,'2024-07-16','06:37:50 pm','admin','103.92.153.33','103.92.153.33',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(19,2,2,'SL',19,'SL19',NULL,'2024-08-01',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,1000.00,0.00,1000.0000,'','Partial',100.0000,'2024-08-01','01:08:04 pm','admin','115.164.210.7','UE7.210.digi.net.my',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(20,2,2,'SL',20,'SL20',NULL,'2024-08-02',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-08-02','04:15:14 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(21,2,2,'SL',21,'SL21',NULL,'2024-08-11',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,69.00,0.00,69.0000,'','Unpaid',0.0000,'2024-08-11','12:58:57 am','admin','103.59.179.21','103.59.179.21',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(22,2,2,'SL',22,'SL22',NULL,'2024-08-11',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,69.00,0.00,69.0000,'','Unpaid',0.0000,'2024-08-11','12:58:57 am','admin','103.59.179.21','103.59.179.21',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(23,2,2,'SL',23,'SL23',NULL,'2024-08-11',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,1574.00,0.00,1574.0000,'','Unpaid',0.0000,'2024-08-11','02:10:05 pm','admin','103.120.35.154','103.120.35.154',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(24,2,2,'SL',24,'SL24',NULL,'2024-08-11',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,24200.00,0.00,24200.0000,'','Paid',24200.0000,'2024-08-11','07:14:03 pm','admin','103.197.248.45','103.197.248-45.eurotelbd.net',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(25,2,2,'SL',25,'SL25',NULL,'2024-08-18',NULL,'Final',3,NULL,NULL,NULL,0.00,'in_percentage',0.00,8800.00,0.00,8800.0000,'','Paid',8800.0000,'2024-08-18','12:29:58 am','admin','118.179.89.119','118.179.89.119',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(26,2,2,'SL',26,'SL26',NULL,'2024-08-19',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,1500.00,0.00,1500.0000,'','Paid',1500.0000,'2024-08-19','12:33:18 am','admin','103.59.179.21','103.59.179.21',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(27,2,91,'SL',27,'SL27',NULL,'2024-08-19',NULL,'Final',13,NULL,NULL,NULL,0.00,'in_percentage',0.00,1000.00,0.00,1000.0000,'','Paid',1000.0000,'2024-08-19','01:38:07 am','admin','103.59.179.21','103.59.179.21',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(28,2,2,'SL',28,'SL28',NULL,'2024-08-21',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,23247.00,0.00,23247.0000,'','Paid',23247.0000,'2024-08-21','01:23:03 am','admin','103.140.212.171','103.140.212.171',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(29,2,2,'SL',29,'SL29',NULL,'2024-08-23',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22577.00,0.00,22577.0000,'','Paid',22577.0000,'2024-08-23','12:01:20 am','admin','103.114.94.37','103.114.94.37',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(30,2,2,'SL',30,'SL30',NULL,'2024-08-23',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,113577.00,0.00,113577.0000,'','Paid',113577.0000,'2024-08-23','12:02:15 am','admin','103.114.94.37','103.114.94.37',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(31,2,2,'SL',31,'SL31',NULL,'2024-08-31',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-08-31','03:12:21 pm','admin','37.111.237.161','37.111.237.161',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(32,2,88,'SL',32,'SL32',NULL,'2024-08-31',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,1000.00,0.00,1000.0000,'','Unpaid',0.0000,'2024-08-31','05:14:35 pm','admin','182.163.115.234','IP-115-234.bol-online.com',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(33,2,88,'SL',33,'SL33',NULL,'2024-08-31',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,1000.00,0.00,1000.0000,'','Paid',1000.0000,'2024-08-31','05:14:51 pm','admin','182.163.115.234','IP-115-234.bol-online.com',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(34,2,2,'SL',34,'SL34',NULL,'2024-08-31',NULL,'Final',20,NULL,NULL,NULL,0.00,'in_percentage',0.00,1000.00,0.00,1000.0000,'','Paid',1000.0000,'2024-08-31','05:23:51 pm','admin','182.163.115.234','IP-115-234.bol-online.com',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(35,2,2,'SL',35,'SL35',NULL,'2024-09-07',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,1215.00,0.00,1215.0000,'','Unpaid',0.0000,'2024-09-07','12:36:57 am','admin','103.43.94.69','103.43.94.69',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(36,2,2,'SL',36,'SL36',NULL,'2024-09-12',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22000.00,0.00,22000.0000,'','Paid',22000.0000,'2024-09-12','09:55:07 am','admin','43.245.143.54','43.245.143.54.summitiig.net',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(37,2,2,'SL',37,'SL37',NULL,'2024-09-12',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,565.00,0.00,565.0000,'','Unpaid',0.0000,'2024-09-12','04:52:13 pm','admin','163.47.86.163','peninsulactg-163.colbd.com',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(38,2,2,'SL',38,'SL38',NULL,'2024-09-13',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22520.00,0.00,22520.0000,'','Paid',22520.0000,'2024-09-13','08:23:43 pm','admin','45.118.60.6','45.118.60.6',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(39,2,2,'SL',39,'SL39',NULL,'2024-09-16',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,3170.00,0.00,3170.0000,'','Paid',3170.0000,'2024-09-16','06:26:34 am','admin','117.99.20.215','117.99.20.215',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(40,2,2,'SL',40,'SL40',NULL,'2024-09-19',NULL,'Final',2,NULL,NULL,NULL,0.00,'in_percentage',0.00,22520.00,0.00,22520.0000,'','Paid',22520.0000,'2024-09-19','11:30:32 pm','admin','103.84.133.206','103.84.133.206',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(41,2,2,'SL',41,'SL41',NULL,'2024-09-22',NULL,'Final',3,NULL,NULL,NULL,0.00,'in_percentage',0.00,520.00,0.00,520.0000,'','Unpaid',0.0000,'2024-09-22','04:32:46 pm','admin','118.179.89.119','118.179.89.119',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(42,2,2,'SL',42,'SL42','','2024-09-22',NULL,'Final',2,NULL,NULL,NULL,1.00,'in_percentage',440.30,44030.00,0.30,43590.0000,'','Paid',43590.0000,'2024-09-22','06:49:01 pm','admin','37.111.212.94','37.111.212.94',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0.00,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।'),(43,3,92,'SL/2026/03/',1,'SL/2026/03/1',NULL,'2026-09-30',NULL,'Final',22,NULL,NULL,NULL,0.00,'in_percentage',0.00,2000.00,0.00,2000.0000,'','Paid',2000.0000,'2026-09-30','05:07:29 pm','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,''),(44,3,92,'SL/2026/03/',2,'SL/2026/03/2',NULL,'2026-09-30',NULL,'Final',23,NULL,NULL,NULL,0.00,'in_percentage',0.00,2000.00,0.00,2000.0000,'','Paid',2000.0000,'2026-09-30','06:06:10 pm','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,''),(45,3,92,'SL/2026/03/',3,'SL/2026/03/3',NULL,'2026-09-30',NULL,'Final',22,NULL,NULL,NULL,0.00,'in_percentage',0.00,2000.00,0.00,2000.0000,'','Paid',2000.0000,'2026-09-30','06:38:16 pm','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,''),(46,3,92,'SL/2026/03/',4,'SL/2026/03/4',NULL,'2026-09-30',NULL,'Final',22,NULL,NULL,NULL,0.00,'in_percentage',0.00,2000.00,0.00,2000.0000,'','Paid',2000.0000,'2026-09-30','06:55:39 pm','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,''),(47,3,92,'SL/2026/03/',5,'SL/2026/03/5',NULL,'2026-10-01',NULL,'Final',22,NULL,NULL,NULL,0.00,'in_percentage',0.00,4000.00,0.00,4000.0000,'','Paid',4000.0000,'2026-10-01','09:23:06 am','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,''),(48,3,92,'SL/2026/03/',6,'SL/2026/03/6',NULL,'2026-10-01',NULL,'Final',22,NULL,NULL,NULL,0.00,'in_percentage',0.00,2000.00,0.00,2000.0000,'','Paid',2000.0000,'2026-10-01','09:23:15 am','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,''),(49,3,92,'SL/2026/03/',7,'SL/2026/03/7',NULL,'2026-10-01',NULL,'Final',22,NULL,NULL,NULL,0.00,'in_percentage',0.00,2000.00,0.00,2000.0000,'','Paid',2000.0000,'2026-10-01','10:26:02 am','shuvo2525','::1','DESKTOP-V3TH0KV',NULL,1,1,NULL,NULL,NULL,NULL,NULL,0.00,'');
/*!40000 ALTER TABLE `db_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_salesitems`
--

DROP TABLE IF EXISTS `db_salesitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_salesitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `sales_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sales_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `seller_points` double(20,2) DEFAULT 0.00,
  `purchase_price` double(20,3) DEFAULT 0.000,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `sales_id` (`sales_id`),
  CONSTRAINT `db_salesitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salesitems_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `db_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=743 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_salesitems`
--

LOCK TABLES `db_salesitems` WRITE;
/*!40000 ALTER TABLE `db_salesitems` DISABLE KEYS */;
INSERT INTO `db_salesitems` VALUES (622,2,1,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(623,2,2,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(624,2,3,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(625,2,4,'Final',4,'',200.00,220.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,220.0000,44000.0000,1,0.00,180.000),(626,2,4,'Final',1,'',100.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,2200000.0000,1,0.00,15000.000),(627,2,4,'Final',2,'',40.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,20800.0000,1,0.00,300.000),(628,2,4,'Final',3,'',1.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450.0000,1,0.00,300.000),(643,2,5,'Final',1,'',1000.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000000.0000,1,0.00,15000.000),(644,2,5,'Final',2,'',1000.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520000.0000,1,0.00,300.000),(645,2,5,'Final',3,'',1000.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450000.0000,1,0.00,300.000),(646,2,5,'Final',8,'',1000.00,15.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,15.0000,15000.0000,1,0.00,12.000),(647,2,5,'Final',7,'',1000.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12000.0000,1,0.00,8.000),(648,2,5,'Final',10,'',1000.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,500000.0000,1,0.00,400.000),(649,2,5,'Final',9,'',1000.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,500000.0000,1,0.00,400.000),(650,2,6,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(651,2,7,'Final',8,'',1.00,15.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,15.0000,15.0000,1,0.00,12.000),(652,2,7,'Final',9,'',1.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,500.0000,1,0.00,400.000),(653,2,8,'Final',8,'',5.00,15.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,15.0000,75.0000,1,0.00,12.000),(654,2,9,'Final',4,'',1.00,220.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,220.0000,220.0000,1,0.00,180.000),(655,2,10,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(656,2,11,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(657,2,12,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(658,2,12,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(659,2,12,'Final',3,'',1.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450.0000,1,0.00,300.000),(660,2,13,'Final',2,'',2.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,1040.0000,1,0.00,300.000),(661,2,13,'Final',4,'',1.00,220.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,220.0000,220.0000,1,0.00,180.000),(662,2,14,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(663,2,15,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(664,2,16,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(665,2,16,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(666,2,16,'Final',5,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,10.000),(669,2,17,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(676,2,18,'Final',2,'',10.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,5200.0000,1,0.00,300.000),(677,2,19,'Final',16,'',1.00,1000.0000,'Inclusive',150,NULL,'Fixed',0.0000,0.0000,1000.0000,1000.0000,1,0.00,1000.000),(678,2,20,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(679,2,21,'Final',11,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,10.000),(680,2,21,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(681,2,21,'Final',7,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,8.000),(682,2,22,'Final',11,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,10.000),(683,2,22,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(684,2,22,'Final',7,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,8.000),(685,2,23,'Final',6,'',5.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,225.0000,1,0.00,35.000),(686,2,23,'Final',5,'',12.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,144.0000,1,0.00,10.000),(687,2,23,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(688,2,23,'Final',3,'',1.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450.0000,1,0.00,300.000),(689,2,23,'Final',4,'',1.00,220.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,220.0000,220.0000,1,0.00,180.000),(690,2,23,'Final',8,'',1.00,15.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,15.0000,15.0000,1,0.00,12.000),(691,2,24,'Final',18,'',11.00,2200.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,2200.0000,24200.0000,1,0.00,2000.000),(692,2,25,'Final',18,'',4.00,2200.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,2200.0000,8800.0000,1,0.00,2000.000),(693,2,26,'Final',16,'',1.00,1000.0000,'Inclusive',150,NULL,'Fixed',0.0000,0.0000,1000.0000,1000.0000,1,0.00,1000.000),(694,2,26,'Final',10,'',1.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,500.0000,1,0.00,400.000),(698,2,27,'Final',16,'',1.00,1000.0000,'Inclusive',150,NULL,'Fixed',0.0000,0.0000,1000.0000,1000.0000,1,0.00,1000.000),(699,2,28,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(700,2,28,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(701,2,28,'Final',3,'',1.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450.0000,1,0.00,300.000),(702,2,28,'Final',4,'',1.00,220.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,220.0000,220.0000,1,0.00,180.000),(703,2,28,'Final',5,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,10.000),(704,2,28,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(705,2,29,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(706,2,29,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(707,2,29,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(708,2,29,'Final',5,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,10.000),(709,2,30,'Final',9,'',1.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,500.0000,1,0.00,400.000),(710,2,30,'Final',10,'',1.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,500.0000,1,0.00,400.000),(711,2,30,'Final',12,'',1.00,30.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,30.0000,30.0000,1,0.00,20.000),(712,2,30,'Final',16,'',1.00,1000.0000,'Inclusive',150,NULL,'Fixed',0.0000,0.0000,1000.0000,1000.0000,1,0.00,1000.000),(713,2,30,'Final',3,'',1.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450.0000,1,0.00,300.000),(714,2,30,'Final',2,'',2.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,1040.0000,1,0.00,300.000),(715,2,30,'Final',5,'',1.00,12.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,12.0000,12.0000,1,0.00,10.000),(716,2,30,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(717,2,30,'Final',1,'',5.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,110000.0000,1,0.00,15000.000),(718,2,31,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(719,2,32,'Final',16,'',1.00,1000.0000,'Inclusive',150,NULL,'Fixed',0.0000,0.0000,1000.0000,1000.0000,1,0.00,1000.000),(720,2,33,'Final',16,'',1.00,1000.0000,'Inclusive',150,NULL,'Fixed',0.0000,0.0000,1000.0000,1000.0000,1,0.00,1000.000),(721,2,34,'Final',9,'',2.00,500.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,500.0000,1000.0000,1,0.00,400.000),(722,2,35,'Final',3,'',3.00,450.0000,'Inclusive',150,NULL,'Percentage',10.0000,135.0000,450.0000,1215.0000,1,0.00,300.000),(723,2,36,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(724,2,37,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(725,2,37,'Final',6,'',1.00,45.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,45.0000,45.0000,1,0.00,35.000),(726,2,38,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(727,2,38,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(728,2,39,'Final',3,'',1.00,450.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,450.0000,450.0000,1,0.00,300.000),(729,2,39,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(730,2,39,'Final',18,'',1.00,2200.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,2200.0000,2200.0000,1,0.00,2000.000),(731,2,40,'Final',1,'',1.00,22000.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,22000.0000,22000.0000,1,0.00,15000.000),(732,2,40,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(733,2,41,'Final',2,'',1.00,520.0000,'Inclusive',150,NULL,'Percentage',0.0000,0.0000,520.0000,520.0000,1,0.00,300.000),(734,2,42,'Final',1,'',2.00,22000.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,22000.0000,44000.0000,1,0.00,15000.000),(735,2,42,'Final',12,'',1.00,30.0000,'Inclusive',150,NULL,'Percentage',NULL,0.0000,30.0000,30.0000,1,0.00,20.000),(736,3,43,'Final',20,'',1.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,2000.0000,1,0.00,1000.000),(737,3,44,'Final',20,'',1.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,2000.0000,1,0.00,1000.000),(738,3,45,'Final',20,'',1.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,2000.0000,1,0.00,1000.000),(739,3,46,'Final',20,'',1.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,2000.0000,1,0.00,1000.000),(740,3,47,'Final',20,'',2.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,4000.0000,1,0.00,1000.000),(741,3,48,'Final',20,'',1.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,2000.0000,1,0.00,1000.000),(742,3,49,'Final',20,'',1.00,2000.0000,'Inclusive',NULL,NULL,'Percentage',0.0000,0.0000,2000.0000,2000.0000,1,0.00,1000.000);
/*!40000 ALTER TABLE `db_salesitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_salesitemsreturn`
--

DROP TABLE IF EXISTS `db_salesitemsreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_salesitemsreturn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `return_qty` double(20,2) DEFAULT NULL,
  `price_per_unit` double(20,4) DEFAULT NULL,
  `tax_type` varchar(50) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_amt` double(20,4) DEFAULT NULL,
  `discount_input` double(20,4) DEFAULT NULL,
  `discount_amt` double(20,4) DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `unit_total_cost` double(20,4) DEFAULT NULL,
  `total_cost` double(20,4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `purchase_price` double(20,3) DEFAULT 0.000,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `return_id` (`return_id`),
  CONSTRAINT `db_salesitemsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salesitemsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_salesreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_salesitemsreturn`
--

LOCK TABLES `db_salesitemsreturn` WRITE;
/*!40000 ALTER TABLE `db_salesitemsreturn` DISABLE KEYS */;
INSERT INTO `db_salesitemsreturn` VALUES (86,2,NULL,1,'Return',1,1.00,22000.0000,'Inclusive',150,NULL,NULL,0.0000,'Percentage',22000.0000,22000.0000,1,'',15000.000);
/*!40000 ALTER TABLE `db_salesitemsreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_salespayments`
--

DROP TABLE IF EXISTS `db_salespayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_salespayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `change_return` double(20,4) DEFAULT NULL COMMENT 'Refunding the greater amount',
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  `advance_adjusted` double(20,4) DEFAULT NULL,
  `cheque_number` varchar(100) DEFAULT NULL,
  `cheque_period` int(11) DEFAULT NULL,
  `cheque_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `sales_id` (`sales_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `db_salespayments_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salespayments_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `db_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salespayments_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=414 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_salespayments`
--

LOCK TABLES `db_salespayments` WRITE;
/*!40000 ALTER TABLE `db_salespayments` DISABLE KEYS */;
INSERT INTO `db_salespayments` VALUES (351,1,'SP0001',2,1,'2024-07-09','CASH',500.0000,'',0.0000,'::1','DESKTOP-GMFRN98','02:24:11 am','2024-07-09','admin',1,1,7,NULL,0.0000,NULL,NULL,NULL),(352,2,'SP0002',2,2,'2024-07-09','CASH',800.0000,'',0.0000,'::1','DESKTOP-GMFRN98','02:25:34 am','2024-07-09','admin',1,1,8,NULL,0.0000,NULL,NULL,NULL),(353,3,'SP0003',2,3,'2024-07-09','CASH',300.0000,'',0.0000,'::1','DESKTOP-GMFRN98','02:26:53 am','2024-07-09','admin',1,1,9,NULL,0.0000,NULL,NULL,NULL),(354,4,'SP0004',2,4,'2024-07-09','CASH',2265250.0000,'',0.0000,'::1','DESKTOP-GMFRN98','12:27:43 pm','2024-07-09','admin',1,1,3,NULL,0.0000,NULL,NULL,NULL),(357,5,'SP0005',2,5,'2024-07-09','CASH',23997000.0000,'',0.0000,'::1','DESKTOP-GMFRN98','12:30:45 pm','2024-07-09','admin',1,1,3,NULL,0.0000,NULL,NULL,NULL),(358,6,'SP0006',2,6,'2024-07-09','CASH',200.0000,'',0.0000,'::1','DESKTOP-GMFRN98','12:31:34 pm','2024-07-09','admin',1,1,7,NULL,0.0000,NULL,NULL,NULL),(359,7,'SP0007',2,7,'2024-07-09','CASH',300.0000,'',0.0000,'::1','DESKTOP-GMFRN98','12:32:23 pm','2024-07-09','admin',1,1,8,NULL,0.0000,NULL,NULL,NULL),(360,8,'SP0008',2,8,'2024-07-09','CASH',75.0000,'',0.0000,'::1','DESKTOP-GMFRN98','12:32:46 pm','2024-07-09','admin',1,1,9,NULL,0.0000,NULL,NULL,NULL),(361,9,'SP0009',2,7,'2024-07-09','CASH',215.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:33:29 pm','2024-07-09','admin',1,1,8,NULL,0.0000,'',0,'Pending'),(362,10,'SP0010',2,6,'2024-07-09','CASH',500.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:33:39 pm','2024-07-09','admin',1,1,7,NULL,0.0000,'',0,'Pending'),(363,11,'SP0011',2,3,'2024-07-09','CASH',21700.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:33:54 pm','2024-07-09','admin',1,1,9,NULL,0.0000,'',0,'Pending'),(364,12,'SP0012',2,1,'2024-07-09','CASH',999.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:34:15 pm','2024-07-09','admin',1,1,7,NULL,0.0000,'',0,'Pending'),(365,13,'SP0013',2,1,'2024-07-09','CASH',100.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:34:23 pm','2024-07-09','admin',1,1,7,NULL,0.0000,'',0,'Pending'),(366,14,'SP0014',2,6,'2024-07-09','CASH',3000.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:34:43 pm','2024-07-09','admin',1,1,7,NULL,0.0000,'',0,'Pending'),(367,15,'SP0015',2,9,'2024-07-09','CASH',100.0000,'',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','01:56:41 pm','2024-07-09','admin',1,1,10,NULL,0.0000,NULL,NULL,NULL),(368,16,'SP0016',2,10,'2024-07-09','CASH',22000.0000,'',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','05:08:32 pm','2024-07-09','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(369,17,'SP0017',2,11,'2024-07-10','Bkash',22000.0000,'018708293434',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:02:23 pm','2024-07-10','admin',1,4,2,NULL,0.0000,NULL,NULL,NULL),(370,18,'SP0018',2,12,'2024-07-10','CASH',22970.0000,'',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:07:41 pm','2024-07-10','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(371,19,'SP0019',2,13,'2024-07-10','Bkash',200.0000,'01870829343 ei number theke se pay koreche',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:20:25 pm','2024-07-10','admin',1,4,12,NULL,0.0000,NULL,NULL,NULL),(372,20,'SP0020',2,13,'2024-07-10','CASH',800.0000,'',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:20:25 pm','2024-07-10','admin',1,1,12,NULL,0.0000,NULL,NULL,NULL),(373,21,'SP0021',2,13,'2024-07-10','CASH',260.0000,'',NULL,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:24:08 pm','2024-07-10','admin',1,1,12,NULL,0.0000,'',0,'Pending'),(374,22,'SP0022',2,14,'2024-07-11','CASH',20000.0000,'',0.0000,'103.88.140.78','103.88.140.78','10:01:40 pm','2024-07-11','admin',1,1,13,NULL,0.0000,NULL,NULL,NULL),(375,23,'SP0023',2,15,'2024-07-12','Cash',22000.0000,'Paid By Cash',0.0000,'103.85.156.81','103.85.156.81.race.net.bd','01:45:16 pm','2024-07-12','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(376,24,'SP0024',2,16,'2024-07-13','CASH',200.0000,'',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','12:36:01 am','2024-07-13','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(377,25,'SP0025',2,17,'2024-07-14','CASH',22400.0000,'',NULL,'182.48.82.20','182.48.82.20','02:09:06 am','2024-07-14','admin',1,1,14,NULL,0.0000,'',0,'Pending'),(378,26,'SP0026',2,NULL,'2024-07-14','CASH',5.0000,'',NULL,'103.161.66.23','103.161.66.23','11:58:30 am','2024-07-14','admin',1,1,14,'OPENING BALANCE PAID',NULL,NULL,NULL,NULL),(381,27,'SP0027',2,18,'2024-07-16','CASH',5200.0000,'',0.0000,'103.92.153.33','103.92.153.33','06:37:50 pm','2024-07-16','admin',1,2,2,NULL,0.0000,NULL,NULL,NULL),(382,28,'SP0028',2,19,'2024-08-01','CASH',100.0000,'',0.0000,'115.164.210.7','UE7.210.digi.net.my','01:08:04 pm','2024-08-01','admin',1,2,2,NULL,0.0000,NULL,NULL,NULL),(383,29,'SP0029',2,20,'2024-08-02','CASH',22000.0000,'',0.0000,'103.131.145.159','client-103.131.145.159.plexuscloud.com.bd','04:15:14 pm','2024-08-02','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(384,30,'SP0030',2,24,'2024-08-11','Cash',24200.0000,'Paid By Cash',0.0000,'103.197.248.45','103.197.248-45.eurotelbd.net','07:14:03 pm','2024-08-11','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(385,31,'SP0031',2,25,'2024-08-18','CASH',8800.0000,'',0.0000,'118.179.89.119','118.179.89.119','12:29:58 am','2024-08-18','admin',1,1,3,NULL,0.0000,NULL,NULL,NULL),(386,32,'SP0032',2,26,'2024-08-19','Bkash',1000.0000,'',0.0000,'103.59.179.21','103.59.179.21','12:33:18 am','2024-08-19','admin',1,7,2,NULL,0.0000,NULL,NULL,NULL),(387,33,'SP0033',2,26,'2024-08-19','CASH',200.0000,'',0.0000,'103.59.179.21','103.59.179.21','12:33:18 am','2024-08-19','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(388,34,'SP0034',2,26,'2024-08-19','Rocket',300.0000,'',0.0000,'103.59.179.21','103.59.179.21','12:33:18 am','2024-08-19','admin',1,2,2,NULL,0.0000,NULL,NULL,NULL),(389,35,'SP0035',2,2,'2024-08-19','CASH',21200.0000,'',NULL,'103.59.179.21','103.59.179.21','12:56:18 am','2024-08-19','admin',1,1,8,NULL,NULL,NULL,NULL,NULL),(390,36,'SP0036',2,1,'2024-08-19','CASH',20401.0000,'',NULL,'103.59.179.21','103.59.179.21','12:56:34 am','2024-08-19','admin',1,1,7,NULL,NULL,NULL,NULL,NULL),(391,36,'SP0036',2,6,'2024-08-19','CASH',18300.0000,'',NULL,'103.59.179.21','103.59.179.21','12:56:34 am','2024-08-19','admin',1,1,7,NULL,NULL,NULL,NULL,NULL),(392,37,'SP0037',2,14,'2024-08-13','CASH',2000.0000,'',NULL,'103.59.179.21','103.59.179.21','12:57:48 am','2024-08-19','admin',1,1,13,NULL,NULL,NULL,NULL,NULL),(394,38,'SP0038',2,27,'2024-08-19','CASH',500.0000,'',0.0000,'103.59.179.21','103.59.179.21','01:38:07 am','2024-08-19','admin',1,1,13,NULL,0.0000,NULL,NULL,NULL),(395,39,'SP0039',2,27,'2024-08-19','Rocket',500.0000,'',0.0000,'103.59.179.21','103.59.179.21','01:38:07 am','2024-08-19','admin',1,6,13,NULL,0.0000,NULL,NULL,NULL),(396,40,'SP0040',2,28,'2024-08-21','Cash',23247.0000,'Paid By Cash',0.0000,'103.140.212.171','103.140.212.171','01:23:03 am','2024-08-21','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(397,41,'SP0041',2,29,'2024-08-23','Cash',22577.0000,'Paid By Cash',0.0000,'103.114.94.37','103.114.94.37','12:01:20 am','2024-08-23','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(398,42,'SP0042',2,30,'2024-08-23','Cash',113577.0000,'Paid By Cash',0.0000,'103.114.94.37','103.114.94.37','12:02:15 am','2024-08-23','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(399,43,'SP0043',2,31,'2024-08-31','CASH',22000.0000,'Ss',0.0000,'37.111.237.161','37.111.237.161','03:12:21 pm','2024-08-31','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(400,44,'SP0044',2,33,'2024-08-31','Cash',1000.0000,'Paid By Cash',0.0000,'182.163.115.234','IP-115-234.bol-online.com','05:14:51 pm','2024-08-31','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(401,45,'SP0045',2,34,'2024-08-31','Cash',1000.0000,'Paid By Cash',0.0000,'182.163.115.234','IP-115-234.bol-online.com','05:23:51 pm','2024-08-31','admin',1,NULL,20,NULL,0.0000,NULL,NULL,NULL),(402,46,'SP0046',2,36,'2024-09-12','Cash',22000.0000,'Paid By Cash',0.0000,'43.245.143.54','43.245.143.54.summitiig.net','09:55:07 am','2024-09-12','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(403,47,'SP0047',2,38,'2024-09-13','Cash',22520.0000,'Paid By Cash',0.0000,'45.118.60.6','45.118.60.6','08:23:43 pm','2024-09-13','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(404,48,'SP0048',2,39,'2024-09-16','Cash',3170.0000,'Paid By Cash',0.0000,'117.99.20.215','117.99.20.215','06:26:34 am','2024-09-16','admin',1,NULL,2,NULL,0.0000,NULL,NULL,NULL),(405,49,'SP0049',2,40,'2024-09-19','CASH',22520.0000,'',480.0000,'103.84.133.206','103.84.133.206','11:30:32 pm','2024-09-19','admin',1,1,2,NULL,0.0000,NULL,NULL,NULL),(406,50,'SP0050',2,42,'2024-09-22','CASH',43590.0000,'',NULL,'37.111.212.94','37.111.212.94','06:49:01 pm','2024-09-22','admin',1,1,2,NULL,0.0000,'',0,'Pending'),(407,1,'SP/2026/03/0001',3,43,'2026-09-30','Cash',2000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','05:07:29 pm','2026-09-30','shuvo2525',1,NULL,22,NULL,0.0000,NULL,NULL,NULL),(408,2,'SP/2026/03/0002',3,44,'2026-09-30','Cash',2000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','06:06:10 pm','2026-09-30','shuvo2525',1,NULL,23,NULL,0.0000,NULL,NULL,NULL),(409,3,'SP/2026/03/0003',3,45,'2026-09-30','Cash',2000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','06:38:16 pm','2026-09-30','shuvo2525',1,NULL,22,NULL,0.0000,NULL,NULL,NULL),(410,4,'SP/2026/03/0004',3,46,'2026-09-30','Cash',2000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','06:55:39 pm','2026-09-30','shuvo2525',1,NULL,22,NULL,0.0000,NULL,NULL,NULL),(411,5,'SP/2026/03/0005',3,47,'2026-10-01','Cash',4000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','09:23:06 am','2026-10-01','shuvo2525',1,NULL,22,NULL,0.0000,NULL,NULL,NULL),(412,6,'SP/2026/03/0006',3,48,'2026-10-01','Cash',2000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','09:23:15 am','2026-10-01','shuvo2525',1,NULL,22,NULL,0.0000,NULL,NULL,NULL),(413,7,'SP/2026/03/0007',3,49,'2026-10-01','Cash',2000.0000,'Paid By Cash',0.0000,'::1','DESKTOP-V3TH0KV','10:26:02 am','2026-10-01','shuvo2525',1,NULL,22,NULL,0.0000,NULL,NULL,NULL);
/*!40000 ALTER TABLE `db_salespayments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_salespaymentsreturn`
--

DROP TABLE IF EXISTS `db_salespaymentsreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_salespaymentsreturn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count_id` int(11) DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `change_return` double(20,4) DEFAULT NULL COMMENT 'Refunding the greater amount',
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `return_id` (`return_id`),
  KEY `db_salespaymentsreturn_ibfk_3` (`customer_id`),
  CONSTRAINT `db_salespaymentsreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salespaymentsreturn_ibfk_2` FOREIGN KEY (`return_id`) REFERENCES `db_salesreturn` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salespaymentsreturn_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_salespaymentsreturn`
--

LOCK TABLES `db_salespaymentsreturn` WRITE;
/*!40000 ALTER TABLE `db_salespaymentsreturn` DISABLE KEYS */;
INSERT INTO `db_salespaymentsreturn` VALUES (46,1,'SRP0001',2,NULL,1,'2024-07-09','CASH',22000.0000,'',NULL,'::1','DESKTOP-GMFRN98','12:35:58','2024-07-09','admin',1,1,3,NULL);
/*!40000 ALTER TABLE `db_salespaymentsreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_salesreturn`
--

DROP TABLE IF EXISTS `db_salesreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_salesreturn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create Sales Return Code',
  `sales_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `return_code` varchar(50) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `other_charges_input` double(20,4) DEFAULT NULL,
  `other_charges_tax_id` int(11) DEFAULT NULL,
  `other_charges_amt` double(20,4) DEFAULT NULL,
  `discount_to_all_input` double(20,4) DEFAULT NULL,
  `discount_to_all_type` varchar(50) DEFAULT NULL,
  `tot_discount_to_all_amt` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `round_off` double(20,4) DEFAULT NULL,
  `grand_total` double(20,4) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL COMMENT '1=yes 0=no',
  `status` int(11) DEFAULT NULL,
  `return_bit` int(11) DEFAULT NULL COMMENT 'Return raised or not 1 or null',
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_amt` double(20,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `sales_id` (`sales_id`),
  KEY `coupon_id` (`coupon_id`),
  CONSTRAINT `db_salesreturn_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salesreturn_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `db_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_salesreturn_ibfk_3` FOREIGN KEY (`coupon_id`) REFERENCES `db_customer_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_salesreturn`
--

LOCK TABLES `db_salesreturn` WRITE;
/*!40000 ALTER TABLE `db_salesreturn` DISABLE KEYS */;
INSERT INTO `db_salesreturn` VALUES (1,2,1,NULL,2,'SR0001','1250','2024-07-09','Return',3,NULL,150,NULL,NULL,'in_percentage',NULL,22000.0000,NULL,22000.0000,'','Paid',22000.0000,'2024-07-09','12:35:58 pm','admin','::1','DESKTOP-GMFRN98',NULL,NULL,1,NULL,NULL,0.00);
/*!40000 ALTER TABLE `db_salesreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_shippingaddress`
--

DROP TABLE IF EXISTS `db_shippingaddress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_shippingaddress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `postcode` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `location_link` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  KEY `customer_id` (`customer_id`),
  KEY `store_id` (`store_id`),
  KEY `id` (`id`),
  CONSTRAINT `db_shippingaddress_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_shippingaddress_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_shippingaddress`
--

LOCK TABLES `db_shippingaddress` WRITE;
/*!40000 ALTER TABLE `db_shippingaddress` DISABLE KEYS */;
INSERT INTO `db_shippingaddress` VALUES (1,1,1,NULL,NULL,'','',1,1,NULL),(2,2,NULL,NULL,NULL,NULL,NULL,1,2,NULL),(4,2,0,0,'','','',1,3,''),(5,2,0,0,'','','',1,18,''),(6,2,210,66,'Dhaka','1202','sutrapur\r\njatrabary',1,19,''),(7,2,210,67,'Dahak','1200','sutrapur\r\njatrabary',1,13,''),(8,2,0,0,'','','',1,20,''),(9,2,210,67,'Jashore ','7400','Hospital get',1,21,''),(10,3,210,66,'Tangail','1940','Dewhata Mirzapur.',1,23,'');
/*!40000 ALTER TABLE `db_shippingaddress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_sitesettings`
--

DROP TABLE IF EXISTS `db_sitesettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sitesettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(10) DEFAULT NULL,
  `site_name` varchar(100) DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL COMMENT 'path',
  `machine_id` text DEFAULT NULL,
  `domain` text DEFAULT NULL,
  `unique_code` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_sitesettings`
--

LOCK TABLES `db_sitesettings` WRITE;
/*!40000 ALTER TABLE `db_sitesettings` DISABLE KEYS */;
INSERT INTO `db_sitesettings` VALUES (1,'3.1','Shop Keeper','/uploads/site/logo.png','1','pointofsale.ozonepos.com','4kcd2s8v9axrpm6gy1foh7tlqij5nw');
/*!40000 ALTER TABLE `db_sitesettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_smsapi`
--

DROP TABLE IF EXISTS `db_smsapi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_smsapi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `info` varchar(150) DEFAULT NULL,
  `key` varchar(600) DEFAULT NULL,
  `key_value` varchar(600) DEFAULT NULL,
  `delete_bit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_smsapi_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_smsapi`
--

LOCK TABLES `db_smsapi` WRITE;
/*!40000 ALTER TABLE `db_smsapi` DISABLE KEYS */;
INSERT INTO `db_smsapi` VALUES (29,1,'url','weblink','https://www.example.com/api/mt/SendSMS?',NULL),(30,1,'mobile','mobiles','',NULL),(31,1,'message','message','',NULL),(32,2,'url','weblink','http://bulksmsbd.net/api/smsapi',NULL),(33,2,'mobile','+088','',NULL),(34,2,'message','message','',NULL),(35,2,'','api_key','your_api_key',NULL),(36,2,'','senderid','your_sender_id',NULL),(37,3,'url','weblink','http://example.com/sendmessage',NULL),(38,3,'mobile','mobiles','',NULL),(39,3,'message','message','',NULL);
/*!40000 ALTER TABLE `db_smsapi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_smstemplates`
--

DROP TABLE IF EXISTS `db_smstemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_smstemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `variables` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `undelete_bit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_smstemplates_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_smstemplates`
--

LOCK TABLES `db_smstemplates` WRITE;
/*!40000 ALTER TABLE `db_smstemplates` DISABLE KEYS */;
INSERT INTO `db_smstemplates` VALUES (1,1,'GREETING TO CUSTOMER ON SALES','Hi {{customer_name}},\r\nYour sales Id is {{sales_id}},\r\nSales Date {{sales_date}},\r\nTotal amount  {{sales_amount}},\r\nYou have paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}<br>                          \r\n{{sales_id}}<br>\r\n{{sales_date}}<br>\r\n{{sales_amount}}<br>\r\n{{paid_amt}}<br>\r\n{{due_amt}}<br>\r\n{{store_name}}<br>\r\n{{store_mobile}}<br>\r\n{{store_address}}<br>\r\n{{store_website}}<br>\r\n{{store_email}}<br>\r\n',1,1),(2,1,'GREETING TO CUSTOMER ON SALES RETURN','Hi {{customer_name}},\r\nYour sales return Id is {{return_id}},\r\nReturn Date {{return_date}},\r\nTotal amount  {{return_amount}},\r\nWe paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}<br>                          \r\n{{return_id}}<br>\r\n{{return_date}}<br>\r\n{{return_amount}}<br>\r\n{{paid_amt}}<br>\r\n{{due_amt}}<br>\r\n{{company_name}}<br>\r\n{{company_mobile}}<br>\r\n{{company_address}}<br>\r\n{{company_website}}<br>\r\n{{company_email}}<br>',1,1),(12,2,'GREETING TO CUSTOMER ON SALES','Hi {{customer_name}},\r\nYour sales Id is {{sales_id}},\r\nSales Date {{sales_date}},\r\nTotal amount  {{sales_amount}},\r\nYou have paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}                          \r\n{{sales_id}}\r\n{{sales_date}}\r\n{{sales_amount}}\r\n{{paid_amt}}\r\n{{due_amt}}\r\n{{store_name}}\r\n{{store_mobile}}\r\n{{store_address}}\r\n{{store_website}}\r\n{{store_email}}\r\n',1,1),(13,2,'GREETING TO CUSTOMER ON SALES RETURN','Hi {{customer_name}},\r\nYour sales return Id is {{return_id}},\r\nReturn Date {{return_date}},\r\nTotal amount  {{return_amount}},\r\nWe paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}                          \r\n{{return_id}}\r\n{{return_date}}\r\n{{return_amount}}\r\n{{paid_amt}}\r\n{{due_amt}}\r\n{{company_name}}\r\n{{company_mobile}}\r\n{{company_address}}\r\n{{company_website}}\r\n{{company_email}}\r\n',1,1),(28,3,'GREETING TO CUSTOMER ON SALES','Hi {{customer_name}},\r\nYour sales Id is {{sales_id}},\r\nSales Date {{sales_date}},\r\nTotal amount  {{sales_amount}},\r\nYou have paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}                          \r\n{{sales_id}}\r\n{{sales_date}}\r\n{{sales_amount}}\r\n{{paid_amt}}\r\n{{due_amt}}\r\n{{store_name}}\r\n{{store_mobile}}\r\n{{store_address}}\r\n{{store_website}}\r\n{{store_email}}\r\n',1,1),(29,3,'GREETING TO CUSTOMER ON SALES RETURN','Hi {{customer_name}},\r\nYour sales return Id is {{return_id}},\r\nReturn Date {{return_date}},\r\nTotal amount  {{return_amount}},\r\nWe paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}                          \r\n{{return_id}}\r\n{{return_date}}\r\n{{return_amount}}\r\n{{paid_amt}}\r\n{{due_amt}}\r\n{{company_name}}\r\n{{company_mobile}}\r\n{{company_address}}\r\n{{company_website}}\r\n{{company_email}}\r\n',1,1);
/*!40000 ALTER TABLE `db_smstemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_sobpayments`
--

DROP TABLE IF EXISTS `db_sobpayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sobpayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` mediumtext DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_sobpayments`
--

LOCK TABLES `db_sobpayments` WRITE;
/*!40000 ALTER TABLE `db_sobpayments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_sobpayments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_states`
--

DROP TABLE IF EXISTS `db_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `state_code` varchar(10) DEFAULT NULL,
  `state` varchar(4050) DEFAULT NULL,
  `country_code` varchar(15) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `country` varchar(15) DEFAULT NULL,
  `added_on` date DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_states_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_states`
--

LOCK TABLES `db_states` WRITE;
/*!40000 ALTER TABLE `db_states` DISABLE KEYS */;
INSERT INTO `db_states` VALUES (64,2,NULL,'Barisal Division',NULL,NULL,'Bangladesh',NULL,NULL,1),(65,2,NULL,'Chittagong Division',NULL,NULL,'Bangladesh',NULL,NULL,1),(66,2,NULL,'Dhaka Division',NULL,NULL,'Bangladesh',NULL,NULL,1),(67,2,NULL,'Khulna Division',NULL,NULL,'Bangladesh',NULL,NULL,1),(68,2,NULL,'Rajshahi Division',NULL,NULL,'Bangladesh',NULL,NULL,1),(69,2,NULL,'Rangpur Division',NULL,NULL,'Bangladesh',NULL,NULL,1),(70,2,NULL,'Sylhet Division',NULL,NULL,'Bangladesh',NULL,NULL,1);
/*!40000 ALTER TABLE `db_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stockadjustment`
--

DROP TABLE IF EXISTS `db_stockadjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stockadjustment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `adjustment_date` date DEFAULT NULL,
  `adjustment_note` mediumtext DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_stockadjustment_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stockadjustment`
--

LOCK TABLES `db_stockadjustment` WRITE;
/*!40000 ALTER TABLE `db_stockadjustment` DISABLE KEYS */;
INSERT INTO `db_stockadjustment` VALUES (18,2,2,NULL,'2022-08-09',NULL,'2022-08-09','12:00:19 pm','Chris','37.28.46.147','dynamic.isp.ooredoo.om',1),(19,2,2,'','2022-08-09','','2022-08-09','01:38:51 pm','Chris','37.28.46.147','dynamic.isp.ooredoo.om',1),(20,2,2,NULL,'2022-08-10',NULL,'2022-08-10','09:23:28 am','Chris','5.21.237.233','5.21.237.233',1),(21,2,2,NULL,'2024-07-09',NULL,'2024-07-09','01:52:33 am','admin','::1','DESKTOP-GMFRN98',1),(22,2,2,NULL,'2024-07-09',NULL,'2024-07-09','12:42:05 pm','admin','::1','DESKTOP-GMFRN98',1),(23,2,2,NULL,'2024-07-10',NULL,'2024-07-10','12:49:08 pm','admin','103.131.145.159','client-103.131.145.159.plexuscloud.com.bd',1),(24,2,87,NULL,'2024-07-14',NULL,'2024-07-14','10:52:51 am','admin','114.130.189.19','114.130.189.19',1),(25,2,2,NULL,'2024-08-11',NULL,'2024-08-11','07:12:39 pm','admin','103.197.248.45','103.197.248-45.eurotelbd.net',1),(26,3,92,NULL,'2026-09-30',NULL,'2026-09-30','05:07:19 pm','shuvo2525','::1','DESKTOP-V3TH0KV',1),(27,3,92,NULL,'2026-10-01',NULL,'2026-10-01','11:11:59 am','shuvo2525','::1','DESKTOP-V3TH0KV',1);
/*!40000 ALTER TABLE `db_stockadjustment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stockadjustmentitems`
--

DROP TABLE IF EXISTS `db_stockadjustmentitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stockadjustmentitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `adjustment_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `adjustment_qty` double(20,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`adjustment_id`),
  KEY `item_id` (`item_id`),
  KEY `store_id` (`store_id`),
  KEY `warehouse_id` (`warehouse_id`),
  CONSTRAINT `db_stockadjustmentitems_ibfk_1` FOREIGN KEY (`adjustment_id`) REFERENCES `db_stockadjustment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stockadjustmentitems_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stockadjustmentitems_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stockadjustmentitems_ibfk_4` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=374 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stockadjustmentitems`
--

LOCK TABLES `db_stockadjustmentitems` WRITE;
/*!40000 ALTER TABLE `db_stockadjustmentitems` DISABLE KEYS */;
INSERT INTO `db_stockadjustmentitems` VALUES (366,2,2,21,1,20.00,1,NULL),(367,2,2,22,11,2.00,1,NULL),(368,2,2,23,12,20.00,1,NULL),(369,2,87,24,14,10.00,1,NULL),(370,2,2,25,18,50.00,1,NULL),(371,2,2,19,4,1.00,1,''),(372,3,92,26,20,10.00,1,NULL),(373,3,92,27,21,10.00,1,NULL);
/*!40000 ALTER TABLE `db_stockadjustmentitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stockentry`
--

DROP TABLE IF EXISTS `db_stockentry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stockentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_date` date DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stockentry`
--

LOCK TABLES `db_stockentry` WRITE;
/*!40000 ALTER TABLE `db_stockentry` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_stockentry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stocktransfer`
--

DROP TABLE IF EXISTS `db_stocktransfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stocktransfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT 'from store',
  `to_store_id` int(11) DEFAULT NULL COMMENT 'to store transfer',
  `warehouse_from` int(11) DEFAULT NULL,
  `warehouse_to` int(11) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `warehouse_id` (`warehouse_from`),
  KEY `warehouse_to` (`warehouse_to`),
  KEY `db_stocktransfer_ibfk_4` (`to_store_id`),
  CONSTRAINT `db_stocktransfer_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransfer_ibfk_2` FOREIGN KEY (`warehouse_from`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransfer_ibfk_3` FOREIGN KEY (`warehouse_to`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransfer_ibfk_4` FOREIGN KEY (`to_store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stocktransfer`
--

LOCK TABLES `db_stocktransfer` WRITE;
/*!40000 ALTER TABLE `db_stocktransfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_stocktransfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stocktransferitems`
--

DROP TABLE IF EXISTS `db_stocktransferitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stocktransferitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stocktransfer_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT 'from store',
  `to_store_id` int(11) DEFAULT NULL COMMENT 'to store',
  `warehouse_from` int(11) DEFAULT NULL COMMENT 'warehouse ids',
  `warehouse_to` int(11) DEFAULT NULL COMMENT 'warehouse ids',
  `item_id` int(11) DEFAULT NULL,
  `transfer_qty` double(20,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `warehouse_from` (`warehouse_from`),
  KEY `warehouse_to` (`warehouse_to`),
  KEY `stocktranfer_id` (`stocktransfer_id`),
  KEY `item_id` (`item_id`),
  KEY `db_stocktransferitems_ibfk_6` (`to_store_id`),
  CONSTRAINT `db_stocktransferitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransferitems_ibfk_2` FOREIGN KEY (`warehouse_from`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransferitems_ibfk_3` FOREIGN KEY (`warehouse_to`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransferitems_ibfk_4` FOREIGN KEY (`stocktransfer_id`) REFERENCES `db_stocktransfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransferitems_ibfk_5` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_stocktransferitems_ibfk_6` FOREIGN KEY (`to_store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stocktransferitems`
--

LOCK TABLES `db_stocktransferitems` WRITE;
/*!40000 ALTER TABLE `db_stocktransferitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_stocktransferitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_store`
--

DROP TABLE IF EXISTS `db_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_code` varchar(150) DEFAULT NULL,
  `store_name` varchar(150) DEFAULT NULL,
  `store_website` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `store_logo` text DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL,
  `upi_id` varchar(50) DEFAULT NULL,
  `upi_code` text DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `vat_no` varchar(50) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `bank_details` mediumtext DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `category_init` varchar(50) DEFAULT NULL,
  `item_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `supplier_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `purchase_return_init` varchar(50) DEFAULT NULL,
  `customer_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_init` varchar(50) DEFAULT NULL COMMENT 'INITAL CODE',
  `sales_return_init` varchar(50) DEFAULT NULL,
  `expense_init` varchar(50) DEFAULT NULL,
  `accounts_init` varchar(50) DEFAULT NULL,
  `journal_init` varchar(50) DEFAULT NULL,
  `cust_advance_init` varchar(50) DEFAULT NULL,
  `invoice_view` int(11) DEFAULT NULL COMMENT '1=Standard,2=Indian GST',
  `sms_status` int(11) DEFAULT NULL COMMENT '1=Enable 0=Disable',
  `status` int(11) DEFAULT NULL,
  `auto_lock_day` int(2) DEFAULT 0,
  `auto_lock_date` date DEFAULT NULL,
  `auto_lock_note` varchar(255) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_placement` varchar(50) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `date_format` varchar(50) DEFAULT NULL,
  `time_format` int(11) DEFAULT NULL,
  `sales_discount` double(20,4) DEFAULT NULL,
  `currencysymbol_id` int(11) DEFAULT NULL,
  `regno_key` varchar(50) DEFAULT NULL,
  `fav_icon` text DEFAULT NULL,
  `purchase_code` text DEFAULT NULL,
  `change_return` int(11) DEFAULT NULL,
  `sales_invoice_format_id` int(11) DEFAULT NULL,
  `pos_invoice_format_id` int(11) DEFAULT NULL,
  `sales_invoice_footer_text` text DEFAULT NULL,
  `round_off` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `quotation_init` varchar(50) DEFAULT NULL,
  `decimals` int(11) DEFAULT 2,
  `money_transfer_init` varchar(50) DEFAULT NULL,
  `sales_payment_init` varchar(50) DEFAULT NULL,
  `sales_return_payment_init` varchar(50) DEFAULT NULL,
  `purchase_payment_init` varchar(50) DEFAULT NULL,
  `purchase_return_payment_init` varchar(50) DEFAULT NULL,
  `expense_payment_init` varchar(50) DEFAULT NULL,
  `current_subscriptionlist_id` int(11) DEFAULT 0,
  `smtp_host` varchar(250) DEFAULT NULL,
  `smtp_port` varchar(250) DEFAULT NULL,
  `smtp_user` varchar(250) DEFAULT NULL,
  `smtp_pass` varchar(250) DEFAULT NULL,
  `smtp_status` int(11) DEFAULT 0,
  `sms_url` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `mrp_column` int(11) DEFAULT 0,
  `invoice_terms` text DEFAULT NULL,
  `previous_balance_bit` int(11) DEFAULT 1 COMMENT '1=Show, 0=Hide - Shows on sales invoice',
  `qty_decimals` int(11) DEFAULT 2,
  `signature` text DEFAULT NULL,
  `show_signature` int(11) DEFAULT 0,
  `t_and_c_status` int(11) DEFAULT 1 COMMENT '1=Show, 0=Hide - Shows on sales invoice',
  `t_and_c_status_pos` int(11) DEFAULT 1,
  `number_to_words` varchar(250) DEFAULT 'Default',
  `default_account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_store`
--

LOCK TABLES `db_store` WRITE;
/*!40000 ALTER TABLE `db_store` DISABLE KEYS */;
INSERT INTO `db_store` VALUES (1,'ST0001','SAAS ADMIN','','+919999999999','','admin@example.com','www','uploads/store/company_logo.png',NULL,NULL,NULL,'India','Karnataka','Bengalore','Gandhi Road','','','','','',NULL,'CT/01/','IT01','SU/01/','PU/2020/01','PR/2020/01/','CU/01/','SL/2020/01/','SR/2020/01/','EX/2020/01/','AC/01/','JE','ADV',1,0,1,0,NULL,NULL,1,35,'Left','Asia/Kolkata\r\n','dd-mm-yyyy',12,0.0000,NULL,NULL,NULL,NULL,1,3,1,'Its Footer, You can change it from Store Settings.',0,NULL,NULL,NULL,NULL,NULL,'QT/2020/01/',2,'MT/01/','SP/2020/01/','SRP/2020/01/','PP/2020/01/','PRP/2020/01/','XP/2020/01/',26,'ssl://smtp.gmail.com','465','salmanpathanindia@gmail.com','9632563672',1,'http://sms.proware.in/api/sendhttp.php?authkey=248050Asbku6K75bf27efc&amp;mobiles={{MOBILE}}&amp;message={{MESSAGE}}&amp;sender=WBMGIC&amp;route=4',0,0,NULL,1,2,NULL,0,1,1,'Default',8),(2,'ST0002','AR Departmental Store','www.elitedesign.com.bd','01775457008','01954578089','info@elitedesign.com.bd',NULL,'uploads/store/12.png',NULL,NULL,NULL,'Bangladesh','Rangpur Division','Lalmonir Hat','House: Munsi Bari,Beside Nayar Hat High School,Borobari,Lalmonir Hat','5500','','','','Accounts: 128474444444\r\nHolder: Md Abu Sayed\r\nBank Name: EBL Bank',NULL,'CT','IT02','SU','PU','PR','CU','SL','SR','EX','AC',NULL,'ADV',1,1,0,1,'2026-10-01',NULL,1,60,'Left','Asia/Dhaka\r\n','dd-mm-yyyy',12,0.0000,NULL,NULL,NULL,NULL,1,3,1,'সালাত কায়েম করুন, ধন্যবাদ আবার আসবেন।',1,'2021-02-12','05:53:37 pm','','127.0.0.1','LAPTOP-I5OUIM4R','QT',2,'MT','SP','SRP','PP','PRP','XP',28,'mail.elitedesign.com.bd','465','01744594344','s989989@',1,NULL,0,1,'ব্রিদ্রঃ বিক্রয়কৃত কোন পণ্য ফেরত নেওয়া হয় না।',1,2,'uploads/signature/signature.png',1,1,1,'Default',1),(3,'ST0003','Nahid Super Shop','','01818430308','','shuvo2525@gmail.com',NULL,'uploads/store/Jpeg.jpg',NULL,NULL,NULL,'Bangladesh','','tangail','ffa','','','','','',NULL,'CT/03/','IT03','SU/03/','PU/2026/03/','PR/2026/03/','CU/03/','SL/2026/03/','SR/2026/03/','EX/2026/03/','AC/03/',NULL,'ADV/2026/03/',1,0,1,1,'2026-11-01',NULL,1,60,'Right','Africa/Abidjan\r\n','dd-mm-yyyy',12,0.0000,NULL,NULL,NULL,NULL,1,3,1,'This is footer text. It is in Store Management.',0,'2026-09-30','10:31:26 pm','superadmin','::1','DESKTOP-V3TH0KV','QT/2026/03/',2,'MT/03/','SP/2026/03/','SRP/2026/03/','PP/2026/03/','PRP/2026/03/','XP/2026/03/',29,NULL,NULL,NULL,NULL,0,NULL,105,1,'',1,2,NULL,0,1,1,'Default',12);
/*!40000 ALTER TABLE `db_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stripe`
--

DROP TABLE IF EXISTS `db_stripe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stripe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `sandbox` int(11) DEFAULT NULL,
  `publishable_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `api_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_stripe_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stripe`
--

LOCK TABLES `db_stripe` WRITE;
/*!40000 ALTER TABLE `db_stripe` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_stripe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_stripepayments`
--

DROP TABLE IF EXISTS `db_stripepayments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_stripepayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `buyer_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `buyer_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount_currency` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `txn_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_stripepayments`
--

LOCK TABLES `db_stripepayments` WRITE;
/*!40000 ALTER TABLE `db_stripepayments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_stripepayments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_subscription`
--

DROP TABLE IF EXISTS `db_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `payment_id` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `package_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `package_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subscription_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `trial_days` int(11) DEFAULT NULL,
  `max_users` int(11) DEFAULT NULL,
  `max_warehouses` int(11) DEFAULT NULL,
  `max_items` int(11) DEFAULT NULL,
  `max_invoices` int(11) DEFAULT NULL,
  `payment_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `txn_id` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_gross` double(10,2) DEFAULT NULL,
  `package_charge` double(10,2) DEFAULT 0.00,
  `setup_charge` double(10,2) DEFAULT 0.00,
  `currency_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payer_email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_status` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `package_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_type` varchar(250) DEFAULT NULL COMMENT 'manual subscription only',
  `package_count` int(11) DEFAULT NULL COMMENT 'manual subscription only',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_subscription`
--

LOCK TABLES `db_subscription` WRITE;
/*!40000 ALTER TABLE `db_subscription` DISABLE KEYS */;
INSERT INTO `db_subscription` VALUES (13,22,NULL,2,NULL,'Regular','Test description','2021-01-25',NULL,15,20,20,200,200,'PayPal','48R18927X78299709',250.00,0.00,0.00,'USD','sb-9fy504805522@business.example.com','Pending','2021-01-25','01:30:45 pm','Tester','127.0.0.1','LAPTOP-I5OUIM4R',NULL,NULL,NULL),(14,22,NULL,2,'Paid','Regular','Test description','2021-01-25',NULL,15,20,20,200,200,'PayPal','9M838440FH9266015',250.00,0.00,0.00,'USD','sb-9fy504805522@business.example.com','Pending','2021-01-25','01:32:28 pm','Tester','127.0.0.1','LAPTOP-I5OUIM4R',NULL,NULL,NULL),(16,22,NULL,2,'Paid','Regular','Test description','2021-01-25','2021-02-25',15,20,20,200,200,'PayPal','2PT61144W90213341',250.00,0.00,0.00,'USD','sb-9fy504805522@business.example.com','Pending','2021-01-25','02:00:38 pm','Tester','127.0.0.1','LAPTOP-I5OUIM4R',NULL,NULL,NULL),(26,1,NULL,1,'Free','Free','Test description','2021-01-25','2021-02-04',10,2,2,20,20,'Self','',0.00,0.00,0.00,'','','','2021-01-25','06:32:32 pm','admin','127.0.0.1','LAPTOP-I5OUIM4R',NULL,NULL,NULL),(27,24,NULL,1,'Free','Free','Test description','2021-02-11','2021-02-21',10,2,2,20,20,'Self','',0.00,0.00,0.00,'','','','2021-02-11','03:09:47 pm','Tester','127.0.0.1','LAPTOP-I5OUIM4R',NULL,NULL,NULL),(28,2,NULL,1,'Free','Free','Test description','2021-02-12','2021-02-22',10,2,2,20,20,'Self','',0.00,0.00,0.00,'','','Paid','2021-02-12','06:57:18 pm','Tester','127.0.0.1','LAPTOP-I5OUIM4R','Active',NULL,NULL),(29,3,NULL,1,'Free','Free Plan','Free plan for new businesses','2026-10-01','2027-09-30',30,1,1,50,50,'Manual',NULL,0.00,0.00,0.00,NULL,NULL,'Paid','2026-09-30','10:31:26 pm','superadmin',NULL,NULL,'Active','Free',1);
/*!40000 ALTER TABLE `db_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_supplier_payments`
--

DROP TABLE IF EXISTS `db_supplier_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_supplier_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchasepayment_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `purchasepayment_id` (`purchasepayment_id`),
  CONSTRAINT `db_supplier_payments_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `db_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_supplier_payments_ibfk_2` FOREIGN KEY (`purchasepayment_id`) REFERENCES `db_purchasepayments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=291 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_supplier_payments`
--

LOCK TABLES `db_supplier_payments` WRITE;
/*!40000 ALTER TABLE `db_supplier_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_supplier_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_suppliers`
--

DROP TABLE IF EXISTS `db_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL COMMENT 'Use to create supplier Code',
  `supplier_code` varchar(20) DEFAULT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `tax_number` varchar(50) DEFAULT NULL,
  `vatin` varchar(100) DEFAULT NULL,
  `opening_balance` double(20,4) DEFAULT NULL,
  `purchase_due` double(20,4) DEFAULT NULL,
  `purchase_return_due` double(20,4) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_suppliers_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_suppliers`
--

LOCK TABLES `db_suppliers` WRITE;
/*!40000 ALTER TABLE `db_suppliers` DISABLE KEYS */;
INSERT INTO `db_suppliers` VALUES (1,2,1,'SU0001','Badsha Treaders','+8801858989397','','badsha@gmail.com','','',NULL,0.0000,954999500.0000,NULL,0,0,'','','Puran Dhaka, Bangladesh','::1','DESKTOP-GMFRN98','2024-07-09','11:39:56 am','admin',NULL,1),(2,2,2,'SU0002','Karim Textile','01775457889','','karim@gmail.com','','',NULL,0.0000,7340047130.0000,NULL,0,0,'','','Mirpur-1','::1','DESKTOP-GMFRN98','2024-07-09','11:41:25 am','admin',NULL,1),(3,2,3,'SU0003','AR Group','+8801870829396','','ar@gmail.com','','',NULL,0.0000,59999800.0000,NULL,210,0,'Dhaka','','35/3/1,B,Section-13','::1','DESKTOP-GMFRN98','2024-07-09','11:42:27 am','admin',NULL,1),(4,2,4,'SU0004','Mahmud Jeans','01954578086','','mahmud@gmail.com','','',NULL,0.0000,0.0000,NULL,210,0,'Dhaka','','35/3/1,B,Section-13','::1','DESKTOP-GMFRN98','2024-07-09','11:43:32 am','admin',NULL,1),(5,2,5,'SU0005','Dilu Telicom','01775457001','','dilu@gmail.com','','',NULL,0.0000,1499999909000.0000,NULL,210,0,'Dhaka','1216','Mirpu-10','::1','DESKTOP-GMFRN98','2024-07-09','11:44:53 am','admin',NULL,1),(6,2,6,'SU0006','Grocer World','01858989391','','grocer@gmial.com','','',NULL,0.0000,17999999900.0000,NULL,210,0,'Dhaka','','35/3/1,B,Section-13','::1','DESKTOP-GMFRN98','2024-07-09','11:46:05 am','admin',NULL,1),(7,2,7,'SU0007','Ali Khadda Bhander','01854896987','01965982698','info@elitedesign.com.bd','','',NULL,200000.0000,NULL,NULL,210,66,'Dhaka ','1548','','103.59.179.21','103.59.179.21','2024-08-19','01:07:04 am','admin',NULL,1);
/*!40000 ALTER TABLE `db_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_tax`
--

DROP TABLE IF EXISTS `db_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `tax_name` varchar(50) DEFAULT NULL,
  `tax` double(20,4) DEFAULT NULL,
  `group_bit` int(11) DEFAULT NULL COMMENT '1=Yes, 0=No',
  `subtax_ids` varchar(10) DEFAULT NULL COMMENT 'Tax groups IDs',
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_tax_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_tax`
--

LOCK TABLES `db_tax` WRITE;
/*!40000 ALTER TABLE `db_tax` DISABLE KEYS */;
INSERT INTO `db_tax` VALUES (150,2,'N/A',0.0000,NULL,NULL,1);
/*!40000 ALTER TABLE `db_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_timezone`
--

DROP TABLE IF EXISTS `db_timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=549 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_timezone`
--

LOCK TABLES `db_timezone` WRITE;
/*!40000 ALTER TABLE `db_timezone` DISABLE KEYS */;
INSERT INTO `db_timezone` VALUES (1,'Africa/Abidjan\r',1),(2,'Africa/Accra\r',1),(3,'Africa/Addis_Ababa\r',1),(4,'Africa/Algiers\r',1),(5,'Africa/Asmara\r',1),(6,'Africa/Asmera\r',1),(7,'Africa/Bamako\r',1),(8,'Africa/Bangui\r',1),(9,'Africa/Banjul\r',1),(10,'Africa/Bissau\r',1),(11,'Africa/Blantyre\r',1),(12,'Africa/Brazzaville\r',1),(13,'Africa/Bujumbura\r',1),(14,'Africa/Cairo\r',1),(15,'Africa/Casablanca\r',1),(16,'Africa/Ceuta\r',1),(17,'Africa/Conakry\r',1),(18,'Africa/Dakar\r',1),(19,'Africa/Dar_es_Salaam\r',1),(20,'Africa/Djibouti\r',1),(21,'Africa/Douala\r',1),(22,'Africa/El_Aaiun\r',1),(23,'Africa/Freetown\r',1),(24,'Africa/Gaborone\r',1),(25,'Africa/Harare\r',1),(26,'Africa/Johannesburg\r',1),(27,'Africa/Juba\r',1),(28,'Africa/Kampala\r',1),(29,'Africa/Khartoum\r',1),(30,'Africa/Kigali\r',1),(31,'Africa/Kinshasa\r',1),(32,'Africa/Lagos\r',1),(33,'Africa/Libreville\r',1),(34,'Africa/Lome\r',1),(35,'Africa/Luanda\r',1),(36,'Africa/Lubumbashi\r',1),(37,'Africa/Lusaka\r',1),(38,'Africa/Malabo\r',1),(39,'Africa/Maputo\r',1),(40,'Africa/Maseru\r',1),(41,'Africa/Mbabane\r',1),(42,'Africa/Mogadishu\r',1),(43,'Africa/Monrovia\r',1),(44,'Africa/Nairobi\r',1),(45,'Africa/Ndjamena\r',1),(46,'Africa/Niamey\r',1),(47,'Africa/Nouakchott\r',1),(48,'Africa/Ouagadougou\r',1),(49,'Africa/Porto-Novo\r',1),(50,'Africa/Sao_Tome\r',1),(51,'Africa/Timbuktu\r',1),(52,'Africa/Tripoli\r',1),(53,'Africa/Tunis\r',1),(54,'Africa/Windhoek\r',1),(55,'AKST9AKDT\r',1),(56,'America/Adak\r',1),(57,'America/Anchorage\r',1),(58,'America/Anguilla\r',1),(59,'America/Antigua\r',1),(60,'America/Araguaina\r',1),(61,'America/Argentina/Buenos_Aires\r',1),(62,'America/Argentina/Catamarca\r',1),(63,'America/Argentina/ComodRivadavia\r',1),(64,'America/Argentina/Cordoba\r',1),(65,'America/Argentina/Jujuy\r',1),(66,'America/Argentina/La_Rioja\r',1),(67,'America/Argentina/Mendoza\r',1),(68,'America/Argentina/Rio_Gallegos\r',1),(69,'America/Argentina/Salta\r',1),(70,'America/Argentina/San_Juan\r',1),(71,'America/Argentina/San_Luis\r',1),(72,'America/Argentina/Tucuman\r',1),(73,'America/Argentina/Ushuaia\r',1),(74,'America/Aruba\r',1),(75,'America/Asuncion\r',1),(76,'America/Atikokan\r',1),(77,'America/Atka\r',1),(78,'America/Bahia\r',1),(79,'America/Bahia_Banderas\r',1),(80,'America/Barbados\r',1),(81,'America/Belem\r',1),(82,'America/Belize\r',1),(83,'America/Blanc-Sablon\r',1),(84,'America/Boa_Vista\r',1),(85,'America/Bogota\r',1),(86,'America/Boise\r',1),(87,'America/Buenos_Aires\r',1),(88,'America/Cambridge_Bay\r',1),(89,'America/Campo_Grande\r',1),(90,'America/Cancun\r',1),(91,'America/Caracas\r',1),(92,'America/Catamarca\r',1),(93,'America/Cayenne\r',1),(94,'America/Cayman\r',1),(95,'America/Chicago\r',1),(96,'America/Chihuahua\r',1),(97,'America/Coral_Harbour\r',1),(98,'America/Cordoba\r',1),(99,'America/Costa_Rica\r',1),(100,'America/Creston\r',1),(101,'America/Cuiaba\r',1),(102,'America/Curacao\r',1),(103,'America/Danmarkshavn\r',1),(104,'America/Dawson\r',1),(105,'America/Dawson_Creek\r',1),(106,'America/Denver\r',1),(107,'America/Detroit\r',1),(108,'America/Dominica\r',1),(109,'America/Edmonton\r',1),(110,'America/Eirunepe\r',1),(111,'America/El_Salvador\r',1),(112,'America/Ensenada\r',1),(113,'America/Fort_Wayne\r',1),(114,'America/Fortaleza\r',1),(115,'America/Glace_Bay\r',1),(116,'America/Godthab\r',1),(117,'America/Goose_Bay\r',1),(118,'America/Grand_Turk\r',1),(119,'America/Grenada\r',1),(120,'America/Guadeloupe\r',1),(121,'America/Guatemala\r',1),(122,'America/Guayaquil\r',1),(123,'America/Guyana\r',1),(124,'America/Halifax\r',1),(125,'America/Havana\r',1),(126,'America/Hermosillo\r',1),(127,'America/Indiana/Indianapolis\r',1),(128,'America/Indiana/Knox\r',1),(129,'America/Indiana/Marengo\r',1),(130,'America/Indiana/Petersburg\r',1),(131,'America/Indiana/Tell_City\r',1),(132,'America/Indiana/Vevay\r',1),(133,'America/Indiana/Vincennes\r',1),(134,'America/Indiana/Winamac\r',1),(135,'America/Indianapolis\r',1),(136,'America/Inuvik\r',1),(137,'America/Iqaluit\r',1),(138,'America/Jamaica\r',1),(139,'America/Jujuy\r',1),(140,'America/Juneau\r',1),(141,'America/Kentucky/Louisville\r',1),(142,'America/Kentucky/Monticello\r',1),(143,'America/Knox_IN\r',1),(144,'America/Kralendijk\r',1),(145,'America/La_Paz\r',1),(146,'America/Lima\r',1),(147,'America/Los_Angeles\r',1),(148,'America/Louisville\r',1),(149,'America/Lower_Princes\r',1),(150,'America/Maceio\r',1),(151,'America/Managua\r',1),(152,'America/Manaus\r',1),(153,'America/Marigot\r',1),(154,'America/Martinique\r',1),(155,'America/Matamoros\r',1),(156,'America/Mazatlan\r',1),(157,'America/Mendoza\r',1),(158,'America/Menominee\r',1),(159,'America/Merida\r',1),(160,'America/Metlakatla\r',1),(161,'America/Mexico_City\r',1),(162,'America/Miquelon\r',1),(163,'America/Moncton\r',1),(164,'America/Monterrey\r',1),(165,'America/Montevideo\r',1),(166,'America/Montreal\r',1),(167,'America/Montserrat\r',1),(168,'America/Nassau\r',1),(169,'America/New_York\r',1),(170,'America/Nipigon\r',1),(171,'America/Nome\r',1),(172,'America/Noronha\r',1),(173,'America/North_Dakota/Beulah\r',1),(174,'America/North_Dakota/Center\r',1),(175,'America/North_Dakota/New_Salem\r',1),(176,'America/Ojinaga\r',1),(177,'America/Panama\r',1),(178,'America/Pangnirtung\r',1),(179,'America/Paramaribo\r',1),(180,'America/Phoenix\r',1),(181,'America/Port_of_Spain\r',1),(182,'America/Port-au-Prince\r',1),(183,'America/Porto_Acre\r',1),(184,'America/Porto_Velho\r',1),(185,'America/Puerto_Rico\r',1),(186,'America/Rainy_River\r',1),(187,'America/Rankin_Inlet\r',1),(188,'America/Recife\r',1),(189,'America/Regina\r',1),(190,'America/Resolute\r',1),(191,'America/Rio_Branco\r',1),(192,'America/Rosario\r',1),(193,'America/Santa_Isabel\r',1),(194,'America/Santarem\r',1),(195,'America/Santiago\r',1),(196,'America/Santo_Domingo\r',1),(197,'America/Sao_Paulo\r',1),(198,'America/Scoresbysund\r',1),(199,'America/Shiprock\r',1),(200,'America/Sitka\r',1),(201,'America/St_Barthelemy\r',1),(202,'America/St_Johns\r',1),(203,'America/St_Kitts\r',1),(204,'America/St_Lucia\r',1),(205,'America/St_Thomas\r',1),(206,'America/St_Vincent\r',1),(207,'America/Swift_Current\r',1),(208,'America/Tegucigalpa\r',1),(209,'America/Thule\r',1),(210,'America/Thunder_Bay\r',1),(211,'America/Tijuana\r',1),(212,'America/Toronto\r',1),(213,'America/Tortola\r',1),(214,'America/Vancouver\r',1),(215,'America/Virgin\r',1),(216,'America/Whitehorse\r',1),(217,'America/Winnipeg\r',1),(218,'America/Yakutat\r',1),(219,'America/Yellowknife\r',1),(220,'Antarctica/Casey\r',1),(221,'Antarctica/Davis\r',1),(222,'Antarctica/DumontDUrville\r',1),(223,'Antarctica/Macquarie\r',1),(224,'Antarctica/Mawson\r',1),(225,'Antarctica/McMurdo\r',1),(226,'Antarctica/Palmer\r',1),(227,'Antarctica/Rothera\r',1),(228,'Antarctica/South_Pole\r',1),(229,'Antarctica/Syowa\r',1),(230,'Antarctica/Vostok\r',1),(231,'Arctic/Longyearbyen\r',1),(232,'Asia/Aden\r',1),(233,'Asia/Almaty\r',1),(234,'Asia/Amman\r',1),(235,'Asia/Anadyr\r',1),(236,'Asia/Aqtau\r',1),(237,'Asia/Aqtobe\r',1),(238,'Asia/Ashgabat\r',1),(239,'Asia/Ashkhabad\r',1),(240,'Asia/Baghdad\r',1),(241,'Asia/Bahrain\r',1),(242,'Asia/Baku\r',1),(243,'Asia/Bangkok\r',1),(244,'Asia/Beirut\r',1),(245,'Asia/Bishkek\r',1),(246,'Asia/Brunei\r',1),(247,'Asia/Calcutta\r',1),(248,'Asia/Choibalsan\r',1),(249,'Asia/Chongqing\r',1),(250,'Asia/Chungking\r',1),(251,'Asia/Colombo\r',1),(252,'Asia/Dacca\r',1),(253,'Asia/Damascus\r',1),(254,'Asia/Dhaka\r',1),(255,'Asia/Dili\r',1),(256,'Asia/Dubai\r',1),(257,'Asia/Dushanbe\r',1),(258,'Asia/Gaza\r',1),(259,'Asia/Harbin\r',1),(260,'Asia/Hebron\r',1),(261,'Asia/Ho_Chi_Minh\r',1),(262,'Asia/Hong_Kong\r',1),(263,'Asia/Hovd\r',1),(264,'Asia/Irkutsk\r',1),(265,'Asia/Istanbul\r',1),(266,'Asia/Jakarta\r',1),(267,'Asia/Jayapura\r',1),(268,'Asia/Jerusalem\r',1),(269,'Asia/Kabul\r',1),(270,'Asia/Kamchatka\r',1),(271,'Asia/Karachi\r',1),(272,'Asia/Kashgar\r',1),(273,'Asia/Kathmandu\r',1),(274,'Asia/Katmandu\r',1),(275,'Asia/Kolkata\r',1),(276,'Asia/Krasnoyarsk\r',1),(277,'Asia/Kuala_Lumpur\r',1),(278,'Asia/Kuching\r',1),(279,'Asia/Kuwait\r',1),(280,'Asia/Macao\r',1),(281,'Asia/Macau\r',1),(282,'Asia/Magadan\r',1),(283,'Asia/Makassar\r',1),(284,'Asia/Manila\r',1),(285,'Asia/Muscat\r',1),(286,'Asia/Nicosia\r',1),(287,'Asia/Novokuznetsk\r',1),(288,'Asia/Novosibirsk\r',1),(289,'Asia/Omsk\r',1),(290,'Asia/Oral\r',1),(291,'Asia/Phnom_Penh\r',1),(292,'Asia/Pontianak\r',1),(293,'Asia/Pyongyang\r',1),(294,'Asia/Qatar\r',1),(295,'Asia/Qyzylorda\r',1),(296,'Asia/Rangoon\r',1),(297,'Asia/Riyadh\r',1),(298,'Asia/Saigon\r',1),(299,'Asia/Sakhalin\r',1),(300,'Asia/Samarkand\r',1),(301,'Asia/Seoul\r',1),(302,'Asia/Shanghai\r',1),(303,'Asia/Singapore\r',1),(304,'Asia/Taipei\r',1),(305,'Asia/Tashkent\r',1),(306,'Asia/Tbilisi\r',1),(307,'Asia/Tehran\r',1),(308,'Asia/Tel_Aviv\r',1),(309,'Asia/Thimbu\r',1),(310,'Asia/Thimphu\r',1),(311,'Asia/Tokyo\r',1),(312,'Asia/Ujung_Pandang\r',1),(313,'Asia/Ulaanbaatar\r',1),(314,'Asia/Ulan_Bator\r',1),(315,'Asia/Urumqi\r',1),(316,'Asia/Vientiane\r',1),(317,'Asia/Vladivostok\r',1),(318,'Asia/Yakutsk\r',1),(319,'Asia/Yekaterinburg\r',1),(320,'Asia/Yerevan\r',1),(321,'Atlantic/Azores\r',1),(322,'Atlantic/Bermuda\r',1),(323,'Atlantic/Canary\r',1),(324,'Atlantic/Cape_Verde\r',1),(325,'Atlantic/Faeroe\r',1),(326,'Atlantic/Faroe\r',1),(327,'Atlantic/Jan_Mayen\r',1),(328,'Atlantic/Madeira\r',1),(329,'Atlantic/Reykjavik\r',1),(330,'Atlantic/South_Georgia\r',1),(331,'Atlantic/St_Helena\r',1),(332,'Atlantic/Stanley\r',1),(333,'Australia/ACT\r',1),(334,'Australia/Adelaide\r',1),(335,'Australia/Brisbane\r',1),(336,'Australia/Broken_Hill\r',1),(337,'Australia/Canberra\r',1),(338,'Australia/Currie\r',1),(339,'Australia/Darwin\r',1),(340,'Australia/Eucla\r',1),(341,'Australia/Hobart\r',1),(342,'Australia/LHI\r',1),(343,'Australia/Lindeman\r',1),(344,'Australia/Lord_Howe\r',1),(345,'Australia/Melbourne\r',1),(346,'Australia/North\r',1),(347,'Australia/NSW\r',1),(348,'Australia/Perth\r',1),(349,'Australia/Queensland\r',1),(350,'Australia/South\r',1),(351,'Australia/Sydney\r',1),(352,'Australia/Tasmania\r',1),(353,'Australia/Victoria\r',1),(354,'Australia/West\r',1),(355,'Australia/Yancowinna\r',1),(356,'Brazil/Acre\r',1),(357,'Brazil/DeNoronha\r',1),(358,'Brazil/East\r',1),(359,'Brazil/West\r',1),(360,'Canada/Atlantic\r',1),(361,'Canada/Central\r',1),(362,'Canada/Eastern\r',1),(363,'Canada/East-Saskatchewan\r',1),(364,'Canada/Mountain\r',1),(365,'Canada/Newfoundland\r',1),(366,'Canada/Pacific\r',1),(367,'Canada/Saskatchewan\r',1),(368,'Canada/Yukon\r',1),(369,'CET\r',1),(370,'Chile/Continental\r',1),(371,'Chile/EasterIsland\r',1),(372,'CST6CDT\r',1),(373,'Cuba\r',1),(374,'EET\r',1),(375,'Egypt\r',1),(376,'Eire\r',1),(377,'EST\r',1),(378,'EST5EDT\r',1),(379,'Etc./GMT\r',1),(380,'Etc./GMT+0\r',1),(381,'Etc./UCT\r',1),(382,'Etc./Universal\r',1),(383,'Etc./UTC\r',1),(384,'Etc./Zulu\r',1),(385,'Europe/Amsterdam\r',1),(386,'Europe/Andorra\r',1),(387,'Europe/Athens\r',1),(388,'Europe/Belfast\r',1),(389,'Europe/Belgrade\r',1),(390,'Europe/Berlin\r',1),(391,'Europe/Bratislava\r',1),(392,'Europe/Brussels\r',1),(393,'Europe/Bucharest\r',1),(394,'Europe/Budapest\r',1),(395,'Europe/Chisinau\r',1),(396,'Europe/Copenhagen\r',1),(397,'Europe/Dublin\r',1),(398,'Europe/Gibraltar\r',1),(399,'Europe/Guernsey\r',1),(400,'Europe/Helsinki\r',1),(401,'Europe/Isle_of_Man\r',1),(402,'Europe/Istanbul\r',1),(403,'Europe/Jersey\r',1),(404,'Europe/Kaliningrad\r',1),(405,'Europe/Kiev\r',1),(406,'Europe/Lisbon\r',1),(407,'Europe/Ljubljana\r',1),(408,'Europe/London\r',1),(409,'Europe/Luxembourg\r',1),(410,'Europe/Madrid\r',1),(411,'Europe/Malta\r',1),(412,'Europe/Mariehamn\r',1),(413,'Europe/Minsk\r',1),(414,'Europe/Monaco\r',1),(415,'Europe/Moscow\r',1),(416,'Europe/Nicosia\r',1),(417,'Europe/Oslo\r',1),(418,'Europe/Paris\r',1),(419,'Europe/Podgorica\r',1),(420,'Europe/Prague\r',1),(421,'Europe/Riga\r',1),(422,'Europe/Rome\r',1),(423,'Europe/Samara\r',1),(424,'Europe/San_Marino\r',1),(425,'Europe/Sarajevo\r',1),(426,'Europe/Simferopol\r',1),(427,'Europe/Skopje\r',1),(428,'Europe/Sofia\r',1),(429,'Europe/Stockholm\r',1),(430,'Europe/Tallinn\r',1),(431,'Europe/Tirane\r',1),(432,'Europe/Tiraspol\r',1),(433,'Europe/Uzhgorod\r',1),(434,'Europe/Vaduz\r',1),(435,'Europe/Vatican\r',1),(436,'Europe/Vienna\r',1),(437,'Europe/Vilnius\r',1),(438,'Europe/Volgograd\r',1),(439,'Europe/Warsaw\r',1),(440,'Europe/Zagreb\r',1),(441,'Europe/Zaporozhye\r',1),(442,'Europe/Zurich\r',1),(443,'GB\r',1),(444,'GB-Eire\r',1),(445,'GMT\r',1),(446,'GMT+0\r',1),(447,'GMT0\r',1),(448,'GMT-0\r',1),(449,'Greenwich\r',1),(450,'Hong Kong\r',1),(451,'HST\r',1),(452,'Iceland\r',1),(453,'Indian/Antananarivo\r',1),(454,'Indian/Chagos\r',1),(455,'Indian/Christmas\r',1),(456,'Indian/Cocos\r',1),(457,'Indian/Comoro\r',1),(458,'Indian/Kerguelen\r',1),(459,'Indian/Mahe\r',1),(460,'Indian/Maldives\r',1),(461,'Indian/Mauritius\r',1),(462,'Indian/Mayotte\r',1),(463,'Indian/Reunion\r',1),(464,'Iran\r',1),(465,'Israel\r',1),(466,'Jamaica\r',1),(467,'Japan\r',1),(468,'JST-9\r',1),(469,'Kwajalein\r',1),(470,'Libya\r',1),(471,'MET\r',1),(472,'Mexico/BajaNorte\r',1),(473,'Mexico/BajaSur\r',1),(474,'Mexico/General\r',1),(475,'MST\r',1),(476,'MST7MDT\r',1),(477,'Navajo\r',1),(478,'NZ\r',1),(479,'NZ-CHAT\r',1),(480,'Pacific/Apia\r',1),(481,'Pacific/Auckland\r',1),(482,'Pacific/Chatham\r',1),(483,'Pacific/Chuuk\r',1),(484,'Pacific/Easter\r',1),(485,'Pacific/Efate\r',1),(486,'Pacific/Enderbury\r',1),(487,'Pacific/Fakaofo\r',1),(488,'Pacific/Fiji\r',1),(489,'Pacific/Funafuti\r',1),(490,'Pacific/Galapagos\r',1),(491,'Pacific/Gambier\r',1),(492,'Pacific/Guadalcanal\r',1),(493,'Pacific/Guam\r',1),(494,'Pacific/Honolulu\r',1),(495,'Pacific/Johnston\r',1),(496,'Pacific/Kiritimati\r',1),(497,'Pacific/Kosrae\r',1),(498,'Pacific/Kwajalein\r',1),(499,'Pacific/Majuro\r',1),(500,'Pacific/Marquesas\r',1),(501,'Pacific/Midway\r',1),(502,'Pacific/Nauru\r',1),(503,'Pacific/Niue\r',1),(504,'Pacific/Norfolk\r',1),(505,'Pacific/Noumea\r',1),(506,'Pacific/Pago_Pago\r',1),(507,'Pacific/Palau\r',1),(508,'Pacific/Pitcairn\r',1),(509,'Pacific/Pohnpei\r',1),(510,'Pacific/Ponape\r',1),(511,'Pacific/Port_Moresby\r',1),(512,'Pacific/Rarotonga\r',1),(513,'Pacific/Saipan\r',1),(514,'Pacific/Samoa\r',1),(515,'Pacific/Tahiti\r',1),(516,'Pacific/Tarawa\r',1),(517,'Pacific/Tongatapu\r',1),(518,'Pacific/Truk\r',1),(519,'Pacific/Wake\r',1),(520,'Pacific/Wallis\r',1),(521,'Pacific/Yap\r',1),(522,'Poland\r',1),(523,'Portugal\r',1),(524,'PRC\r',1),(525,'PST8PDT\r',1),(526,'ROC\r',1),(527,'ROK\r',1),(528,'Singapore\r',1),(529,'Turkey\r',1),(530,'UCT\r',1),(531,'Universal\r',1),(532,'US/Alaska\r',1),(533,'US/Aleutian\r',1),(534,'US/Arizona\r',1),(535,'US/Central\r',1),(536,'US/Eastern\r',1),(537,'US/East-Indiana\r',1),(538,'US/Hawaii\r',1),(539,'US/Indiana-Starke\r',1),(540,'US/Michigan\r',1),(541,'US/Mountain\r',1),(542,'US/Pacific\r',1),(543,'US/Pacific-New\r',1),(544,'US/Samoa\r',1),(545,'UTC\r',1),(546,'WET\r',1),(547,'W-SU\r',1),(548,'Zulu\r',1);
/*!40000 ALTER TABLE `db_timezone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_twilio`
--

DROP TABLE IF EXISTS `db_twilio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_twilio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `account_sid` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `auth_token` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twilio_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_twilio_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_twilio`
--

LOCK TABLES `db_twilio` WRITE;
/*!40000 ALTER TABLE `db_twilio` DISABLE KEYS */;
INSERT INTO `db_twilio` VALUES (1,1,'','','',0),(3,2,'','','',0);
/*!40000 ALTER TABLE `db_twilio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_units`
--

DROP TABLE IF EXISTS `db_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `unit_name` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_units_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_units`
--

LOCK TABLES `db_units` WRITE;
/*!40000 ALTER TABLE `db_units` DISABLE KEYS */;
INSERT INTO `db_units` VALUES (61,2,'PCS','',NULL,1),(62,2,'KG','',NULL,1),(63,2,'GM','',NULL,1),(64,2,'Liter','',NULL,1),(65,2,'PKT','',NULL,1),(66,3,'j','',NULL,1);
/*!40000 ALTER TABLE `db_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_users`
--

DROP TABLE IF EXISTS `db_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `password` blob DEFAULT NULL,
  `member_of` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `photo` blob DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` blob DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `profile_picture` text DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(100) DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `status` double DEFAULT NULL,
  `creater_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `default_warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_users_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_users`
--

LOCK TABLES `db_users` WRITE;
/*!40000 ALTER TABLE `db_users` DISABLE KEYS */;
INSERT INTO `db_users` VALUES (1,1,'superadmin','Elite','Design','25d55ad283aa400af464c76d713c07ad','',NULL,NULL,'','super@creativedesign.com.bd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'uploads/users/admin.png','2018-11-27','::1',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL),(2,2,'admin','Elite','Design','25d55ad283aa400af464c76d713c07ad',NULL,NULL,NULL,'0133483004','info@creativedesign.com.bd',NULL,NULL,NULL,NULL,NULL,NULL,'25d55ad283aa400af464c76d713c07ad',NULL,NULL,2,'uploads/users/IMG_20240625_231339_222.jpg','2021-02-12','05:53:37 pm','','127.0.0.1','LAPTOP-I5OUIM4R',1,NULL,NULL,NULL,0),(102,2,'manager01','Matin','Mia','25f9e794323b453885f5181f1b624d0b',NULL,NULL,NULL,'01745983657','abdcdd@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,32,NULL,'2024-08-19','12:09:15 am','admin','103.59.179.21','103.59.179.21',1,NULL,NULL,NULL,90),(103,2,'Great Bengal','Great','Bengal','f135fb25ba513a1710ddcef411fb096a',NULL,NULL,NULL,'01971705080','SIYAM_ORG@YAHOO.COM',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,32,NULL,'2024-09-07','11:44:19 pm','admin','103.43.94.71','103.43.94.71',1,NULL,NULL,NULL,0),(104,2,'Robiul1','Md','Robiul','71f55003c9a36b40c4a094908f11fb77',NULL,NULL,NULL,'01825479683','Robiul1@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,32,NULL,'2024-09-20','03:51:21 pm','admin','27.123.253.117','27-123-253-117-mcnbd.com',1,NULL,NULL,NULL,90),(105,3,'shuvo2525','Jubayer','khan','55ee32991ebd4e88a591b47c46b2ec8b',NULL,NULL,NULL,'','skjd@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,'2026-09-30','10:35:26 pm','superadmin','::1','DESKTOP-V3TH0KV',1,NULL,NULL,NULL,92);
/*!40000 ALTER TABLE `db_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_userswarehouses`
--

DROP TABLE IF EXISTS `db_userswarehouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_userswarehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `warehouse_id` (`warehouse_id`),
  CONSTRAINT `db_userswarehouses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `db_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_userswarehouses_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_userswarehouses`
--

LOCK TABLES `db_userswarehouses` WRITE;
/*!40000 ALTER TABLE `db_userswarehouses` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_userswarehouses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_variants`
--

DROP TABLE IF EXISTS `db_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `variant_code` varchar(50) DEFAULT NULL,
  `variant_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_variants_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_variants_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_variants`
--

LOCK TABLES `db_variants` WRITE;
/*!40000 ALTER TABLE `db_variants` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_warehouse`
--

DROP TABLE IF EXISTS `db_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_type` varchar(50) DEFAULT NULL,
  `warehouse_name` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `db_warehouse_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_warehouse`
--

LOCK TABLES `db_warehouse` WRITE;
/*!40000 ALTER TABLE `db_warehouse` DISABLE KEYS */;
INSERT INTO `db_warehouse` VALUES (1,1,'System','Warehouse-A','','warehouse_a@example.com',1,NULL),(2,2,'System','Shop Store','01775457008','info@elitedesign.com.bd',1,NULL),(87,2,'Custom','Godaount 2','01775457009','godaoun@elitedesign.com.bd',1,'2024-07-09'),(88,2,'Custom','df gsdf','','',1,'2024-07-16'),(89,2,'Custom','Av sda fasd','','',1,'2024-07-16'),(90,2,'Custom','Test','017888888878','sk@gmail.com',1,'2024-08-02'),(91,2,'Custom','Billal Treaders','1639720157','billal@gmail.com',1,'2024-08-19'),(92,3,'System','System Warehouse','','',1,'2026-09-30');
/*!40000 ALTER TABLE `db_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_warehouseitems`
--

DROP TABLE IF EXISTS `db_warehouseitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_warehouseitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `available_qty` double(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `warehouse_id` (`warehouse_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `db_warehouseitems_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `db_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_warehouseitems_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `db_warehouse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `db_warehouseitems_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `db_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4375 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_warehouseitems`
--

LOCK TABLES `db_warehouseitems` WRITE;
/*!40000 ALTER TABLE `db_warehouseitems` DISABLE KEYS */;
INSERT INTO `db_warehouseitems` VALUES (4299,2,87,14,10.00),(4328,2,2,8,9998993.00),(4330,2,2,7,99999008.00),(4335,2,2,4,99999797.00),(4345,2,2,5,9999999984.00),(4348,2,2,10,9998998.00),(4351,2,2,9,98996.00),(4355,2,2,6,999988.00),(4359,2,2,3,1098991.00),(4360,2,2,18,34.00),(4363,2,2,2,10098937.00),(4364,2,2,1,99998924.00),(4365,2,2,12,18.00),(4373,3,92,20,2.00),(4374,3,92,21,10.00);
/*!40000 ALTER TABLE `db_warehouseitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_warranty`
--

DROP TABLE IF EXISTS `db_warranty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_warranty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT 1,
  `warranty_code` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_id` int(11) DEFAULT 0,
  `sales_code` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `warranty_period_days` int(11) DEFAULT 0,
  `warranty_expiry_date` date DEFAULT NULL,
  `problem_description` text DEFAULT NULL,
  `accessories_received` text DEFAULT NULL,
  `product_condition` text DEFAULT NULL,
  `claim_date` date DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivered_to` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT 'Received',
  `technician_notes` text DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `service_charge` double(20,4) DEFAULT 0.0000,
  `parts_charge` double(20,4) DEFAULT 0.0000,
  `total_charge` double(20,4) DEFAULT 0.0000,
  `payment_type` varchar(50) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `warranty_code` (`warranty_code`),
  KEY `serial_no` (`serial_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_warranty`
--

LOCK TABLES `db_warranty` WRITE;
/*!40000 ALTER TABLE `db_warranty` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_warranty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_holdinvoice`
--

DROP TABLE IF EXISTS `temp_holdinvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_holdinvoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_qty` int(11) DEFAULT NULL,
  `item_price` double(10,2) DEFAULT NULL,
  `tax` double(10,2) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `system_ip` varchar(50) DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_holdinvoice`
--

LOCK TABLES `temp_holdinvoice` WRITE;
/*!40000 ALTER TABLE `temp_holdinvoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp_holdinvoice` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-01 18:52:03
