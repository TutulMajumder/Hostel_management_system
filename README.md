# Hostel Management System

A comprehensive web-based solution for managing hostel operations, including student admissions, room assignments, complaints, health services, attendance, and accounts.

---

## Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Setup & Installation](#setup--installation)
- [Database Import](#database-import)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [Troubleshooting](#troubleshooting)
- [Roadmap](#roadmap)
- [Contributors](#contributors)
- [License](#license)
- [Contact](#contact)

---

## Features

- **Student Portal:** Room application, complaints, mess menu, health requests, profile management.
- **Warden Portal:** Room assignment, attendance, complaints/services handling, notices.
- **Health Officer Portal:** Health requests, doctor scheduling, medicine inventory, feedback, reports.
- **Accountant Portal:** Student fees, salary payments, expenses, reminders.

---

## Project Structure

```
Account/
    CSS/           # Accountant styles
    DB/            # Accountant DB config
    View/          # Accountant pages
Health_officer/
    css/           # Health officer styles
    db/            # Health officer DB config
    img/           # Images
    php/           # Health officer backend
    view/          # Health officer pages
Student/
    CSS/           # Student styles
    DB/            # Student DB config
    img/           # Images
    php/           # Student backend
    View/          # Student pages
Warden/
    Css/           # Warden styles
    Db/            # Warden DB config/tables
    img/           # Images
    Php/           # Warden backend
    uploads/       # Notice uploads
    View/          # Warden pages
```

---

## Technologies Used

- PHP (Backend)
- MySQL (Database)
- HTML, CSS, JavaScript (Frontend)
- XAMPP (Local Development)

---

## Setup & Installation

### Prerequisites

- PHP 7+
- MySQL/MariaDB
- Apache (XAMPP recommended)

### Clone the Repository

Open **Git Bash** and run:

```sh
git clone https://github.com/yourusername/Hostel_management_system.git
cd Hostel_management_system
```

Or download and extract the ZIP file from your repository host.

---

## Database Import

1. Start Apache and MySQL using XAMPP.
2. Open your browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Create a new database (e.g., `hostel_management_system`).
4. Click the database name, then go to the **Import** tab.
5. Select the provided SQL file:  
   `Warden/Db/hostel_management_system.sql`
6. Click **Go** to import the tables and data.

7. Update database credentials in config files if needed:
   - `Warden/Db/config.php`
   - `Account/DB/config.php`
   - `Health_officer/db/config.php`
   - `Student/DB/apply_room_DB.php`

---

## Usage

- Place the project folder in your web server root (e.g., `htdocs` for XAMPP).
- Access the system in your browser:
  ```
  http://localhost/Hostel_management_system/Warden/View/homepage.php
  ```
- Use the respective dashboards for Students, Wardens, Health Officers, and Accountants.

---



## Contributing

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Open a Pull Request.

---

## Troubleshooting

- **Blank Page:** Check your PHP error logs and ensure all config files have correct database credentials.
- **Database Import Error:** Make sure you created the database before importing the SQL file.
- **Login Issues:** Verify user credentials and that the database is properly imported.

---

## Roadmap

- Add hostel room availability calendar
- Integrate email notifications for students and staff
- Mobile-friendly responsive design
- Role-based access control improvements
- Enhanced reporting and analytics

---

## Contributors

- Arpon Paul — Student
- Tutul Majumder — Warden
- Abdullah Bin Sefat — Accountant
- MJobayed Hazary — Health Officer

---

## License

For academic and demonstration use only.

---

## Contact

**Email:** majumder.tutul.364@gmail.com  
**Address:** American International University-Bangladesh, Dhaka, Bangladesh
