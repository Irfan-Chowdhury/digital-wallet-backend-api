
<div align='center'>

# 🛠️ Service Booking API System

</div>

A token-authenticated, API-based service booking platform built with Laravel. It allows customers to register, view services, and make bookings, while admins can manage services and monitor bookings.



## Features

### Authentication (Laravel Sanctum)
- Customer registration & login
- Admin login (via seeded credentials)
- Token-based authentication (Sanctum)

### User Roles
- `customer`: Can browse services and book
- `admin`: Can manage services and view all bookings

### Core Modules

#### Users
- Role-based authorization (`admin`/`customer`)
- Enum-based user roles for cleaner logic

#### Services
- CRUD API for admin
- Public listing API for customers

#### Bookings
- Customers can book a service on a specific date
- Validation: No booking in the past or duplicate booking (same date/service/user)

--- 

<br>

## 🧱 Tech Stack

- Laravel 11
- PHP 8.2+
- Sanctum for API tokens
- MySQL
- Pest for testing
- API Resources for response formatting
- Form Requests for validation
- Middleware for role-based protection
- Laravel Pint for code formatting

---

<br>

## ⚙️ Setup Instructions

1. **Clone the repository**

```bash
git clone git@github.com:Irfan-Chowdhury/service-booking-system-api.git

cd service-booking-system-api
````

2. **Install dependencies**

```bash
composer install

cp .env.example .env

php artisan key:generate
```

3. **Configure `.env`**

Update your database, mail, queue connection and other credentials.

4. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

5. **Run the app**

```bash
php artisan serve
```
> The API will now be available at http://127.0.0.1:8000

6. **Testing by PEST (Optional)**

```bash
php artisan test
```
---

### Test Result : 

<img src="https://snipboard.io/5J6YK4.jpg" />


<br>

## User Login Credentials 

- **Email** : admin@example.com
- **Password** : admin123

<br>

## Customer Login Credentials 

- **Email** : irfan123@gmail.com
- **Password** : irfan123

---


<br>



## API Endpoints

Here are the available endpoints with their descriptions.

## 🔁 API Endpoints

### 🔓 Public
| Method | Endpoint         | Description          |
|--------|------------------|----------------------|
| POST   | /api/register    | Register a customer  |
| POST   | /api/login       | Login (admin/customer) |

### 🔐 Authenticated (Customer)
| Method | Endpoint          | Description                  |
|--------|-------------------|------------------------------|
| GET    | /api/services     | List all services            |
| POST   | /api/bookings     | Book a service               |
| GET    | /api/bookings     | View own bookings            |
| POST   | /api/logout       | Logout                       |

### 🔐 Authenticated (Admin Only)
| Method | Endpoint               | Description         |
|--------|------------------------|---------------------|
| POST   | /api/services          | Create a new service |
| PUT    | /api/services/{id}     | Update service       |
| DELETE | /api/services/{id}     | Delete service       |
| GET    | /api/admin/bookings    | View all bookings    |

---

<br>



## ✅ Validations

- Cannot book a service in the past
- Cannot book the same service on the same date (per user)
- Standard Laravel validation using `FormRequest`

---

## API Documentation
Please click the [API Documentation](https://documenter.getpostman.com/view/34865364/2sB3BAKWzR) link to check overall details for this Service Booking API. 


<br>

## 💡 Notes

* Clean error responses using custom exception handlers
* Enum-based role and status management
* Well-structured service layer with `Service Pattern`
* Reusable middleware (`role:admin`, `role:customer`)
* `ApiResponse` helper for consistent API structure


<br>


## Download Postman Collection & Test with Postman

#### Download :
Please download this **POSTMAN Collection File** : [Download Now](https://drive.google.com/file/d/1uDGXVlEsNEgHBW_ri3JVDUj_TUyskIMl/view?usp=sharing)


#### Import :

1. Import the provided Postman collection into your Postman tool.
2. Setup a Environment to use the token for all API request.
3. Then click on the root folder, open the **Authorization** tab.  
    - Select **Type:** `Bearer Token` 
    - In **Token** field, just put the `environment variable`.
4. Test all the endpoints mentioned above.

Some screenshot given below of my previous project's - 

<img src="https://snipboard.io/OezHn7.jpg" />
<br>
<img src="https://snipboard.io/v8ADLV.jpg" />


<br>

## API Authentication (Sanctum)

* All API routes (except login/register) are protected by **Laravel Sanctum**.
* Use `/api/register` and `/api/login` to get an access token.
* Attach `Authorization: Bearer {token}` header for all authenticated routes.

---


<!-- 
## Rate Limiting (Throttle)
* All authenticated API requests are rate limited using Laravel’s `throttle` middleware.
* By default, a user can make **60 requests per minute**.
* If exceeded, the API returns `429 Too Many Requests`.
* This protects the system from abuse and ensures fair usage. -->


<!-- ## ⚡ Performance Notes

* To optimize reporting queries, **indexes** have been added on the `start_time` and `end_time` columns in the `time_logs` table.

  * This improves the efficiency of **date-based filtering** and **aggregation** (e.g., total hours per day/week/month).
* **Eloquent relationships are eager-loaded** where needed to avoid N+1 query problems and reduce database load.
* **Caching** has been applied to frequently accessed data:

  * All **clients** and **projects** for the authenticated user are cached per user to reduce repetitive queries.
  * **Report results** are cached based on filters like date range, client, and project to avoid heavy recomputation during repeated API hits.
* These optimizations collectively enhance API performance, especially under high traffic or large data volumes. -->


<br>



## Error Handling
The API includes proper error handling with meaningful HTTP status codes:
- **401 Authentication:** Access to app.
- **403 Forbidden:** Unauthorized access.
- **404 Not Found:** Resource not found.
- **422 Unprocessable Entity:** Validation errors.
- **429 Error:** Too Many Request.
- **500 Error:** Internal Server error.




## 👨‍💻 Author

**Md Irfan Chowdhury** <br>
PHP-Laravel Developer  <br>
🔗 [LinkedIn Profile](https://www.linkedin.com/in/irfan-chowdhury/) | 📧 [irfanchowdhury80@gmail.com](irfanchowdhury80@gmail.com)
