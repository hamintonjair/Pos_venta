
 <!--javascripts for application to work-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script src="<?php echo base_url; ?>Assets/Admin/js/jquery-3.3.1.min.js"></script>
    <!-- <script src="<?php echo base_url; ?>Assets/Admin/js/toastr.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
    <script src="<?php echo base_url; ?>Assets/Admin/js/popper.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/Admin/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/Admin/js/main.js"></script>
    <script src="<?php echo base_url; ?>Assets/Admin/js/fontawesome.js"></script>  
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url; ?>Assets/Admin/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/plugins/jsBarcode.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/plugins/chart.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/plugins/dataTables.bootstrap.min.js"></script>
   
           
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/plugins/bootstrap-select.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/plugins/select2.min.js"></script>  -->

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url; ?>Assets/libreria/sweetalert2/dist/sweetalert2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/functions_admin.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_usuario.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_cliente.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_caja.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_categoria.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_medida.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_proveedor.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funcion_producto.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/funciones_compra.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script type="text/javascript" src="<?php echo base_url; ?>Assets/Admin/js/datepicker/jquery-ui.min.js"></script>
   
    <script>
         const base_url = "<?= base_url; ?>";
    </script>


   <!-- usuarios -->
     <script>
		
      //  Highcharts.chart('pagosMesAnio', {
      //   chart: {
      //       plotBackgroundColor: null,
      //       plotBorderWidth: null,
      //       plotShadow: false,
      //       type: 'pie'
      //   },
      //   title: {
      //       text: 'Ventas por tipo pago, <?= $pagosMes['mes'].' '.$pagosMes['anio'] ?>',
         

      //   },
      //   tooltip: {
      //       pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      //   },
      //   accessibility: {
      //       point: {
      //           valueSuffix: '%'
      //       }
      //   },
      //   plotOptions: {
      //       pie: {
      //           allowPointSelect: true,
      //           cursor: 'pointer',
      //           dataLabels: {
      //               enabled: true,
      //               format: '<b>{point.name}</b>: {point.percentage:.1f} %'
      //           }
      //       }
      //   },
      //   series: [{
      //       name: 'Brands',
      //       colorByPoint: true,
      //       data: [
      //             <?php 
      //                   foreach ($pagosMes['tipospago'] as $pagos) {
      //                   echo "{name:'".$pagos->tipopago."',y:".$pagos->total."},";
      //             }
      //                ?>          
      //          ]
      //       }]
      // }); 
      
      // Highcharts.chart('graficaMes', {
      //       chart: {
      //           type: 'line'
      //       },
      //       title: {
      //           text: 'Ventas de <?= $ventasMDia['mes']?> de <?= $ventasMDia['anio'] ?>'
      //       },
      //       subtitle: {
      //           text: 'Total Ventas <?= SMONEY.'. '.formatMoney($ventasMDia['total']) ?> '
      //       },
      //       xAxis: {
      //          categories: [
      //                      <?php 
      //                            foreach ($ventasMDia['ventas'] as $dia) {

      //                               echo $dia['dia'].",";
      //                            }
      //                     ?>                          
      //                   ]              
      //       },
      //       yAxis: {
      //           title: {
      //               text: ''
      //           }
      //       },
      //       plotOptions: {
      //           line: {
      //               dataLabels: {
      //                   enabled: true
      //               },
      //               enableMouseTracking: false
      //           }
      //       },
      //       series: [{
      //           name: 'Dato',
      //           data: [
      //             <?php                  
      //               if($ventasMDia['total'] == 0){
      //                    echo  [0].",";
      //                }else{
      //                   echo $ventasMDia['total'].",";
      //                }        
      //             ?>
      //           ]
      //       }]
      // });   

      // Highcharts.chart('graficaAnio', {
      //    chart: {
      //       type: 'column'
      //    },
      //    title: {
      //       text: 'Ventas del año <?= $ventasAnio['anio'] ?>'
      //    },
      //    subtitle: {
      //       text: 'Esdística de ventas por mes'
      //    },
      //    xAxis: {
      //       type: 'category',
      //       labels: {
      //             rotation: -45,
      //             style: {
      //                fontSize: '13px',
      //                fontFamily: 'Verdana, sans-serif'
      //             }
      //       }
      //    },
      //    yAxis: {
      //       min: 0,
      //       title: {
      //             text: ''
      //       }
      //    },
      //    legend: {
      //       enabled: false
      //    },
      //    tooltip: {
      //       pointFormat: 'Population in 2021: <b>{point.y:.1f} millions</b>'
      //    },
      //    series: [{
      //       name: 'Population',
      //       data: [
             
      //             <?php 
      //               foreach ($ventasAnio['meses'] as $mes) {                               
      //                //  echo "['".$mes['mes']."',".$mes['venta']."],";
      //                if($mes['venta'] == ""){
      //                   echo  "['".$mes['mes']."', 0],";
      //                }else{
      //                  echo  "['".$mes['mes']."',".$mes['venta']."],";
      //                }
                   
      //               }
      //             ?>  
      //       ],
      //       dataLabels: {
      //             enabled: true,
      //             rotation: -90,
      //             color: '#FFFFFF',
      //             align: 'right',
      //             format: '{point.y:.1f}', // one decimal
      //             y: 10, // 10 pixels down from the top
      //             style: {
      //                fontSize: '13px',
      //                fontFamily: 'Verdana, sans-serif'
      //             }
      //       }
      //    }]
      // });
     
     </script> 
<!-- clientes -->

    <script>

  Highcharts.chart('graficaMes', {
      chart: {
          type: 'line'
      },
      title: {
          text: 'Ventas de <?= $ventasMDia['mes'].' del '.$ventasMDia['anio'] ?>'
      },
      subtitle: {
          text: 'Total Ventas <?= SMONEY.'. '.formatMoney($ventasMDia['total']) ?> '
      },
      xAxis: {
          categories: [
            <?php 
                foreach ($ventasMDia['ventas'] as $dia) {
                  echo $dia['dia'].",";
                }
            ?>
          ]
      },
      yAxis: {
          title: {
              text: ''
          }
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: false
          }
      },
      series: [{
          name: 'Dato',
          data: [
            <?php               
                  echo $ventasMDia['total'].",";
                
            ?>
          ]
      }]
  });

   </script>
    


    <!-- <script>
            $(document).ready(function() {
                  $('#listRolid').select2();
               });
   </script> -->

        <!-- Google analytics script-->
      <!-- <script type="text/javascript">
      var data = {
         labels: ["January", "February", "March", "April", "May"],
         datasets: [
            {
               label: "My First dataset",
               fillColor: "rgba(220,220,220,0.2)",
               strokeColor: "rgba(220,220,220,1)",
               pointColor: "rgba(220,220,220,1)",
               pointStrokeColor: "#fff",
               pointHighlightFill: "#fff",
               pointHighlightStroke: "rgba(220,220,220,1)",
               data: [65, 59, 80, 81, 56]
            },
            {
               label: "My Second dataset",
               fillColor: "rgba(151,187,205,0.2)",
               strokeColor: "rgba(151,187,205,1)",
               pointColor: "rgba(151,187,205,1)",
               pointStrokeColor: "#fff",
               pointHighlightFill: "#fff",
               pointHighlightStroke: "rgba(151,187,205,1)",
               data: [28, 48, 40, 19, 86]
            }
         ]
      };
      var pdata = [
         {
            value: 300,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Complete"
         },
         {
            value: 50,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "In-Progress"
         }
      ]
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);
    </script> -->
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
         (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
         (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
         ga('create', 'UA-72504830-1', 'auto');
         ga('send', 'pageview'); 
      }
      
    </script>
  </body>
</html>
