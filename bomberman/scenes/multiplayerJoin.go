package scenes

import (
	"fmt"

	"github.com/hajimehoshi/ebiten/v2"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/game/entities"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/game/multiplayer"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/userinfo"
)

type MultiPlayerGameSceneJoin struct {
	Client *multiplayer.GameClient
	GameScene
	terrainChange int
}

func NewMultiPlayerGameSceneJoin(client *multiplayer.GameClient) Scene {
	s := MultiPlayerGameSceneJoin{
		Client: client,
	}
	s.GameScene = *LoadLevelFromTextFile(client.GameInfo.Level)

	spawnPositions := []struct{ x, y float64 }{
		{16, 16},
		{float64(len(s.staticEntities[0])*16 - 32), 16},
		{16, float64(len(s.staticEntities)*16 - 32)},
		{float64(len(s.staticEntities[0])*16 - 32), float64(len(s.staticEntities)*16 - 32)},
	}

	s.players = make([]entities.Player, len(client.GameInfo.Players))
	for i, player := range client.GameInfo.Players {
		spawnIndex := i % len(spawnPositions)
		spawn := spawnPositions[spawnIndex]

		s.players[i] = *entities.NewPlayer(
			s.collisionSpace,
			spawn.x,
			spawn.y,
			&userinfo.UserInfo{Username: player.Username},
			player.Color,
		)
	}

	s.screenHeight = 16 * len(s.staticEntities)
	s.screenWidth = 16 * len(s.staticEntities[0])

	return &s
}

func (s *MultiPlayerGameSceneJoin) Update(state *GameState) error {
	if s.Client.GameInfo.GameState == multiplayer.GameStateEnd && state.Input.IsAbilityOneJustPressed() {
		state.SceneManager.GoTo(NewMainMenuScene(s.screenWidth, s.screenHeight))
	}

	s.Client.Player.Control.Up = state.Input.StateForUp() > 0
	s.Client.Player.Control.Down = state.Input.StateForDown() > 0
	s.Client.Player.Control.Left = state.Input.StateForLeft() > 0
	s.Client.Player.Control.Right = state.Input.StateForRight() > 0
	s.Client.Player.Control.Ability1 = state.Input.IsAbilityOneJustPressed()
	s.Client.Player.Control.Ability2 = state.Input.IsAbilityTwoJustPressed()

	// update monsters
	for i, entity := range s.monsters {
		entity.GetCollider().MoveTo(s.Client.GameInfo.Monsters[i].X, s.Client.GameInfo.Monsters[i].Y)
	}

	//update effects
	if len(s.Client.GameInfo.StatusEffects) != len(s.statusEffects) {
		existingEffects := make(map[string]entities.Effect)
		for _, effect := range s.statusEffects {
			pos := fmt.Sprintf("%.0f,%.0f", effect.GetCollider().GetPosition().X, effect.GetCollider().GetPosition().Y)
			existingEffects[pos] = effect
		}

		newEffects := []entities.Effect{}
		for _, effect := range s.Client.GameInfo.StatusEffects {
			pos := fmt.Sprintf("%.0f,%.0f", effect.X, effect.Y)
			if existing, ok := existingEffects[pos]; ok {
				newEffects = append(newEffects, existing)
				continue
			}

			var newEffect entities.Effect
			switch effect.Type {
			case "SkullDebuff":
				newEffect = entities.NewSkullDebuff(s.collisionSpace, effect.X, effect.Y)
			case "BombCountIncrease":
				newEffect = entities.NewBombEffect(s.collisionSpace, effect.X, effect.Y)
			case "RadiusIncrease":
				newEffect = entities.NewRadiusEffect(s.collisionSpace, effect.X, effect.Y)
			case "RollerIncrease":
				newEffect = entities.NewRollerEffect(s.collisionSpace, effect.X, effect.Y)
			case "ObstacleIncrease":
				newEffect = entities.NewObstacleEffect(s.collisionSpace, effect.X, effect.Y)
			case "DetonatorIncrease":
				newEffect = entities.NewDetonatorEffect(s.collisionSpace, effect.X, effect.Y)
			case "GhostIncrease":
				newEffect = entities.NewGhostEffect(s.collisionSpace, effect.X, effect.Y)
			case "InvincibilityIncrease":
				newEffect = entities.NewInvincibilityEffect(s.collisionSpace, effect.X, effect.Y)
			}
			if newEffect.GetCollider() != nil {
				newEffects = append(newEffects, newEffect)
			}
		}

		for _, effect := range s.statusEffects {
			s.collisionSpace.Remove(effect.GetCollider())
		}

		s.statusEffects = newEffects
	}

	for _, effect := range s.statusEffects {
		effect.Update()
	}

	for i, v := range s.Client.GameInfo.Players {
		if !v.IsDead && i < len(s.players) {
			s.players[i].ColorOverLay = v.Color
		}
	}

	for i := len(s.explosions); i < len(s.Client.GameInfo.Explosions); i++ {
		s.explosions = append(s.explosions, entities.NewExplosion(s.collisionSpace, s.Client.GameInfo.Explosions[i].X, s.Client.GameInfo.Explosions[i].Y))
	}

	for i, explosion := range s.explosions {
		if explosion.Update() {
			s.collisionSpace.Remove(s.explosions[i].GetCollider())
			s.explosions = append(s.explosions[:i], s.explosions[i+1:]...)
			break
		}
	}

	for i := len(s.bombs); i < len(s.Client.GameInfo.Bombs); i++ {
		s.bombs = append(s.bombs, entities.NewBomb(s.collisionSpace, nil, 1, s.Client.GameInfo.Bombs[i].X, s.Client.GameInfo.Bombs[i].Y))
	}

	for i, bomb := range s.bombs {
		if bomb.Update() {
			s.collisionSpace.Remove(s.bombs[i].GetCollider())
			if i-1 >= 0 {
				s.bombs[i] = s.bombs[len(s.bombs)-1]
				s.bombs = s.bombs[:len(s.bombs)-1]
			} else {
				s.bombs = make([]*entities.Bomb, 0)
			}
		}
	}

	if len(s.players) != len(s.Client.GameInfo.Players) {
		s.players = make([]entities.Player, len(s.Client.GameInfo.Players))
		for i, v := range s.Client.GameInfo.Players {
			s.players[i] = *entities.NewPlayer(s.collisionSpace, v.X, v.Y, &userinfo.UserInfo{Username: v.Username}, v.Color)
		}
	}

	for s.terrainChange < len(s.Client.GameInfo.TerrainChanges) {
		s.staticEntities[s.Client.GameInfo.TerrainChanges[s.terrainChange].X][s.Client.GameInfo.TerrainChanges[s.terrainChange].Y] = entities.NewGrass(s.collisionSpace, float64(s.Client.GameInfo.TerrainChanges[s.terrainChange].X*16), float64(s.Client.GameInfo.TerrainChanges[s.terrainChange].Y*16), "assets/map/grass_block.png")
		s.terrainChange++
	}

	return nil
}

func (s *MultiPlayerGameSceneJoin) Draw(screen *ebiten.Image) {
	s.GameScene.Draw(screen)

	for i, v := range s.Client.GameInfo.Players {
		if v.IsDead {
			continue
		}

		if i < len(s.players) {
			s.players[i].GetCollider().MoveTo(v.X, v.Y)
			s.players[i].Draw(screen)
		}
	}

	if s.Client.GameInfo.GameState == multiplayer.GameStateEnd {
		drawLogo(screen, 400, 30, "Game Over")

		OrientationY := 50
		for _, player := range s.Client.GameInfo.Players {
			drawLogo(screen, 400, OrientationY, fmt.Sprintln(player.Username, player.Score))
			OrientationY += 30
		}
	}
}
