<section id="premium" >
    <div class="container">
        <div class="section-title mb20 headline text-left ">

            <h2>@lang('labels.frontend.layouts.partials.view_all_news'){{--Devenir <span>Premium</span>--}}</h2>
            </div>
            <div class="row">
            @foreach ($premiums as $item)
                <div class="col-md-4 col-lg-4 mb-5 mb-lg-0">
                <div class="bg-black-1 p-5 rounded-lg shadow border border-base-0">
                    <h1 class="h6 text-uppercase font-weight-bold mb-4">{{ $item->name }}</h1>
                    <h2 class="h1 font-weight-bold">${{ $item->price }}<span class="text-small font-weight-normal ml-2">/ month</span></h2>
                    <div class="custom-separator my-4 mx-auto bg-base-3"></div>
                    <ul class="list-unstyled my-3 text-small text-left" style="height: 100px;">
                        @foreach (array_slice($item->premiumList(), 0, 2) as $line)
                            <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i>{{ $line }}</li>
                        @endforeach


                        {{-- <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i> 5GB Disk Space</li>
                        <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i> 10 Email Accounts</li>
                        <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i> 5 GB Monthly Bandwidth</li>
                        <li class="mb-3 text-muted"> <i class="fa fa-times mr-2"></i> <del>Unlimited Subdomain</del> </li>
                        <li class="mb-3 text-muted"> <i class="fa fa-times mr-2"></i> <del>Automatic Cloud Backup</del> </li> --}}
                    </ul> <a href="#" class="btn bg-base-3 btn-block color-black-0 p-2 shadow rounded-pill">@lang('labels.frontend.layouts.partials.view_all_news'){{--Voir le detail...--}}</a>
                </div>
            </div>
            @endforeach
        </div>


    </div>

</section>
