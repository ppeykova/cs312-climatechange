<?php
require ('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<script>
    $('.googleMapPopUp').each(function() {
        var thisPopup = $(this);
        thisPopup.colorbox({
            iframe: true,
            innerWidth: 400,
            innerHeight: 300,
            opacity: 0.7,
            href: thisPopup.attr('href') + '&ie=UTF8&t=h&output=embed'
        });
    });
</script>

<a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q=south+australia" target="_blank">View location map </a>

</body>
</html>
