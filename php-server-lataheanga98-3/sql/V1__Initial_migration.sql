CREATE TABLE guestbook (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    visitor_name VARCHAR(255) NOT NULL,
    note TEXT NULL,
    created_at DATETIME DEFAULT now()
);

CREATE TABLE employees (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'employee',
    department VARCHAR(100),
    created_at DATETIME DEFAULT NOW()
);