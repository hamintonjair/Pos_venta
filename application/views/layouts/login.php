<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Iniciar Sesión</title>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico"> 

        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libreria/sweetalert2/dist/sweetalert2.min.css">        
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar Sesión - Efi-conta V1.0</h3></div>
                                    <div class="card-body">                                  
                                        <form id="frmLogin" name="frmLogin">
                                            <div class="form-group">
                                                <label class="small mb-1" for="usuario"><i class="fas fa-user"></i>Usuario<font color="red"> *</font></label>
                                                <input class="form-control py-2" id="usuario" name="usuario" type="text" placeholder="Ingresar usuario" />
                                             
                                            </div>
                                            <div class="form-group">
                                            <label class="small mb-1" for="clave"><i class="fas fa-key"></i>Contraseña<font color="red"> *</font></label>
                                                <input class="form-control py-2" id="clave" name="clave" type="password" placeholder="Ingrese contraseña" />
                                            </div>
                                            <br>
                                            <div class="alert alert-danger text-center d-none" id="alerta" role="alert">
                                               
                                            </div>                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                               <button class="btn btn-primary" type="submit" >Login</button>
                                            </div>
                                        </form>
                                    </div>
                                   </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Todos los derechos reservados <?php echo date("Y")?> <a href="https://jojama.shop/" target="_blaak" rel="noopener noreferrer">Visite mi página web</a></div>

                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script  type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/libreria/sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/Admin/js/funcion_login.js"></script>
    </body>
</html>
