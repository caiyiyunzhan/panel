import i18n from "i18next";
import { initReactI18next } from "react-i18next";
import I18NextHttpBackend, { HttpBackendOptions } from "i18next-http-backend";
import I18NextMultiloadBackendAdapter from "i18next-multiload-backend-adapter";

const hash = module.hot ? Date.now().toString(16) : process.env.WEBPACK_BUILD_HASH;

// Grab preloaded translations embedded by the server
const preloaded = (typeof window !== "undefined" && window.__PRELOADED_TRANSLATIONS) || {};
console.log("[i18n] Preloaded translations:", Object.keys(preloaded.zh || {}));

function initI18n() {
    if (typeof window !== "undefined") {
        try {
            localStorage.setItem("i18nextLng", "zh");
        } catch (e) {}
    }

    return i18n
        .use(I18NextMultiloadBackendAdapter)
        .use(initReactI18next)
        .init({
            debug: true,
            lng: "zh",
            fallbackLng: "zh",
            supportedLngs: ["zh", "en"],
            nonExplicitSupportedLngs: true,
            load: "languageOnly",
            // Preloaded translations from server-side embedding
            resources: preloaded,
            ns: [
                "auth",
                "strings",
                "admin",
                "server",
                "dashboard",
                "pagination",
                "passwords",
                "validation",
                "activity",
                "exceptions",
            ],
            defaultNS: "strings",
            preload: ["zh"],
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
                escapeValue: false,
            },
        });
}

const i18nInstance = initI18n();

i18nInstance.then(() => {
    console.log("[i18n] Initialized. Language:", i18n.language);
    console.log("[i18n] Languages:", i18n.languages);
    
    if (i18n.language !== "zh") {
        console.warn("[i18n] WARNING: language is not zh, it is:", i18n.language);
        console.warn("[i18n] Forcing change to zh...");
        i18n.changeLanguage("zh");
    }
    
    i18n.on("languageChanged", (lng) => {
        console.log("[i18n] Language changed to:", lng);
    });
});

i18n.on("loaded", (loaded) => {
    console.log("[i18n] Loaded event:", loaded);
});

export default i18n;