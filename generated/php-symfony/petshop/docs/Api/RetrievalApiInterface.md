# PetshopApi\Api\RetrievalApiInterface

All URIs are relative to *https://petstore.swagger.io/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findPetById**](RetrievalApiInterface.md#findPetById) | **GET** /pets/{id} | 


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\RetrievalApi:
        tags:
            - { name: "open_api_server.api", api: "retrieval" }
    # ...
```

## **findPetById**
> PetshopApi\Model\Pet findPetById($id)



Returns a user based on a single ID, if the user does not have access to the pet

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RetrievalApiInterface.php

namespace Acme\MyBundle\Api;

use PetshopApi\Api\RetrievalApiInterface;

class RetrievalApi implements RetrievalApiInterface
{

    // ...

    /**
     * Implementation of RetrievalApiInterface#findPetById
     */
    public function findPetById(int $id, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**| ID of pet to fetch |

### Return type

[**PetshopApi\Model\Pet**](../Model/Pet.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

