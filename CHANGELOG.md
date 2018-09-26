# Change Log
All notable changes to this project will be documented in this file.
This project adheres to Semantic Versioning (http://semver.org/).

## 3.6.1
* Fix the import path for graphql request

## 3.6.0
* Add support for GraphQL API calls

## 3.5.0
* Add support for marketing permission api operation

## 3.4.2
* Make MarkupableString mutable

## 3.4.1
* Fix Serializable Objects

## 3.4.0
* Implements Markupable Category, Pagetype and SearchTerm Objects 

## 3.3.2
* Generate API_EMAIL token during signup

## 3.3.1
* Rename opt-in attribute
* Fix html serialization bug for attributes having boolean false as a value
* Add tests for serializing Buyer object

## 3.3.0
* Add opt-in attribute to customer
* Introduce ModelFilter class for filtering purposes

## 3.2.2
* Improve the error handling in Oauth and in account uninstall

## 3.2.2
* Improve the error handling in Oauth and in account uninstall

## 3.2.1
* Fix the issue that custom field keys were converted to snake case
* Add helper method for serializing collection to json
* Add more tests for serialization

## 3.2.0
* Introduce operation class for deleting / discontinuing products
* Refactor operation classes to use common authenticated abstract class
* Fix array handling bug in serializer
* Add few tests for serialization

## 3.1.9
* Make the validator use getters instead of accessing attributes directly

## 3.1.8
* Define productId as mandatory for product object

## 3.1.7
* Add CartOperation to support sending cart update events to nosto

## 3.1.6
* Remove static abstract function because it is not allowed in php strict mode

## 3.1.5
* Add sku id to cart LineItem

## 3.1.4
* Rename Cart::restoreCartUrl to Cart::restoreLink for supporting html serializer

## 3.1.3
* Change product tag1, tag2 and tag3 tagging to tags1, tags2 and tags3

## 3.1.2
* Fix doc block for Order::setCreated()

## 3.1.1
* Remove DateTimeInterface type hint from Order class
* Add PHP version compatibility checks
* Update Dockerfile to use PHP 7.0.25

## 3.1.0
* Support tagging html markup generation
* Add "Custom Fields" property to product class
* Add notranslate tag to avoid tagging being translated by browser plugin
* Support setting response timeout on each request

## 3.0.12
* Add phone, post code and country fields to person object

## 3.0.11
* Fix the iframe regular expression
* Move symfony console dependency under require-dev 

## 3.0.10
* Add support for variation
* Add support for getting X-Request-ID from http response and http exception
* Revert phpseclib dependency to 2.0.*

## 3.0.9
* Fix the phpseclib dependency version

## 3.0.8
* Rename custom_attributes to custom_fields for SKU

## 3.0.7
* Add support for using product thumb url 

## 3.0.6
* Fix product adding sku issue

## 3.0.5
* Fix providing default nosto backend url

## 3.0.4
* Fix handling the 100 (Continue) HTTP header

## 3.0.3
* Make the abstract collections countable

## 3.0.2
* Correct the de-duplication of the alternate image URLs

## 3.0.1
* Add collection for SKUs
* Add set availability method to SKU model
* Make the serializer to handle collections (implementations of Iterable interface)

## 3.0.0
* Add namespaces and comply to PSR-4
* Add support for SKUs (variations)
* Introduce traits
* Introduce several new interfaces and implementations of those interfaces
* Unify Nosto API communications into operation classes
* Refactor and rearrange various parts of the codebase

## 1.16.3
* Remove price formatting from product serializer
* Add optional precision attribute to price formatter

## 1.16.2
* Remove usage is superglobals ($_ENV, $_SERVER, etc.)

## 1.16.1
* Add get modules to iframe interface

## 1.16.0
* Introduce new product fields / product attributes

## 1.15.9
* Add logic for getting missing tokens

## 1.15.8
* Add notification classes

## 1.15.7
* Remove getDatePublished from product interface
* Decrease the API call timeout
* Add type check for price formatter

## 1.15.6
* Add checks for missing tokens

## 1.15.5
* Code style fixes

## 1.15.4
* Add support for account details

## 1.15.3
* Improve the exception handling

## 1.15.2
* Add constants to product interface

## 1.15.1
* Add support for using external order ref

## 1.15.0
* Add support for account details

## 1.14.0
* Support for exchange rates
* Code style fixes
