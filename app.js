window.onload = function() {
    let firstContent = SliderDom.querySelector('.item:nth-child(1) .content');
    firstContent.style.opacity = 1;

    let otherContents = SliderDom.querySelectorAll('.item:nth-child(n+2) .content');
    otherContents.forEach(content => {
        content.style.opacity = 0;
    });

    clearTimeout(runNextAuto);
    runNextAuto = setTimeout(() => {
        nextDom.click();
    }, timeAutoNext);

    setTimeout(() => {
        nextDom.click();
    }, 1000);  // Delay of 1 second for the first transition
    
};


let nextDom = document.getElementById('next');
let prevDom = document.getElementById('prev');

let carouselDom = document.querySelector('.carousel-e');
let SliderDom = carouselDom.querySelector('.list');
let thumbnailBorderDom = carouselDom.querySelector('.thumbnail');
let timeDom = carouselDom.querySelector('.time');

let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);

let timeRunning = 3000;
let timeAutoNext = 7000;

nextDom.onclick = function() {
    showSlider('next');
};

prevDom.onclick = function() {
    showSlider('prev');
};

let runTimeOut;
let runNextAuto = setTimeout(() => {
    nextDom.click();
}, timeAutoNext);

function showSlider(type) {
    let SliderItemsDom = SliderDom.querySelectorAll('.item');
    let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');

    // Clear any existing timeouts to prevent conflicts
    clearTimeout(runTimeOut);
    clearTimeout(runNextAuto);

    // Hide content of the current item
    let currentContent = SliderDom.querySelector('.item:nth-child(1) .content');
    currentContent.style.opacity = 0;
    currentContent.style.transition = 'opacity 0.3s ease'; // Faster transition

    // Immediate transition without delay
    if (type === 'next') {
        SliderDom.appendChild(SliderItemsDom[0]);
        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
        carouselDom.classList.add('next');
    } else {
        SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
        thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
        carouselDom.classList.add('prev');
    }

    // Reset and show the content of the new first item
    let newContent = SliderDom.querySelector('.item:nth-child(1) .content');
    newContent.style.opacity = 1;
    newContent.style.transition = 'opacity 0.3s ease'; // Faster transition

    // Shorter timeout for removing classes
    runTimeOut = setTimeout(() => {
        carouselDom.classList.remove('next');
        carouselDom.classList.remove('prev');
    }, 1500); // Reduced from 3000ms to 1500ms

    // Restart auto-advance
    runNextAuto = setTimeout(() => {
        nextDom.click();
    }, timeAutoNext);
}
