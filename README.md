# Same Site POC
This is a simple project to work with `samesite` cookies. To make it up:
```
docker build -t samesite . --rm
docker run --name samesite -p 80:80 -v $PWD/another-site-mainsite.lab/:/var/www/app/another -v $PWD/same-site-mainsite.lab/:/var/www/app/main -v $PWD/xyz.subdomain.same-site-mainsite.lab/:/var/www/app/sub --rm samesite
```
The session's attribute can be changed by modifying `index.php`:
```php
session_set_cookie_params([
    'samesite' => 'Lax'
]);
```