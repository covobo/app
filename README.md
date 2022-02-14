# Home task
## Build and run

```bash
docker-compose build --no-cache
docker-compose up -d
```

Use this command to run an app in develop environment

```bash
docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml up -d
```

## See result

Open http://<host>:<port>/api/doc to see api doc

