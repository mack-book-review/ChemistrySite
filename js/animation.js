 
 class Animation{

     static GetExplosionTextures(){
         var txtImg1 = new Image();
            txtImg1.src = "assets/RegularExplosion/regularExplosion00.png";
            
            var txtImg2 = new Image();
            txtImg2.src = "assets/RegularExplosion/regularExplosion01.png";

            var txtImg3 = new Image();
            txtImg3.src = "assets/RegularExplosion/regularExplosion02.png";

            var txtImg4 = new Image();
            txtImg4.src = "assets/RegularExplosion/regularExplosion03.png";

            var txtImg5 = new Image();
            txtImg5.src = "assets/RegularExplosion/regularExplosion04.png";

            var txtImg6 = new Image();
            txtImg6.src = "assets/RegularExplosion/regularExplosion05.png";


            var txtImg7 = new Image();
            txtImg7.src = "assets/RegularExplosion/regularExplosion06.png";

            var txtImg8 = new Image();
            txtImg8.src = "assets/RegularExplosion/regularExplosion07.png";
            
            return [txtImg1,txtImg2,
                txtImg3,txtImg4,
                txtImg5,txtImg6,txtImg7,txtImg8,
                ];

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
