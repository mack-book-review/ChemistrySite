	

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
			this.alienGenerator.spawnObjects(7);
			console.log("Finished creating sprite generator...");

			var player = this.player;
			var alienGenerator = this.alienGenerator;
			
			this.playerShootHandler = function(){

				alienGenerator.checkPlayerContact(player);
			};

	
			
			this.configureCanvasKeyboardControls();
			this.createPauseButton();


		}

		createPauseButton(){
			var currentGame = this;

			this.pauseButton = document.createElement("a");
			this.configurePauseButton(this.pauseButton);


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



			this.player = new Player(50,50,this.canvas);
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
			canvasElement.style.border = "black 1px solid";
			canvasElement.style.backgroundColor = "white";
			canvasElement.style.position = "absolute";
			canvasElement.style.top = 40 + "px";
			canvasElement.style.left = 40 + "px";
			canvasElement.style.zIndex = 0;

		}


		

		configurePauseButton(button){
			var cWidth = this.container.style.width;
			var cHeight = this.container.style.height;

			button.style.position = "absolute";
			button.style.top = 20 + "px";
			button.style.left = 30 + "px";

			button.style.backgroundColor = "pink";
			button.style.padding = "10px";
			button.style.borderRadius = "10%";
			button.style.color = "white";
			button.style.fontFamily = "Arial";
			button.style.border = "solid 2px black";
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

			this.player.update(timeDiff);
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
