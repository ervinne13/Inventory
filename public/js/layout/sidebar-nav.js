
(function () {

    $(function () {

        setCurrentNavItemActive();
    });

    function findCurrentNavItem() {
        var currentNavItem = null;
        var currentHref = location.href;
        $('.auto-select-sidebar-nav li a').each(function () {

            //  "" + to make sure this is a string
            var linkHref = "" + $(this).attr('href');

            if (currentHref.startsWith(linkHref)) {
                currentNavItem = $(this);
            }

        });

        return currentNavItem;
    }

    function resetNavItemsActiveStatus() {

        $('.auto-select-sidebar-nav li').removeClass('active');
//        $('.auto-select-sidebar-nav li ul li').removeClass('active');

    }

    function setCurrentNavItemActive() {

        resetNavItemsActiveStatus();

        var $currentNavItem = findCurrentNavItem();
        if ($currentNavItem) {

            var $linkContainer = $currentNavItem.parent('li');
            var $navItemParent = $linkContainer.parent('ul').parent('li');
            var $navToggle;

            var loopCount = 0;
            var limit = 10; //  failsafe with loopcount & limit

            $linkContainer.addClass('active');

            do {
                $navItemParent.addClass('active');
                $navItemParent.addClass('expanded');

                loopCount++;
            } while ($navItemParent && loopCount < limit);

        }

    }

})();
