<?php
namespace app\wap\controller;

use wechat\Wechat;
use think\Request;
class User extends WapBase
{
    public function login(){  
        $wechatObj = new Wechat();
        $request = Request::instance();
        if($request->get('code') !='' && $request->get('state') == 'tech1024'){
            $postData = [
                'appid' => $wechatObj->appid,
                'secret' => $wechatObj->appsecret,
                'code' => $request->get('code'),
                'grant_type' => "authorization_code",
            ];
            $urlPath = "https://api.weixin.qq.com/sns/oauth2/access_token?".http_build_query($postData);
//             echo $urlPath;die;
            
            $res = file_get_contents($urlPath);
            $resObj = json_decode($res);
            if($resObj->access_token != ''){
                $postData = [
                    'access_token'=> $resObj->access_token,
                    'openid'=> $resObj->openid,
                    'lang'=> 'zh_CN',
                ];
                $urlPath = "https://api.weixin.qq.com/sns/userinfo?".http_build_query($postData);
               
                $res = file_get_contents($urlPath);
                //用户绑定
//                 1、已有账号，绑定openid
//                 2、新用户注册，绑定openid
//                 3、再次微信进入，获取openid,查找该用户，并登陆
                dump($res);die;
            }else{
                die;
            }
        }
        
        $postData = [
            'appid' => $wechatObj->appid,
            'redirect_uri' => $request->url(true),
            'response_type' => 'code',
            'scope' => 'snsapi_userinfo',
            'state' => 'tech1024',
        ];
//         dump($postData);die;
        $urlPath = $wechatObj->authorizeUrl.'authorize?'.http_build_query($postData).'#wechat_redirect';
//         echo $urlPath;die; 
        header("Location: ".$urlPath);die;
          return $res;
          echo $res;die; 
//         https://open.weixin.qq.com/connect/oauth2/authorize?
//         appid=APPID&redirect_uri=REDIRECT_URI
//         &response_type=code&scope=SCOPE&state=STATE#wechat_redirect
//         return 'this is login page';
    }
}