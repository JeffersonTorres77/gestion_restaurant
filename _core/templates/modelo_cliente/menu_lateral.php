<?php
    $objRestaurant = Sesion::getRestaurant();
    $objMesa = Sesion::getUsuario();
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion menu-lateral" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="panel-usuario row">
                <div class="ml-2 d-flex">
                    <div class="usuario-miniatura bg-primary border border-primary d-flex justify-content-center align-self-center">
                        <i class="fas fa-utensils w-50 h-50 align-self-center text-white"></i>
                    </div>
                </div>

                <div class="col">
                    <div class="col-12 nombre px-2">
                        <?php echo $objMesa->getAlias(); ?>
                    </div>

                    <div class="col-12 px-2 text-muted">
                        <?php echo $objMesa->getAlias(); ?>
                    </div>
                </div>
            </div>

            <div class="nav">

                <!--====================================================================
                    Seccion por defecto: Inicio
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "welcome") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Welcome/"; ?>">
					<div class="sb-nav-link-icon">
						<i class="fas fa-home"></i>
					</div>
					Inicio
                </a>

                <!--====================================================================
                    Seccion por defecto: Combos
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "menus") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Menus/"; ?>">
					<div class="sb-nav-link-icon">
                        <i class="fas fa-book-open"></i>
					</div>
					Menus y promociones
                </a>

                <!--====================================================================
                    Seccion por defecto: Comandas
                =====================================================================-->
                <?php
                    $active_a = (Peticion::getControlador() == "carta") ? 'active' : '';
                    $class = "nav-link collapsed";
                    $aria_expanded = "false";
                    $show = "";

                    if($active_a != "") { $class = "nav-link"; $attrAria_expanded = "true"; $show = "show"; }
                ?>

                <a class="<?php echo $class ?>" <?php echo $active_a; ?> data-toggle="collapse" data-target="#subopciones-carta" aria-expanded="<?php echo $aria_expanded; ?>" aria-controls="subopciones-carta">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>

                    Carta

                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse <?php echo $show; ?>" id="subopciones-carta" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav" id="menu-lateral-categorias-opciones">

                        <a class="nav-link sub" href="<?php echo HOST . "Carta/#/"; ?>" style="font-size: 14px;">
                            <div class="sb-nav-link-icon">
                                <i class="far fa-circle"></i>
                            </div>

                            General
                        </a>

                        <?php
                            $condicional = "idRestaurant = '{$objRestaurant->getId()}'";
                            $categorias = CategoriasModel::Listado($condicional);
                            foreach($categorias as $categoria)
                            {
                                $link = HOST . "Carta/#/categoria=".$categoria['idCategoria']."/";
                                $idCategoria = $categoria['idCategoria'];
                                $nombre = $categoria['nombre'];

                                ?>
                                    <a class="nav-link sub" href="<?php echo $link; ?>" categoria="<?php echo $idCategoria; ?>" style="font-size: 14px;">
                                        <div class="sb-nav-link-icon">
                                            <i class="far fa-circle"></i>
                                        </div>
                                        
                                        <?php echo $nombre; ?>
                                    </a>
                                <?php
                            }
                        ?>

                    </nav>
                </div>

                <!--====================================================================
                    Seccion por defecto: Cuenta
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "cuenta") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Cuenta/"; ?>">
					<div class="sb-nav-link-icon">
                        <i class="fas fa-money-bill-wave-alt"></i>
					</div>
                    Cuenta
                </a>

            </div>
        </div>

        <a href="#/Salir/">
            <div class="w-100 p-2 border-top border-primary" onclick="ModalCerrarSesion()">
                <i class="fas fa-shield-alt"></i>
                Cerrar sesión
            </div>
        </a>
    </nav>
</div>