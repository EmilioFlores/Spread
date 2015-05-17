<?php namespace App\Http\Controllers;
use Request;
use App\customer;
use App\modality;
use App\personalization;

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

	public function test() {

		$frio = modality::where('name','=','Caliente')->first();
		var_dump($frio->types->toArray());	

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
		        //$w->sendMessage($tel, "Tu telefono es: " . $tel);
		        $customer = customer::where('phone', '=', $tel)->first();


		        
		        /*
		        var_dump("Perzonalization",$personalization);

		        if ($personalization) {
		        	$step = $personalizations->step;
		        	
		        } else {
		        	
		        	$step = 0;
		        }

		        */
		        if ($customer) {
		        		$transaction = $customer->personalizations()->count();

		        		$personalization = personalization::where('transaction', '=', $transaction)->first();

		        		// personalization::where('phone','=',$tel)->count();
///		        		$w->sendMessage($tel, "Tu telefono es: " . $transaction);
		        		//$personalization = $customer->personalizations()->max('transaction');
		        		// Get the last step that the client is working on and save it in $stepNumber

		        		var_dump("Perzonalization",$personalization);
		        		// If the customer is already registered in, then we have to know in which step he was working on
		        		// We then select the step that the customer has a 
		        		$stepNumber=1;
		        		if ($personalization) {
				        	$stepNumber = $personalization->step;
				        	
				        } else {
				        	if ($message == "1") {
				        		$customer->personalizations()->save( new personalization(array('code' => ' ', 'modality' => ' ', 'type' => ' ', 'option' => ' ', 'size' => ' ', 'milk' => ' ', 'step' => '1', 'foam' => ' ', 'temperature' =>  ' ', 'transaction' =>'1')));
	        					//$w->sendMessage($tel, "Que tipo de bebida quisiera ordenar? \n 1) Frio \n 2) Caliente");
				        		$stepNumber = 1;
				        	} else {
				        		$w->sendMessage($tel, "Bienvenidos al sistema inteligente de Starbucks. Para usar el servicio tan solo responda las preguntas que se le harán y seleccione la opcion o la palabra que desea. \n 1) continuar \n 2) salir");	

				        	}
				        }


		        		switch ($stepNumber) {
		      
		        			case '1':
		        				# Screen asking for the type of the coffe cold or hot
		        				if ($message == '1' || $message == '2' ) {

	        						// Query the modality from the personalization
	        						if($message==1) {
	        							$modality=modality::where('name' ,'=','Frio')->first();
	        						}
	        						else{
	        							$modality=modality::where('name' ,'=','Caliente')->first();
	        						}
		        					// Query the types given the modality
		        					$types = $modality->types()->get()->toArray();

	        						// Loop from the available types and append them to a variable to display to the user
		        					$answer = '\n';
		        					$i=1;
		        					foreach ($types as $key ) {
		        						
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
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
	        					$modality = $personalization;
	        					// Query the types given the modality
	        					$types = $modality->types();

	        					// Check if the message inputed by the user is found in all the available types 
	        					if (in_array($message, $types)) {
									
									// Query the options available from the given types		        					
		        					$options = $types->options();

		        					// Loop from the available options and append them to a variable to display to the user
		        					$answer = '\n';
		        					foreach ($options as $key => $value) {
		        						
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

		        					// The answer was not correct, loop from the availabele types and append them to a variable
		        					$answer = '\n';
		        					foreach ($options as $key => $value) {
		        						
		        						$answer .=  $key + 1 . ') ' . $value . '\n';
		        					}
		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);

		        				}
        						break;
    						case '4':
    							# Screen asking for the type of milk 
    							
    							$sizes = array("Alto", "Grande", "Venti");

    							// Check if the message inputed is an actual size 
    							if (in_array($message, $sizes) ){

    								// Query all the types of milk available and append them to a variable
    								$milk = milk::orderBy('name', 'asc')->get();
    								$answer = '\n';
    								$i = 1;
		        					foreach ($milk as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}

    								// Send the message to the user with the possible milk
    								$w->sendMessage($tel, "¿Qué leche desea?" . $answer);

    								// Update the size that was chosen by the user and send them to the next screen
		        					$personalization->update(['size' => $message, 'step' => 5]);


    							} else {
    								$w->sendMessage($tel, "¿Qué tamaño desea? \n 1) Alto \n 2) Grande \n 3) Venti");

    							}
    							break;
							case '5':
								# Screen asking for the toppings tipe
								

								// Select the key index of the milk in the array
								$milk = milk::orderBy('name', 'asc')->get();
								$i = 1;
	        					foreach ($milk as $key) {
	        						if ($i == $message) {
	        							$milk = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}

								// Check if the given messege is an actual milk
								if ($found) {

									// Query all the possible and append it to a variable
									$toppings = topping::orderBy('name','asc')->get();
									$answer = '\n';
	        						$i = 1;
		        					foreach ($toppings as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}


									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué toppings desea?" . $answer);									
									
    								


									// Update the milk that was chosen by the user and send them to the next screen
									$personalization->update(['milk' => $milk, 'step' => 6]);

								} else {

									// Query all the types of milk available and append them to a variable
    								$answer = '\n';
    								$i = 1;
		        					foreach ($milk as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}

    								// Send the message to the user with the possible milk
    								$w->sendMessage($tel, "¿Qué leche desea?" . $answer);

								}
								break;
							case '6':
								# Screen asking for the syrup
								
								$input = explode(",", $message);
								$toppingKey = $input[0];
								$toppingAmount =  $input[1];

								$toppings = topping::orderBy('name', 'asc')->get();
								$i = 1;
	        					foreach ($toppings as $key) {
	        						if ($i == $toppingKey) {
	        							$topping = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}



								// Check if the given messege is an actual topping
								if ( $found ) {
									
									// Query all the possible syrup and append it to a variable
	
		        					$syrups = syrup::orderBy('name','asc')->get();
									$answer = '\n';
	        						$i = 1;
		        					foreach ($syrups as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}


									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué jarabe desea?" . $answer);

									
									$personalization->personalizationTopping()->create(['name' =>  $topping, 'amount' => $toppingAmount]);
									$personalization->update(['step' => 7]);

								} else {

									// The inputed topping did not match any option
    								
    								$answer = '\n';
	        						$i = 1;
		        					foreach ($toppings as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}

    								// Send the message to the user with the possible syrup
    								$w->sendMessage($tel, "¿Qué leche desea?" . $answer);

								}
								break;
							case '7':	
								# Screen asking for the shot desired
								

								$input = explode(",", $message);
								$syrupKey = $input[0];
								$syrupAmount =  $input[1];


								$syrups = syrup::orderBy('name', 'asc')->get();
								$i = 1;
	        					foreach ($syrups as $key) {
	        						if ($i == $syrupKey) {
	        							$syrup = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}


								// Check if the given messege is an actual topping
								if ( $found ) {
									
									// Query all the possible syrup and append it to a variable
	
		        					$shots = shot::orderBy('name','asc')->get();
									$answer = '\n';
	        						$i = 1;
		        					foreach ($shots as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}


									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué shot desea?" . $answer);

									
									$personalization->personalizationSyrup()->Create(['name' =>  $syrup, 'amount' => $syrupAmount]);
									$personalization->update(['step' => 8]);

								} else {

													// The inputed topping did not match any option
    								
    								$answer = '\n';
	        						$i = 1;
		        					foreach ($syrups as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}

									// Send the message to the user with the possible syrups
    								$w->sendMessage($tel, "¿Qué jarabe desea?" . $answer);


								}
								break;
							case '8':
								# Screen asking for the temperature 
								
								$input = explode(",", $message);
								$shotKey = $input[0];
								$shotAmount =  $input[1];


								$shots = shot::orderBy('name', 'asc')->get();
								$i = 1;
	        					foreach ($shots as $key) {
	        						if ($i == $shotKey) {
	        							$shot = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}


								// Check if the given messege is an actual topping
								if ( $found ) {
									

									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué temperatura desea? \n 1) Frio \n 2) Caliente \n 3) Extra caliente");

									
									$personalization->personalizationShots()->Create(['name' =>  $shot, 'amount' => $shotAmount]);
									$personalization->update(['step' => 9]);

								} else {

									// The inputed topping did not match any shot
    								$answer = '\n';
	        						$i = 1;
		        					foreach ($shots as $key) {
		        						$answer .=  $i . ') ' . $key->name . '\n';
		        						$i++;
		        					}

									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué shot desea?" . $answer);


								}
							case '9':
									# Screen asking for the foam desired
									
	    							$temperatures = array("1"=>"Frio", "2"=>"Caliente", "3" => "Extra Caliente");
	    							$i = 1;
		        					foreach ($temperatures as $key) {
		        						if ($i == $message) {
		        							$temperature = $key;
		        							$found = true;
		        						}
		        						$i++;
		        					}


	    							// Check if the message inputed is an actual size 
	    							if ($found) {


	    								$w->sendMessage($tel, "¿Qué espuma desea? \n 1) Sin Espuma \n 2) Poca Espuma \n 3) Normal \n 4) Mucha Espuma ");

	    								// Update the size that was chosen by the user and send them to the next screen
			        					$personalization->update(['temperature' => $temperature, 'step' => 10]);

    								} else {

    									$w->sendMessage($tel, "¿Qué temperatura desea? \n 1) Frio \n 2) Caliente \n 3) Extra caliente");
    								}


							break;
							case '10':
								

    							$foams = array("1"=>"Sin Espuma", "2"=>"Poca Espuma", "3" => "Normal", "4" => "Mucha Espuma");

    							// Check if the message inputed is an actual size 
    							$i = 1;
	        					foreach ($foams as $key) {
	        						if ($i == $message) {
	        							$foam = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}

	        					if ($found) {

	        						
	        						
	        						// Start priting the bill 
	        						$bill = "Resumen de su orden: \n";
	        						$bill .= $personalization->option . "\n";
	        						$sizeCost =  option::where('name','=', $personalization->option)->$personalization->size;
	        						$bill .= $personalization->size . "\t" . $sizeCost . "\n"; ##########################
	        						
	        						$milkCost = milk::where('name','=', $personalization->milk)->$cost;
	        						$bill .= $personalization->milk . "\t" .  $milkCost . "\n"; 
	        						$bill .= $personalization->foam . "\t" .  "0.0" . "\n";  
	        						$bill .= $personalization->temperature . "\t" .  "0.0" . "\n"; 

	        						$subtotal = $sizeCost + $milkCost;
        							$bill .= "Subtotal: \t " . $subtotal;

        							// Get the possible multiple selections
	        						$toppings = $personalization->personlaizationToppings();
	        						$syrups = $personalization->personlaizationSyrups();
	        						$shots = $personalization->personalizationShots();

	        						$bill .= "Shots: \n";
	        						$shotCosts = 0.0;
	        						foreach ($shots as $key) {
		        						$bill .=  $key->name . "\t" . $key->cost . "\n";
		        						$shotCosts += $key->cost;
		        					}

		        					$bill .= "Toppings: \n";
		        					$toppingsCost = 0.0;
	        						foreach ($toppings as $key) {
		        						$bill .=  $key->name . "\t" . $key->cost . "\n";
		        						$toppingsCost += $key->cost;
		        					}

		        					$bill .= "Syrups: \n";
		        					$syrupsCost = 0.0;
	        						foreach ($syrups as $key) {
		        						$bill .=  $key->name . "\t" . $key->cost . "\n";
		        						$syrupsCost += $key->cost;
		        					}
		        					$total = $subtotal +  $shotCosts + $toppingsCost + $syrupsCost; 
		        					$bill .= "Total: \t" .   $total; 

    								$w->sendMessage($tel, $bill);

									
									$personalization->personalizationShots()->Create(['name' =>  $shot, 'amount' => $shotAmount]);
									$personalization->update(['step' => 9]);

	        					}

								break;
		        			default:
		        				# code...
		        				break;
		        		}

		        } else {
		        		// First time the user uses the service
		        		// Register the user given the phone number
		        		$customer = customer::create(['phone' => $tel]);
		        		
		        		// This is the second transaction (second screen)
		        		$w->sendMessage($tel, "Bienvenidos al sistema inteligente de Starbucks. Para usar el servicio tan solo responda las preguntas que se le harán y seleccione la opcion o la palabra que desea. \n 1) continuar \n 2) salir" );
        				

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