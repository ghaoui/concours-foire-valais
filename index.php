<?php 
session_start();
if(isset($_SESSION['lang'])){
  $lang = $_SESSION['lang'];
}else{
  $lang = 'fr';
  $_SESSION['lang'] = $lang;
}
if(isset($_GET['lang'])){
  $lang = $_GET['lang'];
  $_SESSION['lang'] = $lang;
}
$langFile = $lang.'-langue.ini';
$translate = @parse_ini_file('langue/'.$langFile);
?>
<!DOCTYPE html>
<html lang="en" class="html">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link href = "css/bootstrap.min.css" rel = "stylesheet">
    <link href = "css/style.css" rel = "stylesheet">
	<link type="image/vnd.microsoft.icon" rel="shortcut icon" href="favicon.ico">
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fb.js"></script>
    <script src="js/wScratchPad.js"></script>
    <script src="js/script.js"></script>
	<title>Jeu concour verbier</title>
</head>
<body class="bgverbier">
  <header id="header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 logoheader imgLogo">
          <img src="images/logo-verbier.png" alt="" class="img-responsive">
        </div>
        <div class="col-lg-6 col-md-6 hidden-xs hidden-sm logoheader tentez">
          <p>TENTEZ VOTRE CHANCE AU GRATTAGE</p>
          <p>ET DÉCOUVREZ INSTANTANÉMENT SI VOUS AVEZ GAGNÉ !</p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 ">
          <a href="" class="linkface link">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center">
                <img src="images/picto-fb.png" alt="" class="img-responsive">
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 text-center">
                <span>Suivez-nous </span>
                <span>sur facebook</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 ">
          <a href="" class="linkverb link">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center">
                <img src="images/picto-mobile.png" alt="" class="img-responsive">
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 text-center">
                <span>Restez connecté</span>
                <span>avec Verbier</span>
              </div>
            </div>
          </a>
        </div>
        <div class="hidden-lg hidden-md col-sm-12 col-xs-12 logoheader tentez">
          <p>TENTEZ VOTRE CHANCE AU GRATTAGE</p>
          <p>ET DÉCOUVREZ INSTANTANÉMENT SI VOUS AVEZ GAGNÉ !</p>
        </div>
      </div>
    </div> 
  </header>   
  <section id="conteneur">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 text-center margin-top-20">
          <img src="images/titre-jeuconcours.png" alt="" class="center-block img-responsive imgTitle">
          <div class="bgForm">
            <div class="form-group">
              <input type="text" class="form-control input-md" placeholder="Prénom" name="prenom" id="prenom">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-md" placeholder="Nom" name="nom" id="nom">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-md" placeholder="Code postal" name="cp" id="cp">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-md" placeholder="E-mail" name="email" id="email">
            </div>
            <div class="ou">OU</div>
           <fb:login-button data-scope="public_profile,email" onlogin="checkLoginState();" id="facebook-button">SE CONNECTER AVEC FACEBOOK</fb:login-button>
              <div id="fb-root"></div>
            <div class="condition text-left">
				<label>
					<input type="checkbox" id="newsletter" name="newsletter"  >&nbsp;Je souhaite recevoir les offres spéciales  de Verbier
				</label>
            </div>
            <div class="condition text-left">
				<p>
					<label>
						<input type="checkbox"   id="condition" name="condition">&nbsp;J'accepte les conditions de participation
					</label>
				</p>
            </div>
            <button type="button" class="parti btn" id="subscribeButton">C'EST PARTI !</button>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 bggray"></div>
        <div class="col-lg-4 col-md-4 col-sm-4  col-xs-12">
          <img src="images/info-large-cadeaux.png" alt="" class="img-responsive center-block superprix">
        </div>
      </div>
    </div>  
  </section>
   <footer id="footer">  
      <div class="container-fluid">
        <div class="row footer">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <ul class="list-inline">
              <li><a href="" data-toggle="modal" data-target="#creditText">Crédit</a></li>
              <li><a href="" data-toggle="modal" data-target="#mentionText">Mentions légales</a></li>
              <li><a href="" data-toggle="modal" data-target="#regleText">Réglement</a></li>
              <li><a href="" data-toggle="modal" data-target="#contactText">Contactez-nous</a></li>
            </ul>
          </div>
        </div>
      </div>
    <div id="bgloading"><img src="images/loading.gif" alt=""></div>
    <?php 
    require 'contactez.php';
    require 'mentions.php';
    require 'reglement.php';
    require 'credits.php';
    ?>
</body> 
</html>



