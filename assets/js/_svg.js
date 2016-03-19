
// var path = document.querySelector('.logo path');
var pathone = document.querySelector('.play-btn path.two');
var pathtwo = document.querySelector('.play-btn path.three');
// var paththree = document.querySelector('.play-btn polygon');

// var length = path.getTotalLength();
var lengthone = pathone.getTotalLength();
console.log(lengthone);
var lengthtwo = pathtwo.getTotalLength();
console.log(lengthtwo);
// var lengththree = paththree.getTotalLength();

console.log(pathone.style);
// Clear any previous transition
pathone.style.transition = pathone.style.WebkitTransition = 'none';
pathtwo.style.transition = pathtwo.style.WebkitTransition = 'none';
// paththree.style.transition = paththree.style.WebkitTransition = 'none';

// Set up the starting positions
pathone.style.strokeDasharray = lengthone + ' ' + lengthone;
pathone.style.strokeDashoffset = lengthone;
pathtwo.style.strokeDasharray = lengthtwo + ' ' + lengthtwo;
pathtwo.style.strokeDashoffset = lengthtwo;
// paththree.style.strokeDasharray = lengththree + ' ' + lengththree;
// paththree.style.strokeDashoffset = lengththree;

// Trigger a layout so styles are calculated & the browser
// picks up the starting position before animating
pathone.getBoundingClientRect();
pathtwo.getBoundingClientRect();
// paththree.getBoundingClientRect();

// Define our transition
pathone.style.transition = pathone.style.WebkitTransition = 'stroke-dashoffset 2.5s ease-in-out';
pathtwo.style.transition = pathtwo.style.WebkitTransition = 'stroke-dashoffset 2.5s ease-in-out';
// paththree.style.transition = paththree.style.WebkitTransition = 'stroke-dashoffset 2.5s ease-in-out';

// Define our transition delay
pathone.style.transitionDelay="0.4s";
pathtwo.style.transitionDelay="0.6s";
// paththree.style.transitionDelay="0.2s";


// Go!
pathone.style.strokeDashoffset = '0';
pathtwo.style.strokeDashoffset = '0';
// paththree.style.strokeDashoffset = '0';