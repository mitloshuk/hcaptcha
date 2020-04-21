hCaptcha PHP library 
===========================
Library for hCaptcha, a service that protects websites from spam, protects user privacy, rewards websites, and helps companies get their data labeled

Uses `curl` for requests and `PHP 5.6+`, compatible with any frameworks like Laravel, Yii2, Symfony and etc.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/)

Either run

```
composer require mitloshuk/hcaptcha
```

or add

```
"mitloshuk/hcaptcha": "^1.0"
```

to the require section of your `composer.json` file.

How to use
------------

### API Site key and Secret

Go to https://dashboard.hcaptcha.com, sign in and make new site if you do not have it yet

### HTML

Include hCaptcha `api.js` at end of body
```
<script src="https://hcaptcha.com/1/api.js" async defer></script>
```

####For visible captcha add to form

```
<div class="h-captcha" data-sitekey="your-site-key"></div>
```

####For **invisible** captcha change your submit button of form to

```
<button class="h-captcha"
        data-sitekey="your-site-key"
        data-callback="onSubmit"
        data-size="invisible">
    Check it!
</button>
```

And at after `api.js` script

```
<script type="text/javascript">
    function onSubmit(token)
    {
        document.getElementById('hcaptcha-form').submit();
    }
</script>
```

More info on [hCaptcha docs page](https://docs.hcaptcha.com)

#### PHP

Initialize hCaptcha

```
$hCaptcha = new hCaptcha('your-secret-key');
```

If you do not want to use curl for requests, you should create your own class that implements `RequestInterface` and use it like that

```
$hCaptcha = new hCaptcha(
    'your-secret-key',
    null,
    (new YourOwnRequest())
);
```

Verify data with hCaptcha, it will return `Response` class

```
$hCaptchaResponse = $hCaptcha->verify($_POST['h-captcha-response'])
```

Simple check it with

```
if ($hCaptchaResponse->isSuccess()) {
    echo 'Congratulations! You are human';
}
```

If you need to know errors just get it via

```
$hCaptchaResponse->getErrors()
```

that returns array of errors, when `isSuccess` is `false` and `null` when it is `true`

From `$hCaptchaResponse` you also can get challenge date via

```
$hCaptchaResponse->getDate()
```

Hostname via

```
$hCaptchaResponse->getHostname()
```

Credit value `true/false` via

```
$hCaptchaResponse->isCredit()
```

Working examples you can take from `example` folder

Playground
------------

If you want to play with hCaptcha just _clone repository_ to your local machine, go to package folder and run 

```
php -S localhost:8000
```

then go to `http://localhost:8000/examples/visible.php` for visible hCaptcha or to `http://localhost:8000/examples/invisible.php` for invisible

_Remember that example code contains test `SITE_KEY` (10000000-ffff-ffff-ffff-000000000001) and `SECRET KEY` (0x0000000000000000000000000000000000000000) values from official hCaptcha documentation. More info on [hCaptcha docs page](https://docs.hcaptcha.com)_