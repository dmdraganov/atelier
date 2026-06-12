### Main Entities

The system uses the following entities:

- User
- ClothingCategory
- ClothingModel
- Material
- Order
- OrderReferenceImage

### User

Represents a system user.

Fields:

```txt
id
name
email
password
phone
role
created_at
updated_at
```

Roles:

```txt
customer
master
admin
```

Relationships:

```txt
User has many customer orders
User has many assigned master orders
```

### ClothingCategory

Represents a clothing category.

Examples:

- dresses;
- suits;
- shirts;
- skirts;
- trousers;
- coats.

Fields:

```txt
id
name
slug
description
is_active
sort_order
created_at
updated_at
```

Relationship:

```txt
ClothingCategory has many ClothingModels
```

### ClothingModel

Represents a clothing model or tailoring service.

Examples:

- classic dress;
- business suit;
- men’s shirt;
- pencil skirt;
- classic trousers.

Fields:

```txt
id
category_id
name
slug
description
image_path
base_price
default_complexity
estimated_days
is_active
sort_order
created_at
updated_at
```

Relationship:

```txt
ClothingModel belongs to ClothingCategory
ClothingModel has many Orders
```

### Material

Represents a fabric or sewing material.

Fields:

```txt
id
name
description
price_modifier
is_active
created_at
updated_at
```

`price_modifier` increases the estimated order price.

Relationship:

```txt
Material has many Orders
```

### Order

Represents a customer tailoring order.

Fields:

```txt
id
order_number
customer_id
master_id
clothing_model_id
material_id
status
quantity
complexity
urgency
measurements
parameters
customer_comment
admin_comment
preliminary_price
final_price
cancelled_at
completed_at
created_at
updated_at
```

Relationships:

```txt
Order belongs to customer
Order belongs to master
Order belongs to ClothingModel
Order belongs to Material
Order has many OrderReferenceImages
```

### Order Statuses

```txt
new
confirmed
in_progress
fitting
completed
cancelled
```

Status meaning:

- `new` — created by customer;
- `confirmed` — accepted by admin;
- `in_progress` — currently being made;
- `fitting` — fitting stage;
- `completed` — finished;
- `cancelled` — cancelled.

### Complexity Levels

```txt
simple
medium
complex
```

Recommended multipliers:

```txt
simple: 1.00
medium: 1.25
complex: 1.50
```

### Urgency Levels

```txt
standard
fast
urgent
```

Recommended multipliers:

```txt
standard: 1.00
fast: 1.20
urgent: 1.50
```

### OrderReferenceImage

Represents an uploaded reference image for an order.

Fields:

```txt
id
order_id
file_path
original_name
mime_type
size
created_at
updated_at
```

Allowed formats:

```txt
jpg
jpeg
png
webp
```

### Price Calculation

Service:

```txt
OrderPriceCalculator
```

Formula:

```txt
preliminary_price =
  (base_price + material_modifier + options_price)
  * complexity_multiplier
  * urgency_multiplier
  * quantity
```

Rules:

- the calculated price is preliminary;
- the admin can set the final price;
- price calculation must be centralized in one service.

### Seeders

Required seeders:

- admin user;
- master user;
- customer user;
- clothing categories;
- clothing models;
- materials;
- sample orders.
