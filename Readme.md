SMHW
=====

## How to run

### console

```$bash
composer install
echo "API_ADDR='https://api.supermetrics.com'\nCLIENT_ID='client_id'\nUSER_NAME='user_name'\nUSER_EMAIL='my@email.addr'" > .env
php entrypoint.php
```

### docker

```$bash
make build
make run
```

----
by [Stanislav Gumeniuk]('http://gumeniuk.com')