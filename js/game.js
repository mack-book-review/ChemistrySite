	

	class Game{

		constructor(container){
			

			//Initialize Game :oop ID
			this.gameLoopID = 0;

			//Initialize Timer Variables
			this.timer = 0;
			this.timeRemaining = 60;
			this.clockTime = 0;

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
				new EvilCloudGenerator(this.canvasElement),
				new EvilSunGenerator(this.canvasElement)

			];

			//Spawn enemies
			this.spriteGenerators.forEach((generator) =>{
				generator.spawnObjects(1);
			});

			//Configure the event handler that is called when the player shoots
			this.configurePlayerShootHandler();
	
			//Create a way for player to interact with game
			
		
			var bgMusicAudio = document.createElement("audio");
			this.bgMusicAudio = bgMusicAudio;
			this.bgMusicAudio.src = "polka_train.ogg";
			this.addToContainer(this.bgMusicAudio);
			this.loadBackgroundMusic();
	
			InputHelper.ConfigureCanvasKeyboardControls(this);
			
			//Create UI elements
			this.createPauseButton();
			this.createInstructionsButton();
			this.createMusicSettingsButton();
			this.createTitleBanner();
			this.createHUD();

			

		}

		configurePlayerShootHandler(){
			//Get references to enemy generators for playerShoot handler
			var spriteGenerators = this.spriteGenerators;
			var player = this.player;

			this.shootAudio = new Audio();
			this.shootAudio.src = "assets/Sounds/laser2.ogg";
			this.addToContainer(this.shootAudio);

			var shootAudio = this.shootAudio;
			
			this.playerShootHandler = function(){

				shootAudio.play();
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
				
					var popup = UIGenerator.CreateInstructionsPopup(
						"In order to move the targeting crosshair, use the up, down, left, and right arrows on your keypad.  When the crosshair is over an enemy, tap the spacebar to fire a missile at the enemy.",
						GAME_SETTINGS.getScreenHeight()/3,
						GAME_SETTINGS.getScreenWidth()/4,
						"assets/Smilies/confused.gif",
						function(){
							currentGame.isPaused = false;

						});
					currentGame.addToContainer(popup);
					currentGame.isPaused = true;
			});

			this.addToContainer(this.instructionsButton);

		}

		createMusicSettingsButton(){
			var currentGame = this;

			this.musicSettingsButton = document.createElement("a");
			UIGenerator.ConfigureMenuButton(this.musicSettingsButton,"30%");
			var buttonText = document.createTextNode("Music Settings");
			this.musicSettingsButton.appendChild(buttonText);
			
			var musicSettingsButton = this.musicSettingsButton;
			var bgMusicAudio = this.bgMusicAudio;
			this.musicSettingsButton.addEventListener("click", 
				function(){
				
					var popup = UIGenerator.CreateMusicSettingsPopup(
						"Music Settings",
						GAME_SETTINGS.getScreenHeight()/3,
						GAME_SETTINGS.getScreenWidth()/4,
						"assets/Smilies/confused.gif",
						function(event){
							console.log("Processing event...");
							if(event.target.checked){
								if(bgMusicAudio.muted){
									bgMusicAudio.muted = false;
								} else {
									bgMusicAudio.muted = true;
								}
								
							} else {
								if(bgMusicAudio.muted){
									bgMusicAudio.muted = false;
								} else {
									bgMusicAudio.muted = true;
								}
							
							}
						},
						function(){
							currentGame.isPaused = false;

						});
					currentGame.addToContainer(popup);
					currentGame.isPaused = true;
			});

			this.addToContainer(this.musicSettingsButton);

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
			var startPos = GAME_SETTINGS.getPlayerStartPosition();
			this.player = new Player(
				startPos[0],
				startPos[1],
				this.canvasElement);
		}


		addSprite(sprite){
			this.sprites.push(sprite);
		}

		loadBackgroundMusic(){

			var bgMusicAudio = this.bgMusicAudio;
			this.container.addEventListener("mousemove", function () {
    			bgMusicAudio.play();

    		});
		}


		createCanvasElement(){
			this.canvasElement = document.createElement("canvas");
			this.configureCanvasElement(this.canvasElement);
			this.addToContainer(this.canvasElement,0);
	
		}

		configureCanvasElement(canvasElement){
			UIGenerator.ConfigureCanvas(canvasElement);

		}

		configureMenuButton(button,topDistance){
			UIGenerator.ConfigureMenuButton(button,topDistance);
		
		}

		addToContainer(element,zIndex = 0){
			element.style.zIndex = zIndex;
			this.container.appendChild(element);
		}


		drawText(someText,x,y){
			this.context.strokeStyle = "white";
			this.context.font = '30 pt Times New Roman';
			this.context.strokeText(someText,x,y);

		}

		drawBackgroundImg(){
			var backgroundImg = new Image();
			backgroundImg.src = GAME_SETTINGS.getBackgroundImgPath();

			this.context.drawImage(
				backgroundImg,
				0,0,
				backgroundImg.naturalWidth,
				backgroundImg.naturalHeight,
				0,0,
				GAME_SETTINGS.screenWidth,
				GAME_SETTINGS.screenHeight
				);
		}

		/** HUD-related Helper Functions **/
		createHUD(){
		
			this.hud = new HUD(this.container,GAME_SETTINGS);
			this.hud.addHUD();

		}


		getTotalEnemies(){
			var totalEnemies = 0;

			this.spriteGenerators.forEach(function(spriteGenerator){
				totalEnemies += spriteGenerator.getTotalSprites();
				
			});

			return totalEnemies;
		}

		updateHUDSpriteCount(){
			var totalEnemies = this.getTotalEnemies();

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

			var currentGame = this;

			if(currentGame.timeRemaining == 0){
				currentGame.isLost = true;
				var msg = UIGenerator.CreateGameFinishedMessage("I'm Sorry! You Lost!",150,150,"/assets/Smilies/cry.gif");
				currentGame.addToContainer(msg);
			}

			if(currentGame.getTotalEnemies() == 0){
				currentGame.isWon = true;
				var msg = UIGenerator.CreateGameFinishedMessage("Congratulations! You won!",150,150,"/assets/Medals/flat_medal1.png");
				currentGame.addToContainer(msg);
			}
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
	

			this.gameLoopID = setInterval(function(){
				if(currentGame.isPaused || currentGame.isLost || currentGame.isWon){
					return;
				}

				//Calculate time difference
				timeDiff = lastTime - currentTime;
				currentTime = lastTime;
				currentGame.timer += timeDiff;


			
				//Clear the canvas before drawing other game objects
				context.clearRect(0,0,canvas.width,canvas.height);
				
				//Update physics, animation, HUD, etc.
				currentGame.updatePhysics(timeDiff);
				currentGame.updateAnimations(timeDiff);
				currentGame.updateHUD();


				
				currentGame.clockTime = Math.floor(currentGame.timer / 1000);
				currentGame.timeRemaining = 60 - currentGame.clockTime;
				currentGame.drawText("Time Remaining: " + currentGame.timeRemaining,10,20);
				


				//Check if game win or loss conditions have been satisfied
				currentGame.checkForGameWinOrLoss();

				//Reset the last time
				lastTime = Date.now();

			}, GAME_SETTINGS.frameRate);

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
