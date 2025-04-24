🚗 ProDriver
ProDriver is a secure and responsive web application built to onboard and register professional drivers. It features image upload, form validation, and a clean UI. The backend is built with PHP and MySQL, while the frontend uses HTML and CSS.

✨ Features
Driver registration with:

Full name

Email and password

Phone number

Years of experience

Education level

Profile photo upload

Input validation with helpful messages

Responsive form with icons and styled inputs

Secure password hashing

Redirects after successful registration

Login page and protected dashboard

Spam-protected email confirmations (optional via PHPMailer)

Password reset with email verification (optional)

🛠️ Tech Stack
Frontend: HTML, CSS

Backend: PHP (local server via XAMPP or similar)

Database: MySQL

Email: PHPMailer (for confirmation and password reset)

📁 Folder Structure
graphql
Copy
Edit
prodriver/
│
├── assets/              # CSS, images, etc.
├── includes/            # Reusable PHP scripts (DB connection, validation, etc.)
├── dashboard.php        # Driver dashboard (protected)
├── login.php            # Login page
├── register.php         # Registration form
├── register_process.php # Registration handler
├── reset_password/      # Password reset logic
└── README.md
🚀 Getting Started
Prerequisites
PHP 7.4+

MySQL

XAMPP or similar local server setup

Installation
Clone the repo:

bash
Copy
Edit
git clone https://github.com/your-username/prodriver.git
Import the SQL database file into phpMyAdmin.

Configure your database connection in includes/db.php:

php
Copy
Edit
$host = 'localhost';
$db = 'prodriver_db';
$user = 'root';
$pass = '';
Run the server:

bash
Copy
Edit
localhost/prodriver/register.php
🧪 Usage
New drivers can register at register.php.

After registration, users are redirected to the login page.

Only authenticated users can access the dashboard.

(Optional) Use PHPMailer to send confirmation or password reset links.

🔐 Security
Passwords are hashed using password_hash().

All inputs are sanitized and validated.

Login sessions are protected.

📸 Screenshot

📬 Contact
Developed by Adeoti Israel Adeola
📧 LinkedIn
