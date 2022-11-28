<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= base_url('plugins/bootstrap/css/bootstrap.min.css') ?>" />
        
        <!-- Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin="">
        </script>

        <!-- custom -->
        <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
    </head>
    <body>

        <div class="container-fluid w-100 h-100">
            <!--- HEADER --->
            <div class="d-flex p-3 align-items-center w-100 justify-content-between">
                <h1 class='m-0'>Smart Bin Dashboard</h1>
                <p class='m-0 ps-3 border-start border-3 border-dark'>DIKE UGM</p>
            </div>
    
            <!--- MAIN --->
            <div class="py-3 px-md-3 w-100 h-100 position-relative map-container">
                <div id="map" class="p-3 w-100 h-100 border rounded-10px shadow"></div>
                <div id="popup" class="popup popup-hidden m-4 position-absolute"></div>
                <div id="pulse"></div>
            </div>
        </div>

        <script src="<?= base_url('plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('plugins/jquery/jquery-3.6.1.min.js') ?>"></script>

        <script src="<?= base_url('plugins/ol/ol.js') ?>"></script>
        <script src="<?= base_url('js/index.js')?>"></script>

        <script>
            $('document').ready(function () {
                const popup = $('.popup');
                const pulse = $('#pulse');
                setInterval(() => {
                    $.ajax({
                        url: "<?= base_url('api/get/all') ?>",
                        success: function (data) {
                            let bins = data.data;
                            bins.forEach((bin) => {
                                updateMarker(bin);
                            })
                            updatePopup();
                        }
                    })
                }, 3000);
            })
        </script>
    </body>
</html>