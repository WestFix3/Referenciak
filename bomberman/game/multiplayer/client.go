package multiplayer

import (
	"log"
	"time"

	"github.com/gorilla/websocket"
	"szofttech.inf.elte.hu/szofttech-c-2024/group-08/ninjago/userinfo"
)

// GameClient represents a client connected to the game server.
type GameClient struct {
	conn     *websocket.Conn // The connection to the game server.
	GameInfo ProtoGameInfo   // The game state information received from the server.
	Ping     time.Duration   // The ping of the client.
	Player   *ProtoPlayer    // The player information for the client.
}

// NewGameClient creates a new GameClient and connects to the game server at the specified address.
func NewGameClient(Address string, UserInfo *userinfo.UserInfo, CloseHandler func(code int, text string) error) *GameClient {
	gc := &GameClient{}
	conn, _, err := websocket.DefaultDialer.Dial("ws://"+Address+"/", nil)
	if err != nil {
		log.Println("Failed to connect to server:", err)

		return nil
	}

	gc.conn = conn

	var userID userinfo.UserInfo
	err = gc.conn.ReadJSON(&userID)
	if err != nil {
		log.Println("Failed to Get userid:", err)

		return nil
	}
	UserInfo.UserID = userID.UserID
	gc.Player = &ProtoPlayer{
		Username: UserInfo.Username,
	}

	gc.conn.SetCloseHandler(CloseHandler)

	go gc.handleWebsocketConnection()

	return gc
}

// handleWebsocketConnection handles the websocket communication with the game server.
func (gc *GameClient) handleWebsocketConnection() {
	if gc.conn == nil {
		log.Panic("Connection is nil")
	}
	for {
		comStart := time.Now()

		err := gc.conn.WriteJSON(*(gc.Player))
		if err != nil {
			log.Println("Failed to send message to server:", err)
		}

		err = gc.conn.ReadJSON(&gc.GameInfo)
		if err != nil {
			log.Println("Failed to read message from server:", err)
		}

		for _, player := range gc.GameInfo.Players {
			gc.Player.Color = player.Color
		}

		gc.Ping = time.Since(comStart)
	}
}

// Close closes the connection to the game server.
func (gc *GameClient) Close() {
	if gc.conn == nil {
		return
	}

	gc.conn.Close()
}
