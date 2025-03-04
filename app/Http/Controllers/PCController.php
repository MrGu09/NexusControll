<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PCController extends Controller
{
    public function sendCommand(Request $request)
    {
        $command = $request->input('command');

        // Send the command to WebSocket server
        $ws = stream_socket_client("tcp://192.168.1.13:3000", $errno, $errstr, 30);

        if (!$ws) {
            return response()->json(['error' => "Failed to connect: $errstr ($errno)"], 500);
        }

        fwrite($ws, $command);
        fclose($ws);

        return response()->json(['message' => "Command {$command} sent"]);
    }
}
