# PetshopApi\Api\PetsApiInterface

All URIs are relative to *https://petstore.swagger.io/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addPet**](PetsApiInterface.md#addPet) | **POST** /pets | 
[**deletePet**](PetsApiInterface.md#deletePet) | **DELETE** /pets/{id} | 
[**findPetById**](PetsApiInterface.md#findPetById) | **GET** /pets/{id} | 
[**findPets**](PetsApiInterface.md#findPets) | **GET** /pets | 


## Service Declaration
```yaml
# config/services.yaml
services:
    # ...
    Acme\MyBundle\Api\PetsApi:
        tags:
            - { name: "open_api_server.api", api: "pets" }
    # ...
```

## **addPet**
> PetshopApi\Model\Pet addPet($newPet)



Creates a new pet in the store. Duplicates are allowed

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/PetsApiInterface.php

namespace Acme\MyBundle\Api;

use PetshopApi\Api\PetsApiInterface;

class PetsApi implements PetsApiInterface
{

    // ...

    /**
     * Implementation of PetsApiInterface#addPet
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
 **newPet** | [**PetshopApi\Model\NewPet**](../Model/NewPet.md)| Pet to add to the store |

### Return type

[**PetshopApi\Model\Pet**](../Model/Pet.md)

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
// src/Acme/MyBundle/Api/PetsApiInterface.php

namespace Acme\MyBundle\Api;

use PetshopApi\Api\PetsApiInterface;

class PetsApi implements PetsApiInterface
{

    // ...

    /**
     * Implementation of PetsApiInterface#deletePet
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

## **findPetById**
> PetshopApi\Model\Pet findPetById($id)



Returns a user based on a single ID, if the user does not have access to the pet

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/PetsApiInterface.php

namespace Acme\MyBundle\Api;

use PetshopApi\Api\PetsApiInterface;

class PetsApi implements PetsApiInterface
{

    // ...

    /**
     * Implementation of PetsApiInterface#findPetById
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

## **findPets**
> PetshopApi\Model\Pet findPets($tags, $limit)



Returns all pets from the system that the user has access to Nam sed condimentum est. Maecenas tempor sagittis sapien, nec rhoncus sem sagittis sit amet. Aenean at gravida augue, ac iaculis sem. Curabitur odio lorem, ornare eget elementum nec, cursus id lectus. Duis mi turpis, pulvinar ac eros ac, tincidunt varius justo. In hac habitasse platea dictumst. Integer at adipiscing ante, a sagittis ligula. Aenean pharetra tempor ante molestie imperdiet. Vivamus id aliquam diam. Cras quis velit non tortor eleifend sagittis. Praesent at enim pharetra urna volutpat venenatis eget eget mauris. In eleifend fermentum facilisis. Praesent enim enim, gravida ac sodales sed, placerat id erat. Suspendisse lacus dolor, consectetur non augue vel, vehicula interdum libero. Morbi euismod sagittis libero sed lacinia.  Sed tempus felis lobortis leo pulvinar rutrum. Nam mattis velit nisl, eu condimentum ligula luctus nec. Phasellus semper velit eget aliquet faucibus. In a mattis elit. Phasellus vel urna viverra, condimentum lorem id, rhoncus nibh. Ut pellentesque posuere elementum. Sed a varius odio. Morbi rhoncus ligula libero, vel eleifend nunc tristique vitae. Fusce et sem dui. Aenean nec scelerisque tortor. Fusce malesuada accumsan magna vel tempus. Quisque mollis felis eu dolor tristique, sit amet auctor felis gravida. Sed libero lorem, molestie sed nisl in, accumsan tempor nisi. Fusce sollicitudin massa ut lacinia mattis. Sed vel eleifend lorem. Pellentesque vitae felis pretium, pulvinar elit eu, euismod sapien.

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/PetsApiInterface.php

namespace Acme\MyBundle\Api;

use PetshopApi\Api\PetsApiInterface;

class PetsApi implements PetsApiInterface
{

    // ...

    /**
     * Implementation of PetsApiInterface#findPets
     */
    public function findPets(?array $tags, ?int $limit, int &$responseCode, array &$responseHeaders): array|object|null
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **tags** | [**string**](../Model/string.md)| tags to filter by | [optional]
 **limit** | **int**| maximum number of results to return | [optional]

### Return type

[**PetshopApi\Model\Pet**](../Model/Pet.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

