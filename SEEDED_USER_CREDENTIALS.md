# User Credentials for Testing (Seeded Data)

This document contains the credentials for all users created by the seeders in your Laravel project. These credentials are for development/testing purposes only.

---

## Seller Users
- **Name:** Random (faker generated)
- **Email:** Random (faker generated)
- **Password:** `password123`
- **Count:** 20 sellers (each with a unique user)

## Employee Users (per Seller)
Each seller has the following employees created (all with the same password):

- **Salesmen:** 5
  - **Name:** Random
  - **Email:** Random
  - **Password:** `password123`
- **Delivery Men:** 5
  - **Name:** Random
  - **Email:** Random
  - **Password:** `password123`
- **Accountants:** 5
  - **Name:** Random
  - **Email:** Random
  - **Password:** `password123`
- **Warehouse Managers:** 5
  - **Name:** Random
  - **Email:** Random
  - **Password:** `password123`

---

**Note:**
- All emails and names are generated randomly using Faker, so you can log in with any seeded email and the password `password123`.
- If you need a specific email, check the database after seeding.
- This document is for internal/testing use only. Do not use these credentials in production.
