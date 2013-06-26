<?php

define("TOKEN", "weixin");//修改和乐享平台token值一样即可！并使腾讯的toke值和此一致//
$ac =@$_GET['ac'];
$tid = @$_GET['tid'];
$page = @$_GET['page'];
$k = @$_GET['k'];
$c = @$_GET['c'];
$w = @$_GET['w'];
$v = @$_GET['v'];
if($v){
	exit ("1");
}
$baseurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];//.'?'.$_SERVER['QUERY_STRING'];
$basehome = dirname($baseurl)."/";
if($tid&&$ac){

	$filename="weixinhtml/ac{$ac}tid{$tid}page{$page}c{$c}.html"; 
	if($w=='2'){
		mk_dir("weixinhtml");
		$html = @HTTP_GET("http://www.apiwx.com/index.php?ac=$ac&tid=$tid&page=$page&k=$k&c=$c","","","");
		$html = preg_replace(array ("'index.php\?ac='si"),array($baseurl."?ac="),$html);
		if(strlen($html)>300){
			$fp = @fopen($filename, 'w'); 
			if (@fwrite($fp,$html) === FALSE) {
					@fclose($fp);
					echo "<script>alert('缓存".$basehome."生成失败,服务器可能不支持 如果是子目录请确保子目录的读写权限777!')</script>";
					exit($html);
			}else{
					@fclose($fp);
					
						header("Location: $basehome$filename");
						exit;
					
			}
		}
	}
	if($w=='1'){
		mk_dir("weixinhtml");
		$html = @HTTP_GET("http://www.apiwx.com/index.php?ac=$ac&tid=$tid&page=$page&k=$k&c=$c","","","");
		$html = preg_replace(array ("'index.php\?ac='si"),array($baseurl."?ac="),$html);
		if(strlen($html)>300){
			$fp = @fopen($filename, 'w'); 
			if (@fwrite($fp,$html) === FALSE) {
					@fclose($fp);
					exit($html);
			}else{
					@fclose($fp);
					
						header("Location: $basehome$filename");
						exit;
					
			}
		}
	}
	if($k==""){
		mk_dir("weixinhtml");
		if(!file_exists($filename)){
			$html = @HTTP_GET("http://www.apiwx.com/index.php?ac=$ac&tid=$tid&page=$page&k=$k&c=$c","","","");
			$html = preg_replace(array ("'index.php\?ac='si"),array($baseurl."?ac="),$html);
			if(strlen($html)>300){
				$fp = @fopen($filename, 'w'); 
				if (@fwrite($fp,$html) === FALSE) {
					@fclose($fp);
					exit($html);
				}else{
					@fclose($fp);
					if(!@$_SERVER['HTTP_REFERER'])
					{	
						exit($html);
					}else{
						header("Location: $basehome$filename");
						exit;
					}
				}
			}
		}else{
			$a=time()-filemtime($filename);
			if($a>86400){
				$html = @HTTP_GET("http://www.apiwx.com/index.php?ac=$ac&tid=$tid&page=$page&k=$k&c=$c","","","");
				$html = preg_replace(array ("'index.php\?ac='si"),array($baseurl."?ac="),$html);
				if(strlen($html)>300){
					$fp = @fopen($filename, 'w'); 
					if (@fwrite($fp,$html) === FALSE) {
					@fclose($fp);
					exit($html);
					}else{
						@fclose($fp);
						if(!@$_SERVER['HTTP_REFERER'])
						{	
							exit($html);
						}else{
							header("Location: $basehome$filename");
							exit;
						}
					}
				}
			}else{
				if(!@$_SERVER['HTTP_REFERER'])
					{	
					$html =@HTTP_GET("$basehome$filename");
						exit($html);
					}else{
						header("Location: $basehome$filename");
						exit;
					}
			}
			
		}
	}else{
	$html = @HTTP_GET("http://www.apiwx.com/index.php?ac=$ac&tid=$tid&page=$page&k=$k&c=$c","","","");
	$html = preg_replace(array ("'index.php\?ac='si"),array($baseurl."?ac="),$html);
	}
	exit($html); 
}
$wechatObj = new wechatCallbackapiTest();
if(@$GLOBALS["HTTP_RAW_POST_DATA"]){
$wechatObj->responseMsg();
}else{
	
	if($_GET["timestamp"]){
		$wechatObj->valid();
	}else{
	echo "php is ok this is new 2013-4-17 0:0  http_GET<br>";
		if(function_exists('curl_init')){
			echo "curl_init is ok<br>";
		}else{
			echo "no curl_init <br>";
		}
		if(function_exists('fsockopen')){
			echo "fsockopen is ok<br>";
		}
		else{
			echo "fsockopen is no<br>>";
		}
		if(function_exists('file_get_contents')){
			echo "file_get_contents is ok <br>";
		}
		else{
			echo "file_get_contents is not ok<br>";
		}
		if(function_exists('file_exists')){
			echo "file_exists is ok <br>";
		}
		else{
			echo "file_exists is not ok<br>";
		}
		if(function_exists('fopen')){
			echo "fopen is ok <br>";
		}
		else{
			echo "fopen is not ok<br>";
		}
		if(function_exists('fwrite')){
			echo "fwrite is ok <br>";
		}
		else{
			echo "fwrite is not ok<br>";
		}
		if(function_exists('mkdir')){
			echo "mkdir is ok <br>";
		}
		else{
			echo "mkdir is not ok<br>";
		}
	}
		
}

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = htmlspecialchars($_GET["echostr"]);
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
             	$postObj = @simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
				$Location_X = $postObj->Location_X;
				$Location_Y = $postObj->Location_Y;
				$Scale = $postObj->Scale;
				$Label = $postObj->Label;
				$PicUrl = $postObj->PicUrl;
				$MsgType = $postObj->MsgType;
				$MsgId  = $postObj->MsgId;
				$Url = $postObj->Url;
				$Event = $postObj->Event;
				$Latitude = $postObj->Latitude;
				$Longitude = $postObj->Longitude;
				$Precision = $postObj->Precision;
				$EventKey = $postObj->EventKey;
				$token = TOKEN;
                $Message = trim($postObj->Content);
         
			
					$Message = trim($Message);
					//if(function_exists('curl_init')){
					//$resultStr = $this->vcurl("http://www.apiwx.com/apiwx.php","fromUsername=$fromUsername&toUsername=$toUsername&Message=$Message");
					//}else{
						$resultStr = $this->HTTP_Post("http://www.apiwx.com/apiwx.php","fromUsername=$fromUsername&toUsername=$toUsername&Message=$Message&Location_X=$Location_X&Location_Y=$Location_Y&Scale=$Scale&Label=$Label&PicUrl=$PicUrl&MsgType=$MsgType&MsgId=$MsgId&Url=$Url&Event=$Event&Latitude=$Latitude&Longitude=$Longitude&Precision=$Precision&EventKey=$EventKey&token=$token&vision=2");
					//}
                	echo $resultStr;
                	
              

        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}


	public	function HTTP_Post($URL,$data,$cookie, $referrer="")//有些服务器可能需要通过此方式
	{
				$URL_Info=parse_url($URL);
				// making string from $data
				// Find out which port is needed - if not given use standard (=80)
				if(!isset($URL_Info["port"])){
					$URL_Info["port"]=80;
				}
				// building POST-request:
				$request.="POST ".$URL_Info["path"]." HTTP/1.1\n";
				$request.="Host: ".$URL_Info["host"]."\n";
				$request.="Referer: $referer\n";
				$request.="Content-type: application/x-www-form-urlencoded\n";
				$request.="Content-length: ".strlen($data)."\n";
				$request.="Connection: close\n";
				$request.="Cookie:   $cookie\n";
				$request.="\n";
				$request.=$data."\n";
				$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
				fputs($fp, $request);
				while(!feof($fp)) {
					$result .= fgets($fp, 1024);
				}
				fclose($fp);
			$result = preg_replace (array ("'HTTP/1[\w\W]*<xml>'i","'</xml>[\w\W]*0'i"),array ("<xml>","</xml>"),$result);
			return trim($result);
	}
	
public function HTTP_GET($URL,$data,$cookie, $referrer="")//有些服务器可能需要通过此方式
	{
				$URL_Info=parse_url($URL);
				// making string from $data
				// Find out which port is needed - if not given use standard (=80)
				if(!isset($URL_Info["port"])){
					$URL_Info["port"]=80;
				}
				// building POST-request:
				$request.="GET ".$URL." HTTP/1.1\n";
				$request.="Host: ".$URL_Info["host"]."\n";
				$request.="Referer: $referer\n";
				$request.="Content-type: application/x-www-form-urlencoded\n";
				//$request.="Content-length: ".strlen($data)."\n";
				$request.="Connection: close\n";
				$request.="Cookie:   $cookie\n";
				$request.="\n";
				$request.=$data."\n";
				$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
				fputs($fp, $request);
				while(!feof($fp)) {
					$result .= fgets($fp, 1024);
				}
				fclose($fp);
				
			$result = preg_replace (array ("'HTTP/1.[\w\W]*<html>'i"),array ( "<html>"),$result);
			return trim($result);
	}

}
function HTTP_GET($URL,$data,$cookie, $referrer="")//有些服务器可能需要通过此方式
	{
				$URL_Info=parse_url($URL);
				// making string from $data
				// Find out which port is needed - if not given use standard (=80)
				if(!isset($URL_Info["port"])){
					$URL_Info["port"]=80;
				}
				// building POST-request:
				$request.="GET ".$URL." HTTP/1.1\n";
				$request.="Host: ".$URL_Info["host"]."\n";
				$request.="Referer: $referer\n";
				$request.="Content-type: application/x-www-form-urlencoded\n";
				//$request.="Content-length: ".strlen($data)."\n";
				$request.="Connection: close\n";
				$request.="Cookie:   $cookie\n";
				//$request.="\n";
				$request.=$data."\n";
				$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
				fputs($fp, $request);
				while(!feof($fp)) {
					$result .= fgets($fp, 1024);
				}
				fclose($fp);
			$result = preg_replace (array ("'HTTP/1.[\w\W]*<head>'i"),array ( "<html><head>"),$result);
			$result = preg_replace (array ("'</body>[\w\W]*0'i"),array ( "</body></html>"),$result);
			return trim($result);
	}
function mk_dir($dir, $mode = 0777) 
{ 
if (is_dir($dir) || @mkdir($dir,$mode)) return true; 
if (!mk_dir(dirname($dir),$mode)) return false; 
return @mkdir($dir,$mode); 
} 
?>