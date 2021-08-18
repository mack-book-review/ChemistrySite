class Wingman extends Sprite{


	constructor(x = undefined,
			y = undefined, canvas = undefined){
		

			super("/assets/Wingman/wingMan1.png",
				x,y,30,30,canvas);
			this.velocityX = 5;
			this.velocityY = 0;
			this.timer = 0;
			this.img.style.zIndex = -10;
			
		}

		updatePhysics(timeDiff){
			this.timer += timeDiff;
			if(this.timer > 150){
				
				if(this.velocityX > 0){
					this.velocityY = 5;
					this.velocityX = 0;

				} else if(this.velocityY > 0){
					this.velocityY = 0;
					this.velocityX = -5;

				} else if(this.velocityX < 0){
					this.velocityX = 0;
					this.velocityY = -5;

				} else if(this.velocityY < 0){
					this.velocityY = 0;
					this.velocityX = 5;

				}

				this.timer = 0;

			}
			
			this.x += this.velocityX;
			this.y += this.velocityY;
			

		}

}