<!-- Modal -->
<div class="modal fade" id="pass" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Modificar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmPass">
                    <div class="form-group">
                        <label for="clave_actual">Contraseña actual(<font color="red">*</font>)</label>
                        <input type="password" name="clave_actual" id="clave_actual" class="form-control"
                            placeholder="Contraseña Actual" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="clave_nueva">Contraseña Nueva(<font color="red">*</font>)</label>
                        <input type="password" name="clave_nueva" id="clave_nueva" class="form-control"
                            placeholder="Contraseña Nueva" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="confirmar_clave">Confirmar Contraseña(<font color="red">*</font>)</label>
                        <input type="password" name="confirmar_clave" id="confirmar_clave"
                            placeholder="Confirmar Contraseña" class="form-control" aria-describedby="helpId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="frmPass(event)">Actualizar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--javascripts for application to work-->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
<script  type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/jquery-3.3.1.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/Admin/js/toastr.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/Admin/js/popper.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/Admin/js/bootstrap.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/Admin/js/main.js"></script>
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/Admin/js/fontawesome.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/Admin/js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/plugins/jsBarcode.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/tinymce/tinymce.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/plugins/chart.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/plugins/dataTables.bootstrap.min.js">
</script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/plugins/bootstrap-select.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/plugins/select2.min.js"></script>  -->

<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Chart.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/libreria/sweetalert2/dist/sweetalert2.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/functions_admin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_usuario.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_cliente.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_caja.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_categoria.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_medida.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_proveedor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_producto.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_compra.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_empresa.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/funcion_venta.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/function_reportesInventarios.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/Admin/js/datepicker/jquery-ui.min.js"></script>




<script type="text/javascript">
if (document.location.hostname == 'pratikborsadiya.in') {
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-72504830-1', 'auto');
    ga('send', 'pageview');
}
</script>
</body>

</html>