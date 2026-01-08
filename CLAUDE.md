# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Fire Safety Compliance Module** built on CodeIgniter 3.x with HMVC (Hierarchical Model-View-Controller) architecture. It's a multi-tenant business application supporting inventory, sales, purchases, production, CRM, POS, and accounting modules.

## Development Commands

```bash
# Install PHP dependencies
composer install

# Database setup - import the main schema
mysql -u [user] -p [database] < db/clacton.sql

# Run local development server (PHP built-in)
php -S localhost:8000

# Run tests (PHPUnit 4.x/5.x)
vendor/bin/phpunit
```

## Architecture

### Directory Structure
- `index.php` - Front controller (entry point)
- `ci/system/` - CodeIgniter core framework (do not modify)
- `ci/application/` - Application code
- `components/` - Frontend assets (CSS, JS, images, third-party libraries)
- `uploads/` - User-uploaded files
- `db/`, `sql/` - Database migration scripts

### HMVC Module Structure
Each module in `ci/application/modules/` follows the MVC pattern:
```
modules/
├── accounts/     # Financial accounting
├── admin/        # Administration & user management
├── business/     # Business unit configuration
├── crm/          # Customer relationship management
├── documents/    # Document management
├── inventory/    # Stock & warehouse management
├── pos/          # Point of sale
├── production/   # Manufacturing/production
├── purchase/     # Purchase orders
├── rawmaterial/  # Raw material tracking
├── reports/      # Reporting
├── sale/         # Sales management
└── welcome/      # Authentication & landing
```

### Core Classes (ci/application/core/)
- `MY_Controller.php` - Base controller with authentication, session handling, business unit context, financial year management, and permission checks
- `MY_Model.php` - Extended model with CRUD operations, soft deletes, validation, callbacks, and relationships
- `MY_Router.php` - Custom routing for HMVC
- `MY_Loader.php` - Extended loader for modules with template methods (`template()`, `admintemplate()`, `signintemplate()`, `postemplate()`)

### Key Libraries (ci/application/libraries/)
- `REST_Controller.php` - RESTful API support
- `M_pdf.php` - PDF generation via mPDF
- `Excel.php` - Excel file handling
- `Stripe-php/` - Stripe payment integration
- `TextToSpeech.php` - TTS functionality
- `Template.php`, `View.php` - View templating

### Third-Party Libraries (ci/application/third_party/)
- `mpdf/` - PDF generation
- `dompdf/` - Alternative PDF generation

## Development Patterns

### Controller Pattern
Controllers extend `MY_Controller` and use render methods:
```php
class Example extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('module/model_name', 'alias');
    }

    public function index() {
        $data['content'] = $this->load->view('example/index', $data, true);
        $this->dashboardrender($data['content']);  // Full dashboard layout
        // or: $this->framerender($data['content']);  // Frame/partial layout
    }
}
```

### View Rendering Methods
- `$this->dashboardrender($content)` - Full page with sidebar and header
- `$this->framerender($content)` - Partial/iframe layout without navigation
- `$this->load->template('viewname', $data)` - HMVC module template loader
- `$this->render($content)` - Sign-in/basic layout

### Model Pattern
Models extend `MY_Model` with automatic table detection and ORM features:
```php
class Product_model extends MY_Model {
    protected $_table = 'ub_products';
    protected $primary_key = 'product_id';
    protected $soft_delete = FALSE;  // Enable logical deletes if needed

    // Callbacks available: before_create, after_create, before_update,
    // after_update, before_get, after_get, before_delete, after_delete

    // Relationships: belongs_to, has_many (use with() for eager loading)
}
```

### Session Variables
Key session data available in controllers via `MY_Controller`:
- `$this->loggeduserid` - Current user ID
- `$this->businessid` - Current business ID
- `$this->buid` - Current business unit ID
- `$this->finyearid` - Current financial year ID
- `$this->userrole` - User role (1=admin, 2=business owner)
- `$this->permissionmodulearrayspages` - Module permissions array
- `$this->currency`, `$this->currencysymbol`, `$this->decimalpoints` - Localization
- `$this->isvatgst` - Tax type (0=GST, 1=VAT)
- `$this->godownid` - Current warehouse/godown ID

### Checksum Security
Controllers use checksum validation for secure operations:
```php
// Generate checksum
$checksum = $this->checksumgen($id);  // Uses SHA1(HASHCODE + value)

// Validate checksum
if ($this->validchecksumcheck($id, $hash)) {
    // Valid request
}
```

### Database
- MySQL with mysqli driver
- Query Builder enabled
- Character set: UTF-8
- Table prefix: `ub_` (e.g., `ub_products`, `ub_customers`)

## Code Style
- Allman indent style (braces on new line)
- Tabs for indentation
- LF line endings
- UTF-8 character set
- **PHP 5.3.7+ compatible** - Do NOT use:
  - Null coalescing operator (`??`)
  - Null safe operator (`?->`)
  - Short array syntax in older files (`[]` vs `array()`)
  - Arrow functions (`fn() =>`)
  - Typed properties or return types

## Configuration Files
- `ci/application/config/database.php` - Database connection
- `ci/application/config/routes.php` - URL routing and API routes
- `ci/application/config/autoload.php` - Auto-loaded libraries and helpers

### Auto-loaded Resources
Libraries: database, session, view, template, password, email
Helpers: url, form, file, html, application, my_form_helper, string, excel, security, commonfunction, my_array_helper, my_common_helper, my_date_helper

### Application Constants (ci/application/config/constants.php)
- `HASHCODE` - Used for checksum generation (SHA1-based security)
- `FOLDERPATH` - Upload directory path ('uploads')
- `QUERYLIMIT` - Default pagination limit
- `PAGINATIONPERPAGECOUNT` - Items per page for pagination

### Custom Helper Functions
Common date functions in `my_date_helper.php`:
- `current_date_mysqlformat()` - Returns current date as 'Y-m-d'
- `get_date($date)` - Formats date as 'd-M-Y'
- `get_updated_on()` - Returns current datetime for update timestamps

## API Endpoints
REST API controllers in `ci/application/controllers/api/`:
- Uses `REST_Controller` library
- Routes configured in `ci/application/config/routes.php`
- Supports multiple response formats (JSON, XML)
