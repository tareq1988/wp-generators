<?php include 'header.php'; ?>

<div class="container">

    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4" style="margin-bottom: 50px; text-align: center;">
            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#videoModal" data-theVideo="http://www.youtube.com/embed/HrFViVnGY68"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> Watch Video Demo</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="caption">
                    <h3><small>Step 1:</small> Admin Menu Page</h3>
                    <p>Generate admin menu with registering menu page and handler class</p>
                    <p><a href="admin-menu-page.php" class="btn btn-primary" role="button">Generate</a></p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="caption">
                    <h3><small>Step 2:</small> WP List Table</h3>
                    <p>Generate WP List Table with class, getter functions and list table view</p>
                    <p><a href="list-table.php" class="btn btn-primary" role="button">Generate</a></p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="caption">
                    <h3><small>Step 3:</small> Form Table</h3>
                    <p>Generate Add and Edit form. Get the form handler code, as well as data insert function.</p>
                    <p><a href="form.php" class="btn btn-primary" role="button">Generate</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src=""></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
    function autoPlayYouTubeModal(){
        var trigger = $("body").find('[data-toggle="modal"]');

        trigger.click(function() {
            var theModal = $(this).data( "target" ),

            videoSRC = $(this).attr( "data-theVideo" ),
            videoSRCauto = videoSRC+"?autoplay=1" ;

            $(theModal+' iframe').attr('src', videoSRCauto);
            $(theModal+' button.close').click(function () {
                $(theModal+' iframe').attr('src', videoSRC);
            });
        });
    }

    jQuery(document).ready(function($){
        autoPlayYouTubeModal();

        $('#videoModal').on('hidden.bs.modal', function (e) {
            $(this).find('iframe').attr('src', '');
        })
    });
</script>