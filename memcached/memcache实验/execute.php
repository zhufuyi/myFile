<?php

require('./distributed.php');
require('./config.php');

$mem = new memcache();
$distr = new $_distr();   // 动态变量

foreach ($srvmem as $k => $v) { // 添加服务器
    $distr->addNode($k);
}

$distr->delNode('C');   // 模拟突然有一台缓存服务器死机

echo 'getting data......<br>';

for ($i = 1; $i < $_keysize*10; $i++) {   // 轮循几圈get所有缓存服务器的key
    $key = sprintf('%dmdm', $i % $_keysize);  // 所有服务器key为1~999mdm
    $srv = $srvmem[$distr->lookup($key)];// 从key计算落点在那一台服务器上
    $mem->connect($srv['host'], $srv['port'], 2);   // 连接缓存服务器

    if (!$mem->get($key)) {    // 如果key不存在，则添加key到对应服务器
        $mem->add($key, 'val' . $i, 0, 0);
    }
    $mem->close();  // 关闭连接
    usleep(3000);   // 延时，防止太快访问造成连接不上

    if ($i % 200 == 0) { // 查看请求到哪个位置
        echo $i, "\n";
    }
}

echo "getting data over.\n";
