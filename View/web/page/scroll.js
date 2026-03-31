if ($('.container').length) {
  $('html, body').animate({
    scrollTop: $(hash).offset().top
  }, 900, '');
}