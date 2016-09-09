<?php

$srvmem = array();
$ip = '127.0.0.1';
$srvmem['A'] = array('host' => $ip, 'port' => 11211);
$srvmem['B'] = array('host' => $ip, 'port' => 11212);
$srvmem['C'] = array('host' => $ip, 'port' => 11213);
$srvmem['D'] = array('host' => $ip, 'port' => 11214);
$srvmem['E'] = array('host' => $ip, 'port' => 11215);

$_distr = 'DHT';// DHT哈希一致性算法，MOD取模算法

$_keysize = 5000; // 向所有缓存服务器总共插入多少个key