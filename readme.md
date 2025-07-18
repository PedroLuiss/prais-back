
## Installation

* [https://laravel.com/docs/12.x/installation](https://laravel.com/docs/12.x/installation)
* [https://laravel.com/docs/12.x/vite](https://laravel.com/docs/12.x/vite)

```bash
# Create our environment file.
cp .env.example .env
# Update database values in .env file.
# Install our app dependencies.
composer i
php artisan key:generate
# Before running the next command:
# Update your database details in .env
php artisan migrate --seed

```

## Usage

```bash
php artisan serve --port=3000
# Website accessible at http://localhost:3000
```


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.


