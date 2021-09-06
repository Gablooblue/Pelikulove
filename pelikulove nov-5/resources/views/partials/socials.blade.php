<div class="row">
    <div class="col-sm-12 mb-2">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'facebook']), 'fab fa-facebook-f', 'Facebook', array('class' => 'btn btn-block btn-social btn-facebook')) !!}
    </div>
    <div class="col-sm-12 mb-2">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'google']), 'fab fa-google-plus-g', 'Google +', array('class' => 'btn btn-block btn-social btn-google')) !!}
    </div>
</div>
