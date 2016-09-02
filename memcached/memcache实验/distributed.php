<?php

// 一致性hash算法
class DHT{
    public $node = array(); // 存放虚拟节点
    public $num = 100;    // 每台服务器分分配虚拟节点

    public function getCRC($str)
    {    // 把字符串转为数字1 ~ 2^32-1
        return sprintf("%u", crc32($str));
    }

    public function lookup($key){  // 查找key的落点在哪个缓存服务器
        $keyHash = $this->getCRC($key);
        $place = current($this->node);
        foreach ($this->node as $k => $v) {
            if ($keyHash <= $k) {
                $place = $v;
                break;
            }
        }
        return $place;
    }

    public function addNode($nodeName){  // 把每个服务器分为多个虚拟节点
        for ($i = 0; $i < $this->num; $i++) {
            $this->node[$this->getCRC($nodeName . '_' . $i)] = $nodeName;
        }
        ksort($this->node, SORT_REGULAR);
    }

    public function delNode($nodeName){ // 删除服务器节点
        foreach ($this->node as $k => $v) {
            if ($nodeName == $v) {
                unset($this->node[$k]);
            }
        }
    }
}

// 取模算法
class MOD{
    public $node = array();   // 存放缓存服务器节点

    public function getCRC($key){     // 把字符串转为数字1 ~ 2^32-1
        return sprintf('%u', crc32($key));
    }

    public function lookup($key){   // 查找key的落点在哪个缓存服务器
        $hashKey = $this->getCRC($key);
        $key = $hashKey % count($this->node);   // 求余
        if (array_key_exists($key, $this->node)) {    // 判断key是否存在
            return $this->node[$key];
        } else {
            return '';
        }
    }

    public function addNode($nodename){ // 添加节点
        if (in_array($nodename, $this->node)) {   // 判断节点是否已经存在
            return;
        }
        $this->node[] = $nodename;
    }

    public function delNode($nodename){     // 删除节点
        if (in_array($nodename, $this->node)) {   // 判断节点是否已经存在
            $key = array_search($nodename, $this->node);// 获取节点的key
            unset($this->node[$key]);
            $this->node = array_merge($this->node);
        }
    }
}