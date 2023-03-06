<?php
require_once("hv-html.php");

class HV_Table extends HV_HTML{
    public $thClass = "";
    public $tdClass = "";
    public function __construct($array2D, $class, $id, $style, $orderBy, $orderDirection)
    {
        parent::__construct("", $array2D, $class, $id, $style, "", $orderBy, $orderDirection);
    }
    public function setThClass($class){
        $this->thClass = $class;
    }
    public function setTdClass($tdClass){
        $this->tdClass = $tdClass;
    }
    function getTable() {
        // Prüfen, ob das übergebene Array ein 2D-Array ist
        if (!is_array($this->array2D) || empty($this->array2D)) {
            return;
        }
    
        // Wenn $orderBy und $orderDirection angegeben wurden, sortiere das Array
        if ($this->orderBy && in_array($this->orderDirection, ['ASC', 'DESC'])) {
            $sortedArray = array();
            foreach ($this->array2D as $key => $row) {
                $sortedArray[$key] = $row[$this->orderBy];
            }
            array_multisort($sortedArray, $this->orderDirection == 'ASC' ? SORT_ASC : SORT_DESC, $this->array2D);
        }
    
        // Erstelle die Tabelle
        $table = '<table';
        if ($this->class) {
            $table .= ' class="' . $this->class . '"';
        }
        if ($this->id) {
            $table .= ' id="' . $this->id . '"';
        }
        if ($this->style) {
            $table .= ' style="' . $this->style . '"';
        }
        $table .= '>';
    
        // Erstelle die Tabellenüberschrift
        $table .= '<thead><tr>';
        foreach ($this->array2D[0] as $key => $value) {
            $table .= '<th>' . $value . '</th>';
        }
        $table .= '</tr></thead>';
    
        // Erstelle die Tabellenzeilen
        $table .= '<tbody>';
        foreach ($this->array2D as $row) {
            $table .= '<tr>';
            foreach ($row as $value) {
                $table .= '<td id="' . $this->id . '" class="' . $this->class . '" style="' . $this->style . '">' . $value . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</tbody>';
    
        $table .= '</table>';
        return $table;
    }    
}
?>