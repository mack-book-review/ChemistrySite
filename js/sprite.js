class Sprite{

		constructor(imgSrc,
			x = undefined,
			y = undefined,
			width = undefined,
			height = undefined){
			this.img = new Image();
			this.img.src = imgSrc;
			this.img.style.zIndex = 10;

			this.currentAnimation = null;
			this.isDead = false;
			this.x = x ?? 0;
			this.y = y ?? 0;
			this.width = width ?? this.img.naturalWidth;
			this.height = height ?? this.img.naturalHeight;
			this.health = 2;

			

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

			if(this.isDead){
				return;
			}

			console.log("Take damage");
			this.img.style.opacity -= 0.2;
			if(this.health > 0){
				this.health -= 1;
			} else {

				var textures = Animation.GetExplosionTextures();
				var explosionAnimation = new Animation(textures);
				var currentSprite = this;
				this.runAnimation(explosionAnimation,function(){
					console.log("Finished running animation");
				});
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

		stopCurrentAnimation(){
			this.currentAnimation = null;
		}

		stopAllAnimations(){
			this.currentAnimation = null;
		}

		runAnimation(animation, callback = null){

			this.currentAnimation = animation;

			if(callback != null && typeof(callback) == "function"){
				callback();
			}
		
		}

		die(){

		}

		drawImage(context,timeDiff){
			


			if(this.currentAnimation == null){

				context.drawImage(
				this.img,
				0,0,
				this.img.naturalWidth,this.img.naturalHeight, 
				this.x,this.y,
				this.width,this.height);

			} else {
				//run current animation
				var currentAnimation = this.currentAnimation;
				
				currentAnimation.incrementTimeCounter(timeDiff);


				if(currentAnimation.getCurrentFrame() < currentAnimation.getTextureCount()){
					if(currentAnimation.timeCounter > currentAnimation.frameInterval){
						var currentTexture = currentAnimation.getCurrentTexture();
						context.drawImage(
							currentTexture,
							0,0,
							currentTexture.naturalWidth,currentTexture.naturalHeight, 
							this.x,this.y,
							this.width,this.height);

						currentAnimation.resetTimeCounter();
						currentAnimation.incrementFrameNumber();
					}
				} else {
					console.log("Resetting current frame");
					currentAnimation.resetCurrentFrame();
					if(!currentAnimation.autoLoop){
						console.log("Removing animation");
						delete this.currentAnimation;
						this.currentAnimation = null;
						this.isDead = true;
					}
				}
				
			}
			
		}
	}


