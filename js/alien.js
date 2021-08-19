class Alien extends Sprite{

		constructor(alienColor, 
			x = undefined,
			y = undefined, canvas = undefined){
			
			var imgPath = "assets/Aliens/alien_";
			imgPath += alienColor;
			imgPath += ".png"


			super(imgPath,x,y,30,30,canvas);
			this.velocityX = 0;
			this.velocityY = 0;
			this.timer = 0;
			this.img.style.zIndex = -10;
			
		}	


		checkPosition(callback){

				if(this.x < 0){
					this.velocityX = 20;
				}


				if(this.x > this.canvas.width-this.width){
					this.velocityX = -20;
				}


				if(this.y < 0){
					this.velocityY = 20;
				}

				if(this.y > this.canvas.height - this.height){
					this.velocityY = -20;
				}

				if(typeof(callback) == "function"){
					callback();
				}

		}

		randomizeVelocity(){

			this.velocityX = Math.random()*10;
			this.velocityY = Math.random()*10;

			var flip1 = Math.floor(Math.random()*2);
			var flip2 = Math.floor(Math.random()*2);

			this.velocityX = flip1 == 0 ? this.velocityX : -this.velocityX;
			this.velocityY = flip2 == 0 ? this.velocityY : -this.velocityY;
			
		}

		moveRandomly(timeDiff){
			this.timer += timeDiff;
			if(this.timer > 150){
				this.randomizeVelocity();

				this.x += this.velocityX;
				this.y += this.velocityY;



				this.timer = 0;
			}
		}

		

		updatePhysics(timeDiff){
			this.moveRandomly(timeDiff);
			this.checkPosition();
				

		}
}