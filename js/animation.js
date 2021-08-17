 
 class Animation{

     static GetExplosionTextureImgPaths(){

         var basePath = "assets/RegularExplosion/regularExplosion";
         var imgPaths = [];

         for(var i = 0; i < 9; i++){
             var imgPath  = basePath + 0 + i + ".png";
             imgPaths.push(imgPath);
         }

         return imgPaths;
     }

     static GetExplosionTextures(){
         var imgPaths = this.GetExplosionTextureImgPaths();
         var imgArray = [];

         imgPaths.forEach((imgPath,index) =>{
             var img = new Image();
             img.src = imgPath;
             imgArray.push(img);
         });

         
            return imgArray;

     }

     constructor(textures){
         this.textures = textures;
         this.currentFrame = 0;
         this.frameInterval = 10;
         this.timeCounter = 0;
         this.autoLoop = false;
     }

     resetCurrentFrame(){
         this.currentFrame = 0;
     }

     incrementFrameNumber(){
         if(this.currentFrame < this.textures.length){
             this.currentFrame += 1;
         } else {
             this.currentFrame = 0;
         }
     }

     getCurrentTexture(){
         return this.textures[this.currentFrame];
     }

     getCurrentFrame(){
         return this.currentFrame;
     }


    addTextures(textures)
    {
        this.textures = textures;
    }

     getTextureCount(){
         return this.textures.length;
     }


     resetTimeCounter(){
         this.timeCounter = 0;
     }

     incrementTimeCounter(timeDiff){
         this.timeCounter += timeDiff;
     }

 
 }
