# PetShopApi\Api\ManagementApiInterface

All URIs are relative to *https://petstore.swagger.io/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addPet**](ManagementApiInterface.md#addPet) | **POST** /pets | 
[**deletePet**](ManagementApiInterface.md#deletePet) | **DELETE** /pets/{id} | 


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\ManagementApi:
        tags:
            - { name: "open_api_server.api", api: "management" }
    # ...
```

## **addPet**
> PetShopApi\Model\Pet addPet($newPet)



Creates a new pet in the store. Duplicates are allowed

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ManagementApiInterface.php

namespace Acme\MyBundle\Api;

use PetShopApi\Api\ManagementApiInterface;

class ManagementApi implements ManagementApiInterface
{

    // ...

    /**
     * Implementation of ManagementApiInterface#addPet
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

## **deletePet**
> deletePet($id)



deletes a single pet based on the ID supplied

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ManagementApiInterface.php

namespace Acme\MyBundle\Api;

use PetShopApi\Api\ManagementApiInterface;

class ManagementApi implements ManagementApiInterface
{

    // ...

    /**
     * Implementation of ManagementApiInterface#deletePet
     */
    public function deletePet(int $id, int &$responseCode, array &$responseHeaders): void
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**| ID of pet to delete |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

