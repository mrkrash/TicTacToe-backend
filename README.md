# TicTacToe Backend Example

This is a small example of an API REST built on PHP of famous game (Tic-Tac-Toe)[https://en.wikipedia.org/wiki/Tic-tac-toe]

It's possible play the game with cURL from command line

## Start Server

You can use start the server with PHP builtin server: `php -S localhost:8000`

### Start a new game
With request `curl -c cookies.txt -X POST http://localhost:8000/new`, start a new game. The server return an unique ID.
### Execute a move
with request `curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"1","move":"C2"}' http://localhost:8000/move` a user make a move, where data are:
- `uuid`: unique ID received from command that start a new game
- `player`: the player that make the move ("1" or "2")
- `move`: the cell where player want place his mark

The table arranged before previous move
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T ||||
|C ||||
|D ||||

The table arranged after previous move
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T ||||
|C |||1|
|D ||||

## Example sequence of commands
`curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"1","move":"D2"}' http://localhost:8000/move`
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T ||||
|C ||||
|D |||1|

`curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"2","move":"C1"}' http://localhost:8000/move`
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T ||||
|C ||2||
|D |||1|

`curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"1","move":"D0"}' http://localhost:8000/move`
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T ||||
|C ||2||
|D |1||1|

`curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"2","move":"D1"}' http://localhost:8000/move`
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T ||||
|C ||2||
|D |1|2|1|

`curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"1","move":"T0"}' http://localhost:8000/move`
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T |1|||
|C ||2||
|D |1|2|1|

`curl -b cookies.txt -X PATCH -H "Content-Type: application/json" -d '{"uuid":"322b2aac-788c-4304-ba55-20de7b428e0a", "player":"2","move":"T1"}' http://localhost:8000/move`
|| 0 | 1 | 2 |
| -- | -- | -- | -- |
|T |1|2||
|C ||2||
|D |1|2|1|

**End Game** Player 2 Win!!
