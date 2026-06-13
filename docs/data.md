### Main Entities

The system uses the following entities:

- User
- ClothingCategory
- ClothingModel
- TailoringService
- Material
- MeasurementType
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
ClothingModel belongs to many TailoringServices
```

### TailoringService

Represents a type of atelier service selected by the customer.

Examples:

- custom tailoring from scratch;
- fit alteration;
- evening or occasion look;
- business wardrobe;
- fabric and style consultation.

Fields:

```txt
id
name
slug
description
pricing_mode
base_price
model_price_factor
price_modifier
requires_model
requires_material
requires_measurements
applies_complexity
applies_urgency
applies_quantity
is_active
sort_order
created_at
updated_at
```

`pricing_mode` values:

```txt
model_based
alteration
fixed
```

Pricing meaning:

- `model_based` — calculated from service base price, clothing model price, material price, complexity, urgency, and quantity;
- `alteration` — calculated from service base price and a configurable part of the clothing model price; material is usually not required;
- `fixed` — fixed service price, for example consultation, and does not require model, material, measurements, complexity, or quantity.

`price_modifier` is legacy compatibility data and should not be used by the current calculator.

Relationship:

```txt
TailoringService has many Orders
TailoringService belongs to many MeasurementTypes
TailoringService belongs to many ClothingModels
```

TailoringService should define which ClothingModels are valid for that service. For example, evening services can be limited to dress models, business wardrobe services can be limited to suits, shirts, skirts, and trousers, and fixed consultations can have no required model.

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

### MeasurementType

Represents a measurement field configured by admin.

Examples:

- height;
- chest;
- waist;
- hips;
- garment length;
- sleeve length.

Fields:

```txt
id
name
slug
unit
help_text
is_required
is_active
sort_order
created_at
updated_at
```

Customers fill only measurement values. Measurement labels are loaded from the database and must not be user-editable in the order form.

Measurement types can be attached to specific TailoringServices. Required measurements are evaluated in the context of the selected service.

### Order

Represents a customer tailoring order.

Fields:

```txt
id
order_number
customer_id
master_id
clothing_model_id
tailoring_service_id
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
Order belongs to ClothingModel nullable
Order belongs to TailoringService
Order belongs to Material nullable
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

Formula inputs:

```txt
tailoring service pricing mode
tailoring service base price
clothing model base price, when required
tailoring service model price factor
material price modifier, when required
complexity multiplier
urgency multiplier
quantity
optional parameters price
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
