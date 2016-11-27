erdiko-shopify
==============

[![Package version](https://img.shields.io/packagist/v/erdiko/shopify.svg?style=flat-square)](https://packagist.org/packages/erdiko/shopify)

Shopify API Adapter

* Connect to the Shopify API
* Guzzle support
* Convenient composer install
* PSR compliant
* Use with Erdiko or your favorite framework

If you are using composer and php 5.3 or greater, then this is a great package to use.  It is compatible with frameworks such as Laravel, Symfony, SlimPHP, and of course Erdiko.

If you are using php 4 or are not using composer then check out [ohShopify](https://github.com/cmcdonaldca/ohShopify.php)


Installation
------------

**via composer**

	composer require erdiko/shopify 0.1.*


Usage
-----

To connect to shopify you can use the \erdiko\shopify\Shopify class to connect to the Shopify API.  This library can be used within any PHP app that supports composer.

If you are using erdiko you can leverage our service models and sample app to jumpstart your development.


Authorizing your App with your Shopify Store
-----

This module relies on OAuth to access and interact with your shopify stores. Authorization
with this module is only required for setup, but it is required for each store.

The workflow of authorizing your application with OAuth is "asking for permission" by constructing a link
to allow Shopify to install this application. You will need to expose your application to a URL from which you can
redirect and access. Edit your routes config to expose the Shopify module controller to make sure we construct
and output the expected output for Shopify like so:

```
 {
     "routes": {
     	...
        "shop": "\erdiko\shopify\controllers\Shopify",
        ...
     }
 }
```

While we will defer you to the [official Shopify Docs](https://help.shopify.com/api/guides/authentication/oauth) 
for complete instructions, here are the brief instructions to authorize your 
application with your store:


* Register your application with the [Shopify Partners Dashboard](https://app.shopify.com/services/partners/api_clients)
* Retrieve your API Key, API Secret and the Refresh Token (also known as a "nonce") for your newly created application
* Construct your "Permissions Prompt" URL by editing the following URL


`https://{shop}.myshopify.com/admin/oauth/authorize?client_id={api_key}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}`

Tokens:

* {shop}
    * The subdomain for your shopify store
* {api_key}
  * This is your API key
* {scopes}
  * This is a comma separated list of permissions you allow for your application
  * We would like to suggest the following: `write_products,write_orders,write_customers`
* {nonce}
  * Your Refresh Token, also known as a "nonce"
* {redirect_url}
  * A publicily accessible route exposed by your erdiko application where the Shopify 
  model is initialized


Feedback
--------

Please send us feedback if you have any questions or suggestions.  If you find any bugs or find places where we are not PSR compliant please submit a github issue or email us.


Special Thanks
--------------

Arroyo Labs - For sponsoring development, [http://arroyolabs.com](http://arroyolabs.com)

[cmcdonaldca/ohShopify.php](https://github.com/cmcdonaldca/ohShopify.php) - Original Shopify PHP class 
