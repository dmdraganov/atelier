### Required Stack

Only the Laravel ecosystem should be used:

- Laravel
- Blade
- Filament
- PostgreSQL
- Eloquent
- Laravel Auth
- Laravel Filesystem

### Forbidden Technologies

Do not use:

- React
- Vue
- Angular
- Next.js
- Nuxt
- GraphQL
- REST API as a separate backend
- Firebase
- Supabase
- microservices
- mobile app

### Functional Limitations

The system must not implement:

- online payments;
- payment gateway integration;
- delivery;
- delivery tracking;
- customer-admin chat;
- customer-master chat;
- SMS notifications;
- email notifications;
- push notifications;
- CRM;
- accounting;
- warehouse management;
- multilingual interface.

### Role Restrictions

The system has only three roles:

```txt
customer
master
admin
```

A customer can:

- browse the catalog;
- create orders;
- view own orders;
- edit basic profile data;
- cancel an order before production starts.

A master can:

- view only assigned orders.

A master cannot:

- manage users;
- edit catalog;
- edit materials;
- manage all orders;
- act as admin.

An admin can:

- manage users;
- manage orders;
- manage catalog;
- manage materials;
- assign masters;
- change statuses;
- edit final prices.

### Price Calculation Rules

The calculator provides only an estimated price.

The final price can be changed by the admin after reviewing the order.

The price formula must not be duplicated in controllers, views, models, or Filament resources.
