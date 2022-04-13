FORMAT: 1A
HOST: http://localhost:3000

# nosto/php-sdk

# Group Account
Account related resources

## Create Account [/accounts/create/{lang}]

+ Parameters

    + lang (string) ... the 2-letter language ISO ((ISO 639-1)) code for the account language

### New account [POST]

+ Request (application/json)

        {
            "api_tokens": [
                "API_SSO",
                "API_PRODUCTS",
                "API_RATES",
                "API_SETTINGS",
                "API_EMAIL",
                "API_APPS"
            ],
            "currencies": {
                "EUR": {
                    "currency_before_amount": true,
                    "currency_token": "\u20ac",
                    "decimal_character": ".",
                    "decimal_places": 2
                }
            },
            "currency_code": "USD",
            "default_variant_id": "XXX",
            "front_page_url": "http:\/\/localhost",
            "language_code": "en",
            "name": "00000000",
            "owner": {
                "email": "james.kirk@example.com",
                "first_name": "James",
                "last_name": "Kirk",
                "marketing_permission": false
            },
            "owner_language_code": "en",
            "platform": "magento",
            "signup_api_token": {
                "name": "create",
                "value": "YBDKYwSqTCzSsU8Bwbg4im2pkHMcgTy9cCX7vevjJwON1UISJIwXOLMM0a8nZY7h"
            },
            "title": "My Shop",
            "use_exchange_rates": false
        }

+ Response 200 (application/json)

        {
            "sso_token": "01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783",
            "products_token": "01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783"
        }

## OAuth Access Token [/oauth/token{?code,client_id,client_secret,redirect_uri,grant_type}]

+ Parameters

    + code (string) ... the authorization code that was received in the redirect url from the oauth server
    + client_id (string) ... the oauth client id
    + client_secret (string) ... the oauth client secret
    + grant_type (string) ... must be "authorization_code"

### Get the OAuth access token [GET]

+ Response 200 (application/json)

        {
            "access_token": "01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783",
            "merchant_name": "platform-00000000"
        }

## Sync Account [/oauth/exchange{?access_token}]

+ Parameters

    + access_token (string) ... the access token received in the oauth token request (above)

### Sync existing account details [GET]

+ Response 200 (application/json)

        {
            "api_sso": "01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783",
            "api_products": "01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783"
        }

## Single Sign On  [/users/sso/{email}]

+ Parameters

    + email (string) ... the email address of the user who is doing the SSO

### SSO login [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            {
                "first_name": "James",
                "last_name": "Kirk"
            }

+ Response 200 (application/json)

        {
            "login_url": "http://platform-00000000.dev.nos.to:9010/hub/magento/platform-00000000/sso%2Bplatform-00000000@nostosolutions.com/"
        }

## Deleting Account [/hub/uninstall]

### Notify nosto about deleted account [POST]

+ Request (application/json)

    + Headers

            Content-type: application/json
            Authorization: Basic OjEyMw==

+ Response 200

# Group OrderConfirm
OrderConfirm related resources

## Matched OrderConfirm Confirmation [/visits/order/confirm/{m}/{cid}]

+ Parameters

    + m (string) ... the account name for which this order was placed
    + cid (string) ... the nosto customer id that placed the order

### New account [POST]

+ Request (application/json)

        {
            "order_number": 1,
            "order_status_code": "complete",
            "order_status_label": "Complete",
            "buyer": {
                "first_name": "James",
                "last_name": "Kirk",
                "email": "james.kirk@example.com"
            },
            "created_at": "2014-12-12",
            "payment_provider": "test-gateway [1.0.0]",
            "purchased_items": [
                {
                    "product_id": 1,
                    "quantity": 2,
                    "name": "Test Product",
                    "unit_price": "99.99",
                    "price_currency_code": "USD"
                }
            ]
        }

+ Response 200 (application/json)

        {}

## Un-matched OrderConfirm Confirmation [/visits/order/unmatched/{m}]

+ Parameters

    + m (string) ... the account name for which this order was placed

### New account [POST]

+ Request (application/json)

        {
            "order_number": 1,
            "order_status_code": "complete",
            "order_status_label": "Complete",
            "buyer": {
                "first_name": "James",
                "last_name": "Kirk",
                "email": "james.kirk@example.com"
            },
            "created_at": "2014-12-12",
            "payment_provider": "test-gateway [1.0.0]",
            "purchased_items": [
                {
                    "product_id": 1,
                    "quantity": 2,
                    "name": "Test Product",
                    "unit_price": "99.99",
                    "price_currency_code": "USD"
                }
            ]
        }

+ Response 200 (application/json)

        {}

# Group Customer
Customer related resources

## Marketing permission [/v1/customers/consent/{email}/{state}]

### Update customer marketing permission [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

+ Response 200 (application/json)

        {}

# Group Product
Product related resources

## Product Re-crawl [/products/recrawl]

### Send product re-crawl request [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            {
                "products": [
                    {
                        "product_id": 1,
                        "url": "http://my.shop.com/products/test_product.html"
                    }
                ]
            }

+ Response 200 (application/json)

        {}

## Product upsert [/v1/products/upsert]

### Send product create request [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            [
                {
                    "alternate_image_urls": ["http:\/\/shop.com\/product_alt.jpg"],
                    "availability": "InStock",
                    "brand":"Super Brand",
                    "categories": [
                        "\/Mens",
                        "\/Mens\/Shoes"
                    ],
                    "condition": "Used",
                    "date_published": "2013-03-05",
                    "description": "This is a full description",
                    "google_category": "All",
                    "gtin":"gtin",
                    "image_url":"http:\/\/my.shop.com\/images\/test_product.jpg",
                    "inventory_level":50,
                    "list_price":110.99,
                    "name":"Test Product",
                    "price":99.99,
                    "price_currency_code":"USD",
                    "product_id":1,
                    "rating_value":2.5,
                    "review_count":99,
                    "skus":[],
                    "supplier_cost":22.33,
                    "tag1":["first"],
                    "tag2":["second"],
                    "tag3":["third"],
                    "url":"http:\/\/my.shop.com\/products\/test_product.html",
                    "variation_id":"USD",
                    "variations":[]
                }
            ]

+ Response 200 (application/json)

        {}

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

        [
            {
                "alternate_image_urls": ["http:\/\/shop.com\/product_alt.jpg"],
                "availability":"InStock",
                "brand":"Super Brand",
                "categories":[
                    "\/Mens",
                    "\/Mens\/Shoes"
                ],
                "condition":"Used",
                "date_published":"2013-03-05",
                "description":"This is a full description",
                "google_category":"All",
                "gtin":"gtin",
                "image_url":"http:\/\/my.shop.com\/images\/test_product.jpg",
                "inventory_level":50,
                "list_price":110.99,
                "name":"Test Product",
                "price":99.99,
                "price_currency_code":"USD",
                "product_id":1,
                "rating_value":2.5,
                "review_count":99,
                "skus":[
                    {
                        "availability":"InStock",
                        "gtin":"gtin",
                        "id":100,
                        "image_url":"http:\/\/my.shop.com\/images\/test_product.jpg",
                        "inventory_level":20,
                        "list_price":110.99,
                        "name":"xxxx",
                        "price":99.99,
                        "url":"http:\/\/my.shop.com\/products\/test_product.html"
                    },
                    {
                        "availability":"InStock",
                        "gtin":"gtin",
                        "id":3,
                        "image_url":"http:\/\/my.shop.com\/images\/test_product.jpg",
                        "inventory_level":20,
                        "list_price":110.99,
                        "name":"Test Product",
                        "price":99.99,
                        "url":"http:\/\/my.shop.com\/products\/test_product.html"
                    }
                ],
                "supplier_cost":22.33,
                "tag1":["first"],
                "tag2":["second"],
                "tag3":["third"],
                "url":"http:\/\/my.shop.com\/products\/test_product.html",
                "variation_id":"USD",
                "variations":[]
            }
        ]

+ Response 200 (application/json)

        {}
        
+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

        [
            {
                "alternate_image_urls": ["http:\/\/shop.com\/product_alt.jpg"],
                "availability":"InStock",
                "brand":"Super Brand",
                "categories": ["\/Mens","\/Mens\/Shoes"],
                "condition":"Used",
                "date_published":"2013-03-05",
                "description":"This is a full description",
                "google_category":"All",
                "gtin":"gtin",
                "image_url":"http:\/\/my.shop.com\/images\/test_product.jpg",
                "inventory_level":50,
                "list_price":110.99,
                "name":"Test Product",
                "price":99.99,
                "price_currency_code":"USD",
                "product_id":1,
                "rating_value":2.5,
                "review_count":99,
                "skus":[],
                "supplier_cost":22.33,
                "tag1":["first"],
                "tag2":["second"],
                "tag3":["third"],
                "url":"http:\/\/my.shop.com\/products\/test_product.html",
                "variation_id":"USD",
                "variations":{
                    "newID":{
                        "availability":"InStock",
                        "list_price":110.99,
                        "price":99.99,
                        "price_currency_code":"USD",
                        "variation_id":"newID"
                    },
                    "1": {
                        "availability":"InStock",
                        "list_price":110.99,
                        "price":99.99,
                        "price_currency_code":"USD",
                        "variation_id":1
                    }
                }
            }
        ]


+ Response 200 (application/json)

        {}
                        
### Send product update request [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            [
                {
                    "url": "http://my.shop.com/products/test_product.html",
                    "product_id": 1,
                    "name": "Test Product",
                    "image_url": "http://my.shop.com/images/test_product.jpg",
                    "price": "99.99",
                    "list_price": "110.99",
                    "price_currency_code": "USD",
                    "availability": "InStock",
                    "tag1": ["tag1", "tag2"],
                    "categories": ["/a/b", "/a/b/c"],
                    "description": "Lorem ipsum dolor sit amet",
                    "brand": "Super Brand"
                }
            ]

+ Response 200 (application/json)

        {}

## Product create [/v1/products/create]

### Send product create request [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            [
                {
                    "url": "http://my.shop.com/products/test_product.html",
                    "product_id": 1,
                    "name": "Test Product",
                    "image_url": "http://my.shop.com/images/test_product.jpg",
                    "price": "99.99",
                    "list_price": "110.99",
                    "price_currency_code": "USD",
                    "availability": "InStock",
                    "tag1": ["tag1", "tag2"],
                    "categories": ["/a/b", "/a/b/c"],
                    "description": "Lorem ipsum dolor sit amet",
                    "brand": "Super Brand"
                }
            ]

+ Response 200 (application/json)

        {}

## Product update [/v1/products/update]

### Send product update request [PUT]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            [
                {
                    "url": "http://my.shop.com/products/test_product.html",
                    "product_id": 1,
                    "name": "Test Product",
                    "image_url": "http://my.shop.com/images/test_product.jpg",
                    "price": "99.99",
                    "list_price": "110.99",
                    "price_currency_code": "USD",
                    "availability": "InStock",
                    "tag1": ["tag1", "tag2"],
                    "categories": ["/a/b", "/a/b/c"],
                    "description": "Lorem ipsum dolor sit amet",
                    "brand": "Super Brand"
                }
            ]

+ Response 200 (application/json)

        {}

## Product delete [/v1/products/discontinue]

### Send product delete request [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            [
                1
            ]

+ Response 200 (application/json)

        {}

## Sync Rates [/exchangerates]

### Sync exchange rates request [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu
            
    + Body

        {
            "rates": {
                "Dollars": {
                    "price_currency_code": "USD",
                    "rate": 1.29
                },
                "Euros": {
                    "price_currency_code": "EUR",
                    "rate": 0.1
                },
                "Pounds": {
                    "price_currency_code": "GBP",
                    "rate": 1.3
                }
            }
        }

+ Response 200 (application/json)

        {}

## Sync UpdateSettings [/settings]

### Update account settings request [PUT]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

            {
                "currencies": {
                    "EUR": {
                        "currency_before_amount":true,
                        "currency_token":"\u20ac",
                        "decimal_character":".",
                        "decimal_places":2
                    }
                },
                "currency_code":"USD",
                "default_variant_id":"XXX",
                "front_page_url":"http:\/\/localhost",
                "language_code":"en",
                "title":"My Shop",
                "use_exchange_rates":false
            }

+ Response 200 (application/json)

        {}


## Single Sign On [/hub/{platform}/load]

+ Parameters

    + platform (string) ... the platform name
    + email (string) ... the email address of the user who is doing the SSO

### SSO login [POST]

+ Request (application/json)

    + Headers

            Authorization: Basic OnRva2Vu

    + Body

        {
            "email":"james.kirk@example.com",
            "first_name":"James",
            "last_name":"Kirk",
            "marketing_permission":false
        }

+ Response 200 (application/json)

        {
            "login_url": "http://platform-00000000.dev.nos.to:9010/hub/magento/platform-00000000/sso%2Bplatform-00000000@nostosolutions.com/"
        }
