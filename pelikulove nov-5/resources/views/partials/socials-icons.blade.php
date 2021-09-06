<div class="row">
    <div class="col-12 mb-2 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'facebook']), 'fab fa-facebook-f', '', array('class' => 'btn btn-social-icon btn-lg mb-1 btn-facebook')) !!}
        {!! HTML::icon_link(route('social.redirect',['provider' => 'google']), 'fab fa-google-plus-g', '', array('class' => 'btn btn-social-icon btn-lg mb-1 btn-google')) !!}
	</div>	
</div>
