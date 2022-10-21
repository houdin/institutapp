import { defineRule } from "vee-validate";
import {
    email,
    required,
    min,
    max,
    alpha_spaces,
    regex,
    between,
} from "@vee-validate/rules";

defineRule("min", min);
defineRule("max", max);
defineRule("alpha_spaces", alpha_spaces);
defineRule("regex", regex);

defineRule("required", (value) => {
    if (required(value)) {
        return true;
    }

    return "This field is required";
});

defineRule("email", (value) => {
    if (email(value) && required(value)) {
        return true;
    }

    return "A valid email address is required";
});

defineRule("password", (value) => {
    if (
        required(value) &&
        min(value, { length: 4 }) &&
        max(value, { length: 30 })
    ) {
        return true;
    }

    return "Password must be between 6 and 30 characters";
});

defineRule("confirmed", (value, [target], ctx) => {
    if (required(value) && value === ctx.form[target]) {
        return true;
    }

    return "Passwords must match";
});

defineRule("name", (value) => {
    return max(value, { length: 60 })
        ? true
        : "Name may not exceed 60 characters";
});

defineRule("minLength", (value, [limit]) => {
    // The field is empty so it should pass
    if (!value || !value.length) {
        return true;
    }

    if (value.length < limit) {
        return `This field must be at least ${limit} characters`;
    }

    return true;
});

// use regex patter for URL
defineRule("url", (value) => {
    const pattern = new RegExp(
        "^(https?:\\/\\/)" + // protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // domain name
            "((\\d{1,3}\\.){3}\\d{1,3}))" + // OR ip (v4) address
            "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // port and path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
            "(\\#[-a-z\\d_]*)?$",
        "i"
    );

    return pattern.test(value) || value.length === 0
        ? true
        : "Website must be a valid URL";
});
