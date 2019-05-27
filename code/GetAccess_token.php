<?php
/**
 * 获取access_token接口 /token
 */
class GetAccess_token{

  /**
   * 定义请求链接
   * @return [type] [description]
   */
  public function geturl(){
    return 'https://api.weixin.qq.com/cgi-bin/token';
  }

  /**
   * 组合请求参数并且发送
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  public function send($data){
      $url=$this->geturl();

      $url.='?';
        foreach ($data as $k=>$v){
            $url.=$k.'='.$v.'&';
        }

      $url=substr($url,0,strlen($url)-1);

      echo($url);die();
      // 1. 初始化
        $ch = curl_init();

        // 2. 设置选项，包括URL
        curl_setopt($ch,CURLOPT_URL,$url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER,$post_header);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        // 4. 释放curl句柄
        curl_close($ch);

        //处理结果
        if($output === FALSE ){
            echo "CURL Error:".curl_error($ch);
        }else {
            echo ($output);
        }
  }

}

$data=[
  'grant_type'=>'client_credential',
  'appid'=>'',//你自己的appid
  'secret'=>'' //你自己的secret
];

$a=new GetAccess_token();
$a->send($data);

?>
