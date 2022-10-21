<div id="cookieWrapper" class="bg-black-0 text-white w-100 py-3 text-center">
    <div class="js-cookie-consent d-inline  cookie-consent">

    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
    </span>

        <button onclick="$('#cookieWrapper').remove()"
                class="js-cookie-consent-agree text-dark btn btn-light cookie-consent__agree">
            {{ trans('cookieConsent::texts.agree') }}
        </button>
    </div>
</div>
