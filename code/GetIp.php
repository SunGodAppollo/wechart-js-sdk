<?php
/**
 * 获取微信服务器的ip
 */
class GetIp{

  /**
   * 获得token请求链接
   * @return [type] [description]
   */
  public function getTokenUrl(){
    return 'https://api.weixin.qq.com/cgi-bin/token';
  }

  /**
   * 获取ip地址的请求链接
   * @return [type] [description]
   */
  public function getIpUrl(){
      return 'https://api.weixin.qq.com/cgi-bin/getcallbackip';
  }

  /**
   * tonken请求配置
   * @return [type] [description]
   */
  public function token_conifg(){
      return [
        'grant_type'=>'client_credential',
        'appid'=>'',//你自己的appid
        'secret'=>'' //你自己的secret
      ];
  }

  /**
   * 组合get请求
   * @return [type] [description]
   */
  private function combinationGetUrl($url,$dataArray){
    //方法内容
    $get_url=$url;
    $get_url.='?';
        foreach ($dataArray as $k=>$v){
            $get_url.=$k.'='.$v.'&';
        }

      $get_url=substr($get_url,0,strlen($get_url)-1);
      return $get_url;
  }

  /**
   * 获得微信服务器ip
   * @return [type] [description]
   */
  public function getWxServerIp(){
      $token=$this->getToken();
	  $data=[
	  'access_token'=>$token
	  ];

	  $getWxServerIpUrl=$this->combinationGetUrl($this->getIpUrl(),$data);
	  $res=$this->send($getWxServerIpUrl);
	  echo($res);
  }

  /**
   * 获得toen
   * @return [type] [description]
   */
  public function  getToken(){
      $tonken_data=$this->token_conifg();
      $url=$this->combinationGetUrl($this->getTokenUrl(),$tonken_data);
      $res=$this->send($url);

      if(empty($res)){
          echo "error";die();
      }
      $res_array=json_decode($res,true);


	  return($res_array['access_token']);

  }




  /**
   * 组合请求参数并且发送
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  public function send($url){


      //echo($url);die();
      // 1. 初始化
        $ch = curl_init();




        // 2. 设置选项，包括URL
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 跳过证书验证（https）的网站无法跳过，会报错
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书验证
        curl_setopt($ch,CURLOPT_URL,$url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER,$post_header);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        // 4. 释放curl句柄
        curl_close($ch);


		//echo ($output);die();
        //处理结果
        if($output === FALSE ){
            echo "CURL Error:".curl_error($ch);
        }else {
            return $output;
        }
  }

}



$a=new GetIp();
$a->getWxServerIp();

?>
