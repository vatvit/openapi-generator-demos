# Game

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Unique game identifier | 
**status** | [**TicTacToeApi\Model\GameStatus**](GameStatus.md) |  | 
**mode** | [**TicTacToeApi\Model\GameMode**](GameMode.md) |  | 
**playerX** | [**TicTacToeApi\Model\Player**](Player.md) | Player assigned to X marks | [optional] 
**playerO** | [**TicTacToeApi\Model\Player**](Player.md) | Player assigned to O marks | [optional] 
**currentTurn** | [**TicTacToeApi\Model\Mark**](Mark.md) |  | [optional] 
**winner** | [**TicTacToeApi\Model\Winner**](Winner.md) |  | [optional] 
**board** | **TicTacToeApi\Model\Mark** | 3x3 game board represented as nested arrays | 
**createdAt** | **\DateTime** | Game creation timestamp | 
**updatedAt** | **\DateTime** | Last update timestamp | [optional] 
**completedAt** | **\DateTime** | Game completion timestamp | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


