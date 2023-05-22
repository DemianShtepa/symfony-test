## How to deploy project
1. `cp docker/.env.example docker/.env`
2. `docker-compose exec -u www-data php-fpm composer setup`

## End-points
- `GET` - `/user` - user index page.
- `GET` - `/project` - project index page.
- `GET` - `/project_milestone` - project milestone index page.
