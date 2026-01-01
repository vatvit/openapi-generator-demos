# Game

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Unique game identifier | 
**status** | [**TictactoeApi\Model\GameStatus**](GameStatus.md) |  | 
**mode** | [**TictactoeApi\Model\GameMode**](GameMode.md) |  | 
**playerX** | [**TictactoeApi\Model\Player**](Player.md) | Player assigned to X marks | [optional] 
**playerO** | [**TictactoeApi\Model\Player**](Player.md) | Player assigned to O marks | [optional] 
**currentTurn** | [**TictactoeApi\Model\Mark**](Mark.md) |  | [optional] 
**winner** | [**TictactoeApi\Model\Winner**](Winner.md) |  | [optional] 
**board** | **TictactoeApi\Model\Mark** | 3x3 game board represented as nested arrays | 
**createdAt** | **\DateTime** | Game creation timestamp | 
**updatedAt** | **\DateTime** | Last update timestamp | [optional] 
**completedAt** | **\DateTime** | Game completion timestamp | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


