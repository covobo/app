# Home task
## envs
Place your token GOTIFY_TOKEN
you can do it after first application up

## Build and run

```bash
docker-compose build --no-cache
docker-compose up -d
```

Use this command to run an app in develop environment (composer install required on a local machine for developing)

```bash
docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml up -d
```

Run tests

```bash
docker-compose exec app ./vendor/bin/phpunit
```

You have to rerun an app if you change envs

## See result

Open http://<host>:<port>/api/doc to see api doc

## Happy path

for SMS notification:

```bash
curl --location --request POST 'http://<host>:<port>/verifications' \
--header 'Content-Type: application/json' \
--data-raw '{
  "subject": {
    "identity": "+7100500",
    "type": "mobile-verfication"
  }
}'
```

for EMAIL notification:

```bash
curl --location --request POST 'http://<host>:<port>/verifications' \
--header 'Content-Type: application/json' \
--data-raw '{
  "subject": {
    "identity": "email@email.com",
    "type": "email-verfication"
  }
}'
```

grab confirmation id from request and confirmation code from sms/email

confirm

```bash
curl --location --request PUT 'http://<host>:<port>/verifications/<confirmation-uuid>/confirm' \
--header 'Content-Type: application/json' \
--data-raw '{
  "code": "<confirmation-code>"
}'
```
