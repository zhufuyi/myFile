<?php

require('./config.php');

$gets = 0;
$hits = 0;
$mem = new memcache();

foreach ($srvmem as $k => $srv) {   // 获取所有服务器的cmd_get和get_hits的总和
    $mem->connect($srv['host'], $srv['port'], 2);   // 连接缓存服务器
    $res = $mem->getstats();  // 获取服务器状态
    $mem->close();  // 关闭连接

    $hits += $res['get_hits'];
    $gets += $res['cmd_get'];
}

$rate = 1;
if ($gets > 0) {
    $rate = $hits / $gets;
}

$f = fopen($_distr . '.txt', 'a');   // 把命中率数据写入文件中，方便生成静态图表
fwrite($f, ($rate * 100) . "\r\n");
fclose($f);

echo $rate; // 返回给ajax生成动态图表