## SmartBin Dashboard

### Tech Stack
- PHP >= 7.4
- Composer
- MySQL

### Instalasi
1. Clone Repository
2. Jalankan 'Composer Install'
3. Setup env : copy .env.example menjadi .env. kemudian sesuaikan konfigurasi 
```
CI_ENVIRONMENT = development

app.baseUrl = <nama-url>

database.default.hostname = localhost
database.default.database = <nama-database>
database.default.username = <username>
database.default.password = <password>
database.default.DBDriver = MySQLi
```
4. Jalankan migrasi tabel dengan 'php spark migrate --all' (pastikan tidak ada error)
5.  Jalankan Seed tabel dengan 'php spark db:seed InitializeSeeder'