<?php
    $objUsuario = Sesion::getUsuario();
    $idRol = $objUsuario->getRol()->getId();
?>

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
                $menu = new MenuBModel(-1);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4">
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

                $menu = new MenuBModel(0);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4">
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

                $menu = new MenuBModel(1);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4">
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

                $menu = new MenuBModel(-2);
                if($menu->Verificar( $idRol ))
                {
                    ?>
                        <div class="col-12 col-sm-6 col-md-4">
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
                        <div class="col-12 col-sm-6 col-md-4">
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
                        <div class="col-12 col-sm-6 col-md-4">
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