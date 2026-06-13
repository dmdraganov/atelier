### API Approach

The project does not use a separate REST API.

All actions are handled through Laravel web routes.

Responses are:

- Blade views;
- redirects;
- validation errors;
- flash messages.

### Public Routes

```txt
GET /
GET /catalog
GET /catalog/{clothingModel:slug}
```

Public users can view the homepage, catalog, and clothing model pages.

### Auth Routes

Standard Laravel authentication routes are used:

```txt
GET /login
POST /login
GET /register
POST /register
POST /logout
```

### Customer Order Routes

```txt
GET /orders
GET /orders/create
POST /orders
GET /orders/{order}
PATCH /orders/{order}/cancel
```

Rules:

- only authenticated customers can create orders;
- selected tailoring service defines whether clothing model, material, quantity, complexity, urgency, and measurements are required;
- customers can view only their own orders;
- customers can cancel orders only before production starts.

### Profile Routes

```txt
GET /profile/edit
PATCH /profile
```

Editable profile fields:

```txt
name
phone
```

### Master Routes

```txt
GET /master/orders
GET /master/orders/{order}
```

Rules:

- master can view only assigned orders;
- master cannot manage catalog, users, or materials.

### Admin Routes

Admin panel is handled by Filament.

Base path:

```txt
/admin
```

Filament resources:

```txt
OrderResource
ClothingCategoryResource
ClothingModelResource
TailoringServiceResource
MaterialResource
MeasurementTypeResource
UserResource
```

Admin can:

- manage orders;
- assign masters;
- edit statuses;
- edit final prices;
- manage catalog;
- manage services;
- manage materials;
- manage measurement types;
- manage users.
