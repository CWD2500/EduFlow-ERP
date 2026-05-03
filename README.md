# 🎓 EduFlow ERP: Automated Institute Management System

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript)

**EduFlow ERP** is a high-performance, fully automated Institutional Resource Planning system designed to streamline academic workflows. It transforms manual administrative tasks into a seamless digital ecosystem, managing everything from departmental hierarchies to intelligent student lifecycle transitions.

---

## 🚀 Key Features

### 🏛️ Department & Academic Management
* **Specialization Control:** Manage departments like Software Engineering, Networking, and more.
* **Subject Matrix:** Intelligent course management with a distinction between **Theoretical** and **Practical** modules.
* **Faculty Assignment:** Advanced module for assigning one or multiple instructors to specific subjects.

### 🤖 The Automation Engine (Smart Logic)
The core of EduFlow ERP is its **Automated Transition Engine**. It eliminates manual grading errors through:
* **Auto-Grading Logic:** Real-time calculation of pass/fail status upon grade entry.
* **Smart Routing:** * **Successful Students:** Automatically moved to advanced data display records.
    * **Unsuccessful Students:** Instantly migrated to the **Supplementary Exam System** (التكميلي) based on predefined academic rules.
* **Conflict Validation:** Built-in validation to ensure data integrity during automated migrations.

### 📊 Advanced Analytics Dashboard
A comprehensive data visualization hub for administrators providing:
* Real-time **Success/Failure** percentage charts.
* Live counters for total students, faculty members, and active courses.
* Objection tracking metrics to monitor student satisfaction.

### 📩 Interaction & Notifications
* **Student Portal:** Clean UI for students to view grades and academic status.
* **Objection System:** Students can raise appeals/objections directly from their dashboard.
* **Admin Notifications:** Real-time alerts for administrators when new objections are submitted.

---

## 🏗️ System Architecture & Design

To ensure a deep understanding of the system's complexity, we have documented the logic flow and database structure below.

### 1. Conceptual Logic Flow (System Logic)
This diagram illustrates the business logic, entity relationships, and the automated "Success/Fail" path.

![Conceptual Model](docs/conceptual-logic.jpg)

### 2. Physical Database Schema (Technical Structure)
The technical blueprint showing the 12+ interconnected tables, data types, and relational constraints in MySQL.

![Database Schema](docs/database-schema.png)

---

## 🛠️ Tech Stack

| Layer | Technology |
| :--- | :--- |
| **Backend** | Laravel (PHP 8.x) |
| **Frontend** | Blade Engine, HTML5, CSS3 |
| **Styling** | Bootstrap 5 |
| **Interactivity** | JavaScript (Vanilla & AJAX) |
| **Database** | MySQL |

---

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/CWD2500/EduFlow-ERP.git](https://github.com/CWD2500/EduFlow-ERP.git)
   cd EduFlow-ERP
