# Hotel Booking API Documentation

## Introduction

This document outlines the endpoints available in the Hotel Booking API, allowing clients to manage rooms, bookings, customers, and payments.

## Base URL

All URLs referenced in the documentation have the base path `http://localhost:8000/api`.

## Authentication

### Register a User

- **POST** `/register`
- **Body**:

  ```json
  {
    "name": "user name",
    "email": "user@example.com",
    "password": "password"
  }

### Success Response: 200 OK, Returns user details with an access token.


### Login

- **POST** `/login`
- **Body**:


  ```json
  {
    "email": "user@example.com",
    "password": "password"
  }

### Success Response: 200 OK, Returns an access token.

### Endpoints

### Room Management

List All Rooms

- **GET** `/rooms`
- ### Success Response: 200 OK, Returns a list of rooms.

Get Room Details

- **GET** `/rooms{room}`
- ### Success Response: 200 OK, Returns details of a specific room.

Create a Room (Protected)

- **POST** `/rooms`
- **HEADERS** `Authorization: Bearer <access_token>`
- **Body**:

  ```json
  {
    "number": "101",
    "type": "Deluxe",
    "price_per_night": 150,
    "status": "available",
  }
  
- ### Success Response: 201 Created, Returns the created room details.

### Booking Management

List All Bookings

- **GET** `/bookings`
- ### Success Response: 200 OK, Returns a list of booking.

Create a Booking (Protected)

- **POST** `/bookings`
- **HEADERS** `Authorization: Bearer <access_token>`
- **Body**:

  ```json
  {
    "room_id": 1,
    "customer_id": 1,
    "check_in_date": "2024-01-01",
    "check_out_date": "2024-01-05",
    "total_price": 400
  }
  
- ### Success Response: 201 Created, Returns the created booking details.

Customer Management

List All Customers

- **GET** `/customers`
- ### Success Response: 200 OK, Returns a list of customers.

Create a Customer (Protected)

- **POST** `/customers`
- **HEADERS** `Authorization: Bearer <access_token>`
- **Body**:

  ```json
  {
    "name": "John Doe",
    "email": "johndoe@example.com",
    "phone_number": "1234567890"
  }

- ### Success Response: 201 Created, Returns the created customer details.


Payment Recording

Record a Payment (Protected)

- **POST** `/payments`
- **HEADERS** `Authorization: Bearer <access_token>`
- **Body**:

  ```json
  {
    "booking_id": 1,
    "amount": 400,
    "payment_date": "2024-01-02",
    "status": "completed"
  }

- ### Success Response: 201 Created, Returns the recorded payment details.

Status Codes


To use this documentation:
1. Copy the content above into a new file.
2. Save the file with the `.md` extension, for example, `API_Documentation.md`.
3. You can view or edit this file with any text editor, but it's best viewed in a Markdown editor or a platform that supports Markdown rendering, such as GitHub, GitLab, or Bitbucket.
