document.addEventListener("DOMContentLoaded", () => {
  /*после загрузки html загрузка js*/
  let slider = function () {
    /*Объявление функции для слайдера(из документации к библиотеке)*/
    const swiper = new Swiper("#review-slider-js", {
      calculateHeight: true,
      loop: true /* слайдер был бесконечный */,

      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },

      breakpoints: {
        320: {
          /*количество слайдов и расстояние между ними с 320px*/
          slidesPerView: 1,
          spaceBetween: 15,
        },
        820: {
          /*количество слайдов и расстояние между ними с 820px*/
          slidesPerView: 2,
          spaceBetween: 0,
        },
        1300: {
          /*количество слайдов и расстояние между ними с 1300px*/
          slidesPerView: 3,
          spaceBetween: 0,
        },
      },

      keyboard: true /*проматывание при адаптиве*/,
    });
  };
  slider();
});

// Аккордеон
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function () {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
//Бургер
/* Открыть, когда кто-то нажимает на элемент span */
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

/* Закрыть, когда кто-то нажимает на символ "x" внутри наложения */
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
