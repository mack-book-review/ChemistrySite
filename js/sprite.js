class Sprite{

		constructor(imgSrc,
			x = undefined,
			y = undefined,
			width = undefined,
			height = undefined){
			this.img = new Image();
			this.img.src = imgSrc;

			this.isDead = false;
			this.x = x ?? 0;
			this.y = y ?? 0;
			this.width = width ?? this.img.naturalWidth;
			this.height = height ?? this.img.naturalHeight;
			this.animations = {};
			this.animationInProgress = false;
			this.textures = [];
			this.timeCounter = 0;
			this.frameNumber = 0;

			this.health = 2;

			var txtImg1 = new Image();
			txtImg1.src = "assets/RegularExplosion/regularExplosion00.png";
			
			var txtImg2 = new Image();
			txtImg2.src = "assets/RegularExplosion/regularExplosion01.png";

			var txtImg3 = new Image();
			txtImg3.src = "assets/RegularExplosion/regularExplosion02.png";

			var txtImg4 = new Image();
			txtImg4.src = "assets/RegularExplosion/regularExplosion03.png";

			var txtImg5 = new Image();
			txtImg5.src = "assets/RegularExplosion/regularExplosion04.png";

			var txtImg6 = new Image();
			txtImg6.src = "assets/RegularExplosion/regularExplosion05.png";


			var txtImg7 = new Image();
			txtImg7.src = "assets/RegularExplosion/regularExplosion06.png";

			var txtImg8 = new Image();
			txtImg8.src = "assets/RegularExplosion/regularExplosion07.png";


			
			
			this.textures = [txtImg1,txtImg2,
				txtImg3,txtImg4,
				txtImg5,txtImg6,txtImg7,txtImg8,
				];

	
		}

		hasOverlapWith(otherSprite){
			return !(
				this.x > (otherSprite.x+otherSprite.width) || 
					(this.x + this.width < otherSprite.x) ||
					(this.y > (otherSprite.y + otherSprite.height)) ||
					((this.y+this.height) < otherSprite.y)
					);
		}

		//Refactor later to get bounds from canvas element
		IsInHorizontalBounds(screenWidth){
			console.log("x is: " + this.x);
			return this.x >= 0  && this.x <= screenWidth;
		}

		IsInVerticalBounds(screenHeight){
			console.log("y is: " + this.y);
			return this.y >= 0 && this.y <= screenHeight;

		}

		get boundingRectangle(){
			return [this.x,this.y,this.width,this.height];
		}

		getX(){
			return this.x;
		}

		getY(){
			return this.y;
		}

		getWidth(){
			return this.width;
		}

		getHeight(){
			return this.height;
		}

		setX(xPos){
			this.x = xPos;
		}

		setY(yPos){
			this.y = yPos;
		}

		setWidth(newWidth){
			this.width = newWidth;
		}

		setHeight(newHeight){
			this.height = newHeight;
		}

		init(){

		}

		takeDamage(){
			console.log("Take damage");
			this.img.style.opacity -= 0.2;
			if(this.health > 0){
				this.health -= 1;
			} else {
				this.runAnimation();
			}
		}

		mousedownHandler(){

		}

		mouseupHandler(){

		}

		isClicked(xCor,yCor){
			var containsX = xCor > this.x && xCor < (this.x + this.width);
			var containsY = yCor > this.y && yCor < (this.y + this.height);
			
			return containsX && containsY;
		}
		
		update(timeDiff){

			
		}

		runAnimation(){
			this.animationInProgress = true;
		}

		runTextureAnimation(){

		
		}

		die(){

		}

		drawImage(context,timeDiff){
			
			if(!this.animationInProgress){
				context.drawImage(
				this.img,
				0,0,
				this.img.naturalWidth,this.img.naturalHeight, 
				this.x,this.y,
				this.width,this.height);

			} else {
				//run animation
				this.timeCounter += timeDiff;
				
				if(this.frameNumber < this.textures.length){
					if(this.timeCounter > 20){
						context.drawImage(
							this.textures[this.frameNumber],
							0,0,
							this.img.naturalWidth,this.img.naturalHeight, 
							this.x,this.y,
							this.width,this.height);
							this.timeCounter = 0;
							this.frameNumber += 1;
					}
				} else {
					this.frameNumber = 0;
					this.animationInProgress = false;
					this.isDead = true;
				}
				
			}
			
		}
	}


