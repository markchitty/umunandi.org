// Umunandi global
var Umunandi = Umunandi || {};

(function (Umunandi) {

  function onClick(e) {
    e.preventDefault();
    $('.price-box').removeClass('active');
    $(this).addClass('active');
  }

  function sponsorPage() {
    $('.price-box').off().on('click', onClick);
  }

  // export
  Umunandi.sponsor = sponsorPage;

})(Umunandi);
