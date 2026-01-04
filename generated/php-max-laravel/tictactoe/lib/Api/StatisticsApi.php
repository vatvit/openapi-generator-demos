
# This is a sample api mustache template.  It is representing a fictitious
# language and won't be usable or compile to anything without lots of changes.
# Use it as an example.  You can access the variables in the generator object
# like such:

# use the package from the `apiPackage` variable
package: TictactoeApi\Api

# operations block
classname: StatisticsApi

# loop over each operation in the API:

# each operation has an `operationId`:
operationId: getLeaderboard

# and parameters:
timeframe: string
limit: int


# each operation has an `operationId`:
operationId: getPlayerStats

# and parameters:
player_id: string


# end of operations block
