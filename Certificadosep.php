<?php
/*Clase para crear XML de certificado electrónico de la SEP MEC V2.0
Creada por Ing. MTW Luis Gerardo Merino Figueroa
05/03/2020
*/
class certificadosep
{
	private $xml;
	private $Sello;
	private $root;
	private $folioControl;
	private $certificadoResponsable;
	private $nocertificadoResponsable;
	private $Version;
	private $tipoCertificado;
	function __construct() {

    }
public function getXml(){ return $this->xml; }
public function getXmlFinal(){ $this->xml->formatOutput = true;return $this->xml->saveXML(); }
public function setXml($xml){ $this->xml=$xml; }
public function getSello(){ return $this->sello; }
public function setSello($sello){ $this->Sello=$sello; }
public function getRoot(){ return $this->root; }
public function setRoot($root){ $this->root=$root; }
public function getFolioControl(){ return $this->folioControl; }
public function setFolioControl($folioControl){ $this->folioControl=$folioControl; }
public function getCertificadoResponsable(){ return $this->certificadoResponsable; }
public function setCertificadoResponsable($certificadoResponsable){ $this->certificadoResponsable=$certificadoResponsable; }
public function getNocertificadoResponsable(){ return $this->nocertificadoResponsable; }
public function setNocertificadoResponsable($nocertificadoResponsable){ $this->nocertificadoResponsable=$nocertificadoResponsable; }

public function genera_xml($arr)
{
	$this->xml = new DOMdocument("1.0","utf-8");
$this->xml_generales($arr);
$this->xml_ipes($arr);
$this->xml_Rvoe($arr);
$this->xml_carrera($arr);
$this->xml_alumno($arr);
$this->xml_asignaturas($arr);
$this->xml_expedicion($arr);
}
private function xml_generales($arr)
{
$xml=$this->getXml();
$root=$this->getRoot();
$root =$xml->createElement("Dec");
$root=$xml->appendChild($root);
$this->cargaAtt($root, array("xmlns"=>"https://www.siged.sep.gob.mx/certificados",


						"version"=>$arr["version"],
						"tipoCertificado"=>$arr["tipoCertificado"],
						"folioControl"=>$arr["folioControl"],
						"Sello"=>$arr["Sello"],
						"certificadoResponsable"=>$arr["certificadoResponsable"],
						"noCertificadoResponsable"=>$arr["noCertificadoResponsable"],
					 )
				 );
$this->setXml($xml);
$this->setRoot($root);
}
private function xml_Ipes($arr)
{
	$xml=$this->getXml();
	$root=$this->getRoot();
	$ipes =$xml->createElement("Ipes");
	$responsable=$xml->createElement("Responsable");

	$responsable=$ipes->appendChild($responsable);
	$this->cargaAtt($ipes,array("idNombreInstitucion"=>$arr['Ipes']["idNombreInstitucion"],
							"nombreInstitucion"=>$arr['Ipes']["nombreInstitucion"],
							"idCampus"=>$arr['Ipes']["idCampus"],
							"campus"=>$arr['Ipes']["campus"],
							"idEntidadFederativa"=>$arr['Ipes']["idEntidadFederativa"],
							"entidadFederativa"=>$arr['Ipes']["entidadFederativa"],
						 )
					 );
					 $this->cargaAtt($responsable,array("curp"=>$arr['Ipes']["Responsable"]["curp"],
			 								"nombre"=>$this->fix_chr($arr['Ipes']["Responsable"]["nombre"]),
											"primerApellido"=>$this->fix_chr($arr['Ipes']["Responsable"]["primerApellido"]),
											"segundoApellido"=>$this->fix_chr($arr['Ipes']["Responsable"]["segundoApellido"]),
											"idCargo"=>$arr['Ipes']["Responsable"]["idCargo"],
											"cargo"=>$this->fix_chr($arr['Ipes']["Responsable"]["cargo"]),

			 							 )
			 						 );
	$ipes=$root->appendChild($ipes);
	$this->setXml($xml);
	$this->setRoot($root);

}
private function xml_Rvoe($arr)
{
	$xml=$this->getXml();
	$root=$this->getRoot();
	$rvoe =$xml->createElement("Rvoe");
	$rvoe=$root->appendChild($rvoe);
	$this->cargaAtt($rvoe,array("numero"=>$arr['Rvoe']["numero"],
							"fechaExpedicion"=>$arr['Rvoe']["fechaExpedicion"]
						)
					 );
	$this->setXml($xml);
	$this->setRoot($root);

}
private function xml_carrera($arr)
{
	$xml=$this->getXml();
	$root=$this->getRoot();
	$carrera =$xml->createElement("Carrera");
	$carrera=$root->appendChild($carrera);
	$this->cargaAtt($carrera,array("idCarrera"=>$arr['Carrera']["idCarrera"],
							"claveCarrera"=>$arr['Carrera']["claveCarrera"],
							"nombreCarrera"=>$this->fix_chr($arr['Carrera']["nombreCarrera"]),
							"idTipoPeriodo"=>$arr['Carrera']["idTipoPeriodo"],
							"clavePlan"=>$arr['Carrera']["clavePlan"],
							"idNivelEstudios"=>$arr['Carrera']["idNivelEstudios"],
							"calificacionMinima"=>$arr['Carrera']["calificacionMinima"],
							"calificacionMaxima"=>$arr['Carrera']["calificacionMaxima"],
							"calificacionMinimaAprobatoria"=>$arr['Carrera']["calificacionMinimaAprobatoria"],
						)
					 );
	$this->setXml($xml);
	$this->setRoot($root);
}
private function xml_alumno($arr)
{
	$xml=$this->getXml();
	$root=$this->getRoot();
	$alumno =$xml->createElement("Alumno");
	$alumno=$root->appendChild($alumno);
	$this->cargaAtt($alumno,array("numeroControl"=>	$arr['Alumno']["numeroControl"],
		"curp"=>	$arr['Alumno']["curp"],
		"nombre"=>	$arr['Alumno']["nombre"],
		"primerApellido"=>	$arr['Alumno']["primerApellido"],
		"segundoApellido"=>	$arr['Alumno']["segundoApellido"],
		"idGenero"=>	$arr['Alumno']["idGenero"],
		"fechaNacimiento"=>	$arr['Alumno']["fechaNacimiento"],
		"foto"=>	$arr['Alumno']["foto"],
	)
					 );
	$this->setXml($xml);
	$this->setRoot($root);
}
private function xml_expedicion($arr)
{
	$xml=$this->getXml();
	$root=$this->getRoot();
	$expedicion =$xml->createElement("Expedicion");
	$expedicion=$root->appendChild($expedicion);
	$this->cargaAtt($expedicion,array("idTipoCertificacion"=>	$arr['Expedicion']["idTipoCertificacion"],
	"tipoCertificaciontipoCertificacion"=>	$arr['Expedicion']["tipoCertificacion"],
		"fecha"=>	$arr['Expedicion']["fecha"],
		"idLugarExpedicion"=>	$arr['Expedicion']["idLugarExpedicion"],
		"lugarExpedicion"=>	$arr['Expedicion']["lugarExpedicion"],
	)
					 );
	$this->setXml($xml);
	$this->setRoot($root);
}
private function xml_asignaturas($arr)
{
	$xml=$this->getXml();
	$root=$this->getRoot();
	$asignaturas =$xml->createElement("Asignaturas");
$asignaturas=$root->appendChild($asignaturas);
	$this->cargaAtt($asignaturas,array("total"=>	$arr['Asignaturas']["total"],
							"asignadas"=>	$arr['Asignaturas']["asignadas"],
							"promedio"=>	$arr['Asignaturas']["promedio"],
							"totalCreditos"=>	$arr['Asignaturas']["totalCreditos"],
							"CreditosObtenidos"=>	$arr['Asignaturas']["CreditosObtenidos"],
						 )
					 );
	for($i=0;$i<sizeof($arr['Asignaturas']["Asignatura"]);$i++)
	{
		$asignatura=$xml->createElement("Asignatura");
		$asignatura=$asignaturas->appendChild($asignatura);
		$this->cargaAtt($asignatura,array("idAsignatura"=>$arr['Asignaturas']["Asignatura"][$i]["idAsignatura"],
								"claveAsignatura"=>$arr['Asignaturas']["Asignatura"][$i]["claveAsignatura"],
								"nombre"=>$this->fix_chr($arr['Asignaturas']["Asignatura"][$i]["nombre"]),
								"ciclo"=>$arr['Asignaturas']["Asignatura"][$i]["ciclo"],
								"calificacion"=>$arr['Asignaturas']["Asignatura"][$i]["calificacion"],
								"idTipoAsignatura"=>$arr['Asignaturas']["Asignatura"][$i]["idTipoAsignatura"],
								"idObservaciones"=>$arr['Asignaturas']["Asignatura"][$i]["idObservaciones"],
								"observaciones"=>$arr['Asignaturas']["Asignatura"][$i]["observaciones"],
								"tipoAsignatura"=>$arr['Asignaturas']["Asignatura"][$i]["tipoAsignatura"],
								"creditos"=>$arr['Asignaturas']["Asignatura"][$i]["creditos"],
							)
						 );

	}

	$this->setXml($xml);
	$this->setRoot($root);

}
private function cargaAtt(&$nodo, $attr) {

	foreach ($attr as $key => $val) {
		for ($i=0;$i<strlen($val); $i++) {
			$a = substr($val,$i,1);
			if ($a > chr(127) && $a !== chr(219) && $a !== chr(211) && $a !== chr(209)) {
				//$val = substr_replace($val, ".", $i, 1);
			}
		}
		$val = preg_replace('/\s\s+/', ' ', $val);   // Regla 5a y 5c
		$val = trim($val);                           // Regla 5b
		if (strlen($val)>0) {   // Regla 6
			$val = str_replace(array('"','>','<'),"'",$val);  // &...;
			$val = utf8_encode(str_replace("|","/",$val)); // Regla 1
			$nodo->setAttribute($key,$val);
		}
	}
	}
	public function xml_sella($arr) {

		$certificado = $arr['fiel'];
		$llave=$arr['llave'];
		$password=$arr['password'];
		$cadena_original=$arr['cadena_original'];
				// Ruta al archivo
		// Obtiene la llave privada del Certificado de Sello Digital (CSD),
		//    Ojo , Nunca es la FIEL/FEA
		$certificadom=$this->getCertificate($_SERVER['DOCUMENT_ROOT']."/managecesba/cer/".$certificado, false );
		$claveprivada=$this->getPrivateKey($_SERVER['DOCUMENT_ROOT']."/managecesba/cer/".$llave, $password);
		$claveprivadafisica=$this->generatePrivateKey($_SERVER['DOCUMENT_ROOT']."/managecesba/cer/".$llave, $password);
		/*
		$this->root->setAttribute("Certificado",$certificadom);
		$this->satxmlsv33_genera_cadena_original();*/
		$sello=$this->signData($claveprivada,trim($cadena_original));


return $sello;
		}
		public function gen_cadena_original($arr)
		{
			$cadena="|";
			$cadena.="|".$arr['version'];
			$cadena.="|".$arr['tipoCertificado'];
			$cadena.="|".$arr['Ipes']["idNombreInstitucion"];
			$cadena.="|".$arr['Ipes']["idCampus"];
			$cadena.="|".$arr['Ipes']["idEntidadFederativa"];
			$cadena.="|".$arr['Ipes']["Responsable"]["curp"];
			$cadena.="|".$arr['Ipes']["Responsable"]["idCargo"];
			$cadena.="|".$arr['Rvoe']["numero"];
			$cadena.="|".$arr['Rvoe']["fechaExpedicion"];
			$cadena.="|".$arr['Carrera']["idCarrera"];
			$cadena.="|".$arr['Carrera']["idTipoPeriodo"];
			$cadena.="|".$arr['Carrera']["clavePlan"];
			$cadena.="|".$arr['Carrera']["idNivelEstudios"];
			$cadena.="|".$arr['Carrera']["calificacionMinima"];
			$cadena.="|".$arr['Carrera']["calificacionMaxima"];
			$cadena.="|".$arr['Carrera']["calificacionMinimaAprobatoria"];
			$cadena.="|".$arr['Alumno']["numeroControl"];
			$cadena.="|".$arr['Alumno']["curp"];
			$cadena.="|".$arr['Alumno']["nombre"];
			$cadena.="|".$arr['Alumno']["primerApellido"];
			$cadena.="|".$arr['Alumno']["segundoApellido"];
			$cadena.="|".$arr['Alumno']["idGenero"];
			$cadena.="|".$arr['Alumno']["fechaNacimiento"];
			$cadena.="|".$arr['Alumno']["foto"];
				$cadena.="|".$arr['Alumno']["firmaAutografa"];
			$cadena.="|".$arr['Expedicion']["idTipoCertificacion"];
			$cadena.="|".$arr['Expedicion']["fecha"];
			$cadena.="|".$arr['Expedicion']["idLugarExpedicion"];
			$cadena.="|".$arr['Asignaturas']["total"];
			$cadena.="|".$arr['Asignaturas']["asignadas"];
			$cadena.="|".$arr['Asignaturas']["promedio"];
			$cadena.="|".$arr['Asignaturas']["totalCreditos"];
			$cadena.="|".$arr['Asignaturas']["CreditosObtenidos"];
	for($i=0;$i<count($arr['Asignaturas']["Asignatura"]);$i++){
			$cadena.="|".$arr['Asignaturas']["Asignatura"][$i]["idAsignatura"];
			$cadena.="|".$arr['Asignaturas']["Asignatura"][$i]["ciclo"];
			$cadena.="|".$arr['Asignaturas']["Asignatura"][$i]["calificacion"];
			$cadena.="|".$arr['Asignaturas']["Asignatura"][$i]["idTipoAsignatura"];
			$cadena.="|".$arr['Asignaturas']["Asignatura"][$i]["creditos"];

	}
			$cadena.="|";

			return trim($cadena);
		}
		private function signData ( $key, $data )
		{
		$pkeyid = openssl_get_privatekey( $key );

		// On 2011 Signing algorythm changes from MD5 to SHA1 (Thanks to eDwaRd for the reminder)
		if ( openssl_sign( $data, $cryptedata, $pkeyid, OPENSSL_ALGO_SHA256) ) {

		openssl_free_key( $pkeyid );

		return base64_encode( $cryptedata );
		}
		}
		public function getCertificate ( $cer_path, $to_string = true )
		{
		$cmd = 'openssl x509 -inform DER -outform PEM -in '.$cer_path.' -pubkey';
		if ( $result = shell_exec( $cmd ) ) {
		unset( $cmd );

		if ( $to_string ) {

		return $result;
		}

		$split = preg_split( '/\n(-*(BEGIN|END)\sCERTIFICATE-*\n)/', $result );
		unset( $result );

		return preg_replace( '/\n/', '', $split[1] );
		}

		return false;
		}
		private function generateCertificate($cer_path){

		$cmd = 'openssl x509 -inform DER -outform PEM -in '.$cer_path.' -out tempcer.cer.pem';
		if ( $result = shell_exec( $cmd ) ) {
		unset( $cmd );

		return $result;
		}

		return false;

		}
		private function generatePrivateKey($key_path,$password){

		$cmd = 'openssl pkcs8 -inform DER -in '.$key_path.' -out tempkey.key.pem -passin pass:'.$password;
		if ( $result = shell_exec( $cmd ) ) {
		unset( $cmd );

		return $result;
		}

		return false;

		}
		private function getPFX ( $cer_path,$key_path,$password )
		{
		$cmd = 'openssl pkcs12 -export -in'.$cer_path.'-inkey '.$key_path.' -passout pass:'.$password;
		if ( $result = shell_exec( $cmd ) ) {
		unset( $cmd );

		return $result;
		}

		return false;
		}
		private function getPrivateKey ( $key_path, $password )
		{
		$cmd = 'openssl pkcs8 -inform DER -in '.$key_path.' -passin pass:'.$password;
		if ( $result = shell_exec( $cmd ) ) {
		unset( $cmd );

		return $result;
		}

		return false;
		}
		private function fix_chr($nomb) {
			$nomb = str_replace(array(".","/")," ",$nomb);
			return ($nomb);
		}
		function utf8_for_xml($string)
	 {
		 return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
												 ' ', $string);
	 }

}
?>
