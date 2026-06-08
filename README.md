# 🏠 Laravel AI Rental Management System

A PHP Laravel web application for rental room and apartment management, featuring tenant management, contract management, invoice management, notification system, resident communication, and AI-powered rental price prediction.

---

## 📌 Overview

**Laravel AI Rental Management System** is a smart rental management platform built with **PHP Laravel MVC**.
The system is designed to help landlords and property managers manage rental rooms, tenants, contracts, invoices, and resident information more efficiently.

In addition to core management features, the project integrates an AI service using **Python FastAPI** and **Scikit-learn** to predict rental prices based on room area, location, utilities, and other property-related factors.

This project was developed as a practical web application to combine traditional rental management with artificial intelligence technology.

---

## 🚀 Key Features

### 🏢 Room Management

Manage rental rooms or apartments, including room details, rental price, availability status, utilities, and images.

### 👥 Tenant Management

Store and manage tenant information, rental history, contact details, and related rental data.

### 📄 Contract Management

Create, view, and manage rental contracts between landlords and tenants.

### 💰 Invoice Management

Manage monthly invoices, rental fees, electricity bills, water bills, service fees, and payment status.

### 🔔 Notification System

Send important announcements, payment reminders, and system notifications to tenants.

### 💬 Resident Communication

Support communication between residents and the management team through a community chat feature.

### 🤖 AI Rental Price Prediction

Use a machine learning model to predict rental prices based on input data such as area, location, utilities, and property features.

### 🎨 Responsive Interface

Provide a modern and user-friendly interface that works well on both desktop and mobile devices.

---

## 🛠 Technologies Used

| Category         | Technology                                       |
| ---------------- | ------------------------------------------------ |
| Backend          | PHP, Laravel Framework                           |
| Architecture     | MVC                                              |
| Frontend         | HTML, CSS, Bootstrap 4, JavaScript, jQuery, AJAX |
| Database         | MySQL                                            |
| AI Service       | Python, FastAPI                                  |
| Machine Learning | Scikit-learn, RandomForestRegressor              |
| Server           | Apache / Nginx                                   |

---

## 📂 Project Structure

```bash
laravel-ai-rental-management-system/
│
├── app/                 # Application logic
├── bootstrap/           # Laravel bootstrap files
├── config/              # Configuration files
├── database/            # Migrations and seeders
├── public/              # Public assets
├── resources/           # Views, CSS, JS files
├── routes/              # Web and API routes
├── storage/             # Logs and uploaded files
├── tests/               # Test files
├── .env.example         # Environment configuration example
├── artisan              # Laravel command-line tool
├── composer.json        # PHP dependencies
├── package.json         # Frontend dependencies
└── README.md            # Project documentation
```

---

## 📦 Installation

### 1. Clone the repository

```bash
git clone https://github.com/PhiHung112-id/laravel-ai-rental-management-system.git
cd laravel-ai-rental-management-system
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create environment file

```bash
cp .env.example .env
```

### 5. Configure database

Open the `.env` file and update your database configuration:

```env
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Generate application key

```bash
php artisan key:generate
```

### 7. Run database migration

```bash
php artisan migrate
```

### 8. Start the development server

```bash
php artisan serve
```

Open the project in your browser:

```text
http://127.0.0.1:8000
```

---

## 🤖 AI Price Prediction Service

The AI price prediction feature is developed as a separate service using **Python FastAPI**.

The Laravel system sends room information to the AI service, including:

* Room area
* Location
* Utilities
* Property type
* Other related features

The AI service processes the input data and returns a predicted rental price using a machine learning model.

Main AI technologies:

```text
Python
FastAPI
Scikit-learn
RandomForestRegressor
```

---

## 📸 Screenshots

> Add project screenshots here.

Example:

```markdown
![Home Page](screenshots/home.png)
![Room Management](screenshots/rooms.png)
![Invoice Management](screenshots/invoices.png)
![AI Price Prediction](screenshots/ai-prediction.png)
```

---

## 👤 Author

**Nguyễn Phi Hùng**
Software Engineering Student

* GitHub: https://github.com/PhiHung112-id
* Email: [phihungone1@gmail.com](mailto:phihungone1@gmail.com)

---

## 📌 Project Purpose

This project was developed to apply **PHP Laravel web development** and **AI technology** to a real-world rental management problem.

The system aims to reduce manual management tasks, improve rental operation efficiency, and provide a better digital experience for landlords, property managers, and tenants.

---

## ⭐ GitHub Repository Description

```text
A PHP Laravel rental management system with tenant, contract, invoice, notification, resident communication, and AI-powered rental price prediction features.
```
