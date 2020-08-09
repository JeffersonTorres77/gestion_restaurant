<?php
    $objUsuario = Sesion::getUsuario();
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion menu-lateral" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="panel-usuario">
                <div>
                    <?php echo $objUsuario->getNombre(); ?>
                </div>

                <div>
                    <?php echo $objUsuario->getCedula(); ?>
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

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST_ADMIN."Inicio/"; ?>">
					<div class="sb-nav-link-icon">
						<i class="fas fa-home"></i>
					</div>
					
					Inicio
                </a>
                
                <!--====================================================================
                    Seccion por defecto: Inicio
                =====================================================================-->
                <?php
                    $menusA = AdminMenusAModel::Listado();
                    foreach($menusA AS $fila)
                    {
                        $menuA = new AdminMenuAModel($fila['idMenuA']);
                        
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
                                            $menusB = AdminMenusBModel::Listado($menuA->getId());
                                            foreach($menusB AS $filaB)
                                            {
                                                $menuB = new AdminMenuBModel($filaB['idMenuB']);

                                                $active_b = "";
                                                $attrTarget = "";

                                                if($active_a != "" && strpos(HOST_ACTUAL, $menuB->getLink()) !== FALSE) {
                                                    $active_b = "active";
                                                }

                                                ?>
                                                    <a class="nav-link sub <?php echo $active_b; ?>" href="<?php echo HOST_ADMIN.$menuB->getLink(); ?>" style="font-size: 14px;">
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
								<a class="nav-link" <?php echo $active_a; ?> href="<?php echo HOST_ADMIN.$menuA->getLink(); ?>">
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