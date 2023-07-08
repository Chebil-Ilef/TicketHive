"use strict";

///////////////////////////////
// Selecting elements

const modal = document.querySelector(".modal");
const overlay = document.querySelector(".overlay");
const btnCloseModal = document.querySelector(".btn--close-modal");
const btnsOpenModal = document.querySelectorAll(".btn--show-modal");

const btnScrollTo = document.querySelector(".btn--scroll-to");
const section1 = document.querySelector("#section--1");

const tabs = document.querySelectorAll(".operations__tab");
const tabsContainer = document.querySelector(".operations__tab-container");
const tabsContent = document.querySelectorAll(".operations__content");

const nav = document.querySelector(".nav");

// Modal window
const openModal = function (e) {
  e.preventDefault();
  modal.classList.remove("hidden");
  overlay.classList.remove("hidden");
};

const closeModal = function () {
  modal.classList.add("hidden");
  overlay.classList.add("hidden");
};

btnsOpenModal.forEach((btn) => btn.addEventListener("click", openModal));

btnCloseModal.addEventListener("click", closeModal);
overlay.addEventListener("click", closeModal);

document.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && !modal.classList.contains("hidden")) {
    closeModal();
  }
});

// Button Scrolling
btnScrollTo.addEventListener("click", function (e) {
  const s1coords = section1.getBoundingClientRect();
  section1.scrollIntoView({ behavior: "smooth" });
});

// Event Delegation
// 1. Add event listener to the common parent element
// 2. Determine what element originated the event

document.querySelector(".nav__links").addEventListener("click", function (e) {
  e.preventDefault();
  

  // Matching strategy
  if (e.target.classList.contains("nav__link")) {
    const id = e.target.getAttribute("href");

    document.querySelector(id).scrollIntoView({ behavior: "smooth" });
  }
});

// Tabbed Component

tabsContainer.addEventListener("click", function (e) {
  const clicked = e.target.closest(".operations__tab");
  // console.log(clicked);

  // Guard clause
  if (!clicked) return;

  // Remove active classes
  tabs.forEach((t) => t.classList.remove("operations__tab--active"));
  tabsContent.forEach((c) => c.classList.remove("operations__content--active"));

  // Active tab
  clicked.classList.add("operations__tab--active");

  // Activate content area
  document
    .querySelector(`.operations__content--${clicked.dataset.tab}`)
    .classList.add("operations__content--active");
});

// Menu fade animations
const handleHover = function (e) {
  if (e.target.classList.contains("nav__link")) {
    const link = e.target;
    const siblings = link.closest(".nav").querySelectorAll(".nav__link");
    const logo = link.closest(".nav").querySelector("img");

    siblings.forEach((el) => {
      if (el !== link) el.style.opacity = this;
    });
    logo.style.opacity = this;
  }
};

nav.addEventListener("mouseover", handleHover.bind(0.5));

nav.addEventListener("mouseout", handleHover.bind(1));

// Sticky navigation
////////////////
const header = document.querySelector(".header");
const navHeight = nav.getBoundingClientRect();
// console.log(navHeight);

const stickyNav = function (entries) {
  const [entry] = entries;
  // console.log(entry);

  if (!entry.isIntersecting) nav.classList.add("sticky");
  else nav.classList.remove("sticky");
};

const headerObserver = new IntersectionObserver(stickyNav, {
  root: null,
  threshold: 0,
  rootMargin: `-${navHeight.height}px`,
});
headerObserver.observe(header);

// Reveal sections
const allSections = document.querySelectorAll(".section");

const revealSection = function (entries, observer) {
  const [entry] = entries;
  // console.log(entry);

  // Guard clause
  if (!entry.isIntersecting) return;
  entry.target.classList.remove("section--hidden");
  // stop unobserving once they've intersected
  observer.unobserve(entry.target);
};

const sectionObserver = new IntersectionObserver(revealSection, {
  root: null,
  threshold: 0.15,
});

allSections.forEach(function (section) {
  sectionObserver.observe(section);
  // section.classList.add('section--hidden');
});

// Slider
const slider = function () {
  const slides = document.querySelectorAll(".slide");
  const btnLeft = document.querySelector(".slider__btn--left");
  const btnRight = document.querySelector(".slider__btn--right");
  const dotContainer = document.querySelector(".dots");

  let curSlide = 0;
  const maxSlides = slides.length;

  // const slider = document.querySelector('.slider');
  // slider.style.transform = 'scale(0.4) translateX(-800px)';
  // slider.style.overflow = 'visible';

  // Functions
  const createDots = function () {
    slides.forEach(function (_, i) {
      dotContainer.insertAdjacentHTML(
        "beforeend",
        `<button class="dots__dot" data-slide="${i}" ></button>`
      );
    });
  };

  const activateDot = function (slide) {
    document
      .querySelectorAll(".dots__dot")
      .forEach((dot) => dot.classList.remove("dots__dot--active"));

    document
      .querySelector(`.dots__dot[data-slide="${slide}"]`)
      .classList.add("dots__dot--active");
  };

  const goToSlide = function (slide) {
    slides.forEach(
      (s, i) => (s.style.transform = `translateX(${100 * (i - slide)}%)`)
    );
  };

  // Next slide
  const nextSlide = function () {
    curSlide = (curSlide + 1) % maxSlides;

    goToSlide(curSlide);
    activateDot(curSlide);
  };

  const prevSlide = function () {
    curSlide = (curSlide + maxSlides - 1) % maxSlides;
    goToSlide(curSlide);
    activateDot(curSlide);
  };

  const init = function () {
    createDots();
    activateDot(0);
    goToSlide(0);
  };
  init();

  // Event handlers
  btnRight.addEventListener("click", nextSlide);
  btnLeft.addEventListener("click", prevSlide);

  document.addEventListener("keydown", function (e) {
    if (e.key === "ArrowLeft") prevSlide();
    if (e.key === "ArrowRight") nextSlide();
  });

  dotContainer.addEventListener("click", function (e) {
    if (e.target.classList.contains("dots__dot")) {
      // console.log('DOT');
      const { slide } = e.target.dataset;
      // console.log(slide);
      goToSlide(slide);
      activateDot(slide);
      curSlide = slide;
    }
  });
};
slider();


/*******Letter By Letter Animation CSS+JS********/
const catalogueText = document.querySelector('.catalogue-animation');
const letters = catalogueText.textContent.split('');

catalogueText.textContent = '';

function animateLetters() {
  letters.forEach((letter, index) => {
    const span = document.createElement('span');
    span.textContent = letter;
    span.style.animationDelay = `${0.1 * index}s`;
    catalogueText.append(span);
  });

  setTimeout(() => {
    const spans = catalogueText.querySelectorAll('span');

    spans.forEach((span) => {
      span.remove();
    });

    animateLetters();
  }, 5000);
}

animateLetters();


//dropdown for user to update , addevent and logout

const button_profile = document.getElementById('userprofile')
const updateli = document.querySelector('#update')
const addeventli = document.querySelector('#addevent')
const logoutli = document.querySelector('#logout')


updateli.addEventListener('click',()=>{
  window.location.href = "http://localhost:8000/update";
})


button_profile.addEventListener('click',()=>{
  document.querySelector('.dropdown-user').style.opacity = 1-document.querySelector('.dropdown-user').style.opacity
})


logoutli.addEventListener('click',()=>{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost:8000/delete', true);
    //xhr.open("POST","{{path('delete_session')}}",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = ()=>{
      location.reload();
    }
    xhr.send();
    //console.log(sessionStorage);
    //sessionStorage.removeItem('username');
    //location.reload();
})

//go to addevent page

addeventli.addEventListener('click',()=>{
  window.location.href = "http://localhost:8000/addEvent";
})


/***CART FUNCTIONALITY START***/
    // CART WINDOW JS
// Find the cart icon link and the cart modal container
const openCartIcon = document.getElementById('open-cart-icon');
const cartModalContainer = document.querySelector('.modal-container');
const closeButton = document.querySelector('.close-button');
// Show the cart modal container
openCartIcon.addEventListener('click', () => cartModalContainer.classList.remove('hidden'));
// Hide the cart modal container
closeButton.addEventListener('click', () => cartModalContainer.classList.add('hidden'));

// Get DOM elements

const cartItemsContainer = document.querySelector('.cart-items-container');
const cartQuantityInputs = document.querySelectorAll('.cart-quantity');
const cartPriceElements = document.querySelectorAll('.cart-price');
const totalPriceElement = document.querySelector('#total-price');



// Increase or decrease cart item quantity
cartQuantityInputs.forEach((input) => {
  input.addEventListener('change', () => {
    const itemPrice = input.parentElement.querySelector('.cart-price').getAttribute('data-initial-price');
    const newQuantity = input.value;
    const newPrice = itemPrice * newQuantity;
    input.parentElement.querySelector('.cart-price').textContent = newPrice;
    calculateTotalPrice();
  });
});



// Calculate total cart price
function calculateTotalPrice() {
  let totalPrice = 0;
  cartPriceElements.forEach((element) => {
    totalPrice += parseInt(element.textContent);
  });
  totalPriceElement.textContent = totalPrice;
}


/*stoppinng the user from entering invalid quantity not in range of min and max START*/
const quantityInputs = document.querySelectorAll('.cart-quantity');
const checkoutButton = document.querySelector('#checkout-btn');


// Checkout button click event

if(checkoutButton){
checkoutButton.addEventListener('click', () => {
  // Check if quantity is valid
  let isValid = true;
  cartQuantityInputs.forEach((input) => {
    const maxQuantity = parseInt(input.getAttribute('max'));
    const currentQuantity = parseInt(input.value);
    if (currentQuantity < 1 || currentQuantity > maxQuantity) {
      isValid = false;
      input.classList.add('error');
    } else {
      input.classList.remove('error');
    }
  });
  // Submit form if quantity is valid
  if (isValid) {
    checkoutButton.closest('form').submit();
  }
});
}

// Close modal when close button or overlay is clicked
closeButton.addEventListener('click', closeModal);
overlay.addEventListener('click', closeModal);

/***CART FUNCTIONALITY END***/

