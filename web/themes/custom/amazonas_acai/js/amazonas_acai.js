/**
 * @file
 * Placeholder file for custom sub-theme behaviors.
 *
 */
(function ($, Drupal) {

  /**
   * Use this behavior as a template for custom Javascript.
   */
  Drupal.behaviors.exampleBehavior = {
    attach: function (context, settings) {
      //alert("I'm alive!");
      (function () {
        window.addEventListener('scroll', function () {
          document.querySelectorAll('.hero-banner').forEach((section) => {
            const bg = section.querySelector('.hero-banner-bg');
            const rect = section.getBoundingClientRect();

            if (bg && rect.top < window.innerHeight && rect.bottom > 0) {
              const offset = rect.top * 0.1;

              bg.style.transform = `scale(2) translateY(${offset}px)`;
            }
          });
        });
      })();


        const elements = document.querySelectorAll('.fade-up');

        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible');
            }
          });
        }, {
          threshold: 0.3
        });

        elements.forEach(el => observer.observe(el));
    }
  };

})(jQuery, Drupal);
