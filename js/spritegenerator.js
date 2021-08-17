//Should manage creation and destruction of alien objects
class SpriteGenerator{

	constructor(canvas){
		this.canvas = canvas;
		this.context = this.canvas.getContext('2d');
		this.totalSprites = 0;
		this.killCount = 0;
		this.sprites = [];
		
		
	}

	getTotalSprites(){
		this.totalSprites;
	}

	getKillCount(){
		return this.killCount;
	}

	getRandomSpawnPoint(){
		var maxX = this.canvas.width;
		var maxY = this.canvas.height;

		return [
			Math.random()*(maxX)*0.80 + 0.10*this.canvas.width,
			Math.random()*(maxY)*0.80 + 0.10*this.canvas.height
			];
	}


	getRandomColor(){
		const COLORS = ["beige","pink","blue","green","yellow"];
		var randIndex = Math.floor(Math.random()*COLORS.length);
		return COLORS[randIndex];
	}

	getRandomSprite(callback = null){
		var spawnPoint = this.getRandomSpawnPoint();
		var color =  this.getRandomColor();

		var sprite = new Alien(color,
		spawnPoint[0],
		spawnPoint[1],
		this.canvas);

		if(typeof(callback) == "function"){
			sprite.img.onload = callback;
		}

		this.totalSprites += 1;
		return sprite;

		


	}



	
	getRandomSprites(numberSprites, sprites = []){
		console.log("Getting another sprites: " + sprites.length);
	
		var spriteGenerator = this;

		var sprite = this.getRandomSprite(function(){
			if(numberSprites > 1){
				console.log("Generating next sprite...");
				spriteGenerator.getRandomSprites(numberSprites-1,sprites);
			} 
		});

		if(sprite != null){
			sprites.push(sprite);
		}
	

		return sprites;
	} 
	

	spawnObjects(numberSprites){
		
		this.sprites = this.getRandomSprites(numberSprites);
	
	}


	updatePhysics(timeDiff){
		for(var i = 0; i < this.sprites.length; i++){
				
			this.sprites[i].updatePhysics(timeDiff);

				
		}

	}

	checkPlayerContact(player){
		
		for(var i = 0; i < this.sprites.length; i++){
			if(player.hasOverlapWith(this.sprites[i],0.5)){
				this.sprites[i].takeDamage();
			}
			// if(this.sprites[i].hasOverlapWith(player)){
			// 		this.sprites[i].takeDamage();
			// 	}
					
			}
	}

	draw(timeDiff){
		for(var i = 0; i < this.sprites.length; i++){
			if(this.sprites[i].isDead){
				this.sprites.splice(i,1);
				this.killCount += 1;
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