# PetShopApi\Api\WorkflowApiInterface

All URIs are relative to *https://petstore.swagger.io/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addPet**](WorkflowApiInterface.md#addPet) | **POST** /pets | 


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\WorkflowApi:
        tags:
            - { name: "open_api_server.api", api: "workflow" }
    # ...
```

## **addPet**
> PetShopApi\Model\Pet addPet($newPet)



Creates a new pet in the store. Duplicates are allowed

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/WorkflowApiInterface.php

namespace Acme\MyBundle\Api;

use PetShopApi\Api\WorkflowApiInterface;

class WorkflowApi implements WorkflowApiInterface
{

    // ...

    /**
     * Implementation of WorkflowApiInterface#addPet
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

