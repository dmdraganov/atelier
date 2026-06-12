# Atelier Clothing Order System

### Project Overview

The project is a fullstack educational information system for a clothing atelier.
It is designed to accept custom tailoring orders, calculate an estimated price, manage order statuses, and provide basic user, master, and admin workflows.

### Project Type

Fullstack monolithic web application.

### Technology Stack

- Backend: Laravel
- Frontend: Blade
- Admin Panel: Filament
- Database: PostgreSQL
- ORM: Eloquent
- Authentication: Laravel Auth
- File Storage: Laravel Filesystem

### Main Purpose

The system allows customers to:

- browse clothing models;
- choose tailoring options;
- create individual orders;
- upload reference images;
- receive an estimated price;
- view order history and status.

Admins can manage orders, catalog items, materials, users, and masters through Filament.

Masters can view orders assigned to them.

### User Roles

- `customer` — registered user who creates orders;
- `master` — atelier worker assigned to orders;
- `admin` — system administrator.

### Main Modules

- Clothing catalog
- Custom order form
- Price calculator
- User profile
- Order history
- Master workspace
- Filament admin panel

### Key Limitations

The system does not include:

- online payments;
- real delivery;
- chat;
- notifications;
- mobile application;
- REST API;
- multilingual support.

The interface language is Russian.

## Project Documentation

The project documentation is split into several files. Each file describes a specific part of the system and should be used as a source of truth during development.

- [architecture.md](./docs/architecture.md) — application architecture, layers, project structure, and architectural rules.
- [constraints.md](./docs/constraints.md) — technical, functional, and architectural limitations that must be followed.
- [data.md](./docs/data.md) — database entities, relationships, enums, fields, and data rules.
- [api.md](./docs/api.md) — Laravel web actions, form routes, request handling, validation, and access rules.
- [routes.md](./docs/routes.md) — public, customer, master, profile, and admin routes.
- [ui-guide.md](./docs/ui-guide.md) — UI principles, page structure, components, responsiveness, and Blade interface rules.

Documentation priority:

1. `constraints.md` has the highest priority and defines what must not be violated.
2. `architecture.md` defines how the system should be structured.
3. `data.md` defines the database model and relationships.
4. `routes.md` and `api.md` define how users interact with the system.
5. `ui-guide.md` defines how the Blade interface should be designed.

If there is a conflict between files, follow `constraints.md` first.
