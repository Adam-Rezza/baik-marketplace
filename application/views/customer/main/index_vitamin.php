<style>
.slide-product > .owl-nav{
    display: none !important;
}
</style>
<script>
    $(document).ready(function() {
        $('.slide-product').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2500,
            autoplayHoverPause: true,
            responsive: {
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                760: {
                    items: 1
                }
            }
        });
    });
</script>