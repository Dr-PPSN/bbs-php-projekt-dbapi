<?php

require_once("hv-html.php");
require_once '../api/helper.php';

class HV_Map extends HV_HTML
{
  protected $coordinates = array();

  public function __construct($coordinates, $class, $id, $style)
  {
    $this->coordinates = $coordinates;
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }
  public function getMap()
  {
    if (count($this->coordinates) > 0) {
      return '<div class="vh-20"' . $this->getMainTagAttributes() . '></div>
      <script>
        var map = new ol.Map({
          target: "' . $this->id . '",
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM()
            })
          ],
          view: new ol.View({
            center: ol.proj.fromLonLat([' . $this->coordinates["longitude"] . ', ' . $this->coordinates["latitude"] . ']),
            zoom: 17
          })
        });
      </script>';
    }
    return "<div" . $this->getMainTagAttributes() . ">Keine Position auf der Karte gefunden!</div>";;
  }
}

?>