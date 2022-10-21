export default [
    {
        name: "login",
        path: "/connexion",
        components: {
            loginview: require("../../../components/auth/Login").default,
        },
    },
    {
        name: "register",
        path: "/inscription",

        components: {
            registerview: require("../../../components/auth/Register").default,
        },
    },
    {
        name: "teacher.register",
        path: "/teacher/register",

        components: {
            authview: require("../../../components/auth/RegisterTeacherNone")
                .default,
        },
    },
    {
        name: "verification.tab",
        path: "/auth-verification",
        components: {
            authview: require("../../../components/auth/Verification").default,
        },
    },
    {
        name: "register.confirm",
        path: "/account/confirm/:token",
        components: {
            authview: require("../../../components/auth/RegisterConfirm")
                .default,
        },
    },
    {
        name: "register.confirm.resend",
        path: "/account/confirm/resend/:uuid",
        components: {
            authview: require("../../../components/auth/RegisterConfirm")
                .default,
        },
    },
    {
        name: "password.reset",
        path: "/password/reset",
        components: {
            authview: require("../../../components/auth/PasswordReset").default,
        },
    },
];
