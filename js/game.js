	

	class Game{

		constructor(container, screenWidth,screenHeight){
			this.screenWidth = screenWidth;
			this.screenHeight = screenHeight;
			this.gameLoopID = 0;
			this.frameRate = 20;
			this.sprites = [];
			this.isPaused = false;
			this.isEnded = false;
			this.currentAnimation = null;

			//Create the container before the canvas
			this.container = container;

			//Instantiate the canvas before instantiating the player and other sprites
			//Sprites will require a reference to the canvas on which they are drawn
			this.createCanvasElement();
			this.context = this.canvasElement.getContext('2d');
			
			//Instantiate player
			this.createPlayer();

			//Add Alien Generator
			this.alienGenerator = new AlienGenerator(this.canvasElement);
			this.alienGenerator.spawnObjects(3);

			//Add Wingman Generator
			this.wingmanGenerator = new WingmanGenerator(
				this.canvasElement);
			this.wingmanGenerator.spawnObjects(3);

			//Add EvilSun Generator
			this.evilsunGenerator = new EvilSunGenerator(this.canvasElement);
			this.evilsunGenerator.spawnObjects(3);

			//Add EvilCloud Generator
			this.evilcloudGenerator = new EvilCloudGenerator(this.canvasElement);
			this.evilcloudGenerator.spawnObjects(3);

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
			var alienGenerator = this.alienGenerator;
			var wingmanGenerator = this.wingmanGenerator;
			var evilsunGenerator = this.evilsunGenerator;
			var evilcloudGenerator = this.evilcloudGenerator;
			var player = this.player;
			
			this.playerShootHandler = function(){

				evilsunGenerator.checkPlayerContact(player);
				wingmanGenerator.checkPlayerContact(player);
				alienGenerator.checkPlayerContact(player);
				evilcloudGenerator.checkPlayerContact(player);
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


		createHUD(){
		
			this.hud = new HUD(this.container);
			this.hud.addHUD();
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

		run(animation,callback = null){

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



		updatePhysics(timeDiff){
			console.log("updating physics");
			this.player.updatePhysics(timeDiff);
			this.alienGenerator.updatePhysics(timeDiff,this.checkSpritePosition);
			this.wingmanGenerator.updatePhysics(timeDiff);
			this.evilsunGenerator.updatePhysics(timeDiff,this.checkSpritePosition);
			this.evilcloudGenerator.updatePhysics(timeDiff,this.checkSpritePosition);

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

		drawAnimations(timeDiff){
			//draw animations

			this.drawBackgroundImg();

			this.alienGenerator.draw(timeDiff);


			//Draw the wingman
			this.wingmanGenerator.draw(timeDiff);

			//Draw the evil sun
			this.evilsunGenerator.draw(timeDiff);

			//Draw the evil clouds
			this.evilcloudGenerator.draw(timeDiff);

			//Draw player last so that it's on top of aliens
			this.player.drawImage(this.context);

		}

		//startGame
		startGame(){
			var currentGame = this;

			var lastTime = Date.now();
			var currentTime = lastTime;
			var timeDiff = lastTime - currentTime;

			var context = this.context;
			var canvas = this.canvasElement;
			var isPaused = this.isPaused;
			var isEnded = this.isEnded;
			this.gameLoopID = setInterval(function(){
				if(isPaused || isEnded){
					return;
				}
				context.clearRect(0,0,canvas.width,canvas.height);
				timeDiff = lastTime - currentTime;
				currentTime = lastTime;
				//console.log("Current Time: " + currentTime);

				currentGame.updatePhysics(timeDiff);
				currentGame.drawAnimations(timeDiff);

				//console.log("Time Difference:" + timeDiff);
				lastTime = Date.now();
				//console.log("Last Time: " + lastTime);

			}, this.frameRate);

		}

		//pauseGame
		pauseGame(){
			console.log("Pausing game..");
			clearInterval(this.gameLoopID);
			console.log("Game has been paused..");
		}

		//endGame
		endGame(){
			console.log("Ending game..");
			clearInterval(this.gameLoopID);
			console.log("Game has ended..");

		}

	};
