@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert"">
        <span aria-hidden=" true">&times;</span>
        </button>
        <strong>{{ Session::get('success') }}</strong>
        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert"">
        <span aria-hidden=" true">&times;</span>
        </button>
        <strong>{{ Session::get('error') }}</strong>
        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert"">
        <span aria-hidden=" true">&times;</span>
        </button>
        <strong>{{ Session::get('warning') }}</strong>
        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert"">
        <span aria-hidden=" true">&times;</span>
        </button>
        <strong>{{ Session::get('info') }}</strong>
        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">

        Please check the form below for errors
        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
