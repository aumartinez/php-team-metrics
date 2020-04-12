<?php

class WSModel extends DbModel {
    
    public function get_data($table) {
      $sql = "SELECT * FROM {$table}";
      
      return $this->get_query($sql);
    }
}

?>
