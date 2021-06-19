<?php
include('storage.php');

class DataStorage extends Storage {
  public function __construct($table) {
    parent::__construct(new JsonIO("database/${table}.json"));
  }
}