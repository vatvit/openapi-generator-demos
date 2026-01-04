
# This is a sample api mustache template.  It is representing a fictitious
# language and won't be usable or compile to anything without lots of changes.
# Use it as an example.  You can access the variables in the generator object
# like such:

# use the package from the `apiPackage` variable
package: TictactoeApi\Api

# operations block
classname: GameManagementApi

# loop over each operation in the API:

# each operation has an `operationId`:
operationId: createGame

# and parameters:
create_game_request: \TictactoeApi\Model\CreateGameRequest


# each operation has an `operationId`:
operationId: deleteGame

# and parameters:
game_id: string


# each operation has an `operationId`:
operationId: getGame

# and parameters:
game_id: string


# each operation has an `operationId`:
operationId: listGames

# and parameters:
page: int
limit: int
status: \TictactoeApi\Model\GameStatus
player_id: string


# end of operations block
