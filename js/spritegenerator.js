//Should manage creation and destruction of alien objects
class SpriteGenerator{

	constructor(canvas){
		this.canvas = canvas;
		this.context = this.canvas.getContext('2d');
		this.sprites = [];
		
	}

	getRandomSpawnPoint(){
		var maxX = this.canvas.width;
		var maxY = this.canvas.height;

		return [
			Math.random()*(maxX),
			Math.random()*(maxY)
			];
	}


	getRandomColor(){
		const COLORS = ["beige","pink","blue","green","yellow"];
		var randIndex = Math.floor(Math.random()*COLORS.length);
		return COLORS[randIndex];
	}

	populateAliens(){
		var pt1 = this.getRandomSpawnPoint();
		var pt2 = this.getRandomSpawnPoint();
		var pt3 = this.getRandomSpawnPoint();
		var pt4 = this.getRandomSpawnPoint();

		var alien1 = new Alien(this.getRandomColor(),pt1[0],pt1[1]);
		var alien2 = new Alien(this.getRandomColor(),pt2[0],pt2[1]);
		var alien3 = new Alien(this.getRandomColor(),pt3[0],pt3[1]);
		var alien4 = new Alien(this.getRandomColor(),pt4[0],pt4[1]);

		this.addSprite(alien1);
		this.addSprite(alien2);
		this.addSprite(alien3);
		this.addSprite(alien4);
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