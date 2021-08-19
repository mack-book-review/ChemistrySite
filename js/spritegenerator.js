//Should manage creation and destruction of alien objects
class SpriteGenerator{

	constructor(canvas,defaultImgPath = "assets/Alien/alien_beige.png",defaultSize = [30,30]){
		this.canvas = canvas;
		this.context = this.canvas.getContext('2d');
		this.totalSprites = 0;
		this.killCount = 0;
		this.sprites = [];
		this.defaultImgPath = defaultImgPath;
		this.defaultSize = defaultSize;
		
		
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


	getDefaultImgPath(){
		return this.defaultImgPath;
	}

	getDefaultSize(){
		return this.defaultSize;;
	}

	getRandomSprite(onLoadCallback = null){
		var spawnPoint = this.getRandomSpawnPoint();
		var defaultSize = this.getDefaultSize();

		/** generate a sprite here**/
		var sprite = new Sprite(
			this.getDefaultImgPath(),
			spawnPoint[0],spawnPoint[1],
			defaultSize[0],defaultSize[1],this.canvas
			);

		if(typeof(callback) == "function"){
			sprite.img.onload = onLoadCallback;
		}

		this.totalSprites += 1;
		return sprite;


	}


	getRandomSprites(numberSprites, sprites = []){
	
		var spriteGenerator = this;

		var sprite = this.getRandomSprite(function(){
			if(numberSprites > 1){
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


	updatePhysics(timeDiff,callback = null){
		for(var i = 0; i < this.sprites.length; i++){
				
			this.sprites[i].updatePhysics(timeDiff);

			if(typeof(callback) == "function"){
				callback(this.sprites[i],this.canvas);
			}
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

}