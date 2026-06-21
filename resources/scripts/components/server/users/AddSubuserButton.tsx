import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import Can from "@/components/elements/Can";
import { Button } from "@/components/elements/button/index";
import EditSubuserModal from "@/components/server/users/EditSubuserModal";

export default () => {
    const { t } = useTranslation("server");
    const [visible, setVisible] = useState(false);

    return (
        <Can action={"user.create"}>
            <EditSubuserModal visible={visible} onModalDismissed={() => setVisible(false)} />
            <Button onClick={() => setVisible(true)}>
                {t("invite_user")}
            </Button>
        </Can>
    );
};