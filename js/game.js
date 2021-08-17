	

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


			this.container = container;
			this.createPlayer();
			this.createCanvasElement();
			this.context = this.canvasElement.getContext('2d');
			

			//add some aliens
			var alien1 = new Alien("beige",10,10);
			var alien2 = new Alien("blue",50,50);
			var alien3 = new Alien("green",70,70);
			var alien4 = new Alien("yellow",100,100);

			this.addSprite(alien1);
			this.addSprite(alien2);
			this.addSprite(alien3);
			this.addSprite(alien4);



			
			
			var player = this.player;
			this.playerShootHandler = function(){

				for(var i = 0; i < this.sprites.length; i++){
					if(this.sprites[i].hasOverlapWith(player)){
						this.sprites[i].takeDamage();
					}
					
				}
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



			this.player = new Player(50,50);
		}


		addSprite(sprite){
			this.sprites.push(sprite);
		}

		configureMouseClickHandlers(){

			var player = this.player;
			var sprites = this.sprites;
			var canvas = this.canvasElement;

			this.mousedownHandler = function(xCor,yCor){
				if(player.isClicked(xCor,yCor)){
					console.log("Player was clicked..");
					for(var i = 0; i < sprites.length; i++){
						var sprite = sprites[i];
						if(sprite.isClicked(xCor,yCor)){
						console.log("Sprite was clicked..");
							
           						
								sprite.takeDamage();
							

						}
					}
				}
			};

			this.mouseupHandler = function(xCor,yCor){
				if(player.isClicked(xCor,yCor)){
					for(var i = 0; i < sprites.length; i++){
						
					}
					
				}		
			};
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

		configureOnscreenArrowControls(){
			console.log("Adding controls...");
			var currentGame = this;

			this.controlLeft = document.createElement("div");
			this.controlUp = document.createElement("div");
			this.controlDown = document.createElement("div");
			this.controlRight = document.createElement("div");

			this.configureControlElement(
				this.controlLeft,
				"assets/BasicControls/left.png",
				500,400,function(){
					console.log("Move left");
				});

			this.configureControlElement(
				this.controlRight,
				"assets/BasicControls/right.png",
				550,400,function(){
					console.log("Move right");

				});

			this.configureControlElement(
				this.controlUp,
				"assets/BasicControls/up.png",
				525,375,function(){
					console.log("Move up");

				});

			this.configureControlElement(
				this.controlDown,
				"assets/BasicControls/down.png",
				525,425,function(){
					console.log("Move down");

				});

			console.log("Adding control elements...");
			console.log(this.controlDown);
			console.log(this.controlUp);
			console.log(this.controlLeft);
			console.log(this.controlRight);

			this.addToContainer(this.controlDown);
			this.addToContainer(this.controlUp);
			this.addToContainer(this.controlRight);
			this.addToContainer(this.controlLeft);


		}

		configureControlElement(controlElement, 
			imgPath,
			leftPos,
			topPos,
			clickHandler){

			controlElement.style.backgroundColor = "blue";
			controlElement.style.width = "50px";
			controlElement.style.height = "50px";
			controlElement.style.backgroundImage = imgPath;
			controlElement.style.position = "absolute";
			controlElement.style.top = topPos + "px";
			controlElement.style.left = leftPos + "px";
			controlElement.style.zIndex = 10;
			controlElement.addEventListener("click",clickHandler);
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


		configureCanvasMouseControl(){
			var player = this.player;
			var mousedownHandler = this.mousedownHandler;
			var mouseupHandler = this.mouseupHandler;

			this.canvasElement.addEventListener('mousedown',event =>{
				
				console.log("Mouse down");
				console.log(event);
				var newX = event.offsetX;
				var newY = event.offsetY;
				player.mousedownHandler(newX,newY);
				mousedownHandler(newX,newY);
			});

			this.canvasElement.addEventListener('mouseup',event =>{
			
				console.log("Mouse up");
				var newX = event.clientX;
				var newY = event.clientY;
				player.mouseupHandler();
				mouseupHandler(newX,newY);

			});
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
			

			for(var i = 0; i < this.sprites.length; i++){
				
				this.sprites[i].update(timeDiff);

				
			}

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

			for(var i = 0; i < this.sprites.length; i++){
				if(this.sprites[i].isDead){
					this.sprites.splice(i,1);

				} 
				
				this.sprites[i].drawImage(this.context,timeDiff);

				
			}

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
