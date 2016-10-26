# MercadoLibre API Client

[![Build Status](https://scrutinizer-ci.com/g/zephia/mercadolibre/badges/build.png?b=master)](https://scrutinizer-ci.com/g/zephia/mercadolibre/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zephia/mercadolibre/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zephia/mercadolibre/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/zephia/mercadolibre/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zephia/mercadolibre/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/zephia/mercadolibre/v/stable)](https://packagist.org/packages/zephia/mercadolibre)
[![Total Downloads](https://poser.pugx.org/zephia/mercadolibre/downloads)](https://packagist.org/packages/zephia/mercadolibre)
[![License](https://poser.pugx.org/zephia/mercadolibre/license)](https://packagist.org/packages/zephia/mercadolibre)

## Documentation

Official documentation and how to use the MercadoLibre API can be found at
[http://developers.mercadolibre.com/api-docs/](http://developers.mercadolibre.com/api-docs/)

## Installation

Using [composer](http://getcomposer.org)

```bash
composer require zephia/mercadolibre
```

## Usage

```php
<?php

// Instantiate serializer with configurations.
$serializer = \JMS\Serializer\SerializerBuilder::create()
   ->addMetadataDir(__DIR__ . '/../../resources/config/serializer')
   ->build();
   
// Instantiate client.
$client = new Zephia\MercadoLibre\Client\MercadoLibreClient(
    [],
    $serializer
);

// Call show user.
$ml_response = $client->showUser(1);

var_dump($ml_response);

// object(Zephia\MercadoLibre\Entity\User)

```

## MercadoLibre API resources:

Overstriked resources are not available yet in this package.

### Users & Apps

* ~~`/users/{Cust_id}?access_token=$ACCESS_TOKEN` User account information. GET PUT~~

    Get user information.

    Update user information

* ~~`/users/me` Returns account information about the authenticated user. GET~~

    Get information about the authenticated in user.

* ~~`/users/{Cust_id}/addresses?access_token=$ACCESS_TOKEN` Returns addresses registered by the user. GET~~

    Get user addresses.

* ~~`/users/{Cust_id}/accepted_payment_methods` Returns payment methods accepted by a seller to collect its operations. GET~~

    Get accepted payment methods by user.

* ~~`/applications/{application_id}?ACCESS_TOKEN` Returns information about the application. GET~~

    Get application details.

* ~~`/users/{User_id}/brands` This resource retrieves brands associated to an user_id. The official_store_id attribute identifies a store. GET~~

    Get brands by user.

* ~~`/users/{User_id}/classifieds_promotion_packs?access_token=$ACCESS_TOKEN` Manage user promotion packs. GET POST~~

    Get promotions packs engaged by user.

    Creates a new Promotion Pack for the user.

* ~~`/users/{user_id}/classifieds_promotion_packs/{listing_type}&categoryId={category_id}?acces_token=$ACCESS_TOKEN` Availability for the user to list under a given Listing Type and category according to packages engaged. GET~~

    Get the availability Listing Type availability by user and category.

* ~~`/projects?access_token=$ACCESS_TOKEN` Manage projects. GET POST PUT DELETE~~

    Get all applications associated to a project

    Create a new project.

    Update a project.

    Remove a project.

* ~~`/projects/{Project_id}/applications?access_token=ACCESS_TOKEN_APP_OWNER` Manage applications & projects. POST DELETE~~

    Save an application under your project.

    Remove an application from your project.

* ~~`/users/{Cust_id}/available_listing_types?category_id={Category_id}&access_token=$ACCESS_TOKEN` Listing types availability by user and category. GET~~

    Get available listing types.

* ~~`/users/{Cust_id}/available_listing_type/{listing_type_id}?category_id={Category_id}&access_token=$ACCESS_TOKEN` Retrieves availability to list under a listing type for a given category. GET~~

    Get category availability.

* ~~`/users/{User_id}/applications/{App_id}?access_token=$ACCESS_TOKEN` Application permissions. DELETE~~

    Revoke permissions to an application.

* ~~`/myfeeds?app_id={App_id}` Notifications history. GET~~

    Get historic of notifications by App.

### Categories & Listings

* ~~`/sites` Retrieves information about the sites where MercadoLibre runs. GET~~

    Get all sites.

* ~~`/site_domains/{Site_domain_url}` Returns information about the domain. GET~~

    Get domain information.

* ~~`/sites/{Site_id}/listing_types` Returns information about listing types. GET~~

    Get listing types by site.

* ~~`/sites/{Site_id}/listing_exposures` Returns different exposure levels associated with all listing types in MercadoLibre. GET~~

    Get listing exposures by site.

* ~~`/sites/{Site_id}/listing_prices?price={Price}` Returns the listing price for selling and buying in MercadoLibre. GET~~

    Get listing prices.

* `/sites/{Site_id}/categories` Returns available categories in the site. GET

    Get the category tree by site
    ```php
    $client->categoriesList();
    ```

* ~~`/categories/{Category_id}` Returns information about a category. GET~~

    Get category details.

* ~~`/categories/{Category_id}/attributes` Displays attributes and rules over them in order to describe the items that are stored in each category. GET~~

    Get category attributes.

* ~~`/sites/{Site_id}/category_predictor/predict` Category predictor. Retrieves the most accurate category to list your item basing on it’s title. GET~~

    Predict category.

* ~~`/categories/{Category_id}/classifieds_promotion_packs` Retrieves classified promotion packs by category. GET~~

    Get classified promotion packs by category

### Locations & Currencies

* ~~`/countries` Returns countries information. GET~~

    Get information about countries.

* ~~`/countries/{Country_id}` Returns country information by country_id. GET~~

    Get country detail

* ~~`/states/{State_id}` Returns state information. GET~~

    Get state information.

* ~~`/cities/{City_id}` Returns city information. GET~~

    Get city information.

* ~~`/currencies` Returns information about all available currencies in MercadoLibre. GET~~

    Get currencies information.

* ~~`/currencies/{Currency_id}` Returns information about available currencies in MercadoLibre by currency_id. GET~~

    Get currency details.

* ~~`/currency_conversions/search?from={Currency_id}&to={Currency_id}` Retrieves the conversion ratio between currencies that MercadoLibre uses in calculations. GET~~

    Get ratio conversion between currencies.

* ~~`/countries/{Country_id}/zip_codes/{Zip_code}` Retrieves data for the location of the zip code entered. GET~~

    Get location information by zip code.

* ~~`/country/{Country_id}/zip_codes/search_between?zip_code_from={zip_code_from}&zip_code_to={zip_code_to}` Retrieve all zip codes for a country_id between two given zip codes. GET~~

    Get all zip codes between two given values of zip codes.

### Items & Searches

* ~~`/items` Allows listing items. POST~~

    List an item in MercadoLibre.

* ~~`/items/{Item_id}` Allows managing listings GET PUT~~

    Get item details.

    Update an item.

* ~~`/items/validate` Validate the JSON before posting an item. POST~~

    Validate your JSON.

* ~~`/items/{Item_id}/available_upgrades` Returns available listing types to upgrade an item posure. GET~~

    Get available upgrades.

* ~~`/items/{Item_id}/relist` Allows to relist an item. GET~~

    Relist your item.

* ~~`/items/{Item_id}/pictures/{picture_id}` Manage item pictures. GET DELETE~~

    Get pictures in all it sizes.

    Delete a picture.

* ~~`/items/{Item_id}/pictures` Add and update pictures on your item. GET PUT~~

    Post a picture.

    Update items pictures.

* ~~`/items/{Item_id}/description` Manage description for an item. GET PUT~~

    Get item description.

    Update item description.

* ~~`/sites/{Site_id}/search?q=ipod` Retrieves items from a search query. GET~~

    METHOD DESCRIPTION

* ~~`/sites/{Site_id}/searchUrl?q=ipod` Search for any item in MercadoLibre. It will return an array of items url that match the search criteria. GET~~

    Search items Url by query.

* ~~`/sites/MLA/search?category={Category_id}&official_store_id=all` Search for all items listed by Official Stores for a given category. GET~~

    Search Official Store items.

* ~~`/sites/{Site_id}/hot_items/search?limit=5&category={Category_id}` Retrieves an array of hot items from a specified category by parameter. Works only with the first level of categories. GET~~

    Search hot items.

* ~~`/sites/{Site_id}/featured_items/HP-{Category_Id}` Retrieves an array of featured items. The featured items are items that have a special posure at home page or categories page. You can use only HP for products of home or HP-{categId} for featured by category. Only works with first level of categories. GET~~

    Get items featured on the home by it’s category.

* ~~`/sites/{Site_id}/trends/search?category={Category_id}` Retrieve an array of the trends items from the category specified by parameter. GET~~

    Get trends by category

* ~~`/sites/{Site_id}/search?seller_id={Seller_id}&category={Category_id}&access_token=$ACCESS_TOKEN` Search items by seller_id for a category. GET~~

    Get items by seller id and cateogyr id.

* ~~`/users/{Cust_id}/items/search?access_token=$ACCESS_TOKEN` Retrieves user’s listings. GET~~

    Get user’s listings

* ~~`/items/{Item_id}/product_identifiers/` Retrieves the product identifier codes associated to your item. GET PUT~~

    Get item product identifiers.

    Update product identifiers

* ~~`/items/{Item_id}/variations` Manage item’s variations. GET POST~~

    Get item’s variations.

    Create a variation for your item.

* ~~`/items/{Item_id}/variations/{Variation_id}` Manage variations. GET PUT DELETE~~

    Get variation details.

    Update a variation.

    Delete a variation.

* ~~`/users/{Cust_id}/items/search?sku={seller_custom_field}&status=active&access_token=$ACCESS_TOKEN` Search item by SKU. Filter item by status. GET~~

    Search item by SKU.
    Filter item by status.
