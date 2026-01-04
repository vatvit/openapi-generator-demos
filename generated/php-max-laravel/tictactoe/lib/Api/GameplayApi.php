
# This is a sample api mustache template.  It is representing a fictitious
# language and won't be usable or compile to anything without lots of changes.
# Use it as an example.  You can access the variables in the generator object
# like such:

# use the package from the `apiPackage` variable
package: TictactoeApi\Api

# operations block
classname: GameplayApi

# loop over each operation in the API:

# each operation has an `operationId`:
operationId: getBoard

# and parameters:
game_id: string


# each operation has an `operationId`:
operationId: getGame

# and parameters:
game_id: string


# each operation has an `operationId`:
operationId: getMoves

# and parameters:
game_id: string


# each operation has an `operationId`:
operationId: getSquare

# and parameters:
game_id: string
row: int
column: int


# each operation has an `operationId`:
operationId: putSquare

# and parameters:
game_id: string
row: int
column: int
move_request: \TictactoeApi\Model\MoveRequest


# end of operations block
