import React, { useEffect, useState } from "react";
import { ServerContext } from "@/state/server";
import TitledGreyBox from "@/components/elements/TitledGreyBox";
import reinstallServer from "@/api/server/reinstallServer";
import { Actions, useStoreActions } from "easy-peasy";
import { ApplicationStore } from "@/state";
import { httpErrorToHuman } from "@/api/http";
import tw from "twin.macro";
import { Button } from "@/components/elements/button/index";
import { Dialog } from "@/components/elements/dialog";
import { useTranslation } from "react-i18next";

export default () => {
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const [modalVisible, setModalVisible] = useState(false);
    const { addFlash, clearFlashes } = useStoreActions((actions: Actions<ApplicationStore>) => actions.flashes);
    const { t } = useTranslation("server");

    const reinstall = () => {
        clearFlashes("settings");
        reinstallServer(uuid)
            .then(() => {
                addFlash({
                    key: "settings",
                    type: "success",
                    message: "Your server has begun the reinstallation process.",
                });
            })
            .catch((error) => {
                console.error(error);

                addFlash({ key: "settings", type: "error", message: httpErrorToHuman(error) });
            })
            .then(() => setModalVisible(false));
    };

    useEffect(() => {
        clearFlashes();
    }, []);

    return (
        <TitledGreyBox title={t("reinstall_server")} css={tw`relative`}>
            <Dialog.Confirm
                open={modalVisible}
                title={t("reinstall_server_confirm")}
                confirm={t("yes_reinstall_server")}
                onClose={() => setModalVisible(false)}
                onConfirmed={reinstall}
            >
                {t("reinstall_server_desc")}
            </Dialog.Confirm>
            <p css={tw`text-sm`}>
                Reinstalling your server will stop it, and then re-run the installation script that initially set it
                up.&nbsp;
                <strong css={tw`font-medium`}>
                    Some files may be deleted or modified during this process, please back up your data before
                    continuing.
                </strong>
            </p>
            <div css={tw`mt-6 text-right`}>
                <Button.Danger variant={Button.Variants.Secondary} onClick={() => setModalVisible(true)}>
                    {t("reinstall_server")}
                </Button.Danger>
            </div>
        </TitledGreyBox>
    );
};