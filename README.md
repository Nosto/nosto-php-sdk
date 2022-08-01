php-sdk
=======

Provides tools for building modules that integrate Nosto into your e-commerce platform.

## Requirements

* The Nosto PHP SDK requires at least PHP version 5.4.0 and it's also compatible with PHP >= 7.0.0

## Getting started

### Creating a new Nosto account

A Nosto account is needed for every shop and every language within each shop.

```php
    .....
    try {
        /** @var NostoSignupInterface $meta */
        /** @var NostoSignup $account */
        $account = NostoSignup::create($meta);
        // save newly created account according to the platforms requirements
        .....
    } catch (NostoException $e) {
        // handle failure
        .....
    }
    .....
```

### Connecting with an existing Nosto account

This should be done in the shops back end when the admin user wants to connect an existing Nosto account to the shop.

First redirect to the Nosto OAuth2 server.

```php
    .....
    /** @var OAuthInterface $meta */
    $client = new NostoOAuthClient($meta);
  	header('Location: ' . $client->getAuthorizationUrl());
```

Then have a public endpoint ready to handle the return request.

```php
    if (isset($_GET['code'])) {
        try {
            /** @var OAuthInterface $meta */
            $account = NostoSignup::syncFromNosto($meta, $_GET['code']);
            // save the synced account according to the platforms requirements
        } catch (NostoException $e) {
            // handle failures
        }
        // redirect to the admin page where the user can see the account controls
        .....
    }
    } elseif (isset($_GET['error'])) {
        // handle errors; 3 parameter will be sent, 'error', 'error_reason' and 'error_description'
        // redirect to the admin page where the user can see an error message
        .....
    } else {
        // 404
        .....
    }
```

### Deleting a Nosto account

This should be used when you delete a Nosto account for a shop. It will notify Nosto that this account is no longer used.

```php
    try {
        /** @var NostoSignup $account */
        $account->delete();
    } catch (NostoException $e) {
        // handle failure
    }
```

### Get authenticated Nosto URL for the account controls

The Nosto account can be created and managed through the controls that should be accessible to the admin user in the shop's
backend.
The account controls will redirect to nosto.com.

```php
    .....
    /**
     * @param ConnectionMetadataInterface $connection the connection meta data.
     * @param AccountInterface|null $account the configuration to return the url for.
     * @param UserInterface|null $user
     * @param array $params additional parameters to add to the connection url.
     */
    try
    {
        $url = Nosto::helper('connection')->getUrl($meta, $account, $user, $params);
    }
    catch (NostoException $e)
    {
        // handle failure
    }
    // render the link to the user with given url
    .....
```

### Sending order confirmations using the Nosto API

Sending order confirmations to Nosto is a vital part of the functionality. OrderConfirm confirmations should be sent when an
order has been completed in the shop. It is NOT recommended to do this when the "thank you" page is shown to the user,
as payment gateways work differently and you cannot rely on the user always being redirected back to the shop after a
payment has been made. Therefore, it is recommended to send the order conformation when the order is marked as payed
in the shop.

OrderConfirm confirmations can be sent two different ways:

* matched orders; where we know the Nosto customer ID of the user who placed the order
* un-matched orders: where we do not know the Nosto customer ID of the user who placed the order

The Nosto customer ID is set in a cookie "2c.cId" by Nosto and it is up to the platform to keep a link between users
and the Nosto customer ID. It is recommended to tie the Nosto customer ID to the order or shopping cart instead of an
user ID, as the platform may support guest checkouts.

```php
    .....
    try {
        /**
         * @var NostoOrderInterface $order
         * @var NostoSignupInterface $account
         * @var string $customerId
         */
        NostoOrderConfirmation::send($order, $account, $customerId);
    } catch (NostoException $e) {
        // handle error
    }
    .....
```

### Sending product re-crawl requests using the Nosto API

Note: this feature has been deprecated in favor of the create/update/delete method below.

When a product changes in the store, stock is reduced, price is updated etc. it is recommended to send an API request
to Nosto that initiates a product "re-crawl" event. This is done to update the recommendations including that product
so that the newest information can be shown to the users on the site.

Note: the $product model needs to include only `productId` and `url` properties, all others can be omitted.

```php
    .....
    try {
        /**
         * @var NostoProductInterface $product
         * @var NostoSignupInterface $account
         */
        NostoProductReCrawl::send($product, $account);
    } catch (NostoException $e) {
        // handle error
    }
    .....
```

Batch re-crawling is also possible by creating a collection of product models:

```php
    .....
    try {
        /**
         * @var NostoExportProductCollection $collection
         * @var NostoProductInterface $product
         * @var NostoSignupInterface $account
         */
        $collection[] = $product;
        NostoProductReCrawl::sendBatch($collection, $account);
    } catch (NostoException $e) {
        // handle error
    }
    .....
```

### Sending product create/update/delete requests using the Nosto API

When a product changes in the store, stock is reduced, price is updated etc. it is recommended to send an API request
to Nosto to handle the updated product info. This is also true when adding new products as well as deleting existing ones.
This is done to update the recommendations including that product so that the newest information can be shown to the users
on the site.

Creating new products:

```php
    .....
    try {
        /**
         * @var NostoProductInterface $product
         * @var NostoSignupInterface $account
         */
        $op = new UpsertProduct($account);
        $op->addProduct($product);
        $op->create();
    } catch (NostoException $e) {
        // handle error
    }
    .....
```

Note: you can call `addProduct` multiple times to add more products to the request. This way you can batch create products.

Updating existing products:

```php
    .....
    try {
        /**
         * @var NostoProductInterface $product
         * @var NostoSignupInterface $account
         */
        $op = new UpsertProduct($account);
        $op->addProduct($product);
        $op->update();
    } catch (NostoException $e) {
        // handle error
    }
    .....
```

Note: you can call `addProduct` multiple times to add more products to the request. This way you can batch update products.

Deleting existing products:

```php
    .....
    try {
        /**
         * @var NostoProductInterface $product
         * @var NostoSignupInterface $account
         */
        $op = new UpsertProduct($account);
        $op->addProduct($product);
        $op->delete();
    } catch (NostoException $e) {
        // handle error
    }
    .....
```

Note: you can call `addProduct` multiple times to add more products to the request. This way you can batch delete products.

### Exporting encrypted product/order information that Nosto can request

When new Nosto accounts are created for a shop, Nosto will try to fetch historical data about products and orders.
This information is used to bootstrap recommendations and decreases the time needed to get accurate recommendations
showing in the shop.

For this to work, Nosto requires 2 public endpoints that can be called once a new account has been created through
the API. These endpoints should serve the history data encrypted with AES. The SDK comes bundled with the ability to
encrypt the data with a pure PHP solution (http://phpseclib.sourceforge.net/), It is recommended, but not required, to
have mcrypt installed on the server.

Additionally, the endpoints need to support the ability to limit the amount of products/orders to export and an offset
for fetching batches of data. These must be implemented as GET parameters "limit" and "offset" which will be sent as
integer values and expected to be applied to the data set being exported.

```php
    .....
    /**
     * @var NostoProductInterface[] $products
     * @var NostoSignupInterface $account
     */
    $collection = new NostoExportProductCollection();
    foreach ($products as $product) {
        $collection[] = $product;
    }
    // The exported will encrypt the collection and output the result.
    $cipher_text = NostoExporter::export($account, $collection);
    echo $cipher_text;
    // It is important to stop the script execution after the export, in order to avoid any additional data being outputted.
    die();
```

```php
    .....
    /**
     * @var NostoOrderInterface[] $orders
     * @var NostoSignupInterface $account
     */
    $collection = new NostoExportOrderCollection();
    foreach ($orders as $order) {
        $collection[] = $order;
    }
    // The exported will encrypt the collection and output the result.
    $cipher_text = NostoExporter::export($account, $collection);
    echo $cipher_text;
    // It is important to stop the script execution after the export, in order to avoid any additional data being outputted.
    die();
```

## Testing

The SDK is unit tested with Codeception (http://codeception.com/).

### Running tests

First cd into the root directory.

Then install Codeception via composer:

```bash
    php composer.phar install
```

Then run the tests:

```bash
    vendor/bin/codecept run
```

### Testing new added operation

The SDK unit test uses the apiary as the stub server. The apiary pulls the api-blueprint.md from master branch and builds fake api endpoints based on it.
A way to test new added operation before merging it to master is using Drakov API Bleuprint Mock Server (https://github.com/Aconex/drakov) running on Node.

First cd into the root directory.

Then install Codeception via composer:

```bash
    php composer.phar install
```

After that you can install the drakov server via npm:

```bash
    npm install -g drakov
```

Update the endpoints in the tests/.env file: 

```bash
    NOSTO_API_BASE_URL=localhost:3000
    NOSTO_OAUTH_BASE_URL=localhost:3000/oauth
    NOSTO_WEB_HOOK_BASE_URL=http://localhost:3000
```

Then start the drakov mock server with the API blueprint:

```bash
    drakov -f tests/api-blueprint.md
```

Then in another window run the tests:

```bash
    vendor/bin/codecept run
```

You can pass debugMode flag to the drakov server for debugging purposes:

```bash
    drakov -f tests/api-blueprint.md --debugMode
```

### Running phpcs

First cd into the root directory.

Then the phpcs:

```bash
    phpcs --standard=ruleset.xml -v .
```
