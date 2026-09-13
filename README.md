# Web-Based Library Management System
**ICT 1108 - Skill Development Project I**  
**Department of Information and Communication Technology**  
**Faculty of Technology, Rajarata University of Sri Lanka**  

---

## ðŸ“Œ Project Overview
The **Web-Based Library Management System** is a modern, responsive web application designed to replace manual paper ledgers and inefficient circulation counter queues in academic libraries. Built with a modular two-portal architecture, it provides self-service capabilities for students while giving library staff centralized control over inventory, user registrations, and physical loans.

---

## ðŸ‘¥ Project Team & Work Distribution

| Member | Registration No | GitHub Account | Assigned Module & Contributions |
| :--- | :--- | :--- | :--- |
| **Dulaj Senarathna** *(Leader)* | `ITT/2024/099` | [@itt2024099](https://github.com/itt2024099) | Project Architecture, Core Layout, Responsive Design System (`style.css`), Common Assets, Main Scripts (`main.js`), MySQL Database Schema & Backend APIs |
| **W.O.T.T. Weerasinghe** | `ITT/2024/114` | [@WOTTW](https://github.com/WOTTW) | Public & Authentication Module: Landing Page (`index.html`), Member Login, Student Registration, Catalog Search Wireframes |
| **Damith** | `ITT/2024/033` | [@Damith-itt033](https://github.com/Damith-itt033) | Member Experience Module: Student Dashboard (`member-dashboard.html`), Reading Trends (`charts.js`), Book Details & Reviews, Borrowed Books, Saved Bookmarks |
| **Nimedha Presath** | `ITT/2024/074` | [@Nimedha03](https://github.com/Nimedha03) | Circulation & Inventory Module: Librarian Login, Book Catalog Management (`admin-books.html`), Circulation Issue & Return Desk, Master Borrowing Logs |
| **B.A.A.M. Balasuriya** | `ITT/2024/014` | [@itt2024014-lang](https://github.com/itt2024014-lang) | Administrative & Utility Module: Member Directory (`admin-members.html`), Registration Approval Queue, Student Profile Settings, Contact & Helpdesk FAQ |

---

## ðŸ›ï¸ System Architecture & Portals

### 1. Student Member Portal
* **Gateway & Registration**: Online student onboarding with an administrative verification hold (`member-register.html`, `member-login.html`).
* **Student Dashboard**: Real-time alerts, return countdowns, and reading statistics chart (`member-dashboard.html`).
* **Catalog Search & Filter**: Search physical and digital books by title, author, or discipline (`member-search.html`).
* **My Bookmarks**: Pin books for assignments and future checkouts (`member-bookmarks.html`).
* **Borrowed Books Tracking**: Active loans list with color-coded overdue warnings (`member-borrowed.html`).
* **Member Profile & Security**: Manage contact details and secure passwords (`member-profile.html`).

### 2. Administration Management Portal
* **Centralized Member Registry**: Search and inspect active members and academic standing (`admin-members.html`).
* **Inventory Control (CRUD)**: Add, edit, and organize book titles and accession codes (`admin-books.html`).
* **Circulation Counter**: Rapid physical issue and return workflows with auto-calculated due dates (`admin-circulation-desk.html`).
* **Master Circulation Logs**: Historical archive of checkouts and return timestamps (`admin-borrowed-log.html`).
* **Member Approval Queue**: Review and verify pending student registration requests (`admin-approvals.html`).

---

## âš™ï¸ Installation & Local Setup

### Prerequisites
* Web Server (Apache via **XAMPP**, **WAMP**, or **LAMP**)
* PHP 7.4 or PHP 8.x
* MySQL / MariaDB

### Setup Steps
1. Clone the repository into your local web root:
   ```bash
   git clone https://github.com/itt2024099/ICT1108-Skill-development-project-library-management-system.git
   ```
2. Start **Apache** and **MySQL** via the XAMPP Control Panel.
3. Open phpMyAdmin (`http://localhost/phpmyadmin`) and create a database named `library_db`.
4. Import the schema file located at:
   `database/schema.sql`
5. Configure database credentials in `backend/config/db.php` if needed (Default: `root` with no password).
6. Open your browser and navigate to:
   `http://localhost/ICT1108-Skill-development-project-library-management-system/index.html`
