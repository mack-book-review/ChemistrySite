	

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


			//Create some aliens via an instance of a SpriteGenerator
			console.log("Creating sprite generator...");
			this.alienGenerator = new SpriteGenerator(this.canvasElement);
			console.log("Spawning objects...");
			this.alienGenerator.spawnObjects(6);
			console.log("Finished creating sprite generator...");

			var player = this.player;
			var alienGenerator = this.alienGenerator;
			
			this.playerShootHandler = function(){

				alienGenerator.checkPlayerContact(player);
			};

	
			//Create a way for player to interact with game
			InputHelper.ConfigureCanvasKeyboardControls(this);
			
			//Create UI elements
			this.createPauseButton();
			this.createInstructionsButton();
			this.createTitleBanner();
			this.createHUD();


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

		updateAnimations(timeDiff){


		}

		updatePhysics(timeDiff){

			this.player.updatePhysics(timeDiff);
			this.alienGenerator.updatePhysics(timeDiff);

		}

		drawAnimations(timeDiff){
			//draw animations
			//console.log("Drawing another animtaion..");

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

			this.alienGenerator.draw(timeDiff);

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
				currentGame.updateAnimations(timeDiff);
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
