@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])

@section('content')
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="{{ asset('css/categorias.css') }}">

<script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/categorias.js') }}"></script>

<div class="content">
    <div class="container">

        <div class="kpx_login">

            <div class="row kpx_row-sm-offset-3 kpx_socialButtons">
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-facebook" data-toggle="tooltip" data-placement="top" title="Facebook">
                        <i class="fa fa-facebook fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-twitter" data-toggle="tooltip" data-placement="top" title="Twitter">
                        <i class="fa fa-twitter fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-google-plus" data-toggle="tooltip" data-placement="top" title="Google Plus">
                        <i class="fa fa-google-plus fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-google-plus" data-toggle="tooltip" data-placement="top" title="Google Plus">
                        <i class="fa fa-google-plus fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
            </div><br>

            <div class="row kpx_row-sm-offset-3 kpx_socialButtons">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Header</div>
                    <div class="card-body">
                        <h5 class="card-title">Primary card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>

            </div><br>

            <div class="row kpx_row-sm-offset-3 kpx_socialButtons">
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-github" data-toggle="tooltip" data-placement="top" title="GitHub">
                        <i class="fa fa-github fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-soundcloud" data-toggle="tooltip" data-placement="top" title="SoundCloud">
                        <i class="fa fa-soundcloud fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-steam" data-toggle="tooltip" data-placement="top" title="Steam">
                        <i class="fa fa-steam fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
            </div><br>
            <div class="row kpx_row-sm-offset-3 kpx_socialButtons">
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-pinterest" data-toggle="tooltip" data-placement="top" title="Pinterest">
                        <i class="fa fa-pinterest fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-vimeo" data-toggle="tooltip" data-placement="top" title="Vimeo">
                        <i class="fa fa-vimeo-square fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-lastfm" data-toggle="tooltip" data-placement="top" title="Lastfm">
                        <i class="fa fa-lastfm fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
            </div><br>
            <div class="row kpx_row-sm-offset-3 kpx_socialButtons">
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-yahoo" data-toggle="tooltip" data-placement="top" title="Yahoo">
                        <i class="fa fa-yahoo fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-vk" data-toggle="tooltip" data-placement="top" title="VKontakte">
                        <i class="fa fa-vk fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-spotify" data-toggle="tooltip" data-placement="top" title="Spotify">
                        <i class="fa fa-spotify fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
            </div><br>
            <div class="row kpx_row-sm-offset-3 kpx_socialButtons">
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-linkedin" data-toggle="tooltip" data-placement="top" title="LinkedIn">
                        <i class="fa fa-linkedin fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-stumbleupon" data-toggle="tooltip" data-placement="top" title="Stumble Upon">
                        <i class="fa fa-stumbleupon fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block kpx_btn-tumblr" data-toggle="tooltip" data-placement="top" title="Tumblr">
                        <i class="fa fa-tumblr fa-2x"></i>
                        <span class="hidden-xs"></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script type="text/javascript">
</script>
@endsection