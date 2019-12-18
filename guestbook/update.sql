DROP TABLE IF EXISTS `session_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sess_id` char(64) NOT NULL,
  `key` varchar(254) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
CREATE UNIQUE INDEX `sess_id` ON `session_storage` (`sess_id`);
