<?php

class Bloomberg {
  
  protected $command = "./bloomberg.sh ";

  // { "securities": ["IBM US Equity", "AAPL US Equity"],
  // "fields": ["PX_LAST", "OPEN"],
  // "startDate": "20120101",
  // "endDate": "20120105",
  // "periodicitySelection": "DAILY" }

  public function Bloomberg() {
    print $this->do_curl();
  }

  private function do_curl() {
    $result = null;
    try {
      $data = json_encode(array("securities" => ["IBM US Equity", "AAPL US Equity"],
                                "fields" => ["PX_LAST", "OPEN"],
                                "startDate" => "20120101",
                                "endDate" => "20120105",
                                "periodicitySelection" => "DAILY"));
      print $data;
      exec($this->command . $data, $result);
    }
    catch(Exception $e) {
      $this->kill($e);
    }

  }
  
  private function errors_off() {
    error_reporting(0);
    ini_set('display_errors', 0);
  }

  private function kill($message) {
    $response = array('status' => 'error', 'message' => $message);
    print json_encode($response);
    die();
  }

}

$b = new Bloomberg();


?>