### Architecture Style

The project uses a simple Laravel MVC architecture.

The system must remain a monolithic Laravel application.
No separate frontend, API backend, SPA, microservices, or complex DDD architecture should be used.

### Main Layers

#### Presentation Layer

Responsible for the user interface.

Includes:

- Blade templates;
- layouts;
- reusable UI components;
- public pages;
- user account pages;
- master pages;
- Filament admin resources.

#### HTTP Layer

Responsible for handling requests.

Includes:

- web routes;
- controllers;
- form requests;
- middleware;
- redirects;
- validation errors;
- flash messages.

#### Service Layer

Contains reusable business logic.

Recommended services:

- `OrderPriceCalculator`
- `OrderCreationService`
- `OrderStatusService`

The price calculation logic must be stored only in `OrderPriceCalculator`.

#### Model Layer

Contains Eloquent models and relationships.

Main models:

- `User`
- `ClothingCategory`
- `ClothingModel`
- `TailoringService`
- `Material`
- `MeasurementType`
- `Order`
- `OrderReferenceImage`

#### Data Layer

Uses PostgreSQL and Eloquent ORM.

Flexible order data such as measurements and custom parameters can be stored in JSONB fields.

### Recommended Project Structure

```txt
app/
  Http/
    Controllers/
    Requests/
  Models/
  Services/
  Policies/
  Enums/
  Filament/
    Resources/

database/
  migrations/
  seeders/

resources/
  views/

routes/
  web.php
```

### Main Architectural Rules

Controllers should only handle request flow.

Controllers may:

- receive requests;
- call validation;
- use services;
- return views or redirects.

Controllers must not contain:

- complex price formulas;
- status transition logic;
- large business rules.

Business logic must be moved to services.

Filament is used only for administration.

Blade is used for the public website and user account.
