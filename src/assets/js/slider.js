document.addEventListener('DOMContentLoaded', function() {
    const heroSlider = document.getElementById('hero-slider');
    const sliderImage = document.getElementById('slider-img');
    if (!sliderImage || !heroSlider) return;

    const imageSources = [
        './assets/img/Slider1.png',
        './assets/img/Slider2.png',
        './assets/img/Slider3.png'
    ];
    let currentImageIndex = 0;
    const fadeDuration = 1500;
    const displayDuration = 3500; 
    const totalCycleTime = fadeDuration + displayDuration; 

    function cycleSlider() {
        sliderImage.classList.add('fade-out');
        sliderImage.classList.remove('fade-in');

        const nextImageIndex = (currentImageIndex + 1) % imageSources.length;
        const nextImageSrc = imageSources[nextImageIndex];

        heroSlider.style.backgroundImage = `url('${nextImageSrc}')`;

        setTimeout(() => {
            sliderImage.src = nextImageSrc;
            currentImageIndex = nextImageIndex;
            sliderImage.classList.add('fade-in');
            sliderImage.classList.remove('fade-out');
        }, fadeDuration); 
    }
    sliderImage.src = imageSources[0]; 
    sliderImage.classList.add('fade-in'); 
    heroSlider.style.backgroundImage = `url('${imageSources[1]}')`;
    
    setInterval(cycleSlider, totalCycleTime);
});