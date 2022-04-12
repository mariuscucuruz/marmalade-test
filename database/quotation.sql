
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `quotation`;

USE quotation;

-- ----------------------------
--  Table structure for `abi_code_rating`
-- ----------------------------
DROP TABLE IF EXISTS `abi_code_rating`;
CREATE TABLE `abi_code_rating` (
  `abi_code` varchar(10) NOT NULL,
  `rating_factor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`abi_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `abi_code_rating`
-- ----------------------------
BEGIN;
INSERT INTO `abi_code_rating` VALUES ('22529902', '0.95'), ('46545255', '1.15'), ('52123803', '1.20');
COMMIT;

-- ----------------------------
--  Table structure for `age_rating`
-- ----------------------------
DROP TABLE IF EXISTS `age_rating`;
CREATE TABLE `age_rating` (
  `age` int(11) NOT NULL,
  `rating_factor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`age`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `age_rating`
-- ----------------------------
BEGIN;
INSERT INTO `age_rating` VALUES ('17', '1.50'), ('18', '1.40'), ('19', '1.30'), ('20', '1.20'), ('21', '1.10'), ('22', '1.00'), ('23', '0.95'), ('24', '0.90'), ('25', '0.75');
COMMIT;

-- ----------------------------
--  Table structure for `postcode_rating`
-- ----------------------------
DROP TABLE IF EXISTS `postcode_rating`;
CREATE TABLE `postcode_rating` (
  `postcode_area` varchar(4) NOT NULL,
  `rating_factor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`postcode_area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `postcode_rating`
-- ----------------------------
BEGIN;
INSERT INTO `postcode_rating` VALUES ('LE10', '1.35'), ('PE3', '1.10'), ('WR2', '0.90');
COMMIT;
