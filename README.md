# ZOMI — Female Boutique

ZOMI is a PHP web application for an online women's clothing boutique. It enables visitors to browse the catalogue, create an account, sign in, add items to a cart, and place orders. Registered users can review their order history, while administrators can manage the product catalogue and stock.

The project was built as an educational web-development project using PHP, MySQL, and XAMPP for local development.

## Features

- Browse clothing by category: T-shirts, jeans, sweaters, coats, dresses, and sets
- View promotional and brand information pages
- Register an account with server-side input validation
- Sign in and sign out using PHP sessions
- Add products to a session-based shopping cart
- Select product sizes and update item quantities in the cart
- Check available stock before an order is created
- Create orders with delivery notes and an estimated delivery date
- Reduce inventory after a successful order
- Review personal order history from the user panel
- Upload a profile image during registration
- Administrator dashboard for adding, editing, and deleting products
- Product image upload with type and size validation

## User roles

### Guest visitor

A guest visitor can:

- View the home, about, and promotion pages
- Browse all product categories
- View products available in the shop
- Open the registration and sign-in page

Guests must create an account and sign in before placing an order.

### Registered user

A registered user can:

- Browse products and select a size
- Add products to a cart
- Change cart contents or empty the cart
- Place an order when stock is available
- Add an optional delivery note
- Access a personal profile and order-history panel

### Administrator

An administrator has access to the shop and the administrator panel. The administrator can:

- Add products with category, quantity, price, description, and image
- Edit product quantity and price
- Delete products
- View and manage the product catalogue

## Technology stack

- PHP
- MySQL / MariaDB
- HTML5 and CSS3
- Bootstrap 5
- JavaScript
- AJAX for asynchronous login feedback
- Font Awesome
- XAMPP and phpMyAdmin for local development

## Project structure

```text
project/
├── adminPanel.php          # Administrator dashboard
├── adminDodavanje.php      # Product creation handler
├── izmeniArtikal.php       # Product update handler
├── konekcija.php           # Database connection settings
├── login.php               # Sign-in and registration page
├── validacijaLogin.php     # Authentication and registration logic
├── korisnikPanel.php       # User profile and order history
├── dodajUKorpu.php         # Cart handler
├── poruci.php              # Order-processing handler
├── slike/                  # Product and site images
├── datoteke/               # Uploaded user profile images
└── Porudzbine/             # Locally generated order records
```

## Run locally

### Prerequisites

- [XAMPP](https://www.apachefriends.org/), including Apache, MySQL, and phpMyAdmin
- PHP 8.x is recommended
- A MySQL or MariaDB database

### 1. Clone the repository

```bash
git clone https://github.com/<your-github-username>/Female-Boutique-php.git
```

### 2. Move the project into `htdocs`

Move or clone the `project` folder into XAMPP's web root. For example:

```text
C:\xampp\htdocs\Female-Boutique-php\project
```

### 3. Start Apache and MySQL

Open the XAMPP Control Panel and start:

- Apache
- MySQL

### 4. Create and import the database

Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin) and create a database named `projekat_pva` with UTF-8 encoding.

Import the SQL dump provided in the repository's `database/` directory into the newly created database. The application uses the following tables:

- `korisnici`
- `artikli`
- `porudzbine`

### 5. Configure the database connection

Open `konekcija.php` and set the connection values for your local environment:

```php
$server = "localhost";
$user = "root";
$lozinka = "";
$baza = "projekat_pva";
```

Adjust these values if your MySQL username, password, or database name differs.

### 6. Open the application

Navigate to:

```text
http://localhost/Female-Boutique-php/project/
```

## Demo accounts

No demo credentials are included in this repository. Create a regular user account through the registration form after importing the database.

To test administrator features, create an account in the `korisnici` table and assign its `tipKorisnika` value to `Administrator`. Passwords must be stored using PHP's `password_hash()` format.

## Security and publication notes

Before publishing this project publicly, review the repository carefully:

- Do not commit production database credentials or configuration files containing secrets.
- Do not commit real customer data, addresses, phone numbers, uploaded profile images, or order records.
- Add runtime-generated files and uploads to `.gitignore`, for example `Porudzbine/` and user-uploaded files in `datoteke/`.
- Use a sanitized SQL schema and non-personal seed data for demonstrations.
- Configure appropriate file permissions for upload directories in the target environment.

## Notes

This project demonstrates core e-commerce workflows: authentication, role-based access control, session handling, catalogue management, shopping-cart processing, stock validation, order creation, and basic file uploads.

It is intended for educational and portfolio purposes. No open-source license is currently provided; contact the repository owner before reusing or redistributing the code.
