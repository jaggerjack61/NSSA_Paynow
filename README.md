# NSSA Paynow - WhatsApp Bot System

> **Note**: The `remove-payments` branch is currently the most up-to-date version of this project.

## Overview

NSSA Paynow is a Laravel-based WhatsApp bot system designed to assist users with NSSA (National Social Security Authority) registration and status checking. The system provides an automated WhatsApp interface that allows users to:

- **Check NSSA Registration Status**: Users can verify their NSSA registration status by providing their ID number
- **NSSA Registration**: Assist users in registering with NSSA through an interactive WhatsApp conversation
- **Portal Registration**: Help registered users apply for portal access and card applications
- **Payment Integration**: Supports Paynow payment gateway for processing registration fees

The system includes a web-based admin dashboard for managing client requests, registrations, cards, and system settings.

## Features

- WhatsApp webhook integration for automated messaging
- Interactive button-based conversations
- Image handling for ID document uploads
- Payment processing via Paynow
- Admin dashboard for managing applications and registrations
- Client status tracking and management
- Automated NSSA SSN lookup functionality

## Requirements

- PHP >= 8.0.2
- Composer
- MySQL or compatible database
- Laravel 9.x
- WhatsApp Business API access (for production)
- Paynow account credentials (for payment processing)

## Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/jaggerjack61/NSSA_Paynow.git
cd NSSA_Paynow
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your `.env` file with the following settings:

```env
APP_NAME="NSSA Paynow"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# WhatsApp Business API Settings
WHATSAPP_TOKEN=your_whatsapp_token
WHATSAPP_PHONE_ID=your_whatsapp_phone_id

# Paynow Settings
PAYNOW_ID=your_paynow_id
PAYNOW_KEY=your_paynow_key
```

### 4. Database Setup

Create your database and run migrations:

```bash
php artisan migrate
```

### 5. Seed the Database

Run the database seeder to create the default administrator account:

```bash
php artisan db:seed --class=UserSeeder
```

### 6. Storage Setup

Create a symbolic link for storage:

```bash
php artisan storage:link
```

Ensure the `clients` directory is writable for storing uploaded ID images:

```bash
mkdir -p clients
chmod -R 755 clients
```

### 7. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Login Credentials

After running the seeder, you can log in to the admin dashboard using:

The login page will be available at `http://localhost:8000/whatsapp`

- **Email/Username**: `admin`
- **Password**: `12345enter`

**Important**: Change the default password immediately after first login for security purposes.

## Webhook Configuration

To set up the WhatsApp webhook:

1. Configure your WhatsApp Business API webhook URL to point to:
   ```
   https://yourdomain.com/api/webhook/receiver
   ```

2. The webhook verification endpoint is:
   ```
   https://yourdomain.com/api/webhook/reciever
   ```

3. Ensure your webhook token matches the token configured in your WhatsApp settings.

## Project Structure

- `app/Http/Controllers/AdvancedWebhookController.php` - Main webhook handler for WhatsApp messages
- `app/Http/Controllers/MainController.php` - Main application controller
- `app/Helpers/PaynowHelper.php` - Paynow payment integration helper
- `database/seeders/UserSeeder.php` - Default user seeder
- `resources/views/` - Blade templates for the web interface

## Key Functionality

### WhatsApp Bot Flow

1. **Welcome Message**: Users receive an interactive menu when they first message
2. **Status Check**: Users can check their NSSA registration by providing their ID number
3. **Registration**: Multi-step registration process collecting user information
4. **Card Application**: Portal registration application with ID image upload
5. **Payment Processing**: Integration with Paynow for fee collection

### Admin Dashboard

Access the dashboard at `/dashboard` (requires authentication) to:
- View and manage client messages
- Process registration applications
- Manage card applications
- Configure WhatsApp and payment settings
- Generate reports

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

This project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## Security Considerations

- Always change default credentials in production
- Use HTTPS for webhook endpoints
- Keep your WhatsApp API tokens and Paynow credentials secure
- Regularly update dependencies
- Review and sanitize all user inputs

## Support

For issues or questions, please refer to the project documentation or contact me.

## License

This project is licensed under the MIT License.
