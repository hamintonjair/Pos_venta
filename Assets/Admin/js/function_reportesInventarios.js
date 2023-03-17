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

//buscar ganacia por mes
function buscarMes() {
    const url = base_url + "Reportes/rangoFecha";
    const frm = document.getElementById("frmBuscarGanacias");
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

            document.getElementById("tableReporteGanancias").innerHTML = html;
        }
    }

}

function Todos() {
    reporteGanacias();
}

//reportes de ganancias por mes
function reporteGanacias() {
    window.location = base_url + "Reportes/reporteGananciasMes";
}

//reporte por empleado
document.addEventListener("DOMContentLoaded", function() {
    $('#tableReporteGananciasMes').dataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
        dom: 'lBfrtip',
        "ajax": {
            "url": " " + base_url + "Reportes/listarGanancias",
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

//reportes de compras a proveedores
function reporteCompras() {
    window.location = base_url + "Reportes/reporteCompas";
}

//reporte por compra a proveedores por fecha
document.addEventListener("DOMContentLoaded", function() {
        $('#tableReporteComprasMes').dataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Reportes/listarCompras",
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
    //buscar ganacia por mes
function buscarMes() {
    const url = base_url + "Reportes/rangoFechaCompra";
    const frm = document.getElementById("frmBuscarCompras");
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

            document.getElementById("tableReporteGanancias").innerHTML = html;
        }
    }

}

function Todoss() {
    reporteCompras();
}