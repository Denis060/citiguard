# CityGuard Architecture

## Overview
CityGuard is an MVC-style PHP web app for reporting and managing city incidents, with role-based admin dashboard, PDF/CSV exports, and region/district/chiefdom filtering.

## Main Components
- **Entry Points:**
  - `index.php`: Public landing page
  - `admin/index.php`: Admin dashboard
  - `controller/submit_report.php`: Report submission endpoint
  - `admin/controller/`: Admin actions (delete, export, update, etc.)
- **Config:** `config/db.php`, `config/config.php`
- **Models:** `model/ReportModel.php`, `model/DashboardModel.php`
- **Views:** `view/`, `admin/`
- **Assets:** `assets/`, `js/`, `admin/js/`
- **Includes:** `includes/header.php`, `includes/footer.php`, `admin/includes/`

## Request Flow
1. User/admin requests a PHP page (file-per-page routing)
2. Page includes config, session, and shared includes
3. Controllers handle form submissions and AJAX (e.g., `submit_report.php`)
4. Models interact with DB (CRUD)
5. Views render HTML, include assets
6. Admin actions require session/auth checks

## Modules
- **Auth:** `admin/auth.php`, `admin/login.php`, `admin/logout.php`
- **Reports:** `controller/submit_report.php`, `admin/reports.php`, `model/ReportModel.php`
- **Exports:** `admin/controller/export_csv.php`, `export_pdf.php`
- **Audit Logs:** `admin/audit_logs.php`, `admin/controller/export_logs.php`
- **Region/Location:** `controller/get_districts.php`, `get_chiefdoms.php`

## Data Lifecycle
- Submit report → Validate → Persist (DB) → List/filter/paginate → Export → Admin review/status update

## Security
- Sessions, password hashing, prepared statements, CSRF, XSS, file upload validation (see Security Fix List)

## Extending
- Add new features via controllers/models/views
- Use config for environment-specific values
