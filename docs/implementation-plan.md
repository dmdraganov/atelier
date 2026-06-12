# Implementation Plan

Дата создания: 2026-06-13

## Source Documents

- `README.md`
- `docs/constraints.md`
- `docs/architecture.md`
- `docs/data.md`
- `docs/routes.md`
- `docs/api.md`
- `docs/ui-guide.md`

## Ground Rules

- Стек: Laravel, Blade, Filament, PostgreSQL, Eloquent, Laravel Auth, Laravel Filesystem.
- Архитектура: монолитное Laravel MVC-приложение, без SPA, REST API, микросервисов и отдельного фронтенда.
- Интерфейс: русский язык.
- Стилизация Blade-интерфейса использует Tailwind CSS через Vite как Laravel asset pipeline, без SPA и без отдельного frontend-приложения.
- Роли: только `customer`, `master`, `admin`.
- Администрирование: только через Filament.
- Расчет предварительной цены: только в `OrderPriceCalculator`.
- Не реализовывать платежи, доставку, чаты, уведомления, CRM, учет, склад и мультиязычность.

## Checklist

- [x] Проверить текущий Laravel-проект, зависимости, `.env` и стартовые файлы.
- [x] Установить недостающие Laravel-пакеты для Filament и, при необходимости, auth scaffolding без нарушения ограничений стека.
- [x] Спроектировать и создать БД: enum-поля, миграции, модели, связи, сидеры.
- [x] Реализовать бизнес-слой: калькулятор цены, создание заказа, статусы, политики доступа.
- [x] Настроить web-маршруты, Laravel Auth, контроллеры и form requests.
- [x] Собрать Blade-интерфейс на русском: публичные страницы, каталог, заказы, профиль, кабинет мастера.
- [x] Настроить Filament admin panel и ресурсы для заказов, каталога, материалов и пользователей.
- [x] Добавить файловую загрузку reference images через Laravel Filesystem.
- [x] Добавить focused-тесты на расчет цены, доступы и ключевые web-сценарии.
- [x] Запустить форматирование, миграции/сидеры, тесты и при возможности локальный сервер для проверки UI.

## Progress Log

- 2026-06-13: Прочитаны `README.md` и локальная документация в `docs/`. Сформирован базовый план реализации.
- 2026-06-13: Проверен стартовый проект: Laravel 13.15.0, `.env` создан, установлены только базовые Laravel-зависимости, Filament отсутствует, auth scaffolding отсутствует, локальная БД настроена на SQLite.
- 2026-06-13: Установлен `filament/filament` 5.6.7 и выполнен `php artisan filament:install --panels`; auth решено реализовать на Laravel Auth без дополнительного starter kit.
- 2026-06-13: Созданы enum-классы, доменные модели, миграции и сидеры. Миграции/сидеры успешно проверены с временным SQLite-подключением; проектная `.env` настроена на PostgreSQL, но в текущем PHP окружении отсутствует `pdo_pgsql`.
- 2026-06-13: Реализованы `OrderPriceCalculator`, `OrderCreationService`, `OrderStatusService`, `OrderPolicy`, form requests, auth/catalog/order/profile/master контроллеры и web-маршруты. `php artisan route:list` проходит.
- 2026-06-13: Собраны Blade-страницы на русском, добавлены Filament 5 ресурсы для заказов, категорий, моделей, материалов и пользователей, выполнен `php artisan storage:link`.
- 2026-06-13: Добавлены focused-тесты для калькулятора цены, создания заказа с reference image, customer/master access rules и admin panel access. `php artisan test` проходит: 5 тестов, 14 assertions.
- 2026-06-13: Vite временно удалялся из пользовательского Blade-интерфейса как лишний build-step; решение позже пересмотрено в пользу Tailwind CSS через Vite.
- 2026-06-13: Локальный сервер запущен для проверки UI на `http://127.0.0.1:8002` с временным SQLite override; главная страница отвечает `200 OK`.
- 2026-06-13: В `docs/ui-guide.md` добавлено правило: Tailwind CSS разрешен для стилизации Blade-шаблонов как CSS utility framework, но не должен превращать проект в SPA или отдельный frontend.
- 2026-06-13: Tailwind CSS и Vite возвращены по решению проекта: `resources/css/app.css` использует Tailwind v4, Blade layout снова подключает ассеты через `@vite`, `npm run build` проходит. После установки `pdo_pgsql` текущая PostgreSQL-конфигурация работает; сервер запущен на `http://127.0.0.1:8003`, главная страница отвечает `200 OK`.
- 2026-06-13: Проведен повторный аудит по `README.md` и всем документам из `docs/`. Исправлены найденные расхождения: главная вынесена в `HomeController`, customer/master routes явно ограничены role middleware, в Filament orders убрано создание заказа и ручное редактирование preliminary price, `.env.example` переведен на PostgreSQL и русскую локаль, каталог получил локальные изображения услуг. PostgreSQL сидеры выполнены: 5 категорий, 7 моделей, 5 материалов.
- 2026-06-13: Исправлен редирект после входа: пользователь попадает только в раздел своей роли, `remember me` больше не отправляет администратора на клиентский `/orders`. Клиентские CTA и навигация скрыты для `admin` и `master`, добавлены regression-тесты.
