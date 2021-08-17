class UIGenerator{

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