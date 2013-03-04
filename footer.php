
      <div class='row span6'>

      </div>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown', function (e) {
    window.location.hash = e.target.hash;
})

    $(document).ready(function(){
    $(".nav-list").children().each(function(){
        var listItem = $(this);
        $(this).children("a").each(function(){
            var link = $(this).attr("href");
            if (document.location.href.indexOf(link) != -1)
                {
                    $(listItem).addClass("active");
                }
        });
     
    });
    });

</script>
