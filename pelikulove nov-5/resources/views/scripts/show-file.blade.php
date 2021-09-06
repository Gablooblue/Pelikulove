<script type="text/javascript">


$('#showModal').on('show.bs.modal', function (e) {
	
    var loadurl = $(e.relatedTarget).data('load-url');
    var title = $(e.relatedTarget).data('title');
    $(this).find('.modal-body').load(loadurl);
    $(this).find('.modal-title').text(title);
    
});


 </script>

