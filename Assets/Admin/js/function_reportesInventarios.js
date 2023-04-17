//INVENTARIO STOCK BAJOS
document.addEventListener("DOMContentLoaded", function() {
        $('#tableStockBajo').dataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "columnDefs": [
                { 'className': "textcenter", "targets": [5] }, //stock

            ],
            "ajax": {
                "url": " " + base_url + "Inventario/listarStockBajos",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "codigo" },
                { "data": "descripcion" },
                { "data": "precio_compra", render: $.fn.dataTable.render.number('.', ',', 2) },
                { "data": "precio_venta", render: $.fn.dataTable.render.number('.', ',', 2) },
                { "data": "cantidad" },
                { "data": "vencimiento" },
                { "data": "fecha_vencimiento" },
            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },

            ],
            "resonsieve": "true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ]
        });
        if (document.getElementById('stockMinimo')) {
            reportStock();
            productosVendidos();

        }

    })
    //vista productos bajos
function productosBajos() {
    window.location = base_url + "Inventario/stockBajos";
}

function volverInventario() {
    window.location = base_url + "inventario";
}
//reporte de cierre
document.addEventListener("DOMContentLoaded", function() {
        $('#tableReporteCierre').dataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Reportes/listarReporteCierre",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "fecha_apertura" },
                { "data": "caja" },
                { "data": "nombre" },
                { "data": "monto_inicial", render: $.fn.dataTable.render.number('.', ',', 2) },
                { "data": "total_ventas" },
                { "data": "monto_total", render: $.fn.dataTable.render.number('.', ',', 2) },
                { "data": "fecha_cierre" },

            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6]
                    }
                },

            ],
            "resonsieve": "true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ]
        });
        if (document.getElementById('stockMinimo')) {
            reportStock();
            productosVendidos();

        }

    })
 //INVENTARIO
document.addEventListener("DOMContentLoaded", function() {
        $('#tableInventario').dataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Inventario/listarInventario",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "codigo" },
                { "data": "descripcion" },
                { "data": "precio_compra", render: $.fn.dataTable.render.number('.', ',', 2) },
                { "data": "precio_venta", render: $.fn.dataTable.render.number('.', ',', 2) },
                { "data": "cantidad" },
                { "data": "vencimiento" },
                { "data": "fecha_vencimiento" },

            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },

            ],
            "resonsieve": "true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ]
        });
        if (document.getElementById('stockMinimo')) {
            reportStock();
            productosVendidos();

        }

    })
    //vista reporte
function ventasEmpleados() {

    window.location = base_url + "Reportes/reporteEmpleado";
}
//volver a reportes
function volverEmpleados() {
    window.location = base_url + "reportes";
}

//buscar empleado
function buscarEmpleados() {
    const url = base_url + "Reportes/buscarReporteEmpleado";
    const frm = document.getElementById("frmBuscar");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);
            console.log(resp);
            let html = '';

            resp.empleado.forEach(row => {

                const monto_inicial = new Intl.NumberFormat().format(row['monto_inicial']);
                const monto_total = new Intl.NumberFormat().format(row['monto_total']);
                html += `<tr>
                        <td>${row['id']}</td>
                        <td>${row['fecha_apertura']}</td>
                        <td>${row['caja']}</td>                       
                        <td>${row['nombre']}</td>
                        <td>${monto_inicial}</td>
                        <td>${row['total_ventas']}</td>
                        <td>${monto_total}</td>     
                        <td>${row['fecha_cierre']}</td>         
                        </tr>`
            });
            document.getElementById("tableReporteEmpleado").innerHTML = html;
        }
    }

}

//buscar ventas por mes
function buscarMes() {
    const url = base_url + "Reportes/rangoFecha";
    const frm = document.getElementById("frmBuscarVentas");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);
            console.log(resp);
            let html = '';
            const total = new Intl.NumberFormat().format(resp.reporte['total']);

            html += `<tr>
                        <td>${resp.reporte['id']}</td>
                        <td>${resp.reporte['fecha_cierre']}</td>
                        <td>${resp.reporte['caja']}</td>                       
                        <td>${resp.reporte['ventas']}</td>
                        <td>${total}</td>                             
                        </tr>`

            document.getElementById("tableReporteVentas").innerHTML = html;
        }
    }

}

function Todos() {
    reporteVentas();
}

//reportes de ganancias por mes
function reporteVentas() {
    window.location = base_url + "Reportes/reporteVentasMes";
}

//reporte por empleado
document.addEventListener("DOMContentLoaded", function() {
    $('#tableReporteVentasMesaMes').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "ajax": {
            "url": " " + base_url + "Reportes/listarVentasMes",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "fecha_cierre" },
            { "data": "caja" },
            { "data": "ventas" },
            { "data": "total", render: $.fn.dataTable.render.number('.', ',', 2) },
        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4]
                }
            },

        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]
    });
    if (document.getElementById('stockMinimo')) {
        reportStock();
        productosVendidos();

    }

})

//vista reporte
function comprasProveedor() {

    window.location = base_url + "Reportes/reporteProveedor";
}
//volver a reportes
function volverProveedor() {
    window.location = base_url + "reportes";
}
//buscar compras proveedores
function frmBuscarCompras() {
    const url = base_url + "Reportes/buscarComprasProveedor";
    const frm = document.getElementById("frmBuscarC");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const resp = JSON.parse(this.responseText);

            let html = '';
            resp.empleado.forEach(row => {

                const precio = new Intl.NumberFormat().format(row['precio']);
                const total = new Intl.NumberFormat().format(row['total']);
                html += `<tr>
                        <td>${row['id']}</td>
                        <td>${row['nit']}</td>
                        <td>${row['razon_social']}</td>                       
                        <td>${row['nombre']}</td>
                        <td>${row['descripcion']}</td>
                        <td>${row['cantidad']}</td>
                        <td>${precio}</td>                   
                        <td>${total}</td>     
                        <td>${row['pago']}</td>
                        <td>${row['fecha']}</td>         
                        </tr>`
            });
            document.getElementById("tableCompras").innerHTML = html;
        }
    }

}
document.addEventListener("DOMContentLoaded", function() {
    $('#tableReporteCompras').dataTable({

        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "ajax": {
            "url": " " + base_url + "Reportes/listarCompras",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "nit" },
            { "data": "razon_social" },
            { "data": "nombre" },
            { "data": "descripcion" },
            { "data": "cantidad" },
            { "data": "precio", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "total", render: $.fn.dataTable.render.number('.', ',', 2) },
            { "data": "pago" },
            { "data": "fecha" },
        ],
        buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },

        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]

    })
});
//reporte por empleado