class LevelConfiguration{

	constructor(levelNum,
		timeLimit,
		minSpawningRate,
		maxSpawningRate){
		this.levelNumber = levelNum;
		this.timeLimit = timeLimit;
		this.minSpawningRate = minSpawningRate;
		this.maxSpawningRate = maxSpawningRate;
		this.enemyGenerators = [];
	}


}