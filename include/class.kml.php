<?
/**
 * Class kml
 * This class allows generate dynamic kml file to publish in google earth
 * Need google earth installed to view kml file
 *
 * @author pablo kogan
 *
 *
 */
class kml {
	var $sBody;
	var $sHeader;
	var $sFooter;
	/**
	 * Constructor
	 */
	function kml($sName) {
		$this->sName = $sName;
		$this->sHeader = '<?xml version="1.0" encoding="UTF-8"?>';
		$this->sHeader .= '<kml xmlns="http://earth.google.com/kml/2.0">';

		$this->sHeader .= "<Document>
					<name>$sName</name>";
		/**
		 * To change the style generate kml in google eath y paste in the next
		 * line the header style.
		 */
		$this->sHeader .= "	";

		$this->sFooter .= "	</Document>";
		$this->sFooter .= '</kml>';
	}
	/**
	 * Add element to kml file
	 */
	function addElement($sElement) {
		$this->sBody .= $sElement;
	}
	/**
	 * Print kml, change the header to open Google earth
	 */
	function export() {
		header('Content-type: application/keyhole');
		//Para que modifique el nombre de lo que baja se agrega la siguiente línea.
		header('Content-Disposition:atachment; filename="' . $this->sName . '.kml"');
		//Para que cuando se baje el archivo el cliente IE y/o FireFox pregunte si bajar o guardar el archivo.
		//Hay que agregar al header Content-Disposition:atachment
		$sKml = $this->sHeader . $this->sBody . $this->sFooter;
		header('Content-Length: ' . strlen($sKml));
		header('Expires: 0');
		header('Pragma: cache');
		header('Cache-Control: private');
		echo $sKml;
	}
	/**
	 * Add point to kml file
	 * @param int $lat latitude
	 * @param int $lon longitude
	 * @param int $alt altitude
	 * @param string $tit title of point
	 * @param string $des description of point
	 * @param string $sLayer style of point default ''
	 */

	function addPoint($lon, $lat, $alt, $tit, $des, $sLayer = '') {
		$sResponse = '<Placemark>';
		$sResponse .= "<description>$des</description>";
		$sResponse .= "<name>$tit</name>";
		$sResponse .= '<visibility>1</visibility>';
		$sResponse .= "<styleUrl>#$sLayer</styleUrl>";
		$sResponse .= '<Point>';
		$sResponse .= "<coordinates>$lon,$lat,$alt</coordinates>";
		$sResponse .= '</Point>';
		$sResponse .= '</Placemark>';
		$this->addElement($sResponse);
	}
	/**
	 * Add line to kml file
	 * @param array $puntos poits of line array of array('lat'=>num,'lon'=>num,'alt'=num)
	 * @param string $tit title of line
	 * @param string $des description of line
	 * @param string $sLayer style of line default ''
	 */
	function addLine($puntos, $tit, $des, $sLayer = '') {
		$sResponse = "<Placemark>";
		$sResponse .= "<name>$tit</name>";
		$sResponse .= "<description>$des</description>";
		$sResponse .= "<styleUrl>#$sLayer</styleUrl>";
		$sResponse .= "<LineString>";
		$sResponse .= "<tessellate>1</tessellate>";
		$sResponse .= "<coordinates>";
		$primero = true;
		foreach ($puntos as $key => $punto) {
			if ($primero) {
				$sResponse .= $punto['lon'] . "," . $punto['lat'] . "," . $punto['alt'];
				$primero = false;
			} else
				$sResponse .= " " . $punto['lon'] . "," . $punto['lat'] . "," . $punto['alt'];
		}
		$sResponse .= "</coordinates>";
		$sResponse .= "</LineString>";
		$sResponse .= "</Placemark>";
		$this->addElement($sResponse);
	}
	/**
	 * Add Polygon
	 * @param array $puntos poits of polygon array of array('lat'=>num,'lon'=>num,'alt'=num)
	 * @param string $tit title of polygon
	 * @param string $des description of polygon
	 * @param string $sLayer style of polygon default ''
	*/
	function addPolygon($puntos, $tit, $des, $sLayer = '') {

		$sResponse = "<Placemark>";
		$sResponse .= "<name>$tit</name>";
		$sResponse .= "<styleUrl>#$sLayer</styleUrl>";
		$sResponse .= "<Polygon>";
		$sResponse .= "<tessellate>1</tessellate>";
		$sResponse .= "<outerBoundaryIs>
									<LinearRing>
										<coordinates>
					";
		$primero = true;
		foreach ($puntos as $key => $punto) {
			if ($primero) {
				$sResponse .= $punto['lon'] . "," . $punto['lat'] . "," . $punto['alt'];
				$primero = false;
			} else
				$sResponse .= " " . $punto['lon'] . "," . $punto['lat'] . "," . $punto['alt'];
		}
		$sResponse .= "</coordinates>
					  			  </LinearRing>
								</outerBoundaryIs>
							</Polygon>
						</Placemark>
					";
		$this->addElement($sResponse);
	}
	/**
	 * Add Link
	 * @param string $link link to file
	 * @param string $tit title of link
	 * @param string $sLayer style of link default ''
	*/
	function addLink($link, $tit) {
		$aScript = explode('/', $_SERVER[SCRIPT_NAME]);
		array_pop($aScript);
		$sScript = implode('/', $aScript);
		$sLink = "http://" . $_SERVER[SERVER_NAME] . "/" . $sScript . "/$link";
		$sResponse = "<NetworkLink>";
		$sResponse .= "<name>$tit</name>";
		$sResponse .= "<Url>
					<href>$sLink</href>
					<refreshMode>onInterval</refreshMode>
					<viewRefreshMode>onRequest</viewRefreshMode>
				</Url>
				</NetworkLink>";
		//echo $sResponse;
		$this->addElement($sResponse);
	}
	/**
	 * Add SreenOverlay
	 * @param string $link link to logo file
	 * @param string $tit title of logo
	*/
	function addScreenOverlay($link, $tit) {
		$aScript = explode('/', $_SERVER[SCRIPT_NAME]);
		array_pop($aScript);
		$sScript = implode('/', $aScript);
		$sLink = "http://" . $_SERVER[SERVER_NAME] . "/" . $sScript . "/$link";
		$sResponse = "<ScreenOverlay>";
		$sResponse .= "<name>$tit</name>";
		$sResponse .= "<Icon>
					<href>$sLink</href>
				</Icon>
	<overlayXY x=\"1\" y=\"1\" xunits=\"fraction\" yunits=\"fraction\"/>
	<screenXY x=\"1\" y=\"1\" xunits=\"fraction\" yunits=\"fraction\"/>
	<rotationXY x=\"0\" y=\"0\" xunits=\"fraction\" yunits=\"fraction\"/>
	<size x=\"0.1\" y=\"0.1\" xunits=\"fraction\" yunits=\"fraction\"/>
	</ScreenOverlay>";
		//echo $sResponse;
		$this->addElement($sResponse);
	}
}
?>