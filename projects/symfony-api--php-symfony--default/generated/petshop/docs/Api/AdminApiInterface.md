# PetShopApi\Api\AdminApiInterface

All URIs are relative to *https://petstore.swagger.io/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deletePet**](AdminApiInterface.md#deletePet) | **DELETE** /pets/{id} | 


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\AdminApi:
        tags:
            - { name: "open_api_server.api", api: "admin" }
    # ...
```

## **deletePet**
> deletePet($id)



deletes a single pet based on the ID supplied

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/AdminApiInterface.php

namespace Acme\MyBundle\Api;

use PetShopApi\Api\AdminApiInterface;

class AdminApi implements AdminApiInterface
{

    // ...

    /**
     * Implementation of AdminApiInterface#deletePet
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

