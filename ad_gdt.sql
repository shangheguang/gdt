-- phpMyAdmin SQL Dump
-- version 4.4.15.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-04-12 19:08:58
-- 服务器版本： 5.7.9-log
-- PHP Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: ``
--

-- --------------------------------------------------------

--
-- 表的结构 `ad_gdt`
--

CREATE TABLE IF NOT EXISTS `ad_gdt` (
  `id` int(11) NOT NULL,
  `muid` varchar(50) NOT NULL DEFAULT '' COMMENT 'muid',
  `click_time` int(11) NOT NULL DEFAULT '0' COMMENT '点击事件',
  `appid` int(11) NOT NULL DEFAULT '0' COMMENT 'appid',
  `app_type` varchar(10) NOT NULL DEFAULT '',
  `advertiser_id` int(11) NOT NULL DEFAULT '0',
  `click_id` varchar(50) NOT NULL DEFAULT '',
  `content` text,
  `report_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上报[0:未上报，1:已上报]',
  `create_ip` varchar(15) NOT NULL DEFAULT '',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ad_gdt`
--

INSERT INTO `ad_gdt` (`id`, `muid`, `click_time`, `appid`, `app_type`, `advertiser_id`, `click_id`, `content`, `report_status`, `create_ip`, `create_date`) VALUES
(1, '02b5c6bad8b62e3fc9faa422225269b0', 1460347757, 1057842207, 'ios', 1202221, '382b004aafab963708a5c44030f2a1c1', 'array (\n  ''muid'' => ''02b5c6bad8b62e3fc9faa422225269b0'',\n  ''click_time'' => ''1460347757'',\n  ''appid'' => ''1057842207'',\n  ''click_id'' => ''382b004aafab963708a5c44030f2a1c1'',\n  ''app_type'' => ''ios'',\n  ''advertiser_id'' => ''1202221'',\n  ''ac'' => ''gdt'',\n)', 0, '59.37.97.102', '2016-04-11 12:09:19'),
(2, '0440b70df0a82bdaf77b45b2c5501b20', 1460352312, 1057842207, 'ios', 1202221, 'aga6svrxwqq3cttkmoiq', 'array (\n  ''appid'' => ''1057842207'',\n  ''app_type'' => ''ios'',\n  ''click_id'' => ''aga6svrxwqq3cttkmoiq'',\n  ''click_time'' => ''1460352312'',\n  ''muid'' => ''0440b70df0a82bdaf77b45b2c5501b20'',\n  ''advertiser_id'' => ''1202221'',\n  ''ac'' => ''gdt'',\n)', 0, '14.17.3.32', '2016-04-11 13:25:13'),
(3, '02b5c6bad8b62e3fc9faa422225269b0', 1460357041, 1057842207, 'ios', 1202221, '7821b35795be7be9d01af9ec21149ed8', 'array (\n  ''muid'' => ''02b5c6bad8b62e3fc9faa422225269b0'',\n  ''click_time'' => ''1460357041'',\n  ''appid'' => ''1057842207'',\n  ''click_id'' => ''7821b35795be7be9d01af9ec21149ed8'',\n  ''app_type'' => ''ios'',\n  ''advertiser_id'' => ''1202221'',\n  ''ac'' => ''gdt_notify'',\n)', 1, '59.37.97.108', '2016-04-11 14:44:01'),
(4, 'ff7f6a81d34d60f1366b6611c05bce92', 1460357668, 1057842207, 'ios', 1202221, '8152871c8751cdcf1d3c7937cd436b19', 'array (\n  ''muid'' => ''ff7f6a81d34d60f1366b6611c05bce92'',\n  ''click_time'' => ''1460357668'',\n  ''appid'' => ''1057842207'',\n  ''click_id'' => ''8152871c8751cdcf1d3c7937cd436b19'',\n  ''app_type'' => ''ios'',\n  ''advertiser_id'' => ''1202221'',\n  ''ac'' => ''gdt_notify'',\n)', 0, '59.37.97.117', '2016-04-11 14:54:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_gdt`
--
ALTER TABLE `ad_gdt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad_gdt`
--
ALTER TABLE `ad_gdt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
