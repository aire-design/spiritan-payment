# Spiritan DFMS - User Flow Diagrams

This document illustrates the primary paths users—both Parents and Administrators—take through the digital financial system.

---

## 1. The Parent / Payer Journey

This diagram covers the process of discovering the payment portal, making a payment, and retrieving a receipt. It handles both logged-in parents (who get a streamlined experience) and anonymous guests (like older siblings or relatives paying on a child's behalf).

```mermaid
flowchart TD
    Start((Visit Web Portal)) --> Landing[Landing Page /pay]
    Landing --> IsAuth{Logged In?}
    
    %% Anonymous Flow
    IsAuth -- No --> GuestForm[View Public Form]
    GuestForm --> SelClass[Select Class & Session]
    SelClass --> AJX[AJAX: Fetch active students for class]
    AJX --> SelStudent[Select Student manually]
    SelStudent --> ManualEntry[Manually type Parent Email & Phone]
    ManualEntry --> Calc[System calculates fee amount]
    
    %% Authenticated Flow
    IsAuth -- Yes (Parent) --> ParentForm[View Parent Smart-Form]
    ParentForm --> Dropdown[Click 'Select Child' dropdown]
    Dropdown --> AutoFill[System auto-fills Class, Student Name, Email, Phone]
    AutoFill --> Calc
    
    %% Shared Checkout
    Calc --> Proceed[Click 'Proceed to Secure Checkout']
    Proceed --> PendingDB[(Save as 'Pending' in DB)]
    PendingDB --> Paystack[Redirect to Paystack Gateway]
    
    Paystack --> |User pays with Card/Bank| Webhook(Paystack Server fires Webhook)
    Webhook --> Verify[Verify Signature & Amount]
    Verify --> UpdateDB[(Update DB to 'Successful')]
    UpdateDB --> ReceiptView[Generate E-Receipt & PDF]
    
    Paystack --> |Return to site| SuccessPage[View Receipt Page]
    SuccessPage --> Print[Download PDF / Print]
```

---

## 2. The Administrator Journey

This diagram illustrates how school administrators interact with the system to set up the academic year, manage students, and track financial reports.

```mermaid
flowchart TD
    AdminLogin((Admin Login)) --> Dash[Admin Dashboard]
    
    Dash --> Setup{Academic Setup}
    
    %% Setup Branch
    Setup --> Sessions[Manage Academic Sessions]
    Setup --> Terms[Manage Terms]
    Setup --> Classes[Manage Classes]
    Setup --> Purposes[Manage Payment Descriptors]
    Setup --> Fees[Define Fees per Class & Term]
    
    Dash --> Students{Student Mgmt}
    
    %% Student Branch
    Students --> AddSingle[Add Individual Student]
    Students --> Bulk[Bulk CSV/Excel Upload]
    Bulk --> Validator[System validates rows & checks class names]
    Validator --> CreateOrUpdate[(Update existing or Create new)]
    
    Dash --> Finances{Financial Tracking}
    
    %% Finances Branch
    Finances --> Record[Record Manual Payment (Cash/Transfer)]
    Finances --> ViewAll[View all online/offline payments]
    Finances --> Receipt[Re-print missing receipts]
    
    Dash --> Reports[Export Ledger]
    Reports --> CSV[Download as CSV]
    Reports --> Exl[Download as Excel]
```

---

## 3. The Registration / Linking Process

How do students get linked to their parent's online accounts?

```mermaid
sequenceDiagram
    participant P as Parent
    participant S as System (Web)
    participant A as Admin
    participant DB as Database

    A->>S: Admin creates student (Manual or Bulk)
    Note over A,S: Includes parent_email field (e.g. dad@email.com)
    S->>DB: Save Student Record
    
    P->>S: Parent registers account (dad@email.com)
    S->>DB: Save User (role: parent)
    
    S->>DB: System matches User.email == Student.parent_email
    DB-->>S: Match Found!
    S->>DB: System updates Student.parent_user_id
    
    P->>S: Parent logs in next time
    S->>DB: Fetch children linked via parent_user_id
    DB-->>P: Displays specific children on checkout & history
```
