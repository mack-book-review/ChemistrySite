	

	class Game{

		constructor(container, screenWidth,screenHeight){
			//Initialize game settings
			this.screenWidth = screenWidth;
			this.screenHeight = screenHeight;
			this.gameLoopID = 0;
			this.frameRate = 20;

			//Initialize game states
			this.isPaused = false;
			this.isLost = false;
			this.isWon = false;

			//Initialize current background animation
			this.currrenbackgroundAnimation = null;

			//Create the container before the canvas
			this.container = container;

			//Initialize game sprites array
			this.sprites = [];

			//Instantiate the canvas before instantiating the player and other sprites
			//Sprites will require a reference to the canvas on which they are drawn
			this.createCanvasElement();
			this.context = this.canvasElement.getContext('2d');
			
			//Instantiate player
			this.createPlayer();

			//Create sprite generators
			this.spriteGenerators = [
				new AlienGenerator(this.canvasElement),
				new WingmanGenerator(this.canvasElement),
				new EvilSunGenerator(this.canvasElement),
				new EvilCloudGenerator(this.canvasElement)

			];

			//Spawn enemies
			this.spriteGenerators.forEach((generator) =>{
				generator.spawnObjects(3);
			});

			//Configure the event handler that is called when the player shoots
			this.configurePlayerShootHandler();
	
			//Create a way for player to interact with game
			InputHelper.ConfigureCanvasKeyboardControls(this);
			
			//Create UI elements
			this.createPauseButton();
			this.createInstructionsButton();
			this.createTitleBanner();
			this.createHUD();


		}

		configurePlayerShootHandler(){
			//Get references to enemy generators for playerShoot handler
			var spriteGenerators = this.spriteGenerators;
			var player = this.player;
			
			this.playerShootHandler = function(){

				spriteGenerators.forEach(function(spriteGenerator){

					spriteGenerator.checkPlayerContact(player);
				});
				
			};
		}

		checkSpritePosition(sprite,canvasElement = this.canvasElement){
			if(sprite.x < 0){
				sprite.velocityX = 5;
			}

			if(sprite.y < 0){
				sprite.velocityY = 5;
			}

			if(sprite.x > canvasElement.width - sprite.width){
				sprite.velocityX = -5;
			}

			if(sprite.y > canvasElement.height - sprite.height){
				sprite.velocityY = -5;
			}
		}




		createTitleBanner(){
			this.titleElement = UIGenerator.CreateTitleBanner("Alien Sniper Defense");
			this.addToContainer(this.titleElement);
		}

		createInstructionsButton(){
			var currentGame = this;

			this.instructionsButton = document.createElement("a");
			UIGenerator.ConfigureMenuButton(this.instructionsButton,"20%");
			var buttonText = document.createTextNode("Instructions");
			this.instructionsButton.appendChild(buttonText);
			
			var instructionsButton = this.instructionsButton;
			this.instructionsButton.addEventListener("click", 
				function(){
				

			});

			this.addToContainer(this.instructionsButton);

		}

		createPauseButton(){
			var currentGame = this;

			this.pauseButton = document.createElement("a");
			this.configureMenuButton(this.pauseButton,"10%");


			var pauseText = document.createTextNode("Pause Game");
			var resumeText = document.createTextNode("Restart Game");
			this.pauseButton.appendChild(pauseText);
			var pauseButton = this.pauseButton;
			this.pauseButton.addEventListener("click", 
				function(){
				if(!this.isPaused){
					currentGame.pauseGame();
					this.isPaused = true;
					pauseButton.removeChild(pauseText);
					pauseButton.appendChild(resumeText);
				} else {
					currentGame.startGame();
					this.isPaused = false;
					pauseButton.removeChild(resumeText);
					pauseButton.appendChild(pauseText);
				}

			});

			this.addToContainer(this.pauseButton);

		}

		hasActiveAnimation(){
			return this.currentAnimation != null;
		}

		runBackgroundAnimation(animation,callback = null){

			this.currentAnimation = animation;


			if(callback != null && typeof(callback) == "function"){
				callback();
			}
		}

		createPlayer(){

			this.player = new Player(50,50,this.canvasElement);
		}


		addSprite(sprite){
			this.sprites.push(sprite);
		}

		loadBackgroundMusic(filePath){

			var audio = document.createElement("audio");
			this.audioElement = audio;
			this.audioElement.src = filePath;
			this.container.appendChild(this.audioElement);

			audio = this.audioElement;
			this.container.addEventListener("mousemove", function () {
    			audio.play();

    		});
		}


		createCanvasElement(){
			this.canvasElement = document.createElement("canvas");
			this.configureCanvasElement(this.canvasElement);
			this.addToContainer(this.canvasElement,0);
	
		}

		configureCanvasElement(canvasElement){
			UIGenerator.ConfigureCanvas(canvasElement,this.screenWidth,this.screenHeight);

		}

		configureMenuButton(button,topDistance){
			UIGenerator.ConfigureMenuButton(button,topDistance);
		
		}

		addToContainer(element,zIndex = 0){
			element.style.zIndex = zIndex;
			this.container.appendChild(element);
		}


		drawText(someText,x,y){
			this.context.font = '16 pt Arial';
			this.context.strokeText(someText,x,y);

		}

		drawBackgroundImg(){
			var backgroundImg = new Image();
			backgroundImg.src = "assets/Backgrounds/starry_sky.jpg";

			this.context.drawImage(
				backgroundImg,
				0,0,
				backgroundImg.naturalWidth,
				backgroundImg.naturalHeight,
				0,0,
				this.screenWidth,this.screenHeight
				);
		}

		/** HUD-related Helper Functions **/
		createHUD(){
		
			this.hud = new HUD(this.container);
			this.hud.addHUD();

		}

		updateHUDSpriteCount(){
			var totalEnemies = 0;

			this.spriteGenerators.forEach(function(spriteGenerator){
				totalEnemies += spriteGenerator.getTotalSprites();
				console.log(spriteGenerator.getTotalSprites());
				
			});

			this.hud.updateEnemyCount(totalEnemies);
		}

		updateHUDKillCount(){
			var totalKills = 0;

			this.spriteGenerators.forEach(function(spriteGenerator){
				totalKills += spriteGenerator.getKillCount();
			});

			this.hud.updateKillCount(totalKills);
		}


		updateHUD(){
			this.updateHUDSpriteCount();
			this.updateHUDKillCount();

			
			this.hud.updateHUD();
		}

		/** Various 'hooks' for game loop **/

		updatePhysics(timeDiff){
			
			this.player.updatePhysics(timeDiff);
			
			this.spriteGenerators.forEach(function(spriteGenerator){

				spriteGenerator.updatePhysics(timeDiff);
			});
			

		}

		

		updateAnimations(timeDiff){

			//Draw the background image
			this.drawBackgroundImg();

			this.spriteGenerators.forEach(function(spriteGenerator){

				//Draw enemy sprites
				spriteGenerator.draw(timeDiff);

			});


			//Draw player last so that it's on top of aliens
			this.player.drawImage(this.context);

		}

		checkForGameWinOrLoss(){

		}

		

		//Run the game loop
		runGame(){

			
			//Initialize timer-related variables
			var lastTime = Date.now();
			var currentTime = lastTime;
			var timeDiff = lastTime - currentTime;

			/** Store references to the current game,
			 * current context, canvas, etc. **/			
			var currentGame = this;
			var context = this.context;
			var canvas = this.canvasElement;
			var isPaused = this.isPaused;
			var isLost = this.isLost;
			var isWon = this.isWon;

			this.gameLoopID = setInterval(function(){
				if(isPaused){
					return;
				}

				if(isLost){
					return;
				}

				if(isWon){
					return;
				}

				//Calculate time difference
				timeDiff = lastTime - currentTime;
				currentTime = lastTime;

				//Clear the canvas before drawing other game objects
				context.clearRect(0,0,canvas.width,canvas.height);
				
				//Update physics, animation, HUD, etc.
				currentGame.updatePhysics(timeDiff);
				currentGame.updateAnimations(timeDiff);
				currentGame.updateHUD();

				//Check if game win or loss conditions have been satisfied
				currentGame.checkForGameWinOrLoss();

				//Reset the last time
				lastTime = Date.now();

			}, this.frameRate);

		}

		//Start Game
		startGame(){
			this.runGame();

		}

		//Restart Game
		restartGame(){
			this.runGame();

		}

		//Pause Game
		pauseGame(){
			clearInterval(this.gameLoopID);
		}

		//End Game
		endGame(){
			clearInterval(this.gameLoopID);

		}

	};
