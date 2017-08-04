# laravel-captcha
Captcha package for laravel, that can be embeded in any website as `widget`.


# How to use
- Install : `composer install anandpilania/laravel-captcha`
- Register `ServiceProvider` OR `Facade` :
	- `AP\Captcha\ServiceProvider::class`
	- `"Captcha" => AP\Captcha\Facade::class`

IF USING DIRECTLY IN LARAVEL PROJECT
- Add `captcha` attribute to the `view` : `Captcha::build()`
	- `build` method accepts two parameters 
		1- `int - length` of the `captcha value`,
		2- `boolean - html` : if passed `true`, returns the default html contianer else return the `code` (default: false)
- Add `validation field` to your specific `controller` : `"captcha_code" => "captcha"`

IF USING AS WIDGET
- Call the `route` : GET: //HOSTNAME/captcha/widget (optionally can pall the `int : length` parameter as //HOSTNAME/captcha/widget/6)
- Refresh the code via calling : GET: //HOSTNAME/captcha/refresh
- Verify it via calling : GET: //HOSTNAME/captcha/verify