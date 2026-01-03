# # Game

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Unique game identifier |
**status** | [**\TictactoeApi\Model\GameStatus**](GameStatus.md) |  |
**mode** | [**\TictactoeApi\Model\GameMode**](GameMode.md) |  |
**player_x** | [**\TictactoeApi\Model\Player**](Player.md) | Player assigned to X marks | [optional]
**player_o** | [**\TictactoeApi\Model\Player**](Player.md) | Player assigned to O marks | [optional]
**current_turn** | [**\TictactoeApi\Model\Mark**](Mark.md) |  | [optional]
**winner** | [**\TictactoeApi\Model\Winner**](Winner.md) |  | [optional]
**board** | **\TictactoeApi\Model\Mark[][]** | 3x3 game board represented as nested arrays |
**created_at** | **\DateTime** | Game creation timestamp |
**updated_at** | **\DateTime** | Last update timestamp | [optional]
**completed_at** | **\DateTime** | Game completion timestamp | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
