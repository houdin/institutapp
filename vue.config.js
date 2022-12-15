module.exports = {
    configureWebpack: (config) => {
        if (import.meta.env.NODE_ENV === "production") {
            // mutate config for production...
        } else {
            // mutate for development...
        }
    },
};
