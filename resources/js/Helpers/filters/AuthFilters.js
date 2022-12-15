const auth_get = async (url) => {
    if (Laravel.app.user) {
        try {
            const res = await axios.get(url);
            if (res.status == 200 && res.data !== false) {
                return res.data;
            }
        } catch (error) {}
    }
    return false;
};

const auth_post = async (url, value) => {
    if (Laravel.app.user) {
        try {
            const res = await axios.post(url, value);
            if (res.status == 200 && res.data !== false) {
                return res.data;
            }
        } catch (error) {}
    }

    return false;
};

const Auth = {
    check: async function check() {
        const check = await auth_get("/user/users-check");

        return check !== false ? check.check : false;
    },
    can: async function can(permission, model, id) {
        const can = await auth_get(`/${permission}/${model}/${id}`);

        return check !== false ? check.check : false;
    },
    user: async function user() {
        const user = await auth_get("/user/users-details");

        return user !== false ? user : false;
    },
    hasrole: async function hasrole(value, error = null) {
        let url = "/user/users-role/" + value;
        url = error === null ? url : url + "/1";
        const role = await auth_get(url);

        return role !== false ? role.role : false;
    },

    haspermission: async function haspermission(value, error = null) {
        let url = "/user/users-permission/" + value;
        url = error === null ? url : url + "/1";
        const permission = await auth_get(url);

        return permission !== false ? permission.permission : false;
    },

    admin_permission: async function admin_permission(error = null) {
        return await this.haspermission(
            "7b547a711d0b9fb93968b5b8d81dc86d",
            error
        );
    },
    admin_role: async function admin_role(error = null) {
        return await this.hasrole("200ceb26807d6bf99fd6f4f0d1ca54d4", error);
    },
    student_role: async function admin_role(error = null) {
        return await this.hasrole("cd73502828457d15655bbd7a63fb0bc8", error);
    },
};

export default Auth;
