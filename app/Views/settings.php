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
                <div>
                  <p class='m-0 ps-3 border-start border-3 border-dark d-inline'>DIKE UGM</p>
                </div>
            </div>
    
            <!--- MAIN --->
            <!--- MAIN --->
            <div class="row">
                <div class="col-12">
                    <div class="card m-3 p-3">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <td>Id</td>
                            <td>Latitude</td>
                            <td>Longitude</td>
                            <td>Aksi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (isset($bins)): ?>
                            <?php foreach ($bins as $bin): ?>
                              <tr>
                                <td><?= $bin['ID'] ?></td>
                                <td><?= $bin['Latitude'] ?></td>
                                <td><?= $bin['Longitude'] ?></td>
                                <td>
                                  <a href="<?= base_url('settings/edit/'.$bin['ID']) ?>" class="btn btn-primary">
                                    Edit
                                  </a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?= base_url('plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('plugins/jquery/jquery-3.6.1.min.js') ?>"></script>
    </body>
</html>