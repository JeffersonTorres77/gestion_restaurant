<?php
    $objUsuario = Sesion::getUsuario();
    $idRol = Sesion::getUsuario()->getRol()->getId();
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion menu-lateral" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="panel-usuario row">
                <div class="ml-2" style="height: 48px;">
                    <label class="usuario-miniatura border-secondary bg-light mb-0">
                        <img src="<?php echo $objUsuario->getFoto(); ?>">
                    </label>
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col-12 nombre px-2">
                            <?php echo $objUsuario->getNombre(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 rol px-2">
                            <?php echo $objUsuario->getRol()->getNombre(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav">

                <!--====================================================================
                    Seccion por defecto: Inicio
                =====================================================================-->
                <?php
                    $active = "";
                    if(Peticion::getControlador() == "inicio") $active = "active";
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST_GERENCIAL."Inicio/"; ?>">
					<div class="sb-nav-link-icon">
						<i class="fas fa-home"></i>
					</div>
					
					Inicio
                </a>
                
                <!--====================================================================
                    Seccion por defecto: Inicio
                =====================================================================-->
                <?php
                    $menusA = MenusAModel::Listado( $idRol );
                    foreach($menusA AS $fila)
                    {
                        $menuA = new MenuAModel($fila['idMenuA'], $idRol);
                        
						$active_a = "";
                        $target = "";
                        
                        if(strpos(HOST_ACTUAL, $menuA->getLink()) !== FALSE) {
							$active_a = "active";
                        }
                        
                        if($menuA->getConOpciones())
                        {
                            $attrId = "menuA_".$menuA->getId();
                            $attrClass = "nav-link collapsed";
                            $attrAria_expanded = "false";
                            $attrShow = "";

                            if($active_a != "") { $attrClass = "nav-link"; $attrAria_expanded = "true"; $attrShow = "show"; }

                            ?>
                                <a class="<?php echo $attrClass; ?>" <?php echo $active_a; ?> data-toggle="collapse" data-target="#<?php echo $attrId; ?>" aria-expanded="<?php echo $attrAria_expanded; ?>" aria-controls="<?php echo $attrId; ?>">
									<div class="sb-nav-link-icon">
										<i class="<?php echo $menuA->getImg(); ?>"></i>
									</div>
									
									<?php echo $menuA->getNombre(); ?>

									<div class="sb-sidenav-collapse-arrow">
										<i class="fas fa-angle-down"></i>
									</div>
                                </a>
                                
                                <div class="collapse <?php echo $attrShow; ?>" id="<?php echo $attrId; ?>" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
									<nav class="sb-sidenav-menu-nested nav">

                                        <?php
                                            $menusB = MenusBModel::Listado($menuA->getId(), $idRol);
                                            foreach($menusB AS $filaB)
                                            {
                                                $menuB = new MenuBModel($filaB['idMenuB']);

                                                $active_b = "";
                                                $attrTarget = "";

                                                if($active_a != "" && strpos(HOST_ACTUAL, $menuB->getLink()) !== FALSE) {
                                                    $active_b = "active";
                                                }

                                                ?>
                                                    <a class="nav-link sub <?php echo $active_b; ?>" href="<?php echo HOST_GERENCIAL.$menuB->getLink(); ?>" style="font-size: 14px;">
                                                        <div class="sb-nav-link-icon">
                                                            <i class="<?php echo $menuB->getImg(); ?>"></i>
                                                        </div>
                                                        
                                                        <?php echo $menuB->getNombre(); ?>
                                                    </a>
                                                <?php
                                            }
                                        ?>

                                    </nav>
                                </div>
                            <?php
                        }
                        else
                        {
							?>
								<a class="nav-link" <?php echo $active_a; ?> href="<?php echo HOST_GERENCIAL.$menuA->getLink(); ?>">
									<div class="sb-nav-link-icon">
										<i class="<?php echo $menuA->getImg(); ?>"></i>
									</div>

									<?php echo $menuA->getNombre(); ?>
								</a>
							<?php
                        }
                    }
                ?>

            </div>
        </div>
    </nav>
</div>