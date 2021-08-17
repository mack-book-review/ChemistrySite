class Player extends Sprite{
		
		constructor(x = undefined,y = undefined){
			super("assets/BasicCrosshairs/crosshair075.png",x,y,40,40);
			this.velocityX = 0;
			this.velocityY = 0;
			this.timeCounter = 0;
		}	




		keyLeft(){
			this.velocityX += -0.3;
		}

		keyRight(){
			this.velocityX += 0.3;
		}

		keyUp(){
			this.velocityY += -0.3;
		}

		keyDown(){
			this.velocityY += 0.3;
		}

		stopVelocityX(){
			this.velocityX = 0;
		}

		stopVelocityY(){
			this.velocityY = 0;
		}

		mouseupHandler(){
			this.velocityY = 0;
			this.velocityX = 0;
		}


		mousedownHandler(xCor,yCor){
			console.log("xCor: " + xCor);
			console.log("yCor: " + yCor);
			console.log("currentX: " + this.x);
			console.log("currentY: " + this.y);

			var xDist = xCor - (this.x + this.width/2);
			var yDist = yCor - (this.y + this.height/2);

			var rad = Math.atan(Math.abs(yDist/xDist));


			var deltaY = Math.sin(rad);
			var deltaX =  Math.cos(rad);

			console.log("deltaX: " + deltaX);
			console.log("deltaY: " + deltaY);

			if(this.isClicked(xCor,yCor)){
				console.log("Target was clicked");
				deltaX = 0;
				deltaY = 0;
			} else {
				deltaX = (xDist < 0) ? -deltaX:deltaX;
				deltaY = (yDist > 0) ? deltaY:-deltaY;

			}

			console.log("yDist: " + yDist);
			console.log("xDist: " + xDist);

			console.log("deltaY: " + deltaY);
			console.log("deltaX: " + deltaX);

			this.velocityY = deltaY;
			this.velocityX = deltaX;
		}

		

		update(timeDiff){

				this.y += this.velocityY;
				this.x += this.velocityX;
		
				
				// this.timeCounter = 0;

			// } else {
			// }
			

		}
		
}