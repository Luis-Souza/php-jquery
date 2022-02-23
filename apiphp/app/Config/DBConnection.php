<?php

namespace App\Config;

class DBConnection {

  public function getConnection()
  {
    return new \MongoDB\Client('mongodb://localhost:27017');
  }
}
