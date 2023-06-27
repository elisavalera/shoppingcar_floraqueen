# Shopping car - Coding challenge floraqueen

This is a sample shopping cart application built with Symfony and Docker, allowing users to add products and vouchers to their cart and calculate the total amount.

## Features

- Add products (Product A, Product B, Product C) to the shopping cart.
- Apply vouchers (Voucher V, Voucher R, Voucher S) for different types of discounts.
- Calculate the total cart value based on the selected products and vouchers.

## Requirements

- PHP 8.1 or higher
- Composer
- Docker (optional, for running the application in a Docker container)

## Getting Started

To run the Shopping Cart Application locally, follow these steps:

1. Clone the repository:
   `git clone https://github.com/elisavalera/shoppingcar_floraqueen.git`
2. Navigate to the project directory: cd shoppingcart-floraqueen


### 🚀 Application Container execution
1. The project folder is: `app`
2. To see the help of Make commands you can place:`make`
3. Install all the containers and bring up the project with Docker executing: `make docker-up`
4. You can run `make sh` and you can execute it:
```bash
composer install
```
5. Set up the environment variables (check if is necessary):
Rename the .env.example file to .env:
```bash
cp .env.example .env
```
Update the necessary environment variables in the .env file, such as the database configuration.

6. Set up the database:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

7. Start the development server:
```bash
symfony serve
```

The application should now be running on http://localhost:8000.

## Usage

### CLI Command
You can use the CLI command php bin/console cart:add to add items to the cart and calculate the total amount. Run the following command for help and usage information:
```bash
php bin/console cart:add --help
```

#### Example usage:
```bash
php bin/console cart:add ProductA VoucherS ProductA VoucherV ProductB
```
This command will add ProductA, VoucherS, ProductA, VoucherV, and ProductB to the cart. It will then calculate the total cart amount and display it in the output.



### API Endpoints
The application provides the following API endpoints:
`POST /cart`: Add an item to the cart. Send a JSON payload with the item parameter.
 
 Example:
 URL: http://localhost:8080/cart

 JSON Add Product B: 
 ```bash
 {
  "item": "ProductB"
 }
```

 JSON Add Product A: 
```bash
 {
  "item": "ProductA"
 }
```

JSON Add Voucher: 
 ```bash
{
  "item": "VoucherV"
}
```

`GET /cart`: Retrieve the cart details.

Example:
URL: http://localhost:8080/cart

JSON:
 ```bash
[
    {
        "id": 1,
        "name": "ProductB",
        "price": "8.00"
    },
    {
        "id": 2,
        "name": "ProductA",
        "price": "10.00"
    },
    {
        "id": 1,
        "name": "VoucherV",
        "price": 0
    }
]
```

`GET /cart/total`: Calculate the total amount of the cart.

Example:
URL: http://localhost:8080/cart/total

JSON:
 ```bash
{
    "total_amount": 18
}
```

Make sure to start the development server (symfony serve) or configure a virtual host to access the API endpoints.

### Testing
To run the tests, use the following command:
```bash
php ./vendor/bin/phpunit
```

### Folder Structure
`app/`: Symfony application files.
`nginx.conf`: Nginx configuration file.
`docker-compose.yml`: Docker Compose configuration file.
`Dockerfile`: Dockerfile for building the Symfony application image.


### Used technology
- Symfony 6.2.*
- Docker
- PHP 8.1-fpm-alpine
- Nginx
- MySql 8.0

### Credits
This project was created by Elisa Valera Márquez.