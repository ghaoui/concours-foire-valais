<?php 

	session_start();
	require 'mysql.class.php';
	$config = @parse_ini_file('config.db.ini');
	$db = new MySQL();
	if (! $db->Open($config['database'], $config['host'] , $config['user'], $config['password'])) {
	    $db->Kill();
	}
	$task= "";
	if(isset($_POST['task']))$task = $_POST['task'];
	if(isset($_GET['task']))$task = $_GET['task'];

	if($task == 'subscription'){
		$sql="select * from users where email='".$_POST['email']."'";
		$verifmail = $db->QuerySingleRowArray($sql,MYSQLI_ASSOC);
		if(empty($verifmail)){
			$sql = "insert into users (nom,prenom,cp,email,newsletter) values('".$_POST['nom']."','".$_POST['prenom']."','".$_POST['cp']."','".$_POST['email']."','".$_POST['newsletter']."')";
			if ($db->Query($sql)) {
				$id =  $db->GetLastInsertID();
				$_SESSION['iduser'] = $id;
				$_SESSION['email'] = $_POST['email'];
				echo 'success subscription';
			} else {
				echo 'error subscription';	
			}
		}else{
			echo 'existed mail';
		}
	}
	if($task == "getprix"){
		$image = 'perdu';
		$prix = "none";
		$randomCode = 'perdu';
		function updateIni($config){
			$content ="";
			foreach ($config as $key => $value) {
				$content.=$key.' = '.$value."\n";
			}
			$handle = fopen("config.ini", "w");
			fclose($handle);
			@file_put_contents('config.ini', $content);
		}
		$config = @parse_ini_file('config.ini');
		$jour = date('d-m-Y'); 
		if($jour != $config['date']){
			$config['date'] = $jour;
			$config['nbGagneJour'] = 0;
			$config['posGagnant'] = rand(1,$config['nbJoueurParGagnant']);
			$config['posEncour'] = 1;
			$config['nbcasquettesgagnant'] = 0;
			$config['nbsonnettesgagnant'] = 0;
			$config['nbstylosgagnant'] = 0;
			updateIni($config);
		}

		if($config['nbGagneJour'] < $config['maxGagnant']){
			if($config['posEncour'] == $config['posGagnant']){
				
				if($config['nbcasquettesgagnant'] < $config['maxcasquettes'] ){
					$prix = "casquette";
					$config['nbcasquettesgagnant']++;
				}elseif($config['nbsonnettesgagnant'] < $config['maxsonnettes']){
					$prix = "sonnette";
					$config['nbsonnettesgagnant']++;
				}elseif($config['nbstylosgagnant'] < $config['maxstylos']){
					$prix = "stylo";
					$config['nbstylosgagnant']++;
				}
				if($prix!="none"){
					$image = 'gagner';
					$config['nbTotalGagne']++ ;
					$config['nbGagneJour']++ ;
				}						
			}
			$config['posEncour'] = $config['posEncour']  + 1 ;
			@file_put_contents('encour.ini', $config['posEncour']);
			if($config['posEncour'] > $config['nbJoueurParGagnant']){
					$config['posEncour'] = 1;
					$config['posGagnant'] = rand(1,$config['nbJoueurParGagnant']);
				}
			
			updateIni($config);
		}
		echo $image.'-/-'.$prix;
	}
	if($task == "setprix"){
		$etat = $_POST['etat'];
		$prix = $_POST['prix'];
		$id= $_SESSION['iduser'];
		$email = $_SESSION['email'];
		if($etat == "perdu"){// envoi email perdu
			include 'perdu.php';
			$subject ="joueur perdu";
			//echo $subject;
		}else{// envoi email gagner
			$req="select * from codes where prix='".$prix."' and utiliser=0 limit 1";
			$code = $db->QuerySingleRowArray($req,MYSQLI_ASSOC);
			$update['idcode'] = MySQL::SQLValue($code["id"], "integer");
			include 'gagner.php';
			$subject ="joueur gagner";
				/*************************************************/
				$up['utiliser'] = MySQL::SQLValue(1, "integer");
				$whr['id'] = MySQL::SQLValue($code["id"], "integer");// update code utiliser
				$res = $db->UpdateRows("codes", $up, $whr);
				/************************************************/
			echo $code['code'];
		}
		$update["etat"]  = MySQL::SQLValue($etat);
        $where["id"] = MySQL::SQLValue($id, "integer");
        $result = $db->UpdateRows("users", $update, $where);
        envoiMail($email, $subject, $body);
	}
	
	function envoiMail($to,$subject,$body){
		require 'PHPMailer-master/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'saad.com.tn@gmail.com';                 // SMTP username
		$mail->Password = 'saad.com.tn123456';                           // SMTP password
		$mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->setFrom('saad.com.tn@gmail.com', 'SAAD');
		$mail->addAddress($to);     // Add a recipient
		$mail->addReplyTo('saad.com.tn@gmail.com', 'Information');
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->send();
		/*if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}*/
	}
?>