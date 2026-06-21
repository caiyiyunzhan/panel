import React, { useState } from "react";
import { RouteComponentProps } from "react-router";
import { Link } from "react-router-dom";
import performPasswordReset from "@/api/auth/performPasswordReset";
import { httpErrorToHuman } from "@/api/http";
import LoginFormContainer from "@/components/auth/LoginFormContainer";
import { Actions, useStoreActions } from "easy-peasy";
import { ApplicationStore } from "@/state";
import { Formik, FormikHelpers } from "formik";
import { object, ref, string } from "yup";
import Field from "@/components/elements/Field";
import Input from "@/components/elements/Input";
import tw from "twin.macro";
import Button from "@/components/elements/Button";
import { useTranslation } from "react-i18next";

interface Values {
    password: string;
    passwordConfirmation: string;
}

export default ({ match, location }: RouteComponentProps<{ token: string }>) => {
    const [email, setEmail] = useState("");

    const { clearFlashes, addFlash } = useStoreActions((actions: Actions<ApplicationStore>) => actions.flashes);
    const { t: tAuth } = useTranslation("auth");
    const { t: tStrings } = useTranslation("strings");

    const parsed = new URLSearchParams(location.search);
    if (email.length === 0 && parsed.get("email")) {
        setEmail(parsed.get("email") || "");
    }

    const submit = ({ password, passwordConfirmation }: Values, { setSubmitting }: FormikHelpers<Values>) => {
        clearFlashes();
        performPasswordReset(email, { token: match.params.token, password, passwordConfirmation })
            .then(() => {
                window.location = "/" as any;
            })
            .catch((error) => {
                console.error(error);

                setSubmitting(false);
                addFlash({ type: "error", title: tStrings("error"), message: httpErrorToHuman(error) });
            });
    };

    return (
        <Formik
            onSubmit={submit}
            initialValues={{
                password: "",
                passwordConfirmation: "",
            }}
            validationSchema={object().shape({
                password: string()
                    .required(tAuth("new_password_required"))
                    .min(8, tAuth("password_requirements")),
                passwordConfirmation: string()
                    .required(tAuth("new_password_required"))
                    .oneOf([ref("password"), null], tAuth("new_password_required")),
            })}
        >
            {({ isSubmitting }) => (
                <LoginFormContainer title={tAuth("reset_password_title")} css={tw`w-full flex`}>
                    <div>
                        <label>{tStrings("email")}</label>
                        <Input value={email} isLight disabled />
                    </div>
                    <div css={tw`mt-6`}>
                        <Field
                            light
                            label={tStrings("new_password")}
                            name={"password"}
                            type={"password"}
                            description={tAuth("password_requirements")}
                        />
                    </div>
                    <div css={tw`mt-6`}>
                        <Field light label={tStrings("confirm_password")} name={"passwordConfirmation"} type={"password"} />
                    </div>
                    <div css={tw`mt-6`}>
                        <Button size={"xlarge"} type={"submit"} disabled={isSubmitting} isLoading={isSubmitting}>
                            {tAuth("reset_and_sign_in")}
                        </Button>
                    </div>
                    <div css={tw`mt-6 text-center`}>
                        <Link
                            to={"/auth/login"}
                            css={tw`text-xs text-neutral-500 tracking-wide no-underline uppercase hover:text-neutral-600`}
                        >
                            {tAuth("return_to_login")}
                        </Link>
                    </div>
                </LoginFormContainer>
            )}
        </Formik>
    );
};
