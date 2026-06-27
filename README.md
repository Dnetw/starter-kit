# dnetw Starter Kit

A Laravel 13 starter kit pre-wired with the **dnetw** ecosystem — admin surface, permissions, auth (Fortify + Passkeys + 2FA), settings, sidebar nav, and the dnetw look-and-feel out of the box. Built on Livewire 4 + Flux UI.

## Create a new app

```bash
laravel new my-app --using=dnetw/starter-kit
```

That clones this template, installs Composer dependencies (pulling `dnetw/core` + `dnetw/admin` and their transitive deps `dnetw/attachments` + `dnetw/comments`), copies `.env.example` → `.env`, generates an `APP_KEY`, and links `public/storage`.

## Finish setup

```bash
cd my-app
# Configure DB credentials in .env, then:
npm install && npm run build
php artisan dnetw:install --no-composer
```

`dnetw:install` prompts for the app name + optional dnetw packages to layer on, scaffolds anything not already in place, runs `migrate` + the registry sync chain (`roles-sync`, `permissions-sync`, `routes-sync`, `dashboard-cards-sync`, `sync-route-access --commit`), and creates the **root super-user** (id=1, Administrators role) via an interactive prompt.

Once that finishes, browse to `https://<my-app>.test` (Herd) or whichever URL you set in `APP_URL`, log in as the root user, and you're in.

## What's included

- **dnetw/core** — Foundation: layouts, locale switcher, primitives (Activity, Broadcastable, etc.), NavRegistry, DashboardCard, Volt page wiring, the entire installer.
- **dnetw/admin** — Auth + admin surface. HasAdminRoles / IsRootUser / AdminUser contract on the User model; Permission / Role / Profile / LoginEvent / Setting models; FortifyDefaults; every `admin.*` Volt page; sidebar groups; RoutePermissionMap; UserObserver auto-assigning the `Users` baseline role.
- **dnetw/attachments** (transitive) — Polymorphic file attachments + admin panel.
- **dnetw/comments** (transitive) — Polymorphic comments across commentable models.

## Add more dnetw packages

Suggested packages this kit doesn't ship by default (because the bare minimum should stay bare):

```bash
composer require dnetw/calendar      # month/week views, ICS feed, holidays
composer require dnetw/inbox         # in-app messages + rules
composer require dnetw/notifications # Telegram / Teams / Discord channels
composer require dnetw/search        # Scout-backed global search
composer require dnetw/tags          # polymorphic tagging
```

After each `composer require`, re-run `php artisan dnetw:install` to re-emit `app/Models/User.php` with the new package's trait, refresh registries, and pick up any new permissions / nav items.

## Local development against `dnetw/*` source

If you have the `dnetw/*` source checked out alongside your app (the standard layout is `Herd/packages/dnetw/<package>` + `Herd/<your-app>`), running `php artisan dnetw:install` auto-detects them and switches `vendor/dnetw/*` to symlinks via path repos. Edits to `Herd/packages/dnetw/core/src/...` are visible immediately in your app — no commit, push, tag, or `composer update` round-trip needed.

If the source isn't locally present, the VCS repositories declared in this kit's `composer.json` resolve from GitHub tagged releases.

## License

MIT.
