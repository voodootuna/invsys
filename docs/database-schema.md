# Database Schema

## Tables Overview

### users
Primary user table for authentication and tracking
```sql
- id (bigint, primary key)
- name (string)
- email (string, unique)
- password (string)
- role (enum: 'admin', 'employee') default: 'employee'
- phone (string, nullable)
- email_verified_at (timestamp, nullable)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### equipment_items
Individual equipment pieces that can be rented
```sql
- id (bigint, primary key)
- name (string) - e.g., "Ponceuse 1", "Karcher électrique"
- type (string) - e.g., "drill", "karcher", "ladder", "cable"
- status (enum: 'available', 'rented', 'broken', 'maintenance') default: 'available'
- current_location_id (bigint, foreign key -> locations.id)
- serial_number (string, nullable)
- purchase_date (date, nullable)
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### locations
Places where equipment can be stored or sent
```sql
- id (bigint, primary key)
- name (string) - e.g., "Office", "Shandrani", "Montmartre"
- type (enum: 'warehouse', 'client', 'job_site') default: 'client'
- address (text, nullable)
- contact_name (string, nullable)
- contact_phone (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### rentals
Track equipment movement and rental history
```sql
- id (bigint, primary key)
- equipment_item_id (bigint, foreign key -> equipment_items.id)
- user_id (bigint, foreign key -> users.id) - who took it
- from_location_id (bigint, foreign key -> locations.id)
- to_location_id (bigint, foreign key -> locations.id)
- taken_date (datetime)
- expected_return_date (date, nullable)
- returned_date (datetime, nullable)
- returned_by_user_id (bigint, nullable, foreign key -> users.id)
- status (enum: 'active', 'returned', 'overdue') default: 'active'
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Relationships

### User
- hasMany rentals (as taker)
- hasMany returns (as returner)

### EquipmentItem
- belongsTo currentLocation
- hasMany rentals
- hasOne activeRental (where status = 'active')

### Location
- hasMany equipment (as current location)
- hasMany rentalsFrom
- hasMany rentalsTo

### Rental
- belongsTo equipment
- belongsTo user (taker)
- belongsTo returnedByUser
- belongsTo fromLocation
- belongsTo toLocation