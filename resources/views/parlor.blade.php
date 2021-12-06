@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')
        <script src="{{asset('./js/hc-sticky.js')}}"></script>
        <div class="list-container">
            <div class="container">
                <div class="list-content">
                    <div class="breadcrumb">
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-list-item typography-caption">
                                <a href="">Falano</a>
                            </li>
                            <li class="breadcrumb-list-item typography-caption">
                                <a href="">Dhiskano</a>
                            </li>
                            <li class="breadcrumb-list-item typography-caption">
                                <a href="">Samaj</a>
                            </li>
                            <li class="breadcrumb-list-item typography-caption">
                                <a href="">Jutta</a>
                            </li>                            
                            <li class="breadcrumb-list-name typography-caption">
                                Dhiskano
                            </li>
                        </ul>
                    </div>
                    <div class="list-content-grid">
                        <div class="list-content-grid-left">
                            <div id="videoContainer" data-fullscreen="false">
                                <video id="video" controls preload="metadata" poster="http://127.0.0.1:8000/img/cover.jpg" autoplay muted>
                                    <source src="http://127.0.0.1:8000/videos/1.mp4" type="video/mp4">
                                </video>
                                <div id="video-controls" class="controls" data-state="hidden">
                                    <div>                                        
                                        <button id="playpause" type="button" data-state="play">Play/Pause</button>
                                        <button id="mute" type="button" data-state="mute">Mute/Unmute</button>
                                    </div>
                                    <div class="progress">
                                        <progress id="progress" value="0" min="0">
                                            <span id="progress-bar"></span>
                                        </progress>
                                    </div>
                                    <div>                                        
                                        <button id="fs" type="button" data-state="go-fullscreen">Fullscreen</button>
                                    </div>
                                </div>
                            </div>
                            <div class="list-images">
                                
                            <script>
                                (function () {
	'use strict';

	// Does the browser actually support the video element?
	var supportsVideo = !!document.createElement('video').canPlayType;

	if (supportsVideo) {
		// Obtain handles to main elements
		var videoContainer = document.getElementById('videoContainer');
		var video = document.getElementById('video');
		var videoControls = document.getElementById('video-controls');

		// Hide the default controls
		video.controls = false;

		// Display the user defined video controls
		videoControls.setAttribute('data-state', 'visible');

		// Obtain handles to buttons and other elements
		var playpause = document.getElementById('playpause');
		var stop = document.getElementById('stop');
		var mute = document.getElementById('mute');
		var volinc = document.getElementById('volinc');
		var voldec = document.getElementById('voldec');
		var progress = document.getElementById('progress');
		var progressBar = document.getElementById('progress-bar');
		var fullscreen = document.getElementById('fs');

		// If the browser doesn't support the progress element, set its state for some different styling
		var supportsProgress = (document.createElement('progress').max !== undefined);
		if (!supportsProgress) progress.setAttribute('data-state', 'fake');

		// Check if the browser supports the Fullscreen API
		var fullScreenEnabled = !!(document.fullscreenEnabled || document.mozFullScreenEnabled || document.msFullscreenEnabled || document.webkitSupportsFullscreen || document.webkitFullscreenEnabled || document.createElement('video').webkitRequestFullScreen);
		// If the browser doesn't support the Fulscreen API then hide the fullscreen button
		if (!fullScreenEnabled) {
			fullscreen.style.display = 'none';
		}

		// Set the video container's fullscreen state
		var setFullscreenData = function(state) {
			videoContainer.setAttribute('data-fullscreen', !!state);
			// Set the fullscreen button's 'data-state' which allows the correct button image to be set via CSS
			fullscreen.setAttribute('data-state', !!state ? 'cancel-fullscreen' : 'go-fullscreen');
		}

		// Checks if the document is currently in fullscreen mode
		var isFullScreen = function() {
			return !!(document.fullScreen || document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement || document.fullscreenElement);
		}

		// Fullscreen
		var handleFullscreen = function() {
			// If fullscreen mode is active...	
			if (isFullScreen()) {
					// ...exit fullscreen mode
					// (Note: this can only be called on document)
					if (document.exitFullscreen) document.exitFullscreen();
					else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
					else if (document.webkitCancelFullScreen) document.webkitCancelFullScreen();
					else if (document.msExitFullscreen) document.msExitFullscreen();
					setFullscreenData(false);
				}
				else {
					// ...otherwise enter fullscreen mode
					// (Note: can be called on document, but here the specific element is used as it will also ensure that the element's children, e.g. the custom controls, go fullscreen also)
					if (videoContainer.requestFullscreen) videoContainer.requestFullscreen();
					else if (videoContainer.mozRequestFullScreen) videoContainer.mozRequestFullScreen();
					else if (videoContainer.webkitRequestFullScreen) {
						// Safari 5.1 only allows proper fullscreen on the video element. This also works fine on other WebKit browsers as the following CSS (set in styles.css) hides the default controls that appear again, and 
						// ensures that our custom controls are visible:
						// figure[data-fullscreen=true] video::-webkit-media-controls { display:none !important; }
						// figure[data-fullscreen=true] .controls { z-index:2147483647; }
						video.webkitRequestFullScreen();
					}
					else if (videoContainer.msRequestFullscreen) videoContainer.msRequestFullscreen();
					setFullscreenData(true);
				}
			}

		// Only add the events if addEventListener is supported (IE8 and less don't support it, but that will use Flash anyway)
		if (document.addEventListener) {
			// Wait for the video's meta data to be loaded, then set the progress bar's max value to the duration of the video
			video.addEventListener('loadedmetadata', function() {
				progress.setAttribute('max', video.duration);
			});

			// Changes the button state of certain button's so the correct visuals can be displayed with CSS
			var changeButtonState = function(type) {
				// Play/Pause button
				if (type == 'playpause') {
					if (video.paused || video.ended) {
						playpause.setAttribute('data-state', 'play');
					}
					else {
						playpause.setAttribute('data-state', 'pause');
					}
				}
				// Mute button
				else if (type == 'mute') {
					mute.setAttribute('data-state', video.muted ? 'unmute' : 'mute');
				}
			}

			// Add event listeners for video specific events
			video.addEventListener('play', function() {
				changeButtonState('playpause');
			}, false);
			video.addEventListener('pause', function() {
				changeButtonState('playpause');
			}, false);

			// Add events for all buttons			
			playpause.addEventListener('click', function(e) {
				if (video.paused || video.ended) video.play();
				else video.pause();
			});
			mute.addEventListener('click', function(e) {
				video.muted = !video.muted;
				changeButtonState('mute');
			});
			fs.addEventListener('click', function(e) {
				handleFullscreen();
			});

			// As the video is playing, update the progress bar
			video.addEventListener('timeupdate', function() {
            progress.value = video.currentTime;
            progressBar.style.width = Math.floor((video.currentTime / video.duration) * 100) + '%';
            });

            // React to the user clicking within the progress bar
			progress.addEventListener('click', function(e) {
				//var pos = (e.pageX  - this.offsetLeft) / this.offsetWidth; // Also need to take the parent into account here as .controls now has position:relative
				console.log(e.target.parentElement.previousElementSibling.clientWidth);
                console.log(e.pageX);
                var pos = (e.pageX - e.target.getBoundingClientRect().left + e.target.parentElement.previousElementSibling.clientWidth  - (this.offsetLeft + this.offsetParent.offsetLeft)) / this.offsetWidth;
				video.currentTime = pos * video.duration;
			});

			// Listen for fullscreen change events (from other controls, e.g. right clicking on the video itself)
			document.addEventListener('fullscreenchange', function(e) {
				setFullscreenData(!!(document.fullScreen || document.fullscreenElement));
			});
			document.addEventListener('webkitfullscreenchange', function() {
				setFullscreenData(!!document.webkitIsFullScreen);
			});
			document.addEventListener('mozfullscreenchange', function() {
				setFullscreenData(!!document.mozFullScreen);
			});
			document.addEventListener('msfullscreenchange', function() {
				setFullscreenData(!!document.msFullscreenElement);
			});
		}
	 }

 })();
                            </script>

                                <img src="{{asset('./img/1a9f2a4a-e613-4dfe-b871-1a2ec4841f04.webp')}}" alt="">
                                <img src="{{asset('./img/e1c01595-f826-43ff-8370-03846f6c99ea.webp')}}" alt="">
                                <img src="{{asset('./img/f6a23d02-bf08-4ae1-835f-b935fac81136.webp')}}" alt="">
                                <img src="{{asset('./img/1611686990_3SN231YKA_H061_E09_GH.webp')}}" alt="">
                                
                            </div>
                            <div>
                                <div>
                                    <p>In this series titled ‘Simple Pleasures’ we worked with graphic artist Lucy Sherston to create a range where each artwork represents a small, joyous moment in life. Lucy has brought an incredible sense of life to the collaboration through her expert use of colour, shape and handmade elements.</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="list-content-grid-right">
                            <div class="list-content-margin">
                                <div class="list-meta">
                                    <h1 class="typography-headline4 list-meta-title">Falano Dhiskano Shoes</h1>
                                    <div class="studio-rating">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#888888" stroke="currentColor" stroke-width="0" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span>4.6</span><a href="#">Lekhne Korne Studio</a>
                                    </div>
                                </div>
                                <div class="divider-bar"></div>
                                <div class="list-custom">
                                    <div class="list-custom-variation-option">
                                        <div class="custom-select-wrapper">
                                            <div class="custom-select typography-body2">
                                                <div class="custom-select__trigger"><span>Select your size</span>
                                                    <div class="arrow"></div>
                                                </div>
                                                <div class="custom-options">
                                                    <span class="custom-option selected" data-value="tesla">Small</span>
                                                    <span class="custom-option" data-value="volvo">Medium</span>
                                                    <span class="custom-option" data-value="mercedes">Large</span>
                                                    <span class="custom-option" data-value="mercedes">Extra Large</span>
                                                    <span class="custom-option" data-value="mercedes">Extra Extra Large</span>
                                                    <span class="custom-option" data-value="mercedes">Big as House</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    for (const dropdown of document.querySelectorAll(".custom-select-wrapper")) {
                                        dropdown.addEventListener('click', function () {
                                            this.querySelector('.custom-select').classList.toggle('open');
                                        })
                                    }

                                    for (const option of document.querySelectorAll(".custom-option")) {
                                        option.addEventListener('click', function () {
                                            if (!this.classList.contains('selected')) {
                                                this.parentNode.querySelector('.custom-option.selected').classList.remove('selected');
                                                this.classList.add('selected');
                                                this.closest('.custom-select').querySelector('.custom-select__trigger span').textContent = this.textContent;
                                            }
                                        })
                                    }

                                    window.addEventListener('click', function (e) {
                                        for (const select of document.querySelectorAll('.custom-select')) {
                                            if (!select.contains(e.target)) {
                                                select.classList.remove('open');
                                            }
                                        }
                                    });

                                    function selectOption(index) {
                                        var optionOnIdx = document.querySelector('.custom-option:nth-child('+index+')');
                                    var optionSelected = document.querySelector('.custom-option.selected');
                                    if (optionOnIdx !== optionSelected) {
                                        optionSelected.parentNode.querySelector('.custom-option.selected').classList.remove('selected');
                                                optionOnIdx.classList.add('selected');
                                                optionOnIdx.closest('.custom-select').querySelector('.custom-select__trigger span').textContent = optionOnIdx.textContent;
                                            }
                                    }
                                </script>
                                <div class="divider-bar"></div>
                                <div class="price-section">
                                    <div class="price-section-wrapper">
                                        <span class="typography-headline5">Rs. 5,250</span>
                                        <div class="product-action">
                                            <button class="btn-third btn-normalize bag-btn bag">Add to Bag</button>
                                            <button class="btn-normalize fav-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider-bar"></div>
                                <div class="report-list">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-flag"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                                    <a href="#" class="typography-caption">Report this listing</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="review mt">
            <div class="container">
                <div class="review-wrapper">
                    <div class="review-summery">
                        <div class="review-summery-header">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#888888" stroke="currentColor" stroke-width="0" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                            <div class="typography-headline5">
                                <span>4.5 (10 reviews)</span>
                            </div>                            
                        </div>
                        <div class="review-summery-table">
                            <div class="review-summery-rating">
                                <div class="review-summery-rating-bar-wrapper">
                                    <div class="ok">5 Star</div>
                                    <div class="review-summery-rating-bar">
                                        <div class="review-summery-rating-bar-progress" style="width:70%"></div>
                                    </div>
                                    <div class="suppery-right">70%</div>
                                </div>
                                <div class="review-summery-rating-bar-wrapper">
                                    <div class="ok">4 Star</div>
                                    <div class="review-summery-rating-bar">
                                        <div class="review-summery-rating-bar-progress" style="width:15%"></div>
                                    </div>
                                    <div class="suppery-right">70%</div>
                                </div>
                                <div class="review-summery-rating-bar-wrapper">
                                    <div class="ok">3 Star</div>
                                    <div class="review-summery-rating-bar">
                                        <div class="review-summery-rating-bar-progress" style="width:5%"></div>
                                    </div>
                                    <div class="suppery-right">70%</div>
                                </div>
                                <div class="review-summery-rating-bar-wrapper">
                                    <div class="ok">2 Star</div>
                                    <div class="review-summery-rating-bar">
                                        <div class="review-summery-rating-bar-progress" style="width:0%"></div>
                                    </div>
                                    <div class="suppery-right">0</div>
                                </div>
                                <div class="review-summery-rating-bar-wrapper">
                                    <div class="ok">1 Star</div>
                                    <div class="review-summery-rating-bar">
                                        <div class="review-summery-rating-bar-progress" style="width:10%"></div>
                                    </div>
                                    <div class="suppery-right">1</div>
                                </div>
                            </div>
                            <div>
                                Dhiskano
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
        

  <script>
    "use strict";

    var elements = document.getElementsByClassName('list-content-grid-right');

    for (var i = 0; i < elements.length; i++) {
      new hcSticky(elements[i], {
        stickTo: elements[i].parentNode,
        top: 100
      });
    }

  </script>

@endsection