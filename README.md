# Web-Based Library Management System
**ICT 1108 - Skill Development Project I**  

---

## Project Overview
The **Web-Based Library Management System** is a modern, responsive web application designed to replace manual paper ledgers and inefficient circulation counter queues in academic libraries. Built with a modular two-portal architecture, it provides self-service capabilities for students while giving library staff centralized control over inventory, user registrations, and physical loans.

---

## System Portals & Features

### 1. Student Member Portal
* **Gateway & Registration**: Online student onboarding with an administrative verification hold and automated email credential activation.
* **Student Dashboard**: Real-time alerts, return countdowns, and catalog highlights.
* **Catalog Search & Filter**: Search physical and soft-copy books by title, author, or category.
* **My Bookmarks**: Pin books for assignments, exams, and future checkouts.
* **Borrowed Books Tracking**: Active loans list with color-coded overdue warnings to avoid penalty fees.
* **Member Profile & Account Settings**: Manage contact details and secure passwords.

### 2. Administration Management Portal
* **Centralized Registry & Member Management**: Search and inspect active members, loan records, and standing statuses (Active, Overdue, Blocked).
* **Inventory Control (CRUD)**: Add, edit, or remove book titles, manage accession codes, and configure physical and digital stock.
* **Circulation Control Counter**: Fast desk issue and return transactions with automated stock recalculation.
* **Master Circulation Logs**: Historical archive of all checkouts, due dates, and return timestamps.
* **Member Approval Queue**: Review and verify pending student registration submissions.

---

## Special Innovation Features (Beyond Traditional Libraries)
1. **Student Reviews & Star Ratings**: Coursework-focused peer reviews and ratings on book detail pages.
2. **Visual Analytics & Reading Habits (Chart.js)**: Interactive charts on both student and admin dashboards tracking reading volume and circulation trends.
3. **Smart Waitlist & Book Reservation**: Automated queue reservations when physical copies are exhausted (`Copies = 0`), with hold notifications at the return counter.
4. **Soft Copy Integration**: Read-only Google Drive and PDF preview links directly on catalog entries.

---

## Technology Stack
* **Frontend**: HTML5, CSS3, JavaScript (Vanilla ES6+), Chart.js
* **Backend**: PHP 8.x, PDO
* **Database**: MySQL Relational Database
* **Local Server**: XAMPP / Apache

---

## Project Structure
```
├── css/
│   └── style.css                 # Unified master stylesheet matching wireframes
├── js/
│   ├── main.js                   # Interactive UI handlers (bookmarks, waitlists, filters)
│   └── charts.js                 # Chart.js visual analytics for student & admin
├── images/                       # UI assets and book cover placeholders
├── index.html                    # Main landing gateway (Member vs Admin)
├── contact.html                  # Library helpdesk contact page
├── help.html                     # Frequently asked questions (FAQ)
├── member-login.html             # Student login page
├── member-register.html          # Student registration with approval notice
├── member-dashboard.html         # Student dashboard with analytics & alerts
├── member-search.html            # Search books catalog with waitlist buttons
├── book-detail.html              # Book overview with reviews and soft copy link
├── member-bookmarks.html         # Pinned bookmarks collection
├── member-borrowed.html          # Active loans & waitlist reservations
├── member-profile.html           # Student details & settings
├── admin-login.html              # Admin login page
├── admin-members.html            # Admin dashboard, member list & circulation charts
├── admin-books.html              # Book inventory management (Add/Edit/Delete)
├── admin-borrowed-log.html       # Master circulation logs
├── admin-circulation-desk.html   # Issue & Return counter desk
└── admin-approvals.html          # Student verification & approval queue
```

---

## 💻 How to Run Locally
1. Clone the repository:
   ```bash
   git clone https://github.com/itt2024099/Skill-development-project-library-management-system.git
   ```
2. Simply double-click any `.html` file (e.g., `index.html`) to test the frontend in your browser, or place the folder inside `htdocs` in XAMPP to run via local web server.

---
&copy; 2026 Rajarata University of Sri Lanka. All Rights Reserved.
