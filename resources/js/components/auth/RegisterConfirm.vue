<template>
    <div class="tab-pane container active" id="verification">

        <!-- <span class="success-response text-success">{{(session()->get('flash_success'))}}</span> -->
        <p id="verify_modal_text" class="">
            Un e-mail doit avoir été envoyé à votre adresse à <strong>{{user.email}}</strong>
            Il contient des instructions simples pour terminer votre inscription.
            Si vous continuez à rencontrer des difficultés, contactez l'administrateur du site

        </p>
        <div class="contact-info mb-2 mx-auto w-50 py-4">
            <div id="verify_btn" class="nws-button text-center white">

            </div>
        </div>

    </div>
</template>

<script>
export default {
    props : ['user'],
    data(){
        return {

        }
    }

}
</script>
