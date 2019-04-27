// Define a var to retrieve current page
// Used to ensure User doesn't cache uneccessary content
var getPage = [
	document.querySelector("#homePage"),
	document.querySelector("#productsPage"),
	document.querySelector("#templatePage")
]

// If the page is this...
if (getPage[0]) {
	// ...Load relevant evemts that are used on this page in a function
	this.onload = function() {
		callDatabase();
	}
} else if (getPage[1]) {
	this.onload = function () {
		openModal();
	}
} else if (getPage[2]) {
	this.onload = function() {
		createRow();
		fillInputs();
		updateInputs();
		updateTable();
		exportHandsetTable();
	}
};

// ---- Sidemenu ----
var sideNavOpenIcon = document.querySelector(".open-slider-icon");
var sideNav = document.querySelector(".sidenav");
var sideNavCloseIcon = document.querySelector(".close-slider-icon");
var backDrop = document.querySelector("#backdrop");

sideNavOpenIcon.addEventListener("click", function() {
	sideNav.style.marginLeft = "0px";
	backDrop.style.display = "block";
	backDrop.style.opacity = "0.65";
	backDrop.style.zIndex = "9";

	sideNavCloseIcon.addEventListener("click", function() {
		sideNav.style.marginLeft = "-235px";
		backDrop.style.display = "none";
		backDrop.style.opacity = "0";
		backDrop.style.zIndex = "0";
	});

	backDrop.addEventListener("click", function() {
		sideNav.style.marginLeft = "-235px";
		backDrop.style.display = "none";
		backDrop.style.opacity = "0";
		backDrop.style.zIndex = "0";
	})
});

// ---- Modal ----
var productZoom = document.querySelectorAll(".product-image");
var hiddenModal = document.querySelectorAll(".modal");
var closeIcon = document.querySelectorAll(".close-modal-icon");

function openModal() {
	productZoom[0].addEventListener("click", function() {
		hiddenModal[0].style.display = "block";
		closeIcon[0].addEventListener("click", function() {
			hiddenModal[0].style.display = "none";
		})
	});

	productZoom[1].addEventListener("click", function() {
		hiddenModal[1].style.display = "block";
		closeIcon[1].addEventListener("click", function() {
			hiddenModal[1].style.display = "none";
		})
	});

	productZoom[2].addEventListener("click", function() {
		hiddenModal[2].style.display = "block";
		closeIcon[2].addEventListener("click", function() {
			hiddenModal[2].style.display = "none";
		})
	});

	productZoom[3].addEventListener("click", function() {
		hiddenModal[3].style.display = "block";
		closeIcon[3].addEventListener("click", function() {
			hiddenModal[3].style.display = "none";
		})
	});

	productZoom[4].addEventListener("click", function() {
		hiddenModal[4].style.display = "block";
		closeIcon[4].addEventListener("click", function() {
			hiddenModal[4].style.display = "none";
		})
	});

	productZoom[5].addEventListener("click", function() {
		hiddenModal[5].style.display = "block";
		closeIcon[5].addEventListener("click", function() {
			hiddenModal[5].style.display = "none";
		})
	});

	productZoom[6].addEventListener("click", function() {
		hiddenModal[6].style.display = "block";
		closeIcon[6].addEventListener("click", function() {
			hiddenModal[6].style.display = "none";
		})
	});
};

document.onclick = function(evt) {
	if (evt.target == hiddenModal[0]) {
		hiddenModal[0].style.display = "none";
	} else if (evt.target == hiddenModal[1]) {
		hiddenModal[1].style.display = "none";
	} else if (evt.target == hiddenModal[2]) {
		hiddenModal[2].style.display = "none";
	} else if (evt.target == hiddenModal[3]) {
		hiddenModal[3].style.display = "none";
	} else if (evt.target == hiddenModal[4]) {
		hiddenModal[4].style.display = "none";
	} else if (evt.target == hiddenModal[5]) {
		hiddenModal[5].style.display = "none";
	} else if (evt.target == hiddenModal[6]) {
		hiddenModal[6].style.display = "none";
	}
}

// --- SERVICE WORKERS ---
// Check if Browser supports ServiceWorkers
if ("serviceWorker" in navigator) {
	window.addEventListener("load", function() {
		// Call our script which registers the Service Worker to the page
		navigator.serviceWorker.register("sw.js").then(function(registration) {
			// Return a success upon completion
			console.log("[Service Worker] Success:", registration.scope);
		}, function(err) {
			// Return a fail message upon incomplete or error
			console.log("[Service Worker] Error:", err);
		})
	})
};
// --- END SERVICE WORKERS ---
