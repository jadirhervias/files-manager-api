# Setup project

- Requirements:
    - Laravel 9
    - Composer
    - PHP 8.1
    - Database: SQLite

```bash
Test user:
  email: test@gmail.com
  password: password
```

#### Setup environment

```bash
# Once located in the root of the project
cp .env.example .env

# Install dependencies
composer install

# Migrations were already executed

# Run application
php artisan serve
```

#### Metrics page for API

```
http://<host>/telescope/requests
```

#### API Endpoints

```bash
Get API token:

curl --location --request POST 'http://<host>/api/auth/token' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "test@gmail.com",
    "password": "password"
}'
```

```bash
Register user:

curl --location --request POST 'http://<host>/api/auth/register' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "John Doe",
    "email": "john@gmail.com",
    "password": "12345678"
}'
```

```bash
List all files:

curl --location --request GET 'http://<host>/api/files' \
--header 'Authorization: Bearer <jwt>'
```

```bash
Create file:

curl --location --request POST 'http://<host>/api/files' \
--header 'Authorization: Bearer <jwt>' \
--form 'file=@"<file-path>"'
```

```bash
Bulk files:

curl --location --request POST 'http://<host>/api/files/bulk' \
--header 'Authorization: Bearer <jwt>' \
--form 'files[0]=@"<file-path>"' \
--form 'files[1]=@"<file-path>"' \
--form 'files[2]=@"<file-path>"'
```

```bash
Delete file:

curl --location --request POST 'http://<host>/api/files/delete/<file-id>' \
--header 'Authorization: Bearer <jwt>' \
--header 'Content-Type: application/json' \
--data-raw '{
    "is_permanent": true
}'
```
