<script src="{{asset('admin-template/js/jquery-2.1.1.js')}}"></script>
<script src="{{asset('admin-template/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin-template/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('admin-template/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('admin-template/js/plugins/dataTables/datatables2.min.js')}}"></script>
<script src="{{asset('admin-template//select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin-template/maskmoney/jquery.maskMoney.min.js')}}"></script>
<script src="{{asset('admin-template/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<!-- Custom and plugin javascript -->
<script src="{{asset('admin-template/js/inspinia.js')}}"></script>
<script src="{{asset('admin-template/js/plugins/pace/pace.min.js')}}"></script>
<!-- jQuery UI -->
<script src="{{asset('admin-template/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- GITTER -->
<script src="{{asset('admin-template/js/plugins/toastr/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(document).ready(function () {
        $(window).load(function () {
            // PAGE IS FULLY LOADED
            // FADE OUT YOUR OVERLAYING DIV
            $('#overlay-loading').fadeOut();
        });
        $('.select2').select2();
        $('.input-currency').maskMoney();
        $.extend($.fn.datepicker.defaults, {
            showOnFocus: false,
            format: 'dd-mm-yyyy',
            disableTouchKeyboard: true,
            enableOnReadonly: false
        });

        $.fn.select2.defaults.set('dropdownAutoWidth', true);
        $.fn.select2.defaults.set('width', 'resolve');

        setTimeout(function () {
            $('.select2-container').css('width', '100%');
        }, 1000);

        $('.select2').on('select2:opening', function () {

            $('.select2-container').css('width', '100%');

        });

        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            // toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

        }, 1300);


        var data1 = [
            [0, 4],
            [1, 8],
            [2, 5],
            [3, 10],
            [4, 4],
            [5, 16],
            [6, 5],
            [7, 11],
            [8, 6],
            [9, 11],
            [10, 30],
            [11, 10],
            [12, 13],
            [13, 4],
            [14, 3],
            [15, 3],
            [16, 6]
        ];
        var data2 = [
            [0, 1],
            [1, 0],
            [2, 2],
            [3, 0],
            [4, 1],
            [5, 3],
            [6, 1],
            [7, 5],
            [8, 2],
            [9, 3],
            [10, 2],
            [11, 1],
            [12, 0],
            [13, 2],
            [14, 8],
            [15, 0],
            [16, 0]
        ];
        $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
            data1, data2
        ], {
            series: {
                lines: {
                    show: false,
                    fill: true
                },
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#d5d5d5'
            },
            colors: ["#1ab394", "#1C84C6"],
            xaxis: {},
            yaxis: {
                ticks: 4
            },
            tooltip: false
        });

        var doughnutData = [{
                value: 300,
                color: "#a3e1d4",
                highlight: "#1ab394",
                label: "App"
            },
            {
                value: 50,
                color: "#dedede",
                highlight: "#1ab394",
                label: "Software"
            },
            {
                value: 100,
                color: "#A4CEE8",
                highlight: "#1ab394",
                label: "Laptop"
            }
        ];

        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 45, // This is 0 for Pie charts
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false
        };


        var polarData = [{
                value: 300,
                color: "#a3e1d4",
                highlight: "#1ab394",
                label: "App"
            },
            {
                value: 140,
                color: "#dedede",
                highlight: "#1ab394",
                label: "Software"
            },
            {
                value: 200,
                color: "#A4CEE8",
                highlight: "#1ab394",
                label: "Laptop"
            }
        ];

        var polarOptions = {
            scaleShowLabelBackdrop: true,
            scaleBackdropColor: "rgba(255,255,255,0.75)",
            scaleBeginAtZero: true,
            scaleBackdropPaddingY: 1,
            scaleBackdropPaddingX: 1,
            scaleShowLine: true,
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false
        };

    });
    $.extend(true, $.fn.dataTable.defaults, {
        "width": '100%',
        "responsive": true,
        "pageLength": 10,
        "lengthMenu": [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
            },
            "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
            "infoFiltered": "(difilter dari _MAX_ total entri)",
        }

    });

    function humanizePrice(alpha) {
        var val = alpha.toString().replace(/[^0-9.]/g, '');
        // console.log(alpha);
        var parts = val.split('.');
        var result = parts.slice(0, -1).join('') + '.' + parts.slice(-1);
        result = result.replace(/^\./, '');
        result = result.replace(/\.$/, '');

        var bilangan = result.toString();
        var commas = '00';

        if (bilangan.split('.').length > 1) {
            commas = bilangan.split('.')[1];
            bilangan = bilangan.split('.')[0];
        }

        var number_string = bilangan.toString(),
            sisa = number_string.length % 3;
        rupiah = number_string.substr(0, sisa);
        rupiah = isNaN(rupiah) ? '' : rupiah;
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }

        if (alpha.toString().charAt(0) == '-') {
            return '(' + rupiah + '.' + commas + ')';
        }

        // Cetak hasil
        return rupiah + '.' + commas // Hasil: 23.456.789
    }

    $.extend($.fn.datepicker.defaults, {
        showOnFocus: false,
        format: 'dd-mm-yyyy',
        disableTouchKeyboard: true,
        enableOnReadonly: false
    });

    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });
    function humanizeDate(e, timestamp = false) {
        if (!e) {
            return false;
        }
        str = e.split(' ')[0];

        let date = str.split('-')[2] + '/' + e.split('-')[1] + '/' + e.split('-')[0];
        let time = '';
        if (timestamp) {

            let fulltime = e.split(' ')[1];
            if (fulltime) {
                time = fulltime.split(':')[0] + ":" + fulltime.split(':')[1];
            }

        }
        return date + ' ' + time;
    }
</script>
