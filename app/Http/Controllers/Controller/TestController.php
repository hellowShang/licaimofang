<?php

namespace App\Http\Controllers\Controller;

use App\Events\Register;
use App\Jobs\Manage;
use App\Model\Order;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    /*
        0.配置nginx环境，支持laravel框架
        1.搞清楚laravel框架的migration机制，并熟悉框架的orm
        2.写一个get请求，能够读mysql（使用框架的orm），能够读redis（使用框架的cache）
        3.写一个post请求，能够写mysql（使用框架的orm），能够写redis（使用框架的cache）
        4.写一个laravel命令，并能够执行命令
        5.写一个队列任务，并通过laravel框架的异步任务支持工具，执行一个同步任务和一个异步任务
        6.写一个laravel事件，并进行事件注册，及验证事件是否生效
     */
    /**
     * 传递参数 uid
     * get请求访问MySQL和redis
     */
    public function testGet(){
        // 数据库读取
        $uid = request()->uid;
        $data = User::where(['id' => $uid])->first();
        if($data){
            echo "数据库数据";
            echo "<br />";
            echo "<pre>";print_r($data->toArray());echo "</pre>";
        }
        echo "<hr />";

        if($uid){
            $key = "manage:".$uid;
            $arr = Redis::hGetAll($key);
            echo "redis数据";
            echo "<br />";
            echo "<pre>";print_r($arr);echo "</pre>";die;
        }
    }

    /**
     * 传递参数 name email password
     * post请求访问MySQL和redis
     */
    public function testPost(){
        // 数据库写
        $postData = request()->all();
        // echo "<pre>";print_r($postData);echo "</pre>";die;
        $uid = User::insertGetId($postData);
        echo "数据库写入成功，id：".$uid;;
        echo "<br />";

        // redis写
        if($uid){
            $key = "manage:".$uid;
            Redis::hMSet($key,$postData);
            echo "redis写入成功，id：".$uid;
        }
    }

    // 读库数据写redis
    public function test3(){
        $data = User::all()->toArray();
        foreach($data as $k=>$v){
            $key = "manage:".$v['id'];
            Redis::hMSet($key,$v);
        }
    }

    /**
     * 传递参数 email
     * 发送邮箱
     */
    public  function SendEmail(){
        // 接收邮件
        $email = request()->email;
        echo $email;
        echo "<br />";

        // 异步发送
        Manage::dispatch($email)->onQueue('sendEmail')->delay(now()->addMinutes(10));

        // 同步发送
//        Manage::dispatchNow($email);

    }

    /**
     *
     * 事件注册
     */
    public function listen(){
        $oid = request()->oid;
        echo "oid：".$oid;
        echo "<br />";
        $data = Order::where(['id'=>$oid])->first();
        if($data){
            echo "num：".$data->num;
            echo "<br />";
            Register::dispatch($data->num);
        }
    }
}
