
# This is a sample api mustache template.  It is representing a fictitious
# language and won't be usable or compile to anything without lots of changes.
# Use it as an example.  You can access the variables in the generator object
# like such:

# use the package from the `apiPackage` variable
package: PetshopApi\Api

# operations block
classname: PetsApi

# loop over each operation in the API:

# each operation has an `operationId`:
operationId: addPet

# and parameters:
new_pet: \PetshopApi\Model\NewPet


# each operation has an `operationId`:
operationId: deletePet

# and parameters:
id: int


# each operation has an `operationId`:
operationId: findPetById

# and parameters:
id: int


# each operation has an `operationId`:
operationId: findPets

# and parameters:
tags: string[]
limit: int


# end of operations block
