-- --------------------------------------------------------

-- 
-- Table structure for table `opt`
-- 

CREATE TABLE `opt` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`name`)
);

-- 
-- Dumping data for table `opt`
-- 

INSERT INTO `opt` (`name`, `value`) VALUES ('attack_mode', '0'),
('cmd', 'wait'),
('http_freq', '100'),
('http_threads', '3'),
('icmp_freq', '10'),
('icmp_size', '2000'),
('max_sessions', '30'),
('spoof_ip', '0'),
('syn_freq', '10'),
('tcpudp_freq', '20'),
('tcp_size', '2000'),
('udp_size', '1000'),
('ufreq', '1');

-- --------------------------------------------------------

-- 
-- Table structure for table `stat`
-- 

CREATE TABLE `stat` (
  `id` varchar(50) NOT NULL,
  `addr` varchar(16) NOT NULL,
  `time` int(11) NOT NULL,
  `build` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

