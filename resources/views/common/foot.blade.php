<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#report_user').autocomplete({
            source: '{{ url("patients/autocomplete") }}',
            minLength: 2,
            select: function(event, ui) {
                $("#report_user").val(ui.item.label);
                $("#user_id").val(ui.item.desc);
                return false;
            },
            _renderItem: function( ul, item ) {
                return $("<li>").append( item.label + '(' + item.value + ')' ).appendTo( ul );
            }
        });
    });
</script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}