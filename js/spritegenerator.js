//Should manage creation and destruction of alien objects
class SpriteGenerator{

	constructor(canvas){
		this.canvas = canvas;
		this.context = this.canvas.getContext('2d');
		this.sprites = [];
		this.screenWidth = this.canvas.width;
		this.screenHeight = this.canvas.height;
		
	}

	getRandomSpawnPoint(){
		var maxX = this.canvas.width;
		var maxY = this.canvas.height;

		return [
			Math.random()*(maxX)*0.80 + 0.10*this.screenWidth,
			Math.random()*(maxY)*0.80 + 0.10*this.screenHeight
			];
	}


	getRandomColor(){
		const COLORS = ["beige","pink","blue","green","yellow"];
		var randIndex = Math.floor(Math.random()*COLORS.length);
		return COLORS[randIndex];
	}

	getRandomSprite(callback){
		var spawnPoint = this.getRandomSpawnPoint();
		var color =  this.getRandomColor();

		var sprite = new Alien(color,
			spawnPoint[0],
			spawnPoint[1],
			this.canvas);

		if(typeof(callback) == "function"){
			sprite.img.onload = callback;
		}

		return alien;

	}

	getRandomSprites(numberSprites, sprites = []){
		console.log("Getting another sprites: " + sprites.length);
	
		var spriteGenerator = this;
		sprites.push(this.getRandomSprite(){
			if(numberSprites > 0){
				console.log("Generating next sprite...");
				spriteGenerator.getRandomSprites(numberSprites-1,sprites);
			}
		});

		return sprites;
	}

	spawnObjects(numberSprites){
		
		return this.getRandomSprites(numberSprites);
	
	}


	updatePhysics(timeDiff){
		for(var i = 0; i < this.sprites.length; i++){
				
			this.sprites[i].update(timeDiff);

				
		}

	}

	checkPlayerContact(player){
		
		for(var i = 0; i < this.sprites.length; i++){
			if(this.sprites[i].hasOverlapWith(player)){
					this.sprites[i].takeDamage();
				}
					
			}
	}

	draw(timeDiff){
		for(var i = 0; i < this.sprites.length; i++){
			if(this.sprites[i].isDead){
				this.sprites.splice(i,1);
			} 
				
			this.sprites[i].drawImage(this.context,timeDiff);

				
		}

	}

	addSprite(newSprite){
		this.sprites.push(newSprite);
	}



	getAliens(){

	}

	createRandomAliens(numberAliens){

	}

	createRandomAlien(){

	}
}