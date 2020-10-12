<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de RESTAURANTES
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RestaurantModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $documento;
    private $nombre;
    private $direccion;
    private $telefono;
    private $correo;
    private $logo;
    private $facebook;
    private $twitter;
    private $instagram;
    private $whatsapp;
    private $activo;
    private $imagencomanda;
    private $titulocomanda;
    private $textocomanda;
    private $imagencombo;
    private $titulocombo;
    private $textocombo;
    private $idMoneda;
    private $moneda;
    private $servicio;
    private $imprimirFactura;
    private $imprimirFacturaParaLlevar;
    private $iva;
    private $aux_1;
    private $aux_2;
    private $aux_3;
    private $fecha_registro;
    
	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }
    
    public function getDocumento() {
        return $this->documento;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getDireccion() {
        return $this->direccion;
    }
    
    public function getTelefono() {
        return $this->telefono;
    }
    
    public function getCorreo() {
        return $this->correo;
    }

    public function getLogo() {
        $ruta = DIR_IMG_REST."/".$this->id."/".$this->logo;
        $link = HOST_IMG_REST."/".$this->id."/".$this->logo."?update=".rand();
        if(file_exists($ruta) && is_File($ruta))
        {
            return $link;
        }
        else
        {
            return HOST.IMG_LOGO_DEFECTO;
        }
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function getInstagram() {
        return $this->instagram;
    }

    public function getWhatsapp() {
        return $this->whatsapp;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getimagencomanda() {
        $ruta = DIR_IMG_REST."/".$this->id."/".$this->imagencomanda;
        $link = HOST_IMG_REST."/".$this->id."/".$this->imagencomanda."?update=".rand();
        if(file_exists($ruta) && is_File($ruta))
        {
            return $link;
        }
        else
        {
            return $this->getLogo();
        }
    }

    public function gettitulocomanda() {
        return $this->titulocomanda;
    }

    public function gettextocomanda() {
        return $this->textocomanda;
    }

    public function getimagencombo() {
        $ruta = DIR_IMG_REST."/".$this->id."/".$this->imagencombo;
        $link = HOST_IMG_REST."/".$this->id."/".$this->imagencombo."?update=".rand();
        if(file_exists($ruta) && is_File($ruta))
        {
            return $link;
        }
        else
        {
            return $this->getLogo();
        }
    }

    public function gettitulocombo() {
        return $this->titulocombo;
    }

    public function gettextocombo() {
        return $this->textocombo;
    }

    public function getIdMoneda() {
        return $this->idMoneda;
    }

    public function getMoneda() {
        return $this->moneda;
    }

    public function getServicio() {
        return $this->servicio;
    }

    public function getAux1() {
        return $this->aux_1;
    }

    public function getAux2() {
        return $this->aux_2;
    }

    public function getAux3() {
        return $this->aux_3;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getRutaDB() {
        $archivo = RUTA_CARPETA_DB_TEMPORAL . "/{$this->getId()}_temporal.db";
        return $archivo;
    }

    public function getStatusServicio() {
        $archivo = $this->getRutaDB();
        if( file_exists($archivo) && is_file($archivo) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getImprimirFactura() {
        return $this->imprimirFactura;
    }


    public function getImprimirFacturaParaLLevar() {
        return $this->imprimirFacturaParaLlevar;
    }

    public function getIva() {
        return $this->iva;
    }
    
	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($idRestaurant)
    {
        $idRestaurant = (int) $idRestaurant;

        $query = "SELECT * FROM restaurantes WHERE idRestaurant = '{$idRestaurant}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("El restaurant (id: {$idRestaurant}) no esta registrado.");
        }

        $this->id = $datos[0]['idRestaurant'];
        $this->documento = $datos[0]['documento'];
        $this->nombre = $datos[0]['nombre'];
        $this->direccion = $datos[0]['direccion'];
        $this->telefono = $datos[0]['telefono'];
        $this->correo = $datos[0]['correo'];
        $this->logo = $datos[0]['logo'];
        $this->facebook = $datos[0]['facebook'];
        $this->twitter = $datos[0]['twitter'];
        $this->instagram = $datos[0]['instagram'];
        $this->whatsapp = $datos[0]['whatsapp'];
        $this->activo = boolval( $datos[0]['activo'] );
        $this->imagencomanda = $datos[0]['imagencomanda'];
        $this->titulocomanda = $datos[0]['titulocomanda'];
        $this->textocomanda = $datos[0]['textocomanda'];
        $this->imagencombo = $datos[0]['imagencombo'];
        $this->titulocombo = $datos[0]['titulocombo'];
        $this->textocombo = $datos[0]['textocombo'];
        $this->idMoneda = $datos[0]['idMoneda'];
        $this->moneda = new MonedaModel($this->idMoneda);
        $this->servicio = boolval( $datos[0]['servicio'] );
        $this->imprimirFactura = boolval( $datos[0]['imprimirFactura'] );
        $this->imprimirFacturaParaLlevar = boolval( $datos[0]['imprimirFacturaParaLlevar'] );
        $this->iva = $datos[0]['iva'];
        $this->aux_1 = $datos[0]['aux_1'];
        $this->aux_2 = $datos[0]['aux_2'];
        $this->aux_3 = $datos[0]['aux_3'];
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }

    /*============================================================================
	 *
	 *	SETTER
	 *
    ============================================================================*/
    public function setDocumento( $documento ) {
        $documento = Filtro::General($documento);
        $this->set("documento", $documento);
        $this->documento = $documento;
    }
    
    public function setNombre( $nombre ) {
        $nombre = Filtro::General($nombre);
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
    }

    public function setDireccion( $direccion ) {
        $direccion = Filtro::General($direccion);
        $this->set("direccion", $direccion);
        $this->direccion = $direccion;
    }
    
    public function setTelefono( $telefono ) {
        $telefono = Filtro::General($telefono);
        $this->set("telefono", $telefono);
        $this->telefono = $telefono;
    }
    
    public function setCorreo( $correo ) {
        $correo = Filtro::General($correo);
        $this->set("correo", $correo);
        $this->correo = $correo;
    }
    
    public function setLogo( $logo ) {
        $logo = Filtro::General($logo);
        $this->set("logo", $logo);
        $this->logo = $logo;
    }

    public function setFacebook( $facebook ) {
        $facebook = Filtro::General($facebook);
        $this->set("facebook", $facebook);
        $this->facebook = $facebook;
    }

    public function setTwitter( $twitter ) {
        $twitter = Filtro::General($twitter);
        $this->set("twitter", $twitter);
        $this->twitter = $twitter;
    }

    public function setInstagram( $instagram ) {
        $instagram = Filtro::General($instagram);
        $this->set("instagram", $instagram);
        $this->instagram = $instagram;
    }

    public function setWhatsapp( $whatsapp ) {
        $whatsapp = Filtro::General($whatsapp);
        $this->set("whatsapp", $whatsapp);
        $this->whatsapp = $whatsapp;
    }
    
    public function setimagencomanda( $imagencomanda ) {
        $imagencomanda = Filtro::General($imagencomanda);
        $this->set("imagencomanda", $imagencomanda);
        $this->imagencomanda = $imagencomanda;
    }

    public function settitulocomanda( $titulocomanda ) {
        $titulocomanda = Filtro::General($titulocomanda);
        $this->set("titulocomanda", $titulocomanda);
        $this->titulocomanda = $titulocomanda;
    }

    public function settextocomanda( $textocomanda ) {
        $textocomanda = Filtro::General($textocomanda);
        $this->set("textocomanda", $textocomanda);
        $this->textocomanda = $textocomanda;
    }

    public function setimagencombo( $imagencombo ) {
        $imagencombo = Filtro::General($imagencombo);
        $this->set("imagencombo", $imagencombo);
        $this->imagencombo = $imagencombo;
    }

    public function settitulocombo( $titulocombo ) {
        $titulocombo = Filtro::General($titulocombo);
        $this->set("titulocombo", $titulocombo);
        $this->titulocombo = $titulocombo;
    }

    public function settextocombo( $textocombo ) {
        $textocombo = Filtro::General($textocombo);
        $this->set("textocombo", $textocombo);
        $this->textocombo = $textocombo;
    }

    public function setIdMoneda($idMoneda) {
        $idMoneda = (int) $idMoneda;
        $this->set("idMoneda", $idMoneda);
        $this->idMoneda = $idMoneda;
        $this->moneda = new MonedaModel($this->idMoneda);
    }

    public function setServicio($boolval) {
        $boolval = (int) boolval($boolval);
        $this->set("servicio", $boolval);
        $this->servicio = $boolval;
    }

    public function setActivo( $activo ) {
        $activo = (int) $activo;
        $this->set("activo", $activo);
        $this->activo = boolval( $activo );
    }

    public function setImprimirFactura( $imprimirFactura ) {
        $imprimirFactura = (int) $imprimirFactura;
        $this->set("imprimirFactura", $imprimirFactura);
        $this->imprimirFactura = boolval( $imprimirFactura );
    }

    public function setImprimirFacturaParaLLevar( $imprimirFacturaParaLlevar ) {
        $imprimirFacturaParaLlevar = (int) $imprimirFacturaParaLlevar;
        $this->set("imprimirFacturaParaLlevar", $imprimirFacturaParaLlevar);
        $this->imprimirFacturaParaLlevar = boolval( $imprimirFacturaParaLlevar );
    }

    public function setIva( $iva ) {
        $this->set("iva", $iva);
        $this->iva = $iva;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE restaurantes SET {$columna} = '{$valor}' WHERE idRestaurant = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' en el restaurant.");
        }
    }
}