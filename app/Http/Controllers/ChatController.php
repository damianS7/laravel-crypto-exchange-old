<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

// Beautify this class
class ChatController extends Controller
{
    /**
     *
     * This returns updated data so we can update the website
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetLastMessages(Request $request)
    {
        $last_message_id = $request->last_message_id;
        $messages = $this->getLastMessages($last_message_id);
        $response = [
            'status' => 'ok',
            'message' => 'received id: ' . $last_message_id,
            'data' => [
                'messages' => $messages,
                'count' => count($messages),
                'date' => date('Y-m-d H:i:s'),
            ],
        ];
        return response()->json($response);

    }

    private function getLastMessages($last_id = null)
    {
        $now = date('Y-m-d H:i:s');
        $before = date($now, strtotime('-1 seconds'));

        //SELECT * FROM chat_messages WHERE created_at BETWEEN (SELECT DATE_SUB(current_timestamp, INTERVAL 10 SECOND)) AND (SELECT NOW())
        //$query = ChatMessage::whereBetween('created_at', [$before, $now])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');
        $query = ChatMessage::orderBy('id', 'DESC')->limit(1);
        if ($last_id !== null) {
            //$query = ChatMessage::where('id', '>', $last_id)->whereBetween('created_at', [$before, $now])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');
            $query = ChatMessage::where('id', '>', $last_id)->orderBy('created_at', 'DESC')->orderBy('id', 'ASC');

        }

        return $query->get();
    }

    /**
     *
     * This returns updated data so we can update the website
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxPostMessage(Request $request)
    {
        $response = [
            'status' => 'ok',
            'message' => 'message received.',
            'received' => $request->message,
            'data' => '',
        ];

        if (!Auth::check()) {
            $response['status'] = 'error';
            $response['message'] = 'You are not logged in.';
            return response()->json($response);
        }

        $chat_message = $this->postChatMessage(Auth::user()->id, $request->message);
        $message['data'] = $chat_message;
        return response()->json($response);
    }

    private function postChatMessage($user_id, $message)
    {
        // Balance must be checked before put the order
        $chat = new ChatMessage;
        $chat->user_id = $user_id;
        $chat->message = $message;
        $chat->save();
        return $chat;
    }

}
