<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="icon" type="image/x-icon" href="<?= base_url('images/bin_empty.png') ?>">
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
            <div class="row">
                <div class="col-12">
                    <div class="card m-3 p-3">
                      <form method="post" action="<?= base_url('/settings/edit/'.$bin['ID']) ?>">
                          <div class="mb-3">
                              <label for="bin_id" class="form-label">Bin Id</label>
                              <input type="text" class="form-control" id="bin_id" name="bin_id" value="<?= $bin['ID'] ?>" readonly>
                          </div>
                          <div class="mb-3">
                              <label for="Latitude" class="form-label">latitude</label>
                              <input type="text" class="form-control" id="Latitude" name="Latitude" value="<?= $bin['Latitude'] ?>">
                          </div>
                          <div class="mb-3">
                              <label for="Longitude" class="form-label">longitude</label>
                              <input type="text" class="form-control" id="Longitude" name="Longitude" value="<?= $bin['Longitude'] ?>">
                          </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?= base_url('plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('plugins/jquery/jquery-3.6.1.min.js') ?>"></script>
    </body>
</html>