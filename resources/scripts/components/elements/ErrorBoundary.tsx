import React from "react";
import tw from "twin.macro";
import Icon from "@/components/elements/Icon";
import { faExclamationTriangle } from "@fortawesome/free-solid-svg-icons";
import { useTranslation } from "react-i18next";

interface State {
    hasError: boolean;
}

class ErrorBoundaryInner extends React.Component<{ t: (key: string) => string }, State> {
    state: State = {
        hasError: false,
    };

    static getDerivedStateFromError() {
        return { hasError: true };
    }

    componentDidCatch(error: Error) {
        console.error(error);
    }

    render() {
        const { t } = this.props;

        return this.state.hasError ? (
            <div css={tw`flex items-center justify-center w-full my-4`}>
                <div css={tw`flex items-center bg-neutral-900 rounded p-3 text-red-500`}>
                    <Icon icon={faExclamationTriangle} css={tw`h-4 w-auto mr-2`} />
                    <p css={tw`text-sm text-neutral-100`}>
                        {t("app_error")}
                    </p>
                </div>
            </div>
        ) : (
            this.props.children
        );
    }
}

const ErrorBoundary: React.FC = (props) => {
    const { t } = useTranslation("strings");
    return <ErrorBoundaryInner t={t} {...props} />;
};

export default ErrorBoundary;
