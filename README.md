# Simple PHP E-Commerce Shopping Cart

This is a simple e-commerce web application built using PHP and MySQL. It allows authenticated users to browse products, add them to a shopping cart, and remove them from the cart. The application uses PHP sessions and cookies for user authentication and cart management.

## Features

- **User Authentication**: Users must be logged in to access the shopping cart functionality.
- **Product Browsing**: Users can view a list of available products from the database.
- **Add to Cart**: Users can add products to their shopping cart.
- **Remove from Cart**: Users can remove products from their cart.
- **Session and Cookie Management**: User sessions are utilized for authentication, and cookies are used to store cart information.

## Technologies Used

- PHP
- MySQL
- HTML
- Sessions and Cookies for authentication and cart management

## Database Setup

The application requires a MySQL database with the following structure:

### Database: `storedb`

### Table: `products`
| Column  | Type   | Description                       |
|---------|--------|-----------------------------------|
| `id`    | INT    | Unique identifier for the product |
| `title` | VARCHAR| Title of the product              |
| `image` | VARCHAR| URL/path to the product image     |
| `price` | DECIMAL| Price of the product              |

## How It Works

1. **Session Check**: 
   - The application checks for a valid user session. If the user is not logged in, they are redirected to `login.php`.

2. **Logout Functionality**:
   - Users can log out, which clears their session and cookies, redirecting them back to the login page.

3. **Adding Products**:
   - Users can click the "buy" button for a product to add it to their cart. If the product is already in the cart, it won't be added again.

4. **Removing Products**:
   - Users can remove products from their cart. The cart is updated in the cookie accordingly.

5. **Displaying Products and Cart**:
   - The application connects to the MySQL database to retrieve and display available products. It also displays items currently in the user's cart.

## Installation and Setup

### 1. Clone the Repository
```bash
git clone https://github.com/mostafa587/PHP_Shop.git
"# PHP_Shop" 
