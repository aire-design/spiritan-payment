# Spiritan Financial System — Complete App Flowchart

> **Stack:** Laravel 10 · Blade · MySQL · Paystack · DomPDF

---

## System Overview

```mermaid
flowchart TD
    subgraph Users
        PUB["🌐 Public / Anonymous"]
        PAR["👨‍👩‍👧 Parent (Authenticated)"]
        ADM["🔐 Admin / Bursar / IT Officer"]
    end

    PUB --> Landing["Landing Page (/)"]
    Landing --> PayForm["Public Pay Form (/pay)"]
    Landing --> AuthPage["Login / Signup"]

    AuthPage --> Login["/login"]
    AuthPage --> Signup["/signup"]

    Login -->|"role: parent"| ParentDash["Parent History (/history)"]
    Login -->|"role: admin/bursar/it_officer"| AdminDash["Admin Dashboard (/dashboard)"]
    Signup --> ParentDash

    PAR --> ParentDash
    PAR --> Profile["Edit Profile (/profile)"]

    ADM --> AdminDash
```

---

## 🌐 Public Payment Flow

```mermaid
flowchart TD
    A["Visit /pay"] --> B["Select: Class · Term · Purpose · Student"]
    B --> C{{"AJAX: /pay/fee-lookup\n(feeLookup)"}}
    C -->|"Fee found"| D["Display Fee Amount / Breakdown"]
    C -->|"Not found"| E["Show: No active fee configured"]
    D --> F["Fill: Student Name · Admission No. · Parent Email/Phone"]
    F --> G["Submit POST /pay"]
    G --> H["Validate + Create Payment record\n(status: pending)"]
    H --> I[["PaystackService::initializeTransaction()"]]
    I --> J["🔀 Redirect → Paystack Checkout"]
    J -->|"Payment done"| K["Paystack redirects to /pay/verify/{payment}"]
    K --> L[["PaystackService::verifyTransaction()"]]
    L -->|"status: success"| M["Update Payment → success\nGenerate receipt_number\nDispatch SendPaymentConfirmationJob"]
    L -->|"status: failed/pending"| N["Payment stays pending"]
    M --> O["Redirect → /pay/receipt/{payment}"]
    N --> O
    O --> P["View Receipt (HTML)"]
    P --> Q["Download PDF Receipt\n(/pay/receipt/{payment}/pdf)\nvia DomPDF"]
    M --> R[["SendPaymentConfirmationJob\n→ Email confirmation to parent"]]
```

---

## 🔐 Authentication Flow

```mermaid
flowchart TD
    A["POST /login"] --> B{{"user_type?"}}
    B -->|"parent"| C["Auth::attempt with role=parent"]
    C -->|"success"| D["Session: user_type=parent\nRedirect → /history"]
    C -->|"fail"| E["Back with error"]
    B -->|"admin / bursar / it_officer"| F["Session spoof\n(no DB check for admin roles)"]
    F --> G["Redirect → /dashboard"]

    H["POST /signup"] --> I["Validate & Create User (role=parent)"]
    I --> J["Auth::login + Session → /history"]

    K["POST /logout"] --> L["Auth::logout + Session clear → /"]
```

---

## 👨‍👩‍👧 Parent Portal

```mermaid
flowchart TD
    A["Parent logs in"] --> B["/history — ParentDashboardController"]
    B --> C["List own payment history\n(by payer_email or student)"]
    A --> D["/profile — Edit Profile"]
    D --> E["Update: name · email · phone · password"]
```

---

## 🏫 Admin Dashboard

```mermaid
flowchart TD
    A["Admin logs in"] --> B["/dashboard — DashboardController"]
    B --> C["Show: Total Students · Active Students\nTotal Paid · Recent 10 Payments"]

    A --> D["Student Management\n(/students)"]
    D --> D1["List Students"]
    D --> D2["Create Student"]

    A --> E["Fee Management\n(/fees)"]
    E --> E1["List Fees"]
    E --> E2["Create Fee\n(with optional Fee Items)"]
    E --> E3["View Fee Detail + Payments"]

    A --> F["Record a Payment\n(/payments)"]
    F --> F1["List All Payments"]
    F --> F2["Create Payment\n(offline cash/POS/bank or online)"]
    F2 -->|"Offline"| F3["status=success immediately\nUpdate student balance"]
    F2 -->|"Online Paystack"| F4["status=pending"]
    F --> F5["View Payment Detail + Logs"]

    A --> G["School Classes\n(/classes)"]
    A --> H["Terms\n(/terms)"]
    A --> I["Academic Sessions\n(/academic-sessions)"]
    A --> J["Payment Purposes\n(/purposes)"]

    A --> K["Reports\n(/reports)"]
    K --> K1["Filter by: status · type · class\nadmission no. · date range"]
    K1 --> K2["Export CSV"]
    K1 --> K3["Export Excel (.xls)"]
    K1 --> K4["Export PDF (DomPDF)"]
```

---

## 🗄️ Data Model Relationships

```mermaid
erDiagram
    User {
        int id
        string first_name
        string last_name
        string email
        string phone
        string role
        string password
    }

    AcademicSession {
        int id
        string name
        date starts_at
        date ends_at
    }

    Term {
        int id
        string name
        int academic_session_id
        date starts_at
        date ends_at
    }

    SchoolClass {
        int id
        string name
        boolean is_active
    }

    Student {
        int id
        string first_name
        string last_name
        string admission_number
        int school_class_id
        string status
        decimal outstanding_balance
        string parent_email
        string parent_phone
    }

    PaymentPurpose {
        int id
        string name
        boolean is_active
    }

    Fee {
        int id
        string name
        string category
        int school_class_id
        int academic_session_id
        int term_id
        decimal amount
        boolean is_variable
        boolean is_active
        decimal late_fee_penalty
        date due_date
    }

    FeeItem {
        int id
        int fee_id
        string name
        decimal amount
    }

    Discount {
        int id
        string type
        decimal value
    }

    Payment {
        int id
        int fee_id
        int student_id
        int academic_session_id
        int term_id
        string student_full_name
        string admission_number
        string class_name
        decimal amount_paid
        decimal discount_amount
        decimal balance_after
        string payment_reference
        string gateway_reference
        string payment_method
        string payment_type
        string payment_purpose
        string status
        string receipt_number
        string payer_email
        string parent_phone
        json gateway_payload
        json metadata
        timestamp paid_at
        timestamp verified_at
    }

    PaymentLog {
        int id
        int payment_id
        string event
        string reference
        string status
        json payload
    }

    AcademicSession ||--o{ Term : "has"
    AcademicSession ||--o{ Fee : "has"
    Term ||--o{ Fee : "for"
    SchoolClass ||--o{ Student : "has"
    SchoolClass ||--o{ Fee : "scoped to"
    Fee ||--o{ FeeItem : "broken into"
    Fee ||--o{ Payment : "paid via"
    Student ||--o{ Payment : "makes"
    Payment ||--o{ PaymentLog : "audited by"
```

---

## ⚙️ Services & Jobs

```mermaid
flowchart LR
    PS["PaystackService"] -->|"initializeTransaction()"| PAY["Paystack API\n(POST /transaction/initialize)"]
    PS -->|"verifyTransaction()"| VER["Paystack API\n(GET /transaction/verify/:ref)"]

    JOB["SendPaymentConfirmationJob\n(queued via dispatch)"] --> MAIL["Mailable → Email\nto parent on success"]

    WEBHOOK["WebhookController\n(/webhook/paystack)\n(Paystack push events)"] --> DB["Update Payment status"]
```
