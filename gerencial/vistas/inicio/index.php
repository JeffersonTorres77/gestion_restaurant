<?php
    $objUsuario = Sesion::getUsuario();
    $idRol = $objUsuario->getRol()->getId();
?>

<?php
    $objRestaurant = Sesion::getRestaurant();
    $activo = $objRestaurant->getServicio();
    $alertClass = ($activo) ? 'alert alert-success' : 'alert alert-danger';
    $alertText = ($activo) ? 'Servicio activo' : 'Servicio no activo';
    $btnClass = ($activo) ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success';
?>
<div class="m-2 p-2">
    <div class="<?php echo $alertClass ?> mb-0">
        <?php echo $alertText ?>

        <?php
            if($objUsuario->getRol()->getResponsable())
            {
                ?>
                    <div class="position-absolute p-2" style="top: 0px; right: 0px;">
                        <button class="<?php echo $btnClass ?>" onclick="CambiarServicio()">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </div>
                <?php
            }
        ?>
    </div>
</div>

<div class="m-2 p-2">
    <div class="">
        <div class="card card-header bg-primary text-white mb-3" style="background: #5C8AE5 !important;">
            <h5 class="mb-0">Opciones rapidas</h5>
        </div>

        <div class="row">
            <?php
                $menu = new MenuAModel(1);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                $menu = new MenuAModel(2);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                $menu = new MenuAModel(3);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                $menu = new MenuAModel(8);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                $menu = new MenuAModel(9);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>

        <div class="card card-header bg-primary text-white mb-3 mt-3" style="background: #5C8AE5 !important;">
            <h5 class="mb-0">Monitoreos</h5>
        </div>

        <div class="row">
            <?php
                $menu = new MenuBModel(1);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                $menu = new MenuBModel(2);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                $menu = new MenuBModel(3);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                            <div class="wrimagecard wrimagecard-topimage">
                                <a href="<?php echo HOST_GERENCIAL . $menu->getLink(); ?>">
                                    <div class="wrimagecard-topimage_header">
                                        <center class="icon_interfaz"> <i class="<?php echo $menu->getImg(); ?>"></i></center>
                                    </div>

                                    <div class="wrimagecard-topimage_title">
                                        <h4 class="centrar"><?php echo $menu->getNombre(); ?>
                                            <div class="pull-right badge"> </div>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>