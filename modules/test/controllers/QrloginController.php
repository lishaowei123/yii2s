<?php

namespace app\modules\test\controllers;

use app\models\Ws;
use Yii;
use curl;
use yii\web\Response;
use yii\web\Controller;

class QrloginController extends Controller
{
    public $layout = false;
    public function actionIndex()
    {
        $curlClass = new \curl();
        $url = 'https://login.dingtalk.com/user/qrcode/generate.jsonp?callback=angular.callbacks._19';
//        $headers = array(
//            'Accept:*/*',
//            'Accept-Encoding:gzip, deflate, sdch',
//            'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.6,en;q=0.4',
//            'Cache-Control:no-cache',
//            'Connection:keep-alive',
//            'DNT:1',
//            'Host:login.dingtalk.com',
//            'Pragma:no-cache',
//            'Referer:https://im.dingtalk.com/?spm=a3140.7858860.1998832757.7.6bQVK5',
//            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'
//        );
        $data = $curlClass->curl_get($url);
        var_dump($data);die();
        $data = strtr($data,  array('angular.callbacks._19('=>'',');'=>''));
        $data_arr = json_decode($data, true);
        var_dump($data_arr);die();
        return $this->render('qrlogin', $data_arr);
    }
    //
    public function actionKun()
    {
         $urls = array(

 ); // 设置要抓取的页面URL
        $num=4000;
 $a=1;

 $mh = curl_multi_init();

 for($a=1;$a<$num;$a++){
     $cookie_folder = dirname ( __FILE__ ) . "/laji/";
 	 $save_to=$cookie_folder.$a.'.html';  // 把抓取的代码写入该文件
 	 $st = fopen($save_to,'x',"ccs=UTF-8");
 	 $url='http://www.xiamp4.com/Html/GP'.$a.'.html';
 	 echo $url;
 	 $conn[$a] = curl_init($url);
 	 curl_setopt($conn[$a], CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)");
 	 curl_setopt($conn[$a], CURLOPT_HEADER ,0);
 	 curl_setopt($conn[$a], CURLOPT_CONNECTTIMEOUT,60);
 	 curl_setopt($conn[$a], CURLOPT_FILE,$st); // 设置将爬取的代码写入文件

  	 // $data1 = curl_multi_getcontent($conn[$a]);
 	 curl_multi_add_handle ($mh,$conn[$a]);

 	 // var_dump($data1);die();
 } // 初始化

 do {
  curl_multi_exec($mh,$active);
 } while ($active); // 执行

 foreach ($urls as $i => $url) {
  curl_multi_remove_handle($mh,$conn[$i]);
  curl_close($conn[$i]);
 } // 结束清理

 curl_multi_close($mh);
 fclose($st);
    }
    //
    public function actionTest()
    {
$num=100;
        for($a=1;$a<$num;){
            $save_to='./laji/'.$a.'.html';  // 把抓取的代码写入该文件
            $data=file_get_contents($save_to);
            // var_dump($data);die();
            $tt = '/ed2k:\/\/.*?\//si';
            preg_match_all ( $tt , $data, $array );
            $tt2='/ftp:\/\/.*?(mkv|rmvb)/si';
            preg_match_all ( $tt2 , $data, $array2 );
            $tt1 = '/<h1>.*?<\/h1>/si';
            preg_match_all ( $tt1 , $data, $array1 );
            $b=$array1['0']['0'];
            // var_dump($b);die();

            foreach($array[0] as $ab=>$s){
                $b.="<a href=''>".$s."</a><br/>";
            }
            foreach($array2[0] as $ab=>$s){
                $b.="<a href=''>".$s."</a><br/>";
            }
            $title=strtr($array1['0']['0'],['<h1>'=>'','</h1>'=>'']);
            $title=substr($title, 0,10);
            $newhtml='./wenjian/'.$title.'.html';  // 把抓取的代码写入该文件
            // $st = fopen($newhtml,"w+","ccs=UTF-8");
            $newdata=fopen($newhtml, 'x');
            echo $title.$a;
            fwrite($newdata, $b);
            fclose($newdata);
            $a++;
        }
    }

    public function _websocket()
    {
        // 建立一个 socket 套接字
        $master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($master, $address, $port);
        socket_listen($master);
    }
}
