class ImageLoader{

	constructor(imagePaths){
		this.imagePaths = imagePaths;
		this.numberOfImages = this.imagePaths.length;
		this.loadedImages = [];
		this.imagesLoaded = this.loadedImages.length;
	}

	//Keeps track of the percentage of images that have been loaded
	getLoadingCompletionPercentage(){
		return this.getNumberOfImagesLoaded()/this.getTotalNumberOfImages;
	}

	//Returns the total number of images that need to be loaded
	getTotalNumberOfImages(){
		return this.imagePaths.length;
	}

	//Returns the number of images that have been loaded
	getNumberOfImagesLoaded(){
		return this.imagesLoaded.length;
	}

	getImageDeepCopy(imgSrc){
		var imgIndex = this.imgPaths.indexOf(imgSrc);
		return this.loadImages[imgIndex];
	}

	loadImages(callback){

		while(this.getLoadingCompletionPercentage < 1){

			var imageLoader = this;
			this.imagePaths.prototype.forEach((imgPath,index) => {
				var newImg = new Image();
				newImg.src = imgPath;
				imageLoader.imagesLoaded.push(newImg);
			});
		}

		if(typeof(callback) == "function"){
			callback();
		}

	}
}