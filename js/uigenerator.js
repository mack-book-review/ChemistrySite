class UIGenerator{
	//Static Constants for Game Fonts

	static Fonts = class {

		static PressStart2P = "Press Start 2P";
		static SigmarOne = "Sigmar One";
		static Bangers = "Bangers";


	};

	static CreateInstructionsPopup(messageTxt, top, left, imgSrc, removeCallback = null){
			var message = document.createElement("p");

			var img = document.createElement("img");
			img.src = imgSrc;
			img.style.float = "left";
			img.style.height = "30%";
			img.style.width = "auto";
			img.style.marginRight = "20px";

			message.appendChild(img);

			var removeButton = document.createElement("a");

			removeButton.style.cursor = "pointer";
			removeButton.style.textDecoration = "none";
			removeButton.style.color = "purple";
			removeButton.style.padding = "10px";
			removeButton.style.backgroundColor = "white";
			removeButton.style.border = "solid 2px purple";
			removeButton.style.marginTop = "30px";
			removeButton.style.clear = "both";
			removeButton.style.borderRadius = "10%";

			removeButton.appendChild(document.createTextNode("Got It!"));

			removeButton.addEventListener("mouseenter", function(){
				removeButton.style.textShadow = "2px 2px red";
			});

			removeButton.addEventListener("mouseleave", function(){
				removeButton.style.textShadow = "none";
			});

			removeButton.addEventListener("click", function(){

				
				message.remove();

				if(typeof(removeCallback) == "function"){
					removeCallback();
				}
			});


			message.style.position = 'absolute';
			message.style.display = 'block';
			

			message.style.width = '500px';
			message.style.height = '200px';
			message.style.overflowY = 'scroll';

			message.style.padding = "10px";
			message.style.paddingTop = '20px';
			message.style.fontFamily = UIGenerator.Fonts.Bangers;
			message.style.color = "white";
			message.style.textShadow = "2px 2px purple";
			message.style.borderRadius = "10%";
			message.style.fontSize = "1.8em";

			message.style.backgroundColor = "#A2CFF3";
			message.style.border = "solid 2px #FC9E80";

			message.style.top = top +'px';
			message.style.left = left +'px';
			message.appendChild(document.createTextNode(messageTxt));
			
			var breakElement = document.createElement("br");
	
			message.appendChild(breakElement);
			message.appendChild(removeButton);

			return message;
	}

	static CreateGameFinishedMessage(messageTxt, top, left, imgSrc, removeCallback = null){
			var message = document.createElement("p");

			var img = document.createElement("img");
			img.src = imgSrc;
			img.style.float = "left";
			img.style.height = "90%";
			img.style.width = "auto";
			img.style.marginRight = "20px";

			message.appendChild(img);

			var removeButton = document.createElement("a");
			removeButton.style.cursor = "pointer";
			

			removeButton.appendChild(document.createTextNode("Play Again"));

			removeButton.addEventListener("mouseenter", function(){
				removeButton.style.textShadow = "2px 2px red";
			});

			removeButton.addEventListener("mouseleave", function(){
				removeButton.style.textShadow = "none";
			});

			removeButton.addEventListener("click", function(){

				
				message.remove();
				window.location.reload();

				if(typeof(removeCallback) == "function"){
					removeCallback();
				}
			});


			message.style.position = 'absolute';
			message.style.display = 'block';
			

			message.style.width = '700px';
			message.style.height = '200px';
			message.style.padding = "10px";
			message.style.paddingTop = '20px';
			message.style.fontFamily = UIGenerator.Fonts.Bangers;
			message.style.color = "white";
			message.style.borderRadius = "10%";
			message.style.fontSize = "2em";

			message.style.backgroundColor = "purple";
			message.style.border = "solid 2px #FC9E80";
			message.style.top = top +'px';
			message.style.left = left +'px';

			var txtNode = document.createTextNode(messageTxt);
			message.appendChild(txtNode);
			
			var breakElement = document.createElement("br");
	
			message.appendChild(breakElement);
			message.appendChild(breakElement);

			message.appendChild(removeButton);

			return message;
	}

	static CreateTitleBanner(text,backgroundImgSrc = "/assets/Banners/bannerScroll.png"){
			var title = document.createElement("p");

			title.style.backgroundImage = 'url('+ backgroundImgSrc + ')';
			title.style.backgroundRepeat = 'no-repeat';

			title.style.position = 'absolute';
			title.style.display = 'block';
			title.style.textAlign = 'center';
			title.style.width = '250px';
			title.style.height = '50px';
			title.style.padding = "10px";
			title.style.paddingTop = '20px';
			title.style.fontFamily = UIGenerator.Fonts.Bangers;
			title.style.color = "white";
			title.style.fontSize = "1.2em";
			title.style.transform = "scale(1.2)";

			title.style.top = 5 +'px';
			title.style.left = 300 +'px';
			title.appendChild(document.createTextNode(text));
			return title;
	}

	static ConfigureCanvas(canvas){

		canvas.style.width = GAME_SETTINGS.getScreenWidth() + "px";
		canvas.style.height = GAME_SETTINGS.getScreenHeight() + "px";
		canvas.style.border = "white 1px solid";
		canvas.style.backgroundColor = "white";
		canvas.style.position = "absolute";
		canvas.style.top = "10%";
		canvas.style.left = "10%";
		canvas.style.zIndex = 0;
	}

	static ConfigureMenuButton(button,topDistance){

			button.style.position = "absolute";
			button.style.top = topDistance;
			button.style.right = "10%";
			button.style.width = 250 + "px";
			button.style.height = 30 + "px";
			button.style.textAlign = "center";
			button.style.backgroundImage = "url(assets/Banners/bannerModern.png)";
			button.style.backgroundRepeat = 'no-repeat';
			button.style.cursor = "pointer";

			button.style.padding = "10px";
			button.style.fontSize = "1.4em";
			button.style.color = "white";
			button.style.fontFamily = UIGenerator.Fonts.SigmarOne;
	}
}