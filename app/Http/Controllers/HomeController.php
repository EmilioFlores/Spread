<?php namespace App\Http\Controllers;
use Request;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

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
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$username = "5218117476498";                      // Telephone number including the country code without '+' or '00'.
		$password = "eBVeJJ07vy3XdoZV+Lur3VKZaig";     // Use registerTool.php or exampleRegister.php to obtain your password
		$nickname = "Starbucks";                          // This is the username (or nickname) displayed by WhatsApp clients.
		$w = new \WhatsProt($username, $nickname, true);
		//if(Request::input('options')=='test')
		//{
		//	return view('test', compact('username', 'nickname'));
		//}
		$debug = true;  // Shows debug log

		$w->connect();

		// Now loginWithPassword function sends Nickname and (Available) Presence
		$w->loginWithPassword($password);

		while (1) {
    		$w->pollMessage();
    		$msgs = $w->getMessages();
    		foreach ($msgs as $m) {
		        $message=$m->getChild('body');
		        $message=$message->getData();
		        $w->sendMessage('5218111707775', $message);
		        $w->sendMessage('5218116001989', $message);

    }
    // $line = fgets_u(STDIN);
    // if ($line != "") {
    //     if (strrchr($line, " ")) {
    //         $command = trim(strstr($line, ' ', TRUE));
    //     } else {
    //         $command = $line;
    //     }
    //     //available commands in the interactive conversation [/lastseen, /query]
    //     switch ($command) {
    //         case "/query":
    //             $dst = trim(strstr($line, ' ', FALSE));
    //             echo "[] Interactive conversation with $target:\n";
    //             break;
    //         case "/lastseen":
    //             echo "[] last seen: ";
    //             $w->sendGetRequestLastSeen($target);
    //             break;
    //         default:
    //             $w->sendMessage($target , $line);
    //             break;
    //     }
    }
}
		

}