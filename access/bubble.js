function createBubble() {
    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    bubble.style.left = `${Math.random() * window.innerWidth}px`;
    bubble.style.bottom = '0px';
    return bubble;
}
function animateBubble(bubble) {
    const duration = Math.random() * 1 + 3;
    bubble.style.animation = `float ${duration}s linear infinite`;
}
function createAnimatedHotel() {
    const light = document.createElement('i');
    light.className = 'fas fa-solid fa-hotel';
    light.style.left = `${Math.random() * window.innerWidth}px`;
    light.style.top = `${Math.random() * window.innerHeight}px`;
    return light;
}
function animateLight(light) {
    const duration = Math.random() * 10 + 5;
    light.style.animation = `fade ${duration}s linear infinite`;
}
document.addEventListener('DOMContentLoaded', function() {
    const bubblearea = document.getElementById('bubblearea');
    const numBubbles = 30;
    const animatedLightInterval = 4000;

    for (let i = 0; i < numBubbles; i++) {
        const bubble = createBubble();
        animateBubble(bubble);
        bubblearea.appendChild(bubble);
    }

    setInterval(function() {
        const light = createAnimatedHotel();
        animateLight(light);
        bubblearea.appendChild(light);
        light.addEventListener('animationend', function() {
            light.remove();
        });
    }, animatedLightInterval);
});