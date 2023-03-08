<?php
require_once("hv-html.php");

class HV_Table extends HV_HTML{
    public $thClass = "";
    public $tdClass = "";
    public function __construct($tableData, $class, $id, $style, $orderBy, $orderDirection)
    {
        parent::__construct("", $tableData, $class, $id, $style, "", $orderBy, $orderDirection);
    }
    public function setThClass($class){
        $this->thClass = $class;
    }
    public function setTdClass($tdClass){
        $this->tdClass = $tdClass;
    }
    //function to check if $tableData[0] exists and is not empty
    public function checkTableData($tableData) {
        if (isset($tableData[0]) && !empty($tableData[0])) {
            return true;
        }
        return false;
    }
    public function getTable() {
        if (isset($this->tableData) && $this->checkTableData($this->tableData)) {
            $colNames = array_keys($this->tableData[0]);
            $thHTML = '<tr>';
            foreach ($colNames as $colName) {
                // wenn die schleife bei der orderBy spalte ist, soll der Pfeil (ASC oder DESC) angezeigt werden
                //wenn die var orderBy gesetzt ist, soll der Pfeil (ASC oder DESC) angezeigt werden
                if (isset($this->orderBy) && $colName == $this->orderBy) {
                  if ($this->orderDirection == "ASC") {
                    $thHTML .= '<th scope="col" class="' . $this->thClass . '" id="">' . $colName . ' ▲</th>';
                  }
                  else if ($this->orderDirection == "DESC") {
                    $thHTML .= '<th scope="col" class="' . $this->thClass . '" id="">' . $colName . ' ▼</th>';
                  }
                }
                else {
                  $thHTML .= '<th scope="col" class="' . $this->thClass . '" id="' . $colName . '">' . $colName . '</th>';
                }
            }
        
            $thHTML .= '</tr>';

            $this->tableData = $this->orderTableData($this->tableData, $this->orderBy, $this->orderDirection);
        
            $trHTML = '';
            for ($i = 0; $i < count($this->tableData); $i++) {
              $row = $this->tableData[$i];
              $trHTML .= '<tr>';
              foreach ($row as $val) {
                $trHTML .= '<td class="' . $this->tdClass . '">' . $val . '</td>';
              }
              $trHTML .= '</tr>';
            }
            $tableHTML = '<table class="table table-striped table-dark">' . $thHTML . $trHTML . '</table>';
            return $tableHTML;
        }
    }
    function orderTableData($tableData, $orderBy, $orderDirection) {
        if (!($orderBy == "null")) {
          $n = count($tableData);
          for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
              if ($orderDirection === 'ASC') {
                if ($tableData[$j][$orderBy] > $tableData[$j + 1][$orderBy]) {
                  $this->swap($tableData[$j], $tableData[$j + 1]);
                }
              } else {
                if ($tableData[$j][$orderBy] < $tableData[$j + 1][$orderBy]) {
                  $this->swap($tableData[$j], $tableData[$j + 1]);
                }
              }
            }
          }
        }
        return $tableData;
      }
      
      function swap(&$a, &$b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
      }
}
?>