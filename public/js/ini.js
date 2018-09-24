$(document).ready(function(){
  $("body").on('click', 'button', function () {
      // Si el boton no tiene el atributo ajax no hacemos nada
      if ($(this).data('ajax') === undefined)
          return;

      // El metodo .data identifica la entrada y la castea al valor más correcto
      if ($(this).data('ajax') !== true)
          return;

      var form = $(this).closest("form");
      var button = $(this);
      var url = form.attr('action');

      if (button.data('confirm') !== undefined)
      {
          if (button.data('confirm') === '') {
              if (!confirm('¿Esta seguro de realizar esta acción?'))
                  return false;
          } else {
              if (!confirm(button.data('confirm')))
                  return false;
          }
      }

      if (button.data('delete') !== undefined)
      {
          if (button.data('delete') === true)
          {
              url = button.data('url');
          }
      }

      // Creamos un div que bloqueara todo el formulario
      var block = $('<div class="block-loading" />');
      form.prepend(block);

      // Alert container
      var alertContainer = form.find('.alert-container');
      alertContainer.html('');

      // Escondomes los errores
      form.find(".form-validation-failed").html('');

      form.ajaxSubmit({
          dataType: 'JSON',
          type: 'POST',
          url: url,
          success: function (r) {
              block.remove();

              if (r.response) {
                  if (!button.data('reset') !== undefined) {
                      if (button.data('reset'))
                          form.reset();
                  } else
                  {
                      form.find('input:file').val('');
                  }
              }

              // Mostrar mensaje
              if (r.message !== null) {
                  if (r.message.length > 0) {
                      var css = "";
                      if (r.response) {
                          css = "alert-success";
                      } else {
                          css = "alert-danger";
                      }

                      var message = '<div class="alert ' + css + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + r.message + '</div>';

                      if(alertContainer.length > 0){
                          alertContainer.html(message);
                      } else {
                          form.prepend(message);
                      }
                  }
              }

              // Validaciones
              if(r.validations !== null) {
                for(var k in r.validations) {
                    var vmessage = typeof(r.validations[k]) === 'array' ? r.validations[k][0] : r.validations[k];
                   form.find("[data-key='" + k + "']").html(vmessage);
                }
              }

              // Ejecutar funciones que son especificadas por el servidor
              if (r.function !== null) {
                  setTimeout(r.function, 0);
              }

              // Ejecutar funciones que son especificadas por el cliente
              if (button.data('success') !== undefined && r.response) {
                  setTimeout('{0}()'.format(button.data('success')), 0);
              }

              // Redireccionar
              if (r.href !== null) {
                  if (r.href === 'self') window.location.reload(true);
                  else redirect(r.href);
              }

              // Si el servidor retorno algo
              if (r.result !== null && button.data('result') !== undefined && r.response) {
                  var resultFunction = button.data('result') + '({0})';
                  resultFunction = resultFunction.format(JSON.stringify(r.result));
                  setTimeout(resultFunction, 0);
              }
          },
          error: function (jqXHR, textStatus, errorThrown) {
              if (jqXHR.status === 422) {
                  for (var k in jqXHR.responseJSON) {
                      var control = form.find('.validation-message[data-target="' + k + '"]');
                      control.text(jqXHR.responseJSON[k][0]);
                      control.css('display', 'block');
                  }
              } else {
                  var message = '<div class="alert alert-warning alert-dismissable response-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorThrown + ' | <b>' + textStatus + '</b></div>';

                  if(alertContainer.length > 0){
                      alertContainer.html(message);
                  }
              }

              block.remove();
          }
      });

      return false;
  })
})

if (!String.prototype.ucfirst) {
    String.prototype.ucfirst = function () {
        if(this.length > 0) {
          return this.substring(0, 1).toUpperCase() + this.substring(1, this.length);
        }
    }
}

if (!String.prototype.format) {
    String.prototype.format = function () {
        var text = this;

        for (var i = 0; i < arguments.length; i++) {
            text = text.replace("{" + i + "}", arguments[i]);
        }

        return text;
    }
}

if (!String.prototype.render) {
    String.prototype.render = function (obj) {
        var text = this;

        for (var k in obj) {
            text = text.replace("{" + k + "}", obj[k]);
        }

        return text;
    }
}

if (!Number.prototype.toMonth) {
    Number.prototype.toMonth = function () {
        var m = '';

        switch (parseInt(this)) {
            case 1:
                m = 'Enero';
                break;
            case 2:
                m = 'Febrero';
                break;
            case 3:
                m = 'Marzo';
                break;
            case 4:
                m = 'Abril';
                break;
            case 5:
                m = 'Mayo';
                break;
            case 6:
                m = 'Junio';
                break;
            case 7:
                m = 'Julio';
                break;
            case 8:
                m = 'Agosto';
                break;
            case 9:
                m = 'Setiembre';
                break;
            case 10:
                m = 'Octubre';
                break;
            case 11:
                m = 'Noviembre';
                break;
            case 12:
                m = 'Diciembre';
                break;
        }

        return m;
    };
}

if (!Number.prototype.format) {
    Number.prototype.format = function (decimals, moneySymbol) {
        decimals = decimals || 0;
        moneySymbol = moneySymbol || false;
        moneySymbol = moneySymbol ? 'USD' : '';

        return moneySymbol + this.toFixed(decimals).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    };
}

if (!Number.prototype.padLeft) {
    Number.prototype.padLeft = function (n) {
        n = n || 0;

        var zeros = '';

        for (var i = 0; i < n; i++) {
            zeros += '0';
        }

        return zeros.substring(0, zeros.length - this.toString().length) + this.toString();
    };
}

if (!moment.prototype.defaultFormat) {
    moment.prototype.defaultFormat = function () {
        return moment(this).format('DD/MM/YYYY');
    }
}

function mergeObjects(obj1, obj2) {
    for (var k in obj2) {
        obj1[k] = obj2[k];
    }

    return obj1;
}

function isNullOrEmpty(x) {
    if (x === undefined) return true;
    if (x === null) return true;
    if (x.toString().trim().length === 0) return true;
}

function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

jQuery.fn.reset = function () {
  $("input", $(this)).each(function(){
    var type = $(this).attr('type');

    if(type === 'checkbox' && $(this).is('checked')) {
      $(this).click();
    } else {
      $(this).val('');
    }
  })

  $("select", $(this)).val(0);
};

(function ($) {
    'use strict';

    var browserWindow = $(window);

    // :: 1.0 Preloader Active Code
    browserWindow.on('load', function () {
        $('.preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });

    // :: 2.0 Nav Active Code
    if ($.fn.classyNav) {
        $('#appNav').classyNav();
    }

    // :: 3.0 Sliders Active Code
    if ($.fn.owlCarousel) {
        var welcomeSlide = $('.hero-post-slides');
        var instaSlides = $('.instagram-slides');

        welcomeSlide.owlCarousel({
            items: 5,
            margin: 20,
            loop: true,
            nav: false,
            dots: false,
            autoplay: true,
            center: true,
            autoplayTimeout: 7000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1200: {
                    items: 5
                }
            }
        });

        instaSlides.owlCarousel({
            items: 6,
            margin: 10,
            loop: true,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 600,
            responsive: {
                0: {
                    items: 2
                },
                480: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 6
                }
            }
        });
    }

    // :: 4.0 ScrollUp Active Code
    if ($.fn.scrollUp) {
        browserWindow.scrollUp({
            scrollSpeed: 1500,
            scrollText: '<i class="fa fa-angle-up"></i>'
        });
    }

    // :: 5.0 CounterUp Active Code
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    }

    // :: 6.0 Sticky Active Code
    if ($.fn.sticky) {
        $(".app-main-menu").sticky({
            topSpacing: 0
        });
    }

    // :: 7.0 Tooltip Active Code
    if ($.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip()
    }

    // :: 8.0 niceScroll Active Code
    if ($.fn.niceScroll) {
        $(".album-all-songs").niceScroll({
            background: "#fff"
        });
    }

    // :: 9.0 ScrollDown Active Code
    $("#scrollDown").on('click', function () {
        $('html, body').animate({
            scrollTop: $("#about").offset().top - 85
        }, 1500);
    });

    // :: 10.0 prevent default a click
    $('a[href="#"]').on('click', function ($) {
        $.preventDefault();
    });

    // :: 11.0 wow Active Code
    if (browserWindow.width() > 767) {
        new WOW().init();
    }

})(jQuery);
