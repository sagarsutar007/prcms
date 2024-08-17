import { useEffect } from "react";

const Preloader = () => {
	useEffect(() => {
		const squareBlock = document.querySelector(".square-block");
		const preloadBlock = document.getElementById("preload-block");

		const hidePreloader = () => {
			if (squareBlock) {
				squareBlock.style.transition = "opacity 0.5s ease-out";
				squareBlock.style.opacity = "0";
				setTimeout(() => {
					squareBlock.style.display = "none";
				}, 500);
			}

			if (preloadBlock) {
				preloadBlock.style.transition = "opacity 0.5s ease-out";
				preloadBlock.style.opacity = "0";
				setTimeout(() => {
					preloadBlock.style.display = "none";
				}, 500);
			}
		};

		window.addEventListener("load", hidePreloader);

		return () => window.removeEventListener("load", hidePreloader);
	}, []);

	return (
		<div id="preload-block">
			<div className="square-block"></div>
		</div>
	);
};

export default Preloader;
