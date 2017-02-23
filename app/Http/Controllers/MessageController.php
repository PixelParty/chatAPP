<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Message as MassageModel;
use App\Events\Message as MessageEvent;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if($request->limit){
    		$messages = MassageModel::limit($request->limit)->crossJoin('users')->get();
    		
    	}else{
    		$messages = MassageModel::crossJoin('users')->get();
    	}
    	return $messages->toArray();
    }

    /**
     * Store the incoming message.
     *
     * @param  Request  $request
     * @return Response
     */
	public function store(Request $request)
	{
	    $valid = Validator::make($request->all(), [
	        'message' => 'required'
	    ]);

	    if(!$valid->fails())
	    {
	    	$user = Auth::user();
	        $message = new MassageModel;
	        $message->text = $request->message;
	        $message->user_id = $user->id;
	        $message->save();
	        event(new MessageEvent($message, $user));
	    }
	}

}
