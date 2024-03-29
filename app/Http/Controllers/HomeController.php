<?php namespace App\Http\Controllers;
use Request;
use App\customer;
use App\modality;
use App\type;
use App\topping;
use App\syrup;
use App\milk;
use App\shot;
use App\order;
use App\option;
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

		        		//$personalization = personalization::where('transaction', '=', $transaction)->first();

		        		$personalization = $customer->personalizations()->where('transaction', $transaction)->first(); 
		        		// personalization::where('phone','=',$tel)->count();
///		        		$w->sendMessage($tel, "Tu telefono es: " . $transaction);
		        		//$personalization = $customer->personalizations()->max('transaction');
		        		// Get the last step that the client is working on and save it in $stepNumber

		        		
		        		// If the customer is already registered in, then we have to know in which step he was working on
		        		// We then select the step that the customer has a 
		        		$stepNumber=1;
		        		if ($personalization) {
				        	$stepNumber = $personalization->step;
				        	
				        } else {
				        	if ($message == "1") {
				        		$customer->personalizations()->save( new personalization(array('code' => ' ', 'modality' => ' ', 'type' => ' ', 'option' => ' ', 'size' => ' ', 'milk' => ' ', 'step' => '1', 'foam' => ' ', 'temperature' =>  ' ', 'transaction' =>'1')));

				        		$transaction = $customer->personalizations()->count();
				        		$personalization = $customer->personalizations()->where('transaction', $transaction)->first(); 	
				        		
				        		//$personalization = personalization::where('transaction', '=', $transaction)->first();
				        		//$w->sendMessage($tel, "Que tipo de bebida quisiera ordenar? \n 1) Frio \n 2) Caliente");
				        		$stepNumber = 1;

				        	} else {
				        		$w->sendMessage($tel, "Bienvenidos al sistema inteligente de Starbucks. Para usar el servicio tan solo responda las preguntas que se le harán y seleccione la opcion o la palabra que desea. \n 1) continuar \n 2) salir");	

				        	}
				        }


		        		switch ($stepNumber) {
		      				case '0':
		      					if ($message == '1' || $message == '2' ) {

	      							// Query the modality from the personalization
	        						if($message==1) {
	        							$modality=modality::where('name' ,'=','Frio')->first();
	        						}
	        						else{
	        							$modality=modality::where('name' ,'=','Caliente')->first();
	        						}
		        					// Query the types given the modality
		        					$types = $modality->types;

	        						// Loop from the available types and append them to a variable to display to the user
		        					$answer = "\n ";
		        					$i=1;
		        					foreach ($types as $key ) {
		        						$answer .=  $i . ') ' . $key->name .  " \n ";
		        						$i++;
		        					}

		        					// Send the message to the user with the beberage types
		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);
		        					

		        					if ($message == 1 ) {
		        						$personalization->update(['modality' => "Frio", 'step' => 2]);
		        						
		        					} else {
		        						$personalization->update(['modality' => "Caliente", 'step' => 2]);

		        					}
		      							
		      					} else {
		        					$w->sendMessage($tel, "Que tipo de bebida quisiera ordenar? \n 1) Frio \n 2) Caliente");
		      					}

	      					break;
		        			case '1':
		        				# Screen asking for the type of the coffe cold or hot
		        				if ($message == '1' || $message == '2' ) {


		        					// Send the message to the user with the beberage types
		        					
		        					$w->sendMessage($tel, "Que tipo de bebida quisiera ordenar? \n 1) Frio \n 2) Caliente");
		        					$personalization->update(['step' => 0]);

		        				} else {
		        					// When the user did not answer what was expected, send him the same message again 
									$w->sendMessage($tel, "Bienvenidos al sistema inteligente de Starbucks. Para usar el servicio tan solo responda las preguntas que se le harán y seleccione la opcion o la palabra que desea. \n 1) continuar \n 2) salir");			      						

		        				}
		        				break;
	        				case '2':
	        					# Screen asking for type of beberage, expresso, chocolate, tee, coffe
	        					# If you get to this screen, then save the answer to the question of what type of coffe
	        					
	        					// Query the modality from the personalization
	        					$modality = $personalization->modality;
	        					var_dump("modalityyyy",$modality);
	        					$modality = modality::where('name','=',$modality)->first();
	        					// Query the types given the modality
	        					$types = $modality->types;

	        					$found = false;
	        					$i = 1;
	        					foreach ($types as $key) {
	        						if ($i == $message) {
	        							$typeFound = $key->name;
	        							$found = true;
	        						}
	        						$i++;
	        					}
	        					// Check if the message inputed by the user is found in all the available types 
	        					if ($found) {
									var_dump("Estooooo", $typeFound, "Antes");
									
									$type = type::where('name','=',$typeFound)->first();
									// Query the options available from the given types		        					
		        					$options = $type->options;

		        					// Loop from the available options and append them to a variable to display to the user
		        					$answer = " \n ";
		        					$i = 1;
		        					foreach ($options as $key) {
		        						$answer .=  $i  . ') ' . $key->name . " \n ";
		        						$i++;
		        					}

		        					// Send the message to the user with the possible options
		        					$w->sendMessage($tel, "Que opción desea? " . $answer);

		        					// Update the type that was chosen by the user and update the step to the next screen
		        					$personalization->update(['type' => $typeFound, 'step' => 3]);


		        				} else {

	        						// The answer was not correct, loop from the availabele types and append them to a variable
		        					$answer = " \n ";
		        					$i=1; 
		        					foreach ($types as $key ) {
		        						
		        						$answer .=  $i . ') ' . $key->name . " \n ";
		        						$i++;
		        					}

		        					// Resend the message to the user asking the type for his choice.
		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);

		        				}

	        					break;
        					case '3':		
        						# Screen asking for the size of beberage
        						// Query the type from the personalization previously chosen
	        					$type = type::where('name','=',$personalization->type)->first();
	        					
								// Query the options available from the given types		        					
	        					$options = $type->options;

	        					$i = 1;
	        					$found = false;
	        					foreach ($options as $key) {
	        						if ($i == $message) {
	        							$optionFound = $key->name;
	        							$found = true;
	        						}
	        						$i++;
	        					}
	        					// Check if the message inputed by the user is found in all the available options 
	        					if ( $found ) {
	        						



	        						// Send the message to the user with the possible sizes
		        					$w->sendMessage($tel, "¿Qué tamaño desea? \n 1) Alto \n 2) Grande \n 3) Venti");

		        					// Update the option that was chosen by the user and send them to the next screen
		        					$personalization->update(['option' => $optionFound, 'step' => 4]);

		        				} else {

		        					// The answer was not correct, loop from the availabele types and append them to a variable
		        					$answer = " \n ";
		        					$i=1;
		        					foreach ($options as $key ) {
		        						
		        						$answer .=  $i . ') ' . $key->name . " \n ";
		        						$i++;
		        					}

		        					$w->sendMessage($tel, "Que tipo de bebida?" .  $answer);

		        				}
        						break;
    						case '4':
    							# Screen asking for the type of milk 
    							
    							$sizes = array("1" => "Alto", "2" => "Grande", "3"=>"Venti");
    							$i = 1;
    							$found = false;
	        					foreach ($sizes as $key) {
	        						if ($i == $message) {
	        							$sizeFound = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}

    							// Check if the message inputed is an actual size 
    							if ( $found){

    								// Query all the types of milk available and append them to a variable
    								$milk = milk::orderBy('name', 'asc')->get();
    								$answer = " \n ";
    								$i = 1;
		        					foreach ($milk as $key) {
		        						$answer .=  $i . ') ' . $key->name . " \n ";
		        						$i++;
		        					}

    								// Send the message to the user with the possible milk
    								$w->sendMessage($tel, "¿Qué leche desea?" . $answer);

    								// Update the size that was chosen by the user and send them to the next screen
		        					$personalization->update(['size' => $sizeFound, 'step' => 5]);


    							} else {
    								$w->sendMessage($tel, "¿Qué tamaño desea? \n 1) Alto \n 2) Grande \n 3) Venti");

    							}
    							break;
							case '5':
								# Screen asking for the toppings tipe
								

								// Select the key index of the milk in the array
								$milk = milk::orderBy('name', 'asc')->get();
								$i = 1;
								$found = false;
	        					foreach ($milk as $key) {
	        						if ($i == $message) {
	        							$milk = $key->name;
	        							$found = true;
	        						}
	        						$i++;
	        					}

								// Check if the given messege is an actual milk
								if ($found) {

									// Query all the possible and append it to a variable
									$toppings = topping::orderBy('name','asc')->get();
									$answer = " \n ";
	        						$i = 1;
		        					foreach ($toppings as $key) {
		        						$answer .=  $i . ') ' . $key->name . " \n ";
		        						$i++;
		        					}


									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué toppings desea? \n  Ejemplo: 1,1 \n " . $answer);									
									
    								


									// Update the milk that was chosen by the user and send them to the next screen
									$personalization->update(['milk' => $milk, 'step' => 6]);

								} else {

									// Query all the types of milk available and append them to a variable
    								$answer = " \n ";
    								$i = 1;
		        					foreach ($milk as $key) {
		        						$answer .=  $i . ') ' . $key->name . " \n ";
		        						$i++;
		        					}

    								// Send the message to the user with the possible milk
    								$w->sendMessage($tel, "¿Qué leche desea?" . $answer);

								}
								break;
							case '6':
								# Screen asking for the syrup
								
								$input = explode(",", $message);

								// check if the delimeter was found
								if ($input) {

									if (sizeof($input) >= 2) {

									$toppingKey = $input[0];
									$toppingAmount =  $input[1];

									if (!is_numeric($toppingAmount)) {
										$toppingAmount = 1;
									}




										$toppings = topping::orderBy('name', 'asc')->get();
										$found = false;
										$i = 1;

			        					foreach ($toppings as $key) {
			        						if ($i == $toppingKey) {
			        							$topping = $key->name;
			        							$found = true;
			        						}
			        						$i++;
			        					}



										// Check if the given messege is an actual topping
										if ( $found ) {
											
											// Query all the possible syrup and append it to a variable
			
				        					$syrups = syrup::orderBy('name','asc')->get();
											$answer = " \n " ;
			        						$i = 1;
				        					foreach ($syrups as $key) {
				        						$answer .=  $i . ') ' . $key->name . " \n " ;
				        						$i++;
				        					}


											// Send the message to the user with the possible toppings
		    								$w->sendMessage($tel, "¿Qué jarabe desea? (Escribir  [numero], [cantidad] )" . $answer);

											
											$personalization->personalizationToppings()->create(['name' =>  $topping, 'amount' => $toppingAmount]);
											$personalization->update(['step' => 7]);

										} else {

											// The inputed topping did not match any option
		    								
		    								$toppings = topping::orderBy('name','asc')->get();
											$answer = " \n ";
			        						$i = 1;
				        					foreach ($toppings as $key) {
				        						$answer .=  $i . ') ' . $key->name . " \n ";
				        						$i++;
				        					}


											// Send the message to the user with the possible toppings
		    								$w->sendMessage($tel, "¿Qué toppings desea? \n  Ejemplo: 1,1 \n " . $answer);									
											

										}
									} else  {
										// The inputed topping did not match any option
		    								
	    								$toppings = topping::orderBy('name','asc')->get();
										$answer = " \n ";
		        						$i = 1;
			        					foreach ($toppings as $key) {
			        						$answer .=  $i . ') ' . $key->name . " \n ";
			        						$i++;
			        					}

										// Send the message to the user with the possible toppings
	    								$w->sendMessage($tel, "¿Qué toppings desea? \n  Ejemplo: 1,1 \n " . $answer);		
									}
								}
								break;
							case '7':	
								# Screen asking for the shot desired
								

								$input = explode(",", $message);


								// check if the delimeter was found
								if ($input) {

									if (sizeof($input) >= 2) {
										$syrupKey = $input[0];
										$syrupAmount =  $input[1];

										if (!is_numeric($syrupAmount)) {
											$syrupAmount = 1;
										}

										$syrups = syrup::orderBy('name', 'asc')->get();
										$found = false;
										$i = 1;
			        					foreach ($syrups as $key) {
			        						if ($i == $syrupKey) {
			        							$syrup = $key->name;
			        							$found = true;
			        						}
			        						$i++;
			        					}


										// Check if the given messege is an actual topping
										if ( $found ) {
											
											// Query all the possible syrup and append it to a variable
			
				        					$shots = shot::orderBy('name','asc')->get();
											$answer = " \n " ;
			        						$i = 1;
				        					foreach ($shots as $key) {
				        						$answer .=  $i . ') ' . $key->name . " \n ";
				        						$i++;
				        					}


											// Send the message to the user with the possible toppings
		    								$w->sendMessage($tel, "¿Qué shot desea? \n  Escribir  [numero], [cantidad] )" . $answer);

											
											$personalization->personalizationSyrups()->Create(['name' =>  $syrup, 'amount' => $syrupAmount]);
											$personalization->update(['step' => 8]);

										} else {

															// The inputed topping did not match any option
		    								
		    								$answer = " \n ";
			        						$i = 1;
				        					foreach ($syrups as $key) {
				        						$answer .=  $i . ') ' . $key->name . " \n ";
				        						$i++;
				        					}

											// Send the message to the user with the possible syrups
		    								$w->sendMessage($tel, "¿Qué jarabe desea?  \n  Ejemplo: 1,1 \n" . $answer);


										}
									} else {

	    								$answer = " \n ";
		        						$i = 1;
			        					foreach ($syrups as $key) {
			        						$answer .=  $i . ') ' . $key->name . " \n ";
			        						$i++;
			        					}

										// Send the message to the user with the possible syrups
	    								$w->sendMessage($tel, "¿Qué jarabe desea?  \n  Ejemplo: 1,1 \n " . $answer);
									
									} 
								} else {

	    								$answer = " \n ";
		        						$i = 1;
			        					foreach ($syrups as $key) {
			        						$answer .=  $i . ') ' . $key->name . " \n ";
			        						$i++;
			        					}

										// Send the message to the user with the possible syrups
	    								$w->sendMessage($tel, "¿Qué jarabe desea?  \n  Ejemplo: 1,1 \n " . $answer);
								}
								break;
							case '8':
								# Screen asking for the temperature 
								
								$input = explode(",", $message);
								// check if the delimeter was found
								if ($input) {

									if (sizeof($input) >= 2) {

										$shotKey = $input[0];
										$shotAmount =  $input[1];

										if (!is_numeric($shotAmount)) {
											$shotAmount = 1;
										}

										$shots = shot::orderBy('name', 'asc')->get();
										$found = false;
										$i = 1;
			        					foreach ($shots as $key) {
			        						if ($i == $shotKey) {
			        							$shot = $key->name;
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
		    								$answer = " \n ";
			        						$i = 1;
				        					foreach ($shots as $key) {
				        						$answer .=  $i . ') ' . $key->name . " \n ";
				        						$i++;
				        					}

											// Send the message to the user with the possible toppings
		    								$w->sendMessage($tel, "¿Qué shot desea? \n (Escribir  [numero], [cantidad] )" . $answer);


										}
									} else {
										// The inputed topping did not match any shot
	    								$answer = " \n ";
		        						$i = 1;
			        					foreach ($shots as $key) {
			        						$answer .=  $i . ') ' . $key->name . " \n ";
			        						$i++;
			        					}

										// Send the message to the user with the possible toppings
	    								$w->sendMessage($tel, "¿Qué shot desea? \n (Escribir  [numero], [cantidad] )" . $answer);

									}
								} else {
									// The inputed topping did not match any shot
    								$answer = " \n ";
	        						$i = 1;
		        					foreach ($shots as $key) {
		        						$answer .=  $i . ') ' . $key->name . " \n ";
		        						$i++;
		        					}

									// Send the message to the user with the possible toppings
    								$w->sendMessage($tel, "¿Qué shot desea? \n (Escribir  [numero], [cantidad] )" . $answer);

								}
								

							break;
							case '9':
									# Screen asking for the foam desired
									
	    							$temperatures = array("1"=>"Frio", "2"=>"Caliente", "3" => "Extra Caliente");
	    							$i = 1;
	    							$found = true;
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
    							$found = false;
	        					foreach ($foams as $key) {
	        						if ($i == $message) {
	        							$foam = $key;
	        							$found = true;
	        						}
	        						$i++;
	        					}

	        					if ($found) {

	        						
									$personalization->update(['foam' => $foam, 'step' => 11]);
	        						
	        						// Start priting the bill 
	        						$bill = "Resumen de su orden: \n";
	        						$bill .= $personalization->option . "\n";
	        						$columna = strtolower($personalization->size);
	        						$sizeCost =  option::where('name','=', $personalization->option)->first()->$columna;
	        						
	        						
	        						$bill .= $personalization->size . "---- $" . $sizeCost . "\n"; ##########################
	        						
	        						$milkCost = milk::where('name','=', $personalization->milk)->first()->cost;
	        						$bill .= $personalization->milk . "---- $" .  $milkCost . "\n"; 
	        						$bill .= $personalization->foam . "---- $" .  "0.0" . "\n";  
	        						$bill .= $personalization->temperature . "---- $" .  "0.0" . "\n"; 

	        						$subtotal = $sizeCost + $milkCost;
        							
        							$bill .= "Subtotal: ---- $" . $subtotal;

        							// Get the possible multiple selections
	        						$syrups = $personalization->personalizationSyrups;
	        						$toppings = $personalization->personalizationToppings;
	        						$shots = $personalization->personalizationShots;

	        						
	        						$bill .= "\n Shots: \n";
	        						$shotCosts = 0.0;
	        						foreach ($shots as $key) {
	        							$cost = shot::where('name','=',$key->name)->first()->cost * $key->amount;
		        						$bill .=  $key->name . "---- $" . $cost . " \n ";
		        						$shotCosts += $cost;
		        					}

		        					$bill .= "Toppings: \n";
		        					$toppingsCost = 0.0;
		        					
	        						foreach ($toppings as $key) {
	        							$cost = topping::where('name','=',$key->name)->first()->cost * $key->amount;
		        						$bill .=  $key->name . "---- $" . $cost . " \n ";
		        						$toppingsCost += $cost;
		        					}

		        					$bill .= "Syrups: \n";
		        					$syrupsCost = 0.0;
	        						foreach ($syrups as $key) {
	        							$cost = syrup::where('name','=',$key->name)->first()->cost * $key->amount;
		        						$bill .=  $key->name . "---- $" . $cost . " \n ";
		        						$syrupsCost += $cost;
		        					}
		        					$total = $subtotal +  $shotCosts + $toppingsCost + $syrupsCost; 
	        						
		        					$bill .= "Total: ---- $" .   $total; 

    								$w->sendMessage($tel, $bill);
    								$w->sendMessage('5218117082898',$bill);

									$answer = "\n Desea confirmar su pedido? \n 1) Si \n 2) No \n";

    								$w->sendMessage($tel, $answer);
									
									
									$personalization->update(['step' => 11]);

	        					}

								break;
							case '11':
								
								if ($message == '1') {
									// confirm order
									



									$answer = "Ingrese su primer nombre ";
    								$w->sendMessage($tel, $answer);
									$personalization->update(['step' => 12]);

								} else {
									$personalization->update(['step' => 0]);
								}
								break;
							case '12':


								// Start priting the bill 


	        						$columna = strtolower($personalization->size);
	        						$sizeCost =  option::where('name','=', $personalization->option)->first()->$columna;
	        						$milkCost = milk::where('name','=', $personalization->milk)->first()->cost;

	        						$subtotal = $sizeCost + $milkCost;
        							// Get the possible multiple selections
	        						$syrups = $personalization->personalizationSyrups;
	        						$toppings = $personalization->personalizationToppings;
	        						$shots = $personalization->personalizationShots;
	        						$shotCosts = 0.0;
	        						foreach ($shots as $key) {
	        							$cost = shot::where('name','=',$key->name)->first()->cost * $key->amount;
		        						$shotCosts += $cost;
		        					}

		        					$toppingsCost = 0.0;
		        					
	        						foreach ($toppings as $key) {
	        							$cost = topping::where('name','=',$key->name)->first()->cost * $key->amount;
		        						$toppingsCost += $cost;
		        					}

		        					$syrupsCost = 0.0;
	        						foreach ($syrups as $key) {
	        							$cost = syrup::where('name','=',$key->name)->first()->cost * $key->amount;
		        						$syrupsCost += $cost;
		        					}
		        					$total = $subtotal +  $shotCosts + $toppingsCost + $syrupsCost; 


								$name = $message;
								order::create(['personalization_id' => $personalization->id, 'name' => $name, 'status' => '0', 'total' => $total]);

								$answer = "Gracias por su orden";
								$w->sendMessage($tel, $answer);
								$w->sendMessage('5218117082898',$name);
								


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