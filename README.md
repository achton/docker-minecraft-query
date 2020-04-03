Containerized Minecraft Query Application
=========================================

This Docker image utilizes the [PHP Minecraft Query](https://github.com/xPaw/PHP-Minecraft-Query) library to expose a simple container which can query a Minecraft Bedrock/Java server for info about name, world name, players, version, etc.

It can be used directly by exec'ing into the container, or by putting an Nginx container in front which can handle incoming requests.

## Example usage

Via nginx using `curl` and `jq` (assumes also [Dory](https://github.com/FreedomBen/dory)):
```
$ curl -s http://mcquery.docker/ | jq
{
  "gamemode": "Survival",
  "gamename": "MCPE",
  "hostname": "§l§6My Game Server [SURVIVAL]",
  "ip": "bedrock.server.ip.here",
  "map": "§bPure survival!",
  "maxplayers": "20",
  "method": "ConnectBedrock",
  "players": "2",
  "port": "19132",
  "protocol": "389",
  "status_code": 200,
  "unknown2": "10553705791303119976",
  "unknown3": "1",
  "version": "1.14.32"
}
```

Using docker-compose and the `phpfpm` container only:
```
$ docker-compose run --rm phpfpm php index.php | jq
{
  "gamemode": "Survival",
  "gamename": "MCPE",
  "hostname": "§l§6My Game Server [SURVIVAL]",
  "ip": "bedrock.server.ip.here",
  "map": "§bPure survival!",
  "maxplayers": "20",
  "method": "ConnectBedrock",
  "players": "2",
  "port": "19132",
  "protocol": "389",
  "status_code": 200,
  "unknown2": "10553705791303119976",
  "unknown3": "1",
  "version": "1.14.32"
}
```

Using docker and the `phpfpm` container, setting variables at runtime:
```
$ docker run --rm --name mcquery -e MCQ_IP=bedrock.server.ip.here -e MCQ_PORT=19132 achton/docker-minecraft-query:latest php index.php | jq
{
  "gamemode": "Survival",
  "gamename": "MCPE",
  "hostname": "§l§6My Game Server [SURVIVAL]",
  "ip": "bedrock.server.ip.here",
  "map": "§bPure survival!",
  "maxplayers": "20",
  "method": "ConnectBedrock",
  "players": "2",
  "port": "19132",
  "protocol": "389",
  "status_code": 200,
  "unknown2": "10553705791303119976",
  "unknown3": "1",
  "version": "1.14.32"
}
```
