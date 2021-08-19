class UIGenerator{

	static CreateGameFinishedMessage(messageTxt, top, left,removeCallback = null){
			var message = document.createElement("p");

			var medal = document.createElement("img");
			medal.src = "/assets/Medals/flat_medal1.png";
			medal.style.float = "left";
			medal.style.height = "90%";
			medal.style.width = "auto";
			medal.style.marginRight = "20px";

			message.appendChild(medal);

			var removeButton = document.createElement("a");

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
			

			message.style.width = '500px';
			message.style.height = '200px';
			message.style.padding = "10px";
			message.style.paddingTop = '20px';
			message.style.fontFamily = "Baskerville";
			message.style.color = "white";
			message.style.borderRadius = "10%";
			message.style.fontSize = "2em";

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

	static CreateTitleBanner(text){
			var title = document.createElement("p");

			title.style.backgroundImage = 'url(/assets/Banners/bannerScroll.png)';
			title.style.backgroundRepeat = 'no-repeat';

			title.style.position = 'absolute';
			title.style.display = 'block';
			title.style.textAlign = 'center';
			title.style.width = '250px';
			title.style.height = '50px';
			title.style.padding = "10px";
			title.style.paddingTop = '20px';
			title.style.fontFamily = "Baskerville";
			title.style.color = "white";
			title.style.transform = "scale(1.5)";

			title.style.top = 5 +'px';
			title.style.left = 300 +'px';
			title.appendChild(document.createTextNode(text));
			return title;
	}

	static ConfigureCanvas(canvas,width,height){

		canvas.style.width = width + "px";
		canvas.style.height = height + "px";
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

			button.style.padding = "10px";
			button.style.fontSize = "1.8em";
			button.style.color = "white";
			button.style.fontFamily = "Arial";
	}
}