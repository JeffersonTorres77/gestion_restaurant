<?php

$objRestaurant = Sesion::getRestaurant();
$idFactura = Input::POST('idFactura', TRUE);
$correo = Input::POST('correo', TRUE);

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

// Detalles
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

// Constantes
$fromemail = CORREO['correo'];
$pass = CORREO['clave'];
$fromname = CORREO['nombre'];
$host = CORREO['host'];
$port = CORREO['port'];
$SMTPAuth = CORREO['SMTPAuth'];
$SMTPSecure = "ssl";

// Incluir librerias
include_once(BASE_DIR . "_core/APIs/Mailer/src/PHPMailer.php");
include_once(BASE_DIR . "_core/APIs/Mailer/src/SMTP.php");
include_once(BASE_DIR . "_core/APIs/Mailer/src/Exception.php");

// Codigo HTML
$html = "";

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
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left;">ID: '.$objFactura->getId().'</td>
                <td style="text-align: right;">Hora: '.$objFactura->getHora().'</td>
            </tr>

            <tr>
                <td style="text-align: left;">Mesa: '.$mesa.'</td>
                <td style="text-align: right;">Fecha: '.Formato::FechaCorta($objFactura->getFecha()).'</td>
            </tr>
        </table>
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

// Preparar el mensaje
$emailTo = $correo;
$subjet	= "Recibo de pago - {$objRestaurant->getNombre()}";
$bodyEmail = "Hello world";

try
{
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    if(CORREO['isSMTP']) $mail -> isSMTP();
    $mail ->SMPTDebug = 0;
    $mail ->Host = $host ;
    $mail ->Port= $port;
    $mail ->SMTPAuth= $SMTPAuth;
    $mail ->SMTPSecure= $SMTPSecure;
    $mail ->Username = $fromemail;
    $mail ->Password = $pass;
    $mail ->setFrom($fromemail,$fromname);
    $mail ->addAddress($emailTo);

    //ASUNTO
    $mail ->isHTML(true);
    $mail ->Subject = $subjet;

    // CUERPO
    $mail->Body = $html;

    if (!$mail->send()) {
        throw new Exception("No se ha podido enviar la solicitud para recuperar las credenciales al Correo solicitado. Por favor Revise.<br>{$mail->ErrorInfo}");
    }
}
catch(Exception $e)
{
    throw new Exception($e->getMessage());
}