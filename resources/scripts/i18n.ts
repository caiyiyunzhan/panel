import i18n from "i18next";
import { initReactI18next } from "react-i18next";
import I18NextHttpBackend, { HttpBackendOptions } from "i18next-http-backend";
import I18NextMultiloadBackendAdapter from "i18next-multiload-backend-adapter";

// If we are using HMR use a unique hash per page reload so that we are always
// doing cache busting. Otherwise just use the builder provided hash value in
// the URL to allow cache busting to occur whenever the front-end is rebuilt.
const hash = module.hot ? Date.now().toString(16) : process.env.WEBPACK_BUILD_HASH;

i18n.use(I18NextMultiloadBackendAdapter)
    .use(initReactI18next)
    .init({
        debug: true,
        lng: "zh",
        fallbackLng: "zh",
        supportedLngs: ["zh", "en"],
        nonExplicitSupportedLngs: true,
        load: "languageOnly",
        keySeparator: ".",
        backend: {
            backend: I18NextHttpBackend,
            backendOption: {
                loadPath: "/locales/locale.json?locale={{lng}}&namespace={{ns}}",
                queryStringParams: { hash },
                allowMultiLoading: true,
            } as HttpBackendOptions,
        } as Record<string, any>,
        interpolation: {
            // Per i18n-react documentation: this is not needed since React is already
            // handling escapes for us.
            escapeValue: false,
        },
    });

// Force Chinese language on initialization
i18n.on("initialized", () => {
    if (i18n.language !== "zh") {
        console.warn("[i18n] Language is not zh, it is:", i18n.language, ". Forcing to zh...");
        i18n.changeLanguage("zh");
    }
    console.log("[i18n] Initialized with language:", i18n.language, "| languages:", i18n.languages);
});

// Also listen for language changes
i18n.on("languageChanged", (lng) => {
    console.log("[i18n] Language changed to:", lng);
});

export default i18n;