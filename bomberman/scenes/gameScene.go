// Package scenes provides the implementation of various game scenes and their management.
package scenes

import (
	"fmt"
	"image/color"

	"github.com/hajimehoshi/ebiten/v2"
	collider "github.com/vcscsvcscs/ebiten-collider"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/game/entities"
)

// GameScene represents a game scene containing all necessary entities and game state.
type GameScene struct {
	screenHeight   int                   // The height of the game screen.
	screenWidth    int                   // The width of the game screen.
	collisionSpace *collider.SpatialHash // The collision space for the game entities.
	staticEntities [][]entities.Terrain  // The static entities in the game scene.
	monsters       []entities.Monster    // The monsters in the game scene.
	bombs          []*entities.Bomb      // The bombs in the game scene.
	explosions     []*entities.Explosion // The explosions in the game scene.
	boxes          []entities.Box        // The boxes in the game scene.
	statusEffects  []entities.Effect     // The status effects in the game scene.
	players        []entities.Player     // The players in the game scene.
}

// NewSinglePlayerGameScene creates a new single-player game scene by loading a level from a text file.
// It initializes the game scene with entities and sets the screen dimensions based on the level data.
//
// Parameters:
//   - filepath: The path to the text file containing the level data.
//
// Returns:
//   - Scene: The initialized single-player game scene.
func NewSinglePlayerGameScene(filepath string) Scene {
	s := LoadLevelFromTextFile(filepath)

	s.screenHeight = 16 * len(s.staticEntities)
	s.screenWidth = 16 * len(s.staticEntities[0])

	return s
}

// Update updates the game scene based on the current game state.
// This method is not yet implemented.
//
// Parameters:
//   - state: The current game state.
//
// Returns:
//   - error: An error indicating that the method is not yet implemented.
func (s *GameScene) Update(state *GameState) error {
	return fmt.Errorf("not implemented")
}

// Draw renders the game scene onto the provided screen image.
//
// Parameters:
//   - screen: The image to which the scene is drawn.
func (s *GameScene) Draw(screen *ebiten.Image) {
	screen.Fill(color.RGBA{148, 247, 252, 1})

	for _, rows := range s.staticEntities {
		for _, entity := range rows {
			entity.Draw(screen)
		}
	}

	for _, effect := range s.statusEffects {
		effect.Draw(screen)
	}

	for _, box := range s.boxes {
		box.Draw(screen)
	}

	for i := range s.bombs {
		s.bombs[i].Draw(screen)
	}

	for _, entity := range s.monsters {
		entity.Draw(screen)
	}

	for i := range s.explosions {
		s.explosions[i].Draw(screen)
	}
}
