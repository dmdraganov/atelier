### General UI Style

The interface should be simple, clean, adaptive, and easy to understand.

The project is educational, so usability is more important than advanced animations or complex frontend behavior.

Interface language:

```txt
Russian
```

### Main Layout

The public layout includes:

- header;
- main content;
- footer.

Header should contain:

- atelier name;
- homepage link;
- catalog link;
- order link;
- profile link for authenticated users;
- login/register links for guests;
- logout button for authenticated users.

### Main Pages

Required pages:

- homepage;
- catalog page;
- clothing model page;
- order creation page;
- order history page;
- order details page;
- profile edit page;
- master assigned orders page.

### Catalog UI

Catalog cards should show:

- image;
- model name;
- short description;
- base price;
- details button;
- order button.

### Order Form UI

The order form should include:

- clothing model;
- tailoring service;
- material;
- quantity;
- complexity;
- urgency;
- measurements;
- custom parameters;
- comment;
- reference image upload;
- estimated price block;
- submit button.

Recommended form sections:

```txt
Basic information
Material and options
Measurements
References
Comment
Estimated price
```

Measurement labels must be loaded from the database and displayed as fixed labels. Customers should enter only values and must not edit measurement keys.

The selected tailoring service controls which form fields are visible and required:

- model-based tailoring requires clothing model, material, measurements, quantity, complexity, and urgency;
- alteration requires clothing model and relevant measurements, but not material;
- fixed consultation does not require clothing model, material, measurements, quantity, complexity, or urgency.

The model selector must show only clothing models applicable to the selected tailoring service.

### Order Status Badges

Status labels:

```txt
new: New
confirmed: Confirmed
in_progress: In progress
fitting: Fitting
completed: Completed
cancelled: Cancelled
```

In the actual Russian interface, these labels should be translated.

### Adaptive Design

The interface must work on:

- mobile devices;
- tablets;
- desktop screens.

Rules:

- catalog cards become one-column on mobile;
- forms use full width on mobile;
- tables may become cards on small screens;
- navigation must remain usable.

### JavaScript Usage

JavaScript is allowed only for small UX improvements:

- image preview;
- estimated price update;
- showing or hiding extra fields;
- cancel confirmation.

Critical validation and price calculation must always happen on the server.

### Styling

Tailwind CSS is used for styling Blade templates.

Rules:

- Tailwind is allowed only as a CSS utility framework for server-rendered Blade pages.
- Vite is used only as Laravel's asset pipeline for compiling Tailwind CSS and small Blade-page JavaScript.
- Tailwind must not introduce React, Vue, SPA routing, client-side application state, or a separate frontend application.
- Blade templates remain the source of the interface structure.
- Filament styling remains handled by Filament itself.
- Custom CSS may still be used for small project-specific components when Tailwind utilities become repetitive or reduce readability.

### Filament UI

Admin UI is handled by Filament.

Do not manually recreate admin CRUD pages in Blade.
