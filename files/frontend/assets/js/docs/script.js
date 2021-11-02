(function($) {
    "use strict";


    /*----------------------------
        Jquery Live Search
        ------------------------------*/
    $('#searchinput').on('keyup', function() {
        $('.header-search-list').removeClass('d-none');
        search_table($(this).val());
    });

    function search_table(value) {
        $('.header-search-list ul li').each(function() {
            var found = 'false';
            $(this).each(function() {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                    found = true;
                }
            });
            if (found == true) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('html').on('click', function(e) {
        $('.header-search-list').addClass('d-none');
    });

     //navbar mobile menu
     var $main_nav = $('#main-nav');
     var $toggle = $('.toggle');

     var defaultOptions = {
       disableAt: false,
       customToggle: $toggle,
       levelSpacing: 40,
       navTitle: 'Menu',
       levelTitles: true,
       levelTitleAsBack: true,
       pushContent: '#container',
       insertClose: 2
     };

     // call our plugin
     var Nav = $main_nav.hcOffcanvasNav(defaultOptions);

     // add new items to original nav
     $main_nav.find('li.add').children('a').on('click', function() {
       var $this = $(this);
       var $li = $this.parent();
       var items = eval('(' + $this.attr('data-add') + ')');

       $li.before('<li class="new"><a href="#">'+items[0]+'</a></li>');

       items.shift();

       if (!items.length) {
         $li.remove();
       }
       else {
         $this.attr('data-add', JSON.stringify(items));
       }

       Nav.update(true);
     });

     // demo settings update

     const update = (settings) => {
       if (Nav.isOpen()) {
         Nav.on('close.once', function() {
           Nav.update(settings);
           Nav.open();
         });

         Nav.close();
       }
       else {
         Nav.update(settings);
       }
     };

     $('.actions').find('a').on('click', function(e) {
       e.preventDefault();

       var $this = $(this).addClass('active');
       var $siblings = $this.parent().siblings().children('a').removeClass('active');
       var settings = eval('(' + $this.data('demo') + ')');

       update(settings);
     });

     $('.actions').find('input').on('change', function() {
       var $this = $(this);
       var settings = eval('(' + $this.data('demo') + ')');

       if ($this.is(':checked')) {
         update(settings);
       }
       else {
         var removeData = {};
         $.each(settings, function(index, value) {
           removeData[index] = false;
         });

         update(removeData);
       }
     });

})(jQuery);
