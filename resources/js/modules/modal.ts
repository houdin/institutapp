import ModalType from "@/types/modalType";

const modal: ModalType = {
    container: null,
    open: function (type = null) {
        if (type === "auth") return this.auth();

        if (type !== null) this.type = type;
        if (type === "search")
            this.class = "px-6 sm:my-8 sm:w-full sm:max-w-2xl sm:px-0";

        if (this.isOpen === false) {
            const body = document.body;
            const modals = document.querySelector("#modals");
            if (!body.classList.contains("modal-open"))
                body.classList.add("modal-open");
            if (modals?.classList.contains("hidden"))
                modals?.classList.remove("hidden");
            setTimeout(() => {
                this.isOpen = true;
                // this.autoCloser();
            }, 50);
        }
    },
    isOpen: false as boolean,
    close: function (val: String | String[] | Boolean = "type") {
        const body = document.body;
        const modals = document.querySelector("#modals");
        if (this.isOpen === true) this.reset(val);
        setTimeout(() => {
            if (this.isOpen === false) {
                if (body.classList.contains("modal-open"))
                    body.classList.remove("modal-open");
                if (!modals?.classList.contains("hidden"))
                    modals?.classList.add("hidden");
                // Inertia.get('back')
                this.type = "";
            }
        }, 100);
    },
    autoCloser: function (form) {
        const Timeout = ref(
            setTimeout(() => {
                modal.close();
                form?.reset();
            }, 60000)
        );

        watch(form, () => {
            clearTimeout(Timeout.value);
            Timeout.value = setTimeout(() => {
                modal.close();
                form?.reset();
            }, 60000);
        });
    },
    switch: async function (val: Boolean) {
        this.isOpen = false;

        await useFilters.Utility.timeOut(200);

        this.isOpen = true;

        return !val;
    },
    type: "",
    class: "px-6 pb-4 sm:my-8 sm:w-full sm:max-w-lg sm:px-10",
    data: {},
    background: true,
    redirect: "",
    auth: function () {
        this.class = "px-6 pb-4 sm:my-8 sm:w-full sm:max-w-lg sm:px-10";
        this.type = "auth";
        this.open();
    },
    reset: function (val: String | String[] | Boolean = true) {
        if (typeof val !== "boolean") {
            // this.redirect = val?.includes('redirect') || val === 'redirect' ? this.redirect : this.redirect = '';
            this.type =
                val?.includes("type") || val === "type"
                    ? this.type
                    : (this.type = "");
            this.data =
                val?.includes("data") || val === "data"
                    ? this.data
                    : (this.data = {});
            this.isOpen =
                val?.includes("isOpen") || val === "isOpen"
                    ? this.isOpen
                    : (this.isOpen = false);
            this.class =
                val?.includes("class") || val === "class"
                    ? this.class
                    : (this.class =
                          "px-6 pb-4 sm:my-8 sm:w-full sm:max-w-lg sm:px-10");
        }
    },
};

export default modal;
