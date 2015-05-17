<?php namespace App\Http\Controllers;
use Request;
use App\customer;

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
		//$this->middleware('auth');
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
		$i = 1;
		$w->sendSetProfilePicture("http://upload.wikimedia.org/wikipedia/en/thumb/d/d3/Starbucks_Corporation_Logo_2011.svg/1017px-Starbucks_Corporation_Logo_2011.svg.png");

		//while ($i++ < 4) {
		while (1) {


    		$w->pollMessage();
    		$msgs = $w->getMessages();
    		foreach ($msgs as $m) {
    			
		        
		        
		        $tel = explode("@",$m->getAttribute("from"))[0];
    			
		        $message=$m->getChild('body');
		        $message=$message->getData();
		        $w->sendMessage($tel, "Tu telefono es: " . $tel);
		        $customer = customer::where('phone', '=', $tel)->first();


		        $personalization = $customer->personalizations->max('transaction');

		        if ($personalization) {
		        	$step = $personalizations->step;
		        	
		        } else {
		        	
		        	$step = 0;
		        }


		        if ($customer) {
		        		// Get the last step that the client is working on and save it in $stepNumber
		        		$transactionNumber = $customer->transaction;

		        		// If the customer is already registered in, then we have to know in which step he was working on
		        		// We then select the step that the customer has a 
		        		
		        		if ($personalization) {
				        	$stepNumber = $personalizations->step;
				        	
				        } else {
				        	if ($message == "1") {
				        		$personalization = personalization::create(['code' => ' ', 'modality' => ' ', 'type' => ' ', 'option' => ' ', 'size' => ' ', 'milk' => ' ', 'transaction' =>  $customer->transaction, 'step' => '1']);
	        					$w->sendMessage($tel, "Que tipo de bebida quisiera ordenar? \n 1) Frio \n 2) Caliente" . $tel);
				        		$stepNumber = 1;
				        	} else {
				        		$w->sendMessage($tel, "Bienvenidos al sistema inteligente de Starbucks. Para usar el servicio tan solo responda las preguntas que se le harán y seleccione la opcion o la palabra que desea. \n 1) continuar \n 2) salir");	

				        	}
				        }


		        		switch ($stepNumber) {
		      
		        			case '1':
		        				# Screen asking for the type of the coffe cold or hot
		        				if ($message == 'frio' || $message == 'caliente' ) {

	        						// Query the modality from the personalization
		        					$modality = $personalization->modality;
		        					// Query the types given the modality
		        					$types = $modality->types();

	        						// Loop from the available types and append them to a variable to display to the user
		        					$answer = '\n';
		        					foreach ($types as $key => $value) {
		        						
		        						$answer .=  $key + 1 . ') ' . $value . '\n';
		        					}

		        					// Send the message to the user with the beberage types
		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);

		        					// Update the modality that was chosen by the user and update the step in which the user is on 
		        					$personalization->update(['modality' => $message, 'step' => 2]);

		        				} else {
		        					// When the user did not answer what was expected, send him the same message again 
		        					$w->sendMessage($tel, "Que tipo de bebida quisiera ordenar? \n 1) Frio \n 2) Caliente");

		        				}
		        				break;
	        				case '2':
	        					# Screen asking for type of beberage, expresso, chocolate, tee, coffe
	        					# If you get to this screen, then save the answer to the question of what type of coffe
	        					
	        					// Query the modality from the personalization
	        					$modality = $personalization->modality;
	        					// Query the types given the modality
	        					$types = $modality->types();

	        					// Check if the message inputed by the user is found in all the available types 
	        					if (in_array($message, $types)) {
									
									// Query the options available from the given types		        					
		        					$options = $types->options();

		        					// Loop from the available options and append them to a variable to display to the user
		        					$answer = '\n';
		        					foreach ($types as $key => $value) {
		        						
		        						$answer .=  $key + 1 . ') ' . $value . '\n';
		        					}

		        					// Send the message to the user with the possible options
		        					$w->sendMessage($tel, "Que opción desea? " . $answer);

		        					// Update the type that was chosen by the user and update the step to the next screen
		        					$personalization->update(['type' => $message, 'step' => 3]);


		        				} else {

	        						// The answer was not correct, loop from the availabele types and append them to a variable
		        					$answer = '\n';
		        					foreach ($types as $key => $value) {
		        						
		        						$answer .=  $key + 1 . ') ' . $value . '\n';
		        					}

		        					// Resend the message to the user asking the type for his choice.
		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);

		        				}

	        					break;
        					case '3':		
        						# Screen asking for the size of beberage
        						// Query the type from the personalization previously chosen
	        					$type = $personalization->type;
	        					// Query the options available from the given types
	        					$options = $type->options();

	        					// Check if the message inputed by the user is found in all the available options 
	        					if (in_array($message, $options)) {
	        						
	        						// Send the message to the user with the possible sizes
		        					$w->sendMessage($tel, "¿Qué tamaño desea? \n 1) Alto \n 2) Grande \n 3) Venti");

		        					// Update the option that was chosen by the user and send them to the next screen
		        					$personalization->update(['option' => $message, 'step' => 4]);

		        				} else {

		        					
		        					$answer = '\n';
		        					foreach ($types as $key => $value) {
		        						
		        						$answer .=  $key + 1 . ') ' . $value . '\n';
		        					}
		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);

		        				}


        						break;
    						case '4':
    							# Screen asking for the type of milk 
    							break;
							case '5':
								# Screen asking for the syrup tipe
								break;
							case '6':
								# Screen asking for the toppings
								break;
							case '7':	
								# Screen showing the final order with the total to be paid
								break;
		        			default:
		        				# code...
		        				break;
		        		}

		        } else {
		        		// First time the user uses the service
		        		// Register the user given the phone number
		        		$customer = customer::create(['phone' => $tel, 'transaction' => 1]);
		        		
		        		// This is the second transaction (second screen)
		        		$w->sendMessage($tel, "Bienvenidos al sistema inteligente de Starbucks. Para usar el servicio tan solo responda las preguntas que se le harán y seleccione la opcion o la palabra que desea. \n 1) continuar \n 2) salir" . $tel);
        				

		        }
		        
		        
        		

		        $user = customer::all()->toArray();
		        var_dump("Hola", $user);

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