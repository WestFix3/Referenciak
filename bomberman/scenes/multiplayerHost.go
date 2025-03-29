package scenes

import (
	"fmt"
	"log"
	"math/rand"

	"github.com/hajimehoshi/ebiten/v2"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/game/entities"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/game/multiplayer"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/userinfo"
)

type MultiPlayerGameSceneHost struct {
	Server *multiplayer.GameServer
	GameScene
}

func NewMultiPlayerGameSceneHost(server *multiplayer.GameServer, level string, host *userinfo.UserInfo) Scene {
	s := MultiPlayerGameSceneHost{
		Server: server,
	}
	s.GameScene = *LoadLevelFromTextFile(level)

	spawnPositions := []struct{ x, y float64 }{
		{16, 16},
		{float64(len(s.staticEntities[0])*16 - 32), 16},
		{16, float64(len(s.staticEntities)*16 - 32)},
		{float64(len(s.staticEntities[0])*16 - 32), float64(len(s.staticEntities)*16 - 32)},
	}

	if len(s.players) == 0 {
		for i, player := range s.Server.GameInfo.Players {
			spawnIndex := i % len(spawnPositions)
			spawn := spawnPositions[spawnIndex]

			s.Server.GameInfo.Players[i].X = spawn.x
			s.Server.GameInfo.Players[i].Y = spawn.y

			newPlayer := entities.NewPlayer(
				s.collisionSpace,
				spawn.x,
				spawn.y,
				host,
				player.Color,
			)
			s.players = append(s.players, *newPlayer)
		}
	}
	s.Server.GameInfo.GameState = multiplayer.GameStateRunning

	s.screenHeight = 16 * len(s.staticEntities)
	s.screenWidth = 16 * len(s.staticEntities[0])

	s.Server.GameInfo.Monsters = make([]multiplayer.ProtoEntity, len(s.monsters))
	s.Server.GameInfo.Boxes = make([]multiplayer.ProtoEntity, len(s.boxes))
	s.Server.GameInfo.StatusEffects = make([]multiplayer.ProtoEntity, len(s.statusEffects))
	for i, statusEffect := range s.statusEffects {
		s.Server.GameInfo.StatusEffects[i] = multiplayer.ProtoEntity{X: statusEffect.GetCollider().GetPosition().X, Y: statusEffect.GetCollider().GetPosition().Y, Type: statusEffect.StatusEffect.GetName()}
	}

	return &s
}

func (s *MultiPlayerGameSceneHost) Update(state *GameState) error {
	if s.Server.GameInfo.GameState == multiplayer.GameStateEnd && state.Input.IsAbilityOneJustPressed() {
		state.SceneManager.GoTo(NewMainMenuScene(s.screenWidth, s.screenHeight))
	}

	// Update player controls
	s.Server.GameInfo.Players[0].Control.Up = state.Input.StateForUp() > 0
	s.Server.GameInfo.Players[0].Control.Down = state.Input.StateForDown() > 0
	s.Server.GameInfo.Players[0].Control.Left = state.Input.StateForLeft() > 0
	s.Server.GameInfo.Players[0].Control.Right = state.Input.StateForRight() > 0
	s.Server.GameInfo.Players[0].Control.Ability1 = state.Input.IsAbilityOneJustPressed()
	s.Server.GameInfo.Players[0].Control.Ability2 = state.Input.IsAbilityTwoJustPressed()

	for i, entity := range s.monsters {
		s.monsters[i].Update()
		target := rand.Intn(len(s.players))
		s.monsters[i].SetTarget(&s.players[target])
		s.Server.GameInfo.Monsters[i].X = entity.GetCollider().GetPosition().X
		s.Server.GameInfo.Monsters[i].Y = entity.GetCollider().GetPosition().Y
	}

	for i, box := range s.boxes {
		s.boxes[i].Update()
		for i >= len(s.Server.GameInfo.Boxes) {
			s.Server.GameInfo.Boxes = append(s.Server.GameInfo.Boxes, multiplayer.ProtoEntity{X: box.GetCollider().GetPosition().X, Y: box.GetCollider().GetPosition().Y})
		}
		s.Server.GameInfo.Boxes[i].X = box.GetCollider().GetPosition().X
		s.Server.GameInfo.Boxes[i].Y = box.GetCollider().GetPosition().Y
	}

	for i, effect := range s.statusEffects {
		s.statusEffects[i].Update()
		for i >= len(s.Server.GameInfo.StatusEffects) {
			s.Server.GameInfo.StatusEffects = append(s.Server.GameInfo.StatusEffects, multiplayer.ProtoEntity{X: effect.GetCollider().GetPosition().X, Y: effect.GetCollider().GetPosition().Y, Type: effect.StatusEffect.GetName()})
		}
		s.Server.GameInfo.StatusEffects[i].X = effect.GetCollider().GetPosition().X
		s.Server.GameInfo.StatusEffects[i].Y = effect.GetCollider().GetPosition().Y
	}

	for i, v := range s.Server.GameInfo.Players {
		if v.IsDead {
			continue
		}

		s.players[i].Control = v.Control

		s.players[i].ColorOverLay = v.Color

		if len(s.Server.GameInfo.Players) > len(s.players) {
			s.players = append(s.players, *entities.NewPlayer(s.collisionSpace, v.X, v.Y, &userinfo.UserInfo{Username: v.Username}, v.Color))
		}

		newBomb, newBox, err := s.players[i].Update()
		if err != nil {
			log.Println(err)
		}

		if newBomb != nil {
			s.bombs = append(s.bombs, newBomb)
			s.Server.GameInfo.Bombs = append(s.Server.GameInfo.Bombs, multiplayer.ProtoEntity{X: newBomb.GetCollider().GetPosition().X, Y: newBomb.GetCollider().GetPosition().Y})
		}

		if newBox != nil {
			s.boxes = append(s.boxes, *newBox)
			s.Server.GameInfo.Boxes = append(s.Server.GameInfo.Boxes, multiplayer.ProtoEntity{X: newBox.GetCollider().GetPosition().X, Y: newBox.GetCollider().GetPosition().Y})
		}

		playerCollision := s.collisionSpace.CheckCollisions(s.players[i].GetCollider())
		//log.Println(s.players[i].State)
		for _, collision := range playerCollision {
			sep := collision.SeparatingVector
			switch collidingEntity := collision.Other.GetParent().(type) {
			case nil:
				break
			case *entities.Bomb:
				if !(s.players[i].State != nil && (s.players[i].State.GetName() == "GhostIncrease")) {
					s.players[i].GetCollider().Move(sep.X, sep.Y)
				}
			case *entities.Explosion:
				if !(s.players[i].State != nil && (s.players[i].State.GetName() == "InvincibilityIncrease")) {
					s.Server.GameInfo.Players[i].IsDead = true
				}
			case *entities.Box:
				if !(s.players[i].State != nil && (s.players[i].State.GetName() == "GhostIncrease")) {
					s.players[i].GetCollider().Move(sep.X, sep.Y)
				}
			case entities.Effect:
				s.players[i].State = collidingEntity.StatusEffect
				var effectsToRemove []int
				for j, effect := range s.statusEffects {
					if effect.GetCollider() == collision.Other {
						s.players[i].State = effect.StatusEffect
						s.collisionSpace.Remove(effect.GetCollider())
						effectsToRemove = append(effectsToRemove, j)
					}
				}
				for _, index := range effectsToRemove {
					if index < len(s.statusEffects)-1 {
						s.statusEffects[index] = s.statusEffects[len(s.statusEffects)-1]
						s.Server.GameInfo.StatusEffects[index] = s.Server.GameInfo.StatusEffects[len(s.Server.GameInfo.StatusEffects)-1]
					}
					s.statusEffects = s.statusEffects[:len(s.statusEffects)-1]
					s.Server.GameInfo.StatusEffects = s.Server.GameInfo.StatusEffects[:len(s.Server.GameInfo.StatusEffects)-1]
				}

			case entities.Terrain:
				if collidingEntity.IsSolid() {
					s.players[i].GetCollider().Move(sep.X, sep.Y)
				}
			case entities.Monster:
				if !(s.players[i].State != nil && (s.players[i].State.GetName() == "InvincibilityIncrease")) {
					s.Server.GameInfo.Players[i].IsDead = true
				}
			}
		}
		s.Server.GameInfo.Players[i].X = s.players[i].GetCollider().GetPosition().X
		s.Server.GameInfo.Players[i].Y = s.players[i].GetCollider().GetPosition().Y
	}

	for i, bomb := range s.bombs {
		if bomb.Update() {
			x, y := bomb.TilePosition()
			s.explosions = append(s.explosions, entities.NewExplosion(s.collisionSpace, float64(x*16), float64(y*16)))
			for j := 1; j <= bomb.ExplosionRange; j++ {
				if y+j < len(s.staticEntities) && s.staticEntities[x][y+j].IsDestroyable() || !s.staticEntities[x][y+j].IsSolid() {
					s.explosions = append(s.explosions, entities.NewExplosion(s.collisionSpace, float64(x*16), float64((y+j)*16)))
				} else {
					break
				}
			}
			for j := 1; j <= bomb.ExplosionRange; j++ {
				if y-j >= 0 && s.staticEntities[x][y-j].IsDestroyable() || !s.staticEntities[x][y-j].IsSolid() {
					s.explosions = append(s.explosions, entities.NewExplosion(s.collisionSpace, float64(x*16), float64((y-j)*16)))
				} else {
					break
				}
			}
			for j := 1; j <= bomb.ExplosionRange; j++ {
				if x+j < len(s.staticEntities) && s.staticEntities[x+j][y].IsDestroyable() || !s.staticEntities[x+j][y].IsSolid() {
					s.explosions = append(s.explosions, entities.NewExplosion(s.collisionSpace, float64((x+j)*16), float64((y)*16)))
				} else {
					break
				}
			}
			for j := 1; j <= bomb.ExplosionRange; j++ {
				if x-j >= 0 && s.staticEntities[x-j][y].IsDestroyable() || !s.staticEntities[x-j][y].IsSolid() {
					s.explosions = append(s.explosions, entities.NewExplosion(s.collisionSpace, float64((x-j)*16), float64(y*16)))
				} else {
					break
				}
			}
			s.bombs[i].Owner.NumberOfBombs++
			s.collisionSpace.Remove(bomb.GetCollider())
			if i-1 >= 0 {
				s.bombs[i] = s.bombs[len(s.bombs)-1]
				s.bombs = s.bombs[:len(s.bombs)-1]
				s.Server.GameInfo.Bombs[i] = s.Server.GameInfo.Bombs[len(s.Server.GameInfo.Bombs)-1]
				s.Server.GameInfo.Bombs = s.Server.GameInfo.Bombs[:len(s.Server.GameInfo.Bombs)-1]
			} else {
				s.bombs = make([]*entities.Bomb, 0)
				s.Server.GameInfo.Bombs = make([]multiplayer.ProtoEntity, 0)
			}
		}
	}

	for i, monster := range s.monsters {
		monsterCollision := s.collisionSpace.CheckCollisions(monster.GetCollider())
		for _, collision := range monsterCollision {
			if _, isExplosion := collision.Other.GetParent().(*entities.Explosion); isExplosion {
				s.collisionSpace.Remove(monster.GetCollider())
				s.monsters[i] = s.monsters[len(s.monsters)-1]
				s.monsters = s.monsters[:len(s.monsters)-1]
				s.Server.GameInfo.Monsters[i] = s.Server.GameInfo.Monsters[len(s.Server.GameInfo.Monsters)-1]
				s.Server.GameInfo.Monsters = s.Server.GameInfo.Monsters[:len(s.Server.GameInfo.Monsters)-1]
				break
			}
		}
	}
	for i := 0; i < len(s.explosions); i++ {
		if s.explosions[i].Update() {
			s.collisionSpace.Remove(s.explosions[i].GetCollider())
			s.explosions[i] = s.explosions[len(s.explosions)-1]
			s.explosions = s.explosions[:len(s.explosions)-1]
			s.Server.GameInfo.Explosions[i] = s.Server.GameInfo.Explosions[len(s.Server.GameInfo.Explosions)-1]
			s.Server.GameInfo.Explosions = s.Server.GameInfo.Explosions[:len(s.Server.GameInfo.Explosions)-1]
		} else {
			for i >= len(s.Server.GameInfo.Explosions) {
				s.Server.GameInfo.Explosions = append(s.Server.GameInfo.Explosions, multiplayer.ProtoEntity{X: s.explosions[i].GetCollider().GetPosition().X, Y: s.explosions[i].GetCollider().GetPosition().Y})
			}
			s.Server.GameInfo.Explosions[i].X = s.explosions[i].GetCollider().GetPosition().X
			s.Server.GameInfo.Explosions[i].Y = s.explosions[i].GetCollider().GetPosition().Y

			exploX, ExploY := s.explosions[i].TilePosition()
			for j, box := range s.boxes {
				boxX, boxY := box.TilePosition()
				if exploX == boxX && ExploY == boxY {
					if !box.IsBlank {
						newEffect := box.DropRandomStatusEffect()
						if newEffect.StatusEffect != nil {
							s.statusEffects = append(s.statusEffects, newEffect)
							s.Server.GameInfo.StatusEffects = append(s.Server.GameInfo.StatusEffects, multiplayer.ProtoEntity{X: box.GetCollider().GetPosition().X, Y: box.GetCollider().GetPosition().Y, Type: newEffect.StatusEffect.GetName()})
						}
					}
					s.collisionSpace.Remove(box.GetCollider())
					s.Server.GameInfo.Boxes[j] = s.Server.GameInfo.Boxes[len(s.Server.GameInfo.Boxes)-1]
					s.Server.GameInfo.Boxes = s.Server.GameInfo.Boxes[:len(s.Server.GameInfo.Boxes)-1]
					s.boxes[j] = s.boxes[len(s.boxes)-1]
					s.boxes = s.boxes[:len(s.boxes)-1]
				}
			}

			if s.staticEntities[exploX][ExploY].IsDestroyable() {
				log.Println("Destroyable at x:", exploX, "y:", ExploY, "type:", s.staticEntities[exploX][ExploY])
				s.collisionSpace.Remove(s.staticEntities[exploX][ExploY].GetCollider())
				s.staticEntities[exploX][ExploY] = entities.NewGrass(s.collisionSpace, float64(exploX*16), float64(ExploY*16), "assets/map/grass_block.png")
				s.Server.GameInfo.TerrainChanges = append(s.Server.GameInfo.TerrainChanges, multiplayer.ProtoTerrainChange{X: exploX, Y: ExploY, To: "GRASS"})
			}
		}
	}

	s.Server.GameInfo.GameState = multiplayer.GameStateEnd
	for _, player := range s.Server.GameInfo.Players {
		if !player.IsDead {
			s.Server.GameInfo.GameState = multiplayer.GameStateRunning
			break
		}
	}

	return nil
}

func (s *MultiPlayerGameSceneHost) Draw(screen *ebiten.Image) {
	s.GameScene.Draw(screen)

	for i, player := range s.Server.GameInfo.Players {
		if !player.IsDead && i < len(s.players) {
			s.players[i].Draw(screen)
		}
	}

	if s.Server.GameInfo.GameState == multiplayer.GameStateEnd {
		drawLogo(screen, 400, 30, "Game Over")

		OrientationY := 50
		for _, player := range s.Server.GameInfo.Players {
			drawLogo(screen, 400, OrientationY, fmt.Sprintln(player.Username, "Score:", player.Score))
			OrientationY += 30
		}
	}
}
