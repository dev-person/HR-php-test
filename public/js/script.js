(function () {

    var icon = new skycons.Skycons({
        "monochrome": false,
        "colors": {
            "main": "white",
            "cloud": "#c1c1c1",
            "moon": "#494960"
        }
    });

    function getIcon(iconName, iconID) {
        var currentIcon = iconName.replace(/-/g, '_').toUpperCase();
        return icon.add(iconID, skycons.Skycons[currentIcon]);
    }

    $('.day-of-week').each(function (index, value) {
        var icon = $(this).data('icon');
        getIcon(icon, $(value).find('canvas').attr('id'))
    });

    icon.play();
})();