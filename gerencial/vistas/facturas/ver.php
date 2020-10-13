<?php
    $iva = $objFactura->getIva();
    $objMoneda = new MonedaModel( $objFactura->getIdMoneda() );

    if($objFactura->getIdMesa() != "-1")
    {
        try {
            $objMesa = new MesaModel( $objFactura->getIdMesa() );
            $mesa = $objMesa->getAlias();
        } catch(Exception $e) {
            $mesa = "{$objFactura->getIdMesa()} (Mesa eliminada)";
        }
    }
    else
    {
        $mesa = "Para llevar";
    }
?>

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <a class="pr-2" href="#" onclick="history.go(-1)">
                    <i class="fas fa-sm fa-arrow-left"></i>
                </a>
            </div>

            <h5 class="mb-0">
                <?php echo "Factura N° {$objFactura->getId()}"; ?>
            </h5>
        </div>

        <div class="card-body">
            <div>
                <div class="float-left">
                    <div>
                        Numero: <b><?php echo $objFactura->getId(); ?></b>
                    </div>

                    <div>
                        Mesa: <b><?php echo $mesa; ?></b>
                    </div>
                </div>

                <div class="float-right">
                    <div>
                        Fecha: <b><?php echo Formato::FechaCorta($objFactura->getFecha()); ?></b>
                    </div>
                    
                    <div>
                        Hora: <b><?php echo $objFactura->getHora(); ?></b>
                    </div>
                </div>
            </div>

            <div class="table-responsive pt-3">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-sm">
                        <tr>
                            <th class="w-auto">Descripción</th>
                            <th class="w-150px">Precio</th>
                            <th class="w-50px">Cantidad</th>
                            <th class="w-150px">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $totalFactura = 0;
                            $detalles = $objFactura->getItems();
                            foreach($detalles as $detalle)
                            {
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

                                ?>
                                    <tr class="table-sm">
                                        <td class="text-truncate">
                                            <?php echo $descripcion; ?>
                                        </td>

                                        <td right class="text-truncate">
                                            <?php echo Formato::Precio($precio, $objMoneda); ?>
                                        </td>

                                        <td center>
                                            <?php echo $cantidad; ?>
                                        </td>

                                        <td right class="text-truncate">
                                            <?php echo Formato::Precio($total, $objMoneda); ?>
                                        </td>
                                    </tr>
                                <?php

                                $totalFactura += $total;
                            }
                        ?>

                        <tr class="font-weight-bold table-sm">
                            <td colspan="3">
                                SubTotal
                            </td>

                            <td right>
                                <?php echo Formato::Precio($totalFactura, $objMoneda); ?>
                            </td>
                        </tr> 

                        <tr class="font-weight-bold table-sm">
                            <td colspan="3">
                                Impuestos (<?php echo $iva."%"; ?>)
                            </td>

                            <td right>
                                <?php echo Formato::Precio($totalFactura * ($iva / 100), $objMoneda); ?>
                            </td>
                        </tr> 

                        <tr class="font-weight-bold table-sm">
                            <td colspan="3">
                                Total
                            </td>

                            <td right>
                                <?php echo Formato::Precio($totalFactura * (1 + ($iva / 100)), $objMoneda); ?>
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>