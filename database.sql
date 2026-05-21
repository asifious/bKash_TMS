-- bKash Transaction Management System - Database Schema (MySQL)
-- Compatible with MySQL/MariaDB

DROP DATABASE IF EXISTS bkash;
CREATE DATABASE bkash CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bkash;

-- users
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(191) DEFAULT NULL,
  phone VARCHAR(50) DEFAULT NULL,
  password VARCHAR(191) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  status TINYINT(1) DEFAULT 1,
  last_login_at DATETIME DEFAULT NULL,
  remember_token VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- account_numbers
CREATE TABLE account_numbers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  account_number VARCHAR(100) NOT NULL UNIQUE,
  account_name VARCHAR(191) DEFAULT NULL,
  type VARCHAR(50) DEFAULT NULL,
  status TINYINT(1) DEFAULT 1,
  note TEXT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- transactions
CREATE TABLE transactions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  transaction_type ENUM('cash_in','send_money','received_money') NOT NULL,
  transaction_date DATE NOT NULL,
  from_account_number VARCHAR(100) DEFAULT NULL,
  to_account_number VARCHAR(100) DEFAULT NULL,
  amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  transaction_id VARCHAR(150) DEFAULT NULL,
  note TEXT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_transactions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE UNIQUE INDEX ux_transactions_transaction_id ON transactions(transaction_id);

-- invoices
CREATE TABLE invoices (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  invoice_no VARCHAR(100) NOT NULL UNIQUE,
  invoice_date DATE NOT NULL,
  customer_name VARCHAR(191) NOT NULL,
  account_number VARCHAR(100) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  note TEXT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_invoices_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- application_settings
CREATE TABLE application_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(191) NOT NULL UNIQUE,
  setting_value LONGTEXT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO application_settings (setting_key, setting_value, created_at)
VALUES
('application_name', 'bKash TMS', NOW()),
('company_name', 'bKash Transaction Management System', NOW()),
('country_code', '+880', NOW()),
('company_phone', '01570-000000', NOW()),
('date_format', 'd-m-Y', NOW()),
('time_zone', 'Asia/Dhaka', NOW()),
('country', 'Bangladesh', NOW()),
('declare_country', 'Bangladesh', NOW()),
('currency_code', 'BDT', NOW()),
('currency_symbol', 'BDT', NOW()),
('currency_position', 'before', NOW()),
('invoice_prefix', 'INV', NOW()),
('invoice_due_days', '7', NOW()),
('invoice_tax_rate', '0', NOW()),
('invoice_tax_label', 'Tax', NOW()),
('invoice_footer', 'Thank you for your business.', NOW()),
('invoice_terms', 'Payment is due by the due date shown on this invoice.', NOW()),
('invoice_payment_note', 'Please include the invoice number with your payment.', NOW());

-- announcements
CREATE TABLE announcements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  status TINYINT(1) DEFAULT 1,
  expire_at DATETIME DEFAULT NULL,
  created_by INT UNSIGNED DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_announcements_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- activity_logs
CREATE TABLE activity_logs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED DEFAULT NULL,
  user_name VARCHAR(191) DEFAULT NULL,
  role VARCHAR(50) DEFAULT NULL,
  action VARCHAR(150) NOT NULL,
  description TEXT DEFAULT NULL,
  ip_address VARCHAR(100) DEFAULT NULL,
  user_agent VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_activity_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed: default admin user
-- NOTE: Laravel uses bcrypt. Replace the password field with a bcrypt hash of "admin123" before importing, or run a one-off PHP script on the server to update the password:
-- php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"

INSERT INTO users (name, username, email, phone, password, role, status, created_at)
VALUES ('Administrator', 'admin', 'admin@example.com', '', '$2y$10$2Gon0y45Ils.vK7SxTy2iuinRjfhU5e3ng6o27Sn7nJ31izrpkoIy', 'admin', 1, NOW());

-- Example account numbers
INSERT INTO account_numbers (account_number, account_name, type, status, note)
VALUES
('01700000000', 'Main bKash', 'personal', 1, 'Primary account'),
('01800000000', 'Backup bKash', 'personal', 1, 'Backup');

-- Sample data: optional
-- You can add sample transactions and invoices here or via seeders.

-- End of schema
