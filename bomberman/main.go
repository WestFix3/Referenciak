// This file is the entry point of the game. It sets up the game window and runs the game loop.
package main

import (
	"log"

	"github.com/hajimehoshi/ebiten/v2"
)

// ScreenWidth and ScreenHeight are the dimensions of the game screen.
const (
	ScreenWidth  = 400
	ScreenHeight = 350
)

// main is the entry point of the Ninja Go Bomberman game.
func main() {
	ebiten.SetWindowSize(ScreenWidth*2, ScreenHeight*2)
	ebiten.SetWindowResizingMode(ebiten.WindowResizingModeEnabled)
	ebiten.SetScreenClearedEveryFrame(false)
	ebiten.SetVsyncEnabled(false)
	ebiten.SetWindowTitle("Ninja Go Bomberman")
	if err := ebiten.RunGame(&Game{}); err != nil {
		log.Fatal(err)
	}
}
