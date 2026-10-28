# Laundry Desk

A CRUD website for a small laundry business with three outlets in Surabaya. Staff take in orders, track every status change and record payments. Customers register an account and follow their own bills.

Built for the EF234301 Web Programming (D) Midterm Exam, 2026/2027. Based on Problem 8.4 of the course book (Laundry Desk), implemented with Laravel.

## Features

| Code | Feature | Who |
|---|---|---|
| Auth | Registration, login, logout | everyone |
| F1 | List and search customers | staff |
| F2 | Add a customer | staff |
| F3 | Edit a customer | staff |
| F4 | Delete a customer (blocked while the customer still has bills) | staff |
| F5 | Price list | everyone |
| F6 | Take in a new bill (the server calculates the total) | staff |
| F7 | Move a bill forward: received, finished, collected (every change is logged) | staff |
| F8 | Bill detail, record payments, remaining balance | staff |
| F9 | Customers see only their own bills and balance | customer |

## Database

Seven tables: `outlets`, `users`, `customers`, `services`, `bills`, `payments`, `status_logs`. Ten foreign keys, all `RESTRICT` on delete.

## Run locally

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Open http://127.0.0.1:8000

## Demo accounts

Password for all accounts: `password123`

| Role | Email |
|---|---|
| Staff (Keputih Outlet) | rina@laundrydesk.test |
| Staff (Gebang Outlet) | dimas@laundrydesk.test |
| Staff (Manyar Outlet) | hanif@laundrydesk.test |
| Customer | bayu@laundrydesk.test |

## Photo credits

Photos from Unsplash: hero photo by Yuncho, machines photo by Mathias Reding, folded laundry photo by Victor Volkov.
