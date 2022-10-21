import { extend, setInteractionMode } from "vee-validate";
import {
    required,
    email,
    alpha_spaces,
    min,
    confirmed,
    regex,
    between
} from "vee-validate/dist/rules";

setInteractionMode("lazy");

// Override the default message.
extend("required", {
    ...required,
    message: "Veuillez remplir ce champ"
});
// Override the default message.
extend("email", {
    ...email,
    message: `L'email n'est pas valide`
});
// Override the default message.
extend("alpha_spaces", {
    ...alpha_spaces,
    message: `Ce champ n'est pas valide`
});
// Override the default message.
extend("min", {
    ...min,
    message: "Le {_field_} n'est pas valide"
});

extend("confirmed", {
    ...confirmed,
    message: "La confirmation du {_field_} ne correspond pas"
});

extend("regex", regex);

extend("between", between);

extend("unique-email", {
    validate: value => {
        return axios
            .post(window.Laravel.urls.user_email_url, {
                email: value
            })
            .then(function(response) {
                return {
                    valid: response.data["email"]
                };
            })
            .catch(function(error) {
                console.log(error);
            });
    },
    message: "Cette adresse email est déjà enregistrée."
});
