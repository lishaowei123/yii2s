<?php

namespace app\modules\test\controllers;

use Yii;
use curl;
use tools;
use websocketclient;
use yii\web\Response;
use yii\web\Controller;

class QrloginedController extends Controller
{
    public $layout = false;
    public $curlClass;
    public $tools;

    public function beforeAction(){
        $this->curlClass = new curl();
        $this->tools = new tools();
        return $this->curlClass;
    }
    public function actionIndex($code)
    {
        $userData = $this->getUser($code);
        $data = $this->setCookie($userData['result']['tmpCode'], $userData['result']['appKey'], $userData['result']['openId'] );

        $cookie = file_get_contents(dirname(getcwd()).'/cookie/'.$userData['result']['openId'].'.txt');
        //socket 连接测试
        $websocketclient = new websocketclient('wss://webalfa-cm10.dingtalk.com/lwp','https://im.dingtalk.com', $cookie);
        $this->tools->xbug($websocketclient);

        unset($websocketclient);
    }

    private function getUser($code){
        $url = 'https://login.dingtalk.com/user/qrcode/is_logged.jsonp?callback=angular.callbacks._5&qrcode='.$code;
        $headers = array(
            'Accept:*/*',
            'Accept-Encoding:gzip, deflate, sdch',
            'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.6,en;q=0.4',
            'Cache-Control:no-cache',
            'Connection:keep-alive',
            'DNT:1',
            'Host:login.dingtalk.com',
            'Pragma:no-cache',
            'Referer:https://im.dingtalk.com/?spm=a3140.7858860.1998832757.7.6bQVK5',
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'
        );
        $data = $this->curlClass->curl_get($url, $headers);
        $data = strtr($data,  array('angular.callbacks._5('=>'',');'=>''));
        return json_decode($data, true);
    }
    private function setCookie($tmpCode, $appKey, $openId ){
        $headers = array(
            'Accept:*/*',
            'Accept-Encoding:gzip, deflate, sdch',
            'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.6,en;q=0.4',
            'Cache-Control:no-cache',
            'Connection:keep-alive',
            'DNT:1',
            'Host:webalfa-cm10.dingtalk.com',
            'Pragma:no-cache',
            'Referer:https://im.dingtalk.com/',
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'
        );
        $cookieUrl = 'https://webalfa-cm10.dingtalk.com/setCookie?code='.$tmpCode.'&appkey='.$appKey.'&isSession=true&callback=__jp0';
        $cookiePath = dirname(getcwd()).'/cookie/'.$openId.'.txt';
        $data = $this->curlClass->curl_get($cookieUrl, $headers, NULL, $cookiePath);
        return $data;
    }
}
