
(function ($) {
  // Липкая шапка
  window.onscroll = function () {
    sticky_menu()
  };

  let menu = document.getElementById("menu");
  let sticky = menu.offsetTop;

  function sticky_menu() {
    if (window.pageYOffset >= sticky) {
      menu.classList.add("sticky");
    } else {
      menu.classList.remove("sticky");
    }
  }

  $(function () {

    let filter = $("[data-filter]");

    filter.on("click", function (event) {
      event.preventDefault();

      let category = $(this).data('filter');

      if (category === 'all') {
        $("[data-category]").removeClass("hide");
      } else {
        $("[data-category]").each(function () {
          let workCat = $(this).data('category');

          if (workCat !== category) {
            $(this).addClass('hide');
          } else {
            $(this).removeClass('hide');
          }
        });
      }
    });
  });

})(jQuery);


// всплывающий контент при скролле

function onEntry(entry) {
    entry.forEach(change => {
        if (change.isIntersecting) {
            change.target.classList.add('element-show');
        }
    });
}

let options = {
    threshold: [0.1]
};
let observer = new IntersectionObserver(onEntry, options);
let elements = document.querySelectorAll('.pop-up-content');

for (let elm of elements) {
    observer.observe(elm);
}


