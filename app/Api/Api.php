<?php
//require 'vendor/autoload.php';
namespace App\Api;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;


Class Api
{

    private $client = null;

    #const API_URL = "https://apiv1.feraltar.com/";
    //const API_URL = "https://feraltar-stage.azurewebsites.net/apiv1";
    #const API_URL = "https://apiferaltar.local/";

    private $grant_type;
    private $client_id;
    private $client_secret;
    private $destination_code;
    private $api_url;

    public function __construct($clientid = false, $secret = false, $destination_code = false, $api_url = false)
    {
        $this->grant_type ='client_credentials';
        $this->client_id = $clientid ? $clientid : env('API_FERALTAR_CLIENT_ID');
        $this->client_secret = $secret ? $secret : env('API_FERALTAR_SECRET');
        $this->destination_code = $destination_code ? $destination_code : env('API_FERALTAR_DESTINATION_CODE');
        $this->api_url = $api_url ? $api_url : env('API_FERALTAR_URL');
        $this->client =  new Client();
    }//fin constructor

    /**
    * POST : oauth2/get-token/
    * @return string $accessToken obteniendo token
    */
    /*public function get_access_token()
    {
        return $this->getAccessToken();
    }*///fin metodo prepare access token
    
    public function getAccessToken()
    {
      #dump(Storage::disk('local')->exists('_token.txt'));
      if (Storage::disk('local')->exists('_token.txt')) {
        return Storage::disk('local')->get('_token.txt');
      } else {
        $this->setAccessToken();
        return Storage::disk('local')->get('_token.txt');
      }
    }
    
    public function setAccessToken()
    {
        try {
            $url = $this->api_url .  "oauth2/get-token/";
            $response = $this->client->request('POST', $url, [
                'form_params' => [
                    'grant_type' => $this->grant_type,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret
                ]
            ]);
            $result = json_decode($response->getBody()->getContents());
            $fileToken = fopen("_token.txt", "w");
            Storage::disk('local')->put('_token.txt', $result->access_token, 'private');
            //fwrite($fileToken, $result->access_token);
            //fclose($fileToken);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $this->log('ApiClass->setAccessToken() - RequestException: '.$e->getMessage(). ' - HTTP:'.$statusCode.' - BODY:'.$body);
            #$this->sendEmailError($url, ['client_id' => $this->client_id, 'client_secret' => $this->client_secret], 'ApiClass->setAccessToken() RequestException');
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $this->log('ApiClass->setAccessToken() - ClientException: '.$e->getMessage(). ' - HTTP:'.$statusCode.' - BODY:'.$body);
            #$this->sendEmailError($url, ['client_id' => $this->client_id, 'client_secret' => $this->client_secret], 'ApiClass->setAccessToken() ClientException');
        } catch (\Exception $e) {
            $this->log('ApiClass->setAccessToken() - Exception: '.$e->getMessage());
            #$this->sendEmailError($url, ['client_id' => $this->client_id, 'client_secret' => $this->client_secret], 'ApiClass->setAccessToken() Exception');
        }
    }
    /**
     * POST request
     * @param  strign $url  endpoint
     * @param  array  $data data to send
     * @return Guzzle\Response $response
     */
    public function post($url, $data = array())
    {
        try {
            $data['access_token'] = $this->getAccessToken();
            return $this->client->request('POST', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response->getStatusCode() == 403) {
                $this->setAccessToken();
                $data['access_token'] = $this->getAccessToken();
                try {
                    return $this->client->request('post', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json'
                        ],
                        'body' => json_encode($data)
                    ]);
                } catch (\Exception $e) {
                }
            }
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $this->processResponse($body, $statusCode);
            $this->log('ApiClass->post() - RequestException: '.$e->getMessage(). ' - HTTP:'.$statusCode.' - BODY:'.$body);
            #$this->sendEmailError($url, $data, $e->getMessage());
            $response->getBody()->rewind();
            return $response;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if ($response->getStatusCode() == 403) {
                $this->setAccessToken();
                $data['access_token'] = $this->getAccessToken();
                try {
                    return $this->client->request('post', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json'
                        ],
                        'body' => json_encode($data)
                    ]);
                } catch (\Exception $e) {
                }
            }
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $this->processResponse($body, $statusCode);
            $this->log('ApiClass->post() - ClientException: '.$e->getMessage(). ' - HTTP:'.$statusCode.' - BODY:'.$body);
            #$this->sendEmailError($url, $data, $e->getMessage());
            $response->getBody()->rewind();
            return $response;
        } catch (\Exception $e) {
            $this->log('ApiClass->post() - Exception: '.$e->getMessage());
            #$this->sendEmailError($url, $data, $e->getMessage());
        }
    }
    /**
     * Request get
     * @param  string  $url             url de la peticion
     * @param  array   $data            datos a enviar en la peticion
     * response devuelva 403 (no autorizado)
     * @return [type]                   [description]
     */
    public function get($url, $data = array())
    {
        try {
            $data['access_token'] = $this->getAccessToken();
            return $this->client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'query' => $data
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response->getStatusCode() == 403) {
                $this->setAccessToken();
                $data['access_token'] = $this->getAccessToken();
                try {
                    return $this->client->request('GET', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json'
                        ],
                        'query' => $data
                    ]);
                } catch (Exception $e) {
                }
            }
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $this->processResponse($body, $statusCode);
            $this->log('ApiClass->get() - RequestException: '.$e->getMessage(). ' - HTTP:'.$statusCode.' - BODY:'.$body);
            #$this->sendEmailError($url, $data, $e->getMessage());
            $response->getBody()->rewind();
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            if ($response->getStatusCode() == 403) {
                $this->setAccessToken();
                $data['access_token'] = $this->getAccessToken();
                try {
                    return $this->client->request('GET', $url, [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json'
                        ],
                        'query' => $data
                    ]);
                } catch (Exception $e) {
                }
            }
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $this->processResponse($body, $statusCode);
            $this->log('ApiClass->get() - ClientException: '.$e->getMessage(). ' - HTTP:'.$statusCode.' - BODY:'.$body);
            #$this->sendEmailError($url, $data, $e->getMessage());
            $response->getBody()->rewind();
            return $response;
        } catch (\Exception $e) {
            $this->log('ApiClass->get() - Exception: '.$e->getMessage());
            #$this->sendEmailError($url, $data, $e->getMessage());
        }
    }
    private function processResponse($response, $statusCode)
    {
        $rs = json_decode($response, true);
        if ($statusCode == 403) {
            $cont = '<Limit GET POST>'
                    .chr(13)
                    .chr(10)
                    .'order allow,deny'
                    .chr(13).chr(10)
                    .'deny from '.$this->getRealIpAddr()
                    .chr(13)
                    .chr(10)
                    .'allow from all'
                    .chr(13)
                    .chr(10)
                    .'</Limit>';
            $fp = fopen (".htaccess", "a");
            fwrite ($fp, PHP_EOL.$cont);
            fclose ($fp);
            $log = isset($rs['apiMessage']) ? $rs['apiMessage'] : $response;
            $this->log($log);
        }
        #if (isset($rs['apiCode']) && $rs['apiCode'] == 1) {
        #}
    }
    /**
     * GET : /hotels/search/ busqueda de hoteles
     * @param  string $search          parametro de busqueda
     * @return array                   array of objects
     */
    public function searchHotels($search)
    {
        $url = $this->api_url . 'hotels/search/';
        $response = $this->get($url, ['search' => $search, 'destinationCode' => $this->destination_code]);
        $rs = json_decode($response->getBody()->getContents());
        $rs->statusCode = $response->getStatusCode();
        $rs->error = $response->getStatusCode() < 200 || $response->getStatusCode() > 299;
        return $rs;
    }//fin metodo search Hotels

    /**
    * GET : /services/quote/
    * Array
    * @return json quote airport service and quote transfer service and open service
    */
    public function quoteService($array)
    {
        $url = $this->api_url . 'services/quote/';
        $array['destinationCode'] = $this->destination_code;
        $array['taxi'] = 0;
        $response = $this->get($url, $array);
        #var_dump($response->getStatusCode());exit;
        #echo ($response->getBody()->getContents());exit;
        $rs = json_decode($response->getBody()->getContents());
        $rs->statusCode = $response->getStatusCode();
        $rs->error = $response->getStatusCode() < 200 || $response->getStatusCode() > 299;
        return $rs;
    }//fin metodo quote airport service

    //reservations/B29P9S21/show/
     /**
    * GET : reservations/'.$idReservation.'/show/
    * id,destination
    * @return array of objects
    */
    public function getReservation($idReservation)
    {
        $url = $this->api_url . 'reservations/'.$idReservation.'/show/';
        $response = $this->get($url, ['destinationCode'=>$this->destination_code]);
        return json_decode($response->getBody()->getContents());
    }//fin metodo quote airport service
    public function getReservation21($idReservation)
    {
        $url = $this->api_url . 'reservations/apto-21/'.$idReservation.'/';
        $response = $this->get($url, ['destinationCode'=>$this->destination_code]);
        return json_decode($response->getBody()->getContents());
    }//fin metodo quote airport service

    /**
     * POST : /reservations/store/
     * Array
     * @return array of objects
    */
    public function saveReservation($array)
    {
        $url = $this->api_url . 'reservations/store/';
        $array['destinationCode'] = $this->destination_code;
        $response = $this->post($url, $array);
        #return json_decode($response->getBody()->getContents());
        #var_dump($response->getBody()->getContents());
        $rs = json_decode($response->getBody()->getContents());
        $rs->statusCode = $response->getStatusCode();
        $rs->error = $response->getStatusCode() < 200 || $response->getStatusCode() > 299;
        return $rs;
    }//fin metodo saveReservation
    /**
     * POST : /reservations/store/
     * Array
     * @return array of objects
    */
    public function saveReservation21($array)
    {
        $url = $this->api_url . 'reservations/apto-21/';
        $array['destinationCode'] = $this->destination_code;
        $response = $this->post($url, $array);
        #return json_decode($response->getBody()->getContents());
        //echo($response->getBody()->getContents());exit();
        $rs = json_decode($response->getBody()->getContents());
        $rs->statusCode = $response->getStatusCode();
        $rs->error = $response->getStatusCode() < 200 || $response->getStatusCode() > 299;
        return $rs;
    }//fin metodo saveReservation
    
    /**
     * Cotizacion de un servicio individual
     * @param array $array parametros de cotizacion
     */
    public function quoteSingleService($array)
    {
        $url = $this->api_url . 'services/quote-single-service/';
        $array['destinationCode'] = $this->destination_code;
        $array['taxi'] = 0;
        $response = $this->get($url, $array);
        $rs = json_decode($response->getBody()->getContents());
        $rs->statusCode = $response->getStatusCode();
        $rs->error = $response->getStatusCode() < 200 || $response->getStatusCode() > 299;
        return $rs;
    }//fin quote-single-service
    

    public function StatusCodeHandling($e)
    {
        if ($e->getResponse()->getStatusCode() == '400') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '422') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '500') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '401') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        } elseif ($e->getResponse()->getStatusCode() == '403') {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        } else {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }//fin if
    }//fin metodo status handling
    
    public function getRealIpAddr()
    {
        if (!empty( $_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty( $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip passed from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    private function log($str)
    {
        setlocale(LC_TIME, "es_ES");
        date_default_timezone_set('America/Cancun');
        $write = "\n" . date("d/m/Y H:i:s")." - ".$str."\n";
        Storage::disk('local')->prepend('log_api.log', $write);
    }
    private function sendEmailError($url, $data, $message)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            #$mail->SMTPDebug = 3;                                 // Enable verbose debug output
            /*$mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.feraltar.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'info@feraltar.com';                 // SMTP username
            $mail->Password = '{}!cwr6+Lyao';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('info@feraltar.com', 'Error API REQUEST');
            $mail->addAddress('ivanpuga@outlook.com', 'Ivan puga');     // Add a recipient
            $mail->addAddress('alejandra@feraltar.com', 'Alejandra');     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'ERROR API REQUEST';
            ob_start();
            echo "<h1>URL:$url</h1>";
            echo "<h2>Message</h2>";
            echo $message;
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            $html = ob_get_contents();
            ob_end_clean();
            $mail->Body    = $html;

            $mail->send();*/
        } catch (PHPMailerException $e) {
            $str = 'Message could not be sent. - ';
            $str .= 'Mailer Error: ' . $mail->ErrorInfo;
            $this->log($str);
        } catch (\Exception $e) {
            $str = 'Mailer Error: ' . $e->getMessage();
            $this->log($str);
        }
    }
}//fin de la clase