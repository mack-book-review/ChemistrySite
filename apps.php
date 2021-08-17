<!DOCTYPE html>
<html>
<head>


<meta http-equiv = "Content-type" content = "text/html; charset = utf-8"> <title>Sample HTML5 File</title>

<style>
	#game-container{
		width:  90%;
		height:  50em;
		margin:  0 auto;
		background-color: orange;
		border:  none 2px solid;
	}
</style>


<script src="js/animation.js"></script>
<script src="js/position.js"></script>
<script src="js/velocity.js"></script>
<script src="js/physicsbody.js"></script>
<script src="js/sprite.js"></script>
<script src="js/player.js"></script>
<script src="js/alien.js"></script>
<script src="js/spritegenerator.js"></script>
<script src="js/game.js"></script>
<script type = "text/javascript" charset = "utf-8">

            // This function will be called once the page loads completely
            function pageLoaded(){

				var gameContainer = document.getElementById("game-container");
				var game = new Game(gameContainer,640,480);
				//game.loadBackgroundMusic("polka_train.ogg");

				var player = new Sprite("assets/Meteors/spaceMeteors_001.png",0,0,40,30);

				game.addSprite(player);



				game.startGame();
			}



        </script>
    </head>
    <body onload = "pageLoaded();">

    	<div id="game-container">

    	</div>


    </body>


</html>