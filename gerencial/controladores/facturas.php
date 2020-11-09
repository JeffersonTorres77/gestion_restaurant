<?php
use Dompdf\Dompdf;

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del FACTURAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Controlador extends ControladorBase
{
    /*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct()
    {
        $this->ValidarSesion();

        if( !Peticion::getEsAjax() )
        {
            Incluir::Template("modelo_gerencial");
            Template::Iniciar();
        }

        if(!MenusAModel::Verificar(7, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a este modulo.");
            exit;
        }
    }
    
    /*============================================================================
	 *
	 *	Destructor
	 *
    ============================================================================*/
    public function __destruct()
    {
        if(!Peticion::getEsAjax()) {
            Template::Finalizar();
        }
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function hoy()
    {
        if(!MenusBModel::Verificar(4, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $this->Vista("facturas/hoy");
        $this->Javascript("facturas/hoy");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function general()
    {
        if(!MenusBModel::Verificar(5, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $this->Vista("facturas/general");
        $this->Javascript("facturas/general");
    }
    
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("facturas/crud");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function ver($parametros = [])
    {
        if(!isset($parametros[0])) {
            $this->Error('No se ha enviado el identificador de la factura.');
            return;
        }

        $idFactura = $parametros[0];

        try {
            $objFactura = new FacturaModel($idFactura);
        } catch(Exception $e) {
            $this->Error("El identificador de factura <b>{$idFactura}</b> no existe.");
            return;
        }

        $this->Vista("facturas/ver", ['objFactura' => $objFactura]);
        $this->Javascript("facturas/ver");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function pdf($parametros = [])
    {
        if(!isset($parametros[0])) {
            $this->Error('No se ha enviado el identificador de la factura.');
            return;
        }

        $objRestaurant = Sesion::getRestaurant();
        $idFactura = $parametros[0];

        try {
            $objFactura = new FacturaModel($idFactura);
        } catch(Exception $e) {
            $this->Error("El identificador de factura <b>{$idFactura}</b> no existe.");
            return;
        }

        $objMoneda = new MonedaModel( $objFactura->getIdMoneda() );
        $iva = $objFactura->getIva();
        
        $mesa = "Para llevar";
        if($objFactura->getIdMesa() != "-1") {
            try {
                $objMesa = new MesaModel( $objFactura->getIdMesa() );
                $mesa = $objMesa->getAlias();
            } catch(Exception $e) {
                $mesa = "{$objFactura->getIdMesa()} (Mesa eliminada)";
            }
        }

        // instantiate and use the dompdf class
        $html = "";
        $dompdf = new Dompdf();

        $totalFactura = 0;
        $detalles = $objFactura->getItems();
        $htmlDetalles = "";
        foreach($detalles as $detalle) {
            $descripcion = $detalle['nombrePlato'];
            $precio = $detalle['precioUnitario'];
            $descuento = $detalle['descuento'];
            $cantidad = $detalle['cantidad'];
            $total = $detalle['precioTotal'];

            $nombreCombo = $detalle['nombreCombo'];
            $loteCombo = $detalle['loteCombo'];

            if($loteCombo != '0') {
                $descripcion = "{$nombreCombo} - {$descripcion}";
            }

            $precio = $precio * (1 - ($descuento / 100));

            $htmlDetalles .= '<tr>
                <td>'.$descripcion.'</td>
                <td style="text-align: right;">'.Formato::Precio($precio, $objMoneda).'</td>
                <td style="text-align: center;">'.$cantidad.'</td>
                <td style="text-align: right;">'.Formato::Precio($total, $objMoneda).'</td>
            </tr>';

            $totalFactura += $total;
        }

        $html .= '<style>
            html, body { margin: 0px; padding: 0px; }
            table thead tr th { text-align: left; padding: 5px; }
            table tbody tr td { text-align: left; padding: 5px; }
            table tbody tr:nth-child(2n-1) td { background: rgba(0,0,0,0.1); }
        </style>';

        $html .= '
        <div style="border-bottom: 1px solid rgba(0,0,0,0.25); padding: 15px; font-size: 20px; background: rgba(0,0,0,0.05);">
            <label>'.$objRestaurant->getNombre().'</label>
        </div>

        <div style="padding: 10px;">
            <div style="text-align: center; padding-top: 5px; padding-bottom: 15px; font-size: 18px; font-weight: bold;">
                Recibo de pago
            </div>
            
            <div style="width: 100%; position: relative; padding-bottom: 20px;">
                <div>
                    <div>ID: '.$objFactura->getId().'</div>
                    <div>Mesa: '.$mesa.'</div>
                </div>

                <div style="position: absolute; top: 0px; right: 0px; text-align: right;">
                    <div>Fecha: '.Formato::FechaCorta($objFactura->getFecha()).'</div>
                    <div>Hora: '.$objFactura->getHora().'</div>
                </div>
            </div>

            <table style="width: 100%;" border="1" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: auto;">Descripción</th>
                        <th style="width: 125px;">Precio</th>
                        <th style="width: 50px;">Cantidad</th>
                        <th style="width: 125px;">Total</th>
                    </tr>
                </thead>

                <tbody>
                    '.$htmlDetalles.'

                    <tr>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td colspan="3">SubTotal</td>
                        <td style="font-weight: bold; text-align: right;">'.Formato::Precio($totalFactura, $objMoneda).'</td>
                    </tr>

                    <tr>
                        <td colspan="3">Impuestos ('.$iva.'%)</td>
                        <td style="font-weight: bold; text-align: right;">'.Formato::Precio($totalFactura * ($iva / 100), $objMoneda).'</td>
                    </tr>

                    <tr>
                        <td colspan="3">Total</td>
                        <td style="font-weight: bold; text-align: right;">'.Formato::Precio($totalFactura * (1 + ($iva / 100)), $objMoneda).'</td>
                    </tr>
                </tbody>
            </table>
        </div>';

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('prueba.pdf', ['Attachment' => FALSE]);
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function enviar_correo()
    {
        $this->AJAX("facturas/enviar_correo");
    }
}