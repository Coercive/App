# Coercive App

!!! IN WORKS !!!

## Get
```
composer require coercive/app
```

## Usage
```php

# in works ...

```

---

# ReCaptcha handler

Load class and set your keys
```php
$recaptcha = new ReCaptcha;

$recaptcha
   ->setPublicKey("RECAPTCHA_PUBLIC_KEY")
   ->setPrivateKey("RECAPTCHA_SECRET_KEY")
```

Check if your token is valid
```php
if (!$recaptcha->validateAndPersist($_POST['inputTokenToCheck'])) {
    die('invalid');
}
```

Optional: by default is V2 ; set threshold if you wan't to use reCaptcha V3
```php
$recaptcha->threshold(0.5)
```

Optional: use storage data to optimize your quota
```php
$recaptcha->setStoreCallback(function($result) {
	/* your storage logic here */
})

$recaptcha->setRetrieveCallback(function() {
	/* your retrieve logic here */
})

/* use `validateAndPersist()` to trigger your callbacks */
$recaptcha->validateAndPersist($_POST['inputTokenToCheck'])
```

Full example with session storage logic
```php
$recaptcha
   ->setPublicKey("RECAPTCHA_PUBLIC_KEY")
   ->setPrivateKey("RECAPTCHA_SECRET_KEY")
   ->threshold(0.5)
   ->setStoreCallback(function($result) {
         $_SESSION['recaptcha']['result'] = $result;
         $_SESSION['recaptcha']['timestamp'] = time();
   })
   ->setRetrieveCallback(function () {
         if(!isset($_SESSION['recaptcha'])) {
            return null;
         }
         if(($_SESSION['recaptcha']['timestamp'] ?? 0) + (24 * 60 * 60) < time()) {
            return null; # example 1 day in second before recheck
         }
         return $_SESSION['recaptcha']['result'] ?? false;
   });
```