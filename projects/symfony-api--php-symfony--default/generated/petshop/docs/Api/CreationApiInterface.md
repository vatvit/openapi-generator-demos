# PetShopApi\Api\CreationApiInterface

All URIs are relative to *https://petstore.swagger.io/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addPet**](CreationApiInterface.md#addPet) | **POST** /pets | 


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\CreationApi:
        tags:
            - { name: "open_api_server.api", api: "creation" }
    # ...
```

## **addPet**
> PetShopApi\Model\Pet addPet($newPet)



Creates a new pet in the store. Duplicates are allowed

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/CreationApiInterface.php

namespace Acme\MyBundle\Api;

use PetShopApi\Api\CreationApiInterface;

class CreationApi implements CreationApiInterface
{

    // ...

    /**
     * Implementation of CreationApiInterface#addPet
     */
    public function addPet(NewPet $newPet, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **newPet** | [**PetShopApi\Model\NewPet**](../Model/NewPet.md)| Pet to add to the store |

### Return type

[**PetShopApi\Model\Pet**](../Model/Pet.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

