	

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

	

			this.configureCanvasKeyboardControls();
			this.createPauseButton();
			this.createInstructionsButton();
			this.createTitleBanner();

			this.hud = new HUD(this.container);
			this.hud.addHUD();

		}


		


		createTitleBanner(){
			console.log("Adding title banner");
			this.titleElement = document.createElement("p");

			this.titleElement.style.backgroundImage = 'url(/assets/Banners/bannerScroll.png)';
			this.titleElement.style.backgroundRepeat = 'no-repeat';

			this.titleElement.style.position = 'absolute';
			this.titleElement.style.display = 'block';
			this.titleElement.style.textAlign = 'center';
			this.titleElement.style.width = '250px';
			this.titleElement.style.height = '50px';
			this.titleElement.style.padding = "10px";
			this.titleElement.style.paddingTop = '20px';
			this.titleElement.style.fontFamily = "Baskerville";
			this.titleElement.style.color = "white";
			this.titleElement.style.transform = "scale(1.5)";

			this.titleElement.style.top = 5 +'px';
			this.titleElement.style.left = 300 +'px';
			this.titleElement.appendChild(document.createTextNode("Alien Sniper Defense"));
			console.log(this.titleElement);
			this.addToContainer(this.titleElement);
		}

		createInstructionsButton(){
			var currentGame = this;

			this.instructionsButton = document.createElement("a");
			this.configureMenuButton(this.instructionsButton,"20%");


			var buttonText = document.createTextNode("Instructions");
			this.instructionsButton.appendChild(buttonText);
			var pauseButton = this.pauseButton;
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

		
		configureCanvasKeyboardControls(){

			var player = this.player;
			var currentGame = this;
			document.addEventListener('keydown',event =>{
				console.log("Key was pressed");
				
				event.preventDefault();
				//Down key
				if(event.keyCode == 40) {
						player.keyDown();	
      			}

      			//Up key
      			if(event.keyCode == 38) {
						player.keyUp();
      			}

      			//Left key
      			if(event.keyCode == 37) {
						player.keyLeft();     				       	
      			}

      			//Right key
      			if(event.keyCode == 39) {
         				player.keyRight();
      			}

      			//Hit spacebar
      			if(event.keyCode == 32) {
         			currentGame.playerShootHandler();
      			}

			});

			

			
		}

		

		createCanvasElement(){
			this.canvasElement = document.createElement("canvas");
			this.configureCanvasElement(this.canvasElement);
			this.addToContainer(this.canvasElement,0);
	
		}

		configureCanvasElement(canvasElement){

			canvasElement.style.width = this.screenWidth + "px";
			canvasElement.style.height = this.screenHeight + "px";
			canvasElement.style.border = "white 1px solid";
			canvasElement.style.backgroundColor = "white";
			canvasElement.style.position = "absolute";
			canvasElement.style.top = "10%";
			canvasElement.style.left = "10%";
			canvasElement.style.zIndex = 0;

		}


		

		configureMenuButton(button,topDistance){
			var cWidth = this.container.style.width;
			var cHeight = this.container.style.height;
			button.style.position = "absolute";
			button.style.top = topDistance;
			button.style.right = "10%";
			button.style.width = 250 + "px";
			button.style.height = 30 + "px";
			button.style.textAlign = "center";
			button.style.backgroundImage = "url(assets/Banners/bannerModern.png)";
			button.style.backgroundRepeat = 'no-repeat';

			button.style.padding = "10px";
			button.style.fontSize = "1.8em";
			button.style.color = "white";
			button.style.fontFamily = "Arial";


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
