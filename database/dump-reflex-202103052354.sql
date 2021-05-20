-- MySQL dump 10.13  Distrib 5.7.33, for Linux (x86_64)
--
-- Host: localhost    Database: reflex
-- ------------------------------------------------------
-- Server version	5.7.33-0ubuntu0.18.04.1

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
-- Table structure for table `configuracao`
--

DROP TABLE IF EXISTS `configuracao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracao` (
  `id_data_warehouse` int(11) NOT NULL,
  `bo_diario` tinyint(1) DEFAULT '0',
  `bo_semanal` tinyint(1) DEFAULT '0',
  `bo_mensal` tinyint(1) DEFAULT '0',
  `dt_inicial` date DEFAULT NULL,
  `qt_registros` int(11) NOT NULL DEFAULT '1000',
  `hora` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bo_ativo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_data_warehouse`),
  KEY `fk_data_warehouse` (`id_data_warehouse`),
  CONSTRAINT `fk_data_warehouse` FOREIGN KEY (`id_data_warehouse`) REFERENCES `data_warehouse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracao`
--

LOCK TABLES `configuracao` WRITE;
/*!40000 ALTER TABLE `configuracao` DISABLE KEYS */;
INSERT INTO `configuracao` VALUES (18,1,NULL,NULL,'2021-02-15',1300,'14:12:00','2021-02-14 23:14:56','2021-02-15 18:31:18',1),(19,0,0,0,NULL,1000,NULL,'2021-02-14 23:17:18','2021-02-14 23:17:18',NULL),(20,0,0,0,NULL,1000,NULL,'2021-02-15 01:25:56','2021-02-15 01:25:56',NULL),(21,1,NULL,NULL,'2021-02-16',2,'15:00:00','2021-02-16 17:59:01','2021-02-16 18:00:16',1),(22,0,0,0,NULL,1000,NULL,'2021-02-16 18:10:11','2021-02-16 18:10:11',NULL),(23,0,0,0,NULL,1000,NULL,'2021-02-16 18:13:39','2021-02-16 18:13:39',NULL),(24,0,0,0,NULL,1000,NULL,'2021-02-16 18:16:01','2021-02-16 18:16:01',NULL),(25,0,0,0,NULL,1000,NULL,'2021-02-16 18:18:51','2021-02-16 18:18:51',NULL),(26,0,0,0,NULL,1000,NULL,'2021-02-16 18:23:21','2021-02-16 18:23:21',NULL),(27,1,NULL,NULL,'2021-02-16',2,'15:25:00','2021-02-16 18:24:30','2021-02-16 18:25:25',1),(28,1,NULL,NULL,'2021-02-16',1,'15:36:00','2021-02-16 18:33:59','2021-02-17 01:35:24',1),(29,0,0,0,NULL,1000,NULL,'2021-02-17 01:44:29','2021-02-17 01:44:29',NULL),(30,1,NULL,NULL,'2021-02-23',1000,'19:20:00','2021-02-17 01:48:17','2021-02-23 23:34:55',1),(31,1,NULL,NULL,'2021-02-25',10,'19:30:00','2021-02-24 02:32:23','2021-02-25 22:44:45',1),(32,0,0,0,NULL,1000,NULL,'2021-03-04 18:09:51','2021-03-04 18:09:51',NULL),(33,0,0,0,NULL,1000,NULL,'2021-03-04 18:12:18','2021-03-04 18:12:18',NULL),(34,0,0,0,NULL,1000,NULL,'2021-03-04 18:27:52','2021-03-04 18:27:52',NULL);
/*!40000 ALTER TABLE `configuracao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracao_database`
--

DROP TABLE IF EXISTS `configuracao_database`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracao_database` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_database` text NOT NULL,
  `driver` text NOT NULL,
  `usuario` text,
  `password` text,
  `host` text,
  `port` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` text,
  `charset` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracao_database`
--

LOCK TABLES `configuracao_database` WRITE;
/*!40000 ALTER TABLE `configuracao_database` DISABLE KEYS */;
INSERT INTO `configuracao_database` VALUES (1,'siagesc','mysql','root','@superadmin','localhost','3306','2020-05-02 19:11:29','2021-03-06 02:28:49','host','utf8'),(2,'siagesc2','mysql','root','@superadmin','localhost','3306','2020-05-02 19:11:29','2021-03-06 02:35:48','serve','utf8');
/*!40000 ALTER TABLE `configuracao_database` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracao_transferencia`
--

DROP TABLE IF EXISTS `configuracao_transferencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracao_transferencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_data_warehouse` int(11) NOT NULL,
  `obj_pacote_atual` json DEFAULT NULL,
  `obj_key_atual` json NOT NULL,
  `obj_pacote_total` json NOT NULL,
  `ds_status` text,
  `dt_final` timestamp NULL DEFAULT NULL,
  `bo_ativo` tinyint(1) NOT NULL DEFAULT '1',
  `bo_finalizado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_id_data_warehouse` (`id_data_warehouse`),
  CONSTRAINT `fk_id_data_warehouse` FOREIGN KEY (`id_data_warehouse`) REFERENCES `configuracao` (`id_data_warehouse`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracao_transferencia`
--

LOCK TABLES `configuracao_transferencia` WRITE;
/*!40000 ALTER TABLE `configuracao_transferencia` DISABLE KEYS */;
INSERT INTO `configuracao_transferencia` VALUES (7,28,'{\"caixa_dw\": 0, \"empresa_dw\": 0}','{\"caixa_dw\": 0, \"empresa_dw\": 0}','{\"caixa_dw\": 9, \"empresa_dw\": 4}',NULL,NULL,1,1,'2021-02-17 01:35:29','2021-02-17 01:35:29'),(8,30,'{\"caixa_dw\": 0}','{\"caixa_dw\": 0}','{\"caixa_dw\": 1}',NULL,NULL,1,1,'2021-02-23 23:10:11','2021-02-23 23:10:11'),(9,31,'{\"caixa_dw\": 0, \"empresa_dw\": 0}','{\"caixa_dw\": 14, \"empresa_dw\": 4}','{\"caixa_dw\": 1, \"empresa_dw\": 1}',NULL,NULL,1,1,'2021-02-24 02:34:13','2021-02-25 22:32:20');
/*!40000 ALTER TABLE `configuracao_transferencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_warehouse`
--

DROP TABLE IF EXISTS `data_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` json DEFAULT NULL,
  `serve` json DEFAULT NULL,
  `ddl` text,
  `tabela` text,
  `join` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ds_data_warehouse` text,
  `no_data_warehouse` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_warehouse`
--

LOCK TABLES `data_warehouse` WRITE;
/*!40000 ALTER TABLE `data_warehouse` DISABLE KEYS */;
INSERT INTO `data_warehouse` VALUES (18,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_fantasia` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"cliente_fornecedor_dw\"]','select cliente_fornecedor.no_fantasia from cliente_fornecedor','2021-02-14 23:14:54','2021-02-14 23:14:54','teste','teste'),(19,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_fantasia` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"cliente_fornecedor_dw\"]','select cliente_fornecedor.no_fantasia from cliente_fornecedor','2021-02-14 23:17:11','2021-02-14 23:17:11','teste','teste'),(20,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_fantasia` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"caixa_dw\"]','select caixa.no_caixa,empresa.no_fantasia,empresa.id,caixa.id_empresa from caixa left join empresa on(empresa.id=caixa.id_empresa)','2021-02-15 01:25:56','2021-02-15 01:25:56','teste2','teste2'),(21,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text,\\n  `no_fantasia` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"caixa_dw\"]','select caixa.no_caixa,empresa.nu_cnpj,no_fantasia,empresa.id,caixa.id_empresa from caixa left join empresa on(empresa.id=caixa.id_empresa)','2021-02-16 17:58:58','2021-02-16 17:58:58','teste','Banco e empresa'),(22,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `tp_pessoa` text,\\n  `no_razao_social` text,\\n  `no_fantasia` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"cliente_fornecedor_dw\"]','select cliente_fornecedor.tp_pessoa,no_razao_social,no_fantasia,empresa.nu_cnpj,empresa.id,cliente_fornecedor.id_empresa from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa)','2021-02-16 18:10:11','2021-02-16 18:10:11','teste','clientes'),(23,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `tp_pessoa` text,\\n  `no_razao_social` text,\\n  `no_fantasia` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"cliente_fornecedor_dw\"]','select cliente_fornecedor.tp_pessoa,cliente_fornecedor.no_razao_social,cliente_fornecedor.no_fantasia,empresa.nu_cnpj,empresa.id,cliente_fornecedor.id_empresa from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa)','2021-02-16 18:13:39','2021-02-16 18:13:39','teste','clientes'),(24,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `tp_pessoa` text,\\n  `no_razao_social` text,\\n  `no_fantasia` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"cliente_fornecedor_dw\"]','select cliente_fornecedor.tp_pessoa,cliente_fornecedor.no_razao_social,cliente_fornecedor.no_fantasia,empresa.nu_cnpj,empresa.id,cliente_fornecedor.id_empresa from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa)','2021-02-16 18:16:01','2021-02-16 18:16:01','teste','clientes'),(25,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `tp_pessoa` text,\\n  `no_razao_social` text,\\n  `no_fantasia` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"cliente_fornecedor_dw\"]','select cliente_fornecedor.tp_pessoa,cliente_fornecedor.no_razao_social,cliente_fornecedor.no_fantasia,empresa.nu_cnpj,empresa.id,cliente_fornecedor.id_empresa from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa)','2021-02-16 18:18:51','2021-02-16 18:18:51','teste','clientes'),(26,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `tp_pessoa` text,\\n  `no_razao_social` text,\\n  `no_fantasia` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"cliente_fornecedor_dw\"]','select cliente_fornecedor.tp_pessoa,cliente_fornecedor.no_razao_social,cliente_fornecedor.no_fantasia,empresa.nu_cnpj,cliente_fornecedor.id,empresa.id,cliente_fornecedor.id_empresa from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa)','2021-02-16 18:23:21','2021-02-16 18:23:21','teste','clientes'),(27,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `tp_pessoa` text,\\n  `no_razao_social` text,\\n  `no_fantasia` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"cliente_fornecedor_dw\"]','select cliente_fornecedor.tp_pessoa as cliente_fornecedor.tp_pessoa,cliente_fornecedor.no_razao_social as cliente_fornecedor.no_razao_social,cliente_fornecedor.no_fantasia as cliente_fornecedor.no_fantasia,empresa.nu_cnpj as empresa.nu_cnpj,cliente_fornecedor.id as cliente_fornecedor.id,empresa.id as empresa.id, cliente_fornecedor.id_empresa as cliente_fornecedor.id_empresa from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa)','2021-02-16 18:24:30','2021-02-16 18:24:30','teste','clientes'),(28,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_fantasia` text,\\n  `nu_cnpj` text\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  `id_empresa` int(10) unsigned NOT NULL\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"empresa_dw\",\"caixa_dw\"]','select  caixa.no_caixa as \'caixa.no_caixa\', empresa.no_fantasia as \'empresa.no_fantasia\', empresa.nu_cnpj as \'empresa.nu_cnpj\', caixa.id as \'caixa.id\', empresa.id as \'empresa.id\', caixa.id_empresa as \'caixa.id_empresa\' from caixa left join empresa on(empresa.id=caixa.id_empresa)','2021-02-16 18:33:59','2021-02-16 18:33:59','ttt','caxia e empresa'),(29,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','[\"caixa_dw\"]','select  caixa.no_caixa as \'caixa.no_caixa\', caixa.id as \'caixa.id\' from caixa','2021-02-17 01:44:29','2021-02-17 01:44:29','1231233','asdasdsd'),(30,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','{\"caixa_dw\":[\"no_caixa\"]}','select  caixa.no_caixa as \'caixa.no_caixa\', caixa.id as \'caixa.id\' from caixa','2021-02-17 01:48:17','2021-02-17 01:48:17','1231233','asdasdsd'),(31,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text,\\n  `no_fantasia` text,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  `id_empresa` int(11) DEFAULT NULL,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','{\"empresa_dw\":[\"nu_cnpj\",\"no_fantasia\"],\"caixa_dw\":[\"no_caixa\",\"id_empresa\"]}','select  caixa.no_caixa as \'caixa.no_caixa\', caixa.id_empresa as \'caixa.id_empresa\', empresa.nu_cnpj as \'empresa.nu_cnpj\', empresa.no_fantasia as \'empresa.no_fantasia\', caixa.id as \'caixa.id\', empresa.id as \'empresa.id\', caixa.id_empresa as \'caixa.id_empresa\' from caixa left join empresa on(empresa.id=caixa.id_empresa)','2021-02-24 02:32:23','2021-02-24 02:32:23','Teste de transferencia','Teste de transferencia'),(32,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"log_localidade_dw\",\"Create Table\":\"CREATE TABLE `log_localidade_dw` (\\n  `id` int(11) NOT NULL,\\n  `nome` text,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"endereco_dw\",\"Create Table\":\"CREATE TABLE `endereco_dw` (\\n  `id` int(11) NOT NULL,\\n  `ds_endereco` text,\\n  `id_cidade` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_cidade` (`id_cidade`),\\n  CONSTRAINT `endereco_dw_ibfk_1` FOREIGN KEY (`id_cidade`) REFERENCES `log_localidade_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text,\\n  `id_endereco` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_endereco` (`id_endereco`),\\n  CONSTRAINT `empresa_dw_ibfk_1` FOREIGN KEY (`id_endereco`) REFERENCES `endereco_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cpf_cnpj` text,\\n  `no_razao_social` text,\\n  `id_empresa` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_empresa` (`id_empresa`),\\n  CONSTRAINT `cliente_fornecedor_dw_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=utf8\"}]','{\"log_localidade_dw\":[\"nome\"],\"endereco_dw\":[\"ds_endereco\"],\"empresa_dw\":[\"nu_cnpj\"],\"cliente_fornecedor_dw\":[\"nu_cpf_cnpj\",\"no_razao_social\"]}','select  cliente_fornecedor.nu_cpf_cnpj as \'cliente_fornecedor.nu_cpf_cnpj\', cliente_fornecedor.no_razao_social as \'cliente_fornecedor.no_razao_social\', empresa.nu_cnpj as \'empresa.nu_cnpj\', endereco.ds_endereco as \'endereco.ds_endereco\', log_localidade.nome as \'log_localidade.nome\', cliente_fornecedor.id as \'cliente_fornecedor.id\', empresa.id as \'empresa.id\', cliente_fornecedor.id_empresa as \'cliente_fornecedor.id_empresa\', endereco.id as \'endereco.id\', empresa.id_endereco as \'empresa.id_endereco\', log_localidade.id as \'log_localidade.id\', endereco.id_cidade as \'endereco.id_cidade\' from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa) left join endereco on(endereco.id=empresa.id_endereco) left join log_localidade on(log_localidade.id=endereco.id_cidade)','2021-03-04 18:09:51','2021-03-04 18:09:51','teste','teste'),(33,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"log_localidade_dw\",\"Create Table\":\"CREATE TABLE `log_localidade_dw` (\\n  `id` int(11) NOT NULL,\\n  `nome` text,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=latin1\"},{\"Table\":\"endereco_dw\",\"Create Table\":\"CREATE TABLE `endereco_dw` (\\n  `id` int(11) NOT NULL,\\n  `id_cidade` int(11) DEFAULT NULL,\\n  PRIMARY KEY (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=latin1\"},{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text,\\n  `id_endereco` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_endereco` (`id_endereco`),\\n  CONSTRAINT `empresa_dw_ibfk_1` FOREIGN KEY (`id_endereco`) REFERENCES `endereco_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=latin1\"},{\"Table\":\"cliente_fornecedor_dw\",\"Create Table\":\"CREATE TABLE `cliente_fornecedor_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cpf_cnpj` text,\\n  `no_razao_social` text,\\n  `id_empresa` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_empresa` (`id_empresa`),\\n  CONSTRAINT `cliente_fornecedor_dw_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=latin1\"}]','{\"log_localidade_dw\":[\"nome\"],\"endereco_dw\":[\"id_cidade\"],\"empresa_dw\":[\"nu_cnpj\"],\"cliente_fornecedor_dw\":[\"nu_cpf_cnpj\",\"no_razao_social\"]}','select  cliente_fornecedor.nu_cpf_cnpj as \'cliente_fornecedor.nu_cpf_cnpj\', cliente_fornecedor.no_razao_social as \'cliente_fornecedor.no_razao_social\', empresa.nu_cnpj as \'empresa.nu_cnpj\', endereco.id_cidade as \'endereco.id_cidade\', log_localidade.nome as \'log_localidade.nome\', cliente_fornecedor.id as \'cliente_fornecedor.id\', empresa.id as \'empresa.id\', cliente_fornecedor.id_empresa as \'cliente_fornecedor.id_empresa\', endereco.id as \'endereco.id\', empresa.id_endereco as \'empresa.id_endereco\', log_localidade.id as \'log_localidade.id\', endereco.id_cidade as \'endereco.id_cidade\' from cliente_fornecedor left join empresa on(empresa.id=cliente_fornecedor.id_empresa) left join endereco on(endereco.id=empresa.id_endereco) left join log_localidade on(log_localidade.id=endereco.id_cidade)','2021-03-04 18:12:18','2021-03-04 18:12:18','teste','cliente e cidade'),(34,'{\"id\": 1, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"host\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc\"}','{\"id\": 2, \"host\": \"localhost\", \"port\": \"3306\", \"type\": \"serve\", \"driver\": \"mysql\", \"usuario\": \"root\", \"password\": \"@superadmin\", \"created_at\": \"2020-05-02 16:11:29\", \"updated_at\": \"2020-05-02 16:14:39\", \"no_database\": \"siagesc2\"}','[{\"Table\":\"empresa_dw\",\"Create Table\":\"CREATE TABLE `empresa_dw` (\\n  `id` int(11) NOT NULL,\\n  `nu_cnpj` text,\\n  `id_endereco` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_endereco` (`id_endereco`),\\n  CONSTRAINT `empresa_dw_ibfk_1` FOREIGN KEY (`id_endereco`) REFERENCES `endereco_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=latin1\"},{\"Table\":\"caixa_dw\",\"Create Table\":\"CREATE TABLE `caixa_dw` (\\n  `id` int(11) NOT NULL,\\n  `no_caixa` text,\\n  `id_empresa` int(11) NOT NULL,\\n  PRIMARY KEY (`id`),\\n  KEY `id_empresa` (`id_empresa`),\\n  CONSTRAINT `caixa_dw_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa_dw` (`id`)\\n) ENGINE=InnoDB DEFAULT CHARSET=latin1\"}]','{\"empresa_dw\":[\"nu_cnpj\"],\"caixa_dw\":[\"no_caixa\"]}','select  caixa.no_caixa as \'caixa.no_caixa\', empresa.nu_cnpj as \'empresa.nu_cnpj\', caixa.id as \'caixa.id\', empresa.id as \'empresa.id\', caixa.id_empresa as \'caixa.id_empresa\' from caixa left join empresa on(empresa.id=caixa.id_empresa)','2021-03-04 18:27:52','2021-03-04 18:27:52','teste','empresa e caixa');
/*!40000 ALTER TABLE `data_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_fantasia` text NOT NULL,
  `nu_cnpj` varchar(14) NOT NULL,
  `no_razao_social` text,
  `nu_inscricao_estadual` varchar(11) DEFAULT NULL,
  `nu_inscricao_municipal` varchar(11) DEFAULT NULL,
  `id_empresa_dados_fiscais` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `img` text,
  `id_endereco` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cnpj_UNIQUE` (`nu_cnpj`),
  KEY `fk_empresa_empresa_dados_fiscais_aliquota1_idx` (`id_empresa_dados_fiscais`),
  KEY `empresa_endereco_FK` (`id_endereco`),
  CONSTRAINT `empresa_endereco_FK` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id`),
  CONSTRAINT `fk_empresa_empresa_dados_fiscais_aliquota1` FOREIGN KEY (`id_empresa_dados_fiscais`) REFERENCES `empresa_dados_fiscais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'CONSTRUNORTE MATERIAIS DE CONSTRUCAO','31910411000148','W P GONCALVES MATERIAIS DE CONSTRUCAO EIRELI','240353412',NULL,1,'2019-06-20 16:51:02','2020-02-27 13:03:49','130349_20200227_33b869f90619e81763dbf1fccc896d8d.jpg',1),(2,'Geracell','36399883000100','Geracell Celular e informática','0000002',NULL,2,'2020-01-11 10:57:42','2020-04-27 14:23:37','182517_20200111_images.jpeg',142),(3,'Center Motos','000000000001','Center Motos','000000001','',3,'2020-02-27 09:23:44','2020-02-27 09:23:44','',340),(4,'Center Tintas','000000000002','Center Tintas','000000002',NULL,4,'2020-03-06 16:45:35','2020-03-06 16:49:40','',341);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_funcionario` text NOT NULL,
  `bo_fisico` tinyint(1) DEFAULT NULL,
  `no_pai` text,
  `no_mae` text,
  `dt_nascimento` date DEFAULT NULL,
  `bo_ativo` tinyint(1) DEFAULT '1',
  `cargo_funcionario` text,
  `id_dados_bancarios` int(11) DEFAULT NULL,
  `vl_salario` decimal(10,2) DEFAULT NULL,
  `porcentagem_comissao` decimal(5,2) DEFAULT NULL,
  `tp_comissao` text,
  `ds_observacao` text,
  `id_grupo_permissao` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_empresa` varchar(100) NOT NULL,
  `img` text,
  `login` text,
  `password` text,
  `nu_cpf_cnpj` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_funcionario_dados_bancarios1_idx` (`id_dados_bancarios`),
  KEY `funcionario_grupo_permissao_FK` (`id_grupo_permissao`),
  CONSTRAINT `fk_funcionario_dados_bancarios1` FOREIGN KEY (`id_dados_bancarios`) REFERENCES `dados_bancarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `funcionario_grupo_permissao_FK` FOREIGN KEY (`id_grupo_permissao`) REFERENCES `grupo_permissao` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
INSERT INTO `funcionario` VALUES (1,'Administrador',1,NULL,NULL,'1998-12-16',1,'admin',1,2000.00,10.00,'cv',NULL,1,'2019-06-20 16:57:40','2020-02-18 15:02:50','1','150250_20200218_photo_2019-12-27_18-05-01.jpg','admin','$2y$10$tUin0mQr6He/vZizYd6DM.V1c1lU1Xk/S2F.bliSHQJFf8qoOkG7K','06866397154'),(6,'Kleber de Souza',NULL,NULL,NULL,'2019-04-17',1,'Servente',12,2000.00,10.00,'cv',NULL,1,'2019-07-26 19:40:09','2020-04-17 19:34:09','1','205649_20200108_15957216.jpeg','bitter','$2y$10$5kQiwtIvSX7SXKolP8OwMuG7auGyzkQa1MmCxtaZIBg/kM4b3PA5C','97259122099'),(7,'Carlos Magno',NULL,'Leicimar','Marcia','2019-12-07',1,'Gerente Geral',13,2500.00,5.00,'cv',NULL,1,'2019-07-26 20:55:38','2019-12-09 20:49:37','1','165004_20191002_github.png','carlos','$2y$10$55FQ1Ejp6UWTBKcep7k9wOFVEkK2gWuq4sMsBoPDDgGxHqTx.zWVC','88772762071'),(8,'Geracell',1,'','','1990-01-11',1,'CEO',14,0.00,0.00,'sc','',3,'2020-01-11 10:57:42','2020-01-11 10:57:42','2','','geracell','$2y$10$xfeHuMjTCPLeAEw8B4lZi.WsR.5obKY6.ZB8uLlG65cSGo9u8ORFa','19818657055'),(9,'Administrador',NULL,NULL,NULL,'1993-02-02',1,'Admin',15,NULL,NULL,'sc',NULL,3,'2020-01-11 11:08:24','2020-02-21 18:16:41','2',NULL,'geracelladmin','$2y$10$yuyLMS3JRGI2gwU9Xp1bj.3LXaypV2wehSw65NKIIqPdEGOGZpJNK','69384709000'),(10,'Thyerre Rangel Morais da Silva',NULL,'Leicimar','Marcia','1998-04-15',1,NULL,16,2000.00,NULL,'sc',NULL,1,'2020-01-28 16:45:59','2020-04-23 21:59:14','1',NULL,'thyerre','$2y$10$LppATpfEixV55c/IA2iBfOq0NmXhIMK95qs5EYzk1VfYoKWIKn1My','73456141076'),(11,'MARIA EDUARDA DIVINA',NULL,NULL,NULL,'2000-05-08',1,NULL,17,NULL,NULL,'sc',NULL,3,'2020-01-28 17:44:12','2020-01-28 17:44:12','2',NULL,'duda','$2y$10$Bq8I6Tymf7yhebxf3j9DSuyMx0jbSsJxqb30NhBgn.ZxHy.wDCSQy','09226594198'),(12,'Alessandro',1,'','','1990-10-10',1,'CEO',18,0.00,0.00,'sc','',5,'2020-02-27 09:23:44','2020-02-27 09:23:44','3','','alessandro','$2y$10$mKOBUs2XYY3vL3nApJ3cAekaxUu6dEPIaawWf60AbFgoen.zAd8WW','0000000001'),(13,'Claiton',1,'','','1990-10-10',1,'CEO',19,0.00,0.00,'sc','',7,'2020-03-06 16:45:35','2020-03-06 16:45:35','4','','claiton','$2y$10$FrhC6Cpgy8q4Vwk9og3K4OcUunM9eWv24DiWvzoZzJ1H9xA1ypmom','0000000001');
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_permissao`
--

DROP TABLE IF EXISTS `grupo_permissao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_permissao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_grupo_permissao` text,
  `id_empresa` int(11) DEFAULT NULL,
  `bo_ativo` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_permissao`
--

LOCK TABLES `grupo_permissao` WRITE;
/*!40000 ALTER TABLE `grupo_permissao` DISABLE KEYS */;
INSERT INTO `grupo_permissao` VALUES (1,'ADMIN',1,1,'2019-06-20 16:56:31','2019-08-26 13:09:18'),(2,'PDV - Ponto de venda',1,1,'2019-10-02 19:50:41','2019-12-09 19:55:13'),(3,'Admin',2,1,'2020-01-11 10:57:42','2020-01-11 10:57:42'),(4,'PDV - Ponto de venda',2,1,'2020-01-11 10:57:42','2020-01-11 10:57:42'),(5,'Admin',3,1,'2020-02-27 09:23:44','2020-02-27 09:23:44'),(6,'PDV - Ponto de venda',3,1,'2020-02-27 09:23:44','2020-02-27 09:23:44'),(7,'Admin',4,1,'2020-03-06 16:45:35','2020-03-06 16:45:35'),(8,'PDV - Ponto de venda',4,1,'2020-03-06 16:45:35','2020-03-06 16:45:35');
/*!40000 ALTER TABLE `grupo_permissao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_permissao_rotina`
--

DROP TABLE IF EXISTS `grupo_permissao_rotina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_permissao_rotina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rotina` int(11) NOT NULL,
  `id_grupo_permissao` int(11) NOT NULL,
  `bo_create` tinyint(4) DEFAULT NULL,
  `bo_read` tinyint(4) DEFAULT NULL,
  `bo_show` int(11) DEFAULT NULL,
  `bo_update` tinyint(4) DEFAULT NULL,
  `bo_delete` tinyint(4) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_permissao_rotina_grupo_permissao` (`id_grupo_permissao`),
  KEY `fk_grupo_permissao_rotina_id_rotina` (`id_rotina`),
  CONSTRAINT `fk_grupo_permissao_rotina_grupo_permissao` FOREIGN KEY (`id_grupo_permissao`) REFERENCES `grupo_permissao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_permissao_rotina_id_rotina` FOREIGN KEY (`id_rotina`) REFERENCES `tb_sistema_rotina` (`cd_sistema_rotina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_permissao_rotina`
--

LOCK TABLES `grupo_permissao_rotina` WRITE;
/*!40000 ALTER TABLE `grupo_permissao_rotina` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_permissao_rotina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=1379 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1121,'default','{\"displayName\":\"App\\\\Jobs\\\\ConfiguracaoTransferencia\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ConfiguracaoTransferencia\",\"command\":\"O:34:\\\"App\\\\Jobs\\\\ConfiguracaoTransferencia\\\":8:{s:53:\\\"\\u0000App\\\\Jobs\\\\ConfiguracaoTransferencia\\u0000id_data_warehouse\\\";s:2:\\\"31\\\";s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";i:-780;s:7:\\\"chained\\\";a:0:{}}\"}}',5,1614293698,1614292214,1614292994),(1377,'default','{\"displayName\":\"App\\\\Jobs\\\\ConfiguracaoTransferencia\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ConfiguracaoTransferencia\",\"command\":\"O:34:\\\"App\\\\Jobs\\\\ConfiguracaoTransferencia\\\":8:{s:53:\\\"\\u0000App\\\\Jobs\\\\ConfiguracaoTransferencia\\u0000id_data_warehouse\\\";s:2:\\\"31\\\";s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";i:-780;s:7:\\\"chained\\\";a:0:{}}\"}}',2,1614293496,1614292230,1614293010),(1378,'default','{\"displayName\":\"App\\\\Jobs\\\\ConfiguracaoTransferencia\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ConfiguracaoTransferencia\",\"command\":\"O:34:\\\"App\\\\Jobs\\\\ConfiguracaoTransferencia\\\":8:{s:53:\\\"\\u0000App\\\\Jobs\\\\ConfiguracaoTransferencia\\u0000id_data_warehouse\\\";s:2:\\\"31\\\";s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";i:-840;s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1614292245,1614293085);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2021_02_15_124756_create_jobs_table',1),(2,'2021_02_15_125345_create_failed_jobs_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_sistema_modulo`
--

DROP TABLE IF EXISTS `tb_sistema_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_sistema_modulo` (
  `cd_sistema_modulo` int(11) NOT NULL,
  `no_modulo` text,
  `icone` text,
  `bo_ativo` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cd_sistema_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_sistema_modulo`
--

LOCK TABLES `tb_sistema_modulo` WRITE;
/*!40000 ALTER TABLE `tb_sistema_modulo` DISABLE KEYS */;
INSERT INTO `tb_sistema_modulo` VALUES (1,'Geral',NULL,1,'2019-06-20 16:28:05','2019-06-20 16:28:05'),(2,'Relatórios',NULL,1,'2019-09-19 20:01:49','2019-09-19 20:01:49');
/*!40000 ALTER TABLE `tb_sistema_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_sistema_rotina`
--

DROP TABLE IF EXISTS `tb_sistema_rotina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_sistema_rotina` (
  `cd_sistema_rotina` int(11) NOT NULL AUTO_INCREMENT,
  `cd_sistema_modulo` int(11) NOT NULL,
  `no_rotina` text,
  `ds_rotina` text,
  `no_arquivo` text,
  `ds_url` text,
  `icon` text,
  `bo_ativo` tinyint(4) DEFAULT '1',
  `bo_mostrar_menu` tinyint(4) DEFAULT NULL,
  `nu_ordem` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cd_sistema_rotina`),
  KEY `fk_tb_sistema_rotina_tb_sistema_modulo1_idx` (`cd_sistema_modulo`),
  CONSTRAINT `fk_tb_sistema_rotina_tb_sistema_modulo1` FOREIGN KEY (`cd_sistema_modulo`) REFERENCES `tb_sistema_modulo` (`cd_sistema_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_sistema_rotina`
--

LOCK TABLES `tb_sistema_rotina` WRITE;
/*!40000 ALTER TABLE `tb_sistema_rotina` DISABLE KEYS */;
INSERT INTO `tb_sistema_rotina` VALUES (13,1,'Data Warehouse',NULL,NULL,'data-warehouse','sidebar-window',1,1,1,'2019-06-20 16:28:06','2019-06-20 16:28:07'),(16,1,'Configuração de Migração',NULL,NULL,'configuracao','gear',1,1,6,'2019-06-20 16:28:06','2019-06-20 16:28:07'),(17,1,'Montar DW',NULL,NULL,'compra','database',0,1,4,'2019-06-20 16:28:06','2019-06-20 16:28:07'),(42,1,'Home',NULL,NULL,'dashboard','layout-grid',0,1,0,'2019-06-20 16:28:06','2019-06-20 16:28:07');
/*!40000 ALTER TABLE `tb_sistema_rotina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text,
  `password` text,
  `id_funcionario` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_funcionario1_idx` (`id_funcionario`),
  CONSTRAINT `fk_usuario_funcionario1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'reflex'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-05 23:54:55
