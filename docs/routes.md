### Routing Type

The project uses Laravel server-side routing.

Routes are defined in:

```txt
routes/web.php
```

No client-side SPA routing is used.

### Public Routes

```txt
GET /                      home
GET /catalog               catalog.index
GET /catalog/{slug}        catalog.show
```

### Authenticated User Routes

```txt
GET /orders                orders.index
GET /orders/create         orders.create
POST /orders               orders.store
GET /orders/{order}        orders.show
PATCH /orders/{order}/cancel orders.cancel
```

### Profile Routes

```txt
GET /profile/edit          profile.edit
PATCH /profile             profile.update
```

### Master Routes

```txt
GET /master/orders         master.orders.index
GET /master/orders/{order} master.orders.show
```

### Admin Routes

Handled by Filament:

```txt
/admin
/admin/orders
/admin/clothing-categories
/admin/clothing-models
/admin/materials
/admin/users
```

### Navigation Scenarios

Guest:

```txt
Home → Catalog → Model page → Login/Register
```

Customer:

```txt
Login → Create Order → Order Details → Order History
```

Master:

```txt
Login → Assigned Orders → Order Details
```

Admin:

```txt
Login → Filament Admin Panel
```
