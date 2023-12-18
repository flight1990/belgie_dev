<?php


namespace App\Traits;

use Illuminate\Support\Facades\Cache as Memcached;
use Illuminate\Support\Facades\Redis;


trait HasCache
{
    public function getCache($key, $model = null)
    {
        $memcached = Memcached::get($key);
        if(isset($memcached)){
            return $memcached;
        }
        else{
            $redis = Redis::get($key);
            if(isset($redis)){
                return $redis;
            }
            else{
                if(is_null($model)){
                    return false;
                }
                return $this->setCache($key, $model->get());
            }
        }
    }

    public function setCache($key, $data)
    {
        Memcached::set($key, $data);
        Redis::set($key, $data);
        return $data;
    }

    public function clearCache($key, $data)
    {
        Memcached::del($key);
        Redis::del($key);
    }
}
