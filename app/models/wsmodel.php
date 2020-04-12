<?php

class Wsmodel extends Dbmodel {
    
    public function get_data($table) {
      $sql = "SELECT * FROM {$table}";
      
      return $this->get_query($sql);
    }
}

?>
