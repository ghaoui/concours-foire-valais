<?php 
switch ($code['prix']) {
	case 'casquette':
		$px = "Un verre de blanc";
		break;
	case 'sonnette':
		$px = "UNE SONNETTE";
		break;
	case 'stylo':
		$px = "UN STYLO";
		break;
}
$body = ' <table align="center" width="850" border="0" cellspacing="0" cellpadding="0"> 
      <tr > 
        <td >
            <img src="'.$config['host_uri'].'images/bgmail.png" >
        </td>
      </tr> 
      <tr> 
        <td > 
          <br/>
          <h4 style="color: #fe2004; font-size: 40px;">BRAVO ! VOUS AVEZ GAGNÉ</h4>
          <div style="border: 1px solid #000;color: #000; font-size: 21px;margin-bottom: 30px;margin-top: 30px;padding: 25px;width: 23%; margin-left: 250px;">
             '.$px.'
          </div>
          <br/>
          <p>Présentez votre code gagnant à notre stand i11 (tente intérieure) :</p>
          <h3 style="font-size: 30px;" >'.$code["code"].'</h3>
          <p>N’oubliez pas : tenez-vous prêt pour le tirage au sort final qui aura lieu le 12 octobre.</p>
          <p>Vous remporterez peut-être un séjour VTT à Verbier durant l’été 2016</p>
          <br/>
          <p>Les gagnants seront contactés directement par email!</p>
          <br/>
          <p >Bonne chance et à bientot!</p>
          <p style="font-size:18px;">Le Team de Verbier</p>
        </td> 
      </tr> 
    </table> ';
?>