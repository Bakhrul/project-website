<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
    integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    function humanizePrice(alpha, withDigits = true) {
        if (!alpha)
            return '0.00';
        const separator = ',';
        const radix = '.'

        const data = parseFloat(alpha).toFixed(2);
        var val = data.toString().replace(/[^0-9.]/g, '');

        var parts = val.split('.');
        var result = parts.slice(0, -1).join('') + '.' + parts.slice(-1);
        result = result.replace(/^\./, '');
        result = result.replace(/\.$/, '');

        var bilangan = result.toString();
        var commas = (withDigits) ? '00' : '';

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
            ult = sisa ? separator : '';
            rupiah += ult + ribuan.join(separator);
        }

        if (withDigits) {
            if (alpha.toString().charAt(0) == '-') {
                return '(' + rupiah + radix + commas + ')';
            }

            // Cetak hasil
            return rupiah + radix + commas // Hasil: 23.456.789
        } else {
            if (alpha.toString().charAt(0) == '-') {
                return '(' + rupiah + ')';
            }

            // Cetak hasil
            return rupiah // Hasil: 23.456.789
        }

    }

    function parseFloatX(string) {
        let response;
        if (string) {
            response = parseFloat(string.toString().replace(/\,/g, ''));
        } else {
            response = 0;
        }
        return response;
    }

</script>
