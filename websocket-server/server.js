const WebSocket = require("ws");

// Create a WebSocket server
const wss = new WebSocket.Server({ port: 3000 });

wss.on("connection", (ws) => {
    console.log("Sub-PC connected");

    // Handle incoming messages
    ws.on("message", (message) => {
        console.log("Received command:", message);

        // Broadcast the command to all connected clients (sub-PCs)
        wss.clients.forEach((client) => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    ws.on("close", () => {
        console.log("Sub-PC disconnected");
    });
});

console.log("WebSocket server running on ws://192.168.1.13:3000");
