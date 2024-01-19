# Guest book

* Create comments
* Show comments (pagination)

## Start project

```bash
./start.sh
```

http://localhost

## Stop project

```bash
./stop.sh
```

## Bash in PHP container

```bash
./cli.sh
```

## Run tests and other QA checks

From within the PHP container console:
```bash
./qa.sh
```

## Configure DB

Also from within the PHP container console:
```bash
composer migrations -- migrations:migrate
```

# Database

Inside the container, in php code: `mysql:3306 root:root`

With client on host: `localhost:3306 root:root`

You can find an example of connecting to database in `index.php` so you don't waste time doing this.