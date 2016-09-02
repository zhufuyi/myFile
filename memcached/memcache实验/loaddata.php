<?php

require('./config.php');
require('./distributed.php');

$mem = new memcache();
$distr = new $_distr(); // 动态变量

foreach ($srvmem as $k => $v) { // 添加服务器
    $distr->addNode($k);
}

for ($i = 1; $i < $_keysize; $i++) {    // 填充数据到服务器
    $key = sprintf('%dmdm', $i);   // key名称
    $srv = $srvmem[$distr->lookup($key)];// 从key计算落点在那一台服务器上
    $mem->connect($srv['host'], $srv['port'], 2);// 连接缓存服务器
    $mem->add($key, 'val' . $i, 0, 0);   // 添加key
    $mem->close();  // 关闭连接
    usleep(5000);   // 延时，防止太快访问造成连接不上
}

echo 'Add key-value over.';

