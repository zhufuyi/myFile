<?php

function miConn(){   // 初始化数据库
    static $conn=null;
    if ($conn===null){
        $conn=new mysqli("192.168.8.102","root","123456","schedule"); // 连接数据库
        if ($conn->connect_errno) {
            echo "Connect failed: ".$conn->connect_error;
            return null;
        }

        $conn->query('set names utf8');  // 设置字符编码
    }
    return $conn;
}


$memcache = new Memcache; // 实例化对象
if ($memcache->connect('192.168.8.102', 11211)==false){ // 连接缓存服务器
    echo "连接缓存服务器失败";
    return;
}

$mkey=rand(1,30000)+13000000;

// 从缓存服务器中获取key的值，并判断值key是否存在，不存在则添加数据
if ($memcache->get($mkey)==false){// 获取数据并判断是否存在
    $conn=miConn();
    if ($conn===null){
        return;
    }

    $sql = "select id,execute_type,execute_status,FROM_UNIXTIME(start_time, '%Y-%m-%d %h:%i:%s'),FROM_UNIXTIME(end_time, '%Y-%m-%d %h:%i:%s') from plan_task where id=" . $mkey;
    if ($result=$conn->query($sql)){
        $memcache->add($mkey, $result, false, mt_rand(40,50)); // 添加缓存数据
    } 
}else{
    echo $mkey."存在";
}

$conn->close();// 关闭连接
$memcache->close(); // 关闭连接












