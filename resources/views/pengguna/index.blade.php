@extends('pengguna.main')
@section('extra_style')
<style>
    .navbar-custom {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
    }

    .saldo-element {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
        padding: 20px 15px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .saldo-element .price {
        font-size: 20px;
    }

    .saldo-element .btn-buy-saldo {
        border: 1px #081f36 solid !important;
        color: #081f36 !important;
        background: #fff;
        font-size: 14px;
        padding: 10px 5px;
        margin-top: 15px;
        width: 100%;
        transition: 0.5s;
    }

    .saldo-element .btn-buy-saldo:hover {
        background: #081f36 !important;
        transition: 0.5s;
        color: #fff !important;
    }

    .loader-custom {
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 10px solid #00b6cd;
        border-bottom: 10px solid #00b6cd;
        width: 80px;
        height: 80px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    #modal-loading.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .table-header {
        background: #081f36;
        color: #fff;
        text-align: center;
        font-size: 14px;
        margin-top: 10px;
        border-top-left-radius: 8px;
        padding: 10px 5px;
        border-top-right-radius: 8px;
    }

    .table-custom {
        width: 100%;
    }

    .table-custom thead {
        border-bottom: 2px solid #dee2e6;
        border-top: 1px solid #dee2e6;
        background: #e9ecef;
        font-weight: normal !important;
        font-size: 12px;
        width: 100%;
    }

    .table-custom thead tr th {
        color: #495057;
        font-weight: 500 !important;
    }

    .table-custom tbody tr td {
        color: #495057;
        font-weight: 500 !important;
        font-size: 11px;
    }

    .table-custom tbody tr td {
        padding: 5px 0;
        border-top: 1px solid #dee2e6;
    }

    #myChart {
        height: 200px;
    }

    @media(max-width:991px) {
        #myChart {
            height: auto !important;
        }
    }

    .loader-custom {
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 10px solid #081f36;
        border-bottom: 10px solid #081f36;
        width: 50px;
        height: 50px;
        display: block;
        margin: 15px auto 0 auto;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }


    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .table-responsive {
        width: 100%;
        overflow: auto;
        max-height: 350px;
        border-left: 0 !important;
        border-right: 0 !important;
    }

</style>
@endsection
@section('content')
<div class="container">
    <div class="row min-height-auth">
        <div class="col-lg-12 mt-5">
            <div class="row">
                <div class="col-lg-7" style="background:#e1fcef !important;">
                    <div class="row pt-3 pb-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="label-form">Produk</label>
                                <select class="form-control input-form" id="itemGrafik" onchange="getDataGrafikItem()">
                                    @foreach($item as $row)
                                    <option value="{{$row->i_id}}">{{$row->i_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="label-form">Periode</label>
                                <input id="periodeGrafik" type="month" class="form-control input-form"
                                    onchange="getDataGrafikItem()" value="{{date('Y-m')}}" max="{{date('Y-m')}}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="loader-custom" id="loading-chart"></div>
                            <div id="myChart-container">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="background-color:#e8f4ff !important;">
                    <div class="row pt-3 pb-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="label-form">Tgl Harga</label>
                                <input id="tglTable" type="date" class="form-control input-form"
                                    value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" max="2021-06-24"
                                    onchange="changetglTable()">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="label-form">Tgl Perbandingan Harga</label>
                                <input id="tglPerbandinganTable" type="date" class="form-control input-form"
                                    value="{{date('Y-m-d', strtotime('-1 days'))}}"
                                    max="{{date('Y-m-d', strtotime('-1 days'))}}" max="2021-06-24"
                                    onchange="changetglPerbandinganTable()">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-header">Perbandingan Harga Produk Perhari</div>
                            <div class="table-responsive">
                                <table class="table-custom" id="table-price-item">
                                    <thead>
                                        <tr>
                                            <th width="33%">Produk</th>
                                            <th width="10%">Sat</th>
                                            <th width="20%" id="first_date_table">22/02/2021</th>
                                            <th width="20%" id="second_date_table">23/02/2021</th>
                                            <th width="10%">(%)</th>
                                            <th width="7%">ket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pengguna.layouts._footer')
</div>

@endsection

@section('extra_script')

<script type="text/javascript">
    var imageDefault = "{{asset('member-template/images/item.png')}}";
    var hargaB = "{{asset('member-template/images/harga-b.png')}}";
    var hargaC = "{{asset('member-template/images/harga-c.png')}}";
    var hargaD = "{{asset('member-template/images/harga-d.png')}}";

    var pathStorage = "{{asset('storage/images/item')}}"
    reloadDataTable();
    getDataGrafikItem();

    function changetglTable() {
        let firstDate = $('#tglTable').val();

        let lastDate = new Date(firstDate);
        let result = moment(lastDate).subtract(1, "days").format('YYYY-MM-DD');

        $('#second_date_table').html(moment(firstDate).format('DD/MM/YYYY'));
        $('#first_date_table').html(moment(lastDate).subtract(1, "days").format('DD/MM/YYYY'));

        $('#tglPerbandinganTable').val(result).attr('max', firstDate);

        reloadDataTable();
    }

    function changetglPerbandinganTable() {
        let date = $('#tglPerbandinganTable').val();

        let fullDate = new Date(date);
        let result = moment(fullDate).format('DD/MM/YYYY');

        $('#first_date_table').html(result);

        reloadDataTable();
    }

    function reloadDataTable() {
        let periodeFirst = $('#tglTable').val();
        let periodeSecond = $('#tglPerbandinganTable').val();
        $('#table-price-item tbody').html(`<tr><td colspan="6" class="text-center">
                                                <div class="loader-custom"></div>
                                            </td>
                                        </tr>`);
        $.ajax({
            url: "{{route('home.getDataTablePriceItem')}}",
            type: 'POST',
            data: {
                periode_first: periodeFirst,
                periode_second: periodeSecond,
                "_token": "{{ csrf_token() }}"
            },
            success: function (resp) {
                let item = resp.data;

                let result = '';
                for (let i = 0; i < item.length; i++) {

                    let context = item[i];

                    let imagePath = context.i_icon ? pathStorage + '/' + context.i_icon : imageDefault;
                    let name = context.i_name;
                    let satuan = context.u_name;
                    let priceFirst = context.price_one.length > 0 ? context.price_one[0].ip_price : 0;
                    let priceSecond = context.price_two.length > 0 ? context.price_two[0].ip_price : 0;

                    let percentace = 0;
                    if (priceSecond == 0 && priceFirst > 0) {
                        percentace = 100;
                    } else {
                        percentace = (((parseFloatX(priceFirst) - parseFloatX(priceSecond))) / parseFloatX(
                            priceSecond) * 100);
                    }


                    let iconPath = '';
                    if (parseFloatX(priceFirst) > parseFloatX(priceSecond)) {
                        iconPath = hargaB;
                    } else if (parseFloatX(priceFirst) < parseFloatX(priceSecond)) {
                        iconPath = hargaD;
                    } else {
                        iconPath = hargaC;
                    }

                    let columnImage = `<td>
                                            <img src="` + imagePath + `" class="mr-1" width="20px">
                                            <span>` + name + `</span>
                                        </td>`;
                    let colummSatuan = `<td>` + satuan + `</td>`;
                    let columnPriceOne = `<td>` + humanizePrice(priceSecond) + `</td>`;
                    let columnPriceTwo = `<td>` + humanizePrice(priceFirst) + `</td>`;
                    let columnPercentace = `<td>` + parseFloatX(percentace).toFixed(2) + `</td>`;
                    let columnIcon = `<td> <img src="` + iconPath + `"
                                                    width="15px"></td>`;

                    result += '<tr>' + columnImage + colummSatuan + columnPriceOne + columnPriceTwo +
                        columnPercentace + columnIcon + '</tr>';
                }
                setTimeout(() => {

                }, 100);
                $('#table-price-item tbody').html(result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#table-price-item tbody').html('');
            },
            complete: function () {

            },
        });
    }

    function getDataGrafikItem() {
        $("#myChart").remove();
        $('#loading-chart').removeClass('d-none');
        let item = $('#itemGrafik').val();
        let periode = $('#periodeGrafik').val();

        $.ajax({
            url: "{{route('home.getDataGrafikPriceItem')}}",
            type: 'POST',
            data: {
                item: item,
                periode: periode,
                "_token": "{{ csrf_token() }}"
            },
            success: function (resp) {
                setDataGrafikItem(resp.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                $('#loading-chart').addClass('d-none');
            },
        });


    }

    function setDataGrafikItem(response) {
        $("#myChart").remove();
        $('#myChart-container').append(`<canvas id="myChart"></canvas>`);

        const data = [];
        for (let i = 0; i <= response.length; i++) {
            data.push({
                x: i + 1,
                y: response[i],
            });
        }
        const totalDuration = 3000;
        const delayBetweenPoints = totalDuration / data.length;
        const animation = {
            x: {
                type: 'number',
                easing: 'linear',
                duration: delayBetweenPoints,
                from: NaN, // the point is initially skipped
                delay(ctx) {
                    if (ctx.type !== 'data' || ctx.xStarted) {
                        return 0;
                    }
                    ctx.xStarted = true;
                    return ctx.index * delayBetweenPoints;
                }
            },
        };

        const config = {
            type: 'line',
            data: {
                datasets: [{
                    borderColor: 'rgba(8,31,54 ,1)',
                    borderWidth: 2,
                    radius: 0,
                    data: data,
                }, ]
            },
            options: {
                animation,
                interaction: {
                    intersect: false
                },
                plugins: {
                    legend: false
                },
                scales: {
                    x: {
                        type: 'linear'
                    }
                }
            }
        };
        var ctx = document.getElementById('myChart').getContext('2d');
        window.myChart = new Chart(ctx, config);
    }

</script>
@endsection
