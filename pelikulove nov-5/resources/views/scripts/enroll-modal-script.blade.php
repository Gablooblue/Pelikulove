<script type="text/javascript">
    
        $(document).ready(function(){
                $('body').on('hidden.bs.modal', '.modal', function () {
                         $(this).removeData('bs.modal');
                        $("#" + $(this).attr("id") + " .modal-content").empty();
                        $("#" + $(this).attr("id") + " .modal-content").append("Loading...");
                });
          
        });
 
 </script>

