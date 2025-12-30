# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Fire Safety Compliance Module** built on CodeIgniter 3.x with HMVC (Hierarchical Model-View-Controller) architecture. It's a multi-tenant business application supporting inventory, sales, purchases, production, CRM, POS, and accounting modules.

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
- `MY_Loader.php` - Extended loader for modules

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
    public function index() {
        $data['content'] = $this->load->view('example/index', $data, true);
        $this->dashboardrender($data['content']);  // Full dashboard layout
        // or: $this->framerender($data['content']);  // Frame/partial layout
    }
}
```

### Model Pattern
Models extend `MY_Model` with automatic table detection:
```php
class Product_model extends MY_Model {
    protected $_table = 'products';
    protected $primary_key = 'product_id';
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

### Database
- MySQL with mysqli driver
- Query Builder enabled
- Character set: UTF-8

## Code Style
- Allman indent style (braces on new line)
- Tabs for indentation
- LF line endings
- PHP 5.3.7+ compatible

## API Endpoints
REST API controllers in `ci/application/controllers/api/`:
- Uses `REST_Controller` library
- Routes configured in `ci/application/config/routes.php`
