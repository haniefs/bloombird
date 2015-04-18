<?php

class Bloomberg {
  
  protected $url = "https://http-api.openbloomberg.com/request?ns=blp&service=refdata&type=HistoricalDataRequest";
  private $company = null;

  public function Bloomberg($company) {
    header('Access-Control-Allow-Origin: *');
    $this->errors_off();
    $this->company = $company;
  }

  public function json() {
    $data = json_encode(array('securities' => [$this->company], 
                              'fields' => ['PX_LAST'],
                              'startDate' => '20050101',
                              'endDate' => '20150105',
                              'periodicitySelection' => 'MONTHLY'));


    $stockPrice = $this->do_curl($data);
    $stockPrice = json_decode($stockPrice);

    $result = array();
    foreach ($stockPrice->data[0]->securityData->fieldData as $v ) 
    {
      // array_push($result, array('date' => $v->date, 'value' => $v->PX_LAST));
      array_push($result, array($v->PX_LAST)[0]);
    }

    echo json_encode($result);
  }

  private function do_curl($data) {
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_URL, $this->url); 
    curl_setopt($ch, CURLOPT_PORT , 443); 
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/bloomberg.crt');
    curl_setopt($ch, CURLOPT_SSLCERT, getcwd().'/client.crt');
    curl_setopt($ch, CURLOPT_SSLKEY,  getcwd().'/client.key'); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 

    $ch_data = curl_exec($ch); 
    if(!curl_errno($ch)) {
      $info = curl_getinfo($ch); 
      // echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url']; 
      return $ch_data;
    } else { 
      $this->kill(curl_error($ch));
    } 

    curl_close($ch); 
  }

  private function errors_off() {
    error_reporting(0);
    ini_set('display_errors', 0);
  }

  private function kill($message) {
    $response = array('status' => 'error', 'message' => $message);
    die(json_encode($response));
  }


}

$company = $_POST['company'];
$b = new Bloomberg($company);
$b->json();
?>
