# Laravel JS-translator

## Install

Via Composer

``` bash
$ composer require webkid/js-translator
```

Add service provider: `Webkid\JsTranslator\JsTranslatorServiceProvider::class,`

## Usage. Angular JS example:

Publish lang.js library file. to `your-public-folder/jstranslator/lang.js`
``` bash
$ php artisan vendor:publish
```
Add deferred bootstrap library to load translations before everything was loaded.

``` bash
bower install angular-deferred-bootstrap --save
```

Add assets to your html or blade page

```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.5/angular.js"></script>
<script src="/vendor/angular-deferred-bootstrap/angular-deferred-bootstrap.min.js"></script>
<script src="/jstranslator/lang.js"></script>
```

Run deferred bootstrap:
```js
deferredBootstrapper.bootstrap({
	element: document.documentElement,
	module: 'app',
	resolve: {
		TRANS: ['$http', function ($http) {
			return $http.get('/trans');
		}]
	}
});
```

Set up route for `/trans` url:
```php
Route::get('/trans', function () {
	$a = app()->make('jstranslator');
	return response()->json($a->get());
});
```

Finnaly add your angular script file. Example:

```js
(function() {

	'use strict';

	angular
		.module('app', [])
		.controller('langController', langController)
		.filter('trans', trans)
		.filter('trans_plural', trans_plural)
		.filter('trans_as_array', trans_as_array)
		.run(runBlock)
	;


	runBlock.$inject = ['TRANS'];
	function runBlock(TRANS)
	{
		Lang.setMessages(TRANS); //set messages object
	}

	function langController() {
		console.log(Lang.get('pagination.next'));
	}

	/**
	 * Get translation from resources, empty.
	 * Example:
	 * 'pagination.next' | trans => 'Next'
	 */
	function trans() {
		return function (input, replaces) {
			// Set symbol
			return Lang.get(input, replaces);
		};
	}

	/**
	 * Get translation from resources.
	 * Example:
	 * 'subscription.month' | trans_plural:1 => 'month'
	 * 'subscription.month' | trans_plural:2 => 'months'
	 */
	function trans_plural() {
		return function (input, number) {
			return Lang.choice(input, number);
		};
	}

	/**
	 * Convert translation object to array from resources.
	 * Example:
	 * 'property.property_types' | trans_as_array
	 */
	function trans_as_array() {
		return function (input) {
			if(typeof Lang.get(input) !== 'object') {
				console.error('Error, ' + input + 'not a object.');
				return [];
			}
			var newOptions = [];
			angular.forEach(Lang.get(input), function(val, key){
				newOptions.push({key: key, value: val});
			});

			return newOptions;
		};
	}

})();
```

Example of usage in html:

```html
<div class="title" ng-controller="langController">Laravel 5 @{{ 'pagination.next' | trans }}</div>
```




## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email kolodiy@ukietech.com instead of using the issue tracker.

## Credits

- [kolodiy@ukietech.com][http://john.if.ua/]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
